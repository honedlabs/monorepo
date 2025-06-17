<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

use Illuminate\Support\Str;

trait CanBeText
{
    public const TEXT = 'text';

    /**
     * The limit of the characters to display.
     */
    protected ?int $limit = null;

    /**
     * The limit of the words to display.
     */
    protected ?int $words = null;

    /**
     * The prefix to display before the text.
     */
    protected ?string $prefix = null;

    /**
     * The suffix to display after the text.
     */
    protected ?string $suffix = null;

    /**
     * The separator to be used to separate the text.
     */
    protected ?string $separator = null;

    /**
     * Set the limit of the text to display.
     *
     * @return $this
     */
    public function limit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get the limit of the text to display.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Set the limit of the words to display.
     *
     * @return $this
     */
    public function words(int $words): static
    {
        $this->words = $words;

        return $this;
    }

    /**
     * Get the limit of the words to display.
     */
    public function getWords(): ?int
    {
        return $this->words;
    }

    /**
     * Set the prefix to display before the text.
     *
     * @return $this
     */
    public function prefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the prefix to display before the text.
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    /**
     * Set the suffix to display after the text.
     *
     * @return $this
     */
    public function suffix(string $suffix): static
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Get the suffix to display after the text.
     */
    public function getSuffix(): ?string
    {
        return $this->suffix;
    }

    /**
     * Set the separator to be used to separate the text.
     *
     * @return $this
     */
    public function separator(string $separator): static
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * Get the separator to be used to separate the text.
     */
    public function getSeparator(): ?string
    {
        return $this->separator;
    }

    /**
     * Format the value as text.
     *
     * @return string|array<int, string>|null
     */
    protected function formatText(mixed $value): string|array|null
    {
        if (! is_string($value)) {
            return null;
        }

        $pipes = [
            'formatLimit',
            'formatWords',
            'formatPrefix',
            'formatSuffix',
            'formatSeparator',
        ];

        return array_reduce(
            $pipes,
            fn ($value, $pipe) => $this->{$pipe}($value),
            $value
        );
    }

    /**
     * Format the value as text with a limit.
     */
    protected function formatLimit(string $value): string
    {
        $limit = $this->getLimit();

        return $limit ? Str::limit($value, $limit) : $value;
    }

    /**
     * Format the value as text with a words limit.
     */
    protected function formatWords(string $value): string
    {
        $words = $this->getWords();

        return $words ? Str::words($value, $words) : $value;
    }

    /**
     * Format the value as text with a prefix.
     */
    protected function formatPrefix(string $value): string
    {
        $prefix = $this->getPrefix();

        return $prefix ? $prefix.$value : $value;
    }

    /**
     * Format the value as text with a suffix.
     */
    protected function formatSuffix(string $value): string
    {
        $suffix = $this->getSuffix();

        return $suffix ? $value.$suffix : $value;
    }

    /**
     * Format the value as text with a separator.
     *
     * @return string|array<int, string>
     */
    protected function formatSeparator(string $value): array|string
    {
        $separator = $this->getSeparator();

        return $separator ? explode($separator, $value) : $value;
    }
}
