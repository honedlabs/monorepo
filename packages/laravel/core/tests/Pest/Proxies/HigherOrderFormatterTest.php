<?php

declare(strict_types=1);

use Honed\Core\Contracts\HigherOrder;
use Honed\Core\Concerns\HasFormatter;
use Honed\Core\Proxies\HigherOrderFormatter;
use Honed\Core\Primitive;

class HigherOrderFormatterComponent extends Primitive implements HigherOrder
{
    public static function make()
    {
        return resolve(static::class);
    }

    public function __get($property)
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
    use HasFormatter;
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
