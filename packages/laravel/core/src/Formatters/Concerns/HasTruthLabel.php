<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait HasTruthLabel
{
    const TruthLabel = 'True';

    /**
     * @var string|null
     */
    protected $truthLabel = null;

    /**
     * @var string
     */
    protected static $defaultTruthLabel = self::TruthLabel;

    /**
     * Configure the default truth label.
     *
     * @return void
     */
    public static function useTruthLabel(?string $truthLabel = null)
    {
        static::$defaultTruthLabel = $truthLabel ?? self::TruthLabel;
    }

    /**
     * Get the default truth label.
     */
    public static function getDefaultTruthLabel(): string
    {
        return static::$defaultTruthLabel;
    }

    /**
     * Set the truth label, chainable.
     *
     * @return $this
     */
    public function truthLabel(string $truthLabel): static
    {
        $this->setTruthLabel($truthLabel);

        return $this;
    }

    /**
     * Set the truth label quietly.
     */
    public function setTruthLabel(?string $truthLabel): void
    {
        if (\is_null($truthLabel)) {
            return;
        }

        $this->truthLabel = $truthLabel;
    }

    /**
     * Get the truth label.
     */
    public function getTruthLabel(): string
    {
        return $this->truthLabel ?? static::getDefaultTruthLabel();
    }

    /**
     * Alias for `truthLabel`.
     *
     * @return $this
     */
    public function ifTrue(string $truthLabel): static
    {
        return $this->truthLabel($truthLabel);
    }
}
