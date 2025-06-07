<?php

declare(strict_types=1);

namespace Honed\Bind\Commands;

use Honed\Bind\RetrieveBinders;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'bind:cache')]
class BindCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bind:cache {--table : Show the model bindings that are being cached}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Discover and cache the available route model binding methods for the application.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->callSilent('bind:clear');

        $this->components->info('Caching bindings...');

        $bindings = RetrieveBinders::binders();

        $progress = $this->output->createProgressBar(count($bindings, COUNT_RECURSIVE));

        $binds = [];

        foreach ($bindings as $binding) {
            RetrieveBinders::bindings($binding, $binds);
            $progress->advance();
        }

        RetrieveBinders::put($binds);

        $progress->finish();

        $this->line(PHP_EOL);

        $this->components->success('Cached bindings for '.count($binds).' model(s).');

        if ($this->option('table')) {
            $this->createTable($binds);
        }

        $this->components->info('Bindings cached successfully.');
    }

    /**
     * Create a table of the cached bindings.
     *
     * @param  array<class-string<\Illuminate\Database\Eloquent\Model>, array<string, class-string<\Honed\Bind\Binder>>>  $content
     * @return void
     */
    protected function createTable($content)
    {
        $headers = ['Model', 'Bindings'];

        $this->table($headers, array_map(function ($model, $binds) {
            return [
                $model,
                implode(', ', array_keys($binds)),
            ];
        }, array_keys($content), array_values($content)));
    }
}
