<?php

use App\Models\Product;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should be able to list all products', function () {

    $product = Product::factory()->create();

    $request = getJson(route('product.index'))
        ->assertOk();

    $request->assertJsonFragment([
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->price,
        'category' => [
            'id' => $product->category->id,
            'name' => $product->category->name
        ],
        'created_at' => $product->created_at->format('Y-m-d h:i:s'),
        'updated_at' => $product->updated_at->format('Y-m-d h:i:s'),
    ]);
});

it('should be able to list specific product', function () {
    $product = Product::factory()->create();
    $request = getJson(route('product.edit', $product))
        ->assertOk();

    $request->assertJsonFragment([
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->price,
        'category' => [
            'id' => $product->category->id,
            'name' => $product->category->name
        ],
        'created_at' => $product->created_at->format('Y-m-d h:i:s'),
        'updated_at' => $product->updated_at->format('Y-m-d h:i:s'),
    ]);

});
