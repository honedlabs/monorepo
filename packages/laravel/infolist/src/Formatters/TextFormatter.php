<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use Honed\Infolist\Contracts\Formatter;
use Illuminate\Support\Str;

/**
 * @implements Formatter<mixed, string|array<int, string>>
 */
class TextFormatter implements Formatter
{
    /**
     * The limit of the characters to display.
     *
     * @var int|null
     */
    protected $limit;

    /**
     * The limit of the words to display.
     *
     * @var int|null
     */
    protected $words;

    /**
     * The prefix to display before the text.
     *
     * @var string|null
     */
    protected $prefix;

    /**
     * The suffix to display after the text.
     *
     * @var string|null
     */
    protected $suffix;

    /**
     * The separator to be used to separate the text.
     *
     * @var string|null
     */
    protected $separator;

    /**
     * Set the limit of the text to display.
     *
     * @return $this
     */
    public function limit(int $value): static
    {
        $this->limit = $value;

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
    public function words(int $value): static
    {
        $this->words = $value;

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
    public function prefix(string $value): static
    {
        $this->prefix = $value;

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
    public function suffix(string $value): static
    {
        $this->suffix = $value;

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
    public function separator(string $value): static
    {
        $this->separator = $value;

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
     * @return array<int, string>|string|null
     */
    public function format(mixed $value): mixed
    {
        if (is_numeric($value)) {
            $value = (string) $value;
        }

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
    protected function formatSeparator(string $value): string|array
    {
        $separator = $this->getSeparator();

        return $separator ? explode($separator, $value) : $value;
    }
}
