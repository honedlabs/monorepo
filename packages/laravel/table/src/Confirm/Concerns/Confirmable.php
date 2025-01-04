<?php

declare(strict_types=1);

namespace Honed\Table\Confirm\Concerns;

use Honed\Table\Confirm\Confirm;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait Confirmable
{
    /**
     * @var \Honed\Table\Confirm\Confirm|null
     */
    protected $confirm = null;

    /**
     * Set the properties of the confirm
     *
     * @param  string|\Honed\Table\Confirm\Confirm|(\Closure(\Honed\Table\Confirm\Confirm):void)|array<string,mixed>  $confirm
     * @return $this
     */
    public function confirm(mixed $confirm): static
    {
        $confirmInstance = $this->makeConfirm();

        match (true) {
            $confirm instanceof Confirm => $this->setConfirm($confirm),
            \is_array($confirm) => $this->getConfirm()->assign($confirm),
            \is_callable($confirm) => $this->evaluate($confirm, [
                'confirm' => $confirmInstance,
            ], [
                Confirm::class => $confirmInstance,
            ]),
            default => $this->getConfirm()->setDescription($confirm),
        };

        return $this;
    }

    /**
     * Create a new confirm instance if one is not already set.
     */
    public function makeConfirm(): Confirm
    {
        return $this->confirm ??= Confirm::make();
    }

    /**
     * Set the confirm instance quietly.
     */
    public function setConfirm(Confirm|null $confirm)
    {
        if (\is_null($confirm)) {
            return;
        }

        $this->confirm = $confirm;
    }

    /**
     * Get the confirm instance.
     */
    public function getConfirm(): ?Confirm
    {
        return $this->confirm;
    }

    /**
     * Determine if the action is confirmable.
     */
    public function isConfirmable(): bool
    {
        return ! \is_null($this->confirm);
    }
}
