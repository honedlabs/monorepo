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
        $replacements = $this->replacements();
        $files = (\str_starts_with(\strtoupper(PHP_OS), 'WIN') ? $this->replaceForWindows($directory, $replacements) : $this->replaceForAllOtherOSes($directory, $replacements));

        foreach($files as $file) {
            $this->replaceInFile($file, $this->replacements());
        }

        // Then handle file renames
        $files = (\str_starts_with(\strtoupper(PHP_OS), 'WIN') ? $this->replaceNamesForWindows($directory, $this->fileNames()) : $this->replaceNamesForAllOtherOSes($directory, $this->fileNames()));
        
        foreach($files as $file) {
            $this->renameFile($file);
        }

        return true;
    }

    protected function replaceNamesForWindows(string $directory, array $replacements): array
    {
        // Get all files recursively
        $command = sprintf(
            'dir /S /B "%s" | findstr /v /i .git\ | findstr /v /i vendor | findstr /v /i %s',
            $directory,
            basename(__FILE__)
        );
        
        $files = preg_split('/\\r\\n|\\r|\\n/', $this->run($command));
        
        // Filter files whose names contain any of the replacement keys
        return array_filter($files, function($file) use ($replacements) {
            $filename = basename($file);
            foreach (array_keys($replacements) as $search) {
                if (stripos($filename, $search) !== false) {
                    return true;
                }
            }
            return false;
        });
    }

    protected function replaceNamesForAllOtherOSes(string $directory, array $replacements): array
    {
        // Get all files recursively, excluding .git and vendor
        $command = sprintf(
            'find "%s" -type f ! -path "*/\.git/*" ! -path "*/vendor/*" ! -name "%s"',
            $directory,
            basename(__FILE__)
        );
        
        $files = explode(PHP_EOL, $this->run($command));
        
        // Filter files whose names contain any of the replacement keys
        return array_filter($files, function($file) use ($replacements) {
            $filename = basename($file);
            foreach (array_keys($replacements) as $search) {
                if (stripos($filename, $search) !== false) {
                    return true;
                }
            }
            return false;
        });
    }

    protected function renameFile(string $file): void
    {
        rename($file, $this->getNewFilename($file));
    }

    protected function getNewFilename(string $file): string
    {
        return str_replace(
            \array_keys($this->fileNames()),
            \array_values($this->fileNames()),
            $file
        );
    }
    /**
     * Replace the placeholders in the file with the actual values.
     * @param string $file
     * @param array<string,string> $replacements
     * @return void
     */
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

    /**
     * Hash the directory contents to determine if it has changed as a checksum.
     * 
     * @param string $directory
     * @return string
     */
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

    /**
     * Separate the paths based on the OS.
     * 
     * @param string $path
     * @return string
     */
    protected function separatePath(string $path): string
    {
        return \str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    /**
     * Execute a command and return the output via the shell.
     * 
     * @param string $command
     * @return string
     */
    protected function run(string $command): string
    {
        return \trim((string) \shell_exec($command));
    }

    /**
     * Select the files which need to have replacements made using Windows command. Only the replacement keys will be used, not their mapping value.
     * 
     * @param string $directory
     * @param array<string,string> $replacements
     * @return array<int,string>
     */
    protected function replaceForWindows(string $directory, array $replacements): array
    {
        $command = sprintf(
            'dir /S /B "%s" | findstr /v /i .git\ | findstr /v /i vendor | findstr /v /i %s | findstr /r /i /M /F:/ "%s"',
            $directory,
            basename(__FILE__),
            implode(' ', \array_keys($replacements))
        );
        
        return preg_split('/\\r\\n|\\r|\\n/', $this->run($command));
    }

    /**
     * Select the files which need to have replacements made. Only the replacement keys will be used, not their mapping value.
     * 
     * @param string $directory
     * @param array<string,string> $replacements
     * @return array<int,string>
     */
    protected function replaceForAllOtherOSes(string $directory, array $replacements): array
    {
        $command = sprintf(
            'grep -E -r -l -i "%s" --exclude-dir=vendor "%s" | grep -v %s',
            \implode('|', \array_keys($replacements)),
            $directory,
            basename(__FILE__)
        );

        return explode(PHP_EOL, $this->run($command));
    }


    /**
     * The available package types which can be created.
     * 
     * @return array<string,string>
     */
    protected function packageTypes(): array
    {
        return [
            'laravel' => 'Laravel',
            'vue' => 'Vue',
            'typescript' => 'Typescript',
        ];
    }

    /**
     * The directory where the package will be created.
     * 
     * @param string $type
     * @return string
     */
    protected function packageDirectory(string $type): string
    {
        return __DIR__ . sprintf('/../packages/%s/%s', $type, $this->slug);
    }

    /**
     * Complete match for each type to the location of the project stub
     * 
     * @param string $type
     * @return string
     */
    protected function stubPath(string $type): string
    {
        return match($type) {
            // Any special cases
            default => __DIR__ . sprintf('/../stubs/%s', $type),
        };
    }

    /**
     * The list of placeholder values used in the stubs, to be replaced.
     * 
     * @return array<string,string>
     */
    protected function replacements(): array
    {
        return [
            ':author_name' => self::AuthorName,
            ':author_email' => self::AuthorEmail,
            ':author_homepage' => self::AuthorHomepage,
            ':vendor_slug' => self::VendorSlug,
            ':package_slug' => $this->slug,
            ':package_description' => $this->description,
            'VendorName' => self::VendorName,
            'PackageName' => $this->name,
            ':github_organisation' => self::GithubOrganisation,
        ];
    }

    /**
     * The list of placeholder values which may be used in file names, to be replaced.
     * 
     * @return array<string,string>
     */
    protected function fileNames(): array
    {
        return [
            'PackageName' => $this->name,
            'VendorName' => self::VendorName,
            'vendor_slug' => self::VendorSlug,
            'package_slug' => $this->slug,
        ];
    }
}
