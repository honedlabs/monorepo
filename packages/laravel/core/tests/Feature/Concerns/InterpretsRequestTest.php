<?php

namespace Honed\Refine\Tests\Pest;

use Carbon\Carbon;
use Honed\Core\Concerns\InterpretsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

beforeEach(function () {
    $this->test = new class
    {
        use InterpretsRequest;
    };
});

it('can set the interpreter', function () {
    expect($this->test)
        ->interpretsAs()->toBeNull()
        ->interpretsRaw()->toBeTrue()
        ->asStringable()->toBe($this->test)
        ->interpretsStringable()->toBeTrue()
        ->interpretsAs()->toBe('stringable')
        ->asCollection()->toBe($this->test)
        ->interpretsCollection()->toBeTrue()
        ->interpretsAs()->toBe('collection')
        ->asArray()->toBe($this->test)
        ->interpretsArray()->toBeTrue()
        ->interpretsAs()->toBe('array')
        ->asBoolean()->toBe($this->test)
        ->interpretsBoolean()->toBeTrue()
        ->interpretsAs()->toBe('boolean')
        ->asFloat()->toBe($this->test)
        ->interpretsFloat()->toBeTrue()
        ->interpretsAs()->toBe('float')
        ->asInt()->toBe($this->test)
        ->interpretsInt()->toBeTrue()
        ->interpretsAs()->toBe('int')
        ->asString()->toBe($this->test)
        ->interpretsString()->toBeTrue()
        ->interpretsAs()->toBe('string')
        ->asDate()->toBe($this->test)
        ->interpretsDate()->toBeTrue()
        ->interpretsAs()->toBe('date')
        ->asDatetime()->toBe($this->test)
        ->interpretsDatetime()->toBeTrue()
        ->interpretsAs()->toBe('datetime')
        ->asTime()->toBe($this->test)
        ->interpretsTime()->toBeTrue()
        ->interpretsAs()->toBe('time');
});

it('interprets', function () {
    $request = Request::create('/', Request::METHOD_GET, [
        'p' => '5',
    ]);

    expect($this->test)
        ->interpret($request, 'p')->toBe('5')
        ->as('array')->interpret($request, 'p')->toEqual(['5'])
        ->as('int')->interpret($request, 'p')->toBe(5)
        ->as('string')->interpret($request, 'p')->toBe('5')
        ->as('stringable')->interpret($request, 'p')->toBeInstanceOf(Stringable::class)
        ->as('float')->interpret($request, 'p')->toBe(5.0)
        ->as('boolean')->interpret($request, 'p')->toBe(false)
        ->as('collection')->interpret($request, 'p')->toBeInstanceOf(Collection::class)
        ->as('datetime')->interpret($request, 'p')->toBeNull()
        ->as('date')->interpret($request, 'p')->toBeNull()
        ->as('time')->interpret($request, 'p')->toBeNull();
});

it('interprets raw', function ($param, $value, $expected) {
    $request = Request::create(\sprintf('?%s=%s', 'p'.$param, $value));

    expect($this->test->interpretRaw($request, 'p'))
        ->toBe($expected);

})->with([
    ['', '', null],
    ['', 'value', 'value'],
    ['[]', 'value', 'value'],
    ['[key]', 'value', 'value'],
]);

it('interprets array', function ($param, $value, $expected) {
    $request = Request::create(\sprintf('?%s=%s', 'p'.$param, $value));

    expect($this->test->interpretArray($request, 'p'))
        ->toBe($expected);
})->with([
    ['', '', null],
    ['', 'value', ['value']],
    ['[]', 'value', ['value']],
    ['[key]', 'value', ['value']],
    ['', 5, ['5']],
    ['', '1,2,3', ['1', '2', '3']],
]);

it('interprets boolean', function ($param, $value, $expected) {
    $request = Request::create(\sprintf('?%s=%s', 'p'.$param, $value));

    expect($this->test->interpretBoolean($request, 'p'))
        ->toBe($expected);

})->with([
    ['', '', null],
    ['', 'value', false],
    ['[]', 'yes', true],
    ['[key]', 'yes', true],
    ['', 'true', true],
    ['', 'false', false],
]);

it('interprets collection', function ($param, $value, $expected) {
    $request = Request::create(\sprintf('?%s=%s', 'p'.$param, $value));

    if (\is_null($expected)) {
        expect($this->test->interpretCollection($request, 'p'))
            ->toBeNull();
    } else {
        expect($this->test->interpretCollection($request, 'p'))
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

it('interprets date', function ($param, $value, $expected) {
    $request = Request::create(\sprintf('?%s=%s', 'p'.$param, $value));

    if (\is_null($expected)) {
        expect($this->test->interpretDate($request, 'p'))
            ->toBeNull();
    } else {
        expect($this->test->interpretDate($request, 'p'))
            ->toBeInstanceOf(Carbon::class);
    }
})->with([
    ['', '', null],
    ['', 'value', null],
    ['', 1, null],
    ['', '2000-01-01', Carbon::class],
    ['[]', '2000-01-01', Carbon::class],
]);

it('interprets float', function ($param, $value, $expected) {
    $request = Request::create(\sprintf('?%s=%s', 'p'.$param, $value));

    expect($this->test->interpretFloat($request, 'p'))
        ->toBe($expected);

})->with([
    ['', '', null],
    ['', 'value', 0.0],
    ['[]', 5, 5.0],
    ['[key]', 5, 5.0],
    ['', '5', 5.0],
    ['', '5.5', 5.5],
]);

it('interprets int', function ($param, $value, $expected) {
    $request = Request::create(\sprintf('?%s=%s', 'p'.$param, $value));

    expect($this->test->interpretInt($request, 'p'))
        ->toBe($expected);

})->with([
    ['', '', null],
    ['', 'value', 0],
    ['[]', 5, 5],
    ['[key]', 5, 5],
    ['', '5', 5],
]);

it('interprets string', function ($param, $value, $expected) {
    $request = Request::create(\sprintf('?%s=%s', 'p'.$param, $value));

    expect($this->test->interpretString($request, 'p'))
        ->toBe($expected);

})->with([
    ['', '', null],
    ['', 'value', 'value'],
    ['[]', 'value', 'value'],
    ['[key]', 'value', 'value'],
    ['', 5, '5'],
]);

it('interprets stringable', function ($param, $value, $expected) {
    $request = Request::create(\sprintf('?%s=%s', 'p'.$param, $value));

    if (\is_null($expected)) {
        expect($this->test->interpretStringable($request, 'p'))
            ->toBeNull();
    } else {
        expect($this->test->interpretStringable($request, 'p'))
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

it('has subtype', function () {
    expect($this->test)
        ->hasSubtype()->toBeFalse()
        ->subtype('string')->toBe($this->test)
        ->hasSubtype()->toBeTrue()
        ->getSubtype()->toBe('string');
});

it('interprets arrayables with subtype', function () {
    $arr = \implode(',', [1, 2, 3]);

    $request = Request::create('/', Request::METHOD_GET, [
        'p' => $arr,
    ]);

    expect($this->test)
        ->interpretArray($request, 'p', ',', 'int')->toBe([1, 2, 3])
        ->interpretArray($request, 'p', ',', 'float')->toBe([1.0, 2.0, 3.0])
        ->interpretArray($request, 'p', ',', 'string')->toBe(['1', '2', '3'])
        ->interpretArray($request, 'p', ',', 'boolean')->toBe([true, false, false]);
});
