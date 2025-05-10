<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Core\Primitive;
use Honed\Chart\Concerns\HasAnimationDuration;
use Honed\Chart\Exceptions\MissingSeriesKeyException;

abstract class Series extends Primitive
{
    use HasAnimationDuration;

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
     * Filter any potential undefined values from the array.
     * 
     * @param array<string, mixed> $array
     * @return array<string, mixed>
     */
    public function filterUndefined($array)
    {
        return \array_filter(
            $array,
            static fn ($value) => ! \is_null($value)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'keys' => $this->getKey(),
            'id' => $this->getId(),
            'duration' => $this->getAnimationDuration(),
        ];
    }
}