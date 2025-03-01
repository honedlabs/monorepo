<?php

declare(strict_types=1);

namespace Honed\Refine\Tests\Pest;

use Carbon\Carbon;
use Honed\Core\CoreServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

it('has safe macro', function ($param, $value, $expected) {
    $p = 'param';

    expect(generateRequest($p.$param, $value))
        ->safe($p)->toBe($expected);

})->with([
    ['', '', null],
    ['', 'value', 'value'],
    ['[]', 'value', 'value'],
    ['[][]', 'value', 'value'],
    ['[1]', 'value', 'value'],
    ['[key]', 'value', 'value'],
    ['[key][1]', 'value', 'value'],
]);

it('has safeString macro', function ($param, $value, $expected) {
    $p = 'param';

    expect(generateRequest($p.$param, $value)->safeString($p))
        ->toBeInstanceOf(Stringable::class)
        ->toString()->toBe($expected);
})->with([
    ['', '', ''],
    ['', 'value', 'value'],
    ['[]', 'value', 'value'],
    ['', 5, '5'],
    ['', '', ''],
]);

it('has safeInteger macro', function ($param, $value, $expected) {
    $p = 'param';

    expect(generateRequest($p.$param, $value)->safeInteger($p))
        ->toBeInt()
        ->toBe($expected);
})->with([
    ['', '', 0],
    ['', 'value', 0],
    ['', 5, 5],
    ['', '5', 5],
    ['[]', '5', 5],
    ['', '5.5', 5],
]);

it('has safeFloat macro', function ($param, $value, $expected) {
    $p = 'param';

    expect(generateRequest($p.$param, $value)->safeFloat($p))
        ->toBeFloat()
        ->toBe($expected);
})->with([
    ['', '', 0.0],
    ['', 'value', 0.0],
    ['', 5, 5.0],
    ['', '5', 5.0],
    ['[]', '5', 5.0],
    ['', '5.5', 5.5],
]);

it('has safeBoolean macro', function ($param, $value, $expected) {
    $p = 'param';

    expect(generateRequest($p.$param, $value)->safeBoolean($p))
        ->toBeBool()
        ->toBe($expected);
})->with([
    ['', '', false],
    ['', 'value', false],
    ['', '1', true],
    ['', 'true', true],
    ['[]', 'yes', true],
]);

it('has safeDate macro', function ($param, $value, $expected) {
    $p = 'param';

    if (\is_null($expected)) {
        expect(generateRequest($p.$param, $value)->safeDate($p))
            ->toBeNull();
    } else {
        expect(generateRequest($p.$param, $value)->safeDate($p))
            ->toBeInstanceOf($expected);
    }
})->with([
    ['', '', null],
    ['', 'value', null],
    ['', 1, null],
    ['', '2000-01-01', Carbon::class],
    ['[]', '2000-01-01', Carbon::class],
]);

it('has safeArray macro', function ($param, $value, $expected) {
    $p = 'param';

    if (\is_null($expected)) {
        expect(generateRequest($p.$param, $value)->safeArray($p))
            ->toBeNull();
    } else {
        expect(generateRequest($p.$param, $value)->safeArray($p))
            ->toBeInstanceOf(Collection::class)
            ->all()->toEqual($expected);
    }
})->with([
    ['', '', null],
    ['', 'value', ['value']],
    ['', '1', [1]],
    ['', 'true', [true]],
]);

it('has safeScoped macro', function ($param, $value, $expected) {
    $p = 'param';
    $scope = 'scope';

    $scoped = \sprintf('%s%s%s%s',
        $scope, CoreServiceProvider::SCOPE_DELIMITER, $p, $param);

    expect(generateRequest($scoped, $value))
        ->safeScoped($p, $scope)->toBe($expected);

})->with([
    ['', '', null],
    ['', 'value', 'value'],
    ['[]', 'value', 'value'],
    ['[][]', 'value', 'value'],
    ['[1]', 'value', 'value'],
    ['[key]', 'value', 'value'],
    ['[key][1]', 'value', 'value'],
]);
