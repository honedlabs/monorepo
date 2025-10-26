<?php

declare(strict_types=1);

use App\Enums\Status;
use Honed\Data\Normalizers\EnumNormalizer;

beforeEach(function () {
    $this->normalizer = new EnumNormalizer();
});

it('normalizes', function (mixed $input, mixed $expected) {
    expect($this->normalizer)
        ->normalize($input)->toBe($expected);
})->with([
    [Status::Available, ['label' => Status::Available->name, 'value' => Status::Available->value]],
    [Status::ComingSoon, ['label' => Status::ComingSoon->name, 'value' => Status::ComingSoon->value]],
    ['string', null],
    [null, null],
    [new stdClass(), null],
    [1, null],
    [[], null],
]);