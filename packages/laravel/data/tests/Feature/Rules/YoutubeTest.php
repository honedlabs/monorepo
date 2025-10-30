<?php

declare(strict_types=1);

use Honed\Data\Rules\Youtube;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new Youtube();
});

it('validates', function (bool $expected, string $input) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    [true, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
    [true, 'http://www.youtube.com/watch?v=dQw4w9WgXcQ'],
    [true, 'https://youtube.com/watch?v=dQw4w9WgXcQ'],
    [true, 'http://youtube.com/watch?v=dQw4w9WgXcQ'],
    [true, 'www.youtube.com/watch?v=dQw4w9WgXcQ'],
    [true, 'youtube.com/watch?v=dQw4w9WgXcQ'],
    [true, 'https://m.youtube.com/watch?v=dQw4w9WgXcQ'],
    [true, 'http://m.youtube.com/watch?v=dQw4w9WgXcQ'],
    [true, 'm.youtube.com/watch?v=dQw4w9WgXcQ'],
    [true, 'https://youtu.be/dQw4w9WgXcQ'],
    [true, 'http://youtu.be/dQw4w9WgXcQ'],
    [true, 'youtu.be/dQw4w9WgXcQ'],
    [true, 'https://www.youtube.com/embed/dQw4w9WgXcQ'],
    [true, 'https://youtube.com/embed/dQw4w9WgXcQ'],
    [true, 'https://www.youtube.com/v/dQw4w9WgXcQ'],
    [true, 'https://youtube.com/v/dQw4w9WgXcQ'],
    [true, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ&t=30s'],
    [true, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ&list=PLrAXtmRdnEQy6nuLMOV8Fm4jq3Q'],
    [true, 'https://www.youtube.com/watch?feature=player_embedded&v=dQw4w9WgXcQ'],
    [true, 'https://youtu.be/dQw4w9WgXcQ?t=30s'],
    [true, 'https://youtu.be/dQw4w9WgXcQ&feature=youtu.be'],
    [false, 'https://vimeo.com/123456789'],
    [false, 'https://example.com/video/dQw4w9WgXcQ'],
    [false, 'https://youtube.com/'],
    [false, 'https://youtube.com/watch'],
    [false, 'https://youtube.com/watch?v='],
    [false, 'https://youtube.com/watch?v=short'],
    [false, 'https://youtube.com/watch?v=dQw4w9WgXcQtoolong'],
    [false, 'https://youtube.com/watch?v=dQw4w9WgXcQ@'],
    [false, 'https://youtube.com/watch?v=dQw4w9WgXcQ#'],
    [false, 'https://youtube.com/watch?v=dQw4w9WgXcQ+'],
    [false, 'not-a-url'],
    [false, ''],
    [false, 'ftp://youtube.com/watch?v=dQw4w9WgXcQ'],
    [false, 'https://youtube.org/watch?v=dQw4w9WgXcQ'],
    [false, 'https://youtube.net/watch?v=dQw4w9WgXcQ'],
    [false, 'https://youtube.com/channel/UCuAXFkgsw1L7xaCfnd5JJOw'],
    [false, 'https://youtube.com/playlist?list=PLrAXtmRdnEQy6nuLMOV8Fm4jq3Q'],
    [false, 'https://youtube.com/user/username'],
    [false, 'https://youtube.com/c/channelname'],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validator', function () {
    $validator = Validator::make([
        'value' => 5,
    ], [
        'value' => [$this->rule],
    ]);

    expect($validator)
        ->fails()->toBeTrue()
        ->errors()
        ->scoped(fn ($bag) => $bag
            ->first('value')
            ->toBe(__('honed-data::validation.youtube', ['attribute' => 'value']))
        );
});
