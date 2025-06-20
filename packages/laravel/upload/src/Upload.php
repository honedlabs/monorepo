<?php

declare(strict_types=1);

namespace Honed\Upload;

use Honed\Core\Concerns\HasRequest;
use Honed\Core\Primitive;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class Upload extends Primitive implements Responsable
{
    use Concerns\BridgesSerialization;
    use Concerns\HasFile;
    use Concerns\HasRules;
    use Concerns\InteractsWithS3;
    use Concerns\ValidatesUpload;
    use HasRequest;

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
    public function create()
    {
        $this->build();

        return [
            'attributes' => $this->getPresign()->getFormAttributes(),
            'inputs' => $this->getPresign()->getFormInputs(),
            'data' => $this->getResponse(),
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
        $this->request($request);

        return response()->json($this->create());
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
