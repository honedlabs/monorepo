<?php

declare(strict_types=1);

use Honed\Infolist\Entries\DateEntry;
use Honed\Infolist\Entries\DateTimeEntry;
use Honed\Infolist\Entries\TimeEntry;
use Honed\Infolist\Formatters\TimeFormatter;

beforeEach(function () {
    $this->formatter = new TimeFormatter();
});

it('has date format', function () {
    expect($this->formatter)
        ->getDateFormat()->toBe('H:i:s');
});