<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Action\Contracts\Handles;
use Honed\Core\Concerns\IsDefault;
use Illuminate\Database\Eloquent\Model;

class InlineAction extends Action
{
    use IsDefault;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->type(Creator::Inline);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'default' => $this->isDefault(),
        ]);
    }

    /**
     * Execute the inline action on the given record.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $record
     */
    public function execute($record): mixed
    {
        if (! $this->hasAction()) {
            return;
        }

        $handler = $this->getHandler();

        [$named, $typed] = $this->getEvaluationParameters($record);

        return $this->evaluate($handler, $named, $typed);
    }

    /**
     * Get the named and typed parameters to use for callable evaluation.
     * 
     * @param  \Illuminate\Database\Eloquent\Model  $record
     * @return array{array<string, mixed>,  array<class-string, mixed>}
     */
    protected function getEvaluationParameters($record): array
    {
        [$model, $singular] = $this->getParameterNames($record);

        $named = [
            'model' => $model,
            'record' => $record,
            $singular => $record,
        ];

        $typed = [
            Model::class => $record,
            $model::class => $record,
        ];

        return [$named, $typed];
    }
}
