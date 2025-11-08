<?php

declare(strict_types=1);

use Honed\Form\Support\Route;

beforeEach(function () {
    $this->route = new Route('users.index');
});

it('gets value', function () {
    expect($this->route)
        ->name->toBe('users.index')
        ->parameters->toBe([])
        ->getValue()->toBe(route('users.index'));
});
