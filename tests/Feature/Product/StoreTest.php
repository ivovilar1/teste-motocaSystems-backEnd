<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(function () {
   $this->category = Category::factory()->create();
    $user = User::factory()->create();
    actingAs($user);
});

it('should be able to create a product', function () {
    assertDatabaseCount('products', 0);

    postJson(route('product.store'), [
        'name' => 'Product Test',
        'description' => 'Product Test Description',
        'price' => '123.45',
        'category_id' => $this->category->id,
    ])->assertSuccessful();

    assertDatabaseCount('products', 1);
    assertDatabaseHas('products', [
        'name' => 'Product Test',
        'description' => 'Product Test Description',
        'price' => 12345,
        'category_id' => $this->category->id
    ]);
});

describe('validation rules', function () {

    test('product.name.required', function () {
        postJson(route('product.store'),[])
            ->assertJsonValidationErrors([
                'name' => __('validation.required', ['attribute' => 'name'])
            ]);
    });

    test('product.name.min', function () {
        postJson(route('product.store'),[
            'name' => 'ab'
        ])
            ->assertJsonValidationErrors([
                'name' => __('validation.min.string', ['attribute' => 'name', 'min' => 3])
            ]);
    });
    test('product.name.max', function () {
        postJson(route('product.store'),[
            'name' => str_repeat('a', 101)
        ])
            ->assertJsonValidationErrors([
                'name' => __('validation.max.string', ['attribute' => 'name', 'max' => 100])
            ]);
    });
    test('product.name.string', function () {
        postJson(route('product.store'),[
            'name' => 1321231231
        ])
            ->assertJsonValidationErrors([
                'name' => __('validation.string', ['attribute' => 'name'])
            ]);
    });
    test('product.description.required', function () {
        postJson(route('product.store'),[])
            ->assertJsonValidationErrors([
                'description' => __('validation.required', ['attribute' => 'description'])
            ]);
    });

    test('product.description.min', function () {
        postJson(route('product.store'),[
            'description' => 'ab'
        ])
            ->assertJsonValidationErrors([
                'description' => __('validation.min.string', ['attribute' => 'description', 'min' => 3])
            ]);
    });
    test('product.description.max', function () {
        postJson(route('product.store'),[
            'description' => str_repeat('a', 256)
        ])
            ->assertJsonValidationErrors([
                'description' => __('validation.max.string', ['attribute' => 'description', 'max' => 255])
            ]);
    });
    test('product.description.string', function () {
        postJson(route('product.store'),[
            'description' => 1321231231
        ])
            ->assertJsonValidationErrors([
                'description' => __('validation.string', ['attribute' => 'description'])
            ]);
    });
    test('product.price.required', function () {
        postJson(route('product.store'),[])
            ->assertJsonValidationErrors([
                'price' => __('validation.required', ['attribute' => 'price'])
            ]);
    });
    test('product.price.string', function () {
        postJson(route('product.store'),[
            'price' => 1321231231
        ])
            ->assertJsonValidationErrors([
                'price' => __('validation.string', ['attribute' => 'price'])
            ]);
    });
    test('product.category_id.required', function () {
        postJson(route('product.store'), [])
            ->assertJsonValidationErrors([
                'category_id' => 'The category id field is required.'
            ]);
    });
    test('product.category_id.integer', function () {
        postJson(route('product.store'),[
            'category_id' => '1231231asda'
        ])
            ->assertJsonValidationErrors([
                'category_id' => 'The category id field must be an integer.'
            ]);
    });
    test('product.category_id.exists', function () {
        postJson(route('product.store'),[
            'category_id' => 2
        ])
            ->assertJsonValidationErrors([
                'category_id' => 'The selected category id is invalid.'
            ]);
    });
});

it('after creating whe should return a status 201 with the created product', function () {
    $request = postJson(route('product.store'), [
        'name' => 'Product Test',
        'description' => 'Product Test Description',
        'price' => '123.45',
        'category_id' => $this->category->id,
    ])->assertCreated();

    /** @var Product $product */
    $product = Product::query()->latest()->first();

    $request->assertJson([
        'data' => [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'category' => [
                'id' => $product->category->id,
                'name' => $product->category->name
            ],
            'created_at' => $product->created_at->format('Y-m-d h:i:s'),
            'updated_at' => $product->updated_at->format('Y-m-d h:i:s'),
        ],
    ]);
});
