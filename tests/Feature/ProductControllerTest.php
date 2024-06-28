<?php

use App\Models\Product;
use App\Service\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class);

beforeEach(function () {
    $this->mockProductService = Mockery::mock(ProductService::class);
    $this->app->instance(ProductService::class, $this->mockProductService);
});

it('should return a list of products', function () {
    $products = [
        [
            "id" => 1,
            "name" => "Product one",
            "slug" => "product-1",
            "image" => null,
            "description" => null,
            "quantity" => null,
            "price" => null,
            "discount" => null,
            "user_id" => 1,
            "created_at" => "2024-06-16T19:43:52.000000Z",
            "updated_at" => "2024-06-16T19:43:52.000000Z"
        ]
    ];

    $this->mockProductService
        ->shouldReceive('getAll')
        ->once()
        ->andReturn($products);

    $response = $this->get('/api/v1/product/list');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => $products,
        ]);
});

it('should create a product', function () {

    $newProductRequest = [
        'name' => 'Product two',
        'slug' => 'product-2',
        'user_id' => 1,
    ];

    $newProductResponse = [
        "id" => 1,
        "name" => "Product two",
        "slug" => "product-2",
        "image" => null,
        "description" => null,
        "quantity" => null,
        "price" => null,
        "discount" => null,
        "user_id" => 1,
        "created_at" => now()->format("Y-m-d H:i:s"),
        "updated_at" => now()->format("Y-m-d H:i:s")
    ];

    $this->mockProductService->shouldReceive('create')
        ->once()
        ->with($newProductRequest)
        ->andReturn($newProductResponse);

    $response = $this->post('/api/v1/product/create', $newProductRequest);

    $response->assertStatus(200)->assertJson([
            "success" => true,
            "data" => $newProductResponse,
        ]
    );
});

it('create product false', function () {
    $newProductRequest = [
        'name' => 'Product two',
        'slug' => 'product-2',
        'user_id' => 1,
    ];

    $this->mockProductService->shouldReceive('create')
        ->once()
        ->with($newProductRequest)
        ->andReturn(null);

    $response = $this->post('/api/v1/product/create', $newProductRequest);

    $response->assertStatus(200)->assertJson([
        "success" => false,
    ]);
});

