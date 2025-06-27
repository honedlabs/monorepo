<?php

declare(strict_types=1);

use Honed\Refine\Pipes\SortQuery;
use Honed\Refine\Refine;
use Honed\Refine\Sorts\Sort;
use Honed\Refine\Stores\Data\SortData;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->pipe = new SortQuery();

    $this->name = 'name';

    $this->refine = Refine::make(User::class)
        ->sorts(Sort::make($this->name));
});

it('fails', function ($refine) {
    $this->pipe->run($refine);

    expect($refine->getBuilder()->getQuery()->orders)
        ->toBeEmpty();
})->with([
    'no sort key' => function () {
        $request = Request::create('/', 'GET', [
            'invalid' => $this->name,
        ]);

        return $this->refine->request($request);
    },

    'no matching sort' => function () {
        $request = Request::create('/', 'GET', [
            $this->refine->getSortKey() => 'missing',
        ]);

        return $this->refine->request($request);
    },

    'disabled' => function () {
        $request = Request::create('/', 'GET', [
            $this->refine->getSortKey() => $this->name,
        ]);

        return $this->refine->notSortable()->request($request);
    },

    'scope' => function () {
        $request = Request::create('/', 'GET', [
            $this->refine->getSortKey() => $this->name,
        ]);

        return $this->refine->scope('scope')->request($request);
    },
    'session' => function () {
        $data = new SortData($this->name, Sort::ASCENDING);

        Session::put($this->refine->getPersistKey(), [
            $this->refine->getSortKey() => $data->toArray(),
        ]);

        return $this->refine;
    },

    'cookie' => function () {
        $data = new SortData($this->name, Sort::ASCENDING);

        $request = Request::create('/', 'GET', cookies: [
            $this->refine->getPersistKey() => json_encode([
                $this->refine->getSortKey() => $data->toArray(),
            ]),
        ]);

        return $this->refine->request($request);
    },
]);

it('passes', function ($refine, $direction = Sort::ASCENDING) {
    $this->pipe->run($refine);

    expect($refine->getBuilder()->getQuery()->orders)
        ->toBeOnlyOrder($this->name, $direction);
})->with([
    'request' => function () {
        $request = Request::create('/', 'GET', [
            $this->refine->getSortKey() => $this->name,
        ]);

        return $this->refine->request($request);
    },

    'direction' => function () {
        $request = Request::create('/', 'GET', [
            $this->refine->getSortKey() => '-'.$this->name,
        ]);

        return [$this->refine->request($request), Sort::DESCENDING];
    },

    'scope' => function () {
        $this->refine->scope('scope');

        $request = Request::create('/', 'GET', [
            $this->refine->getSortKey() => $this->name,
        ]);

        return $this->refine->request($request);
    },

    'session' => function () {
        $data = new SortData($this->name, Sort::ASCENDING);

        Session::put($this->refine->getPersistKey(), [
            $this->refine->getSortKey() => $data->toArray(),
        ]);

        return $this->refine->persistSortInSession();
    },

    'cookie' => function () {
        $data = new SortData($this->name, Sort::ASCENDING);

        $request = Request::create('/', 'GET', cookies: [
            $this->refine->getPersistKey() => json_encode([
                $this->refine->getSortKey() => $data->toArray(),
            ]),
        ]);

        return $this->refine->request($request)->persistSortInCookie();
    },
]);

it('applies default sort', function () {
    $name = 'price';

    $request = Request::create('/', 'GET', [
        $this->refine->getSortKey() => 'missing',
    ]);

    $this->pipe->run(
        $this->refine
            ->sorts(Sort::make($name)->default())
            ->request($request)
    );

    expect($this->refine->getBuilder()->getQuery()->orders)
        ->toBeOnlyOrder($name, Sort::ASCENDING);
});
