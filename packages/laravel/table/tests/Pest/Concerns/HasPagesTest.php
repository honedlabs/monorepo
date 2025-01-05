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
    
}

beforeAll(function () {
    foreach (\range(1, 10) as $i) {
        product();
    }
});

beforeEach(function () {
    HasPagesTest::usePageKey();
    HasPagesTest::usePaginator();
    HasPagesTest::recordsPerPage();
    HasPagesTest::useCountKey();
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

it('configures count key', function () {
    HasPagesTest::useCountKey('num');
    expect($this->test->getCountKey())
        ->toBe('num');

    expect($this->method->getCountKey())
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

it('retrieves count key', function () {
    expect($this->test)
        ->getCountKey()->toBe('show');
    
    expect($this->method)
        ->getCountKey()->toBe('records');
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

});