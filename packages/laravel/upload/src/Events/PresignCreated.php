<?php

declare(strict_types=1);

namespace Honed\Upload\Events;

class PresignCreated
{
    /**
     * The upload class instance.
     * 
     * @var class-string<\Honed\Upload\Upload>
     */
    public $upload;

    /**
     * The upload data used to create the presign.
     *
     * @var \Honed\Upload\UploadData
     */
    public $data;

    /**
     * The filesystem to upload into.
     */

    /**
     * Create a new event instance.
     *
     * @param  class-string<\Honed\Upload\Upload>  $upload
     * @param  \Honed\Upload\UploadData  $data
     * @return void
     */
    public function __construct($upload, $data)
    {
        $this->upload = $upload;
        $this->data = $data;
    }
}
