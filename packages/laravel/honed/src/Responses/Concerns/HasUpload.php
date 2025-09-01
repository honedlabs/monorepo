<?php

declare(strict_types=1);

namespace Honed\Honed\Responses\Concerns;

use Honed\Upload\Upload;

/**
 * @phpstan-require-extends \Honed\Honed\Responses\InertiaResponse
 */
trait HasUpload
{
    public const UPLOAD_PROP = 'upload';

    /**
     * The route to update the model.
     *
     * @var class-string<Upload>|Upload
     */
    protected $upload;

    /**
     * Set the route to update the model.
     *
     * @param  class-string<Upload>|Upload  $value
     * @return $this
     */
    public function upload(string|Upload $value): static
    {
        $this->update = $value;

        return $this;
    }

    /**
     * Get the route to update the model.
     */
    public function getUpload(): Upload
    {
        return is_string($this->upload) ? $this->upload::make() : $this->upload;
    }

    /**
     * Convert the upload to an array of props.
     *
     * @return array<string, mixed>
     */
    public function hasUploadToProps(): array
    {
        return [
            self::UPLOAD_PROP => $this->getUpload()->toArray(),
        ];
    }
}
