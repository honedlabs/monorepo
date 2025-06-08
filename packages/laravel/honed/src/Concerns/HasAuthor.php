<?php

namespace Honed\Honed\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Foundation\Auth\User
 * 
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait HasAuthor
{
    /**
     * Boot the HasAuthor trait.
     * 
     * @return void
     */
    public static function bootHasAuthor()
    {
        static::creating(function (self $model) {
            $touchedBy = $model->getTouchedByKey();

            $model->setAuthor($touchedBy);
            $model->setEditor($touchedBy);
        });

        static::updating(function (self $model) {
            $model->setEditor($model->getTouchedByKey());
        });
    }
    /**
     * Get the user that created the model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TModel, $this>
     */
    public function author()
    {
        $model = $this->authorModel();

        return $this->belongsTo(
            $model,
            $this->getAuthorColumn(),
            (new $model())->getKeyName(),
        );
    }

    /**
     * Get the user that last edited the model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TModel, $this>
     */
    public function editor()
    {
        $model = $this->getAuthorModel();

        return $this->belongsTo(
            $model,
            $this->getEditorColumn(),
            (new $model())->getKeyName(),
        );
    }

    /**
     * Get the user model for the application.
     * 
     * @return class-string<\Illuminate\Foundation\Auth\User>
     */
    public function getAuthorModel()
    {
        return Config::get('auth.providers.users.model', User::class);
    }

    /**
     * Get the model which is initiating the action.
     * 
     * @return \Illuminate\Database\Eloquent\Model|int|string|null
     */
    public function touchedBy()
    {
        return Auth::id();
    }

    /**
     * Get the identifying key of the initiating model to update this model.
     * 
     * @return int|string|null
     */
    public function getTouchedByKey()
    {
        $touchedBy = $this->touchedBy();

        if ($touchedBy instanceof Model) {
            /** @var int|string */
            return $touchedBy->getRouteKey();
        }

        return $touchedBy;
    }

    /**
     * Set the author of the model to be the initiating user.
     * 
     * @param int|string|null $id
     * @return void
     */
    public function setAuthor($id)
    {
        $this->{$this->getAuthorColumn()} = $id;
    }

    /**
     * Set the editor of the model to be the initiating user.
     * 
     * @param int|string|null $id
     * @return void
     */
    public function setEditor($id)
    {
        $this->{$this->getEditorColumn()} = $id;
    }

    /**
     * Get the name of the "created by" column.
     * 
     * @return string
     */
    public function getAuthorColumn()
    {
        if (defined('static::CREATED_BY')) {
            return static::CREATED_BY;
        }

        return 'created_by';
    }

    /**
     * Get the name of the "updated by" column.
     * 
     * @return string
     */
    public function getEditorColumn()
    {
        if (defined('static::UPDATED_BY')) {
            return static::UPDATED_BY;
        }
        
        return 'updated_by';
    }
}