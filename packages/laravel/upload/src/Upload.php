<?php

declare(strict_types=1);

namespace Honed\Upload;

use Aws\S3\PostObjectV4;
use Aws\S3\S3Client;
use Honed\Core\Primitive;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use Carbon\Carbon;

class Upload implements Responsable
{
    use Conditionable;
    use Macroable;
    use Tappable;

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
     * @var 'bytes'|'kilobytes'|'megabytes'|'gigabytes'
     */
    protected $unit;

    /**
     * The types of files to accept.
     * 
     * @var array<string>
     */
    protected $types = [];

    /**
     * The duration of the presigned URL.
     * 
     * @var \Carbon\Carbon|int|string|null
     */
    protected $duration;

    /**
     * The bucket to upload the file to.
     * 
     * @var string|null
     */
    protected $bucket;

    /**
     * The path prefix to store the file in
     */
    protected $prefix;

    /**
     * The ACL to use for the file.
     * 
     * @var string|null
     */
    protected $acl;

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
     * Set the maximum file size to upload.
     * 
     * @param int $max
     * @return $this
     */
    public function max($max)
    {
        $this->maxSize = $max;

        return $this;
    }

    /**
     * Set the minimum file size to upload.
     * 
     * @param int $min
     * @return $this
     */
    public function min($min)
    {
        $this->minSize = $min;

        return $this;
    }

    /**
     * Set the minimum and maximum file size to upload.
     * 
     * @param int $size
     * @param int|null $max
     * @return $this
     */
    public function size($size, $max = null)
    {
        return $this->when(\is_null($max), 
            fn () => $this->max($size),
            fn () => $this->min($size)->max(type($max)->asInt()),
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
     * Set the types of files to accept.
     * 
     * @param string|array<int,string>|\Illuminate\Support\Collection<int,string> $types
     * @return $this
     */
    public function types($types)
    {
        if ($types instanceof Collection) {
            $types = $types->all();
        }

        $this->types = \array_merge($this->types, Arr::wrap($types));

        return $this;
    }

    /**
     * Set the types of files to accept.
     * 
     * @param string|array<int,string>|\Illuminate\Support\Collection<int,string> $types
     * @return $this
     */
    public function accepts($types)
    {
        return $this->accepts($types);
    }

    /**
     * Set the types of files to accept to all image MIME types.
     * 
     * @return $this
     */
    public function image()
    {
        return $this->types('image/');
    }

    /**
     * Set the types of files to accept to all video MIME types.
     * 
     * @return $this
     */
    public function video()
    {
        return $this->types('video/');
    }

    /**
     * Set the types of files to accept to all audio MIME types.
     * 
     * @return $this
     */
    public function audio()
    {
        return $this->types('audio/');
    }

    /**
     * Get the types of files to accept.
     * 
     * @return array<int,string>
     */
    public function getTypes()
    {
        return empty($this->types)
            ? type(config('upload.types'))->asArray()
            : $this->types;
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

    /**
     * Set the duration of the presigned URL.
     * If an integer is provided, it will be interpreted as the number of seconds.
     * 
     * @param \Carbon\Carbon|int|string|null $duration
     * @return $this
     */
    public function duration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Set the duration of the presigned URL.
     * If an integer is provided, it will be interpreted as the number of seconds.
     * 
     * @param \Carbon\Carbon|int|string|null $expires
     * @return $this
     */
    public function expires($expires)
    {
        $this->duration = $expires;

        return $this;
    }

    /**
     * Set the duration of the presigned URL to a number of seconds.
     * 
     * @param int $seconds
     * @return $this
     */
    public function seconds($seconds)
    {
        $this->duration = \sprintf('+%d seconds', $seconds);

        return $this;
    }

    /**
     * Set the duration of the presigned URL to a number of minutes.
     * 
     * @param int $minutes
     * @return $this
     */
    public function minutes($minutes)
    {
        $this->duration = \sprintf('+%d minutes', $minutes);

        return $this;
    }

    /**
     * Get the duration of the presigned URL.
     * 
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set the bucket to upload the file to.
     * 
     * @param string $bucket
     * @return $this
     */
    public function bucket($bucket)
    {
        $this->bucket = $bucket;

        return $this;
    }

    /**
     * Get the bucket to upload the file to.
     * 
     * @return string
     */
    public function getBucket()
    {
        return type($this->bucket
            ?? config('upload.bucket')
            ?? $this->getDiskConfig('bucket')
        )->asString();
    }

    /**
     * Set the ACL to use for the file.
     * 
     * @param string $acl
     * @return $this
     */
    public function acl($acl)
    {
        $this->acl = $acl;

        return $this;
    }

    /**
     * Get the ACL to use for the file.
     * 
     * @return string
     */
    public function getAcl()
    {
        return $this->acl
            ?? type(config('upload.acl'))->asString();
    }

    protected function getFormInputs()
    {
        return [
            'acl' => $this->getAcl(),
            'key' => '${filename}',
        ];
    }

    protected function getOptions()
    {
        return [
            ['acl' => $this->getAcl()],
            ['bucket' => $this->getBucket()],
            ['key' => '${filename}'],
            ['starts-with', '$Content-Type', 'image/'],
            ['content-length-range', 0, (2 * 1024 * 1024)],
        ];
    }

    public function toResponse($request)
    {
        $client = $this->getClient();

        $postObject = new PostObjectV4(
            $client, 
            $this->getBucket(), 
            $this->getFormInputs(), 
            $this->getOptions(), 
            $this->getDuration()
        );


        $formAttributes = $postObject->getFormAttributes();
        
        $formInputs = $postObject->getFormInputs();
        
        return response()->json([
            'code' => 200, 
            'attributes' => $formAttributes, 
            'inputs' => $formInputs
        ]);
        // $command = $client->getCommand('putObject', array_filter([
        //     'Bucket' => config('filesystems.disks.s3.bucket'),
        //     'Key' => $key = 'tmp/'.hash('sha256', (string) Str::uuid()),
        //     'ACL' => 'private',
        //     'ContentType' => $contentType,
        //     'ContentLength' => $bytes,
        // ]));

        // $request = $client->createPresignedRequest($command, '+5 minutes');

        // $uri = $request->getUri();

        // return new SignedUrl(
        //     key: $key,
        //     url: $uri->getScheme().'://'.$uri->getAuthority().$uri->getPath().'?'.$uri->getQuery(),
        //     headers: array_filter(array_merge($request->getHeaders(), [
        //         'Content-Type' => $contentType,
        //         'Cache-Control' => null,
        //         'Host' => null,
        //     ])),
        // );
    }

    /**
     * Get a configuration value from the disk.
     * 
     * @param string $key
     * @return mixed
     */
    protected function getDiskConfig(string $key)
    {
        return config(
            \sprintf('filesystems.disks.%s.%s', $this->getDisk(), $key)
        );
    }

    /**
     * Get the S3 client to use for uploading files.
     * 
     * @return \Aws\S3\S3Client
     */
    protected function getClient()
    {
        return new S3Client([
            'region' => $this->getDiskConfig('region'),
            'credentials' => [
                'key' => $this->getDiskConfig('key'),
                'secret' => $this->getDiskConfig('secret'),
            ],
        ]);
    }
}