<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\Components\HasTextStyle;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\Proxies\Proxyable;
use Honed\Chart\Concerns\Style\HasBottom;
use Honed\Chart\Concerns\Style\HasLeft;
use Honed\Chart\Concerns\Style\HasRight;
use Honed\Chart\Concerns\Style\HasTop;
use Honed\Chart\Concerns\Style\HasZ;
use Honed\Chart\Concerns\Style\HasZLevel;
use Honed\Chart\Proxies\HigherOrderTextStyle;

class Title extends Chartable
{
    use CanBeShown;
    use HasBottom;
    use HasId;
    use HasLeft;
    use HasRight;
    use HasTextStyle;
    use HasTop;
    use HasZ;
    use HasZLevel;
    use Proxyable;

    /**
     * The main title text.
     *
     * @var ?string
     */
    protected $text;

    public function __get(string $name): mixed
    {
        return match ($name) {
            'textStyle' => new HigherOrderTextStyle($this, $this->withTextStyle()),
            // 'subtextStyle' => new HigherOrderTextStyle($this, $this->withSubtextStyle()),
            default => $this->defaultGet($name),
        };
    }

    /**
     * Set the main title text.
     *
     * @return $this
     */
    public function text(?string $value): static
    {
        $this->text = $value;

        return $this;
    }

    /**
     * Get the main title text.
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Get the representation of the title.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'id' => $this->getId(),
            'show' => $this->isShown(),
            'text' => $this->getText(),
            // 'link' => $this->getLink(),
            // 'target' => $this->getTarget(),
            'textStyle' => $this->getTextStyle()?->toArray(),
            'zlevel' => $this->getZLevel(),
            'z' => $this->getZ(),
            'left' => $this->getLeft(),
            'top' => $this->getTop(),
            'right' => $this->getRight(),
            'bottom' => $this->getBottom(),
        ];
    }
}
