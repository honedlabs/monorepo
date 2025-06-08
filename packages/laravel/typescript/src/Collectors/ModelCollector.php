<?php

namespace Honed\Typescript\Collectors;

use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Honed\Typescript\Transformers\ModelTransformer;
use Spatie\TypeScriptTransformer\Collectors\Collector;
use Spatie\TypeScriptTransformer\Structures\TransformedType;

class ModelCollector extends Collector
{
    public function shouldCollect(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(Model::class);
    }
    
     public function getTransformedType(ReflectionClass $class): ?TransformedType
     {
        if(! $class->isSubclassOf(Model::class))
        {
            return null;
        }
     
        $transformer = new ModelTransformer($this->config);
        
        return $transformer->transform(
            $class,
            Str::before($class->getShortName(), 'Resource')
        );
     }
}