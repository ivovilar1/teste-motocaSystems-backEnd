<?php

use App\Models\Product;
use function Pest\Laravel\getJson;

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
