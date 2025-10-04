<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\DateTimeFormatter;

beforeEach(function () {
    $this->formatter = new DateTimeFormatter();
});

it('has date format', function () {
    expect($this->formatter)
        ->getDateFormat()->toBe('Y-m-d H:i:s');
});
