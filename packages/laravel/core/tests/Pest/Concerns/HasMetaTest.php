<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasMeta;

class HasMetaComponent
{
    use Evaluable;
    use HasMeta;
}

beforeEach(function () {
    $this->component = new HasMetaComponent;
});

it('is empty by default', function () {
    expect($this->component)
        ->getMeta()->toBeEmpty()
        ->hasMeta()->toBeFalse();
});

it('sets meta', function () {
    $this->component->setMeta(['meta' => 'Meta']);
    expect($this->component)
        ->getMeta()->toEqual(['meta' => 'Meta'])
        ->hasMeta()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setMeta(['meta' => 'Meta']);
    $this->component->setMeta(null);
    expect($this->component)
        ->getMeta()->toEqual(['meta' => 'Meta'])
        ->hasMeta()->toBeTrue();
});

it('chains meta', function () {
    expect($this->component->meta(['meta' => 'Meta']))->toBeInstanceOf(HasMetaComponent::class)
        ->getMeta()->toEqual(['meta' => 'Meta'])
        ->hasMeta()->toBeTrue();
});

it('resolves meta', function () {
    expect($this->component->meta(fn ($record) => ['meta' => $record]))
        ->toBeInstanceOf(HasMetaComponent::class)
        ->resolveMeta(['record' => 'Meta'])->toEqual(['meta' => 'Meta'])
        ->getMeta()->toEqual(['meta' => 'Meta']);
});
