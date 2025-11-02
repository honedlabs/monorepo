<?php

declare(strict_types=1);

namespace Tests\Feature\Concerns;

use Honed\Form\Components\DateField;
use Honed\Form\Form;

beforeEach(function () {
    $this->form = DateField::make('start_at');
});

it('has format', function () {
    expect($this->form)
        ->getFormat()->toBeNull()
        ->hasFormat()->toBeFalse()
        ->missingFormat()->toBeTrue()
        ->format('Y-m-d')->toBe($this->form)
        ->getFormat()->toBe('Y-m-d')
        ->hasFormat()->toBeTrue()
        ->missingFormat()->toBeFalse()
        ->format(null)->toBe($this->form)
        ->getFormat()->toBeNull()
        ->hasFormat()->toBeFalse()
        ->missingFormat()->toBeTrue()
        ->format(fn () => 'Y-m-d')->toBe($this->form)
        ->getFormat()->toBe('Y-m-d')
        ->hasFormat()->toBeTrue()
        ->missingFormat()->toBeFalse();
});
