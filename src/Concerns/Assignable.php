<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Assignable
{
    /**
     * Assign multiple properties at once to the class.
     * 
     * @param  array<string, array-key>  $assignments
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
     * @param  array<string, array-key>  $assignments
     */
    public function setAssignments(array $assignments): void
    {
        foreach ($assignments as $key => $value) {
            $method = 'set'.str($key)->studly()->value();

            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }
    }
}
