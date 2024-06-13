<?php

use function Pest\Laravel\postJson;

it('should be able access route to store category', function () {

    postJson(route('category.store'))
        ->assertSuccessful();

});
