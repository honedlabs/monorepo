<?php

declare(strict_types=1);

use Honed\Core\Contracts\Icon;
use Honed\Core\Concerns\HasIcon;

class IconTest
{
    use HasIcon;
}

enum IconEnum implements Icon
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
        ->icon()->toBeNull()
        ->hasIcon()->toBeFalse();
});

it('sets', function () {
    expect($this->test->icon('test'))
        ->toBeInstanceOf(IconTest::class)
        ->icon()->toBe('test')
        ->hasIcon()->toBeTrue();
});

it('gets', function () {
    expect($this->test->icon('test'))
        ->icon()->toBe('test')
        ->hasIcon()->toBeTrue();
});

it('gets icon interface', function () {
    expect($this->test->icon(IconEnum::Chevron))->toBeInstanceOf(IconTest::class)
        ->icon()->toBe('chevron')
        ->hasIcon()->toBeTrue();
});
