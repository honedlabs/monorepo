<?php

declare(strict_types=1);

use App\Models\User;
use Honed\Data\Contracts\QueryFrom;
use Honed\Data\Rules\RecordsExist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    User::factory(2)->create()->modelKeys();
});

describe('class string', function () {
    beforeEach(function () {
        $this->rule = new RecordsExist(User::class, 'id');
    });

    it('validates', function (mixed $input, bool $expected) {
        expect($this->rule)
            ->isValid($input)->toBe($expected);
    })->with([
        [1, true],
        [[1, 2], true],
        [3, false],
        [[1, 2, 3], false],
    ]);

    it('passes validator', function () {
        $validator = Validator::make([
            'value' => [1, 2],
        ], [
            'value' => [$this->rule],
        ]);

        expect($validator->fails())->toBeFalse();
    });

    it('fails validator', function () {
        $validator = Validator::make([
            'value' => [1, 2, 3],
        ], [
            'value' => [$this->rule],
        ]);

        expect($validator)
            ->fails()->toBeTrue()
            ->errors()
            ->scoped(fn ($bag) => $bag
                ->first('value')
                ->toBe('validation::validation.records_exist')
            );
    });
});

describe('model', function () {
    beforeEach(function () {
        $user = User::factory()->create();

        $this->rule = new RecordsExist($user, 'id');
    });

    it('validates', function (mixed $input, bool $expected) {
        expect($this->rule)
            ->isValid($input)->toBe($expected);
    })->with([
        [1, true],
        [[1, 2], true],
        [4, false],
        [[1, 2, 4], false],
    ]);
});

describe('builder', function () {
    beforeEach(function () {
        $this->rule = new RecordsExist(User::query()->where('id', '>', 1), 'id');
    });

    it('validates', function (mixed $input, bool $expected) {
        expect($this->rule)
            ->isValid($input)->toBe($expected);
    })->with([
        [2, true],
        [[2], true],
        [1, false],
        [[1, 2], false],
    ]);
});

describe('contract', function () {
    beforeEach(function () {
        $from = new class() implements QueryFrom
        {
            public function query(): Builder
            {
                return User::query()->whereKeyNot(2);
            }
        };

        $this->rule = new RecordsExist($from, 'id');
    });

    it('validates', function (mixed $input, bool $expected) {
        expect($this->rule)
            ->isValid($input)->toBe($expected);
    })->with([
        [1, true],
        [[1], true],
        [2, false],
        [[1, 2], false],
    ]);
});
