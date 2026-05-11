<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuSetting;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SipAndChillMenuSeeder extends Seeder
{
    private const TARGET_EMAIL = 'huuhkinn@gmail.com';

    public function run(): void
    {
        $user = User::query()
            ->where('email', self::TARGET_EMAIL)
            ->firstOrFail();

        if ($user->restaurant_id === null) {
            throw new \RuntimeException('User '.self::TARGET_EMAIL.' is not linked to a restaurant.');
        }

        $restaurant = $user->restaurant()->firstOrFail();
        $stats = [
            'categories_created' => 0,
            'categories_updated' => 0,
            'products_created' => 0,
            'products_updated' => 0,
            'duplicate_products_removed' => 0,
        ];

        DB::transaction(function () use ($restaurant, &$stats): void {
            foreach ($this->menuData() as $categoryIndex => $categoryData) {
                $category = Category::query()
                    ->where('restaurant_id', $restaurant->id)
                    ->where('name_ar', $categoryData['name'])
                    ->orderBy('id')
                    ->first();

                $categoryPayload = [
                    'restaurant_id' => $restaurant->id,
                    'name_ar' => $categoryData['name'],
                    'name_en' => null,
                    'sort_order' => $categoryIndex + 1,
                    'is_active' => true,
                ];

                if ($category === null) {
                    $category = Category::query()->create($categoryPayload);
                    $stats['categories_created']++;
                } else {
                    $category->fill($categoryPayload)->save();
                    $stats['categories_updated']++;
                }

                foreach ($categoryData['products'] as $productIndex => [$productName, $price]) {
                    $duplicates = Product::query()
                        ->where('restaurant_id', $restaurant->id)
                        ->where('category_id', $category->id)
                        ->where('name', $productName)
                        ->orderBy('id')
                        ->get();

                    $productPayload = [
                        'restaurant_id' => $restaurant->id,
                        'category_id' => $category->id,
                        'name' => $productName,
                        'description' => null,
                        'price' => $price,
                        'image_path' => null,
                        'is_available' => true,
                        'is_featured' => false,
                        'sort_order' => $productIndex + 1,
                    ];

                    if ($duplicates->isEmpty()) {
                        Product::query()->create($productPayload);
                        $stats['products_created']++;

                        continue;
                    }

                    $product = $duplicates->first();
                    $product->fill($productPayload)->save();
                    $stats['products_updated']++;

                    $duplicateIds = $duplicates->skip(1)->pluck('id');

                    if ($duplicateIds->isNotEmpty()) {
                        $stats['duplicate_products_removed'] += Product::query()
                            ->where('restaurant_id', $restaurant->id)
                            ->whereIn('id', $duplicateIds)
                            ->delete();
                    }
                }
            }
        });

        $this->assertNoDuplicateProductsForTargetRestaurant((int) $restaurant->id);
        $this->reportSummary((int) $restaurant->id, $stats);
    }

    /**
     * @param  array{categories_created: int, categories_updated: int, products_created: int, products_updated: int, duplicate_products_removed: int}  $stats
     */
    private function reportSummary(int $restaurantId, array $stats): void
    {
        $categoryNames = array_column($this->menuData(), 'name');
        $expectedProductCount = array_sum(array_map(
            static fn (array $category): int => count($category['products']),
            $this->menuData(),
        ));

        $categoryCount = Category::query()
            ->where('restaurant_id', $restaurantId)
            ->whereIn('name_ar', $categoryNames)
            ->count();

        $productCount = Product::query()
            ->where('restaurant_id', $restaurantId)
            ->whereIn('category_id', Category::query()
                ->select('id')
                ->where('restaurant_id', $restaurantId)
                ->whereIn('name_ar', $categoryNames))
            ->count();

        $menuSetting = MenuSetting::query()
            ->where('restaurant_id', $restaurantId)
            ->first();

        $this->command?->info('Sip & Chill menu import completed for '.self::TARGET_EMAIL.'.');
        $this->command?->info("Categories created: {$stats['categories_created']}; updated: {$stats['categories_updated']}; verified menu categories: {$categoryCount}/".count($categoryNames).'.');
        $this->command?->info("Products created: {$stats['products_created']}; updated: {$stats['products_updated']}; duplicate products removed: {$stats['duplicate_products_removed']}; verified menu products: {$productCount}/{$expectedProductCount}.");

        if ($categoryCount !== count($categoryNames) || $productCount !== $expectedProductCount) {
            throw new \RuntimeException('Imported menu verification failed for '.self::TARGET_EMAIL.'.');
        }

        if ($menuSetting === null) {
            $this->command?->warn('No menu settings record exists for this restaurant, so the public menu URL could not be verified.');

            return;
        }

        if (! $menuSetting->is_public || ! $menuSetting->restaurant?->isSubscriptionActive()) {
            $this->command?->warn('The products were imported, but the menu is not currently public with an active subscription.');

            return;
        }

        $this->command?->info('Public menu visibility verified at route /menu/'.$menuSetting->slug.'.');
    }

    private function assertNoDuplicateProductsForTargetRestaurant(int $restaurantId): void
    {
        $duplicates = Product::query()
            ->select('category_id', 'name', DB::raw('COUNT(*) as duplicate_count'))
            ->where('restaurant_id', $restaurantId)
            ->groupBy('category_id', 'name')
            ->having('duplicate_count', '>', 1)
            ->exists();

        if ($duplicates) {
            throw new \RuntimeException('Duplicate products still exist for '.self::TARGET_EMAIL.'.');
        }
    }

    /**
     * @return array<int, array{name: string, products: array<int, array{0: string, 1: int}>}>
     */
    private function menuData(): array
    {
        return [
            [
                'name' => 'المشروبات الساخنة',
                'products' => [
                    ['شاي', 45],
                    ['شاي أخضر', 45],
                    ['ينسون', 45],
                    ['ميكس أعشاب', 45],
                    ['شاي مغربي', 55],
                    ['شاي زردة', 55],
                    ['شاي بلبن', 60],
                    ['شاي كرك', 100],
                    ['سحلب عادي', 75],
                    ['سحلب مميز', 110],
                    ['حمص', 85],
                    ['هوت شوكولاتة مارشميلو', 85],
                    ['وايت شوكولاتة', 100],
                    ['هوت أوريو', 90],
                    ['كراميل نوتيلا كوفي', 80],
                    ['أفوجاتو كوفي', 80],
                    ['برتقال مغلي', 60],
                    ['هوت سيدر', 85],
                    ['قهوة تركي سنجل', 40],
                    ['قهوة تركي دبل', 60],
                    ['إسبرسو سنجل', 40],
                    ['إسبرسو دبل', 60],
                    ['ميكاتو سنجل', 55],
                    ['ميكاتو دبل', 75],
                    ['أمريكان كوفي', 70],
                    ['قهوة فرنساوي', 70],
                    ['قهوة بندق', 70],
                    ['كورتادو', 60],
                    ['نسكافيه', 70],
                    ['لاتيه', 70],
                    ['كابتشينو', 70],
                    ['سبانش لاتيه', 80],
                    ['لاتيه لوتس', 80],
                    ['لاتيه كريم بروليه', 110],
                    ['ماتشا لاتيه', 95],
                    ['موكا', 85],
                ],
            ],
            [
                'name' => 'آيس كوفي',
                'products' => [
                    ['آيس لاتيه', 85],
                    ['آيس كابتشينو', 85],
                    ['آيس شوكولاتة', 110],
                    ['آيس ماتشا لاتيه', 110],
                    ['آيس بوبا لاتيه', 110],
                    ['آيس أمريكانو', 85],
                    ['آيس بلو لاتيه', 95],
                    ['آيس موكا', 100],
                    ['آيس سبانش لاتيه', 115],
                    ['آيس سبانش لوتس', 120],
                    ['فرابيه', 115],
                ],
            ],
            [
                'name' => 'موكتيل',
                'products' => [
                    ['موخيتو', 105],
                    ['بلو كروساو', 110],
                    ['لافرز سيب', 130],
                    ['بينا كولادا', 115],
                    ['جرين لاجون', 105],
                    ['صن شاين', 105],
                    ['سيب أند تشيل', 140],
                    ['هواي كوكتيل', 105],
                    ['تروبيكال كوكتيل', 120],
                    ['سين كوكتيل', 145],
                    ['تشيل كوكتيل', 130],
                    ['سيب أند تشيل كوكتيل', 145],
                    ['سيب كوفي كوكتيل', 115],
                ],
            ],
            [
                'name' => 'عصائر فريش',
                'products' => [
                    ['مانجو', 85],
                    ['برتقال', 75],
                    ['جوافة', 75],
                    ['فراولة', 85],
                    ['ليمون نعناع', 65],
                    ['ليمون فرنساوي', 70],
                    ['أفوكادو', 165],
                    ['بلح بلبن', 110],
                    ['بينك ليمون', 70],
                    ['بطيخ', 85],
                    ['موز بلبن', 85],
                ],
            ],
            [
                'name' => 'سموذي',
                'products' => [
                    ['سموذي مانجو', 85],
                    ['سموذي فراولة', 85],
                    ['سموذي مانجو كيوي', 140],
                    ['سموذي أناناس', 120],
                    ['سموذي كيوي', 140],
                    ['سموذي تفاح', 120],
                    ['سموذي باشون', 85],
                    ['سموذي خوخ', 85],
                    ['سموذي ليمون نعناع', 75],
                    ['سموذي بطيخ', 85],
                ],
            ],
            [
                'name' => 'ميلك شيك',
                'products' => [
                    ['ميلك شيك أوريو', 145],
                    ['ميلك شيك كيت كات', 170],
                    ['ميلك شيك كيندر', 155],
                    ['ميلك شيك سنيكرز', 155],
                    ['ميلك شيك براونيز', 170],
                    ['ميلك شيك فانيلا', 135],
                    ['ميلك شيك شوكولاتة', 135],
                    ['ميلك شيك مانجو', 135],
                    ['ميلك شيك فراولة', 135],
                    ['ميلك شيك قرفة', 140],
                    ['ميلك شيك لبان', 140],
                    ['ميلك شيك لوتس', 180],
                    ['ميلك شيك فستق', 190],
                    ['ميلك شيك تشيز كيك', 195],
                ],
            ],
            [
                'name' => 'الحلويات',
                'products' => [
                    ['وافل', 180],
                    ['ميني بان كيك', 180],
                    ['كريب كلاسيك', 120],
                    ['آيس كريب رول', 160],
                    ['آيس ميكس وافل', 220],
                    ['كريب براونيز', 220],
                    ['أم علي', 140],
                    ['مولتن كيك', 140],
                    ['براونيز', 120],
                    ['تشيز كيك', 120],
                    ['تيراميسو', 120],
                    ['كوكيز', 150],
                    ['كرواسون Sip', 190],
                    ['سويت كرواسون', 160],
                    ['بطاطا Sip', 140],
                    ['بوكس الحلى Sip & Chill', 250],
                    ['شوكولاتة مادنس', 120],
                    ['أوريو مادنس', 120],
                    ['لوتس مادنس', 150],
                    ['تشيز مادنس', 180],
                    ['فروت سالاد', 120],
                    ['فرنش توست', 130],
                ],
            ],
            [
                'name' => 'الفطار',
                'products' => [
                    ['أومليت سادة', 120],
                    ['أومليت إسباني', 140],
                    ['أومليت جبنة', 130],
                    ['تركي أند تشيز أومليت', 148],
                    ['أمريكان بريكفاست', 230],
                    ['بلدي بريكفاست', 220],
                    ['كونتيننتال بريكفاست', 195],
                    ['كريب بريكفاست', 210],
                    ['وافل بريكفاست', 220],
                    ['كرواسان مشكل', 120],
                    ['كرواسان سادة', 90],
                    ['كرواسان جبنة', 110],
                    ['أورينتال بريكفاست', 185],
                ],
            ],
            [
                'name' => 'السندوتشات',
                'products' => [
                    ['دجاج تورتيلا مقرمش', 225],
                    ['فيلادلفيا ستيك', 185],
                    ['دجاج إسكالوب', 235],
                    ['دجاج مشروم', 250],
                ],
            ],
            [
                'name' => 'السندوتشات الباردة',
                'products' => [
                    ['كلوب ساندوتش', 225],
                    ['تركي وجبن ساندوتش', 185],
                    ['تونة ساندوتش', 235],
                    ['سالمون مدخن شيباتا', 250],
                ],
            ],
            [
                'name' => 'البرجر',
                'products' => [
                    ['إيطالي موزاريلا برجر', 270],
                    ['بيكون برجر', 260],
                    ['بيف برجر', 245],
                    ['مشروم برجر', 246],
                    ['ميكس تشيز برجر', 235],
                ],
            ],
            [
                'name' => 'البيتزا',
                'products' => [
                    ['مارجريتا', 225],
                    ['خضار بيتزا', 248],
                    ['بيبروني بيتزا', 249],
                    ['فور تشيز بيتزا', 240],
                    ['بي بي كيو تشيكن بيتزا', 239],
                    ['رانش تشيكن بيتزا', 244],
                    ['سوبر سوبريم بيتزا', 249],
                ],
            ],
            [
                'name' => 'الشوربة',
                'products' => [
                    ['شوربة عدس', 115],
                    ['شوربة مشروم', 110],
                    ['شوربة دجاج', 120],
                    ['شوربة فواكه البحر', 145],
                ],
            ],
            [
                'name' => 'المقبلات',
                'products' => [
                    ['دجاج مقرمش', 225],
                    ['موزاريلا مقلية', 185],
                    ['دجاج إسكالوب', 235],
                    ['دجاج مشروم', 250],
                ],
            ],
            [
                'name' => 'السلطات',
                'products' => [
                    ['سلطة تفاح', 240],
                    ['سلطة مشروم', 220],
                    ['كابريزي سالاد', 245],
                    ['جريك سالاد', 215],
                    ['تشيكن سيزر سالاد', 235],
                    ['سلطة تونة فرنسي', 235],
                    ['سلطة دجاج مكسيكي', 260],
                    ['شيف سالاد', 240],
                    ['جريل سالمون سالاد', 290],
                ],
            ],
            [
                'name' => 'أطباق اللحوم',
                'products' => [
                    ['بيف ستراجنوف', 385],
                    ['إسكالوب لحم', 435],
                    ['إسكالوب بارميزان', 440],
                    ['فيليه مشوي', 390],
                ],
            ],
            [
                'name' => 'أطباق الدجاج',
                'products' => [
                    ['رول الدجاج المقلي', 390],
                    ['الصدر المشوي', 350],
                    ['الدجاج الإيطالي المقرمش', 350],
                    ['دجاج ميلانو', 360],
                    ['الدجاج الفرنسي', 365],
                    ['الدجاج الإيطالي', 380],
                    ['الدجاج البارميزان', 370],
                    ['الدجاج الإسكالوب', 365],
                    ['دجاج مسحب مشوي', 390],
                ],
            ],
            [
                'name' => 'المكسيكي',
                'products' => [
                    ['فاهيتا دجاج', 370],
                    ['فاهيتا لحم', 490],
                    ['فاهيتا كومبو', 570],
                    ['فاهيتا سي فود', 500],
                    ['فاهيتا جمبري', 450],
                ],
            ],
            [
                'name' => 'المكرونات',
                'products' => [
                    ['بينا أرابياتا', 190],
                    ['اسباجتي بولونيز', 240],
                    ['بيستو باستا دجاج', 240],
                    ['بيف ستراجنوف باستا', 380],
                    ['ألفريدو', 240],
                    ['تشيكن نيجرسكو', 250],
                    ['سي فود باستا', 280],
                    ['مكس تشيز باستا', 250],
                ],
            ],
            [
                'name' => 'آيس كريم',
                'products' => [
                    ['1 بولة', 40],
                    ['2 بولة', 65],
                    ['3 بولة', 80],
                    ['Sip & Chill', 110],
                ],
            ],
            [
                'name' => 'مشروبات غازية',
                'products' => [
                    ['بيبسي / سفن / دايت', 45],
                    ['ريدبول', 90],
                    ['مياه', 25],
                ],
            ],
            [
                'name' => 'الشيشة',
                'products' => [
                    ['شيشة عادي', 45],
                    ['شيشة فواكه', 175],
                    ['شيشة أعشاب', 25],
                ],
            ],
        ];
    }
}
