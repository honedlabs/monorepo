<?php

use Honed\Table\Table;
use Honed\Table\Tests\Stubs\ExampleTable;
use Illuminate\Support\Stringable;

class TestTable
{
    public function __construct() {
        dd((new Stringable(static::class))
            ->classBasename()
            ->beforeLast('Table')
            ->singular()
            ->prepend('\\App\\Models\\')
            ->toString()
        );
    }
}
it('tests', function () {
    $test = new TestTable();
});