<?php

declare(strict_types=1);

use Honed\Upload\UploadRule;
use Honed\Upload\Concerns\HasFileRules;

beforeEach(function () {
    $this->test = new class {
        use HasFileRules;
    };
});

it('has rules', function () {
    expect($this->test)
        ->getRules()->toBeEmpty()
        ->rules(UploadRule::make('image/png'))->toBe($this->test)
        ->getRules()->toHaveCount(1)
        ->rules([UploadRule::make('image/jpeg')])->toBe($this->test)
        ->getRules()->toHaveCount(2);
});

it('validates', function () {
    $request = presignRequest('test.png', 'image/png', 1000);

    $this->test->validate($request);
});
