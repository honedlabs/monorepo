<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasValue;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->test = new class()
    {
        use HasValue;
    };
});

it('sets', function () {
    expect($this->test)
        ->getValue()->toBeNull()
        ->value('test')->toBe($this->test)
        ->getValue()->toBe('test');
});

it('normalizes values', function () {
    expect($this->test)
        ->normalizeValue(Carbon::now())->toBe(Carbon::now()->format('Y-m-d\TH:i:s'))
        ->normalizeValue(new class() implements Arrayable
        {
            public function toArray(): array
            {
                return ['test' => 'test'];
            }
        })->toBe(['test' => 'test'])
        ->normalizeValue('test')->toBe('test');
});

it('gets normalized value', function () {
    $this->test->value('test');

    expect($this->test)
        ->getNormalizedValue()->toBe('test')
        ->value(Carbon::now())->toBe($this->test)
        ->getNormalizedValue()->toBe(Carbon::now()->format('Y-m-d\TH:i:s'));
});