<?php

declare(strict_types=1);

use Honed\Scaffold\Concerns\InteractsWithSystem;

beforeEach(function () {
    $this->class = new class()
    {
        use InteractsWithSystem;
    };

    $this->phpVersion = (float) phpversion();

    $this->laravelVersion = (float) app()->version();
});

it('checks PHP version', function (mixed $version, bool $expected) {
    expect($this->class->isPhp($version))
        ->toBe($expected);
})->with([
    fn () => [$this->phpVersion, true],
    fn () => [$this->phpVersion + 0.1, false],
    fn () => [$this->phpVersion - 0.1, true],
]);

it('checks Laravel version', function (mixed $version, bool $expected) {
    expect($this->class->isLaravel($version))
        ->toBe($expected);
})->with([
    fn () => [$this->laravelVersion, true],
    fn () => [$this->laravelVersion + 0.1, false],
    fn () => [$this->laravelVersion - 0.1, true],
]);
