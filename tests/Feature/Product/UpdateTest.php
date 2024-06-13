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
