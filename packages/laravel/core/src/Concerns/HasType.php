<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasType
{
    /**
     * @var string
     */
    protected $type;

    /**
     * Set the type for the instance.
     *
     * @return $this
     */
    public function type(?string $type)
    {
        if (! \is_null($type)) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * Get the type for the instance.
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Determine if the instance has an type set.
     *
     * @return bool
     */
    public function hasType()
    {
        return isset($this->type);
    }
}
