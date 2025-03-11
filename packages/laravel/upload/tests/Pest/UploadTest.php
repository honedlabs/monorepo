<?php

declare(strict_types=1);

use Honed\Upload\Upload;
use Illuminate\Support\Str;

it('has disk', function () {
    expect(Upload::make())
        ->getDisk()->toBe(config('upload.disk'))
        ->disk('r2')->toBeInstanceOf(Upload::class)
        ->getDisk()->toBe('r2');
});

it('has max size', function () {
    expect(Upload::make())
        ->getMaxSize()->toBe(config('upload.size.max'))
        ->max(1000)->toBeInstanceOf(Upload::class)
        ->getMaxSize()->toBe(1000);
});

it('has min size', function () {
    expect(Upload::make())
        ->getMinSize()->toBe(config('upload.size.min'))
        ->min(1000)->toBeInstanceOf(Upload::class)
        ->getMinSize()->toBe(1000);
});

it('has sizes', function () {
    expect(Upload::make())
        ->size(1000)->toBeInstanceOf(Upload::class)
        ->getMinSize()->toBe(config('upload.size.min'))
        ->getMaxSize()->toBe(1000)
        ->size(1, 10)->toBeInstanceOf(Upload::class)
        ->getMinSize()->toBe(1)
        ->getMaxSize()->toBe(10);
});

it('has unit', function () {
    expect(Upload::make())
        ->getUnit()->toBe(config('upload.size.unit'))
        ->unit('petabytes')->toBeInstanceOf(Upload::class)
        ->getUnit()->toBe('petabytes')
        ->bytes()->toBeInstanceOf(Upload::class)
        ->getUnit()->toBe('bytes')
        ->kilobytes()->toBeInstanceOf(Upload::class)
        ->getUnit()->toBe('kilobytes')
        ->megabytes()->toBeInstanceOf(Upload::class)
        ->getUnit()->toBe('megabytes')
        ->gigabytes()->toBeInstanceOf(Upload::class)
        ->getUnit()->toBe('gigabytes');
});

it('accepts types', function () {
    expect(Upload::make())
        ->getAccepted()->toEqual(config('upload.accepts'))
        ->accepts('image/png')->toBeInstanceOf(Upload::class)
        ->getAccepted()->toEqual(['image/png'])
        ->accepts('image/svg+xml')->toBeInstanceOf(Upload::class)
        ->getAccepted()->toEqual(['image/svg+xml'])
        ->acceptsImages()->toBeInstanceOf(Upload::class)
        ->getAccepted()->toEqual(['image/'])
        ->acceptsVideos()->toBeInstanceOf(Upload::class)
        ->getAccepted()->toEqual(['video/'])
        ->acceptsAudio()->toBeInstanceOf(Upload::class)
        ->getAccepted()->toEqual(['audio/']);
});

it('has duration', function () {
    $fn = fn ($d) => \sprintf('+%d seconds', $d);

    expect(Upload::make())
        ->getDuration()->toBe(config('upload.expires'))
        ->duration(1)->toBeInstanceOf(Upload::class)
        ->getDuration()->toBe($fn(1))
        ->expires(1)->toBeInstanceOf(Upload::class)
        ->getDuration()->toBe($fn(1))
        ->seconds(1)->toBeInstanceOf(Upload::class)
        ->getDuration()->toBe($fn(1))
        ->minutes(1)->toBeInstanceOf(Upload::class)
        ->getDuration()->toBe('+1 minutes')
        ->duration('+1 hour')->toBeInstanceOf(Upload::class)
        ->getDuration()->toBe('+1 hour')
        ->duration(now()->addMinute())->toBeInstanceOf(Upload::class)
        ->getDuration()->toBe($fn(60));
});

it('has access control list', function () {
    expect(Upload::make())
        ->getAccessControlList()->toBe(config('upload.acl'))
        ->acl('private-read')->toBeInstanceOf(Upload::class)
        ->getAccessControlList()->toBe('private-read');
});