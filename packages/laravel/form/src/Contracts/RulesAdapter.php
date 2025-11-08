<?php

declare(strict_types=1);

namespace Honed\Form\Contracts;

use Closure;
use Honed\Form\Components\Component;

interface RulesAdapter
{
    /**
     * Get the form component for the request rules.
     *
     * @param  list<string|Closure|\Illuminate\Validation\Rule>  $rules
     */
    public function getRulesComponent(string $key, array $rules): ?Component;
}
