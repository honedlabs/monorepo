<?php

declare(strict_types=1);

namespace Honed\Upload;

use Carbon\Carbon;
use Aws\S3\S3Client;
use Aws\S3\PostObjectV4;
use Honed\Core\Primitive;
use Honed\Upload\UploadRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Honed\Upload\Rules\OfType;
use Honed\Upload\Concerns\HasMax;
use Honed\Upload\Concerns\HasMin;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use Honed\Core\Concerns\HasRequest;
use Honed\Upload\Concerns\HasExpiry;
use Honed\Upload\Concerns\HasExpires;
use Honed\Upload\Concerns\HasFileRules;
use Honed\Upload\Concerns\HasFileTypes;
use Honed\Upload\Contracts\AnonymizesName;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;

/**
 * @extends \Honed\Core\Primitive<string,mixed>
 */
class Upload extends UploadValidator //implements Responsable
{
    use HasFileRules;
    use HasRequest;

    /**
     * The disk to retrieve the S3 credentials from.
     *
     * @var string|null
     */
    protected $disk;

    /**
     * Get the configuration rules for validating file uploads.
     * 
     * @var array<int, \Honed\Upload\UploadRule>
     */
    protected $rules = [];

    /**
     * The path prefix to store the file in
     *
     * @var string|\Closure(mixed...):string|null
     */
    protected $path;

    /**
     * The name of the file to be stored.
     *
     * @var string|\Closure(mixed...):string|null
     */
    protected $name;

    /**
     * Whether the file name should be anonymized using a UUID.
     *
     * @var bool|null
     */
    protected $anonymize;

    /**
     * The access control list to use for the file.
     *
     * @var string|null
     */
    protected $acl;

    /**
     * Create a new upload instance.
     */
    public function __construct(Request $request)
    {
        parent::__construct();

        $this->request($request);
    }

    /**
     * Create a new upload instance.
     *
     * @param string $disk
     * @return static
     */
    public static function make($disk = null)
    {
        return resolve(static::class)
            ->disk($disk);
    }

    /**
     * Create a new upload instance for the given disk.
     *
     * @param  string  $disk
     * @return static
     */
    public static function into($disk)
    {
        return static::make($disk);
    }

    /**
     * Set the disk to retrieve the S3 credentials from.
     *
     * @param  string  $disk
     * @return $this
     */
    public function disk($disk)
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * Get the S3 disk to use for uploading files.
     *
     * @return string
     */
    public function getDisk()
    {
        return $this->disk ?? static::getDefaultDisk();
    }

    /**
     * Get the disk to use for uploading files from the config.
     *
     * @return string
     */
    public static function getDefaultDisk()
    {
        return type(config('upload.disk', 's3'))->asString();
    }

    /**
     * Set the rules for validating file uploads.
     * 
     * @param iterable<\Honed\Upload\UploadRule> ...$rules
     * @return $this
     */
    public function rules(...$rules)
    {
        $rules = Arr::flatten($rules);

        $this->rules = \array_merge($this->rules, $rules);

        return $this;
    }

    /**
     * Get the rules for validating file uploads.
     * 
     * @return array<int, \Honed\Upload\UploadRule>
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Set the path to store the file at.
     *
     * @param  string  $path
     * @return $this
     */
    public function path($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the path to store the file at.
     *
     * @return string|\Closure(mixed...):string|null
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the name, or method, of generating the name of the file to be stored.
     *
     * @param  \Closure(mixed...):string|string  $name
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the name, or method, of generating the name of the file to be stored.
     *
     * @return \Closure(mixed...):string|string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set whether to anonymize the file name using a UUID.
     *
     * @param  bool  $anonymize
     * @return $this
     */
    public function anonymize($anonymize = true)
    {
        $this->anonymize = $anonymize;

        return $this;
    }

    /**
     * Determine whether the file name should be anonymized using a UUID.
     *
     * @return bool
     */
    public function isAnonymized()
    {
        if (isset($this->anonymize)) {
            return $this->anonymize;
        }

        if ($this instanceof AnonymizesName) {
            return true;
        }

        return static::isAnonymizedByDefault();
    }

    /**
     * Determine if the file name should be anonymized using a UUID by default.
     *
     * @return bool
     */
    public static function isAnonymizedByDefault()
    {
        return (bool) config('upload.anonymize_name', false);
    }

    /**
     * Set the access control list to use for the file.
     *
     * @param  string  $acl
     * @return $this
     */
    public function acl($acl)
    {
        $this->acl = $acl;

        return $this;
    }

    /**
     * Get the access control list to use for the file.
     *
     * @return string
     */
    public function getACL()
    {
        return $this->acl ?? static::getDefaultACL();
    }

    /**
     * Get the access control list to use for the file from the config.
     *
     * @return string
     */
    public static function getDefaultACL()
    {
        return type(config('upload.acl', 'public-read'))->asString();
    }

    /**
     * Get the defaults for form input fields.
     *
     * @param  string  $key
     * @return array<string,mixed>
     */
    public function getFormInputs($key)
    {
        return [
            'acl' => $this->getACL(),
            'key' => $key,
        ];
    }

    /**
     * Get the policy condition options for the request.
     *
     * @param  string  $key
     * @return array<int,array<int|string,mixed>>
     */
    public function getOptions($key)
    {
        $options = [
            ['eq', '$acl', $this->getACL()],
            ['eq', '$key', $key],
            ['content-length-range', $this->getMin(), $this->getMax()],
        ];

        $mimes = $this->getMimes();

        if (filled($mimes)) {
            $options[] = ['starts-with', '$Content-Type', \implode(',', $mimes)];
        }

        return $options;
    }

    /**
     * Get the S3 client to use for uploading files.
     *
     * @param string $disk
     * @return \Aws\S3\S3Client
     */
    public function getClient($disk)
    {
        $disk = $this->getDisk();

        return new S3Client([
            'version' => 'latest',
            'region' => config("filesystems.disks.{$disk}.region"),
            'credentials' => [
                'key' => config("filesystems.disks.{$disk}.key"),
                'secret' => config("filesystems.disks.{$disk}.secret"),
            ],
        ]);
    }

    /**
     * Get the attributes for the request.
     *
     * @return array<string,string>
     */
    public function getValidationAttributes()
    {
        return [
            'name' => 'file name',
            'type' => 'file type',
            'size' => 'file size',
        ];
    }

    /**
     * Build the storage key path for the uploaded file.
     *
     * @param  \Honed\Upload\UploadData $validated
     * @return string
     */
    public function createKey($data)
    {
        /** @var string */
        $filename = Arr::get($validated, 'name');

        $name = $this->getName();

        /** @var string */
        $validatedName = match (true) {
            $name === 'uuid' => Str::uuid()->toString(),
            $name instanceof \Closure => type($this->evaluateValidated($name, $validated))->asString(),
            default => \pathinfo($filename, \PATHINFO_FILENAME),
        };

        $path = $this->evaluateValidated($this->getPath(), $validated);

        return Str::of($validatedName)
            ->append('.', \pathinfo($filename, \PATHINFO_EXTENSION))
            ->when($path, fn (Stringable $name) => $name
                    ->prepend($path, '/') // @phpstan-ignore-line
                    ->replace('//', '/'),
            )->toString();
    }

    /**
     * Evaluate the closure using the validated data
     *
     * @param  \Closure|string|null  $closure
     * @param  \Honed\Upload\UploadData $data
     * @return string|null
     */
    protected function evaluateValidated($closure, $data)
    {
        return $this->evaluate($closure, [
            'data' => $data,
            'name' => $data->name,
            'extension' => $data->extension,
            'type' => $data->type,
            'size' => $data->size,
            'meta' => $data->meta,
        ], [
            UploadData::class => $data
        ]);
    }

    /**
     * Create a presigned POST URL using.
     *
     * @return array{attributes:array<string,mixed>,inputs:array<string,mixed>}
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create()
    {
        $request = $this->getRequest();

        [$name, $extension] = $this->destructureFilename($request->name);

        /** @var array<string, mixed> */
        $data = $request->merge([
            'name' => $name,
            'extension' => $extension,
        ])->all();

        $rule = Arr::first(
            $this->getRules(),
            static fn (UploadRule $rule) => 
                $rule->isMatching($request->input('type'), $extension),
        );

        $validated = $this->validate($request, $rule);

        $key = $this->createKey($validated);

        $disk = $this->getDisk();

        $client = $this->getClient($disk);

        $bucket = $this->getBucket($disk);

        $postObject = new PostObjectV4(
            $client,
            $bucket,
            $this->getFormInputs($key),
            $this->getOptions($key),
            $this->getExpiry()
        );

        return [
            'attributes' => $postObject->getFormAttributes(),
            'inputs' => $postObject->getFormInputs(),
        ];
    }
}
