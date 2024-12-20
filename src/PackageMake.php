<?php

namespace Honed\Honed;

use function Laravel\Prompts\{suggest, text, multiselect};


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

    public function run()
    {
        $this->types = multiselect(
            label: 'What type of package(s) are you making?',
            options: \array_keys($this->packageTypes()),
            default: ['Laravel'],
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

        dd($this->types, $this->name, $this->slug);
    }

    public function packageTypes(): array
    {
        return [
            'Laravel' => 'path',
            'Vue' => 'path',
            'Typescript' => 'path',
        ];
    }
}
