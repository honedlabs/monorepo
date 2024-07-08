<?php

use Conquest\Core\Identifier\Identifier;

beforeEach(function () {
    Identifier::reset();
    Identifier::setGlobalPrefix('id_');
});

it('can generate an incrementing', function () {
    $id = Identifier::generate();
    expect($id)->toBeString();
    expect(Identifier::getId())->toBe(1);
});

it('has a prefix', function () {
    expect(Identifier::getPrefix())->toBe('id_');
});

it('can change the prefix globally', function () {
    Identifier::setGlobalPrefix($p = 'prefix_');
    expect(Identifier::getPrefix())->toBe($p);
});

it('can reset the id', function () {
    Identifier::generate();
    expect(Identifier::getId())->toBe(1);
    Identifier::reset();
    expect(Identifier::getId())->toBe(0);
});