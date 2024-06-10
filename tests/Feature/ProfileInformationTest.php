<?php

use App\Models\User;

test('profile information can be updated', function () {
    $this->actingAs($user = User::factory()->create());

    $response = $this->put('/user/profile-information', [
        'firstName' => 'Test Name',
        'lastName' => 'Test Name',
        'email' => 'test@example.com',
    ]);

    expect($user->fresh())
        ->firstName->toEqual('Test Name')
        ->lastName->toEqual('Test Name')
        ->email->toEqual('test@example.com');
});
