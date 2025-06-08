<?php

namespace Honed\Typescript\Collectors;

use ReflectionClass;
use Illuminate\Database\Eloquent\Model;
use Spatie\TypeScriptTransformer\Collectors\DefaultCollector;
use Spatie\TypeScriptTransformer\Structures\TransformedType;
use Spatie\TypeScriptTransformer\TypeReflectors\ClassTypeReflector;

class ModelCollector extends DefaultCollector
{
    /**
    * Determine if the collector should collect the class.
    *
    * @param ReflectionClass $class
    * @return bool
    */
    protected function shouldCollect(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(Model::class);
    }
    
    /**
    * Get the transformed type from the model.
    * 
    * @param ReflectionClass $class
    * @return TransformedType|null
    */
    public function getTransformedType(ReflectionClass $class): ?TransformedType
    {
        if(! $this->shouldCollect($class)) {
            return null;
        }
        
        $reflector = ClassTypeReflector::create($class);

        $transformedType = $reflector->getType()
            ? $this->resolveAlreadyTransformedType($reflector)
            : $this->resolveTypeViaTransformer($reflector);
        
        if ($reflector->isInline()) {
            $transformedType->name = null;
            $transformedType->isInline = true;
        }
        
        return $transformedType;
    }
}