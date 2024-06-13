<?php

use App\Models\Category;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(function () {
   $this->category = Category::factory()->create();
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
        'price' => '12345',
        'category_id' => 1
    ]);
});
