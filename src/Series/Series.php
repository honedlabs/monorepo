<?php

namespace Conquest\Chart\Series;

use Conquest\Chart\Series\Concerns\ColorsBy;
use Conquest\Core\Primitive;
use Conquest\Core\Concerns\HasName;
use Conquest\Chart\Series\Concerns\HasChartType;

class Series extends Primitive
{
    use HasChartType;
    use ColorsBy;
    use HasName;

    public function __construct(
        protected mixed $data = null,
    )
    {
        parent::__construct();

    }

    public static function make(

    ): static {
        return resolve(static::class, func_get_args());
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type?->value,
        ];
    }

    public function infersType()
    {

    }
}
