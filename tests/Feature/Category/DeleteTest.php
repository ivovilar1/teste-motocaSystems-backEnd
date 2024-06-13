<?php

use App\Models\Category;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

it('should be able to delete a category', function () {
    $category = Category::factory()->create();
    deleteJson(route('category.destroy', $category))
        ->assertNoContent();
    assertDatabaseMissing('categories', [
        'id' => $category->id
    ]);
});
