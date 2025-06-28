<?php

declare(strict_types=1);

use Workbench\App\Classes\Component;

beforeEach(function () {
    $this->component = Component::make();
})->only();

it('sets persist key', function () {
    expect($this->component)
        ->getPersistKey()->toBe('component')
        ->persistKey('test')
        ->getPersistKey()->toBe('test');
});
