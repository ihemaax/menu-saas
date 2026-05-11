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
            ->first();

        if ($user === null) {
            throw new \RuntimeException('Target user '.self::TARGET_EMAIL.' was not found.');
        }

        if ($user->restaurant_id === null) {
            throw new \RuntimeException('Target user '.self::TARGET_EMAIL.' is not linked to a restaurant.');
        }

        $restaurant = $user->restaurant()->first();

        if ($restaurant === null) {
            throw new \RuntimeException('Restaurant #'.$user->restaurant_id.' linked to '.self::TARGET_EMAIL.' was not found.');
        }

        $stats = [
            'categories_deleted' => 0,
            'products_deleted' => 0,
            'categories_created' => 0,
            'products_created' => 0,
        ];

        DB::transaction(function () use ($restaurant, &$stats): void {
            $stats['products_deleted'] = Product::query()
                ->where('restaurant_id', $restaurant->id)
                ->delete();

            $stats['categories_deleted'] = Category::query()
                ->where('restaurant_id', $restaurant->id)
                ->delete();

            foreach ($this->menuData() as $categoryIndex => $categoryData) {
                $category = Category::query()->create([
                    'restaurant_id' => $restaurant->id,
                    'name_ar' => $categoryData['name'],
                    'name_en' => $categoryData['name'],
                    'sort_order' => $categoryIndex + 1,
                    'is_active' => true,
                ]);

                $stats['categories_created']++;

                foreach ($categoryData['products'] as $productIndex => [$productName, $price]) {
                    Product::query()->create([
                        'restaurant_id' => $restaurant->id,
                        'category_id' => $category->id,
                        'name' => $productName,
                        'description' => null,
                        'price' => $price,
                        'image_path' => null,
                        'is_available' => true,
                        'is_featured' => false,
                        'sort_order' => $productIndex + 1,
                    ]);

                    $stats['products_created']++;
                }
            }
        });

        $this->assertFinalMenuCounts((int) $restaurant->id);
        $this->reportSummary((int) $restaurant->id, $stats);
    }

    /**
     * @param  array{categories_deleted: int, products_deleted: int, categories_created: int, products_created: int}  $stats
     */
    private function reportSummary(int $restaurantId, array $stats): void
    {
        $menuSetting = MenuSetting::query()
            ->where('restaurant_id', $restaurantId)
            ->first();

        $this->command?->info('Sip & Chill menu rebuild completed.');
        $this->command?->info('Email: '.self::TARGET_EMAIL);
        $this->command?->info('Restaurant ID: '.$restaurantId);
        $this->command?->info('Categories deleted: '.$stats['categories_deleted']);
        $this->command?->info('Products deleted: '.$stats['products_deleted']);
        $this->command?->info('Categories created: '.$stats['categories_created']);
        $this->command?->info('Products created: '.$stats['products_created']);
        $this->command?->info('Final verified categories: '.count($this->menuData()));
        $this->command?->info('Final verified products: '.$this->expectedProductCount());

        if ($menuSetting === null) {
            $this->command?->warn('No menu settings record exists for this restaurant, so the public menu URL could not be verified.');

            return;
        }

        if (! $menuSetting->is_public || ! $menuSetting->restaurant?->isSubscriptionActive()) {
            $this->command?->warn('The menu was rebuilt, but the public menu is not currently public with an active subscription.');

            return;
        }

        $this->command?->info('Public menu visibility verified at route /menu/'.$menuSetting->slug.'.');
    }

    private function assertFinalMenuCounts(int $restaurantId): void
    {
        $categoryCount = Category::query()
            ->where('restaurant_id', $restaurantId)
            ->count();

        $productCount = Product::query()
            ->where('restaurant_id', $restaurantId)
            ->count();

        if ($categoryCount !== count($this->menuData()) || $productCount !== $this->expectedProductCount()) {
            throw new \RuntimeException(
                'Final Sip & Chill menu verification failed for '.self::TARGET_EMAIL
                .". Expected 22 categories and 203 products, found {$categoryCount} categories and {$productCount} products."
            );
        }
    }

    private function expectedProductCount(): int
    {
        return array_sum(array_map(
            static fn (array $category): int => count($category['products']),
            $this->menuData(),
        ));
    }

    /**
     * @return array<int, array{name: string, products: array<int, array{0: string, 1: int}>}>
     */
    private function menuData(): array
    {
        return [
            [
                'name' => 'Hot Drinks',
                'products' => [
                    ['Tea - شاي', 45],
                    ['Green Tea - شاي أخضر', 45],
                    ['Anise Tea - ينسون', 45],
                    ['Herbal Mix - ميكس أعشاب', 45],
                    ['Moroccan Tea - شاي مغربي', 55],
                    ['Zarda Tea - شاي زردة', 55],
                    ['Milk Tea - شاي بلبن', 60],
                    ['Karak Tea - شاي كرك', 100],
                    ['Classic Sahlab - سحلب عادي', 75],
                    ['Special Sahlab - سحلب مميز', 110],
                    ['Hummus Drink - حمص', 85],
                    ['Hot Chocolate Marshmallow - هوت شوكولاتة مارشميلو', 85],
                    ['White Chocolate - وايت شوكولاتة', 100],
                    ['Hot Oreo - هوت أوريو', 90],
                    ['Caramel Nutella Coffee - كراميل نوتيلا كوفي', 80],
                    ['Affogato Coffee - أفوجاتو كوفي', 80],
                    ['Boiled Orange - برتقال مغلي', 60],
                    ['Hot Cider - هوت سيدر', 85],
                    ['Turkish Coffee Single - قهوة تركي سنجل', 40],
                    ['Turkish Coffee Double - قهوة تركي دبل', 60],
                    ['Espresso Single - إسبرسو سنجل', 40],
                    ['Espresso Double - إسبرسو دبل', 60],
                    ['Macchiato Single - ميكاتو سنجل', 55],
                    ['Macchiato Double - ميكاتو دبل', 75],
                    ['American Coffee - أمريكان كوفي', 70],
                    ['French Coffee - قهوة فرنساوي', 70],
                    ['Hazelnut Coffee - قهوة بندق', 70],
                    ['Cortado - كورتادو', 60],
                    ['Nescafe - نسكافيه', 70],
                    ['Latte - لاتيه', 70],
                    ['Cappuccino - كابتشينو', 70],
                    ['Spanish Latte - سبانش لاتيه', 80],
                    ['Lotus Latte - لاتيه لوتس', 80],
                    ['Creme Brulee Latte - لاتيه كريم بروليه', 110],
                    ['Matcha Latte - ماتشا لاتيه', 95],
                    ['Mocha - موكا', 85],
                ],
            ],
            [
                'name' => 'Iced Coffee',
                'products' => [
                    ['Iced Latte - آيس لاتيه', 85],
                    ['Iced Cappuccino - آيس كابتشينو', 85],
                    ['Iced Chocolate - آيس شوكولاتة', 110],
                    ['Iced Matcha Latte - آيس ماتشا لاتيه', 110],
                    ['Iced Boba Latte - آيس بوبا لاتيه', 110],
                    ['Iced Americano - آيس أمريكانو', 85],
                    ['Iced Blue Latte - آيس بلو لاتيه', 95],
                    ['Iced Mocha - آيس موكا', 100],
                    ['Iced Spanish Latte - آيس سبانش لاتيه', 115],
                    ['Iced Spanish Lotus - آيس سبانش لوتس', 120],
                    ['Frappe - فرابيه', 115],
                ],
            ],
            [
                'name' => 'Mocktails',
                'products' => [
                    ['Mojito - موخيتو', 105],
                    ['Blue Curacao - بلو كروساو', 110],
                    ['Lovers Sip - لافرز سيب', 130],
                    ['Pina Colada - بينا كولادا', 115],
                    ['Green Lagoon - جرين لاجون', 105],
                    ['Sunshine - صن شاين', 105],
                    ['Sip and Chill - سيب أند تشيل', 140],
                    ['Hawaii Cocktail - هواي كوكتيل', 105],
                    ['Tropical Cocktail - تروبيكال كوكتيل', 120],
                    ['Sin Cocktail - سين كوكتيل', 145],
                    ['Chill Cocktail - تشيل كوكتيل', 130],
                    ['Sip and Chill Cocktail - سيب أند تشيل كوكتيل', 145],
                    ['Sip Coffee Cocktail - سيب كوفي كوكتيل', 115],
                ],
            ],
            [
                'name' => 'Fresh Juices',
                'products' => [
                    ['Mango - مانجو', 85],
                    ['Orange - برتقال', 75],
                    ['Guava - جوافة', 75],
                    ['Strawberry - فراولة', 85],
                    ['Lemon Mint - ليمون نعناع', 65],
                    ['French Lemon - ليمون فرنساوي', 70],
                    ['Avocado - أفوكادو', 165],
                    ['Dates with Milk - بلح بلبن', 110],
                    ['Pink Lemon - بينك ليمون', 70],
                    ['Watermelon - بطيخ', 85],
                    ['Banana with Milk - موز بلبن', 85],
                ],
            ],
            [
                'name' => 'Smoothies',
                'products' => [
                    ['Mango Smoothie - سموذي مانجو', 85],
                    ['Strawberry Smoothie - سموذي فراولة', 85],
                    ['Mango Kiwi Smoothie - سموذي مانجو كيوي', 140],
                    ['Pineapple Smoothie - سموذي أناناس', 120],
                    ['Kiwi Smoothie - سموذي كيوي', 140],
                    ['Apple Smoothie - سموذي تفاح', 120],
                    ['Passion Smoothie - سموذي باشون', 85],
                    ['Peach Smoothie - سموذي خوخ', 85],
                    ['Lemon Mint Smoothie - سموذي ليمون نعناع', 75],
                    ['Watermelon Smoothie - سموذي بطيخ', 85],
                ],
            ],
            [
                'name' => 'Milkshakes',
                'products' => [
                    ['Oreo Milkshake - ميلك شيك أوريو', 145],
                    ['KitKat Milkshake - ميلك شيك كيت كات', 170],
                    ['Kinder Milkshake - ميلك شيك كيندر', 155],
                    ['Snickers Milkshake - ميلك شيك سنيكرز', 155],
                    ['Brownies Milkshake - ميلك شيك براونيز', 170],
                    ['Vanilla Milkshake - ميلك شيك فانيلا', 135],
                    ['Chocolate Milkshake - ميلك شيك شوكولاتة', 135],
                    ['Mango Milkshake - ميلك شيك مانجو', 135],
                    ['Strawberry Milkshake - ميلك شيك فراولة', 135],
                    ['Cinnamon Milkshake - ميلك شيك قرفة', 140],
                    ['Bubble Gum Milkshake - ميلك شيك لبان', 140],
                    ['Lotus Milkshake - ميلك شيك لوتس', 180],
                    ['Pistachio Milkshake - ميلك شيك فستق', 190],
                    ['Cheesecake Milkshake - ميلك شيك تشيز كيك', 195],
                ],
            ],
            [
                'name' => 'Desserts',
                'products' => [
                    ['Waffle - وافل', 180],
                    ['Mini Pancake - ميني بان كيك', 180],
                    ['Classic Crepe - كريب كلاسيك', 120],
                    ['Ice Crepe Roll - آيس كريب رول', 160],
                    ['Ice Mix Waffle - آيس ميكس وافل', 220],
                    ['Brownies Crepe - كريب براونيز', 220],
                    ['Om Ali - أم علي', 140],
                    ['Molten Cake - مولتن كيك', 140],
                    ['Brownies - براونيز', 120],
                    ['Cheesecake - تشيز كيك', 120],
                    ['Tiramisu - تيراميسو', 120],
                    ['Cookies - كوكيز', 150],
                    ['Sip Croissant - كرواسون Sip', 190],
                    ['Sweet Croissant - سويت كرواسون', 160],
                    ['Sip Sweet Potato - بطاطا Sip', 140],
                    ['Sip and Chill Dessert Box - بوكس الحلى Sip & Chill', 250],
                    ['Chocolate Madness - شوكولاتة مادنس', 120],
                    ['Oreo Madness - أوريو مادنس', 120],
                    ['Lotus Madness - لوتس مادنس', 150],
                    ['Cheese Madness - تشيز مادنس', 180],
                    ['Fruit Salad - فروت سالاد', 120],
                    ['French Toast - فرنش توست', 130],
                ],
            ],
            [
                'name' => 'Breakfast',
                'products' => [
                    ['Plain Omelette - أومليت سادة', 120],
                    ['Spanish Omelette - أومليت إسباني', 140],
                    ['Cheese Omelette - أومليت جبنة', 130],
                    ['Turkey and Cheese Omelette - تركي أند تشيز أومليت', 148],
                    ['American Breakfast - أمريكان بريكفاست', 230],
                    ['Baladi Breakfast - بلدي بريكفاست', 220],
                    ['Continental Breakfast - كونتيننتال بريكفاست', 195],
                    ['Breakfast Crepe - كريب بريكفاست', 210],
                    ['Breakfast Waffle - وافل بريكفاست', 220],
                    ['Mixed Croissant - كرواسان مشكل', 120],
                    ['Plain Croissant - كرواسان سادة', 90],
                    ['Cheese Croissant - كرواسان جبنة', 110],
                    ['Oriental Breakfast - أورينتال بريكفاست', 185],
                ],
            ],
            [
                'name' => 'Sandwiches',
                'products' => [
                    ['Crispy Chicken Tortilla - دجاج تورتيلا مقرمش', 225],
                    ['Philadelphia Steak - فيلادلفيا ستيك', 185],
                    ['Chicken Escalope - دجاج إسكالوب', 235],
                    ['Chicken Mushroom - دجاج مشروم', 250],
                ],
            ],
            [
                'name' => 'Cold Sandwiches',
                'products' => [
                    ['Club Sandwich - كلوب ساندوتش', 225],
                    ['Turkey and Cheese Sandwich - تركي وجبن ساندوتش', 185],
                    ['Tuna Sandwich - تونة ساندوتش', 235],
                    ['Smoked Salmon Ciabatta - سالمون مدخن شيباتا', 250],
                ],
            ],
            [
                'name' => 'Burgers',
                'products' => [
                    ['Italian Mozzarella Burger - إيطالي موزاريلا برجر', 270],
                    ['Bacon Burger - بيكون برجر', 260],
                    ['Beef Burger - بيف برجر', 245],
                    ['Mushroom Burger - مشروم برجر', 246],
                    ['Mix Cheese Burger - ميكس تشيز برجر', 235],
                ],
            ],
            [
                'name' => 'Pizza',
                'products' => [
                    ['Margherita Pizza - مارجريتا', 225],
                    ['Vegetables Pizza - خضار بيتزا', 248],
                    ['Pepperoni Pizza - بيبروني بيتزا', 249],
                    ['Four Cheese Pizza - فور تشيز بيتزا', 240],
                    ['BBQ Chicken Pizza - بي بي كيو تشيكن بيتزا', 239],
                    ['Ranch Chicken Pizza - رانش تشيكن بيتزا', 244],
                    ['Super Supreme Pizza - سوبر سوبريم بيتزا', 249],
                ],
            ],
            [
                'name' => 'Soups',
                'products' => [
                    ['Lentil Soup - شوربة عدس', 115],
                    ['Mushroom Soup - شوربة مشروم', 110],
                    ['Chicken Soup - شوربة دجاج', 120],
                    ['Seafood Soup - شوربة فواكه البحر', 145],
                ],
            ],
            [
                'name' => 'Appetizers',
                'products' => [
                    ['Crispy Chicken - دجاج مقرمش', 225],
                    ['Fried Mozzarella - موزاريلا مقلية', 185],
                    ['Chicken Escalope - دجاج إسكالوب', 235],
                    ['Chicken Mushroom - دجاج مشروم', 250],
                ],
            ],
            [
                'name' => 'Salads',
                'products' => [
                    ['Apple Salad - سلطة تفاح', 240],
                    ['Mushroom Salad - سلطة مشروم', 220],
                    ['Caprese Salad - كابريزي سالاد', 245],
                    ['Greek Salad - جريك سالاد', 215],
                    ['Chicken Caesar Salad - تشيكن سيزر سالاد', 235],
                    ['French Tuna Salad - سلطة تونة فرنسي', 235],
                    ['Mexican Chicken Salad - سلطة دجاج مكسيكي', 260],
                    ['Chef Salad - شيف سالاد', 240],
                    ['Grilled Salmon Salad - جريل سالمون سالاد', 290],
                ],
            ],
            [
                'name' => 'Meat Dishes',
                'products' => [
                    ['Beef Stroganoff - بيف ستراجنوف', 385],
                    ['Meat Escalope - إسكالوب لحم', 435],
                    ['Parmesan Escalope - إسكالوب بارميزان', 440],
                    ['Grilled Fillet - فيليه مشوي', 390],
                ],
            ],
            [
                'name' => 'Chicken Dishes',
                'products' => [
                    ['Fried Chicken Roll - رول الدجاج المقلي', 390],
                    ['Grilled Chicken Breast - الصدر المشوي', 350],
                    ['Italian Crispy Chicken - الدجاج الإيطالي المقرمش', 350],
                    ['Chicken Milano - دجاج ميلانو', 360],
                    ['French Chicken - الدجاج الفرنسي', 365],
                    ['Italian Chicken - الدجاج الإيطالي', 380],
                    ['Chicken Parmesan - الدجاج البارميزان', 370],
                    ['Chicken Escalope - الدجاج الإسكالوب', 365],
                    ['Grilled Boneless Chicken - دجاج مسحب مشوي', 390],
                ],
            ],
            [
                'name' => 'Mexican',
                'products' => [
                    ['Chicken Fajita - فاهيتا دجاج', 370],
                    ['Beef Fajita - فاهيتا لحم', 490],
                    ['Combo Fajita - فاهيتا كومبو', 570],
                    ['Seafood Fajita - فاهيتا سي فود', 500],
                    ['Shrimp Fajita - فاهيتا جمبري', 450],
                ],
            ],
            [
                'name' => 'Pasta',
                'products' => [
                    ['Penne Arrabbiata - بينا أرابياتا', 190],
                    ['Spaghetti Bolognese - اسباجتي بولونيز', 240],
                    ['Chicken Pesto Pasta - بيستو باستا دجاج', 240],
                    ['Beef Stroganoff Pasta - بيف ستراجنوف باستا', 380],
                    ['Alfredo Pasta - ألفريدو', 240],
                    ['Chicken Negresco - تشيكن نيجرسكو', 250],
                    ['Seafood Pasta - سي فود باستا', 280],
                    ['Mix Cheese Pasta - مكس تشيز باستا', 250],
                ],
            ],
            [
                'name' => 'Ice Cream',
                'products' => [
                    ['1 Scoop - 1 بولة', 40],
                    ['2 Scoops - 2 بولة', 65],
                    ['3 Scoops - 3 بولة', 80],
                    ['Sip and Chill Ice Cream - Sip & Chill', 110],
                ],
            ],
            [
                'name' => 'Soft Drinks',
                'products' => [
                    ['Pepsi / 7Up / Diet - بيبسي / سفن / دايت', 45],
                    ['Red Bull - ريدبول', 90],
                    ['Water - مياه', 25],
                ],
            ],
            [
                'name' => 'Shisha',
                'products' => [
                    ['Regular Shisha - شيشة عادي', 45],
                    ['Fruit Shisha - شيشة فواكه', 175],
                    ['Herbal Shisha - شيشة أعشاب', 25],
                ],
            ],
        ];
    }
}
