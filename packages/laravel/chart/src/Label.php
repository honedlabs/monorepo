<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\FiltersUndefined;
use JsonSerializable;
use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Concerns\HasFont;
use Illuminate\Contracts\Support\Arrayable;

class Label implements Arrayable, JsonSerializable
{
    use HasFont;
    use HasColor;
    use FiltersUndefined;

    /**
     * The label to display.
     * 
     * @var string|null
     */
    protected $label;

    /**
     * Set the label to display.
     * 
     * @param string $label
     * @return $this
     */
    public function label($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the label to display.
     * 
     * @return string|null
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->filterUndefined([
            'label' => $this->getLabel(),
            'labelFontSize' => $this->getFontSize(),
            'labelColor' => $this->getColor(),
            'labelMargin' => $this->getMargin(),
        ]);
    }    
}