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
            $this->invalid($field, 'delete');
        }

        if ($field) {
            $name ??= $this->getName($request, $field);
        }

        $this->destroy($table, $scope, $name);
    }

    /**
     * Delete a view.
     *
     * @param \Honed\Table\Table $table
     * @param mixed $scope
     * @param string $name
     * @return void
     */
    protected function destroy(Table $table, mixed $scope, string $name): void
    {
        Views::for($scope)->delete($table, $name);
    }
}
