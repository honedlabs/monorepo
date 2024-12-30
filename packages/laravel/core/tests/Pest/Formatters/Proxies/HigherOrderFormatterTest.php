<?php

use Honed\Core\Contracts\HigherOrder;
use Honed\Core\Formatters\Concerns\Formattable;
use Honed\Core\Formatters\Proxies\HigherOrderFormatter;
use Honed\Core\Primitive;

class HigherOrderFormatterComponent extends Primitive implements HigherOrder
{
    public static function make()
    {
        return resolve(static::class);
    }

    public function __get(string $property): HigherOrder
    {
        return match ($property) {
            'formatter' => new HigherOrderFormatter($this),
            default => throw new \Exception('Fail'),
        };
    }

    public function toArray()
    {
        return [];
    }
}

class HigherOrderFormatterTraitComponent extends HigherOrderFormatterComponent
{
    use Formattable;
}

beforeEach(function () {
    $this->formattable = HigherOrderFormatterTraitComponent::make();
});

it('forwards calls to the higher order', function () {
    expect($this->formattable->boolean()->formatter->truthLabel('Agree'))
        ->toBeInstanceOf(HigherOrderFormatterTraitComponent::class)
        ->hasFormatter()->toBeTrue();
});

it('handles case where primitive does not have formatter set', function () {
    expect($this->formattable->formatter->truthLabel('Agree'))
        ->toBeInstanceOf(HigherOrderFormatterTraitComponent::class)
        ->hasFormatter()->toBeFalse();
});
