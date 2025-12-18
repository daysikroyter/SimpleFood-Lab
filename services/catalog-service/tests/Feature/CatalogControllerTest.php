<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_categories()
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'title', 'slug', 'icon']
            ]);
    }

    /** @test */
    public function it_can_create_a_category()
    {
        $categoryData = [
            'title' => 'Pizza',
            'slug' => 'pizza',
            'icon' => 'pizza-icon'
        ];

        $response = $this->postJson('/api/categories', $categoryData);

        $response->assertStatus(201)
            ->assertJson($categoryData);

        $this->assertDatabaseHas('categories', $categoryData);
    }

    /** @test */
    public function it_can_list_all_products()
    {
        $category = Category::factory()->create();
        Product::factory()->count(3)->create(['category_id' => $category->id]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    '*' => ['id', 'title', 'slug', 'price', 'category_id']
                ]
            ]);
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $category = Category::factory()->create();

        $productData = [
            'category_id' => $category->id,
            'title' => 'Margherita Pizza',
            'slug' => 'margherita',
            'description' => 'Classic Italian pizza',
            'price' => 1200
        ];

        $response = $this->postJson('/api/products', $productData);

        $response->assertStatus(201)
            ->assertJson($productData);

        $this->assertDatabaseHas('products', $productData);
    }

    /** @test */
    public function it_validates_product_price_is_positive()
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/products', [
            'category_id' => $category->id,
            'title' => 'Test Product',
            'slug' => 'test',
            'price' => -100
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['price']);
    }

    /** @test */
    public function it_can_show_a_single_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $product->id,
                'title' => $product->title
            ]);
    }

    /** @test */
    public function it_can_filter_products_by_category()
    {
        $category1 = Category::factory()->create(['slug' => 'pizza']);
        $category2 = Category::factory()->create(['slug' => 'burgers']);

        Product::factory()->count(2)->create(['category_id' => $category1->id]);
        Product::factory()->count(3)->create(['category_id' => $category2->id]);

        $response = $this->getJson("/api/products?category_id={$category1->id}");

        $response->assertStatus(200);
        
        $data = $response->json('data'); // Direct pagination data array
        $this->assertCount(2, $data);
    }

    /** @test */
    public function it_can_search_products_by_title()
    {
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->id, 'title' => 'Margherita Pizza']);
        Product::factory()->create(['category_id' => $category->id, 'title' => 'Pepperoni Pizza']);
        Product::factory()->create(['category_id' => $category->id, 'title' => 'Cheeseburger']);

        $response = $this->getJson('/api/products?search=pizza');

        $response->assertStatus(200);
        
        $data = $response->json('data'); // Direct pagination data array
        $this->assertGreaterThanOrEqual(2, count($data));
    }
}
