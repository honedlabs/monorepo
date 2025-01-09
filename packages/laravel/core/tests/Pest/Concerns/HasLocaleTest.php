<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasLocale;

class LocaleTest
{
    use HasLocale;
}

beforeEach(function () {
    $this->test = new LocaleTest;
});

it('is null by default', function () {
    expect($this->test)
        ->locale()->toBeNull()
        ->hasLocale()->toBeFalse();
});

it('sets', function () {
    expect($this->test->locale('test'))
        ->toBeInstanceOf(LocaleTest::class)
        ->locale()->toBe('test')
        ->hasLocale()->toBeTrue();
});

it('gets', function () {
    expect($this->test->locale('test'))
        ->locale()->toBe('test')
        ->hasLocale()->toBeTrue();
});