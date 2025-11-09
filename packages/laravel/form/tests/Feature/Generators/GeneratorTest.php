<?php

declare(strict_types=1);

use Honed\Form\Adapters\TextAdapter;
use Honed\Form\Form;
use Honed\Form\Generators\DataGenerator;

beforeEach(function () {
    $this->generator = app(DataGenerator::class);
});

it('has form', function () {
    expect($this->generator)
        ->form($form = Form::make())->toBe($this->generator)
        ->getForm()->toBe($form)
        ->form()->toBe($this->generator)
        ->getForm()
        ->scoped(fn ($form) => $form
            ->toBeInstanceOf(Form::class)
            ->not->toBe($form)
        )
        ->newForm()->not->toBe($form);
});

it('has adapters', function () {
    $count = count(config('honed-form.adapters'));

    expect($this->generator)
        ->adapters(TextAdapter::class)->toBe($this->generator)
        ->getAdapters()->toHaveCount($count + 1)
        ->getGlobalAdapters()->toHaveCount($count);
});
