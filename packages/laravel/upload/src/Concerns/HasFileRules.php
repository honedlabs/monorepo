<?php

declare(strict_types=1);

namespace Honed\Upload\Concerns;

use Honed\Upload\UploadData;
use Honed\Upload\UploadRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
     * Validate the incoming request.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \Honed\Upload\UploadRule|null $rule
     * @return \Honed\Upload\UploadData
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate($request, $rule = null)
    {
        $rules = $rule ? $rule->createRules() : $this->createRules();

        $validated = Validator::make(
            $request->all(),
            $rules,
        )->validate();

        return UploadData::from($validated);
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
}
