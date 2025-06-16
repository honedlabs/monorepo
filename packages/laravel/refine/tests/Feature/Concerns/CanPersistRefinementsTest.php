<?php

declare(strict_types=1);

use Workbench\App\Refiners\RefineUser;

beforeEach(function () {
    $this->refine = RefineUser::make();
});

it('sets search driver', function () {
    expect($this->refine)
        ->persistSearchInCookie()->toBe($this->refine)
        ->persistSearchInSession()->toBe($this->refine)
        ->persistSearch()->toBe($this->refine);
});

it('sets filter driver', function () {
    expect($this->refine)
        ->persistFilterInCookie()->toBe($this->refine)
        ->persistFilterInSession()->toBe($this->refine)
        ->persistFilter()->toBe($this->refine);
});

it('sets sort driver', function () {
    expect($this->refine)
        ->persistSortInCookie()->toBe($this->refine)
        ->persistSortInSession()->toBe($this->refine)
        ->persistSort()->toBe($this->refine);
});

it('sets persistent driver', function () {
    expect($this->refine)
        ->persistent()->toBe($this->refine);
});