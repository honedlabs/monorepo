<?php

namespace Conquest\Chart\Series;

use Conquest\Chart\Series\Concerns\ColorsBy;
use Conquest\Chart\Series\Concerns\HasChartType;
use Conquest\Chart\Series\Concerns\HasData;
use Conquest\Core\Concerns\HasName;
use Conquest\Core\Primitive;

class Series extends Primitive
{
    use ColorsBy;
    use HasChartType;
    use HasData;
    use HasName;

    public function __construct(
        mixed $data = null,
    ) {
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

    public function infersType() {}
}
