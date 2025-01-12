<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Concerns\IsDefault;
use Honed\Core\Concerns\HasDestination;
use Illuminate\Database\Eloquent\Model;
use Honed\Action\Contracts\HandlesAction;
use Illuminate\Support\Traits\ForwardsCalls;

class InlineAction extends Action
{
    use IsDefault;
    use HasDestination;
    use Concerns\HasAction;
    use ForwardsCalls;

    protected $type = Creator::Inline;

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'action' => $this->hasAction(),
            'default' => $this->isDefault(),
        ]);
    }
    
    /**
     * Execute the action handler using the provided data.
     * 
     * @param \Illuminate\Database\Eloquent\Model $record
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\RedirectResponse|null
     */
    public function execute($record)
    {
        if (! $this->hasAction()) {
            return;
        }

        [$model, $singular] = $this->getActionParameterNames($record);

        return $this instanceof HandlesAction
            ? \call_user_func([$this, 'handle'], $record)
            : $this->evaluate($this->getAction(), [
                'model' => $model,
                'record' => $record,
                $singular => $record,
            ], [
                Model::class => $record,
                $model::class => $record,
            ]);
    }
}