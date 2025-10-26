<?php

declare(strict_types=1);

use Honed\Data\Rules\Recaptcha;

beforeEach(function () {
    $this->rule = new Recaptcha('127.0.0.1');
});

it('calls api', function () {
    expect($this->rule->isValid('test'))->toBeFalse();
});

