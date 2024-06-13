<?php

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

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
