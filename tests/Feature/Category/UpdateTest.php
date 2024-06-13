<?php

use App\Models\Category;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\putJson;

beforeEach(function () {
   $this->category = Category::factory()->create();
    $user = User::factory()->create();
    actingAs($user);
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

test('after update we should return a status 200 with the updated category', function () {

    $request = putJson(route('category.update', $this->category), [
        'name' => 'Category updated',
    ])->assertOk();

    $request->assertJson([
        'data' => [
            'id'         => $this->category->id,
            'category'   => 'Category updated',
            'created_at' => $this->category->created_at->format('Y-m-d h:i:s'),
            'updated_at' => $this->category->updated_at->format('Y-m-d h:i:s'),
        ],
    ]);
});
