<?php

declare(strict_types=1);

use Honed\Chart\Enums\Cursor;
use Honed\Chart\Series\Line;

beforeEach(function () {
    $this->series = Line::make();
});

it('has cursor', function () {
    expect($this->series)
        ->getCursor()->toBeNull()
        ->cursorPointer()->toBe($this->series)
        ->getCursor()->toBe(Cursor::Pointer)
        ->cursorDefault()->toBe($this->series)
        ->getCursor()->toBe(Cursor::Default)
        ->cursor(Cursor::Pointer)->toBe($this->series)
        ->getCursor()->toBe(Cursor::Pointer);
});
