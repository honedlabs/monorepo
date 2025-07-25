<?php

declare(strict_types=1);

namespace Honed\Chart\Axis;

use Honed\Chart\Axis\Concerns\CanAlignTicks;
use Honed\Chart\Axis\Concerns\CanBeScaled;
use Honed\Chart\Axis\Concerns\CanBeShown;
use Honed\Chart\Enums\AxisType;
use Honed\Core\Primitive;

class Axis extends Primitive
{
    use CanBeShown;
    use CanBeScaled;
    use CanAlignTicks;
    
    /**
     * The type of axis.
     * 
     * @var \Honed\Chart\Enums\AxisType
     */
    protected $type;

    /**
     * Set the type of axis.
     * 
     * @return $this
     * 
     * @throws \ValueError if the axis type is not a valid axis type
     */
    public function type(AxisType|string $value): static
    {
        if (! $value instanceof AxisType) {
            $value = AxisType::from($value);
        }

        $this->type = $value;

        return $this;
    }

    // /**
    //  * Set the axis type to value, indicating the axis is for continuous data.
    //  * 
    //  * @param \Honed\Chart\Enums\AxisType|string $value
    //  * @return $this
    //  * 
    //  * @throws \ValueError if the axis type is not a valid axis type
    //  */
    // public function continuous(AxisType|string $value): static
    // {}

    /**
     * Get the type of axis.
     */
    public function getType(): ?string
    {
        return $this->type?->value;
    }

    /**
     * Get the representation of the axis.
     */
    protected function representation(): array
    {
        $this->define();

        return [
            'type' => $this->getType(),
        ];
    }
}