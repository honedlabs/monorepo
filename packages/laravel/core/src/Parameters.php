<?php

namespace Honed\Core;

use Honed\Core\Concerns\HasParameterNames;

class Parameters
{
    /**
     * @use HasParameterNames<\Illuminate\Database\Eloquent\Model, \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>>
     */
    use HasParameterNames {
        getParameterNames as names;
        getSingularName as singular;
        getPluralName as plural;
        getBuilderParameters as builder;
        getModelParameters as model;
    }
}
