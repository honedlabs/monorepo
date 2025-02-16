<?php

declare(strict_types=1);

use Illuminate\Routing\Route;
use function Pest\Laravel\get;

use Honed\Core\Concerns\HasRequest;
use Honed\Core\Tests\Stubs\Product;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Http\Request;

class RequestTest
{
    use HasRequest;
}

beforeEach(function () {
    $this->request = RequestFacade::create('/');
    $this->test = new RequestTest;
});

it('sets', function () {
    expect($this->test->request($this->request))
        ->toBeInstanceOf(RequestTest::class)
        ->getRequest()->toBe($this->request);
});

it('gets', function () {
    expect($this->test->request($this->request))
        ->getRequest()->toBe($this->request);
});

it('has named parameters', function (string $name, string $type) {
    $p = product();
    
    get(route('products.show', $p))
        ->assertOk();

    $this->test->request(RequestFacade::instance());

    expect($this->test->resolveRequestClosureDependencyForEvaluationByName($name))
        ->{0}->toBeInstanceOf($type);
})->with([
    ['request', Request::class],
    ['route', Route::class],
    ['product', Product::class],
]);

it('has typed parameters', function (string $type) {
    $p = product();
    
    get(route('products.show', $p))
        ->assertOk();

    $this->test->request(RequestFacade::instance());

    expect($this->test->resolveRequestClosureDependencyForEvaluationByType($type))
        ->{0}->toBeInstanceOf($type);
})->with([
    [Request::class],
    [Route::class],
    [Product::class],
]);