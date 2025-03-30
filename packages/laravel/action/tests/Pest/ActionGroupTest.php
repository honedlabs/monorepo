<?php

declare(strict_types=1);

use Honed\Action\PageAction;
use Honed\Action\ActionGroup;
use Honed\Action\InlineAction;

beforeEach(function () {
    $this->group = ActionGroup::make(PageAction::make('create'));
});

it('has array representation', function () {
    expect($this->group->toArray())
        ->toBeArray()
        ->dd();
});
