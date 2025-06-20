<?php

declare(strict_types=1);

namespace Honed\Upload\Concerns;

use Closure;
use Honed\Upload\Contracts\ShouldAnonymize;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function is_string;
use function mb_strtolower;
use function pathinfo;

trait HasFile
{
    /**
     * The name of the file to be stored.
     *
     * @var string|Closure(mixed...):string|null
     */
    protected $name;

    /**
     * Whether the file name should be generated using a UUID.
     *
     * @var bool|null
     */
    protected $anonymize;

    /**
     * The file data.
     * 
     * @var \Honed\Upload\File|null
     */
    protected $file;

    /**
     * Set the name, or method, of generating the name of the file to be stored.
     *
     * @param  Closure(mixed...):string|string  $name
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
     * @return Closure(mixed...):string|string|null
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

        if ($this instanceof ShouldAnonymize) {
            return true;
        }

        return $this->isAnonymizedByDefault();
    }

    /**
     * Determine whether the file name should be anonymized using a UUID by default.
     *
     * @return bool
     */
    public function isAnonymizedByDefault()
    {
        return (bool) config('upload.anonymize', false);
    }


    /**
     * Get the complete filename of the file to be stored.
     *
     * @param  \Honed\Upload\UploadData  $data
     * @return string
     */
    public function createFilename($data)
    {
        return once(function () use ($data) {
            $name = $this->getName();

            if ($this->isAnonymized()) {
                return Str::uuid()->toString();
            }

            if (isset($name)) {
                return $this->evaluate($name);
            }

            return $data->name;
        });
    }

    /**
     * Build the storage key location for the uploaded file.
     *
     * @param  \Honed\Upload\UploadData  $data
     * @return string
     */
    public function createKey($data)
    {
        return once(function () use ($data) {
            $filename = $this->createFilename($data);

            $location = $this->evaluate($this->getLocation());

            return Str::of($filename)
                ->append('.', $data->extension)
                ->when($location, fn ($name, $location) => $name
                    ->prepend($location, '/')
                    ->replace('//', '/'),
                )->trim('/')
                ->value();
        });
    }
}
