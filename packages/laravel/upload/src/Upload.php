<?php

declare(strict_types=1);

namespace Honed\Upload;

use Aws\S3\PostObjectV4;
use Honed\Core\Concerns\HasRequest;
use Honed\Core\Primitive;
use Honed\Upload\Concerns\DispatchesPresignEvents;
use Honed\Upload\Concerns\HasFile;
use Honed\Upload\Concerns\ValidatesUpload;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Number;
use Illuminate\Validation\ValidationException;

use function array_map;
use function array_merge;
use function count;
use function implode;
use function mb_strtoupper;
use function trim;
use function ucfirst;

class Upload extends Primitive implements Responsable
{
    use DispatchesPresignEvents;
    use HasFile;
    use Concerns\HasRules;
    use Concerns\InteractsWithS3;
    use HasRequest;

    /**
     * The upload data to use from the request.
     *
     * @var UploadData|null
     */
    protected $data;

    /**
     * Get the configuration rules for validating file uploads.
     *
     * @var array<int, UploadRule>
     */
    protected $rules = [];

    /**
     * The additional data to return with the presign response.
     *
     * @var mixed
     */
    protected $returns = null;

    /**
     * Whether the upload accepts multiple files.
     *
     * @var bool
     */
    protected $multiple = false;

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
     * @return static
     */
    public static function make()
    {
        return resolve(static::class);
    }

    /**
     * Create a new upload instance for the given disk.
     *
     * @param  string  $disk
     * @return static
     */
    public static function into($disk)
    {
        return static::make()->disk($disk);
    }

    /**
     * Merge a set of rules with the existing.
     *
     * @param  UploadRule|array<int,UploadRule>  $rules
     * @return $this
     */
    public function rules($rules)
    {
        /** @var array<int,UploadRule> */
        $rules = is_array($rules) ? $rules : func_get_args();
        
        $this->rules = [...$this->rules, ...$rules];

        return $this;
    }

    /**
     * Add a rule to the upload.
     *
     * @param  UploadRule  $rule
     * @return $this
     */
    public function rule($rule)
    {
        return $this->rules($rule);
    }

    /**
     * Get the rules for validating file uploads.
     *
     * @return array<int, UploadRule>
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Set additiional data to return with the presign response.
     *
     * @param  mixed  $return
     * @return $this
     */
    public function provide($return)
    {
        $this->returns = $return;

        return $this;
    }

    /**
     * Define the data that should be provided as part of the presign response.
     *
     * @return mixed
     */
    public function provides()
    {
        return [];
    }

    /**
     * Get the additional data to return with the presign response.
     *
     * @return mixed
     */
    public function getProvided()
    {
        if (isset($this->returns)) {
            return $this->evaluate($this->returns);
        }

        return $this->provides();
    }

    /**
     * Set whether the upload accepts multiple files.
     *
     * @param  bool  $multiple
     * @return $this
     */
    public function multiple($multiple = true)
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * Determine whether the upload accepts multiple files.
     *
     * @return bool
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * Get the upload data.
     *
     * @return UploadData|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Create the upload message.
     *
     * @return string
     */
    public function getMessage()
    {
        $extensions = $this->getExtensions();
        $mimes = $this->getMimeTypes();

        $numMimes = count($mimes);
        $numExts = count($extensions);

        $typed = match (true) {
            $numExts > 0 && $numExts < 4 => implode(', ', array_map(
                static fn ($ext) => mb_strtoupper(trim($ext)),
                $extensions
            )),

            $numMimes > 0 && $numMimes < 4 => ucfirst(implode(', ', array_map(
                static fn ($mime) => trim($mime, ' /'),
                $mimes
            ))),

            $this->isMultiple() => 'Files',

            default => 'A single file',
        };

        return $typed.' up to '.Number::fileSize($this->getMax());
    }

    /**
     * Validate the incoming request.
     *
     * @param  Request|null  $request
     * @return array{UploadData, UploadRule|null}
     *
     * @throws ValidationException
     */
    public function validate($request)
    {
        $request ??= $this->request;

        [$name, $extension] =
            static::destructureFilename($request->input('name'));

        $request->merge([
            'name' => $name,
            'extension' => $extension,
        ])->all();

        $rule = Arr::first(
            $this->getRules(),
            static fn (UploadRule $rule) => $rule->isMatching(
                $request->input('type'),
                $extension,
            ),
        );

        try {
            $validated = Validator::make(
                $request->all(),
                $rule?->createRules() ?? $this->createRules(),
                [],
                $this->getAttributes(),
            )->validate();

            return [UploadData::from($validated), $rule];
        } catch (ValidationException $e) {
            $this->failedPresign($request);

            throw $e;
        }
    }

    /**
     * Get the attributes for the validator.
     *
     * @return array<string,string>
     */
    public function getAttributes()
    {
        return [
            'name' => 'file name',
            'extension' => 'file extension',
            'type' => 'file type',
            'size' => 'file size',
        ];
    }

    /**
     * Create a presigned POST URL using.
     *
     * @param  Request|null  $request
     * @return array{attributes:array<string,mixed>,inputs:array<string,mixed>}
     *
     * @throws ValidationException
     */
    public function create($request = null)
    {
        // Validate
        // Create Presigned DTO?
        // Create PostObject
        // Dispatch Event
        // Respond
        [$data, $rule] = $this->validate($request);

        $this->data = $data;

        $key = $this->createKey($data);

        $postObject = new PostObjectV4(
            $this->getClient(),
            $this->getBucket(),
            $this->getFormInputs($key),
            $this->getOptions($key),
            $this->formatExpiry($rule ? $rule->getLifetime() : $this->getLifetime())
        );

        static::createdPresign($data, $this->getDisk());

        return [
            'attributes' => $postObject->getFormAttributes(),
            'inputs' => $postObject->getFormInputs(),
            'data' => $this->getProvided(),
        ];
    }

    /**
     * Get the instance as an array.
     * 
     * @return array<string,mixed>
     */
    public function toArray()
    {
        return [
            'multiple' => $this->isMultiple(),
            'message' => $this->getMessage(),
            'extensions' => $this->getExtensions(),
            'mimes' => $this->getMimeTypes(),
            'size' => $this->getMax(),
        ];
    }

    /**
     * Create a response for the upload.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        $presign = $this->create($request);

        return response()->json($presign);
    }

    /**
     * Define the upload instance.
     *
     * @param  $this  $upload
     * @return $this
     */
    protected function definition(self $upload): self
    {
        return $upload;
    }

    /**
     * {@inheritdoc}
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
    {
        if ($parameterName === 'bucket') {
            return [$this->getBucket()];
        }
        
        $data = $this->getData();

        if (! $data) {
            return parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName);
        }

        return match ($parameterName) {
            'data' => [$data],
            'key' => [$this->createKey($data)],
            'file' => [$this->createFilename($data).'.'.$data->extension],
            'filename' => [$this->createFilename($data)],
            'folder' => [$this->getFolder($this->createKey($data))],
            'name' => [$data->name],
            'extension' => [$data->extension],
            'type' => [$data->type],
            'size' => [$data->size],
            'meta' => [$data->meta],
            'disk' => [$this->getDisk()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * {@inheritdoc}
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
    {
        if ($parameterType === UploadData::class && isset($this->data)) {
            return [$this->data];
        }

        return parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType);
    }
}
