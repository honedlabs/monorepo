<?php

declare(strict_types=1);

use Intervention\Validation\AbstractRule;
use Spatie\LaravelData\Contracts\BaseData;
use Spatie\LaravelData\DataPipes\DataPipe;
use Spatie\LaravelData\Normalizers\Normalizer;
use Spatie\LaravelData\Transformers\Transformer;

beforeEach(function () {})->only();

arch()->preset()->php();

arch()->preset()->security();

arch('debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('strict types')
    ->expect('Honed\Data')
    ->toUseStrictTypes();

arch('concerns')
    ->expect('Honed\Data\Concerns')
    ->toBeTraits();

arch('contracts')
    ->expect('Honed\Data\Contracts')
    ->toBeInterfaces();

arch('data')
    ->expect('Honed\Data\Data')
    ->toBeClasses()
    ->toImplement(BaseData::class)
    ->toHaveSuffix('Data');

arch('data pipes')
    ->expect('Honed\Data\DataPipes')
    ->toBeClasses()
    ->toImplement(DataPipe::class)
    ->toHaveSuffix('DataPipe');

arch('exceptions')
    ->expect('Honed\Data\Exceptions')
    ->toBeClasses()
    ->toExtend(Exception::class)
    ->toHaveSuffix('Exception');

arch('normalizers')
    ->expect('Honed\Data\Normalizers')
    ->toBeClasses()
    ->toImplement(Normalizer::class)
    ->toHaveSuffix('Normalizer');

arch('rules')
    ->expect('Honed\Data\Rules')
    ->toBeClasses()
    ->toExtend(AbstractRule::class);

arch('transformers')
    ->expect('Honed\Data\Transformers')
    ->toBeClasses()
    ->toImplement(Transformer::class);