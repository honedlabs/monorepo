<?php

declare(strict_types=1);

use Honed\Lang\Facades\Lang;

use function Orchestra\Testbench\workbench_path;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->auth = require workbench_path('resources/lang/en/auth.php');

    $this->lang = Lang::getFacadeRoot();
});

it('does not set locale if not in session', function () {
    get('/localize');
    expect($this->lang)
        ->getLocale()->toBe(app()->getLocale());
});

it('sets locale if in session', function () {
    session()->put('_lang', 'es');
    get('/localize');
    expect($this->lang)
        ->getLocale()->toBe('es');
});

it('does not set locale if not config', function () {
    config()->set('lang.session', false);
    session()->put('_lang', 'es');
    get('/localize');
    expect($this->lang)
        ->getLocale()->toBe(app()->getLocale())
        ->getLocale()->not->toBe('es');
});
