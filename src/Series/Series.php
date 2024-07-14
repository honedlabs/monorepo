<?php

namespace Conquest\Chart\Series;

use Conquest\Chart\Series\Concerns\ColorsBy;
use Conquest\Core\Primitive;
use Conquest\Core\Concerns\HasName;
use Conquest\Chart\Series\Concerns\HasChartType;
use Conquest\Chart\Series\Concerns\HasData;

class Series extends Primitive
{
    use HasChartType;
    use ColorsBy;
    use HasName;
    use HasData;

    public function __construct(
        mixed $data = null,
    )
    {
        parent::__construct();
        $this->setData([5, 6, 7]);

    }

    public static function make(

    ): static {
        return resolve(static::class, func_get_args());
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->getName(),
            'data' => $this->getData(),
            'type' => $this->type?->value,
        ]);
    }

    public function infersType()
    {

    }
}
