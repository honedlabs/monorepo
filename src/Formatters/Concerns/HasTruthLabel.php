<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasTruthLabel
{
    /**
     * @var string|(\Closure():string)|null
     */
    protected $truthLabel = null;

    /**
     * @var string
     */
    protected static $defaultTruthLabel = 'True';

    /**
     * Configure the default truth label.
     * 
     * @param string $truthLabel
     * @return void
     */
    public static function setDefaultTruthLabel(string $truthLabel)
    {
        static::$defaultTruthLabel = $truthLabel;
    }

    /**
     * Get the default truth label.
     * 
     * @return string
     */
    public static function getDefaultTruthLabel(): string
    {
        return static::$defaultTruthLabel;
    }

    /**
     * Set the truth label, chainable.
     *
     * @param  string|\Closure():string  $truthLabel
     * @return $this
     */
    public function truthLabel(string|\Closure $truthLabel): static
    {
        $this->setTruthLabel($truthLabel);

        return $this;
    }

    /**
     * Set the truth label quietly.
     *
     * @param  string|(\Closure():string)|null  $truthLabel
     */
    public function setTruthLabel(string|\Closure|null $truthLabel): void
    {
        if (is_null($truthLabel)) {
            return;
        }
        $this->truthLabel = $truthLabel;
    }

    /**
     * Get the truth label.
     * 
     * @return string|null
     */
    public function getTruthLabel(): ?string
    {
        return $this->evaluate($this->truthLabel) ?? static::getDefaultTruthLabel();
    }

    /**
     * Alias for truthLabel
     * 
     * @param string|\Closure $truthLabel
     * @return $this
     */
    public function ifTrue(string|\Closure $truthLabel): static
    {
        return $this->truthLabel($truthLabel);
    }
}
