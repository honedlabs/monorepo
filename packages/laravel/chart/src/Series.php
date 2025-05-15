<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\FiltersUndefined;
use Honed\Core\Primitive;
use Honed\Chart\Concerns\HasAnimationDuration;
use Honed\Chart\Exceptions\MissingSeriesKeyException;

abstract class Series extends Primitive
{
    use HasAnimationDuration;
    use FiltersUndefined;

    /**
     * The key(s) of the data to be used for the series.
     * 
     * @var string|array<int, string>|null
     */
    protected $key;

    /**
     * The id to be used for rerieving the data record id.
     * 
     * @var string|null
     */
    protected $id;

    /**
     * Whether to display the series as a sparkline.
     * 
     * @var bool|null
     */
    protected $sparkline;

    /**
     * Create a new series instance.
     * 
     * @return static
     */
    public static function make()
    {
        return resolve(static::class);
    }

    /**
     * Get the type of the series.
     * 
     * @return string
     */
    abstract public function getType();

    /**
     * Set the key(s) of the data to be used for the series.
     * 
     * @param string|array<int, string>|null $key
     * @return $this
     */
    public function key($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the key(s) of the data to be used for the series.
     * 
     * @return string|array<int, string>
     * 
     * @throws \Honed\Chart\Exceptions\MissingSeriesKeyException
     */
    public function getKey()
    {
        $key = $this->key;

        if (is_null($key)) {
            MissingSeriesKeyException::throw();
        }

        return $key;
    }

    /**
     * Set the id to be used for rerieving the data record id.
     * 
     * @param string|null $id
     * @return $this
     */
    public function id($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the id to be used for rerieving the data record id.
     * 
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set whether to display the series as a sparkline.
     * 
     * @param bool|null $sparkline
     * @return $this
     */
    public function sparkline($sparkline)
    {
        $this->sparkline = $sparkline;

        return $this;
    }

    /**
     * Get whether to display the series is a sparkline.
     * 
     * @return bool|null
     */
    public function isSparkline()
    {
        return $this->sparkline;
    }

    /**
     * Flush the state of the series.
     * 
     * @return void
     */
    public static function flushState()
    {
        static::flushAnimationDurationState();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'keys' => $this->getKey(),
            'id' => $this->getId(),
            ...$this->animationDurationToArray(),
        ];
    }
}