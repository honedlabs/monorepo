<?php

declare(strict_types=1);

use Honed\Flash\Toast;

beforeEach(function () {
    $this->message = Toast::make();
});

it('has message', function () {
    expect($this->message)
        ->toBeInstanceOf(Toast::class)
        ->getMessage()->toBeNull()
        ->message('Test')->toBe($this->message)
        ->getMessage()->toBe('Test');
});

it('has type', function () {
    expect($this->message)
        ->getType()->toBeNull()
        ->type('other')->toBe($this->message)
        ->getType()->toBe('other')
        ->success()->toBe($this->message)
        ->getType()->toBe('success')
        ->error()->toBe($this->message)
        ->getType()->toBe('error')
        ->info()->toBe($this->message)
        ->getType()->toBe('info')
        ->warning()->toBe($this->message)
        ->getType()->toBe('warning');
});

it('has title', function () {
    expect($this->message)
        ->getTitle()->toBeNull()
        ->title('Test')->toBe($this->message)
        ->getTitle()->toBe('Test');
});

it('has duration', function () {
    expect($this->message)
        ->getDuration()->toBe(config('flash.duration'))
        ->duration(1000)->toBe($this->message)
        ->getDuration()->toBe(1000);
});

it('has array representation', function () {
    expect($this->message->toArray())->toBe([
        'message' => null,
        'type' => config('flash.type'),
        'title' => null,
        'duration' => config('flash.duration'),
    ]);
});
