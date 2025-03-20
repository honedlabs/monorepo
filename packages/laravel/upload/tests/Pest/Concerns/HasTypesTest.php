<?php

declare(strict_types=1);

use Honed\Upload\Concerns\HasTypes;

beforeEach(function () {
    $this->test = new class {
        use HasTypes;
    };
});

it('has types', function () {
    expect($this->test)
        ->getTypes()->toBeEmpty()
        ->types('image/png', 'image/jpeg')->toBe($this->test)
        ->getTypes()->toBe(['image/png', 'image/jpeg'])
        ->types(['image/gif'])->toBe($this->test)
        ->getTypes()->toBe(['image/png', 'image/jpeg', 'image/gif']);
});

it('separates mimes and extensions', function () {
    expect($this->test)
        ->types('image/png', '.jpeg')->toBe($this->test)
        ->getMimes()->toBe(['image/png'])
        ->getExtensions()->toBe(['.jpeg']);
        
});




