<?php

declare(strict_types=1);

namespace Honed\Upload;

use Carbon\Carbon;
use Aws\S3\S3Client;
use Aws\S3\PostObjectV4;
use Honed\Core\Concerns\HasRequest;
use Honed\Upload\Rules\OfType;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Tappable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Upload implements Responsable
{
    use Conditionable;
    use Macroable;
    use Tappable;
    use HasRequest;

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
     * @var 'bytes'|'kilobytes'|'megabytes'|'gigabytes'|string|null
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
     * 
     * @var string|null
     */
    protected $prefix;

    /**
     * The ACL to use for the file.
     * 
     * @var string|null
     */
    protected $acl;

    /**
     * The name of the file to be stored.
     * 
     * @var string|null
     */
    protected $name;

    /**
     * Create a new upload instance.
     */
    public function __construct(
        Request $request
    ) {
        $this->request($request);
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
     * @param 'bytes'|'kilobytes'|'megabytes'|'gigabytes'|string $unit
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
     * Get the file size unit to use.
     * 
     * @return 'bytes'|'kilobytes'|'megabytes'|'gigabytes'|string
     */
    public function getUnit()
    {
        return $this->unit
            ?? type(config('upload.unit', 'bytes'))->asString();
    }

    /**
     * Get the minimum file size to upload in bytes.
     * 
     * @return int
     */
    public function getMinSize()
    {
        /** @var int|null */
        $minSize = $this->minSize
            ?? config('upload.size.min');

        if (\is_null($minSize)) {
            return 0;
        }

        return $this->convertSize($minSize);
    }

    /**
     * Get the maximum file size to upload in bytes.
     * 
     * @return int
     */
    public function getMaxSize()
    {
        /** @var int|null */
        $maxSize = $this->maxSize
            ?? config('upload.size.max');

        if (\is_null($maxSize)) {
            return PHP_INT_MAX;
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
        return match ($this->getUnit()) {
            'kilobytes' => $size * 1024,
            'megabytes' => $size * (1024 ** 2),
            'gigabytes' => $size * (1024 ** 3),
            default => $size,
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

        $this->types = Arr::wrap($types);

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
        return $this->types($types);
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
        $duration = $this->duration;

        return match (true) {
            \is_string($duration) => $duration,
            \is_int($duration) => \sprintf('+%d seconds', $duration),
            $duration instanceof Carbon => \sprintf('+%d seconds', \round(\abs($duration->diffInSeconds()))),
            default => type(config('upload.expires', '+2 minutes'))->asString(),
        };
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

    /**
     * Set the name, or method, of generating the name of the file to be stored.
     * 
     * @param 'same'|'uuid'|'random'|string $name
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the name of the file to be stored.
     * 
     * @return string
     */
    public function getName()
    {
        return match ($this->name) {
            null, 'same' => '${fileName}',
            'uuid' => Str::uuid()->toString(),
            'random' => Str::random(),
            default => $this->name,
        };
    }

    /**
     * Get the defaults for form input fields.
     * 
     * @return array<string,mixed>
     */
    protected function getFormInputs()
    {
        return [
            'acl' => $this->getAcl(),
            'key' => '${filename}',
        ];
    }

    /**
     * Get the policy condition options for the request.
     * 
     * @return array<int,array<int,mixed>>
     */
    protected function getOptions()
    {
        $options = [
            ['acl' => $this->getAcl()],
            ['bucket' => $this->getBucket()],
            // ['key' => '${filename}'],
            // ['starts-with', '$Content-Type', 'image/'],
        ];

        if (filled($this->getTypes())) {
            $options[] = ['starts-with', '$Content-Type', ...$this->getTypes()];
        }

        if (filled($this->getMinSize())) {
            $options[] = ['content-length-range', $this->getMinSize(), $this->getMaxSize()];
        }

        return $options;
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
            'version' => 'latest',
            'region' => $this->getDiskConfig('region'),
            'credentials' => [
                'key' => $this->getDiskConfig('key'),
                'secret' => $this->getDiskConfig('secret'),
            ],
        ]);
    }

    /**
     * Create a new presigned post object.
     * 
     * @return \Aws\S3\PostObjectV4
     */
    public function create()
    {
        return new PostObjectV4(
            $this->getClient(), 
            $this->getBucket(), 
            $this->getFormInputs(), 
            $this->getOptions(), 
            $this->getDuration()
        );

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
     * Create a new response for the upload.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $validated = $this->validate($request);
        
        $object = $this->create();

        $formAttributes = $object->getFormAttributes();
        $formInputs = $object->getFormInputs();

        // event(new UploadCreated);
        
        return response()->json([
            'code' => 200, 
            'attributes' => $formAttributes, 
            'inputs' => $formInputs
        ]);
    }

    /**
     * Validate the incoming request.
     * 
     * @param \Illuminate\Http\Request $request
     * @return array<string,mixed>
     */
    protected function validate($request)
    {
        return Validator::make(
            $request->all(), 
            $this->getValidationRules(),
            [],
            $this->getValidationAttributes(),
        )->validate();
    }

    /**
     * Get the validation rules for file uploads.
     * 
     * @return array<string,array<int,mixed>>
     */
    protected function getValidationRules()
    {
        $min = $this->getMinSize();
        $max = $this->getMaxSize();

        return [
            'name' => ['required', 'string', 'max:1024'],
            'type' => ['required', new OfType($this->getTypes())],
            'size' => ['required', 'integer', 'min:'.$min, 'max:'.$max],
        ];
    }


    /**
     * Get the attributes for the request.
     * 
     * @return array<string,string>
     */
    protected function getValidationAttributes()
    {
        return [
            'name' => 'file name',
            'type' => 'file type',
            'size' => 'file size',
        ];
    }
}