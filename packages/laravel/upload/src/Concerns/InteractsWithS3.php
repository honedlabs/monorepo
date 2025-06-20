<?php

declare(strict_types=1);

namespace Honed\Upload\Concerns;

trait InteractsWithS3
{
    /**
     * The policy to use for the uploads ACL.
     *
     * @var string
     */
    protected $policy = 'private';

    /**
     * The filesystem disk to use.
     * 
     * @var string
     */
    protected $disk = 's3';

    /**
     * The S3 bucket to use.
     * 
     * @var string|null
     */
    protected $bucket;

    /**
     * Set the policy to use for the uploads ACL.
     *
     * @param  string  $policy
     * @return $this
     */
    public function policy($policy)
    {
        $this->policy = $policy;

        return $this;
    }

    /**
     * Set the policy to use for the uploads ACL to public-read.
     *
     * @return $this
     */
    public function publicRead()
    {
        return $this->policy('public-read');
    }

    /**
     * Set the policy to use for the uploads ACL to private.
     *
     * @return $this
     */
    public function private()
    {
        return $this->policy('private');
    }

    /**
     * Get the access control list policy.
     *
     * @return string
     */
    public function getPolicy()
    {
        return $this->acl;
    }

    /**
     * Set the filesystem disk to use.
     *
     * @param  string  $disk
     * @return $this
     */
    public function disk($disk = 's3')
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * Get the filesystem disk to use.
     *
     * @return string
     */
    public function getDisk()
    {
        return $this->disk;
    }

    /**
     * Set the S3 bucket to use.
     *
     * @param  string  $bucket
     * @return $this
     */
    public function bucket($bucket)
    {
        $this->bucket = $bucket;

        return $this;
    }

    /**
     * Get the S3 bucket to use.
     *
     * @return string
     */
    public function getBucket()
    {
        $this->bucket ??= config("filesystems.disks.{$this->getDisk()}.bucket");

        if (! $this->bucket) {
            throw new \Exception('No bucket specified for the upload.');
        }

        return $this->bucket;
    }

    /**
     * Get the form inputs for the S3 presigner.
     *
     * @param  string  $key
     * @return array
     */
    public function getFormInputs($key)
    {
        return [
            'acl' => $this->getPolicy(),
            'key' => $key,
        ];
    }

    /**
     * Get the policy options for the request.
     *
     * @param  string  $key
     * @param  string  $type
     * @param  int  $min
     * @param  int  $max
     * @return array<int,array<int,string|int>>
     */
    public function getOptions($key, $type, $min = 0, $max = 2147483647)
    {
        return [
            ['eq', '$acl', $this->getPolicy()],
            ['eq', '$key', $key],
            ['eq', '$bucket', $this->getBucket()],
            ['content-length-range', $min, $max],
            ['eq', '$Content-Type', $type],
        ];
    }
}