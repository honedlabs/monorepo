<?php

declare(strict_types=1);
use Illuminate\Support\Str;

it('tests', function () {
    // dd(Str::match('/persist([A-Z].+)$/', 'persistTest')); -> setDriver $ [$parameter]
    // dd(Str::match('/isPersisting([A-Z].+)$/', 'isPersistingTest')); -> isPersisting $
    // dd(Str::match('/get([A-Z].+)Store/', 'getTestCaseStore')); -> getDriver $
    preg_match('/persist([A-Z].+)In([A-Z].+)$/', 'persistUserInDatabase', $matches); // -> setDriver $0 $1
    dd(array_slice($matches, 1));
})->only();

    // persist[name]

    // isPersisting[name]

    // get[name]Store
    
    // persist[name]In[driver]
