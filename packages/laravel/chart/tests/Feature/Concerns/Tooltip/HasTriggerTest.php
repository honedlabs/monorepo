<?php

declare(strict_types=1);

use Honed\Chart\Enums\Trigger;
use Honed\Chart\Tooltip;

beforeEach(function () {
    $this->tooltip = Tooltip::make();
});

it('has trigger', function () {
    expect($this->tooltip)
        ->getTrigger()->toBeNull()
        ->triggerByItem()->toBe($this->tooltip)
        ->getTrigger()->toBe(Trigger::Item)
        ->triggerByAxis()->toBe($this->tooltip)
        ->getTrigger()->toBe(Trigger::Axis)
        ->dontTrigger()->toBe($this->tooltip)
        ->getTrigger()->toBe(Trigger::None)
        ->trigger(Trigger::Item)->toBe($this->tooltip)
        ->getTrigger()->toBe(Trigger::Item);
});
