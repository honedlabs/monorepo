<?php

declare(strict_types=1);

namespace Honed\Table\Pagination;

class LengthAwareData extends SimpleData
{
    /**
     * The total number of records.
     * 
     * @var int
     */
    protected $total;

    /**
     * The index of the first record.
     * 
     * @var int
     */
    protected $from;

    /**
     * The index of the last record.
     * 
     * @var int
     */
    protected $to;

    /**
     * The url of the first page.
     * 
     * @var string
     */
    protected $firstLink;

    /**
     * The url of the last page.
     * 
     * @var string
     */
    protected $lastLink;

    /**
     * The pagination links.
     * 
     * @var array<int, array<string, mixed>>
     */
    protected $links;

    /**
     * Create a new length aware data instance.
     *
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator<int, *> $paginator
     */
    public static function make(mixed $paginator): static
    {
        return parent::make($paginator)
            ->total($paginator->total())
            ->from($paginator->firstItem())
            ->to($paginator->lastItem())
            ->firstLink($paginator->url(1))
            ->lastLink($paginator->url($paginator->lastPage()));
            // ->links($paginator->links());
    }

    /**
     * Set the total number of records.
     *
     * @param  int  $total
     * @return $this
     */
    public function total(int $total): static
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get the total number of records.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * Set the index of the first record.
     *
     * @param  int  $from
     * @return $this
     */
    public function from(int $from): static
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get the index of the first record.
     *
     * @return int
     */
    public function getFrom(): int
    {
        return $this->from;
    }

    /**
     * Set the index of the last record.
     *
     * @param  int  $to
     * @return $this
     */
    public function to(int $to): static
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get the index of the last record.
     *
     * @return int
     */
    public function getTo(): int
    {
        return $this->to;
    }

    /**
     * Set the url of the first page.
     *
     * @param  string  $firstLink
     * @return $this
     */
    public function firstLink(string $firstLink): static
    {
        $this->firstLink = $firstLink;

        return $this;
    }

    /**
     * Get the url of the first page.
     *
     * @return string
     */
    public function getFirstLink(): string
    {
        return $this->firstLink;
    }
    
    /**
     * Set the url of the last page.
     *
     * @param  string  $lastLink
     * @return $this
     */
    public function lastLink(string $lastLink): static
    {
        $this->lastLink = $lastLink;

        return $this;
    }

    /**
     * Get the url of the last page.
     *
     * @return string
     */
    public function getLastLink(): string
    {
        return $this->lastLink;
    }
}