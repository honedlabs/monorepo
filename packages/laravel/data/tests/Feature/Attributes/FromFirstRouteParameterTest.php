<?php

declare(strict_types=1);

use App\Enums\Locale;
use App\Models\Product;
use App\Models\User;
use Honed\Data\Attributes\FromFirstRouteParameter;
use Honed\Data\Data\FormData;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->data = new class extends FormData {
        #[FromFirstRouteParameter(Authenticatable::class)]
        public ?User $user;
    };

    $this->user = User::factory()->create();
});

it('injects property', function () {
    expect($this->data::from(request())->user)
        ->toBeInstanceOf(User::class)
        ->id->toBe($this->user->getKey());
})->with([
    fn () => get(route('users.show', $this->user)),
    fn () => get(route('locales.users.show', [Locale::English, $this->user])),
    fn () => get(route('products.users.show', [Product::factory()->for($this->user)->create(), $this->user]))
]);


it('skips', function (mixed $value) {
    expect($this->data::from($value))
        ->user->toBeNull();
})->with([
    fn () => new stdClass(),
    fn () => get(route('users.index'))->baseRequest
]);