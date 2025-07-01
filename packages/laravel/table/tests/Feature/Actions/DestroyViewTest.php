<?php

declare(strict_types=1);

use Honed\Table\Actions\DestroyView;
use Honed\Table\Facades\Views;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Workbench\App\Tables\ProductTable;
use Workbench\App\Tables\UserTable;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;

beforeEach(function () {
    $this->action = new DestroyView();

    $this->table = ProductTable::make();

    $query = $this->table->getSearchKey().'=term';

    $this->name = 'View';

    $this->request = Request::create('/?'.$query, Request::METHOD_GET, [
        DestroyView::FIELD => $this->name,
    ]);
});

it('throws exception when the table is not viewable', function () {
    $table = UserTable::make();

    $this->action->handle($table, $this->request);
})->throws(ValidationException::class);

it('destroys a view', function () {
    Views::for()->create(
        $this->table, $this->name, []
    );

    assertDatabaseCount(config('table.views.table'), 1);

    $this->action->handle($this->table, $this->request);

    assertDatabaseEmpty(config('table.views.table'));
});

