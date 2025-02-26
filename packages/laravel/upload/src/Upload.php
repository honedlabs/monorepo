<?php

declare(strict_types=1);

namespace Honed\Upload;

use Aws\S3\S3Client;
use Honed\Core\Primitive;


class Upload extends Primitive
{
    /**
     * The disk to retrieve the S3 credentials from.
     * 
     * @var string|null
     */
    protected $disk;

    /**
     * The maximum file size to upload.
     * 
     * @var int|null
     */
    protected $maxSize;

    /**
     * The minimum file size to upload.
     * 
     * @var int|null
     */
    protected $minSize;

    /**
     * The file size unit to use.
     * 
     * @var string
     */
    protected $unit;

    /**
     * The types of files to accept.
     * 
     * @var array<string>
     */
    protected $types = [];

    /**
     * Set the disk to retrieve the S3 credentials from.
     * 
     * @param string $disk
     * @return $this
     */
    public function disk($disk)
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * Get the disk to retrieve the S3 credentials from.
     * 
     * @return string
     */
    public function getDisk()
    {
        return $this->disk 
            ?? type(config('upload.disk', 's3'))->asString();
    }

    /**
     * Set the maximum file size to upload in bytes.
     * 
     * @param int $size
     * @return $this
     */
    public function max($size)
    {
        $this->maxSize = $size;

        return $this;
    }

    /**
     * Set the minimum file size to upload in bytes
     * 
     * @param int $size
     * @return $this
     */
    public function min($size)
    {
        $this->minSize = $size;

        return $this;
    }

    /**
     * Set the minimum and maximum file size to upload in bytes.
     * 
     * @param int $min
     * @param int|null $max
     * @return $this
     */
    public function size($size, $max = null)
    {
        return $this->when(\is_null($max), 
            fn () => $this->max($size),
            fn () => $this->min($size)->max($max),
        );
    }

    /**
     * Set the file size unit to use.
     * 
     * @param 'bytes'|'kilobytes'|'megabytes'|'gigabytes' $unit
     * @return $this
     */
    public function unit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Set the file size unit to bytes.
     * 
     * @return $this
     */
    public function bytes()
    {
        return $this->unit('bytes');
    }

    /**
     * Set the file size unit to kilobytes.
     * 
     * @return $this
     */
    public function kilobytes()
    {
        return $this->unit('kilobytes');
    }

    /**
     * Set the file size unit to megabytes.
     * 
     * @return $this
     */
    public function megabytes()
    {
        return $this->unit('megabytes');
    }

    /**
     * Set the file size unit to gigabytes.
     * 
     * @return $this
     */
    public function gigabytes()
    {
        return $this->unit('gigabytes');
    }

    /**
     * Get the minimum file size to upload in bytes.
     * 
     * @return int|null
     */
    public function getMinSize()
    {
        /** @var int|null */
        $minSize = $this->minSize
            ?? config('upload.size.min');

        if (\is_null($minSize)) {
            return null;
        }

        return $this->convertSize($minSize);
    }

    /**
     * Get the maximum file size to upload in bytes.
     * 
     * @return int|null
     */
    public function getMaxSize()
    {
        /** @var int|null */
        $maxSize = $this->maxSize
            ?? config('upload.size.max');

        if (\is_null($maxSize)) {
            return null;
        }

        return $this->convertSize($maxSize);
    }

    /**
     * Convert the provided size into the number of bytes using the unit.
     * 
     * @param int $size
     * @return int
     */
    protected function convertSize(int $size)
    {
        return match ($this->unit) {
            'bytes' => $size,
            'kilobytes' => $size * 1024,
            'megabytes' => $size * (1024 ** 2),
            'gigabytes' => $size * (1024 ** 3),
        };
    }

    /**
     * Create a new upload instance.
     * 
     * @param string|null $disk
     * @return \Honed\Upload\Upload
     */
    public static function into($disk = 's3')
    {
        return resolve(static::class)
            ->disk($disk);
    }

    public function createUploadUrl(int $bytes, string $contentType)
    {
        $client = $this->client();

        $command = $client->getCommand('putObject', array_filter([
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'Key' => $key = 'tmp/'.hash('sha256', (string) Str::uuid()),
            'ACL' => 'private',
            'ContentType' => $contentType,
            'ContentLength' => $bytes,
        ]));

        $request = $client->createPresignedRequest($command, '+5 minutes');

        $uri = $request->getUri();

        return new SignedUrl(
            key: $key,
            url: $uri->getScheme().'://'.$uri->getAuthority().$uri->getPath().'?'.$uri->getQuery(),
            headers: array_filter(array_merge($request->getHeaders(), [
                'Content-Type' => $contentType,
                'Cache-Control' => null,
                'Host' => null,
            ])),
        );
    }

    /**
     * Get the S3 client to use for uploading files.
     * 
     * @return \Aws\S3\S3Client
     */
    protected function client()
    {
        $key = \sprintf('filesystems.disks.%s', $this->name);

        return new S3Client([
            'region' => config($key.'.region'),
            'credentials' => [
                'key' => config($key.'.key'),
                'secret' => config($key.'.secret'),
            ],
        ]);
    }
}