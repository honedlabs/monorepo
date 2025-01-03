<?php

declare(strict_types=1);

use Honed\Core\Link\Concerns\IsDownloadable;

class IsDownloadableTest
{
    use IsDownloadable;
}

beforeEach(function () {
    $this->test = new IsDownloadableTest;
});

it('is not new tab by default', function () {
    expect($this->test->isDownload())->toBeFalse();
});

it('sets new tab', function () {
    $this->test->setDownload(true);
    expect($this->test->isDownload())->toBeTrue();
});

it('chains new tab', function () {
    expect($this->test->download())->toBeInstanceOf(IsDownloadableTest::class)
        ->isDownload()->toBeTrue();
});