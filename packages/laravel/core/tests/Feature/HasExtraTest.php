<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasExtra;
use Honed\Core\Contracts\WithExtra;
use Honed\Core\Tests\Stubs\Product;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->test = new class {
        use Evaluable, HasExtra;
    };

    $this->user = User::factory()->create();
});

it('sets', function () {
    expect($this->test)
        ->getExtra()->toEqual([])
        ->hasExtra()->toBeFalse()
        ->extra(['key' => 'value'])->toBe($this->test)
        ->getExtra()->toEqual(['key' => 'value'])
        ->hasExtra()->toBeTrue();
});


it('evaluates', function () {
    expect($this->test)
        ->extra(fn (User $user) => ['id' => $user->id])->toBe($this->test)
        ->getExtra(['user' => $this->user])->toEqual(['id' => $this->user->id]);
});

it('has contract', function () {
    $test = new class implements WithExtra{
        use Evaluable, HasExtra;

        public function extraUsing(User $user)
        {
            return ['id' => $user->id];
        }
    };

    expect($test)
        ->getExtra(['user' => $this->user])->toEqual(['id' => $this->user->id])
        ->hasExtra()->toBeTrue();
});


