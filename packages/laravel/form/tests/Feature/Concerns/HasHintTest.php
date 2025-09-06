<?php

declare(strict_types=1);

namespace Tests\Feature\Concerns;

use Honed\Form\Components\Input;

beforeEach(function () {
    $this->hint = 'hint';

    $this->component = Input::make($this->hint);
});

it('has hint', function () {
    expect($this->component)
        ->getHint()->toBeNull()
        ->hint($this->hint)->toBe($this->component)
        ->getHint()->toBe($this->hint);
});
