<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\NumericFormatter;

beforeEach(function () {
    $this->formatter = new NumericFormatter();
});

it('has locale', function () {
    expect($this->formatter)
        ->getLocale()->toBe(app()->getLocale())
        ->locale('fr')->toBe($this->formatter)
        ->getLocale()->toBe('fr');
});
