<?php

declare(strict_types=1);

use App\Enums\Locale;
use App\Enums\Status;
use Honed\Option\Option;
use Honed\Option\OptionBuilder;

beforeEach(function () {});

it('creates options', function ($value, $label, $oValue, $oLabel) {
    expect(OptionBuilder::from($value, $label))
        ->toBeInstanceOf(Option::class)
        ->getValue()->toBe($oValue)
        ->getLabel()->toBe($oLabel);
})->with([
    'basic' => [1, 'One', 1, 'One'],
    'string value with string label' => ['test', 'Test Label', 'test', 'Test Label'],
    'float value with string label' => [3.14, 'Pi', 3.14, 'Pi'],
    'boolean true with string label' => [true, 'True', true, 'True'],
    'boolean false with string label' => [false, 'False', false, 'False'],
    'null value with string label' => [null, 'Null Value', null, 'Null Value'],
    'integer value without label' => [1, null, 1, '1'],
    'string value without label' => ['test', null, 'test', 'test'],
    'float value without label' => [3.14, null, 3.14, '3.14'],
    'boolean true without label' => [true, null, true, '1'],
    'boolean false without label' => [false, null, false, ''],
    'null value without label' => [null, null, null, ''],
    // 'integer value with BackedEnum label' => [1, Status::Available, 1, 'Available'],
    // 'string value with BackedEnum label' => ['test', Status::Unavailable, 'test', 'Unavailable'],
    // 'float value with BackedEnum label' => [3.14, Status::ComingSoon, 3.14, 'ComingSoon'],
    // 'integer value with HasLabel label' => [1, Locale::En, 1, 'English'],
    // 'string value with HasLabel label' => ['test', Locale::Es, 'test', 'Spanish'],
    // 'float value with HasLabel label' => [3.14, Locale::En, 3.14, 'English'],
    // 'BackedEnum value without label' => [Status::Available, null, 'available', 'Available'],
    // 'BackedEnum Unavailable without label' => [Status::Unavailable, null, 'unavailable', 'Unavailable'],
    // 'BackedEnum ComingSoon without label' => [Status::ComingSoon, null, 'coming-soon', 'ComingSoon'],
    // 'BackedEnum value with string label' => [Status::Available, 'Custom Available', 'available', 'Custom Available'],
    // 'BackedEnum Unavailable with string label' => [Status::Unavailable, 'Custom Unavailable', 'unavailable', 'Custom Unavailable'],
    // 'BackedEnum ComingSoon with string label' => [Status::ComingSoon, 'Custom Coming Soon', 'coming-soon', 'Custom Coming Soon'],
    // 'BackedEnum value with BackedEnum label' => [Status::Available, Status::Unavailable, 'available', 'Unavailable'],
    // 'BackedEnum Unavailable with BackedEnum label' => [Status::Unavailable, Status::ComingSoon, 'unavailable', 'ComingSoon'],
    // 'BackedEnum ComingSoon with BackedEnum label' => [Status::ComingSoon, Status::Available, 'coming-soon', 'Available'],
    // 'BackedEnum value with HasLabel label' => [Status::Available, Locale::En, 'available', 'English'],
    // 'BackedEnum Unavailable with HasLabel label' => [Status::Unavailable, Locale::Es, 'unavailable', 'Spanish'],
    // 'BackedEnum ComingSoon with HasLabel label' => [Status::ComingSoon, Locale::En, 'coming-soon', 'English'],
    // 'HasLabel value without label' => [Locale::En, null, 'en', 'English'],
    // 'HasLabel Es without label' => [Locale::Es, null, 'es', 'Spanish'],
    // 'HasLabel value with string label' => [Locale::En, 'Custom English', 'en', 'Custom English'],
    // 'HasLabel Es with string label' => [Locale::Es, 'Custom Spanish', 'es', 'Custom Spanish'],
    // 'HasLabel value with BackedEnum label' => [Locale::En, Status::Available, 'en', 'Available'],
    // 'HasLabel Es with BackedEnum label' => [Locale::Es, Status::Unavailable, 'es', 'Unavailable'],
    // 'HasLabel value with HasLabel label' => [Locale::En, Locale::Es, 'en', 'Spanish'],
    // 'HasLabel Es with HasLabel label' => [Locale::Es, Locale::En, 'es', 'English'],
    // 'Option instance with integer value' => [Option::make(1, 'One'), null, 1, 'One'],
    // 'Option instance with string value' => [Option::make('test', 'Test'), null, 'test', 'Test'],
    // 'Option instance with BackedEnum value' => [Option::make(Status::Available, 'Custom'), null, 'available', 'Custom'],
]);

it('creates options from a list', function ($value, $expected) {
    $options = OptionBuilder::list($value);

    expect($options)
        ->toBeArray()
        ->toHaveCount(count($expected));

    foreach ($options as $index => $option) {
        expect($option)
            ->toBeInstanceOf(Option::class)
            ->getValue()->toBe($expected[$index]['value'])
            ->getLabel()->toBe($expected[$index]['label']);
    }
})->with([
    'list of integers' => [
        [1, 2, 3],
        [
            ['value' => 1, 'label' => '1'],
            ['value' => 2, 'label' => '2'],
            ['value' => 3, 'label' => '3'],
        ],
    ],
    'list of strings' => [
        ['one', 'two', 'three'],
        [
            ['value' => 'one', 'label' => 'one'],
            ['value' => 'two', 'label' => 'two'],
            ['value' => 'three', 'label' => 'three'],
        ],
    ],
    'list of floats' => [
        [1.1, 2.2, 3.3],
        [
            ['value' => 1.1, 'label' => '1.1'],
            ['value' => 2.2, 'label' => '2.2'],
            ['value' => 3.3, 'label' => '3.3'],
        ],
    ],
    'list with booleans' => [
        [true, false],
        [
            ['value' => true, 'label' => '1'],
            ['value' => false, 'label' => ''],
        ],
    ],
    'list with null' => [
        [1, null, 'test'],
        [
            ['value' => 1, 'label' => '1'],
            ['value' => null, 'label' => ''],
            ['value' => 'test', 'label' => 'test'],
        ],
    ],
    'list with BackedEnum' => [
        [Status::Available, Status::Unavailable],
        [
            ['value' => 'available', 'label' => 'Available'],
            ['value' => 'unavailable', 'label' => 'Unavailable'],
        ],
    ],
    'list with HasLabel enum' => [
        [Locale::En, Locale::Es],
        [
            ['value' => 'en', 'label' => 'English'],
            ['value' => 'es', 'label' => 'Spanish'],
        ],
    ],
    'list with Option instances' => [
        [Option::make(1, 'One'), Option::make(2, 'Two')],
        [
            ['value' => 1, 'label' => 'One'],
            ['value' => 2, 'label' => 'Two'],
        ],
    ],
    'empty list' => [
        [],
        [],
    ],
]);

it('creates options from an enum', function ($enumClass, $expected) {
    $options = OptionBuilder::enum($enumClass);

    expect($options)
        ->toBeArray()
        ->toHaveCount(count($expected));

    foreach ($options as $index => $option) {
        expect($option)
            ->toBeInstanceOf(Option::class)
            ->getValue()->toBe($expected[$index]['value'])
            ->getLabel()->toBe($expected[$index]['label']);
    }
})->with([
    'Status enum' => [
        Status::class,
        [
            ['value' => 'available', 'label' => 'Available'],
            ['value' => 'unavailable', 'label' => 'Unavailable'],
            ['value' => 'coming-soon', 'label' => 'ComingSoon'],
        ],
    ],
    'Locale enum' => [
        Locale::class,
        [
            ['value' => 'en', 'label' => 'English'],
            ['value' => 'es', 'label' => 'Spanish'],
        ],
    ],
]);

it('creates options from an object', function ($value, $expected) {
    $options = OptionBuilder::object($value);

    expect($options)
        ->toBeArray()
        ->toHaveCount(count($expected));

    foreach ($options as $index => $option) {
        expect($option)
            ->toBeInstanceOf(Option::class)
            ->getValue()->toBe($expected[$index]['value'])
            ->getLabel()->toBe($expected[$index]['label']);
    }
})->with([
    'associative array with string keys and string values' => [
        ['one' => 'One', 'two' => 'Two', 'three' => 'Three'],
        [
            ['value' => 'one', 'label' => 'One'],
            ['value' => 'two', 'label' => 'Two'],
            ['value' => 'three', 'label' => 'Three'],
        ],
    ],
    'associative array with integer keys and string values' => [
        [1 => 'First', 2 => 'Second', 3 => 'Third'],
        [
            ['value' => 1, 'label' => 'First'],
            ['value' => 2, 'label' => 'Second'],
            ['value' => 3, 'label' => 'Third'],
        ],
    ],
    'associative array with string keys and HasLabel enum values' => [
        ['locale1' => Locale::En, 'locale2' => Locale::Es],
        [
            ['value' => 'locale1', 'label' => 'English'],
            ['value' => 'locale2', 'label' => 'Spanish'],
        ],
    ],
    'empty associative array' => [
        [],
        [],
    ],
]);

it('creates many options', function ($value, $expected) {
    $options = OptionBuilder::many($value);

    expect($options)
        ->toBeArray()
        ->toHaveCount(count($expected));

    foreach ($options as $index => $option) {
        expect($option)
            ->toBeInstanceOf(Option::class)
            ->getValue()->toBe($expected[$index]['value'])
            ->getLabel()->toBe($expected[$index]['label']);
    }
})->with([
    'enum class string' => [
        Status::class,
        [
            ['value' => 'available', 'label' => 'Available'],
            ['value' => 'unavailable', 'label' => 'Unavailable'],
            ['value' => 'coming-soon', 'label' => 'ComingSoon'],
        ],
    ],
    'list array' => [
        [1, 2, 3],
        [
            ['value' => 1, 'label' => '1'],
            ['value' => 2, 'label' => '2'],
            ['value' => 3, 'label' => '3'],
        ],
    ],
    'associative array' => [
        ['one' => 'One', 'two' => 'Two'],
        [
            ['value' => 'one', 'label' => 'One'],
            ['value' => 'two', 'label' => 'Two'],
        ],
    ],
    'Collection instance' => [
        collect([1, 2, 3]),
        [
            ['value' => 1, 'label' => '1'],
            ['value' => 2, 'label' => '2'],
            ['value' => 3, 'label' => '3'],
        ],
    ],
    'Collection instance with associative array' => [
        collect(['a' => 'A', 'b' => 'B']),
        [
            ['value' => 'a', 'label' => 'A'],
            ['value' => 'b', 'label' => 'B'],
        ],
    ],
]);
