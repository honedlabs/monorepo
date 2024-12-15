<?php

namespace Honed\Crumb\Concerns;

use Honed\Crumb\Attributes\Crumb;
use Honed\Crumb\Exceptions\CrumbsNotFoundException;
use ReflectionClass;

trait Crumbs
{
    protected function getCrumb(): string
    {
        if (\property_exists($this, 'crumb')) {
            return $this->crumb;
        }

        if (\method_exists($this, 'crumb')) {
            return $this->crumb();
        }

        // throw new CrumbNameMissingException($this);

        $reflection = new ReflectionClass($this);
        
        // $currentMethod = $reflection->getMethods()
        //     ->first(fn ($method) => $method->isConstructor() === false && $method->getCaller());

        // if ($currentMethod !== null) {
        //     $methodAttributes = $currentMethod->getAttributes(Crumb::class);

        //     if (! empty($methodAttributes)) {
        //         return $methodAttributes[0]->newInstance()->crumb();
        //     }
        // }

        // $classAttributes = $reflection->getAttributes(Crumb::class);

        // if (empty($classAttributes)) {
        //     throw new CrumbsNotFoundException(
        //         sprintf('No crumb found for %s', $reflection->getName())
        //     );
        // }

        // return $classAttributes[0]->newInstance()->crumb();
    }

    public function __destruct()
    {
        // Find the crumbs -> run share
    }
}
