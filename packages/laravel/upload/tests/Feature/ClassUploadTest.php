<?php

declare(strict_types=1);

use Workbench\App\Uploads\AvatarUpload;


beforeEach(function () {
    $this->upload = AvatarUpload::make();
});

it('has definition', function () {
    expect($this->upload)
        ->getMinSize()->toBe(0)
        ->getMaxSize()->toBe(2 * 1024 * 1024)
        ->getMimeTypes()->toEqual(['image/jpeg', 'image/png'])
        ->getExtensions()->toEqual(['jpg', 'jpeg', 'png'])
        ->getPolicy()->toBe('public-read')
        ->getPathCallback()->toBeInstanceOf(Closure::class);
});

it('creates upload', function () {

})->todo();