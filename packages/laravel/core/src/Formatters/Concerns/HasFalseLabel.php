<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasFalseLabel
{
    public const DefaultFalseLabel = 'False';

    /**
     * @var string|(\Closure():string)|null
     */
    protected $falseLabel = null;

    /**
     * @var string
     */
    protected static $defaultFalseLabel = self::DefaultFalseLabel;

    /**
     * Configure the default false label.
     *
     * @return void
     */
    public static function setDefaultFalseLabel(?string $falseLabel = null)
    {
        static::$defaultFalseLabel = $falseLabel ?: self::DefaultFalseLabel;
    }

    /**
     * Get the default false label.
     */
    public static function getDefaultFalseLabel(): string
    {
        return static::$defaultFalseLabel;
    }

    /**
     * Set the false label, chainable.
     *
     * @return $this
     */
    public function falseLabel(string $falseLabel): static
    {
        $this->setFalseLabel($falseLabel);

        return $this;
    }

    /**
     * Set the false label quietly.
     */
    public function setFalseLabel(?string $falseLabel): void
    {
        if (is_null($falseLabel)) {
            return;
        }
        $this->falseLabel = $falseLabel;
    }

    /**
     * Get the false label.
     */
    public function getFalseLabel(): ?string
    {
        return $this->falseLabel ?? static::getDefaultFalseLabel();
    }

    /**
     * Alias for falseLabel
     *
     * @return $this
     */
    public function ifFalse(string $falseLabel): static
    {
        return $this->falseLabel($falseLabel);
    }
}
