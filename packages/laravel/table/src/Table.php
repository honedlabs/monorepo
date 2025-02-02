<?php

declare(strict_types=1);

namespace Honed\Table;

use Closure;
use Exception;
use Honed\Refine\Refine;
use Honed\Core\Primitive;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Honed\Core\Concerns\Encodable;
use Illuminate\Support\Collection;
use Honed\Table\Actions\BulkAction;
use Honed\Table\Columns\BaseColumn;
use Honed\Core\Concerns\RequiresKey;
use Honed\Refine\Concerns\HasRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Honed\Core\Exceptions\MissingRequiredAttributeException;

class Table extends Refine
{
    use Concerns\HasRecords;
    use Concerns\HasPages;
    use Concerns\HasColumns;
    use Concerns\HasEndpoint;
    use Concerns\Searchable;
    use Concerns\HasResource;
    use Concerns\Toggleable;
    use Concerns\HasResourceModifier;
    use Encodable;
    use RequiresKey;

    public static function make($modifier): static
    {
        return resolve(static::class)->modifier($modifier);
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
     * Build the table records and metadata using the current request.
     * 
     * @return $this
     */
    protected function buildTable(): static
    {
        if ($this->refined) {
            return $this;
        }

        $resource = $this->getResource();

        $columns = $this->getColumns();

        $activeColumns = $this->toggleColumns($columns);
        
        $this->modifyResource($resource);

        $this->refine();
        
        $records = $this->paginateRecords($resource);
        $formatted = $this->formatRecords($records, $activeColumns, $this->getInlineActions(), $this->getSelector());
        $this->setRecords($formatted);

        return $this;
    }

    public function toArray(): array
    {
        $this->buildTable();

        return [
            'id' => $this->encodeClass(),
            'endpoint' => $this->isAnonymous() ? null : $this->getEndpoint(),
            'toggleable' => $this->isToggleable(),
            'keys' => [
                'records' => $this->getKeyName(),
                'sorts' => $this->getSortKey(),
                'order' => $this->getOrderKey(),
                'search' => $this->getSearchKey(),
                'toggle' => $this->getToggleKey(),
                'shown' => $this->getShownKey(),
            ],
            'records' => $this->getRecords(),
            'columns' => $this->getColumns(),
            'actions' => [
                'bulk' => $this->getBulkActions(),
                'page' => $this->getPageActions(),
            ],
            'filters' => $this->getFilters(),
            'sorts' => $this->getSorts(),
            'pages' => $this->getPages(),
        ];
    }
}
