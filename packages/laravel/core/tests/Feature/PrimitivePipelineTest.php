<?php

declare(strict_types=1);

use Honed\Core\Exceptions\PipeNotFoundException;
use Honed\Core\PrimitivePipeline;
use Workbench\App\Classes\Component;
use Workbench\App\Pipes\SetMeta;
use Workbench\App\Pipes\SetName;
use Workbench\App\Pipes\SetType;

beforeEach(function () {
    $this->pipeline = PrimitivePipeline::make();
});

it('sets pipes', function () {
    expect($this->pipeline)
        ->throughAll(SetType::class)
        ->toBe($this->pipeline)
        ->getPipes()->toBe([
            SetType::class,
        ])
        ->throughAll([SetType::class, SetName::class])->toBe($this->pipeline)
        ->getPipes()->toBe([
            SetType::class,
            SetName::class,
        ]);
});

it('appends pipes', function () {
    expect($this->pipeline)
        ->through(SetType::class)->toBe($this->pipeline)
        ->through(SetName::class)->toBe($this->pipeline)
        ->getPipes()->toBe([
            SetType::class,
            SetName::class,
        ]);
});

it('sets first pipe', function () {
    expect($this->pipeline)
        ->firstThrough(SetType::class)->toBe($this->pipeline)
        ->firstThrough(SetName::class)->toBe($this->pipeline)
        ->getPipes()->toBe([
            SetName::class,
            SetType::class,
        ]);
});

it('sets last pipe', function () {
    expect($this->pipeline)
        ->lastThrough(SetType::class)->toBe($this->pipeline)
        ->lastThrough(SetName::class)->toBe($this->pipeline)
        ->getPipes()->toBe([
            SetType::class,
            SetName::class,
        ]);
});

it('sets through after pipe', function () {
    expect($this->pipeline)
        ->throughAll(SetType::class, SetName::class)
        ->throughAfter(SetMeta::class, SetType::class)->toBe($this->pipeline)
        ->getPipes()->toBe([
            SetType::class,
            SetMeta::class,
            SetName::class,
        ])
        ->throughAfter(SetMeta::class, SetMeta::class)->toBe($this->pipeline)
        ->getPipes()->toBe([
            SetType::class,
            SetMeta::class,
            SetMeta::class,
            SetName::class,
        ]);
});

it('sets through before pipe', function () {
    expect($this->pipeline)
        ->throughAll(SetType::class, SetName::class)
        ->throughBefore(SetMeta::class, SetName::class)->toBe($this->pipeline)
        ->getPipes()->toBe([
            SetType::class,
            SetMeta::class,
            SetName::class,
        ])
        ->throughBefore(SetMeta::class, SetType::class)->toBe($this->pipeline)
        ->getPipes()->toBe([
            SetMeta::class,
            SetType::class,
            SetMeta::class,
            SetName::class,
        ]);
});

it('throws exception if pipe not found after', function () {
    $this->pipeline->throughAfter(SetMeta::class, SetName::class);
})->throws(PipeNotFoundException::class);

it('throws exception if pipe not found before', function () {
    $this->pipeline->throughBefore(SetMeta::class, SetName::class);
})->throws(PipeNotFoundException::class);

it('marks as completed', function () {
    expect($this->pipeline)
        ->isCompleted()->toBeFalse()
        ->handle(Component::make())->toBe($this->pipeline)
        ->isCompleted()->toBeTrue()
        ->handle(Component::make())->toBe($this->pipeline)
        ->isCompleted()->toBeTrue()
        ->reset()->toBe($this->pipeline)
        ->isCompleted()->toBeFalse();
});

it('handles pipeline', function () {
    $component = Component::make();

    expect($this->pipeline)
        ->through(SetName::class)
        ->handle($component)->toBe($this->pipeline)
        ->isCompleted()->toBeTrue()
        ->getPipes()->toBe([
            SetName::class,
        ]);

    expect($component)
        ->getName()->toBe('Executed');
});
