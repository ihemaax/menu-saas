<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuSetting;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MenuAiAssistantTest extends TestCase
{
    use RefreshDatabase;

    public function test_endpoint_sends_only_current_restaurant_available_products_to_deepseek(): void
    {
        config(['services.deepseek.key' => 'test-key']);

        [$restaurant, $menuSetting, $category] = $this->createPublicRestaurant('cafe-one');
        [$otherRestaurant, , $otherCategory] = $this->createPublicRestaurant('cafe-two');

        $currentProduct = Product::create([
            'restaurant_id' => $restaurant->id,
            'category_id' => $category->id,
            'name' => 'Iced Latte',
            'price' => 95,
            'is_available' => true,
            'is_featured' => false,
            'sort_order' => 1,
        ]);

        $unavailableProduct = Product::create([
            'restaurant_id' => $restaurant->id,
            'category_id' => $category->id,
            'name' => 'Hidden Drink',
            'price' => 100,
            'is_available' => false,
            'is_featured' => false,
            'sort_order' => 2,
        ]);

        $otherProduct = Product::create([
            'restaurant_id' => $otherRestaurant->id,
            'category_id' => $otherCategory->id,
            'name' => 'Other Store Cake',
            'price' => 80,
            'is_available' => true,
            'is_featured' => false,
            'sort_order' => 1,
        ]);

        Http::fake([
            'api.deepseek.com/*' => Http::response([
                'choices' => [[
                    'message' => [
                        'content' => json_encode([
                            'reply' => 'أرشحلك آيس لاتيه، مناسب كحاجة ساقعة.',
                            'recommended_product_ids' => [$currentProduct->id, $otherProduct->id, $unavailableProduct->id],
                            'needs_more_info' => false,
                            'follow_up_question' => null,
                        ], JSON_UNESCAPED_UNICODE),
                    ],
                ]],
            ]),
        ]);

        $this->postJson(route('menu.ai.ask', $menuSetting->slug), [
            'question' => 'عايز حاجة ساقعة',
        ])
            ->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonPath('recommended_product_ids', [$currentProduct->id])
            ->assertJsonCount(1, 'recommended_products')
            ->assertJsonPath('recommended_products.0.id', $currentProduct->id);

        Http::assertSent(function ($request) use ($currentProduct, $otherProduct, $unavailableProduct) {
            $content = data_get($request->data(), 'messages.1.content');
            $payload = is_string($content) ? json_decode($content, true) : [];
            $productIds = collect($payload['menu_products'] ?? [])->pluck('id')->all();

            return $productIds === [$currentProduct->id]
                && ! in_array($otherProduct->id, $productIds, true)
                && ! in_array($unavailableProduct->id, $productIds, true);
        });
    }

    public function test_endpoint_rejects_empty_question(): void
    {
        [, $menuSetting] = $this->createPublicRestaurant('empty-question-cafe');

        $this->postJson(route('menu.ai.ask', $menuSetting->slug), [
            'question' => '',
        ])->assertUnprocessable();
    }

    public function test_endpoint_uses_current_menu_fallback_when_deepseek_fails(): void
    {
        config(['services.deepseek.key' => null]);

        [, $menuSetting, $category] = $this->createPublicRestaurant('no-key-cafe');
        Product::create([
            'restaurant_id' => $category->restaurant_id,
            'category_id' => $category->id,
            'name' => 'Mocha',
            'price' => 120,
            'is_available' => true,
            'is_featured' => false,
            'sort_order' => 1,
        ]);

        $this->postJson(route('menu.ai.ask', $menuSetting->slug), [
            'question' => 'رشحلي حاجة',
        ])
            ->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonPath('recommended_products.0.name', 'Mocha');
    }

    public function test_menu_page_contains_ai_assistant_button(): void
    {
        [$restaurant, $menuSetting, $category] = $this->createPublicRestaurant('visible-ai-cafe');
        Product::create([
            'restaurant_id' => $restaurant->id,
            'category_id' => $category->id,
            'name' => 'Espresso',
            'price' => 70,
            'is_available' => true,
            'is_featured' => false,
            'sort_order' => 1,
        ]);

        $this->get(route('menu.show', $menuSetting->slug))
            ->assertOk()
            ->assertSee('اسأل Osirix');
    }

    private function createPublicRestaurant(string $slug): array
    {
        $restaurant = Restaurant::create([
            'name' => 'Test Cafe '.$slug,
            'subscription_status' => 'active',
        ]);

        $menuSetting = MenuSetting::create([
            'restaurant_id' => $restaurant->id,
            'slug' => $slug,
            'is_public' => true,
            'theme' => 'classy',
        ]);

        $category = Category::create([
            'restaurant_id' => $restaurant->id,
            'name_ar' => 'مشروبات',
            'name_en' => 'Drinks',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        return [$restaurant, $menuSetting, $category];
    }
}
