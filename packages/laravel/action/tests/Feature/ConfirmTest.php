<?php

declare(strict_types=1);

use Honed\Action\Confirm;
use Honed\Core\Parameters;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = Confirm::make();
});

afterEach(function () {
    Confirm::flushState();
});

it('has title', function () {
    expect($this->test)
        ->getTitle()->toBeNull()
        ->title('name')->toBe($this->test)
        ->getTitle()->toBe('name');
});

it('has description', function () {
    expect($this->test)
        ->getDescription()->toBeNull()
        ->description('description')->toBe($this->test)
        ->getDescription()->toBe('description');
});

it('has dismiss', function () {
    expect($this->test)
        ->getDismiss()->toBe('Cancel')
        ->dismiss('Back')->toBe($this->test)
        ->getDismiss()->toBe('Back');
});

it('set global dismiss message', function () {
    expect($this->test)
        ->getDismiss()->toBe('Cancel');

    Confirm::useDismiss('Back');

    expect($this->test)
        ->getDismiss()->toBe('Back');
});

it('has submit', function () {
    expect($this->test)
        ->getSubmit()->toBe('Confirm')
        ->submit('Accept')->toBe($this->test)
        ->getSubmit()->toBe('Accept');
});

it('set global submit message', function () {
    expect($this->test)
        ->getSubmit()->toBe('Confirm');

    Confirm::useSubmit('Accept');

    expect($this->test)
        ->getSubmit()->toBe('Accept');
});

it('has intent', function () {
    expect($this->test)
        ->getIntent()->toBeNull()
        ->intent('danger')->toBe($this->test)
        ->getIntent()->toBe('danger')
        ->constructive()->toBe($this->test)
        ->getIntent()->toBe(Confirm::CONSTRUCTIVE)
        ->destructive()->toBe($this->test)
        ->getIntent()->toBe(Confirm::DESTRUCTIVE)
        ->informative()->toBe($this->test)
        ->getIntent()->toBe(Confirm::INFORMATIVE);
});

it('has array representation', function () {
    expect($this->test->toArray())
        ->toBeArray()
        ->toEqual([
            'title' => null,
            'description' => null,
            'dismiss' => 'Cancel',
            'submit' => 'Confirm',
            'intent' => null,
        ]);
});

it('resolves to array', function () {
    $user = User::factory()->create();

    $confirm = Confirm::make(
        fn (User $p) => $p->name,
        fn (User $p) => \sprintf('Are you sure you want to delete %s?', $p->name)
    );

    expect($confirm->toArray(...Parameters::model($user)))
        ->toEqual([
            'title' => $user->name,
            'description' => \sprintf('Are you sure you want to delete %s?', $user->name),
            'dismiss' => 'Cancel',
            'submit' => 'Confirm',
            'intent' => null,
        ]);
});
