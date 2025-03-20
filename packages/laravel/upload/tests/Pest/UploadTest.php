<?php

declare(strict_types=1);

use Honed\Upload\Upload;

beforeEach(function () {
    $this->upload = Upload::make();
});

it('has disk', function () {
    expect($this->upload)
        ->getDisk()->toBe(config('upload.disk'))
        ->disk('r2')->toBeInstanceOf(Upload::class)
        ->getDisk()->toBe('r2');
});


it('has path', function () {
    expect(Upload::make())
        ->getPath()->toBeNull()
        ->path('test')->toBeInstanceOf(Upload::class)
        ->getPath()->toBe('test');
});

it('has name', function () {
    expect(Upload::make())
        ->getName()->toBeNull()
        ->name('test')->toBeInstanceOf(Upload::class)
        ->getName()->toBe('test');
});

it('has access control list', function () {
    expect(Upload::make())
        ->getACL()->toBe(config('upload.acl'))
        ->acl('private-read')->toBeInstanceOf(Upload::class)
        ->getACL()->toBe('private-read');
});

it('creates form inputs', function () {
    $key = 'test';

    expect(Upload::make()->getFormInputs($key))->toEqual([
        'acl' => config('upload.acl'),
        'key' => $key,
    ]);
});

it('creates policy options', function () {
    $key = 'test';

    expect(Upload::make())
        ->getOptions($key)->toBeArray()
        ->toHaveCount(4);
});

// it('has form attributes as array representation', function () {
//     expect(Upload::make())
//         ->multiple()->toBeInstanceOf(Upload::class)
//         ->accepts(['image/png', 'video/'])
//         ->toArray()->toEqual([
//             'multiple' => true,
//             'accept' => 'image/png,video/*',
//         ]);
// });
