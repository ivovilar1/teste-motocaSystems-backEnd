<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\postJson;

it('should be able to login with token', function () {
    User::factory()->create([
        'email' => 'joe@doe.com',
        'password' => Hash::make('password')
    ]);
    $request = postJson(route('login'), [
        'email' => 'joe@doe.com',
        'password' => 'password'
    ])->assertSuccessful();

    $request->assertJsonStructure([
        'access_token',
    ]);
});
it('should check if the email and password is valid', function ($email, $password) {
    User::factory()->create(['email' => 'joe@doe.com', 'password' => Hash::make('password')]);

    postJson(route('login'), [
        'email'    => $email,
        'password' => $password,
    ])->assertJsonValidationErrors([
        'email' => __('auth.failed'),
    ]);
})->with([
    'wrong email'    => ['wrong@email.com', 'password'],
    'wrong password' => ['wrong@email.com', 'password123213'],
    'invalid email'  => ['invalid-email', 'password123213'],
]);

test('required fields', function () {
    postJson(route('login'), [
        'email'    => '',
        'password' => '',
    ])->assertJsonValidationErrors([
        'email'    => __('validation.required', ['attribute' => 'email']),
        'password' => __('validation.required', ['attribute' => 'password']),
    ]);
});
