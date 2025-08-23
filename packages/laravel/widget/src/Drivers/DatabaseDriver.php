<?php

declare(strict_types=1);

namespace Honed\Widget\Drivers;

use Honed\Widget\Concerns\InteractsWithDatabase;
use Honed\Widget\Concerns\Resolvable;
use Honed\Widget\Facades\Widgets;
use Honed\Widget\QueryBuilder;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

class DatabaseDriver extends Driver
{
    use InteractsWithDatabase;
    use Resolvable;

    /**
     * The name of the "created at" column.
     *
     * @var string|null
     */
    public const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    public const UPDATED_AT = 'updated_at';

    /**
     * The database connection.
     *
     * @var DatabaseManager
     */
    protected $db;

    /**
     * The user configuration.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Create a new driver instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        Dispatcher $events,
        DatabaseManager $db,
    ) {
        parent::__construct($name, $events);

        $this->db = $db;
    }

    /**
     * {@inheritdoc}
     */
    public function get(mixed $scope): array
    {
        return $this->newQuery()
            ->scope($scope)
            ->get()
            ->all();
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $widget, mixed $scope, mixed $data = null, mixed $position = null): void
    {
        $this->newQuery()
            ->insert($this->fill(compact('widget', 'scope', 'data', 'position')));
    }

    /**
     * {@inheritdoc}
     */
    public function update(string $widget, mixed $scope, mixed $data = null, mixed $position = null): bool
    {
        return (bool) $this->newQuery()
            ->scope($scope)
            ->widget($widget)
            ->update([
                'data' => $data,
                'order' => $position,
                self::UPDATED_AT => Carbon::now(),
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $widget, mixed $scope): bool
    {
        return (bool) $this->newQuery()
            ->scope($scope)
            ->widget($widget)
            ->delete();
    }

    /**
     * Create an array of values to be inserted.
     * 
     * @param array{widget: string, scope: mixed, data: mixed, position: mixed} $values
     * @return array<string, mixed>
     */
    protected function fill(array $values): array
    {
        return [
            'widget' => $this->resolveWidget($values['widget']),
            'scope' => $this->resolveScope($values['scope']),
            'data' => $values['data'],
            'order' => $values['position'],
            self::CREATED_AT => $now = Carbon::now(),
            self::UPDATED_AT => $now,
        ];
    }

    /**
     * Create a new table query.
     */
    protected function newQuery(): QueryBuilder
    {
        return (new QueryBuilder($this->connection()))
            ->from($this->getTableName());
    }

    /**
     * The database connection.
     */
    protected function connection(): Connection
    {
        return $this->db->connection($this->getConnectionName());
    }
}
