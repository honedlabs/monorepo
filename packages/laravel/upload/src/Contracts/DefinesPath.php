<?php

declare(strict_types=1);

namespace Honed\Upload\Contracts;

interface DefinesPath
{
    /**
     * Define the path to the store the upload.
     * 
     * @return string
     */
    public function definePath();
}