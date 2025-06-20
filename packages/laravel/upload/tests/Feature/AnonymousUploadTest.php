<?php

declare(strict_types=1);

use Honed\Upload\Upload;
use Honed\Upload\UploadData;
use Honed\Upload\UploadRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->upload = Upload::make();
});

it('uploads into a disk', function () {
    expect(Upload::into('r2'))
        ->getDisk()->toBe('r2');
});


it('is response', function () {
    $request = Request::create('/', Request::METHOD_GET, [
        'name' => 'test.png',
        'type' => 'image/png',
        'size' => 1024,
    ]);

    expect($this->upload->toResponse($request))
        ->toBeInstanceOf(JsonResponse::class);
});

it('has array representation', function () {
    expect($this->upload)
        ->toArray()->toHaveKeys([
            'multiple',
            'message',
            'extensions',
            'mimes',
            'size',
        ]);
});

// it('resolves closures by name', function () {
//     $request = presignRequest('test.png', 'image/png', 1024);
//     $upload = Upload::make();
//     $upload->create($request);

//     expect($upload)
//         ->evaluate(fn ($bucket) => $bucket)->toBe('test')
//         ->evaluate(fn ($data) => $data)->toBeInstanceOf(UploadData::class)
//         ->evaluate(fn ($extension) => $extension)->toBe('png')
//         ->evaluate(fn ($type) => $type)->toBe('image/png')
//         ->evaluate(fn ($size) => $size)->toBe(1024)
//         ->evaluate(fn ($meta) => $meta)->toBeNull()
//         ->evaluate(fn ($disk) => $disk)->toBe(config('upload.disk'))
//         ->evaluate(fn ($key) => $key)->toBe('test.png')
//         ->evaluate(fn ($file) => $file)->toBe('test.png')
//         ->evaluate(fn ($filename) => $filename)->toBe('test')
//         ->evaluate(fn ($folder) => $folder)->toBeNull()
//         ->evaluate(fn ($name) => $name)->toBe('test')
//         ->evaluate(fn ($extension) => $extension)->toBe('png')
//         ->evaluate(fn ($type) => $type)->toBe('image/png')
//         ->evaluate(fn ($size) => $size)->toBe(1024)
//         ->evaluate(fn ($meta) => $meta)->toBeNull()
//         ->evaluate(fn ($disk) => $disk)->toBe(config('upload.disk'));
// });

// it('resolves closures by type', function () {
//     $request = presignRequest('test.png', 'image/png', 1024);
//     $upload = Upload::make();
//     $upload->create($request);

//     expect($upload)
//         ->evaluate(fn (UploadData $d) => $d)->toBeInstanceOf(UploadData::class);
// });
