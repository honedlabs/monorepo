<?php

declare(strict_types=1);

use Workbench\App\Models\User;
use Workbench\App\Batches\UserProductBatch;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->batch = UserProductBatch::make();
})->only();

it('is rememberable', function () {
    expect($this->batch)
        ->isNotRememberable()->toBeTrue()
        ->isRememberable()->toBeFalse()
        ->rememberable()->toBe($this->batch)
        ->isRememberable()->toBeTrue()
        ->notRememberable()->toBe($this->batch)
        ->isNotRememberable()->toBeTrue();
});

it('can remember data', function () {
    $this->batch->user($this->user);

    dd($this->batch->getRemembering());
});
