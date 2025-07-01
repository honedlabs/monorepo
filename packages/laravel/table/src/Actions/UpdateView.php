<?php

declare(strict_types=1);

namespace Honed\Table\Actions;

use Honed\Action\Contracts\Action;
use Honed\Table\Facades\Views;
use Honed\Table\Table;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateView extends ViewAction
{
    /**
     * Update, or create, a view.
     *
     * @return object
     */
    public function handle(
        Table $table,
        Request $request,
        ?string $name = null,
        mixed $scope = null,
        ?string $field = null
    ): void {
        if ($table->isNotViewable()) {
            $this->fail($field, 'We were unable to update the view.');
        }

        if ($field) {
            $name ??= $this->getName($request, $field);
        }

        $view = $this->state($table, $request);

        $this->update($table, $scope, $name, $view);
    }

    /**
     * Update a view.
     *
     * @param \Honed\Table\Table $table
     * @param mixed $scope
     * @param string $name
     * @param array<string, mixed> $view
     * @return void
     */
    protected function update(Table $table, mixed $scope, string $name, array $view): void
    {
        Views::for($scope)->set($table, $name, $view);
    }
}
