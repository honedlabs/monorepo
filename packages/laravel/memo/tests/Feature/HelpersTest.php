<?php

declare(strict_types=1);

beforeEach(function () {});

it('memoizes', function () {
    memo('test', 'value');

    expect(memo_get('test'))->toBe('value');
});
