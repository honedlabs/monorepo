<?php

declare(strict_types=1);

use Honed\Upload\Concerns\HasFilePath;
use Honed\Upload\Contracts\ShouldAnonymize;

beforeEach(function () {
    $this->test = new class {
        use HasFilePath;
    };
});

it('has disk', function () {
    expect($this->test)
        ->getDisk()->toBe(config('upload.disk'))
        ->disk('r2')->toBe($this->test)
        ->getDisk()->toBe('r2');
});

it('has path', function () {
    expect($this->test)
        ->getPath()->toBeNull()
        ->path('test')->toBe($this->test)
        ->getPath()->toBe('test');
});

it('has name', function () {
    expect($this->test)
        ->getName()->toBeNull()
        ->name('test')->toBe($this->test)
        ->getName()->toBe('test');
});

it('anonymizes', function () {
    expect($this->test)
        ->isAnonymized()->toBeFalse()
        ->anonymize()->toBe($this->test)
        ->isAnonymized()->toBeTrue()
        ->isAnonymizedByDefault()->toBeFalse();

    $test = new class implements ShouldAnonymize {
        use HasFilePath;
        
        public function __construct() {}
    };

    expect($test)
        ->isAnonymized()->toBeTrue();
});

it('gets folder', function (string $path, ?string $expected) {
    expect($this->test)
        ->getFolder($path)->toBe($expected);
})->with([
    ['test.txt', null],
    ['parent/test.txt', 'parent'],
    ['root/grandparent/parent/test.txt', 'parent'],
]);
