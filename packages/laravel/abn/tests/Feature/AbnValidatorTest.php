<?php

declare(strict_types=1);

use Honed\Abn\AbnValidator;

it('formats', function () {
    // Valid ABN is formatted
    expect(AbnValidator::format('12345678901'))->toBe('12 345 678 901');

    // Invalid ABN is not formatted
    expect(AbnValidator::format('123456789'))->toBe('123456789');

    // Null ABN is not formatted
    expect(AbnValidator::format(null))->toBeNull();
});

it('fakes ABN', function () {
    $abn = AbnValidator::fake();

    expect(mb_strlen($abn))->toBe(11);
});

it('fakes valid ABN', function () {
    $abn = AbnValidator::fake(true);

    expect(AbnValidator::validate($abn))->toBeTrue();
});

it('passes valid ABN', function () {
    $valid = '51 824 753 556';

    expect(AbnValidator::validate($valid))->toBeTrue();
    expect(AbnValidator::passes($valid))->toBeTrue();
    expect(AbnValidator::fails($valid))->toBeFalse();
});

it('fails due to leading zero', function () {
    $invalid = '01 234 567 890';

    expect(AbnValidator::validate($invalid))->toBeFalse();
    expect(AbnValidator::passes($invalid))->toBeFalse();
    expect(AbnValidator::fails($invalid))->toBeTrue();
});

it('fails due to invalid length', function () {
    $invalid = '1234567890';

    expect(AbnValidator::validate($invalid))->toBeFalse();
    expect(AbnValidator::passes($invalid))->toBeFalse();
    expect(AbnValidator::fails($invalid))->toBeTrue();
});

it('fails due to invalid checksum', function () {
    $invalid = '12345678901';

    expect(AbnValidator::validate($invalid))->toBeFalse();
    expect(AbnValidator::passes($invalid))->toBeFalse();
    expect(AbnValidator::fails($invalid))->toBeTrue();
});

it('fails non-string ABN', function () {
    $invalid = 12345678901;

    expect(AbnValidator::validate($invalid))->toBeFalse();
    expect(AbnValidator::passes($invalid))->toBeFalse();
    expect(AbnValidator::fails($invalid))->toBeTrue();
});
