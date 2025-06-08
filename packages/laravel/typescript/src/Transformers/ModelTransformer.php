<?php

declare(strict_types=1);

namespace Honed\Typescript\Transformers;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use Spatie\TypeScriptTransformer\Structures\TransformedType;
use Spatie\TypeScriptTransformer\Transformers\Transformer;
use Spatie\TypeScriptTransformer\TypeScriptTransformerConfig;

class ModelTransformer implements Transformer
{
    public function __construct(
        protected TypeScriptTransformerConfig $config
    ) { }
    
    public function canTransform(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(Model::class);
    }

    public function transform(
        ReflectionClass $class,
        string $name
    ): TransformedType {
        dd($class);
        
        $type = 'any';

        return TransformedType::create($class, $name, $type);
    }
}