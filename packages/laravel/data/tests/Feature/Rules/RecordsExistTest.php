<?php

declare(strict_types=1);

use App\Models\User;
use Honed\Data\Rules\RecordExists;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\Data;

beforeEach(function () {
    User::factory(5)->create();

    // dd(User::all());
});

// describe('model class string', function () {
//     beforeEach(function () {
//         $this->rule = new RecordExists(User::class);
//     });
//     it('validates', function ($input, bool $expected) {
//         expect($this->rule)
//             ->isValid($input)->toBe($expected);
//     })->with([
//     ]);

//     it('passes validator', function () {
//         $validator = Validator::make([
//             'value' => [1, 2, 3],
//         ], [
//             'value' => [$this->rules],
//         ]);

//         expect($validator->fails())->toBeFalse();
//     });

//     it('fails validator', function () {
//         $validator = Validator::make([
//             'value' => new stdClass(),
//         ], [
//             'value' => [$this->rules],
//         ]);

//         expect($validator)
//             ->fails()->toBeTrue()
//             ->errors()
//             ->scoped(fn ($bag) => $bag
//                 ->first('value')
//                 ->toBe('validation::validation.RecordExists')
//             );
//     });
// });
