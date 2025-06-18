<?php

declare(strict_types=1);

use Honed\Action\Batch;
use Honed\Action\Concerns\HasOperations;
use Honed\Action\Operations\BulkOperation;
use Honed\Action\Operations\InlineOperation;
use Honed\Action\Operations\PageOperation;
use Honed\Core\Primitive;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class() extends Primitive
    {
        use HasOperations;

        public function toArray($named = [], $typed = [])
        {
            return [];
        }
    };
});

it('adds operations', function () {
    expect($this->test)
        ->operations([PageOperation::make('view')])->toBe($this->test)
        ->operations([InlineOperation::make('edit')])->toBe($this->test)
        ->getOperations()->toHaveCount(2);
});

it('adds action groups', function () {
    expect($this->test)
        ->operations(Batch::make(PageOperation::make('view')))->toBe($this->test)
        ->getOperations()->toHaveCount(1);
});

it('has inline operations', function () {
    expect($this->test)
        ->operations([PageOperation::make('create')])
        ->getInlineOperations()->toHaveCount(0)
        ->operations([InlineOperation::make('create')])
        ->getInlineOperations()->toHaveCount(1);
});

it('has bulk operations', function () {
    expect($this->test)
        ->operations([PageOperation::make('create')])
        ->getBulkOperations()->toHaveCount(0)
        ->operations([BulkOperation::make('create')])
        ->getBulkOperations()->toHaveCount(1);
});

it('has page operations', function () {
    expect($this->test)
        ->operations([InlineOperation::make('create')])
        ->getPageOperations()->toHaveCount(0)
        ->operations([PageOperation::make('create')])
        ->getPageOperations()->toHaveCount(1);
});

it('has inline operations array representation', function () {
    $user = User::factory()->create();

    expect($this->test)
        ->operations([
            InlineOperation::make('create')
                ->label(fn ($record) => $record->name)
                ->allow(fn ($record) => $record->id % 2 === 1),
            InlineOperation::make('edit')
                ->label(fn ($record) => $record->name)
                ->allow(fn ($record) => $record->id % 2 === 0),
        ])
        ->inlineOperationsToArray($user)->toHaveCount(1);
});

it('has bulk operations array representation', function () {
    expect($this->test)
        ->operations([BulkOperation::make('create')])
        ->bulkOperationsToArray()->toHaveCount(1);
});

it('has page operations array representation', function () {
    expect($this->test)
        ->operations([PageOperation::make('create')])
        ->pageOperationsToArray()->toHaveCount(1);
});
