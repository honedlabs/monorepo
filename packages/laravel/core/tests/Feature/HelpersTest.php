<?php

test('enum_value', function () {
    expect(enum_value('value'))->toBe('value');
});

test('attempt', function () {
    expect(attempt(fn () => 'value'))->toBe(['value', null]);
    expect(attempt(fn () => throw new Exception('error')))
        ->{0}->toBeNull()
        ->{1}->toBeInstanceOf(Exception::class);
});

