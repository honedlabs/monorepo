<?php

declare(strict_types=1);

namespace Honed\Form\Attributes\Components;

use Attribute;
use Honed\Form\Components\Search;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class AsSearch extends Component
{
    public function __construct(
        mixed ...$arguments
    ) {
        parent::__construct(Search::class, ...$arguments);
    }
}
