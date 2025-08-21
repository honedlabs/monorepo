<?php

declare(strict_types=1);

use Honed\Form\Abstracts\Component;
use Illuminate\Console\Command;

arch()->preset()->php();

arch()->preset()->security();

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Flash')
    ->toUseStrictTypes();

arch('abstracts')
    ->expect('Honed\Form\Abstracts')
    ->toBeClasses()
    ->toBeAbstract();

arch('commands')
    ->expect('Honed\Form\Commands')
    ->toBeClasses()
    ->toExtend(Command::class);

arch('components')
    ->expect('Honed\Form\Components')
    ->toBeClasses()
    ->toExtend(Component::class);

arch('concerns')
    ->expect('Honed\Form\Concerns')
    ->toBeTraits();

arch('contracts')
    ->expect('Honed\Form\Contracts')
    ->toBeInterfaces();

arch('enums')
    ->expect('Honed\Form\Enums')
    ->toBeEnums();
