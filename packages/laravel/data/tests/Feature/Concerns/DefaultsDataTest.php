<?php

declare(strict_types=1);

use Honed\Data\Concerns\DefaultsData;
use Honed\Data\Contracts\Defaultable;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->data = new class() extends Data implements Defaultable
    {
        use DefaultsData;

        public ?string $value = null;

        public static function getDefaults(): array
        {
            return [
                'value' => 'default',
            ];
        }
    };
});

it('has defaults', function () {
    expect($this->data::getDefaults())->toEqual([
        'value' => 'default',
    ]);
});

// it('sets defaults', function () {
//     expect($this->data::empty())->toEqual([
//         'value' => 'default',
//     ]);
// });
