<?php

declare(strict_types=1);

use Honed\Chart\Chart;
use Honed\Chart\Toolbox;

beforeEach(function () {
    $this->chart = Chart::make();
});

it('can have toolbox', function () {
    expect($this->chart)
        ->getToolbox()->toBeNull()
        ->toolbox()->toBe($this->chart)
        ->getToolbox()->toBeInstanceOf(Toolbox::class)
        ->toolbox(false)->toBe($this->chart)
        ->getToolbox()->toBeNull()
        ->toolbox(fn ($toolbox) => $toolbox)->toBe($this->chart)
        ->getToolbox()->toBeInstanceOf(Toolbox::class)
        ->toolbox(null)->toBe($this->chart)
        ->getToolbox()->toBeNull()
        ->toolbox(Toolbox::make())->toBe($this->chart)
        ->getToolbox()->toBeInstanceOf(Toolbox::class);
});
