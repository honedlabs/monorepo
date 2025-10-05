<?php

declare(strict_types=1);

use Illuminate\Support\Arr;

use function Orchestra\Testbench\workbench_path;

beforeEach(function () {
    $this->lang = app('lang');

    $this->greetings = require workbench_path('resources/lang/en/greetings.php');
    $this->auth = require workbench_path('resources/lang/en/auth.php');
});

it('sets string lang files', function () {
    expect($this->lang)
        ->use('greetings')->toBe($this->lang)
        ->getTranslations()->toEqualCanonicalizing([
            'greetings' => $this->greetings,
        ])
        ->use('greetings')->toBe($this->lang)
        ->getTranslations()->toEqualCanonicalizing([
            'greetings' => $this->greetings,
        ]);
});

it('sets array lang files', function () {
    expect($this->lang)
        ->use(['greetings', 'auth'])->toBe($this->lang)
        ->getTranslations()->toEqualCanonicalizing([
            'greetings' => $this->greetings,
            'auth' => $this->auth,
        ]);
});

it('sets variadic lang files', function () {
    expect($this->lang)
        ->use('greetings', 'auth')->toBe($this->lang)
        ->getTranslations()->toEqualCanonicalizing([
            'greetings' => $this->greetings,
            'auth' => $this->auth,
        ]);
});

it('sets locale', function () {
    expect($this->lang)
        ->getLocale()->toBe(app()->getLocale())
        ->locale('es')->toBeTrue()
        ->getLocale()->toBe('es')
        ->locale('fr')->toBeFalse()
        ->getLocale()->toBe('es');
});

it('has available locales', function () {
    expect($this->lang)
        ->availableLocales()->toEqualCanonicalizing(['en', 'es']);
});

it('has lang path', function () {
    expect($this->lang)
        ->getLangPath()->toBe(workbench_path('resources/lang'));
});

it('gets only some keys', function () {
    expect($this->lang)
        ->use('greetings')->toBe($this->lang)
        ->only('greetings.greeting.morning')->toBe($this->lang)
        ->getTranslations()->toEqualCanonicalizing([
            'greetings' => [
                'greeting' => [
                    'morning' => Arr::get(require workbench_path('resources/lang/en/greetings.php'), 'greeting.morning'),
                ],
            ],
        ]);
});

it('gets only some keys with locale', function () {
    expect($this->lang)
        ->locale('es')->toBeTrue()
        ->use('greetings')->toBe($this->lang)
        ->only('greetings.greeting.morning')->toBe($this->lang)
        ->getTranslations()->toEqualCanonicalizing([
            'greetings' => [
                'greeting' => [
                    'morning' => Arr::get(require workbench_path('resources/lang/es/greetings.php'), 'greeting.morning'),
                ],
            ],
        ]);
});

it('gets only some keys with using', function () {
    expect($this->lang)
        ->using('greetings', 'greetings.greeting.morning')->toBe($this->lang)
        ->getTranslations()->toEqualCanonicalizing([
            'greetings' => [
                'greeting' => [
                    'morning' => Arr::get($this->greetings, 'greeting.morning'),
                ],
            ],
        ]);
});