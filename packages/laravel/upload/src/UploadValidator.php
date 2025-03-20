<?php

declare(strict_types=1);

namespace Honed\Upload;

use Honed\Upload\Concerns\HasExpiry;
use Honed\Upload\Concerns\HasMax;
use Honed\Upload\Concerns\HasMin;
use Honed\Upload\Concerns\HasTypes;
use Illuminate\Support\Number;

class UploadValidator
{
    use HasExpiry;
    use HasMax;
    use HasMin;
    use HasTypes;

    /**
     * Create the general rules for this upload.
     * 
     * @return array<string, mixed>
     */
    public function createRules()
    {
        return [
            'name' => ['required', 'string', 'max:1024'],
            'extension' => [
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $extensions = $this->getExtensions();

                    if (! filled($extensions)) {
                        return;
                    }

                    if (! \in_array($value, $extensions)) {
                        $fail(\sprintf(
                            "The file %s must be one of the following: %s.",
                            $attribute,
                            \implode(', ', $extensions)
                        ));
                    }
                },
            ],
            'size' => [
                'required',
                'integer',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $min = $this->getMin();

                    if ($value < $min) {
                        $fail(\sprintf(
                            "The file %s must be at least %s.",
                            $attribute,
                            Number::fileSize($min)
                        ));
                    }

                    $max = $this->getMax();

                    if ($value > $max) {
                        $fail(\sprintf(
                            "The file %s cannot exceed %s.",
                            $attribute,
                            Number::fileSize($max)
                        ));
                    }
                },
            ],
            'type' => [
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $types = $this->getTypes();

                    if (! filled($types)) {
                        return;
                    }

                    if (! \in_array($value, $types)) {
                        $fail(\sprintf(
                            "The file %s is not supported.",
                            $attribute,
                        ));
                    }
                },
            ],
            'meta' => ['nullable'],
        ];
    }
}