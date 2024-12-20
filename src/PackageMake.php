<?php

namespace Honed\Honed;

use function Laravel\Prompts\{error, info, text, multiselect, outro};


class PackageMake
{
    public const GithubOrganisation = 'honedlabs';
    
    public const VendorName = 'Honed';
    public const VendorSlug = 'honed';

    public const AuthorUsername = 'jdw5';
    public const AuthorEmail = 'josh@joshua-wallace.com';
    public const AuthorName = 'Joshua Wallace';
    public const AuthorHomepage = 'https://joshua-wallace.com';
    
    /**
     * @var non-empty-array<int,string>
     */
    protected $types;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array<int,string>
     */
    protected $npmPackages;

    public function run()
    {
        $this->types = multiselect(
            label: 'What type of package(s) are you making?',
            options: $this->packageTypes(),
            default: ['laravel'],
            hint: 'You can select multiple types.',
            required: true
        );

        $this->name = text(
            label: 'What is the name of the package?',
            placeholder: 'Example',
            required: true,
            hint: 'It should be uppercase form, not slugified.'
        );

        $this->slug = \strtolower(\str_replace(' ', '-', $this->name));

        $this->description = text(
            label: 'Enter a description for the package.',
            placeholder: 'Create server-driven...',
            required: false,
        );

        // $this->npmPackages = match (\in_array(['vue', 'typescript'], $this->types)) {
        //     true => multiselect(
        //         label: 'Select the npm packages you want to install.',
        //         options: $this->npmPackages(),
        //         default: ['vue', '@inertiajs/vue3', 'axios'],
        //         hint: 'You can select multiple packages.',
        //         required: true,
        //     ),
        //     false => [],
        // };

        foreach($this->types as $type) {
            $this->buildPackage($type);
        }

        outro(\sprintf('Successfully created [%d] package(s) for [%s].', \count($this->types), $this->slug));
        exit(0);
    }

    protected function buildPackage(string $type): void
    {
        $path = $this->stubPath($type);
        $directory = $this->packageDirectory($type);

        // Check if there is a directory there
        if(\is_dir($directory)) {
            error(\sprintf("There already exists a [%s] package for [%s].", $type, $this->slug));
            exit(1);
        }

        $result = $this->copyDir($path, $directory);

        if (! $result) {
            error(\sprintf("Failed to copy [%s] to [%s].", $path, $directory));
            exit(1);
        }

        if (! $this->replaceInDirectory($directory)) {
            error(\sprintf("Failed to execute replacements in [%s] for [%s].", $directory, $this->slug));
            exit(1);
        }

        info(\sprintf("Successfully created [%s] package for [%s].", $type, $this->slug));
    }

    protected function copyDir(string $source, string $destination, int $permissions = 0755): bool
    {
        $hash = $this->hashDirectory($source);

        if (\is_link($source)) {
            return \symlink(\readlink($source), $destination);
        }

        if (\is_file($source)) {
            return \copy($source, $destination);
        }

        if (! \is_dir($destination)) {
            \mkdir($destination, $permissions, true);
        }

        $dir = \dir($source);

        while (false !== ($file = $dir->read())) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            if ($hash != $this->hashDirectory($source . '/' . $file)) {
                $this->copyDir($source . '/' . $file, $destination . '/' . $file, $permissions);
            }
        }

        $dir->close();
        return true;
    }

    protected function replaceInDirectory(string $directory): bool
    {
        // Search the entire directory and perform replacements
        return true;
    }

    protected function hashDirectory(string $directory): string
    {
        if (! \is_dir($directory)) { 
            return false;
        }

        $files = [];
        $dir = \dir($directory);

        while (false !== ($file = $dir->read())){
            if ($file != '.' and $file != '..') {
                if (\is_dir($directory . '/' . $file)) { $files[] = $this->hashDirectory($directory . '/' . $file); }
                else { $files[] = md5_file($directory . '/' . $file); }
            }
        }

        $dir->close();

        return md5(implode('', $files));
    }

    protected function packageTypes(): array
    {
        return [
            'laravel' => 'Laravel',
            'vue' => 'Vue',
            'typescript' => 'Typescript',
        ];
    }

    protected function packageDirectory(string $type): string
    {
        return __DIR__ . '/../packages/' . $type . '/' . $this->slug;
    }

    protected function stubPath(string $type): string
    {
        return match($type) {
            'laravel' => __DIR__ . '/../stubs/laravel',
            'vue' => __DIR__ . '/../stubs/vue',
            'typescript' => __DIR__ . '/../stubs/typescript',
        };
    }
}
