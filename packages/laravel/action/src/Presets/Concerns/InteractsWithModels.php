<?php

declare(strict_types=1);

namespace Honed\Action\Presets\Concerns;

use Illuminate\Database\Eloquent\Model;

trait InteractsWithModels
{
    /**
     * Get the key of the model.
     * 
     * @param \Illuminate\Database\Eloquent\Model|int|string $model
     */
    protected function getKey($model)
    {
        if ($model instanceof Model) {
            return $model->getKey();
        }

        return $model;
    }

}