<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasTitle;

class HasTitleComponent
{
    use HasTitle;
    use Evaluable;
}

beforeEach(function () {
    $this->component = new HasTitleComponent;
});

it('has no title by default', function () {
    expect($this->component)
        ->getTitle()->toBeNull()
        ->hasTitle()->toBeFalse();
});

it('sets title', function () {
    $this->component->setTitle('Title');
    expect($this->component)
        ->getTitle()->toBe('Title')
        ->hasTitle()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setTitle('Title');
    $this->component->setTitle(null);
    expect($this->component)
        ->getTitle()->toBe('Title')
        ->hasTitle()->toBeTrue();
});

it('chains title', function () {
    expect($this->component->title('Title'))->toBeInstanceOf(HasTitleComponent::class)
        ->getTitle()->toBe('Title')
        ->hasTitle()->toBeTrue();
});

it('resolves title', function () {
    expect($this->component->title(fn ($record) => $record.'.'))
        ->toBeInstanceOf(HasTitleComponent::class)
        ->resolveTitle(['record' => 'Title'])->toBe('Title.')
        ->getTitle()->toBe('Title.');
});
