<?php

declare(strict_types=1);

use Honed\Core\Contracts\HigherOrder;
use Honed\Core\Concerns\HasFormatter;
use Honed\Core\Proxies\HigherOrderFormatter;
use Honed\Core\Primitive;

class HigherOrderFormatterTest extends Primitive implements HigherOrder
{
    use HasFormatter;

    public static function make()
    {
        return resolve(static::class);
    }

    public function __get($property)
    {
        return new HigherOrderFormatter($this);
    }

    public function toArray()
    {
        return [];
    }
}


beforeEach(function () {
    $this->test = HigherOrderFormatterTest::make();
});

it('forwards calls', function () {
    expect($this->test->formatter->true('Agree'))
        ->toBeInstanceOf(HigherOrderFormatterTest::class);

    expect($this->test->formatBoolean()->formatter->true('Agree'))
        ->toBeInstanceOf(HigherOrderFormatterTest::class)
        ->hasFormatter()->toBeTrue();
});

