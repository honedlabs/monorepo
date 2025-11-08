<?php

declare(strict_types=1);

namespace Honed\Form;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Honed\Form\Contracts\Generator;
use Honed\Form\Generators\DataGenerator;
use Honed\Form\Exceptions\CannotResolveGenerator;

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
     * @throws CannotResolveGenerator
     */
    public static function to(string $className): Generator
    {
        return match (true) {
            is_a($className, Data::class) => DataGenerator::make($className),
            // is_a($className, Request::class) => RequestGenerator::make($className),
            default => CannotResolveGenerator::throw($className),
        };
    }
}