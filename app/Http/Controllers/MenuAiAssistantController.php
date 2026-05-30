<?php

namespace App\Http\Controllers;

use App\Models\MenuSetting;
use App\Services\DeepSeekMenuAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuAiAssistantController extends Controller
{
    public function __invoke(Request $request, string $slug, DeepSeekMenuAssistantService $assistant): JsonResponse
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:500'],
        ]);

        $menuSetting = MenuSetting::query()
            ->with('restaurant')
            ->where('slug', $slug)
            ->where('is_public', true)
            ->whereHas('restaurant', fn ($query) => $query
                ->where('subscription_status', 'active')
                ->where(fn ($sub) => $sub->whereNull('subscription_ends_at')->orWhere('subscription_ends_at', '>', now())))
            ->firstOrFail();

        $restaurant = $menuSetting->restaurant;
        $contactInfo = $this->contactInfo($restaurant, $menuSetting->theme);

        if ($contactAnswer = $this->contactAnswer((string) $validated['question'], $contactInfo)) {
            return response()->json([
                'ok' => true,
                'reply' => $contactAnswer,
                'recommended_product_ids' => [],
                'recommended_products' => [],
                'needs_more_info' => false,
                'follow_up_question' => null,
            ]);
        }

        $products = $restaurant->products()
            ->where('is_available', true)
            ->whereHas('category', fn ($query) => $query
                ->where('restaurant_id', $restaurant->id)
                ->where('is_active', true))
            ->with('category:id,restaurant_id,name_ar,name_en')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn ($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => (string) $product->price,
                'discount_price' => $product->hasDiscount() ? (string) $product->discount_price : null,
                'display_price' => $product->displayPrice(),
                'category' => $product->category?->name_ar ?: $product->category?->name_en ?: '',
                'image' => $product->image_path ? asset('storage/'.$product->image_path) : null,
                'availability' => (bool) $product->is_available,
            ]);

        try {
            $answer = $assistant->ask($restaurant, $products, (string) $validated['question'], $contactInfo);
        } catch (\Throwable) {
            $fallbackProducts = $this->fallbackRecommendations($products, (string) $validated['question']);

            return response()->json([
                'ok' => true,
                'reply' => $fallbackProducts->isNotEmpty()
                    ? 'تمام، دي أقرب اختيارات لطلبك من الموجود عندنا. شوف كده تحب أنهي واحد؟'
                    : 'مش لاقي اختيار واضح بنفس الوصف، بس ولا يهمك. تحب أدوّرلك على حاجة بسعر أقل ولا من قسم معين؟',
                'recommended_product_ids' => $fallbackProducts->pluck('id')->values()->all(),
                'recommended_products' => $fallbackProducts
                    ->map(fn ($product) => [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $product['display_price'],
                        'original_price' => $product['price'],
                        'discount_price' => $product['discount_price'],
                        'image' => $product['image'],
                        'category' => $product['category'],
                    ])
                    ->values()
                    ->all(),
                'needs_more_info' => $fallbackProducts->isEmpty(),
                'follow_up_question' => $fallbackProducts->isEmpty() ? 'تحب اختيار بسعر أقل ولا من قسم معين؟' : null,
            ]);
        }

        $recommendedProducts = $products
            ->whereIn('id', $answer['recommended_product_ids'])
            ->values()
            ->map(fn ($product) => [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['display_price'],
                'original_price' => $product['price'],
                'discount_price' => $product['discount_price'],
                'image' => $product['image'],
                'category' => $product['category'],
            ])
            ->all();

        return response()->json([
            'ok' => true,
            'reply' => $answer['reply'],
            'recommended_product_ids' => $answer['recommended_product_ids'],
            'recommended_products' => $recommendedProducts,
            'needs_more_info' => $answer['needs_more_info'],
            'follow_up_question' => $answer['follow_up_question'],
        ]);
    }

    private function fallbackRecommendations($products, string $question)
    {
        $normalizedQuestion = str($question)->lower()->toString();

        $matches = $products
            ->map(function (array $product) use ($normalizedQuestion) {
                $haystack = str($product['name'].' '.$product['description'].' '.$product['category'])
                    ->lower()
                    ->toString();

                $score = 0;

                foreach (preg_split('/\s+/u', $normalizedQuestion, -1, PREG_SPLIT_NO_EMPTY) ?: [] as $word) {
                    if (mb_strlen($word) >= 3 && str_contains($haystack, $word)) {
                        $score += 2;
                    }
                }

                if (str_contains($normalizedQuestion, 'أرخص') || str_contains($normalizedQuestion, 'رخيص') || str_contains($normalizedQuestion, 'سعر')) {
                    $score += max(0, 3 - ((float) $product['display_price'] / 1000));
                }

                if (str_contains($normalizedQuestion, 'الأكثر') || str_contains($normalizedQuestion, 'افضل') || str_contains($normalizedQuestion, 'أفضل')) {
                    $score += 1;
                }

                return [$product, $score];
            })
            ->filter(fn (array $item) => $item[1] > 0)
            ->sortByDesc(fn (array $item) => $item[1])
            ->map(fn (array $item) => $item[0])
            ->values();

        if ($matches->isEmpty()) {
            $matches = $products->sortBy(fn (array $product) => (float) $product['display_price'])->values();
        }

        return $matches->take(3)->values();
    }

    /**
     * @return array{phone:?string,whatsapp:?string,address:?string,branches:array<int,array{name:string,address:string,map_url:string}>}
     */
    private function contactInfo($restaurant, ?string $theme): array
    {
        $info = [
            'phone' => $restaurant->phone,
            'whatsapp' => null,
            'address' => $restaurant->address,
            'branches' => [],
        ];

        if ($theme === 'paper') {
            $info['phone'] = $info['phone'] ?: '01114620426';
            $info['whatsapp'] = '01142073745';
            $info['branches'] = [
                [
                    'name' => 'الفرع الأول',
                    'address' => 'الجيزة - ساقية مكي - شارع محمود حسين',
                    'map_url' => 'https://maps.app.goo.gl/ZewFF9ovQQRh9Hix6?g_st=ic',
                ],
                [
                    'name' => 'الفرع الثاني',
                    'address' => 'الجيزة - شارع البحر الأعظم - أمام القرية الفرعونية',
                    'map_url' => 'https://maps.app.goo.gl/eFB7jpGQSBzLo8As5?g_st=ic',
                ],
                [
                    'name' => 'الفرع الثالث',
                    'address' => 'مصر الجديدة - شارع عمر بن الخطاب - هليوبوليس - بداخل مول تيفولي دوم',
                    'map_url' => 'https://maps.app.goo.gl/rXNxwoc1vuWAvEiQ8?g_st=ic',
                ],
            ];
        }

        return $info;
    }

    private function contactAnswer(string $question, array $contactInfo): ?string
    {
        $normalizedQuestion = mb_strtolower($question);
        $asksPhone = str($normalizedQuestion)->contains(['رقم', 'تليفون', 'تلفون', 'موبايل', 'فون', 'phone', 'mobile', 'call', 'اتصال']);
        $asksWhatsapp = str($normalizedQuestion)->contains(['واتس', 'واتساب', 'whatsapp']);
        $asksAddress = str($normalizedQuestion)->contains(['عنوان', 'مكان', 'فين', 'فرع', 'فروع', 'لوكيشن', 'location', 'address', 'branch']);

        if (! $asksPhone && ! $asksWhatsapp && ! $asksAddress) {
            return null;
        }

        $parts = [];

        if ($asksPhone && filled($contactInfo['phone'] ?? null)) {
            $parts[] = 'رقم التليفون: '.$contactInfo['phone'];
        }

        if ($asksWhatsapp && filled($contactInfo['whatsapp'] ?? null)) {
            $parts[] = 'واتساب: '.$contactInfo['whatsapp'];
        }

        if ($asksAddress) {
            if (! empty($contactInfo['branches'])) {
                $branchLines = collect($contactInfo['branches'])
                    ->map(fn (array $branch) => $branch['name'].': '.$branch['address'])
                    ->implode('، ');
                $parts[] = 'العناوين: '.$branchLines;
            } elseif (filled($contactInfo['address'] ?? null)) {
                $parts[] = 'العنوان: '.$contactInfo['address'];
            }
        }

        if ($parts === []) {
            return 'مش متوفر عندي رقم أو عنوان مؤكد حاليا.';
        }

        return implode(' - ', $parts);
    }
}
