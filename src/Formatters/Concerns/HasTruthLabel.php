<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasTruthLabel
{
    public const DefaultTruthLabel = 'True';
    /**
     * @var string|null
     */
    protected $truthLabel = null;

    /**
     * @var string
     */
    protected static $defaultTruthLabel = self::DefaultTruthLabel;

    /**
     * Configure the default truth label.
     * 
     * @param string|null $truthLabel
     * @return void
     */
    public static function setDefaultTruthLabel(string|null $truthLabel = null)
    {
        static::$defaultTruthLabel = $truthLabel ?: self::DefaultTruthLabel;
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
     * @param string $truthLabel
     * @return $this
     */
    public function truthLabel(string $truthLabel): static
    {
        $this->setTruthLabel($truthLabel);

        return $this;
    }

    /**
     * Set the truth label quietly.
     *
     * @param string|null $truthLabel
     */
    public function setTruthLabel(string|null $truthLabel): void
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
        return $this->truthLabel ?? static::getDefaultTruthLabel();
    }

    /**
     * Alias for truthLabel
     * 
     * @param string $truthLabel
     * @return $this
     */
    public function ifTrue(string $truthLabel): static
    {
        return $this->truthLabel($truthLabel);
    }
}
