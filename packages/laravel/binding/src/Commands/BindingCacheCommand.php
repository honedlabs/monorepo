<?php

declare(strict_types=1);

namespace Honed\Binding\Commands;

use Honed\Binding\BindingServiceProvider;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'binding:cache')]
class BindingCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'binding:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Discover and cache the available route model binding methods for the application.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->callSilent('binding:clear');

        $this->components->info('Caching bindings...');

        $bindings = $this->getBindings();

        $progress = $this->output->createProgressBar(count($bindings));

        $content = [];

        foreach ($bindings as $binding) {
            $content[$binding->getModel()] = $binding->getBindings();

            $progress->advance();
        }

        file_put_contents(
            $this->laravel->getCachedBindingsPath(),
            '<?php return '.var_export($content, true).';'
        );

        $progress->finish();

        $this->components->success('Cached '.count($content).' bindings.');

        if ($this->option('show')) {
            // $this->table(['Class', 'Binding'], $this->getBindings());
        }

        $this->components->info('Bindings cached successfully.');
    }

    /**
     * Get the bindings that should be cached.
     *
     * @return array
     */
    /**
     * Get all of the events and listeners configured for the application.
     *
     * @return array
     */
    protected function getBindings()
    {
        $bindings = [];

        foreach ($this->laravel->getProviders(BindingServiceProvider::class) as $provider) {
            $providerBindings = array_merge_recursive($provider->shouldDiscoverBindings() ? $provider->discoverBindings() : [], $provider->bindings());

            $bindings[get_class($provider)] = $providerBindings;
        }

        return $bindings;
    }
}
