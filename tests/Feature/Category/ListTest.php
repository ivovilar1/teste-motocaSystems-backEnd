<?php

use App\Models\Category;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});
it('should be able to list categories', function () {
    $category = Category::factory()->create();

    $request = getJson(route('category.index'))
        ->assertOk();

    $request->assertJsonFragment([
        'id'         => $category->id,
        'category'   => $category->name,
        'created_at' => $category->created_at->format('Y-m-d h:i:s'),
        'updated_at' => $category->updated_at->format('Y-m-d h:i:s'),
    ]);
});

it('should be able to list specific category', function () {
    $category = Category::factory()->create();

    $request = getJson(route('category.edit', $category))
        ->assertOk();

    $request->assertJsonFragment([
        'id'         => $category->id,
        'category'   => $category->name,
        'created_at' => $category->created_at->format('Y-m-d h:i:s'),
        'updated_at' => $category->updated_at->format('Y-m-d h:i:s'),
    ]);
});
