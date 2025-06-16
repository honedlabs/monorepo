<?php

declare(strict_types=1);

namespace Honed\List;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasType;
use Honed\Core\Primitive;

class Entry extends Primitive
{
    use Allowable;
    use HasType;

    /**
     * Create a new list entry.
     * 
     * @param  string  $label
     * @param  string|\Closure  $value
     * @return \Honed\List\Entry
     */
    public static function make(?string $label = null, mixed $value = null)
    {
        return resolve(static::class)
            ->label($label)
            ->value($value);
    }

    /**
     * Get the instance as an array.
     * 
     * @return array<string, mixed>
     */
    public function toArray($named = [], $typed = [])
    {
        return [
            'type' => $this->getType(),
            'label' => $this->getLabel(),
            'value' => $this->getValue(),
            'none' => $this->isDefaulted(),
        ];
    }

    protected function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
    {
        return match ($parameterName) {
            // 'record', 'row' => [$this->getRecord()],
            // 'state' => [$this->getState()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * @return array<mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
    {
        // $record = $this->getRecord();

        // if (! $record) {
        //     return parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType);
        // }

        return match ($parameterType) {
            // Model::class, $record::class => [$record],
            default => parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
        };
    }

}