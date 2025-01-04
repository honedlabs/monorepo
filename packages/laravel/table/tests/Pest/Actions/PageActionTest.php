<?php

use Honed\Table\Actions\PageAction;
use Symfony\Component\HttpFoundation\Request;

beforeEach(function () {
    $this->action = PageAction::make('test');
});

it('is type page', function () {
    expect($this->action->getType())->toBe('page');
});

it('has array representation', function () {
    expect($this->action->toArray())->toEqual([
        'type' => 'page',
        'name' => 'test',
        'label' => 'Test',
        'meta' => [],
    ]);
});

it('forwards calls to url', function () {
    expect($this->action->url->url('/products'))->toBeInstanceOf(PageAction::class)
        ->toArray()->toEqual([
            'type' => 'page',
            'name' => 'test',
            'label' => 'Test',
            'meta' => [],
            'url' => '/products',
            'method' => Request::METHOD_GET,
        ]);
});
