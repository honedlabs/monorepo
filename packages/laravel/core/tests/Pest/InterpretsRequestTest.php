<?php

declare(strict_types=1);

namespace Honed\Refine\Tests\Pest;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use Honed\Core\Concerns\InterpretsRequest;

beforeEach(function () {
    $this->test = new class {
        use InterpretsRequest;
    };

    $this->param = 'param';
});

it('can set the interpreter', function () {
    expect($this->test)
        ->getAs()->toBeNull()
        ->interpretsRaw()->toBeTrue()
        ->asStringable()->toBe($this->test)
        ->interpretsStringable()->toBeTrue()
        ->getAs()->toBe('stringable')
        ->asCollection()->toBe($this->test)
        ->interpretsCollection()->toBeTrue()
        ->getAs()->toBe('collection')
        ->asArray()->toBe($this->test)
        ->interpretsArray()->toBeTrue()
        ->getAs()->toBe('array')
        ->asBoolean()->toBe($this->test)
        ->interpretsBoolean()->toBeTrue()
        ->getAs()->toBe('boolean')
        ->asFloat()->toBe($this->test)
        ->interpretsFloat()->toBeTrue()
        ->getAs()->toBe('float')
        ->asInteger()->toBe($this->test)
        ->interpretsInteger()->toBeTrue()
        ->getAs()->toBe('integer')
        ->asString()->toBe($this->test)
        ->interpretsString()->toBeTrue()
        ->getAs()->toBe('string')
        ->asDate()->toBe($this->test)
        ->interpretsDate()->toBeTrue()
        ->getAs()->toBe('date')
        ->asDatetime()->toBe($this->test)
        ->interpretsDatetime()->toBeTrue()
        ->getAs()->toBe('datetime')
        ->asTime()->toBe($this->test)
        ->interpretsTime()->toBeTrue()
        ->getAs()->toBe('time');
});

it('interprets using interpreter', function () {
    $request = generateRequest($this->param, '5');

    expect($this->test)
        ->interpret($request, $this->param)->toBe('5')
        ->as('integer')->toBe($this->test)
        ->interpret($request, $this->param)->toBe(5);
});

it('interprets raw', function ($param, $value, $expected) {
    $request = generateRequest($this->param.$param, $value);

    expect($this->test->interpretRaw($request, $this->param))
        ->toBe($expected);

})->with([
    ['', '', null],
    ['', 'value', 'value'],
    ['[]', 'value', 'value'],
    ['[key]', 'value', 'value'],
]);

it('interprets stringable', function ($param, $value, $expected) {
    $request = generateRequest($this->param.$param, $value);

    if (\is_null($expected)) {
        expect($this->test->interpretStringable($request, $this->param))
            ->toBeNull();
    } else {
        expect($this->test->interpretStringable($request, $this->param))
            ->toBeInstanceOf(Stringable::class)
            ->toString()->toBe($expected);
    }
})->with([
    ['', '', null],
    ['', 'value', 'value'],
    ['[]', 'value', 'value'],
    ['[key]', 'value', 'value'],
    ['', 5, '5'],
]);

it('interprets string', function ($param, $value, $expected) {
    $request = generateRequest($this->param.$param, $value);

    expect($this->test->interpretString($request, $this->param))
        ->toBe($expected);

})->with([
    ['', '', null],
    ['', 'value', 'value'],
    ['[]', 'value', 'value'],
    ['[key]', 'value', 'value'],
    ['', 5, '5'],
]);

it('interprets collection', function ($param, $value, $expected) {
    $request = generateRequest($this->param.$param, $value);

    if (\is_null($expected)) {
        expect($this->test->interpretCollection($request, $this->param))
            ->toBeNull();
    } else {
        expect($this->test->interpretCollection($request, $this->param))
            ->toBeInstanceOf(Collection::class)
            ->all()->toEqual($expected);
    }
})->with([
    ['', '', null],
    ['', 'value', ['value']],
    ['[]', 'value', ['value']],
    ['[key]', 'value', ['value']],
    ['', 5, ['5']],
    ['', '1,2,3', ['1', '2', '3']],
]);

it('interprets array', function ($param, $value, $expected) {
    $request = generateRequest($this->param.$param, $value);

    expect($this->test->interpretArray($request, $this->param))
        ->toBe($expected);
})->with([
    ['', '', null],
    ['', 'value', ['value']],
    ['[]', 'value', ['value']],
    ['[key]', 'value', ['value']],
    ['', 5, ['5']],
    ['', '1,2,3', ['1', '2', '3']],
]);

it('interprets integer', function ($param, $value, $expected) {
    $request = generateRequest($this->param.$param, $value);

    expect($this->test->interpretInteger($request, $this->param))
        ->toBe($expected);

})->with([
    ['', '', null],
    ['', 'value', 0],
    ['[]', 5, 5],
    ['[key]', 5, 5],
    ['', '5', 5],
]);

it('interprets float', function ($param, $value, $expected) {
    $request = generateRequest($this->param.$param, $value);

    expect($this->test->interpretFloat($request, $this->param))
        ->toBe($expected);

})->with([
    ['', '', null],
    ['', 'value', 0.0],
    ['[]', 5, 5.0],
    ['[key]', 5, 5.0],
    ['', '5', 5.0],
    ['', '5.5', 5.5],
]);

it('interprets boolean', function ($param, $value, $expected) {
    $request = generateRequest($this->param.$param, $value);

    expect($this->test->interpretBoolean($request, $this->param))
        ->toBe($expected);

})->with([
    ['', '', null],
    ['', 'value', false],
    ['[]', 'yes', true],
    ['[key]', 'yes', true],
    ['', 'true', true],
    ['', 'false', false],
]);

it('interprets date', function ($param, $value, $expected) {
    $request = generateRequest($this->param.$param, $value);

    if (\is_null($expected)) {
        expect($this->test->interpretDate($request, $this->param))
            ->toBeNull();
    } else {
        expect($this->test->interpretDate($request, $this->param))
            ->toBeInstanceOf(Carbon::class);
    }
})->with([
    ['', '', null],
    ['', 'value', null],
    ['', 1, null],
    ['', '2000-01-01', Carbon::class],
    ['[]', '2000-01-01', Carbon::class],
]);



// it('interprets date', function ($param, $value, $expected) {
//     $p = 'param';

//     if (\is_null($expected)) {
//         expect(generateRequest($p.$param, $value)->safeDate($p))
//             ->toBeNull();
//     } else {
//         expect(generateRequest($p.$param, $value)->safeDate($p))
//             ->toBeInstanceOf($expected);
//     }
// })->with([
//     ['', '', null],
//     ['', 'value', null],
//     ['', 1, null],
//     ['', '2000-01-01', Carbon::class],
//     ['[]', '2000-01-01', Carbon::class],
// ]);

// it('interprets array', function ($param, $value, $expected) {
//     $p = 'param';

//     if (\is_null($expected)) {
//         expect(generateRequest($p.$param, $value)->safeArray($p))
//             ->toBeNull();
//     } else {
//         expect(generateRequest($p.$param, $value)->safeArray($p))
//             ->toBeInstanceOf(Collection::class)
//             ->all()->toEqual($expected);
//     }
// })->with([
//     ['', '', null],
//     ['', 'value', ['value']],
//     ['', '1', [1]],
//     ['', 'true', [true]],
// ]);