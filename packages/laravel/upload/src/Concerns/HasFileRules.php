<?php

declare(strict_types=1);

namespace Honed\Upload\Concerns;

use App\Upload\UploadRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

trait HasFileRules
{
    /**
     * Get the configuration rules for validating file uploads.
     * 
     * @var array<int, \Honed\Upload\UploadRule>
     */
    protected $rules = [];

    /**
     * Set the rules for validating file uploads.
     * 
     * @param iterable<\Honed\Upload\UploadRule> ...$rules
     * @return $this
     */
    public function rules(...$rules)
    {
        $this->rules = Arr::flatten($rules);

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

    /**
     * Destructure the filename into its components.
     * 
     * @param mixed $filename
     * @return ($filename is string ? array{string, string} : array{null, null})
     */
    public static function destructureFilename($filename)
    {
        if (! \is_string($filename)) {
            return [null, null];
        }

        return [
            \pathinfo($filename, PATHINFO_FILENAME),
            \mb_strtolower(\pathinfo($filename, PATHINFO_EXTENSION)),
        ];
    }

    public function createRules($data)
    {
        $type = Arr::get($data, 'type');
        $extension = Arr::get($data, 'extension');

        $rule = Arr::first(
            $this->getRules(),
            static fn (UploadRule $rule) => $rule->isMatching($type, $extension),
        );

        $min = $rule->getMin();
        $max = $rule->getMax();
        return [
            'name' => ['required', 'string', 'max:1024'],
            'extension' => ['required', 'string'],
            'type' => ['required'],
            'size' => ['required', 'integer', 'min:'.$min, 'max:'.$max],
            'meta' => ['nullable'],
        ];
    }
}
