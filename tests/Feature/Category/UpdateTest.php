<?php

use App\Models\Category;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\putJson;

beforeEach(function () {
   $this->category = Category::factory()->create();
});

it('should be able to update a category', function () {
    putJson(route('category.update', $this->category), [
        'name' => 'Category updated',
    ])->assertOk();
    assertDatabaseHas('categories', [
        'id' => $this->category->id,
        'name' => 'Category updated',
    ]);
});

describe('validation rules', function () {

    test('category.required', function () {
        putJson(route('category.update', $this->category),[])
            ->assertJsonValidationErrors([
                'name' => __('validation.required', ['attribute' => 'name'])
            ]);
    });

    test('category.min', function () {
        putJson(route('category.update', $this->category),[
            'name' => 'ab'
        ])
            ->assertJsonValidationErrors([
                'name' => __('validation.min.string', ['attribute' => 'name', 'min' => 3])
            ]);
    });
    test('category.max', function () {
        putJson(route('category.update', $this->category),[
            'name' => str_repeat('a', 51)
        ])
            ->assertJsonValidationErrors([
                'name' => __('validation.max.string', ['attribute' => 'name', 'max' => 50])
            ]);
    });
    test('category.string', function () {
        putJson(route('category.update', $this->category),[
            'name' => 1321231231
        ])
            ->assertJsonValidationErrors([
                'name' => __('validation.string', ['attribute' => 'name'])
            ]);
    });
});
