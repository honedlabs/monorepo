<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasDescription;
use Honed\Core\Contracts\HasDescription as ContractsHasDescription;
use Workbench\App\Enums\Status;

beforeEach(function () {
    $this->test = new class()
    {
        use Evaluable, HasDescription;
    };
});

it('has no description by default', function () {
    expect($this->test)
        ->getDescription()->toBeNull()
        ->hasDescription()->toBeFalse()
        ->missingDescription()->toBeTrue();
});

it('sets', function (mixed $description, ?string $expected) {
    expect($this->test)
        ->description($description)->toBe($this->test)
        ->getDescription()->toBe($expected);
})->with([
    fn () => [null, null],
    fn () => ['description', 'description'],
    fn () => [fn () => 'description', 'description'],
    fn () => [Status::Available, Status::Available->value],
    fn () => [new class() implements ContractsHasDescription
    {
        public function getDescription(): string
        {
            return 'description';
        }
    }, 'description'],
]);
