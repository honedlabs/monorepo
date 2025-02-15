<?php

use Honed\Table\Tests\Fixtures\Table as FixtureTable;
use Honed\Table\Table;

beforeEach(function () {
    $this->table = FixtureTable::make();
});

// it('has toggle', function () {
//     expect($this->table)
//         ->getToggle()->toEqual(FixtureTable::Toggle);
