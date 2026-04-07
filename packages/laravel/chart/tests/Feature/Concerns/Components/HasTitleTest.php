<?php

declare(strict_types=1);

use Honed\Chart\Chart;
use Honed\Chart\Title;

beforeEach(function () {
    $this->chart = Chart::make();
});

it('can have title', function () {
    expect($this->chart)
        ->getTitle()->toBeNull()
        ->title()->toBe($this->chart)
        ->getTitle()->toBeInstanceOf(Title::class)
        ->title(false)->toBe($this->chart)
        ->getTitle()->toBeNull()
        ->title(fn ($title) => $title)->toBe($this->chart)
        ->getTitle()->toBeInstanceOf(Title::class)
        ->title(null)->toBe($this->chart)
        ->getTitle()->toBeNull()
        ->title(Title::make())->toBe($this->chart)
        ->getTitle()->toBeInstanceOf(Title::class)
        ->title('Hello World!')->toBe($this->chart)
        ->getTitle()
        ->scoped(fn ($title) => $title
            ->getText()->toBe('Hello World!')
        );
});
