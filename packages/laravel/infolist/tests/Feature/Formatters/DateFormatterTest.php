<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\DateFormatter;

beforeEach(function () {
    $this->formatter = new DateFormatter();
});

it('has date format', function () {
    expect($this->formatter)
        ->getDateFormat()->toBe('Y-m-d');
});
