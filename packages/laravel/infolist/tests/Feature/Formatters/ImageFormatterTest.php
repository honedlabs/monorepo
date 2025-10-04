<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\ImageFormatter;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->entry = new ImageFormatter();

    Storage::fake('s3');

    Storage::disk('s3')->put('avatar.png', 'test');
});

it('does not format null values', function () {
    expect($this->entry)
        ->format(null)->toBeNull();
});

it('does not format without a disk', function () {
    $image = fake()->imageUrl();

    expect($this->entry)
        ->format($image)->toBe($image);
});

it('has disk', function () {
    expect($this->entry)
        ->getDisk()->toBeNull()
        ->disk('s3')->toBe($this->entry)
        ->getDisk()->toBe('s3');
});

it('has expiry', function () {
    expect($this->entry)
        ->getExpiry()->toBeNull()
        ->expiresIn(5)->toBe($this->entry)
        ->getExpiry()->toBe(5);
});

it('formats image urls', function () {
    expect($this->entry)
        ->disk('s3')->toBe($this->entry)
        ->format('avatar.png')->toBe('/storage/avatar.png');
});

it('formats image urls with a temporary url', function () {
    expect($this->entry)
        ->disk('s3')->toBe($this->entry)
        ->expiresIn(5)->toBe($this->entry)
        ->format('avatar.png')->toBeString();
});
