<?php

use Honed\Core\Concerns\HasParameterNames;
use Honed\Core\Tests\Stubs\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class
    {
        use HasParameterNames;
    };

    $this->names = [
        User::class,
        'user',
        'users',
    ];
});

it('gets names from builder', function () {
    expect($this->test)
        ->getParameterNames(User::query())->toBe($this->names);
});

it('gets names from model', function () {
    expect($this->test)
        ->getParameterNames(User::factory()->create())->toBe($this->names);
});

it('gets names from class name', function () {
    expect($this->test)
        ->getParameterNames(User::class)->toBe($this->names);
});

it('gets singular name', function () {
    expect($this->test)
        ->getSingularName(User::class)->toBe($this->names[1]);
});

it('gets plural name', function () {
    expect($this->test)
        ->getPluralName(User::class)->toBe($this->names[2]);
});

it('checks if builder parameter', function () {
    expect($this->test)
        ->isBuilder('builder', Status::class)->toBeTrue()
        ->isBuilder('status', Builder::class)->toBeTrue()
        ->isBuilder('status', Status::class)->toBeFalse();
});

it('checks if collection parameter', function () {
    expect($this->test)
        ->isCollection('collection', Status::class)->toBeTrue()
        ->isCollection('status', Collection::class)->toBeTrue()
        ->isCollection('status', Status::class)->toBeFalse();
});

it('checks if model parameter', function () {
    expect($this->test)
        ->isModel('model', Status::class, User::class)->toBeTrue()
        ->isModel('status', User::class, User::class)->toBeTrue()
        ->isModel('status', Status::class, User::class)->toBeFalse();
});

it('gets builder parameters', function () {
    $user = User::factory()->create();

    $named = ['model', 'record', 'query', 'builder', 'users', 'user'];

    $typed = [Model::class, Builder::class, User::class];

    expect($this->test->getBuilderParameters(User::class, $user))
        ->toBeArray()
        ->toHaveCount(2)
        ->{0}->toHaveKeys($named)
        ->{1}->toHaveKeys($typed);
});
it('gets model parameters', function () {
    $user = User::factory()->create();

    $named = ['model', 'record', 'user'];

    $typed = [Model::class, User::class];

    expect($this->test->getModelParameters(User::class, $user))
        ->toBeArray()
        ->toHaveCount(2)
        ->{0}->toHaveKeys($named)
        ->{1}->toHaveKeys($typed);
});
