<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

use Throwable;
use ReflectionClass;
use RuntimeException;
use Illuminate\Http\Request;
use Honed\Action\Attributes\Remember;
use Illuminate\Database\Eloquent\Model;
use Honed\Action\Contracts\RememberSerializeable;
use Honed\Action\Contracts\RememberUnserializeable;

trait Rememberable
{
    /**
     * Whether the instance is rememberable.
     * 
     * @var bool
     */
    protected $rememberable = false;

    /**
     * The data to remember.
     * 
     * @var array<string, mixed>|null
     */
    protected $remember;

    /**
     * Set whether the instance can remember data.
     * 
     * @return $this
     */
    public function rememberable(bool $value = true): static
    {
        $this->rememberable = $value;

        return $this;
    }

    /**
     * Set whether the instance cannot remember data.
     * 
     * @return $this
     */
    public function notRememberable(bool $value = true): static
    {
        return $this->rememberable(! $value);
    }

    /**
     * Determine if the instance can remember data.
     */
    public function isRememberable(): bool
    {
        return $this->rememberable;
    }

    /**
     * Determine if the instance cannot remember data.
     */
    public function isNotRememberable(): bool
    {
        return ! $this->isRememberable();
    }

    /**
     * 
     */
    public function remembered(Request $request)
    {

    }

    /**
     * Remember the marked properties.
     */
    public function remember(): void
    {

        $properties = $this->getRememberedProperties();

        foreach ($properties as $property) {
            $value = $property->getValue($this);

            if ($value !== null) {
                $this->remember[$property->getName()] = base64_encode(
                    $this->serializeRemember($value)
                );
            }
        }
    }

    /**
     * Get the data to remember
     */
    public function getRemembering()
    {
        if (! isset($this->remember)) {
            $this->remember();
        }

        return $this->remember;
    }

    /**
     * Get the properties that are marked as remembered.
     * 
     * @return array<int, ReflectionProperty>
     */
    public function getRememberedProperties(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();

        $remembered = [];

        foreach ($properties as $property) {
            if ($property->getAttributes(Remember::class) !== []) {
                $remembered[] = $property;
            }
        }

        return $remembered;
    }

    /**
     * Serialize the value for remembering to a request parameter.
     * 
     * @throws \RuntimeException
     */
    protected function serializeRemember(mixed $value): string
    {
        return match (true) {
            $value instanceof Model => $value::class.'|'.$value->getKey(),
            is_scalar($value) => (string) $value,
            default => throw new RuntimeException(
                'Unable to serialize the given value. You can only supply scalar values or an Eloquent model.'
            )
        };
    }

    /**
     * Unserialize the value from a request parameter.
     * 
     * @param string $data
     * 
     * @return mixed
     */
    protected function unserializeRemember(string $data): mixed
    {
        return match (true) {
            str_contains($data, '|') => $this->unserializeModel($data),
            is_float($data) => (float) $data,
            is_int($data) => (int) $data,
            is_bool($data) => (bool) $data,
            default => $data
        };
    }

    /**
     * Unserialize the model from a request parameter.
     */
    protected function unserializeModel(string $data): ?Model
    {
        try {
            [$class, $key] = explode('|', $data);

            if (! class_exists($class) || ! is_subclass_of($class, Model::class)) {
                throw new RuntimeException(
                    "Unable to unserialize the model. The class [$class] does not exist."
                );
            }
            /** @var class-string<Model> $class */

            if ($class instanceof RememberUnserializeable) {
                $class->rememberUnserialize($key);
            }

            return $class::query()->findOrFail($key);
        }

        catch (Throwable $e) {
            return null;
        }
    }
}