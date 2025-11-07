<?php

declare(strict_types=1);

use Honed\Form\Components\Lookup;
use Honed\Form\Enums\FormComponent;
use Honed\Form\Exceptions\RouteNotSetException;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->component = Lookup::make('user');
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Lookup)
        ->getComponent()->toBe(FormComponent::Lookup->value);
});

it('has method', function () {
    expect($this->component)
        ->getMethod()->toBe(mb_strtolower(Request::METHOD_GET))
        ->method(Request::METHOD_POST)->toBe($this->component)
        ->getMethod()->toBe(mb_strtolower(Request::METHOD_POST));
});

it('has url', function () {
    expect($this->component)
        ->getUrl()->toBe(null)
        ->url('https://example.com')->toBe($this->component)
        ->getUrl()->toBe('https://example.com');
});

it('has array representation', function () {
    expect($this->component)
        ->url('https://example.com')->toBe($this->component)
        ->toArray()->toEqualCanonicalizing([
            'name' => 'user',
            'label' => 'User',
            'component' => FormComponent::Lookup->value,
            'url' => 'https://example.com',
            'method' => mb_strtolower(Request::METHOD_GET),
        ]);
});

it('throws exception if url is not set', function () {
    $this->component->toArray();
})->throws(RouteNotSetException::class);