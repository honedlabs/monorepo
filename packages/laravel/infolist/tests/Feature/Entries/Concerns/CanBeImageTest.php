<?php

declare(strict_types=1);

use Honed\Infolist\Entries\ImageEntry;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->entry = ImageEntry::make('avatar');

    Storage::fake('s3');

    Storage::disk('s3')->put('avatar.png', 'test');
});

it('does not format null values', function () {
    expect($this->entry)
        ->format(null)->toBeNull();
});

it('does not format without a disk', function () {
    expect($this->entry)
        ->format('misc')->toBe('misc');
});

it('can have a disk', function () {
    expect($this->entry)
        ->getDisk()->toBeNull()
        ->disk('s3')->toBe($this->entry)
        ->getDisk()->toBe('s3');
});

it('can have a shape', function () {
    expect($this->entry)
        ->getShape()->toBeNull()
        ->square()->toBe($this->entry)
        ->getShape()->toBe('square')
        ->circular()->toBe($this->entry)
        ->getShape()->toBe('circle');
});

it('can have a temporary url', function () {
    expect($this->entry)
        ->isTemporaryUrl()->toBeFalse()
        ->getUrlDuration()->toBe(0)
        ->temporaryUrl()->toBe($this->entry)
        ->isTemporaryUrl()->toBeTrue()
        ->getUrlDuration()->toBe(5);
});

it('formats image urls', function () {
    expect($this->entry)
        ->disk('s3')->toBe($this->entry)
        ->format('avatar.png')->toBe('/storage/avatar.png');
});

it('formats image urls with a temporary url', function () {
    expect($this->entry)
        ->disk('s3')->toBe($this->entry)
        ->temporaryUrl()->toBe($this->entry)
        ->format('avatar.png')->toBeString();
});
