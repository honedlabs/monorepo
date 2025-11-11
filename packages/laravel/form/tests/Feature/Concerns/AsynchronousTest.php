<?php

declare(strict_types=1);

use Honed\Form\Components\Search;

beforeEach(function () {
    $this->component = Search::make('name');
});

it('can be pending', function () {
    expect($this->component)
        ->getPending()->toBeNull()
        ->pending('Loading...')->toBe($this->component)
        ->getPending()->toBe('Loading...');
});
