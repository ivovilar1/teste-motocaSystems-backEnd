<?php

use App\Models\Product;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

it('should be able to delete a product', function () {
    $product = Product::factory()->create();

    deleteJson(route('product.destroy', $product))
        ->assertNoContent();

    assertDatabaseMissing('products', [
        'id' => $product->id
    ]);
});
