<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TheTreeRestaurantMenuSeeder extends Seeder
{
    public function run(): void
    {
        $targetRestaurantId = 5;
        $targetEmail = 'thetree.2026@gmail.com';

        $restaurant = Restaurant::query()->findOrFail($targetRestaurantId);

        $user = User::query()
            ->where('email', $targetEmail)
            ->firstOrFail();

        if ((int) $user->restaurant_id !== $targetRestaurantId) {
            throw new \RuntimeException("User {$targetEmail} is not linked to restaurant #{$targetRestaurantId}.");
        }

        DB::transaction(function () use ($restaurant): void {
            Product::query()->where('restaurant_id', $restaurant->id)->delete();
            Category::query()->where('restaurant_id', $restaurant->id)->delete();

            $categoryOrder = 1;

            foreach ($this->menuData() as $mainGroup => $categories) {
                foreach ($categories as $categoryName => $products) {
                    $category = Category::query()->create([
                        'restaurant_id' => $restaurant->id,
                        'name_ar' => $categoryName,
                        'name_en' => $mainGroup,
                        'sort_order' => $categoryOrder++,
                        'is_active' => true,
                    ]);

                    $productOrder = 1;

                    foreach ($products as [$productName, $price]) {
                        Product::query()->create([
                            'restaurant_id' => $restaurant->id,
                            'category_id' => $category->id,
                            'name' => $productName,
                            'description' => null,
                            'price' => $price ?? 0,
                            'image_path' => null,
                            'is_available' => true,
                            'is_featured' => false,
                            'sort_order' => $productOrder++,
                        ]);
                    }
                }
            }
        });
    }

    /**
     * @return array<string, array<string, array<int, array{0: string, 1: float|int|null}>>>
     */
    private function menuData(): array
    {
        return [
            'Beverage' => [
                'Hot Drinks' => [
                    ['Tea', 49],
                    ['Green Tea', 49],
                    ['Flavored Tea', 65],
                    ['The Tree Herbs', 85],
                    ['Anise', 45],
                    ['Cinamon with Milk', 85],
                    ['Hot Sidr', 85],
                    ['Hot Chocolate', 99],
                    ['Hot lotus', 119],
                    ['Sahlab', 105],
                    ['The tree Sahlab', 125],
                    ['Hummus Al sham', 80],
                    ['Honey ginger', 90],
                ],
                'Coffee' => [
                    ['Single Espresso', 55],
                    ['Double Espresso', 70],
                    ['Caffè Macchiato', 75],
                    ['Tree Latte', 115],
                    ['Cappuccino', 95],
                    ['Caffè Latte', 85],
                    ['Caffè Mocha', 90],
                    ['American Coffee', 90],
                    ['Nescafé', 90],
                    ['Turkish Coffe', 50],
                    ['Hazelnut Coffee', 85],
                    ['French Turkish Coffe', 75],
                    ['Flat White', 105],
                    ['Double Turkish coffee', 70],
                    ['Spinach Latte', 115],
                ],
                'Tea & Coffee Iced' => [
                    ['Ice Tea', null],
                    ['Flavored Ice Tea', null],
                    ['Iced Mocha', 125],
                    ['Classic Frappuccino', 125],
                    ['Iced Latte', 120],
                    ['Frappe Classic', 130],
                    ['Caramel Frappe', 135],
                    ['Vanilla Frappe', 135],
                    ['Mocha Frappe', 140],
                    ['Ice Spanich Latte', 130],
                ],
                'Fresh Juice' => [
                    ['Mango Juice', 95],
                    ['Orange Juice', 90],
                    ['Strawberry Juice', 85],
                    ['Guava Juice', 85],
                    ['Lemon Juice', 80],
                    ['Orange W Carrot Juice', 95],
                    ['Lemon Mint', 75],
                    ['Banana W. Milk', 99],
                    ['Kiwi Juice', 145],
                    ['Watermelon Juice', 115],
                    ['Avocado W.nuts', 170],
                    ['Date W. Milk', 100],
                    ['Guava W. Milk', 95],
                ],
                'Smoothie' => [
                    ['Smoothie Kiwi', 165],
                    ['Smoothie Kiwi Pineapple', 165],
                    ['Smoothie Lemon Mint', 165],
                    ['Smoothie Banana Strawberry', 165],
                    ['Smoothie Watermelon', 165],
                    ['Smoothie Blueberry', 165],
                    ['Smoothie Boba', 165],
                    ['Smoothie Guava', 165],
                    ['Smoothie Mango', 165],
                    ['Smoothie Orange Peach', 165],
                    ['Smoothie Strawberry', 165],
                    ['Smoothie Mango Passion', 165],
                ],
                'Cocktail' => [
                    ['Florida', 135],
                    ['Pina Colada', 145],
                    ['Titan', 143.75],
                    ['The Tree Cocktail', 185],
                    ['Tropicana', 135],
                    ['Electric', 135],
                    ['Tutti Frutti', 135],
                    ['Coco Berry', 135],
                    ['Banana Jungle', 135],
                    ['Fruits Yogurt', 110],
                    ['Honey Yogurt', 115],
                ],
                'Milk Shake' => [
                    ['Milk Shake Vanilla', 130],
                    ['Milk Shake Chocolate', 130],
                    ['Milk Shake Mango', 130],
                    ['Milk Shake Strawberry', 130],
                    ['Milk Shake Lotus', 145],
                    ['Milk Shake Oreo', 135],
                    ['Milk Shake Rasberry', 130],
                    ['Milk Shake Pistachio', 115],
                ],
                'Soft Drink' => [
                    ['Coca-Cola', 55],
                    ['Perill', 65],
                    ['Schweppes', 65],
                    ['Small Water', 20.125],
                    ['Spiro Spathis', 65],
                    ['RedBull', 120],
                    ['Mojito Classic', 120],
                    ['Fayrous', 65],
                    ['RedBull Mojito', 145],
                    ['Cherry Cola', 85],
                    ['Sunshine', 85],
                    ['Star Mint', 85],
                    ['Cheese Cake Lotus', 155],
                ],
                'Desserts' => [
                    ['Om Ali', 125],
                    ['Crape Nutella', 120],
                    ['Molten Nutella', 155],
                    ['Molten Cake', 155],
                    ['Brownies Ice Cream', 145],
                    ['Chocolate Cake', 145],
                    ['Cheese Cake Flavors', 145],
                    ['Cheese Cake Pastachio', 145],
                    ['HoHo Madness', 145],
                    ['Oreo Madness', 145],
                    ['Chesse Madness', 145],
                    ['The Tree Madness', 145],
                    ['Waffle Nutella', 120],
                    ['Waffle Fruit', 120],
                    ['Waffle Lotus', 130],
                    ['The Tree Waffle', 155],
                    ['Fruit Salad', 140],
                    ['Ice Cream', 99],
                ],
                'Adds Bar' => [
                    ['Ex Milk', 25],
                    ['Ex Flav', 35],
                ],
            ],
            'Food' => [
                'Breakfast' => [
                    ['Oriental Breakfast', 145],
                    ['The Tree Breakfast', 165],
                    ['Turky Cheese', 145],
                    ['Spinach Omellet', 135],
                    ['Smoked Turky', 135],
                ],
                'Salad' => [
                    ['Tuna Salad', 210],
                    ['Quino Greek Salad', 180],
                    ['Chicken Caesar Salad', 210],
                    ['Beet Salad', 220],
                    ['BabaGhanoush', 74.75],
                    ['Garlic Salad', 145],
                    ['Oriantal Salad', 140],
                    ['Tahini Salad', 74.75],
                ],
                'Pizza' => [
                    ['Margherita Pizza', 190],
                    ['Frutti Di Mare Pizza', 290],
                    ['Chicken B.Q.Q Pizza', 245],
                    ['Chicken Ranch Pizza', 255],
                    ['Vegetable Pizza', 230],
                    ['Di Carne Pizza', 264.5],
                    ['Pepperoni Pizza', 265],
                    ['The Tree Pizza', 275],
                ],
                'Chicken Main Course' => [
                    ['Chicken Grill', 380],
                    ['Sweet Chili Chicken', 375],
                    ['The Tree Chicken', 390],
                    ['Chicken Fajitas', 395],
                ],
                'Beef Main Course' => [
                    ['Beef Fajitas', 485],
                    ['Grilled Rib Eye', 550],
                    ['Beef Madeilion', 535],
                    ['Beef Piccata', 540],
                ],
                'Pasta' => [
                    ['Chicken Alfredo Pasta', 245],
                    ['Arabiata', 170],
                    ['Rosa Lasagna', 265],
                    ['Seafood Pasta', 325],
                    ['Spaghetti Bolognese', 220],
                    ['Mac And Cheese Pasta', 250],
                    ['Chicken Pesto Pasta', 240],
                    ['Mushroom Risotto', 255],
                    ['Seafood Risotto', 325],
                ],
                'Apptizers' => [
                    ['Mexican Chicken Burrito', 149.5],
                    ['Mozzarella Sticks', 175],
                    ['Gourmet Potatoes', 175],
                    ['Amrancini Polo', 185],
                    ['Fritto Misto', 220],
                    ['Mexican Chicken Quesadilla', 210],
                    ['Mexican Beef Quesadilla', 220],
                    ['Classic Mexican Nachos', 135],
                ],
                'Soup' => [
                    ['Chicken Soup', 135],
                    ['Mushroom Soup', 130],
                    ['Seafood Soup', 165],
                    ['شوربة عدس', 85],
                    ['Italian Minestrone Soup', 110],
                ],
                'Seafood Main Course' => [
                    ['Grilled Salamon', 525],
                    ['Grilled Shrimps', 490],
                    ['Crab Sauce Shrimp', 490],
                    ['Fish And Chips', 255],
                ],
                'Grilled' => [
                    ['Mix Grill', 440],
                    ['Chicken Mashab', 395],
                    ['Shish Tawok', 385],
                ],
                'Sandwiches' => [
                    ['Steak Sandwish', 230],
                    ['Mexican Sandwish', 175],
                    ['Chicken Ransh Sando', 165],
                    ['Panini Vegan Sandwish', 165],
                    ['Shrimp Sandwish', 230],
                    ['Chicken Fajita Sando', 220],
                    ['Shawarma Wrap', 149.5],
                    ['Fried Chicken Warp', 230],
                    ['Classic Burger', 240],
                    ['The Tree Burger', 265],
                ],
                'Kids Corner' => [
                    ['Mini Burger', 190],
                    ['Strips With Fries', 205],
                ],
                'Adds Kit' => [
                    ['Mash Potato', 60],
                    ['White Rice', 50],
                    ['Oriantal Rice', 65],
                    ['Sautéed Vegetables', 70],
                    ['French Frise', 70],
                    ['Frash Frise L', 90],
                    ['Shrimp', 145],
                    ['Chicken', 90],
                    ['Cheese', 74.75],
                    ['Pasta White', 105],
                    ['Pasta Red', 90],
                    ['Rice Basmati', 75],
                    ['Rice White', 40.25],
                    ['Basket Bread', 30],
                    ['Ex Mashroom', 45],
                ],
                'Shisha' => [
                    ['شيشه فواكه', 175],
                    ['ذا ترى شيشه', 205],
                    ['لى طبى', 25],
                    ['شيشه اسكندرانى', 70],
                    ['شيشه معسل', 50],
                    ['غيار فواكه', 110],
                ],
            ],
        ];
    }
}
