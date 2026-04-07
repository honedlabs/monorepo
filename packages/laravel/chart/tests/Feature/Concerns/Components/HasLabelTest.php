<?php

declare(strict_types=1);

use Honed\Chart\Chartable;
use Honed\Chart\Label;

beforeAll(function () {
    if (! trait_exists(Honed\Chart\Concerns\HasLabel::class, false)) {
        require_once dirname(__DIR__, 4).'/src/Concerns/Components/HasLabel.php';
    }
});

beforeEach(function () {
    $this->fixture = new class() extends Chartable
    {
        use Honed\Chart\Concerns\HasLabel;

        protected function representation(): array
        {
            return [];
        }
    };
});

it('can have label', function () {
    expect($this->fixture)
        ->getLabel()->toBeNull()
        ->label(false)->toBe($this->fixture)
        ->getLabel()->toBeNull()
        ->label(fn (Label $label) => $label)->toBe($this->fixture)
        ->getLabel()->toBeInstanceOf(Label::class)
        ->label(null)->toBe($this->fixture)
        ->getLabel()->toBeNull()
        ->label(Label::make())->toBe($this->fixture)
        ->getLabel()->toBeInstanceOf(Label::class);
});
