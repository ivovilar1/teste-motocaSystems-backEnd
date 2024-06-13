<?php

use App\Models\Category;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

it('should be able to delete a category', function () {
    $user = User::factory()->create();
    actingAs($user);
    $category = Category::factory()->create();
    deleteJson(route('category.destroy', $category))
        ->assertNoContent();
    assertDatabaseMissing('categories', [
        'id' => $category->id
    ]);
});
