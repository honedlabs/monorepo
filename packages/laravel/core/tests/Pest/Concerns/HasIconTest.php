<?php

declare(strict_types=1);

use Honed\Core\Contracts\IsIcon;
use Honed\Core\Concerns\HasIcon;

class IconTest
{
    use HasIcon;
}

enum IconEnum implements IsIcon
{
    case Chevron;

    public function icon(): string
    {
        return 'chevron';
    }
}

beforeEach(function () {
    $this->test = new IconTest;
});

it('is null by default', function () {
    expect($this->test)
        ->hasIcon()->toBeFalse();
});

it('sets', function () {
    expect($this->test->icon('test'))
        ->toBeInstanceOf(IconTest::class)
        ->hasIcon()->toBeTrue();
});

it('gets', function () {
    expect($this->test->icon('test'))
        ->getIcon()->toBe('test')
        ->hasIcon()->toBeTrue();
});

it('gets icon interface', function () {
    expect($this->test->icon(IconEnum::Chevron))->toBeInstanceOf(IconTest::class)
        ->getIcon()->toBe('chevron')
        ->hasIcon()->toBeTrue();
});
