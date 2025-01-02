<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait HasFalseLabel
{
    const FalseLabel = 'False';

    /**
     * @var string|null
     */
    protected $falseLabel = null;

    /**
     * @var string
     */
    protected static $defaultFalseLabel = self::FalseLabel;

    /**
     * Configure the default false label.
     */
    public static function useFalseLabel(string $falseLabel = null): void
    {
        static::$defaultFalseLabel = $falseLabel ?? self::FalseLabel;
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
        if (\is_null($falseLabel)) {
            return;
        }

        $this->falseLabel = $falseLabel;
    }

    /**
     * Get the false label.
     */
    public function getFalseLabel(): string
    {
        return $this->falseLabel ?? static::getDefaultFalseLabel();
    }

    /**
     * Alias for `falseLabel`
     *
     * @return $this
     */
    public function ifFalse(string $falseLabel): static
    {
        return $this->falseLabel($falseLabel);
    }
}
