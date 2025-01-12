<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Concerns\IsDefault;
use Honed\Core\Contracts\HigherOrder;
use Illuminate\Http\RedirectResponse;
use Honed\Core\Concerns\HasDestination;
use Illuminate\Database\Eloquent\Model;
use Honed\Action\Contracts\HandlesAction;
use Honed\Core\Concerns\EvaluableDependency;
use Honed\Core\Contracts\ProxiesHigherOrder;
use Illuminate\Contracts\Support\Responsable;

class InlineAction extends Action
{
    use IsDefault;
    use HasDestination;
    use Concerns\HasAction;

    public function setUp(): void
    {
        $this->type(Creator::Inline);
    }

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
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\RedirectResponse|void
     */
    public function execute($record)
    {
        if (! $this->hasAction()) {
            return;
        }

        return $this instanceof HandlesAction
            ? $this->handle($record)
            : $this->evaluate($this->getAction(), [
                'model' => $record,
                'record' => $record,
                str($record->getTable())
                    ->singular()
                    ->camel()
                    ->toString() => $record,
            ], [
                Model::class => $record,
                $record::class => $record,
            ]);
    }
}