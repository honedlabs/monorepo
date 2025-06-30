<?php

declare(strict_types=1);

use Workbench\App\Batches\UserBatch;

use function Pest\Laravel\get;

it('hits', function () {
    dd(get(route('batches', [UserBatch::make(), 'update-name'])));
})->only();