<?php

declare(strict_types=1);

use Honed\Core\Concerns\CanHaveIcon;
use Honed\Core\Concerns\Evaluable;
use Workbench\App\Enums\Status;

beforeEach(function () {
    $this->test = new class()
    {
        use CanHaveIcon, Evaluable;
    };
});

it('sets', function () {
    expect($this->test)
        ->getIcon()->toBeNull()
        ->hasIcon()->toBeFalse()
        ->icon('icon')->toBe($this->test)
        ->getIcon()->toBe('icon')
        ->hasIcon()->toBeTrue();
});

it('sets as enum', function () {
    expect($this->test)
        ->getIcon()->toBeNull()
        ->hasIcon()->toBeFalse()
        ->icon(Status::ComingSoon)->toBe($this->test)
        ->getIcon()->toBe(Status::ComingSoon->value)
        ->hasIcon()->toBeTrue();
});

it('sets as closure', function () {
    expect($this->test)
        ->getIcon()->toBeNull()
        ->hasIcon()->toBeFalse()
        ->icon(fn () => 'icon')->toBe($this->test)
        ->getIcon()->toBe('icon')
        ->hasIcon()->toBeTrue();
});
