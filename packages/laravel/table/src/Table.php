<?php

declare(strict_types=1);

namespace Honed\Table;

use Honed\Refine\Refine;
use Honed\Table\Columns\Column;
use Honed\Core\Concerns\Encodable;
use Honed\Core\Concerns\RequiresKey;
use Honed\Action\Concerns\HasActions;
use Illuminate\Database\Eloquent\Builder;
use Honed\Core\Exceptions\MissingRequiredAttributeException;

class Table extends Refine
{
    use Concerns\HasColumns;
    use Concerns\HasModifier;
    use Concerns\HasPages;
    use Concerns\HasRecords;
    use Concerns\HasResource;
    use Concerns\HasToggle;
    use Encodable;
    use HasActions;
    use RequiresKey;

    /**
     * @param \Closure|null $modifier
     */
    public static function make($modifier = null): static
    {
        return resolve(static::class)
            ->modifier($modifier);
    }

    /**
     * Get the key name for the table records.
     *
     * @throws \Honed\Core\Exceptions\MissingRequiredAttributeException
     */
    public function getKeyName(): string
    {
        try {
            return $this->getKey();
        } catch (MissingRequiredAttributeException $e) {
            return $this->getKeyColumn()?->getName() ?? throw $e;
        }
    }

    /**
     * @return $this
     */
    public function buildTable(): static
    {
        if ($this->isRefined()) {
            return $this;
        }

        $this->builder($this->getResource());
        
        $activeColumns = $this->toggle();
        
        $this->modify();
        
        $this->refine();
        
        $this->paginateRecords();
        
        $this->formatRecords($activeColumns);

        return $this;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        $this->buildTable();

        return [
            'id' => $this->encode(static::class),
            'records' => $this->getRecords(),
            'meta' => $this->getMeta(),
            'columns' => $this->getColumns()
                ->filter(static fn (Column $column) => $column->isActive())
                ->toArray(),
            'pages' => $this->getPages(),
            'filters' => $this->getFilters(),
            'sorts' => $this->getSorts(),
            'toggleable' => $this->isToggleable(),
            'actions' => $this->actionsToArray(),
            'endpoint' => $this->getEndpoint(),
            'keys' => [
                'records' => $this->getKeyName(),
                'sorts' => $this->getSortKey(),
                'order' => $this->getOrderKey(),
                'search' => $this->getSearchKey(),
                'toggle' => $this->getToggleKey(),
                'pages' => $this->getPagesKey(),
                ...($this->hasMatches() ? ['match' => $this->getMatchKey()] : []),
            ],
        ];
    }

    /**
     * @return array<mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        return match ($parameterName) {
            'resource' => [$this->getResource()],
            'query' => [$this->getResource()],
            default => [],
        };
    }

    /**
     * @return array<mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType(string $parameterType): array
    {
        return match ($parameterType) {
            Builder::class => [$this->getResource()],
            default => [],
        };
    }
}
