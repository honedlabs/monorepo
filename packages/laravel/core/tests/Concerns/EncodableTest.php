<?php

use Workbench\App\Component;

beforeEach(function () {
    $this->component = new Component;

    // Reset encoders/decoders before each test
    Component::setEncoder(null);
    Component::setDecoder(null);
});

test('it can encode and decode values using default encryption', function () {
    $value = 'secret-value';
    $encoded = Component::encode($value);

    expect($encoded)->not->toBe($value);
    expect(Component::decode($encoded))->toBe($value);
});

test('it can use custom encoder and decoder', function () {
    Component::setEncoder(fn ($value) => base64_encode($value));
    Component::setDecoder(fn ($value) => base64_decode($value));

    $value = 'test-value';
    $encoded = Component::encode($value);

    expect($encoded)->toBe(base64_encode($value));
    expect(Component::decode($encoded))->toBe($value);
});

test('it can encode and decode class names', function () {
    $encoded = Component::encodeClass();
    $decoded = Component::decodeClass($encoded);

    expect($decoded)->toBe(Component::class);
});

test('it can use custom encoder and decoder for class names', function () {
    Component::setEncoder(fn ($value) => strrev($value));
    Component::setDecoder(fn ($value) => strrev($value));

    $encoded = Component::encodeClass();

    expect($encoded)->toBe(strrev(Component::class));
    expect(Component::decodeClass($encoded))->toBe(Component::class);
});

test('encoder and decoder can be changed at runtime', function () {
    // Start with base64
    Component::setEncoder(fn ($value) => base64_encode($value));
    Component::setDecoder(fn ($value) => base64_decode($value));

    $value = 'test-value';
    $encoded = Component::encode($value);
    expect($encoded)->toBe(base64_encode($value));

    // Switch to reverse string
    Component::setEncoder(fn ($value) => strrev($value));
    Component::setDecoder(fn ($value) => strrev($value));

    $newEncoded = Component::encode($value);
    expect($newEncoded)->toBe(strrev($value));
});
