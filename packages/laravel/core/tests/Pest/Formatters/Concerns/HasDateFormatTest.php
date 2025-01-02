<?php

use Honed\Core\Formatters\Concerns\HasDateFormat;

class HasDateFormatComponent
{
    use HasDateFormat;
}

beforeEach(function () {
    $this->component = new HasDateFormatComponent;
    HasDateFormatComponent::useDateFormat();
});

it('has a default date format', function () {
    expect($this->component)
        ->getDateFormat()->toBe(HasDateFormatComponent::DefaultDateFormat);
});

it('sets date format', function () {
    $this->component->setDateFormat('DateFormat');
    expect($this->component)
        ->getDateFormat()->toBe('DateFormat');
});

it('rejects null values', function () {
    $this->component->setDateFormat('DateFormat');
    $this->component->setDateFormat(null);
    expect($this->component)
        ->getDateFormat()->toBe('DateFormat');
});

it('chains date format', function () {
    expect($this->component->dateFormat('DateFormat'))->toBeInstanceOf(HasDateFormatComponent::class)
        ->getDateFormat()->toBe('DateFormat');
});

it('has configurable default date format', function () {
    HasDateFormatComponent::useDateFormat('DateFormat');
    expect(HasDateFormatComponent::getDefaultDateFormat())->toBe('DateFormat');
    expect($this->component)->getDateFormat()->toBe('DateFormat');
});

it('has shorthand `dMY`', function () {
    expect($this->component->dMY('-'))->toBeInstanceOf(HasDateFormatComponent::class)
        ->getDateFormat()->toBe('d-M-Y');
});

it('has shorthand `Ymd`', function () {
    expect($this->component->Ymd())->toBeInstanceOf(HasDateFormatComponent::class)
        ->getDateFormat()->toBe('Y-m-d');
});
