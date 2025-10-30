<?php

declare(strict_types=1);

use Honed\Data\Rules\Filename;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->rule = new Filename();
});

it('validates', function (bool $expected, string $input) {
    expect($this->rule)
        ->isValid($input)->toBe($expected);
})->with([
    [true, 'file.txt'],
    [true, 'document.pdf'],
    [true, 'image.jpg'],
    [true, 'photo.png'],
    [true, 'video.mp4'],
    [true, 'audio.mp3'],
    [true, 'archive.zip'],
    [true, 'script.php'],
    [true, 'style.css'],
    [true, 'my_file.txt'],
    [true, 'my-file.txt'],
    [true, 'my_file-name.pdf'],
    [true, 'file_name-with-dash.txt'],
    [true, 'file.name.txt'],
    [true, 'document.version.pdf'],
    [true, 'test.file.name.pdf'],
    [true, 'my file.txt'],
    [true, 'my document.pdf'],
    [true, 'fileé.txt'],
    [true, 'documentñ.pdf'],
    [true, 'file_中文.txt'],
    [true, 'very_long_filename_that_goes_on_and_on_and_on.txt'],
    [true, 'another-very-long-filename-with-hyphens.pdf'],
    [true, 'a.txt'],
    [true, '1.pdf'],
    [true, 'file'],
    [true, 'filename'],
    [true, 'myfile'],
    [true, ''],
    [true, '123.pdf'],
    [true, '1.txt'],
    [true, '2023.jpg'],
    [false, 'path/to/file.txt'],
    [false, '/file.txt'],
    [false, 'file/path.txt'],
    [false, '/'],
    [false, '/filename'],
    [false, 'path\\to\\file.txt'],
    [false, '\\file.txt'],
    [false, 'C:\\path\\file.txt'],
    [false, 'file\\path.txt'],
    [false, '\\'],
]);

it('validates with extensions', function (bool $expected, string $input) {
    expect(new Filename(['jpg', 'png']))
        ->isValid($input)->toBe($expected);
})->with([
    [true, 'image.jpg'],
    [true, 'photo.png'],
    [true, 'IMAGE.JPG'],
    [true, 'PHOTO.PNG'],
    [true, 'Image.Jpg'],
    [true, 'Photo.Png'],
    [true, 'image.JPG'],
    [true, 'photo.PNG'],
    [true, 'file1.jpg'],
    [true, 'file2.png'],
    [true, 'myimage.jpg'],
    [true, 'myphoto.png'],
    [true, 'my_image.jpg'],
    [true, 'my-image.jpg'],
    [true, 'my image.jpg'],
    [true, 'my_image_file.jpg'],
    [true, 'file.name.jpg'],
    [true, 'file.name.png'],
    [false, 'image.gif'],
    [false, 'photo.bmp'],
    [false, 'document.pdf'],
    [false, 'video.mp4'],
    [false, 'audio.mp3'],
    [false, 'text.txt'],
    [false, 'script.php'],
    [false, 'file.doc'],
    [false, 'archive.zip'],
    [false, 'image'],
    [false, 'photo'],
    [false, 'file.jpgx'],
    [true, 'file.jpg.png'],
    [false, 'file.jpg.txt'],
    [false, 'path/to/image.jpg'],
    [false, 'path\\to\\image.jpg'],
    [false, '/image.jpg'],
    [false, '\\image.jpg'],
    [false, 'image/path.jpg'],
    [false, 'image\\path.jpg'],
    [true, '.jpg'],
    [false, 'image.'],
    [true, 'image.jpg.jpg'],
]);

it('passes validator', function () {
    $validator = Validator::make([
        'value' => 'document.pdf',
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
            ->toBe(__('honed-data::validation.filename', ['attribute' => 'value']))
        );
});
