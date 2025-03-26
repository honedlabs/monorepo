<?php

declare(strict_types=1);

use Honed\Flash\Message;
use Honed\Flash\Support\Parameters;

beforeEach(function () {
    $this->message = Message::make('Hello World');
});

it('has message', function () {
    expect($this->message)
        ->toBe($this->message)
        ->getMessage()->toBe('Hello World')
        ->message('Test')->toBe($this->message)
        ->getMessage()->toBe('Test');
});

it('has type', function () {
    expect($this->message)
        ->getType()->toBeNull()
        ->type('other')->toBe($this->message)
        ->getType()->toBe('other')
        ->success()->toBe($this->message)
        ->getType()->toBe(Parameters::SUCCESS)
        ->error()->toBe($this->message)
        ->getType()->toBe(Parameters::ERROR)
        ->info()->toBe($this->message)
        ->getType()->toBe(Parameters::INFO)
        ->warning()->toBe($this->message)
        ->getType()->toBe(Parameters::WARNING);
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
        'message' => 'Hello World',
        'type' => config('flash.type'),
        'title' => null,
        'duration' => config('flash.duration'),
    ]);
});

