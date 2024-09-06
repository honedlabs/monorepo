<?php

use Workbench\App\Commands\CoreGenerator;

beforeEach(function () {
    $this->command = new CoreGenerator();
});

it('can check for collisions', function () {
    expect($this->command->proxyCheckForCollision(['src/Core.php']))->toBeFalse();
});

it('can check if a file exists', function () {
    expect($this->command->proxyFileExists(app_path('Invalid.php')))->toBeFalse();
});

it('can write a file', function () {
    $this->command->proxyWriteFile(app_path('Valid.php'), '<?php echo "Hello, World!";');
    expect(file_exists(app_path('Valid.php')))->toBeTrue();
    expect(file_get_contents(app_path('Valid.php')))->toBe('<?php echo "Hello, World!";');
});

it('can copy a stub to the target path', function () {
    $this->command->proxyWriteFile(base_path('/stubs/example.stub'), '<?php echo "Hello, World!";');
    expect(file_exists(base_path('/stubs/example.stub')))->toBeTrue();
    $targetPath = app_path('Valid.php');
    $this->command->proxyCopyStubToApp('example', $targetPath, '<?php echo "Hello, World!";');
    expect(file_exists($targetPath))->toBeTrue();
    expect(file_get_contents($targetPath))->toBe('<?php echo "Hello, World!";');
});
