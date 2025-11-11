<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Honed\Form\Attributes\Component;
use Honed\Form\Components\Search;

class AsSearch extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(Search::class, ...$arguments);
    }
}
