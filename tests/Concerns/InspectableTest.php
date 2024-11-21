<?php

use Honed\Core\Concerns\Inspectable;

class DummyInspectable
{
    use Inspectable;

    public string $publicProperty = 'public value';
    private string $privateProperty = 'private value';
    
    public function someMethod()
    {
        return 'method value';
    }
}

it('can inspect a public property', function () {
    $dummy = new DummyInspectable();
    
    expect($dummy->inspect('publicProperty'))->toBe('public value');
});

it('cannot inspect an undefined property', function () {
    $dummy = new DummyInspectable();
    
    expect($dummy->inspect('undefinedProperty'))->toBeNull();
});

it('can inspect a method', function () {
    $dummy = new DummyInspectable();
    
    expect($dummy->inspect('someMethod'))->toBe('method value');
});

it('returns default value for undefined keys', function () {
    $dummy = new DummyInspectable();
    
    expect($dummy->inspect('undefinedKey', 'default'))->toBe('default');
});

it('evaluates callable default values', function () {
    $dummy = new DummyInspectable();
    
    expect($dummy->inspect('undefinedKey', fn() => 'computed default'))
        ->toBe('computed default');
});

it('throws exception if default value is throwable', function () {
    $dummy = new DummyInspectable();
    $exception = new Exception('Custom error');
    
    expect(fn() => $dummy->inspect('undefinedKey', $exception))
        ->toThrow(Exception::class, 'Custom error');
});

it('can inspect a private property', function () {
    $dummy = new DummyInspectable();
    expect($dummy->inspect('privateProperty'))->toBe('private value');
});

it('cannot inspect a property which does not exist', function () {
    $dummy = new DummyInspectable();
    expect($dummy->inspect('nonExistentProperty'))->toBeNull();
});
