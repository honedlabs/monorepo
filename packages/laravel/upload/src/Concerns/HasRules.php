<?php

declare(strict_types=1);

namespace Honed\Upload\Concerns;

trait HasRules
{
    /**
     * The list of upload rules for validating files.
     *
     * @var array<int, UploadRule>
     */
    protected $rules = [];

    /**
     * The selected set of validation rules based on the request.
     *
     * @var array<int, mixed>|null
     */
    protected $rule;

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
     * Set the active rule for the upload.
     *
     * @param  array<int, mixed>  $rule
     * @return void
     */
    public function setRule($rule)
    {
        $this->rule = $rule;
    }

    /**
     * Get the active rule for the upload.
     *
     * @return array<int, mixed>|null
     */
    public function getRule()
    {
        return $this->rule;
    }
}