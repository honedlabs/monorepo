<?php

declare(strict_types=1);

use Honed\Form\Attributes\Components\AsSearch;
use Honed\Form\Attributes\Components\Component;
use Honed\Form\Components\Search;

it('has search component', function () {
    $attribute = new AsSearch(test: true);

    expect($attribute)
        ->toBeInstanceOf(Component::class)
        ->getComponent()->toBe(Search::class)
        ->getArguments()->toBe([
            'test' => true,
        ]);
});
