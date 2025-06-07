<?php

declare(strict_types=1);

use Honed\Refine\Refine;
use Honed\Refine\Search;
use Workbench\App\Models\User;

beforeEach(function () {
    Refine::useSearchKey();
    Refine::useMatchKey();
    $this->test = Refine::make(User::class);
});

it('is empty by default', function () {
    expect($this->test)
        ->isSearching()->toBeFalse()
        ->getSearches()->toBeEmpty();
});

it('adds searches', function () {
    expect($this->test)
        ->withSearches([Search::make('name')])->toBe($this->test)
        ->withSearches([Search::make('price')])->toBe($this->test)
        ->getSearches()->toHaveCount(2);
});

it('adds searches variadically', function () {
    expect($this->test)
        ->withSearches(Search::make('name'), Search::make('price'))->toBe($this->test)
        ->getSearches()->toHaveCount(2);
});

it('adds searches collection', function () {
    expect($this->test)
        ->withSearches(collect([Search::make('name'), Search::make('price')]))->toBe($this->test)
        ->getSearches()->toHaveCount(2);
});

it('has search key', function () {
    expect($this->test)
        ->getSearchKey()->toBe(config('refine.search_key'))
        ->searchKey('test')->toBe($this->test)
        ->getSearchKey()->toBe('test');
});

it('match', function () {
    expect($this->test)
        ->getMatchKey()->toBe(config('refine.match_key'))
        ->matchKey('test')->toBe($this->test)
        ->getMatchKey()->toBe('test');
});

it('matches', function () {
    expect($this->test)
        ->matches()->toBe(config('refine.match'));

    expect($this->test->match())->toBe($this->test)
        ->matches()->toBeTrue();
});

it('has term', function () {
    expect($this->test)
        ->getTerm()->toBeNull()
        ->term('test')->toBe($this->test)
        ->getTerm()->toBe('test');
});

it('enables and disables searching', function () {
    expect($this->test)
        // base case
        ->searchingEnabled()->toBeTrue()
        ->searchingDisabled()->toBeFalse()
        // disable
        ->disableSearching()->toBe($this->test)
        ->searchingEnabled()->toBeFalse()
        ->searchingDisabled()->toBeTrue()
        // enable
        ->enableSearching()->toBe($this->test)
        ->searchingEnabled()->toBeTrue()
        ->searchingDisabled()->toBeFalse();
});

it('searches to array', function () {
    expect($this->test)
        ->withSearches([Search::make('name'), Search::make('price')])->toBe($this->test)
        ->searchesToArray()->toBeEmpty();

    expect($this->test->match())
        ->searchesToArray()->toHaveCount(2)
        ->each->scoped(fn ($search) => $search
        ->toHaveKeys([
            'name',
            'label',
            'type',
            'active',
            'meta',
        ])
        );
});

it('hides searches from serialization', function () {
    expect($this->test->match())
        ->withSearches([Search::make('name')])->toBe($this->test)
        ->searchesToArray()->toHaveCount(1)
        ->disableSearching()->toBe($this->test)
        ->searchesToArray()->toBeEmpty();
});
