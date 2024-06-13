<?php

use App\Models\Category;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should be able to store a new category', function () {
    assertDatabaseCount('categories', 0);

    postJson(route('category.store'),[
        'name' => 'Test 1'
    ])->assertSuccessful();

    assertDatabaseCount('categories', 1);
    assertDatabaseHas('categories', [
        'name' => 'Test 1'
    ]);

});
describe('validation rules', function () {

   test('category.required', function () {
      postJson(route('category.store'),[])
          ->assertJsonValidationErrors([
          'name' => __('validation.required', ['attribute' => 'name'])
      ]);
   });

    test('category.min', function () {
        postJson(route('category.store'),[
            'name' => 'ab'
        ])
            ->assertJsonValidationErrors([
                'name' => __('validation.min.string', ['attribute' => 'name', 'min' => 3])
            ]);
    });
    test('category.max', function () {
        postJson(route('category.store'),[
            'name' => str_repeat('a', 51)
        ])
            ->assertJsonValidationErrors([
                'name' => __('validation.max.string', ['attribute' => 'name', 'max' => 50])
            ]);
    });
    test('category.string', function () {
        postJson(route('category.store'),[
            'name' => 1321231231
        ])
            ->assertJsonValidationErrors([
                'name' => __('validation.string', ['attribute' => 'name'])
            ]);
    });
});
it('after creating whe should return a status 201 with the created category', function () {

    $request = postJson(route('category.store'),[
        'name' => 'Test 1'
    ])->assertSuccessful();

    /** @var Category $category */
    $category = Category::query()->latest()->first();

    $request->assertJson([
        'data' => [
            'id'         => $category->id,
            'category'   => $category->name,
            'created_at' => $category->created_at->format('Y-m-d h:i:s'),
            'updated_at' => $category->updated_at->format('Y-m-d h:i:s'),
        ],
    ]);
});
