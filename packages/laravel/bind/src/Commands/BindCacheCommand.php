<?php

declare(strict_types=1);

namespace Honed\Bind\Commands;

use Honed\Bind\BindServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
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

        $bindings = $this->getBindings();

        $progress = $this->output->createProgressBar(count($bindings, COUNT_RECURSIVE));

        /** @var array<class-string<\Illuminate\Database\Eloquent\Model>, array<string, class-string<\Honed\Bind\Binder>>> */
        $content = [];

        foreach ($bindings as $binding) {
            $this->retrieveBindings($binding, $content);
            $progress->advance();
        }

        file_put_contents(
            $this->laravel->getCachedBindersPath(),
            '<?php return '.var_export($content, true).';'
        );

        $progress->finish();

        $this->line(PHP_EOL);

        $this->components->success('Cached bindings for '.count($content).' model(s).');

        if ($this->option('table')) {
            $this->createTable($content);
        }

        $this->components->info('Bindings cached successfully.');
    }

    /**
     * Get all of the events and listeners configured for the application.
     *
     * @return array<int, class-string<\Honed\Bind\Binder>>
     */
    protected function getBindings()
    {
        $bindings = [];

        foreach ($this->laravel->getProviders(BindServiceProvider::class) as $provider) {
            $bindings = \array_merge($bindings, $provider->registeredBinders());
        }

        return $bindings;
    }

    /**
     * Retrieve the bindings for the given binder, and push them to the array.
     *
     * @param  class-string<\Honed\Bind\Binder>  $binder
     * @param  array<class-string<\Illuminate\Database\Eloquent\Model>, array<string, class-string<\Honed\Bind\Binder>>>  $content
     * @return void
     */
    protected function retrieveBindings($binder, &$content)
    {
        /** @var \Honed\Bind\Binder $binder */
        $binder = App::make($binder);

        $binds = array_fill_keys($binder->bindings(), get_class($binder));

        $model = $binder->modelName();

        $content[$model] = array_merge($content[$model] ?? [], $binds);
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
