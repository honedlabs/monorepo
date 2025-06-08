<?php

declare(strict_types=1);

use Workbench\App\Models\User;

use function Pest\Laravel\assertDatabaseHas;

it('formats abn when setting', function () {
    $abn = '12345678901';

    $user = User::factory()->create([
        'abn' => $abn,
    ]);

    expect($user)
        ->abn->toBe('12 345 678 901');

    assertDatabaseHas('users', [
        'abn' => '12 345 678 901',
    ]);
});

it('does not format nulls', function () {
    $user = User::factory()->create([
        'abn' => null,
    ]);

    expect($user)
        ->abn->toBeNull();

    assertDatabaseHas('users', [
        'abn' => null,
    ]);
});
