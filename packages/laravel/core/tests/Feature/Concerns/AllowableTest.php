<?php

use Workbench\App\Models\User;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Contracts\WithAllowance;

beforeEach(function () {
    $this->test = new class {
        use Allowable, Evaluable;
    };

    $this->user = User::factory()->create();
});

it('sets', function () {
    expect($this->test)
        ->isAllowed()->toBeTrue()
        ->allow(false)->toBe($this->test)
        ->isAllowed()->toBeFalse();
});

it('evaluates', function () {
    expect($this->test)
        ->allow(fn (User $user) => $user->id > 100)
        ->isAllowed(['user' => $this->user])->toBeFalse();
});

it('has contract', function () {
    $test = new class implements WithAllowance {
        use Allowable, Evaluable;

        /**
         * {@inheritdoc}
         */
        public function allowUsing(User $user)
        {
            return $user->id > 100;
        }
    };

    expect($test)
        ->isAllowed(['user' => $this->user])->toBeFalse();
});