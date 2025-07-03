<?php

declare(strict_types=1);

use Workbench\App\Classes\Component;

beforeEach(function () {
    $this->component = Component::make();
});

afterEach(function () {
    $this->component::encoder(null);
    $this->component::decoder(null);
});

it('encodes using base64', function () {
    $encoded = $this->component::encode('test');

    expect($encoded)->toBeString();

    $decoded = $this->component::decode($encoded);

    expect($decoded)->toBe('test');
});

it('encodes using custom encoder', function () {
    $this->component::encoder(fn ($value) => encrypt($value));
    $this->component::decoder(fn ($value) => decrypt($value));

    $encoded = $this->component::encode('test');

    expect($encoded)->toBeString();

    $decoded = $this->component::decode($encoded);

    expect($decoded)->toBe('test');
});

it('gets id', function () {
    expect($this->component->getId())->toBe($this->component::encode($this->component::class));
});
