<?php

declare(strict_types=1);

use Honed\Widget\Models\Widget;
use Honed\Widget\QueryBuilder;
use Honed\Widget\WidgetBuilder;

it('uses widget builder', function () {
    expect(Widget::query())
        ->toBeInstanceOf(WidgetBuilder::class)
        ->getQuery()->toBeInstanceOf(QueryBuilder::class);
});
