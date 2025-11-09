<?php

declare(strict_types=1);

use Honed\Form\Components\Lookup;

beforeEach(function () {
    $this->component = Lookup::make('name');
});

it('can be pending', function () {
    expect($this->component)
        ->getPending()->toBeNull()
        ->pending('Loading...')->toBe($this->component)
        ->getPending()->toBe('Loading...');
});
