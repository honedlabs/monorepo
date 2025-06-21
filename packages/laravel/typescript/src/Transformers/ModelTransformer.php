<?php

declare(strict_types=1);

namespace Honed\Typescript\Transformers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use ReflectionClass;
use Spatie\TypeScriptTransformer\Structures\TransformedType;
use Spatie\TypeScriptTransformer\Transformers\Transformer;
use Spatie\TypeScriptTransformer\TypeScriptTransformerConfig;

class ModelTransformer implements Transformer
{
    public function __construct(
        protected TypeScriptTransformerConfig $config
    ) { }
    
    /**
     * Determine if the transformer can transform the model.
     *
     * @param ReflectionClass $class
     * @return bool
     */
    public function canTransform(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(Model::class);
    }

    /**
     * Transform the model.
     *
     * @param ReflectionClass $class
     * @param string $name
     * @return TransformedType
     */
    public function transform(ReflectionClass $class, string $name): TransformedType
    {
        
        $transformed = 'any';

        return TransformedType::create($class, $name, $transformed);
    }

    public function getProperties(ReflectionClass $class)
    {

    }

    public function getSingularRelations(ReflectionClass $class)
    {

    }

    public function getManyRelations(ReflectionClass $class)
    {

    }

    public function getAttributes(ReflectionClass $class)
    {

    }

    public function getCasts(ReflectionClass $class)
    {

    }
}