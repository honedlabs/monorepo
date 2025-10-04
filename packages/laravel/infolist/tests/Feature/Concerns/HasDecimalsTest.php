<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\NumericFormatter;

beforeEach(function () {
    $this->formatter = new NumericFormatter();
});

it('has decimals', function () {
    expect($this->formatter)
        ->getDecimals()->toBeNull()
        ->decimals(2)->toBe($this->formatter)
        ->getDecimals()->toBe(2);
});
