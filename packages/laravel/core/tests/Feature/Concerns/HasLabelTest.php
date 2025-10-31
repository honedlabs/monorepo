<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Contracts\HasLabel as ContractsHasLabel;
use Workbench\App\Enums\Status;

beforeEach(function () {
    $this->test = new class()
    {
        use Evaluable, HasLabel;
    };
});

it('has no label by default', function () {
    expect($this->test)
        ->getLabel()->toBeNull()
        ->hasLabel()->toBeFalse()
        ->missingLabel()->toBeTrue();
});

it('sets', function (mixed $label, ?string $expected) {
    expect($this->test)
        ->label($label)->toBe($this->test)
        ->getLabel()->toBe($expected);
})->with([
    fn () => [null, null],
    fn () => ['Label', 'Label'],
    fn () => [fn () => 'Label', 'Label'],
    fn () => [Status::Available, Status::Available->value],
    fn () => [new class() implements ContractsHasLabel
    {
        public function getLabel(): string
        {
            return 'label';
        }
    }, 'label'],
]);

it('makes', function () {
    expect($this->test)
        ->makeLabel(null)->toBeNull()
        ->makeLabel('new-label')->toBe('New label');
});
