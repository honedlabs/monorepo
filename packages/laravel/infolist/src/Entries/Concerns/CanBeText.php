<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

use Illuminate\Support\Str;

trait CanBeText
{
    public const TEXT = 'text';

    /**
     * The limit of the characters to display.
     *
     * @var int|null
     */
    protected $limit = null;

    /**
     * The limit of the words to display.
     *
     * @var int|null
     */
    protected $words = null;

    /**
     * The prefix to display before the text.
     *
     * @var string|null
     */
    protected $prefix = null;

    /**
     * The suffix to display after the text.
     *
     * @var string|null
     */
    protected $suffix = null;

    /**
     * The separator to be used to separate the text.
     *
     * @var string|null
     */
    protected $separator = null;

    /**
     * Set the limit of the text to display.
     *
     * @param  int  $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get the limit of the text to display.
     *
     * @return int|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set the limit of the words to display.
     *
     * @param  int  $words
     * @return $this
     */
    public function words($words)
    {
        $this->words = $words;

        return $this;
    }

    /**
     * Get the limit of the words to display.
     *
     * @return int|null
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * Set the prefix to display before the text.
     *
     * @param  string  $prefix
     * @return $this
     */
    public function prefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the prefix to display before the text.
     *
     * @return string|null
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the suffix to display after the text.
     *
     * @param  string  $suffix
     * @return $this
     */
    public function suffix($suffix)
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Get the suffix to display after the text.
     *
     * @return string|null
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Set the separator to be used to separate the text.
     *
     * @param  string  $separator
     * @return $this
     */
    public function separator($separator)
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * Get the separator to be used to separate the text.
     *
     * @return string|null
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * Format the value as text.
     *
     * @param  mixed  $value
     * @return string|array<int, string>|null
     */
    protected function formatText($value)
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
     *
     * @param  string  $value
     * @return string
     */
    protected function formatLimit($value)
    {
        $limit = $this->getLimit();

        return $limit ? Str::limit($value, $limit) : $value;
    }

    /**
     * Format the value as text with a words limit.
     *
     * @param  string  $value
     * @return string
     */
    protected function formatWords($value)
    {
        $words = $this->getWords();

        return $words ? Str::words($value, $words) : $value;
    }

    /**
     * Format the value as text with a prefix.
     *
     * @param  string  $value
     * @return string
     */
    protected function formatPrefix($value)
    {
        $prefix = $this->getPrefix();

        return $prefix ? $prefix.$value : $value;
    }

    /**
     * Format the value as text with a suffix.
     *
     * @param  string  $value
     * @return string
     */
    protected function formatSuffix($value)
    {
        $suffix = $this->getSuffix();

        return $suffix ? $value.$suffix : $value;
    }

    /**
     * Format the value as text with a separator.
     *
     * @param  string  $value
     * @return string|array<int, string>
     */
    protected function formatSeparator($value)
    {
        $separator = $this->getSeparator();

        return $separator ? explode($separator, $value) : $value;
    }
}
