<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Concerns\IsDefault;
use Honed\Core\Contracts\HigherOrder;
use Honed\Core\Concerns\HasDestination;
use Honed\Core\Contracts\ProxiesHigherOrder;

class InlineAction extends Action
{
    use IsDefault;
    use Concerns\MorphsAction;
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
            // 'confirm' => $this->confirm(),
            // 'link' => $this->link(),
        ]);
    }

    /**
     * Morph this action to accomodate for bulk requests.
     * 
     * @return $this
     */
    public function acceptsBulk()
    {
        return $this->morph();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $record
     */
    public function execute($record): void
    {
        if (! $this->hasAction()) {
            return;
        }


    }
}