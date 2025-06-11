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
     * @return int|string
     */
    protected function getKey($model)
    {
        if ($model instanceof Model) {
            /** @var int|string */
            return $model->getKey();
        }

        return $model;
    }


    /**
     * Indicate whether touched columns should be updated.
     * 
     * @return bool
     */
    protected function shouldTouch()
    {
        return true;
    }

}