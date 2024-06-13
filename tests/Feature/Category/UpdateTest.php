<?php

use App\Models\Category;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\putJson;

it('should be able to update a category', function () {
    $category = Category::factory()->create();
    putJson(route('category.update', $category), [
        'name' => 'Category updated',
    ])->assertOk();
    assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Category updated',
    ]);
});
