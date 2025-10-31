<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use BackedEnum;
use Closure;
use Honed\Core\Contracts\HasDescription as ContractsHasDescription;

trait HasDescription
{
    /**
     * The description.
     *
     * @var string|(Closure(mixed...):string)|BackedEnum|null
     */
    protected $description;

    /**
     * Set the description.
     *
     * @param  string|Closure(mixed...):string|ContractsHasDescription|BackedEnum|null  $description
     * @return $this
     */
    public function description(string|Closure|ContractsHasDescription|BackedEnum|null $description): static
    {
        $this->description = $description instanceof ContractsHasDescription ? $description->getDescription() : $description;

        return $this;
    }

    /**
     * Get the description.
     */
    public function getDescription(): ?string
    {
        return $this->evaluate($this->description);
    }

    /**
     * Determine if a description is set.
     */
    public function hasDescription(): bool
    {
        return isset($this->description);
    }

    /**
     * Determine if a description is not set.
     */
    public function missingDescription(): bool
    {
        return ! $this->hasDescription();
    }
}
