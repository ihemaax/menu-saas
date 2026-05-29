<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuSetting;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MenuDataSafetyTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_delete_only_soft_deletes_the_record_and_keeps_uploaded_image(): void
    {
        Storage::fake('public');

        [$user, $restaurant, $category] = $this->createOwnerRestaurantAndCategory();
        Storage::disk('public')->put('products/images/product.jpg', 'image-content');

        $product = Product::create([
            'restaurant_id' => $restaurant->id,
            'category_id' => $category->id,
            'name' => 'Safe Burger',
            'price' => 120,
            'image_path' => 'products/images/product.jpg',
            'is_available' => true,
            'is_featured' => false,
            'sort_order' => 1,
        ]);

        $this->actingAs($user)
            ->delete(route('products.destroy', $product))
            ->assertRedirect(route('products.index', ['page' => 1]));

        $this->assertSoftDeleted('products', ['id' => $product->id]);
        Storage::disk('public')->assertExists('products/images/product.jpg');
    }

    public function test_category_delete_only_soft_deletes_the_category(): void
    {
        [$user, , $category] = $this->createOwnerRestaurantAndCategory();

        $this->actingAs($user)
            ->delete(route('categories.destroy', $category))
            ->assertRedirect(route('categories.index'));

        $this->assertSoftDeleted('categories', ['id' => $category->id]);
    }

    public function test_menu_seeders_do_not_contain_destructive_deletes(): void
    {
        $seeders = [
            database_path('seeders/SipAndChillMenuSeeder.php'),
            database_path('seeders/TheTreeRestaurantMenuSeeder.php'),
        ];

        foreach ($seeders as $seeder) {
            $contents = file_get_contents($seeder);

            $this->assertStringNotContainsString('->delete(', $contents, $seeder.' must not delete customer data.');
            $this->assertStringNotContainsString('truncate(', $contents, $seeder.' must not truncate customer data.');
        }
    }

    private function createOwnerRestaurantAndCategory(): array
    {
        $restaurant = Restaurant::create([
            'name' => 'Safety Cafe',
            'subscription_status' => 'active',
        ]);

        MenuSetting::create([
            'restaurant_id' => $restaurant->id,
            'slug' => 'safety-cafe',
            'is_public' => true,
            'theme' => 'classy',
        ]);

        $user = User::factory()->create([
            'restaurant_id' => $restaurant->id,
        ]);

        $category = Category::create([
            'restaurant_id' => $restaurant->id,
            'name_ar' => 'Main',
            'name_en' => 'Main',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        return [$user, $restaurant, $category];
    }
}
