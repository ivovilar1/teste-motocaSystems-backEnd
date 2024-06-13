<?php

use App\Models\Product;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\putJson;

beforeEach(function () {
   $this->product = Product::factory()->create();
});

it('should be able to update a product', function () {

    putJson(route('product.update', $this->product), [
        'name' => 'Product Name Updated',
        'description' => $this->product->description,
        'price' => (string)$this->product->price,
        'category_id' => $this->product->category_id,
    ])->assertOk();

    assertDatabaseHas('products', [
        'id' => $this->product->id,
        'name' => 'Product Name Updated'
    ]);
});
describe('validation rules', function () {

    test('product.name.required', function () {
        putJson(route('product.update', $this->product),[])
            ->assertJsonValidationErrors([
                'name' => __('validation.required', ['attribute' => 'name'])
            ]);
    });

    test('product.name.min', function () {
        putJson(route('product.update', $this->product),[
            'name' => 'ab'
        ])
            ->assertJsonValidationErrors([
                'name' => __('validation.min.string', ['attribute' => 'name', 'min' => 3])
            ]);
    });
    test('product.name.max', function () {
        putJson(route('product.update', $this->product),[
            'name' => str_repeat('a', 101)
        ])
            ->assertJsonValidationErrors([
                'name' => __('validation.max.string', ['attribute' => 'name', 'max' => 100])
            ]);
    });
    test('product.name.string', function () {
        putJson(route('product.update', $this->product),[
            'name' => 1321231231
        ])
            ->assertJsonValidationErrors([
                'name' => __('validation.string', ['attribute' => 'name'])
            ]);
    });
    test('product.description.required', function () {
        putJson(route('product.update', $this->product),[])
            ->assertJsonValidationErrors([
                'description' => __('validation.required', ['attribute' => 'description'])
            ]);
    });

    test('product.description.min', function () {
        putJson(route('product.update', $this->product),[
            'description' => 'ab'
        ])
            ->assertJsonValidationErrors([
                'description' => __('validation.min.string', ['attribute' => 'description', 'min' => 3])
            ]);
    });
    test('product.description.max', function () {
        putJson(route('product.update', $this->product),[
            'description' => str_repeat('a', 256)
        ])
            ->assertJsonValidationErrors([
                'description' => __('validation.max.string', ['attribute' => 'description', 'max' => 255])
            ]);
    });
    test('product.description.string', function () {
        putJson(route('product.update', $this->product),[
            'description' => 1321231231
        ])
            ->assertJsonValidationErrors([
                'description' => __('validation.string', ['attribute' => 'description'])
            ]);
    });
    test('product.price.required', function () {
        putJson(route('product.update', $this->product),[])
            ->assertJsonValidationErrors([
                'price' => __('validation.required', ['attribute' => 'price'])
            ]);
    });
    test('product.price.string', function () {
        putJson(route('product.update', $this->product),[
            'price' => 1321231231
        ])
            ->assertJsonValidationErrors([
                'price' => __('validation.string', ['attribute' => 'price'])
            ]);
    });
    test('product.category_id.required', function () {
        putJson(route('product.update', $this->product), [])
            ->assertJsonValidationErrors([
                'category_id' => 'The category id field is required.'
            ]);
    });
    test('product.category_id.integer', function () {
        putJson(route('product.update', $this->product),[
            'category_id' => '1231231asda'
        ])
            ->assertJsonValidationErrors([
                'category_id' => 'The category id field must be an integer.'
            ]);
    });
    test('product.category_id.exists', function () {
        putJson(route('product.update', $this->product),[
            'category_id' => 2
        ])
            ->assertJsonValidationErrors([
                'category_id' => 'The selected category id is invalid.'
            ]);
    });
});
