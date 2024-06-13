<?php

use App\Models\Product;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});
it('should be able to delete a product', function () {
    $product = Product::factory()->create();

    deleteJson(route('product.destroy', $product))
        ->assertNoContent();

    assertDatabaseMissing('products', [
        'id' => $product->id
    ]);
});
