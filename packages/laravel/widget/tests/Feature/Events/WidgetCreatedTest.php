<?php

declare(strict_types=1);

use App\Widgets\UserCountWidget;
use Honed\Widget\Events\WidgetCreated;
use Honed\Widget\Facades\Widgets;
use Illuminate\Support\Facades\Event;
use App\Models\User;

beforeEach(function () {
    Event::fake();

    $this->widget = Widgets::serializeWidget(new UserCountWidget());

    $this->scope = Widgets::serializeScope(User::factory()->create());
});

afterEach(function () {
    Event::assertDispatched(WidgetCreated::class, function (WidgetCreated $event) {
        return true;
    });
});

it('dispatches event', function () {
    WidgetCreated::dispatch(
        $this->widget, $this->scope
    );
});

// it('dispatch event when creating view', function () {

//     Views::create(
//         $this->table, $this->name, $this->scope, $this->view
//     );
// });