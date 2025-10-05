<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

use Honed\Infolist\Entries\ImageEntry;
use Honed\Table\Contracts\Column as ColumnContract;
use Honed\Table\Concerns\AsColumn;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 */
class ImageColumn extends ImageEntry implements ColumnContract
{
    /**
     * @use \Honed\Table\Concerns\AsColumn<TModel, TBuilder>
     */
    use AsColumn;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'column';
}
