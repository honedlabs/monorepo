<?php

declare(strict_types=1);

namespace Honed\Refining\Filters;

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
    public function apply(Builder $builder, Request $request): bool
    {
        return false;
    }

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'multiple' => $this->isMultiple(),
            'options' => $this->getOptions(),
        ]);
    }
}