<?php

declare(strict_types=1);

use Honed\Lang\LangManager;

use function Orchestra\Testbench\workbench_path;

it('has lang helper', function () {
    expect(lang())
        ->toBeInstanceOf(LangManager::class);
});

it('has lang helper with files', function () {
    expect(lang('greetings'))
        ->toBeInstanceOf(LangManager::class)
        ->getTranslations()->toEqual([
            'greetings' => require workbench_path('resources/lang/en/greetings.php'),
        ]);
});
