<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use BackedEnum;
use Closure;
use Honed\Core\Contracts\HasLabel as ContractsHasLabel;
use Illuminate\Support\Str;

use function is_string;

trait HasLabel
{
    /**
     * The label.
     *
     * @var string|(Closure(mixed...):string)|BackedEnum|null
     */
    protected $label;

    /**
     * Convert a string to the label format.
     */
    public static function makeLabel(?string $name): ?string
    {
        if (! is_string($name)) {
            return null;
        }

        return Str::of($name)
            ->afterLast('.')
            ->headline()
            ->lower()
            ->ucfirst()
            ->toString();
    }

    /**
     * Set the label.
     *
     * @param  string|Closure(mixed...):string|ContractsHasLabel|BackedEnum|null  $label
     * @return $this
     */
    public function label(string|Closure|ContractsHasLabel|BackedEnum|null $label): static
    {
        $this->label = $label instanceof ContractsHasLabel ? $label->getLabel() : $label;

        return $this;
    }

    /**
     * Get the label.
     */
    public function getLabel(): ?string
    {
        return $this->evaluate($this->label);
    }

    /**
     * Determine if a label is set.
     */
    public function hasLabel(): bool
    {
        return isset($this->label);
    }

    /**
     * Determine if a label is not set.
     */
    public function missingLabel(): bool
    {
        return ! $this->hasLabel();
    }
}
