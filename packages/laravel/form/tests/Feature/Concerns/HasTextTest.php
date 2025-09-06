<?php

declare(strict_types=1);

namespace Tests\Feature\Concerns;

use Honed\Form\Components\Text;

beforeEach(function () {
    $this->text = 'Enter the details of the user.';

    $this->component = Text::make();
});

it('has text', function () {
    expect($this->component)
        ->getText()->toBeNull()
        ->text($this->text)->toBe($this->component)
        ->getText()->toBe($this->text);
});
