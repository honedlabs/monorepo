<?php

declare(strict_types=1);

use Honed\Core\Link\Concerns\IsNewTab;

class IsNewTabTest
{
    use IsNewTab;
}

beforeEach(function () {
    $this->test = new IsNewTabTest;
});

it('is not new tab by default', function () {
    expect($this->test->isNewTab())->toBeFalse();
});

it('sets new tab', function () {
    $this->test->setNewTab(true);
    expect($this->test->isNewTab())->toBeTrue();
});

it('chains new tab', function () {
    expect($this->test->newTab())->toBeInstanceOf(IsNewTabTest::class)
        ->isNewTab()->toBeTrue();
});