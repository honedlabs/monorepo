<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Stringable;

/**
 * Deprecated
 */
trait Assignable
{
    /**
     * Assign multiple properties at once to the class.
     *
     * @param  array<string,mixed>  $assignments
     * @return $this
     */
    public function assign(array $assignments): static
    {
        $this->setAssignments($assignments);

        return $this;
    }

    /**
     * Set the assignments.
     *
     * @param  array<string,mixed>  $assignments
     */
    public function setAssignments(array $assignments): void
    {
        foreach ($assignments as $key => $value) {
            $method = (new Stringable($key))
                ->prepend('set')
                ->studly()
                ->value();

            if (\method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }
    }
}
