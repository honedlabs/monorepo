<?php

namespace Honed\List\Entries\Concerns;

trait CanBeText
{
    /**
     * The limit of the characters to display.
     * 
     * @var int|null
     */
    protected ?int $limit;

    /**
     * The limit of the words to display.
     * 
     * @var int|null
     */
    protected ?int $words;

    /**
     * The prefix to display before the text.
     * 
     * @var string|null
     */
    protected ?string $prefix;

    /**
     * The suffix to display after the text.
     * 
     * @var string|null
     */
    protected ?string $suffix;
    
    /**
     * The separator to be used to separate the text.
     * 
     * @var string|null
     */
    protected ?string $separator;   

    /**
     * Set the limit of the text to display.
     * 
     * @param  int  $limit
     * @return $this
     */
    public function limit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get the limit of the text to display.
     * 
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Determine if a limit is set.
     * 
     * @return bool
     */
    public function hasLimit(): bool
    {
        return isset($this->limit);
    }

    /**
     * Set the limit of the words to display.
     * 
     * @param  int  $words
     * @return $this
     */
    public function words(int $words): static
    {
        $this->words = $words;

        return $this;
    }

    /**
     * Get the limit of the words to display.
     * 
     * @return int|null
     */
    public function getWords(): ?int
    {
        return $this->words;
    }

    /**
     * Determine if a words limit is set.
     * 
     * @return bool
     */
    public function hasWords(): bool
    {
        return isset($this->words);
    }

    /**
     * Set the prefix to display before the text.
     * 
     * @param  string  $prefix
     * @return $this
     */
    public function prefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the prefix to display before the text.
     * 
     * @return string|null
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    /**
     * Determine if a prefix is set.
     * 
     * @return bool
     */
    public function hasPrefix(): bool
    {
        return isset($this->prefix);
    }

    /**
     * Set the suffix to display after the text.
     * 
     * @param  string  $suffix
     * @return $this
     */
    public function suffix(string $suffix): static
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Get the suffix to display after the text.
     * 
     * @return string|null
     */
    public function getSuffix(): ?string
    {
        return $this->suffix;
    }

    /**
     * Determine if a suffix is set.
     * 
     * @return bool
     */
    public function hasSuffix(): bool
    {
        return isset($this->suffix);
    }

    /**
     * Set the separator to be used to separate the text.
     * 
     * @param  string  $separator
     * @return $this
     */
    public function separator(string $separator): static
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * Get the separator to be used to separate the text.
     * 
     * @return string|null
     */
    public function getSeparator(): ?string
    {
        return $this->separator;
    }

    /**
     * Determine if a separator is set.
     * 
     * @return bool
     */
    public function hasSeparator(): bool
    {
        return isset($this->separator);
    }
}