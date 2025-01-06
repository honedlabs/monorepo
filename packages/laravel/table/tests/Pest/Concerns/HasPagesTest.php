<?php

declare(strict_types=1);

use Honed\Table\Concerns\HasPages;
use Honed\Table\PageAmount;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class HasPagesTest
{
    use HasPages;
}

class HasPagesMethodTest extends HasPagesTest
{
    public function page()
    {
        return 'page';
    }

    public function paginator()
    {
        return 'length-aware';
    }

    public function shown()
    {
        return 'records';
    }

    public function perPage()
    {
        return [10, 20, 50];
    }

    public function defaultPerPage()
    {
        return 20;
    }
    
}

beforeEach(function () {
    HasPagesTest::usePageKey();
    HasPagesTest::usePaginator();
    HasPagesTest::recordsPerPage();
    HasPagesTest::useShownKey();
    $this->test = new HasPagesTest();
    $this->method = new HasPagesMethodTest();
});

it('configures page key', function () {
    HasPagesTest::usePageKey('p');
    expect($this->test->getPageKey())
        ->toBe('p');

    expect($this->method->getPageKey())
        ->toBe('page');
});

it('configures shown key', function () {
    HasPagesTest::useShownKey('num');
    expect($this->test->getShownKey())
        ->toBe('num');

    expect($this->method->getShownKey())
        ->toBe('records');
});

it('configures records per page', function () {
    HasPagesTest::recordsPerPage([5, 10, 20]);
    expect($this->test->getPerPage())
        ->toBe([5, 10, 20]);

    expect($this->method->getPerPage())
        ->toBe([10, 20, 50]);
});

it('configures paginator', function () {
    HasPagesTest::usePaginator('cursor');
    expect($this->test->getPaginator())
        ->toBe('cursor');

    expect($this->method->getPaginator())
        ->toBe('length-aware');
});

it('retrieves per page', function () {
    expect($this->test)
        ->getPerPage()->toBe($this->test->getDefaultPerPage());
    
    expect($this->method)
        ->getPerPage()->toBe([10, 20, 50]);
});

it('retrieves default per page', function () {
    expect($this->test)
        ->getDefaultPerPage()->toBe(10);
    
    expect($this->method)
        ->getDefaultPerPage()->toBe(20);
});

it('retrieves paginator', function () {
    expect($this->test)
        ->getPaginator()->toBe(LengthAwarePaginator::class);
    
    expect($this->method)
        ->getPaginator()->toBe('length-aware');

});

it('retrieves page key', function () {
    expect($this->test)
        ->getPageKey()->toBeNull();
    
    expect($this->method)
        ->getPageKey()->toBe('page');
});

it('retrieves shown key', function () {
    expect($this->test)
        ->getShownKey()->toBe('show');
    
    expect($this->method)
        ->getShownKey()->toBe('records');
});

it('sets pages', function () {
    $this->test->setPages(collect([PageAmount::make(10), PageAmount::make(20)]));

    expect($this->test)
        ->hasPages()->toBeTrue()
        ->getPages()->scoped(fn ($pages) => $pages
            ->toHaveCount(2)
            ->sequence(
                fn ($page) => $page
                    ->getValue()->toBe(10)
                    ->isActive()->toBeFalse(),
                fn ($page) => $page
                    ->getValue()->toBe(20)
                    ->isActive()->toBeFalse(),
            )
        );
});

it('gets number of records from empty request', function () {

});

it('gets number of records when not array', function () {

});

it('gets number of records from request', function () {

});

// Complete pagionation pipeline
it('paginates', function () {
    foreach (\range(1, 10) as $i) {
        product();
    }

});