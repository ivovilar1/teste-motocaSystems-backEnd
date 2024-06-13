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
