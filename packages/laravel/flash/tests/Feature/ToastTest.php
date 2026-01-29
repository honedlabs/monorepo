<?php

declare(strict_types=1);

use Honed\Flash\Enums\FlashType;
use Honed\Flash\Toast;
use Workbench\App\Toasts\SuccessToast;

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

it('has class array representation', function () {
    expect(SuccessToast::make())
        ->getMessage()->toBe('This was a successful operation.')
        ->getType()->toBe(FlashType::Success->value)
        ->getDuration()->toBe(5000)
        ->toArray()->toBe([
            'message' => 'This was a successful operation.',
            'type' => 'success',
            'title' => null,
            'duration' => 5000,
        ]);
});
