<?php

declare(strict_types=1);

namespace Honed\Refining\Filters;

use Honed\Refining\Filters\Concerns\Option;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SetFilter extends Filter
{
    use Concerns\HasOptions;
    use Concerns\IsMultiple;

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        $this->type('set');
    }

    /**
     * @inheritdoc
     */
    public function isActive(): bool
    {
        if (! $this->isMultiple()) {
            return parent::isActive();
        }

        $value = $this->getValue();

        return parent::isActive() 
            && \is_array($value) 
            && \count($value) > 0;
    }

    /**
     * @inheritdoc
     */
    public function apply(Builder $builder, Request $request): bool
    {
        $rawValue = $this->getValueFromRequest($request);

        $options = \array_filter(
            $this->getOptions(),
            fn (Option $option) => $option->active(
                \in_array(
                    $option->getValue(), 
                    (array) $rawValue, 
                    true
                ))->isActive(),
        );

        $value = match (true) {
            $this->isMultiple() => \array_map(
                fn (Option $option) => $option->getValue(), 
                $options),
            default => \array_shift($options)?->getValue(),
        };

        $this->value($value);

        if (! $this->isActive() || !$this->validate($value)) {
            return false;
        }

        if ($this->isMultiple()) {
            $this->handleMultiple($builder, $value, $this->getAttribute());
            return true;
        }

        parent::handle($builder, $value, $this->getAttribute());

        return true;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model> $builder
     * @param non-empty-array<int,mixed>|string|int $value
     */
    private function handleMultiple(Builder $builder, array $value, string $property): void
    {
        $builder->whereIn(
            column: $builder->qualifyColumn($property),
            values: $value,
            boolean: 'and'
        );
    }

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'multiple' => $this->isMultiple(),
            'options' => $this->getOptions(),
        ]);
    }

    public function getValueFromRequest(Request $request): array|string|null
    {
        $value = parent::getValueFromRequest($request);

        if (! $this->isMultiple()) {
            return $value;
        }

        return \explode(',', (string) $value);
    }
}