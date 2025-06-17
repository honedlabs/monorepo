<?php

declare(strict_types=1);

namespace Honed\Refine\Filters\Concerns;

trait HasOperator
{
    /**
     * The operator to use.
     *
     * @var string
     */
    protected $operator = '=';

    /**
     * Set the operator to use for the filter.
     *
     * @param  string  $operator
     * @return $this
     */
    public function operator(string $operator): self
    {
        $this->operator = mb_strtoupper($operator, 'UTF8');

        return $this;
    }

    /**
     * Set the operator to be '>'
     *
     * @return $this
     */
    public function greaterThan(): self
    {
        return $this->operator('>');
    }

    /**
     * Set the operator to be '>'
     *
     * @return $this
     */
    public function gt(): self
    {
        return $this->operator('>');
    }

    /**
     * Set the operator to be '>='
     *
     * @return $this
     */
    public function greaterThanOrEqualTo(): self
    {
        return $this->operator('>=');
    }

    /**
     * Set the operator to be '>='
     *
     * @return $this
     */
    public function gte(): self
    {
        return $this->operator('>=');
    }

    /**
     * Set the operator to be '<'
     *
     * @return $this
     */
    public function lessThan(): self
    {
        return $this->operator('<');
    }

    /**
     * Set the operator to be '<'
     *
     * @return $this
     */
    public function lt(): self
    {
        return $this->operator('<');
    }

    /**
     * Set the operator to be '<='
     *
     * @return $this
     */
    public function lessThanOrEqualTo(): self
    {
        return $this->operator('<=');
    }

    /**
     * Set the operator to be '<='
     *
     * @return $this
     */
    public function lte(): self
    {
        return $this->operator('<=');
    }

    /**
     * Set the operator to be '!='
     *
     * @return $this
     */
    public function notEqualTo(): self
    {
        return $this->operator('!=');
    }

    /**
     * Set the operator to be '!='
     *
     * @return $this
     */
    public function neq(): self
    {
        return $this->operator('!=');
    }

    /**
     * Set the operator to be '='
     *
     * @return $this
     */
    public function equals(): self
    {
        return $this->operator('=');
    }

    /**
     * Set the operator to be '='
     *
     * @return $this
     */
    public function eq(): self
    {
        return $this->operator('=');
    }

    /**
     * Set the operator to be 'LIKE'
     *
     * @return $this
     */
    public function like(): self
    {
        return $this->operator('LIKE');
    }

    /**
     * Get the operator to use for the filter.
     *
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }
}
