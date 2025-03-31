<?php

declare(strict_types=1);

namespace Honed\Upload\Tests\Fixtures;

use Honed\Upload\Upload;
use Honed\Upload\Contracts\DefinesPath;
use Honed\Upload\Contracts\DefinesTypes;

final class AvatarUpload extends Upload implements DefinesPath
{
    /**
     * Provide the upload with any necessary setup.
     *
     * @return void
     */
    public function setUp()
    {
        $this->max(1024 * 1024 * 2); // 2MB
    }

    /**
     * {@inheritdoc}
     */
    public function definePath()
    {
        return 'avatars';
    }
}