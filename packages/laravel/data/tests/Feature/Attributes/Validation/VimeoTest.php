<?php

declare(strict_types=1);

use App\Data\Validation\VimeoData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], VimeoData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
})->with([
    [true, 'https://vimeo.com/123456789'],
    [true, 'http://vimeo.com/123456789'],
    [true, 'vimeo.com/123456789'],
    [true, 'https://www.vimeo.com/123456789'],
    [true, 'http://www.vimeo.com/123456789'],
    [true, 'https://player.vimeo.com/123456789'],
    [true, 'http://player.vimeo.com/123456789'],
    [true, 'https://vimeo.com/channels/staffpicks/123456789'],
    [true, 'https://vimeo.com/channels/staffpicks/123456789'],
    [true, 'https://vimeo.com/groups/name/videos/123456789'],
    [true, 'https://vimeo.com/album/123456/video/789012345'],
    [true, 'https://vimeo.com/video/123456789'],
    [true, 'https://vimeo.com/123456789?autoplay=1'],
    [true, 'https://vimeo.com/123456789#t=30s'],
    [true, 'https://vimeo.com/123456789?autoplay=1&loop=1'],
    [false, 'https://youtube.com/watch?v=123456789'],
    [false, 'https://example.com/video/123456789'],
    [false, 'https://vimeo.com/'],
    [false, 'https://vimeo.com/channels/'],
    [false, 'https://vimeo.com/groups/'],
    [false, 'https://vimeo.com/album/'],
    [false, 'https://vimeo.com/video/'],
    [false, 'https://vimeo.com/abc'],
    [false, 'https://vimeo.com/123abc'],
    [false, 'https://vimeo.com/123-456-789'],
    [false, 'https://vimeo.com/123.456.789'],
    [false, 'not-a-url'],
    [false, ''],
    [false, 'ftp://vimeo.com/123456789'],
    [false, 'https://vimeo.org/123456789'],
    [false, 'https://vimeo.net/123456789'],
    [false, 'https://vimeo.com/channels/invalid-channel/'],
    [false, 'https://vimeo.com/groups/invalid-group/videos/'],
    [false, 'https://vimeo.com/album/invalid-album/video/'],

]);
