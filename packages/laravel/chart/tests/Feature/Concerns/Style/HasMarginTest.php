<?php

declare(strict_types=1);

use Honed\Chart\Chartable;
use Honed\Chart\Concerns\Style\HasMargin;

beforeEach(function () {
    $this->chartable = new class() extends Chartable
    {
        use HasMargin;

        protected function representation(): array
        {
            return [];
        }
    };
});

it('has margin', function () {
    expect($this->chartable)
        ->getMargin()->toBeNull()
        ->margin(16)->toBe($this->chartable)
        ->getMargin()->toBe(16);
});
