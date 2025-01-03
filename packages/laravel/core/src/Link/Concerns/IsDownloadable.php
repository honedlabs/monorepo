<?php

declare(strict_types=1);

namespace Honed\Core\Link\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait IsDownloadable
{
    /**
     * @var bool
     */
    protected $download = false;

    /**
     * Set the url to be downloaded, chainable.
     *
     * @return $this
     */
    public function download(bool $download = true): static
    {
        $this->setDownload($download);

        return $this;
    }

    /**
     * Set the url to be downloaded quietly.
     */
    public function setDownload(bool $download): void
    {
        $this->download = $download;
    }

    /**
     * Determine if the url should be downloaded.
     */
    public function isDownload(): bool
    {
        return $this->download;
    }
}
