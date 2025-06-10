<?php

declare(strict_types=1);

namespace Honed\Refine\Filters;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends \Honed\Refine\Filters\Filter<TModel, TBuilder>
 */
final class TrashedFilter extends Filter
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'trashed';

    /**
     * {@inheritdoc}
     */
    protected $name = 'trashed';

    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected $label = 'Show deleted';

    public function type()
    {
        return 'trashed';
    }

    public function definition(Filter $filter)
    {
        return $filter
            ->name('trashed')
            ->label('Show deleted')
            ->options([
                'with' => 'With deleted',
                'only' => 'Only deleted',
                'without' => 'Without deleted',
            ])
            ->query(function ($builder, $value) {
                return match ($value) {
                    'with' => $builder->withTrashed(),
                    'only' => $builder->onlyTrashed(),
                    default => $builder->withoutTrashed(),
                };
            });
    }

    /**
     * Create a new trashed filter instance.
     *
     * @return static
     */
    public static function new()
    {
        return resolve(self::class);
    }
}
