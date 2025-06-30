<?php

declare(strict_types=1);

use Workbench\App\Batches\UserBatch;
use Workbench\App\Models\User;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('hits', function () {
    User::factory()->create();
    post(route('batches', [UserBatch::make(), 'update-name']), [
        'id' => 1,
    ]);

    dd(User::first());


})->skip();