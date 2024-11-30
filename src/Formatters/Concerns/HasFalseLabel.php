<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasFalseLabel
{
    /**
     * @var string|(\Closure():string)|null
     */
    protected $falseLabel = null;

    /**
     * @var string
     */
    protected static $defaultFalseLabel = 'False';

    /**
     * Configure the default false label.
     * 
     * @param string $falseLabel
     * @return void
     */
    public static function setDefaultFalseLabel(string $falseLabel)
    {
        static::$defaultFalseLabel = $falseLabel;
    }

    /**
     * Get the default false label.
     * 
     * @return string
     */
    public static function getDefaultFalseLabel(): string
    {
        return static::$defaultFalseLabel;
    }

    /**
     * Set the false label, chainable.
     *
     * @param  string|\Closure():string  $falseLabel
     * @return $this
     */
    public function falseLabel(string|\Closure $falseLabel): static
    {
        $this->setFalseLabel($falseLabel);

        return $this;
    }

    /**
     * Set the false label quietly.
     *
     * @param  string|(\Closure():string)|null  $falseLabel
     */
    public function setFalseLabel(string|\Closure|null $falseLabel): void
    {
        if (is_null($falseLabel)) {
            return;
        }
        $this->falseLabel = $falseLabel;
    }

    /**
     * Get the false label.
     * 
     * @return string|null
     */
    public function getFalseLabel(): ?string
    {
        return $this->evaluate($this->falseLabel) ?? static::getDefaultFalseLabel();
    }

    /**
     * Alias for falseLabel
     * 
     * @param string|\Closure $falseLabel
     * @return $this
     */
    public function ifFalse(string|\Closure $falseLabel): static
    {
        return $this->falseLabel($falseLabel);
    }
}
