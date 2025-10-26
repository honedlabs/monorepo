<?php

declare(strict_types=1);

use App\Data\Validation\FilenameData;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {});

it('validates', function (bool $expected, mixed $input) {
    expect(Validator::make([
        'test' => $input,
    ], FilenameData::getValidationRules([
        'test' => $input,
    ])))->passes()->toBe($expected);
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
