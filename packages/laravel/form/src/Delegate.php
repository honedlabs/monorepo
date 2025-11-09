<?php

declare(strict_types=1);

namespace Honed\Form;

use Honed\Form\Contracts\Generator;
use Honed\Form\Exceptions\CannotResolveGenerator;
use Honed\Form\Generators\DataGenerator;
use Honed\Form\Generators\RequestGenerator;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class Delegate
{
    /**
     * Delegate the generation of a form to the appropriate generator.
     *
     * @template T of \Spatie\LaravelData\Data|\Illuminate\Http\Request
     *
     * @param  class-string<T>  $className
     * @return Generator<T>
     *
     * @phpstan-return Generator<Data>|Generator<Request>
     *
     * @throws CannotResolveGenerator
     */
    public static function to(string $className): Generator
    {
        if (is_a($className, Data::class, true)) {
            /** @phpstan-assert class-string<\Spatie\LaravelData\Data> $className */
            return DataGenerator::make($className);
        }

        if (is_a($className, Request::class, true)) {
            /** @phpstan-assert class-string<\Illuminate\Http\Request> $className */
            return RequestGenerator::make($className);
        }

        CannotResolveGenerator::throw($className);
    }
}
