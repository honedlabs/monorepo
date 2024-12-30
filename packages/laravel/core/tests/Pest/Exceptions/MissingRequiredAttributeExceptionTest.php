<?php

use Honed\Core\Exceptions\MissingRequiredAttributeException;

it('can create a missing require attrbiute exception without class', function () {
    $exception = new MissingRequiredAttributeException('key');
    expect($exception->getMessage())->toContain('key');
});

it('can throw a missing require attrbiute exception', function () {
    throw new MissingRequiredAttributeException('key');
})->throws(MissingRequiredAttributeException::class);
