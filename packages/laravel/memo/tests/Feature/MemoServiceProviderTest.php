<?php

declare(strict_types=1);

namespace Honed\Memo\Tests;

use Honed\Memo\Contracts\Memoize;
use Honed\Memo\Facades\Memo;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Honed\Memo\MemoCacheDecorator;
use Honed\Memo\MemoManager;

beforeEach(function () {});

it('extends the cache manager', function () {
    expect(app('cache')->store()->getStore())
        ->toBeInstanceOf(MemoCacheDecorator::class)
        ->getRepository()
        ->scoped(fn ($repository) => $repository
            ->toBeInstanceOf(Repository::class)
            ->getStore()->toBeInstanceOf(ArrayStore::class)
        );
});

it('binds memo', function () {
    expect(app('memo'))->toBeInstanceOf(MemoManager::class);

    expect(app(Memoize::class))->toBeInstanceOf(MemoManager::class);

    expect(Memo::getFacadeRoot())->toBeInstanceOf(MemoManager::class);
});