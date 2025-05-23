<?php

declare(strict_types=1);

use Inertia\Support\Header;
use function Pest\Laravel\get;
use function Pest\Laravel\from;
use Honed\Modal\Support\ModalHeader;
use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia;
use Honed\Modal\Tests\Stubs\ExampleController;
use Honed\Modal\Tests\Stubs\ExampleMiddleware;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Routing\Middleware\SubstituteBindings;

beforeEach(function () {
    Route::middleware([StartSession::class, ExampleMiddleware::class, SubstituteBindings::class])
        ->group(function () {
            Route::get('/', fn () => inertia()->render('Home'))->name('home');
            Route::get('raw/{user}', [ExampleController::class, 'rawUser'])->name('raw.users.show');
            Route::get('raw/{user}/{tweet}', [ExampleController::class, 'rawTweet'])->name('raw.users.tweets.show');
            Route::get('{user}', [ExampleController::class, 'user'])->name('users.show');
            Route::get('{user}/{tweet}', [ExampleController::class, 'tweet'])->name('users.tweets.show');

            Route::get('different/{user}/{tweet}', [ExampleController::class, 'differentParameters'])->name('different.users.tweets.show');
        });
});

it('can be rendered', function () {
    $user = user();
    $tweet = tweet($user);

    get(route('users.tweets.show', [$user, $tweet]))
        ->assertSuccessful()
        ->assertInertia(function (AssertableInertia $page) use ($user, $tweet) {
            $page->component('Users/Show')
                ->where('modal.baseURL', route('users.show', $user))
                ->where('modal.component', 'Tweets/Show')
                ->where('modal.props.user.username', $user->username)
                ->where('modal.props.tweet.body', $tweet->body);
        });
});

it('passes raw data without model bindings', function () {
    $user = 'test-user';
    $tweet = 'test-tweet';

    get(route('raw.users.tweets.show', [$user, $tweet]))
        ->assertSuccessful()
        ->assertInertia(function (AssertableInertia $page) use ($user, $tweet) {
            $page->component('Users/Show')
                ->where('modal.baseURL', route('raw.users.show', $user))
                ->where('modal.component', 'Tweets/Show')
                ->where('modal.props.user', $user)
                ->where('modal.props.tweet', $tweet);
        });
});

it('preserves background on inertia visits', function () {
    $fromURL = route('home');
    $user = user();
    $tweet = tweet($user);

    from($fromURL)
        ->get(route('users.tweets.show', [$user, $tweet]), [
            Header::INERTIA => true,
            ModalHeader::REDIRECT => $fromURL,
        ])
        ->assertSuccessful()
        ->assertJsonPath('component', 'Home')
        ->assertJsonPath('props.modal.redirectURL', $fromURL)
        ->assertJsonPath('props.modal.baseURL', route('users.show', $user));
});

it('preserves background on non-inertia visits', function () {
    $fromURL = route('home');
    $user = user();
    $tweet = tweet($user);

    from($fromURL)
        ->get(route('users.tweets.show', [$user, $tweet]))
        ->assertSuccessful()
        ->assertInertia(function (AssertableInertia $page) use ($user) {
            $page->component('Users/Show')
                ->where('user.username', $user->username)
                ->where('modal.redirectURL', route('users.show', $user))
                ->where('modal.baseURL', route('users.show', $user));
        });
});

it('preserves query string for parent component', function () {
    $user = user();
    $tweet = tweet($user);

    $fromURL = route('users.show', ['user' => $user, 'page' => 3]);

    from($fromURL)
        ->get(route('users.tweets.show', [$user, $tweet]), [
            Header::INERTIA => true,
            ModalHeader::REDIRECT => $fromURL,
        ])
        ->assertJsonPath('component', 'Users/Show')
        ->assertJsonPath('props.page', '3')
        ->assertJsonPath('props.modal.redirectURL', $fromURL);
});

it('binds route parameters correctly', function () {
    $fromURL = route('home');
    $user = user();
    $otherUser = user();
    $tweet = tweet($user);

    from($fromURL)
        ->get(route('different.users.tweets.show', [$user, $tweet]))
        ->assertSuccessful()
        ->assertInertia(function (AssertableInertia $page) use ($otherUser) {
            $page->component('Users/Show')
                ->where('user.id', $otherUser->id)
                ->where('modal.redirectURL', route('users.show', $otherUser))
                ->where('modal.baseURL', route('users.show', $otherUser));
        });
});

it('executes config middleware', function () {

})->skip();