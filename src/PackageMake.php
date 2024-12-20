<?php

namespace Honed\Honed;

use function Laravel\Prompts\{error, info, text, multiselect, outro, pause, spin, table};

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

    /**
     * Create a package based on prompted arguments.
     */
    public function handle()
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

        $this->slug = \strtolower(\trim(\preg_replace('/[^A-Za-z0-9-]+/', '-', $this->name), '-'));

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


        table(['Item', 'Value'], [
            [
                'Vendor', self::VendorName,
            ],
            [
                'Package name', $this->name,
            ],
            [
                'Package slug', $this->slug,
            ],
            [
                'Description', $this->description ?? '-',
            ],
            [
                'Types', \implode(', ', \array_map(fn($type) => $this->packageTypes()[$type], $this->types)),
            ],
            [
                'Author', self::AuthorName,
            ],
            [
                'Author email', self::AuthorEmail,
            ],
            [
                'Author homepage', self::AuthorHomepage,
            ],
            [
                'Github organisation', self::GithubOrganisation,
            ],
        ]);

        pause('Press enter to continue if this is correct...');

        spin(function() {
            foreach($this->types as $type) {
                $this->buildPackage($type);
            }
        }, 'Creating packages...');

        outro(\sprintf('Successfully created [%d] package(s) for [%s].', \count($this->types), $this->slug));
        exit(0);
    }

    protected function buildPackage(string $type): void
    {
        $path = $this->stubPath($type);
        $directory = $this->packageDirectory($type);

        // Check if there is already a package, in which we exit and prevent overwriting
        if(\is_dir($directory)) {
            error(\sprintf("There already exists a [%s] package for [%s].", $type, $this->slug));
            exit(1);
        }

        // Copy the boilerplate to the location
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
        $files = (\str_starts_with(\strtoupper(PHP_OS), 'WIN') ? $this->replaceForWindows() : $this->replaceForAllOtherOSes());

        foreach($files as $file) {
            $this->replaceInFile($file, [
                'author_name' => self::AuthorName,
                'author_email' => self::AuthorEmail,
                'author_homepage' => self::AuthorHomepage,
                'vendor' => self::VendorName,
                'vendor_slug' => self::VendorSlug,
                'package' => $this->name,
                'package_slug' => $this->slug,
                ''
            ]);
        }

        return true;
    }

    protected function replaceInFile(string $file, array $replacements): void
    {
        $contents = \file_get_contents($file);

        \file_put_contents(
            $file,
            \str_replace(
                \array_keys($replacements),
                \array_values($replacements),
                $contents
            )
        );
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
                else { $files[] = \md5_file($directory . '/' . $file); }
            }
        }

        $dir->close();

        return \md5(\implode('', $files));
    }

    protected function separatePath(string $path): string
    {
        return \str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    protected function run(string $command): string
    {
        return \trim((string) \shell_exec($command));
    }

    protected function replaceForWindows(): array
    {
        return \preg_split('/\\r\\n|\\r|\\n/', $this->run('dir /S /B * | findstr /v /i .git\ | findstr /v /i vendor | findstr /v /i '.basename(__FILE__).' | findstr /r /i /M /F:/ ":author :vendor :package VendorName skeleton migration_table_name vendor_name vendor_slug author@domain.com"'));
    }

    protected function replaceForAllOtherOSes(): array
    {
        return \explode(PHP_EOL, $this->run('grep -E -r -l -i ":author|:vendor|:package|VendorName|skeleton|migration_table_name|vendor_name|vendor_slug|author@domain.com" --exclude-dir=vendor ./* ./.github/* | grep -v '.basename(__FILE__)));
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
