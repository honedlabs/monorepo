<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

trait HasQualifier
{
    /**
     * Whether to qualify against the builder.
     *
     * @var bool|string
     */
    protected $qualify = true;

    /**
     * Set whether to qualify against the builder.
     *
     * @param  bool|string  $qualify
     * @return $this
     */
    public function qualifies($qualify = true)
    {
        $this->qualify = $qualify;

        return $this;
    }

    /**
     * Set whether to not qualify against the builder.
     *
     * @param  bool  $unqualify
     * @return $this
     */
    public function unqualify($unqualify = true)
    {
        return $this->qualifies(! $unqualify);
    }

    /**
     * Get the qualifier.
     *
     * @return bool|string
     */
    public function getQualifier()
    {
        return $this->qualify;
    }

    /**
     * Determine if the instance should qualify against the builder.
     *
     * @return bool
     */
    public function isQualifying()
    {
        return (bool) $this->getQualifier();
    }

    /**
     * Get the qualified name.
     *
     * @param  string  $column
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>|null  $builder
     * @return string
     */
    public function qualifyColumn($column, $builder = null)
    {
        $qualifier = $this->getQualifier();

        if (! $qualifier) {
            return $column;
        }

        if (\is_string($qualifier) && ! \str_contains($column, '.')) {
            $column = $qualifier.'.'.$column;
        }

        return $builder
            ? $builder->qualifyColumn($column)
            : $column;
    }
}
