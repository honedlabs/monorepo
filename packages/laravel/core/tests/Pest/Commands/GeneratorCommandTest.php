<?php

use Honed\Core\Tests\Stubs\CoreGenerator;

beforeEach(function () {
    $this->command = new CoreGenerator;
});

it('has two arguments', function () {
    expect($this->command->proxyGetArguments())->toHaveLength(2);
});

it('prompts for missing name', function () {
    expect($this->command->proxyPromptForMissingArgumentsUsing())->toHaveKey('name');
});

it('has a force option', function () {
    expect($this->command->proxyGetOptions())->toHaveLength(1);
    expect($this->command->proxyGetOptions()[0])->toContain('force');
});

it('has a default stub path', function () {
    expect($this->command->proxyGetDefaultStubPath())->toBeString();
});
