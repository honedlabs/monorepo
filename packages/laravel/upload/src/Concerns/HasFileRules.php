<?php

declare(strict_types=1);

namespace Honed\Upload\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait HasFileRules
{
    /**
     * Get the configuration rules for validating file uploads.
     * 
     * @var array<string, mixed>
     */
    protected $rules = [];

    /**
     * List of the accepted file mime types and extensions.
     * 
     * @var array<int, string>
     */
    protected $accepting = [];

    /**
     * The maximum file size in bytes.
     * 
     * @var int|null
     */
    protected $maximum;

    /**
     * The minimum file size in bytes.
     * 
     * @var int|null
     */
    protected $minimum;

    /**
     * The expiry duration of the request in seconds.
     * 
     * @var int|null
     */
    protected $expires;

    /**
     * Set the rules for validating file uploads.
     * 
     * @param array<string, mixed> $rules
     * @return $this
     */
    public function rules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get the rules for validating file uploads.
     * 
     * @return array<string, mixed>
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Set the accepted file mime types and extensions.
     * 
     * @param string $accepting
     * @return $this
     */
    public function accepting(...$accepting)
    {
        $this->accepting = Arr::flatten($accepting);

        return $this;
    }

    /**
     * Get the accepted file mime types and extensions.
     * 
     * @return array<int, string>
     */
    public function getAcceptedTypes()
    {
        return $this->accepting;
    }

    /**
     * Set the upload to accept images.
     * 
     * @return $this
     */
    public function acceptingImages()
    {
        return $this->accepting('image/');
    }

    /**
     * Set the upload to accept videos.
     * 
     * @return $this
     */
    public function acceptingVideos()
    {
        return $this->accepting('video/');
    }

    /**
     * Set the upload to accept audio.
     * 
     * @return $this
     */
    public function acceptingAudio()
    {
        return $this->accepting('audio/');
    }

    /**
     * Set the upload to accept PDFs.
     * 
     * @return $this
     */
    public function acceptingPDFs()
    {
        return $this->accepting('application/pdf');
    }

    /**
     * Get the accepted file mime types.
     * 
     * @return array<int, string>
     */
    public function getAcceptedMimeTypes()
    {
        return \array_values(
            \array_filter(
                $this->getAccepted(),
                static fn (string $type) => ! \str_starts_with($type, '.')
            )
        );
    }

    /**
     * Get the accepted file extensions.
     * 
     * @return array<int, string>
     */
    public function getAcceptedExtensions()
    {
        return \array_values(
            \array_filter(
                $this->getAccepted(),
                static fn (string $type) => \str_starts_with($type, '.')
            )
        );
    }

    /**
     * Set the maximum file size in bytes.
     * 
     * @param int $size
     * @return $this
     */
    public function max($size)
    {
        $this->maximum = $size;

        return $this;
    }

    /**
     * Get the maximum file size in bytes.
     * 
     * @return int
     */
    public function getMax()
    {
        return $this->maximum ?? static::fallbackMax();
    }

    /**
     * Get the maximum file size in bytes from the config.
     * 
     * @return int
     */
    public static function fallbackMax()
    {
        return type(config('upload.max_size', 10 * (1024 ** 3)))->asInt();
    }

    /**
     * Set the minimum file size in bytes.
     * 
     * @param int $size
     * @return $this
     */
    public function min($size)
    {
        $this->minimum = $size;

        return $this;
    }
    
    /**
     * Get the minimum file size in bytes.
     * 
     * @return int
     */
    public function getMin()
    {
        return $this->minimum ?? static::fallbackMin();
    }

    /**
     * Get the minimum file size in bytes from the config.
     * 
     * @return int
     */
    public static function fallbackMin()
    {
        return type(config('upload.min_size', 1))->asInt();
    }

    /**
     * Set the expiry duration of the request in seconds.
     * 
     * @param int $seconds
     * @return $this
     */
    public function expires($seconds)
    {
        $this->expires = $seconds;

        return $this;
    }

    /**
     * Get the expiry duration of the request in seconds.
     * 
     * @return int
     */
    public function getExpires()
    {
        return $this->expires ?? static::fallbackExpires();
    }

    /**
     * Get the expiry duration of the request in seconds from the config.
     * 
     * @return int
     */
    public static function fallbackExpires()
    {
        return type(config('upload.expires', 5 * 60))->asInt();
    }

    /**
     * Validate the incoming request.
     * 
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function validate($request)
    {
        [$name, $extension] = static::destructureFilename($request->input('name'));

        /** @var array<string, mixed> */
        $data = $request->merge([
            'name' => $name,
            'extension' => $extension,
        ])->all();

        return Validator::make(
            $data,
            $this->createRules($data),
        )->validate();
    }

    public function createRules($data)
    {
        return [
            'name' => ['required', 'string', 'max:1024'],
            'extension' => ['required', 'string'],
            'type' => ['required'],
            'size' => ['required', 'integer', 'min:'.$min, 'max:'.$max],
            'meta' => ['nullable'],
        ];
    }

    /**
     * Destructure the filename into its components.
     * 
     * @param string|null $filename
     * @return array{string|null, string|null}
     */
    public static function destructureFilename($filename)
    {
        if (\is_null($filename)) {
            return [null, null];
        }

        return [
            \pathinfo($filename, PATHINFO_FILENAME),
            \pathinfo($filename, PATHINFO_EXTENSION),
        ];
    }
}
