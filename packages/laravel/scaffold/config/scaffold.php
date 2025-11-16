<?php

declare(strict_types=1);

return [
    'context' => Honed\Scaffold\Support\ScaffoldContext::class,

    'indentations' => 4,

    'scaffolders' => [
        Honed\Scaffold\Scaffolders\PropertyScaffolder::class,
        Honed\Scaffold\Scaffolders\InterfaceScaffolder::class,
        Honed\Scaffold\Scaffolders\TraitScaffolder::class,
        Honed\Scaffold\Scaffolders\MigrationScaffolder::class,
        Honed\Scaffold\Scaffolders\FactoryScaffolder::class,
        Honed\Scaffold\Scaffolders\SeederScaffolder::class,
        Honed\Scaffold\Scaffolders\PolicyScaffolder::class,
        Honed\Scaffold\Scaffolders\BuilderScaffolder::class,
        Honed\Scaffold\Scaffolders\BatchScaffolder::class,
        Honed\Scaffold\Scaffolders\InfolistScaffolder::class,
        Honed\Scaffold\Scaffolders\TableScaffolder::class,
        Honed\Scaffold\Scaffolders\FormScaffolder::class,
        // Honed\Scaffold\Scaffolders\RequestScaffolder::class,
        Honed\Scaffold\Scaffolders\DataScaffolder::class,
        Honed\Scaffold\Scaffolders\ActionScaffolder::class,
        Honed\Scaffold\Scaffolders\StatsScaffolder::class,
        Honed\Scaffold\Scaffolders\ResponseScaffolder::class,
        Honed\Scaffold\Scaffolders\ChartScaffolder::class,
        Honed\Scaffold\Scaffolders\ControllerScaffolder::class,
        Honed\Scaffold\Scaffolders\PageScaffolder::class,
        Honed\Scaffold\Scaffolders\ModalScaffolder::class,
    ],

    'interfaces' => [
        Honed\Core\Contracts\HasIcon::class,
        Honed\Core\Contracts\HasLabel::class,
        Honed\Form\Contracts\CanBeSearched::class,
        // Honed\Memo\Contracts\Cacheable::class,
    ],

    'traits' => [
        Spatie\LaravelData\WithData::class,
        Honed\Form\Concerns\CanBeSearched::class,
        // Honed\Memo\Concerns\Cacheable::class,
    ],
];
