<?php

namespace App\Services;

use App\Models\Restaurant;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class DeepSeekMenuAssistantService
{
    /**
     * @param  Collection<int, array{id:int,name:string,description:?string,price:string,discount_price:?string,display_price:string,category:string,image:?string,availability:bool}>  $products
     * @param  array<string, mixed>  $contactInfo
     * @return array{reply:string,recommended_product_ids:array<int>,needs_more_info:bool,follow_up_question:?string}
     */
    public function ask(Restaurant $restaurant, Collection $products, string $question, array $contactInfo = []): array
    {
        $apiKey = (string) config('services.deepseek.key');

        if ($apiKey === '') {
            throw new RuntimeException('DeepSeek API key is missing.');
        }

        $baseUrl = rtrim((string) config('services.deepseek.base_url', 'https://api.deepseek.com'), '/');
        $model = (string) config('services.deepseek.model', 'deepseek-chat');

        try {
            $response = Http::withToken($apiKey)
                ->acceptJson()
                ->connectTimeout(4)
                ->timeout(12)
                ->post($baseUrl.'/chat/completions', [
                    'model' => $model,
                    'response_format' => ['type' => 'json_object'],
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $this->systemPrompt($restaurant),
                        ],
                        [
                            'role' => 'user',
                            'content' => json_encode([
                                'question' => $question,
                                'official_contact_info' => $contactInfo,
                                'menu_products' => $products->values()->all(),
                                'required_json_shape' => [
                                    'reply' => 'رد قصير للعميل',
                                    'recommended_product_ids' => [1, 2],
                                    'needs_more_info' => false,
                                    'follow_up_question' => null,
                                ],
                            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                        ],
                    ],
                ]);
        } catch (ConnectionException $exception) {
            Log::warning('DeepSeek menu assistant request failed.', [
                'restaurant_id' => $restaurant->id,
                'reason' => $exception->getMessage(),
            ]);

            throw new RuntimeException('DeepSeek request failed.', previous: $exception);
        }

        if ($response->failed()) {
            Log::warning('DeepSeek menu assistant returned an error.', [
                'restaurant_id' => $restaurant->id,
                'reason' => 'HTTP '.$response->status(),
            ]);

            throw new RuntimeException('DeepSeek returned HTTP '.$response->status().'.');
        }

        $content = data_get($response->json(), 'choices.0.message.content');
        $decoded = is_string($content) ? json_decode($content, true) : null;

        if (! is_array($decoded)) {
            Log::warning('DeepSeek menu assistant returned invalid JSON.', [
                'restaurant_id' => $restaurant->id,
                'reason' => 'invalid_json',
            ]);

            throw new RuntimeException('DeepSeek returned invalid JSON.');
        }

        $allowedIds = $products->pluck('id')->map(fn ($id) => (int) $id)->all();
        $recommendedIds = collect($decoded['recommended_product_ids'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->filter(fn (int $id) => in_array($id, $allowedIds, true))
            ->unique()
            ->values()
            ->all();

        return [
            'reply' => trim((string) ($decoded['reply'] ?? 'مش قادر أحدد ترشيح مناسب دلوقتي.')),
            'recommended_product_ids' => $recommendedIds,
            'needs_more_info' => (bool) ($decoded['needs_more_info'] ?? false),
            'follow_up_question' => filled($decoded['follow_up_question'] ?? null)
                ? (string) $decoded['follow_up_question']
                : null,
        ];
    }

    private function systemPrompt(Restaurant $restaurant): string
    {
        return <<<PROMPT
أنت مساعد منيو ذكي لمطعم/مكان اسمه {$restaurant->name}.
شخصيتك مهذبة ومحترمة وخفيفة الظل بدون مبالغة.
اتكلم مع العميل كأنك بتساعده يختار براحة، مش كأنك بتقرأ قائمة جامدة.
استخدم اللهجة المصرية الطبيعية: "تمام"، "بص"، "أرشحلك"، "يناسبك"، لكن بدون هزار زيادة أو ألفاظ غير مهنية.
لو العميل فتح كلام عام أو محتاج مساعدة، رد عليه بود واسأله سؤال بسيط يوصلك لاختيار مناسب.
جاوب فقط من المنتجات الموجودة في المنيو المرسل لك.
ممنوع اختراع منتجات.
ممنوع اختراع أسعار.
ممنوع ترشيح منتج غير موجود.
ممنوع ترشيح منتج غير متاح.
لو العميل سأل عن حاجة غير موجودة، اعتذر باختصار واقترح أقرب بدائل من المنيو.
لو السؤال مش واضح، اسأل سؤال واحد قصير.
الرد باللهجة المصرية المهذبة.
الرد مختصر ومناسب للموبايل، لكن خلي فيه روح ولطف.
لا تذكر أنك AI.
لا تقدم وعود خصومات أو توفر غير موجود.
لا تتكلم عن أي متجر آخر.
رجّع JSON فقط بالشكل ده:
{"reply":"رد قصير للعميل","recommended_product_ids":[1,2],"needs_more_info":false,"follow_up_question":null}
If the customer asks for phone numbers, WhatsApp, address, branches, or location, answer only from official_contact_info. Do not guess contact details. If the requested contact detail is missing, say it is not available.
PROMPT;
    }
}
