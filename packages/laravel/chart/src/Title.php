<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\Components\HasTextStyle;
use Honed\Chart\Concerns\HasId;

class Title extends Chartable
{
    use CanBeShown;
    use HasId;
    use HasTextStyle;

    /**
     * The main title text.
     *
     * @var ?string
     */
    protected $text;

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
            // 'subtext' => $this->getSubtext(),
            // 'sublink' => $this->getSublink(),
            // 'subtarget' => $this->getSubtarget(),
            // 'subtextStyle' => $this->getSubtextStyle()?->toArray(),
            // 'textAlign' => $this->getAlign(),
            // 'textVerticalAlign' => $this->getVerticalAlign(),
            // 'triggerEvent' => $this->isTriggerable() ?: null,
            // 'padding' => $this->getPadding(),
            // 'itemGap' => $this->getItemGap(),
            // 'zLevel' => $this->getZLevel(),
            // 'z' => $this->getZ(),
            // 'left' => $this->getLeft(),
            // 'top' => $this->getTop(),
            // 'right' => $this->getRight(),
            // 'bottom' => $this->getBottom(),
            // 'backgroundColor' => $this->getBackgroundColor(),
            // 'borderColor' => $this->getBorderColor(),
            // 'borderWidth' => $this->getBorderWidth(),
            // 'borderRadius' => $this->getBorderRadius(),
            // 'shadowBlur' => $this->getShadowBlur(),
            // 'shadowColor' => $this->getShadowColor(),
            // 'shadowOffsetX' => $this->getShadowOffsetX(),
            // 'shadowOffsetY' => $this->getShadowOffsetY(),
        ];
    }
}
