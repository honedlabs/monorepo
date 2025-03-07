<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

trait InterpretsRequest
{
    /**
     * The request interpreter.
     * 
     * @var string|null
     */
    protected $as;

    /**
     * Interpret the request.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function interpret($request)
    {
        $key = $this->getAs();


        return match ($this->as) {
            'array' => $request->safeArray($key),
            'boolean' => $request->safeBoolean($key),
            'date' => $request->safeDate($key),
            'datetime' => $request->safeDateTime($key),
            'float' => $request->safeFloat($key),
            'integer' => $request->safeInteger($key),
            'string' => $request->safeString($key),
            'time' => $request->safeTime($key),
            default => $request->safe($this->as),
        };
    }

    /**
     * Set the interpreter to use.
     * 
     * @param  string|array{string,string}  $as
     * @return $this
     */
    public function as($as)
    {
        $this->as = $as;

        return $this;
    }

    /**
     * Set the request to interpret as an array.
     * 
     * @param  string|null  $arrayAs
     * @return $this
     */
    public function asArray($arrayAs = null)
    {
        return $this->as(['array', $arrayAs]);
    }

    /**
     * Set the request to interpret as a boolean.
     * 
     * @return $this
     */
    public function asBoolean()
    {
        return $this->as('boolean');
    }

    /**
     * Set the request to interpret as a date.
     * 
     * @return $this
     */
    public function asDate()
    {
        return $this->as('date');
    }

    /**
     * Set the request to interpret as a datetime.
     * 
     * @return $this
     */
    public function asDateTime()
    {
        return $this->as('datetime');
    }

    /**
     * Set the request to interpret as a decimal. Alias for `asFloat`.
     * 
     * @return $this
     */
    public function asDecimal()
    {
        return $this->as('float');
    }

    /**
     * Set the request to interpret as a timestamp.
     * 
     * @return $this
     */
    public function asFloat()
    {
        return $this->as('float');
    }

    /**
     * Set the request to interpret as an integer.
     * 
     * @return $this
     */
    public function asInteger()
    {
        return $this->as('integer');
    }

    /**
     * Set the request to interpret as a string.
     * 
     * @return $this
     */
    public function asString()
    {
        return $this->as('string');
    }

    /**
     * Set the request to interpret as a time.
     * 
     * @return $this
     */
    public function asTime()
    {
        return $this->as('time');
    }

    /**
     * Get the interpreter.
     * 
     * @return string|array{string,string}|null
     */
    public function getAs()
    {
        return $this->as;
    } 
}
