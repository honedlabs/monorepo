<?php

use Honed\Core\Concerns\Encodable;

class EncodableComponent
{
    use Encodable;
}

beforeEach(function () {
    $this->component = new EncodableComponent;
    EncodableComponent::setEncoder();
    EncodableComponent::setDecoder();
});

it('encodes with default encryption', function () {
    // Can never be the same
    expect($this->component->encode('secret-value'))->not->toBe(encrypt('secret-value'));
});

it('decodes with default encryption', function () {
    expect($this->component->decode(encrypt('secret-value')))->toBe('secret-value');
});

it('encodes with custom encoder', function () {
    EncodableComponent::setEncoder(fn ($value) => \base64_encode($value));
    EncodableComponent::setDecoder(fn ($value) => \base64_decode($value));

    $value = 'test-value';
    $encoded = EncodableComponent::encode($value);

    expect($encoded)->toBe(\base64_encode($value));
    expect(EncodableComponent::decode($encoded))->toBe($value);
});

it('can encode and decode class names', function () {
    $encoded = EncodableComponent::encodeClass();
    $decoded = EncodableComponent::decodeClass($encoded);

    expect($decoded)->toBe(EncodableComponent::class);
});
