<?php

declare(strict_types=1);

namespace Honed\Table\Pagination\Concerns;

use Honed\Table\Pagination\Pagination;

trait Paginates
{
    use HasDefaultPerPage;
    use HasPageName;
    use HasPaginator;
    use HasPerPage;
    use HasShowKey;

    public function getPaginationCount(): int|array
    {
        return $this->getPerPage() ?? $this->getDefaultPerPage();
    }

    /**
     * Alias
     */
    public function setPagination(int|array|null $pagination): void
    {
        if (is_null($pagination)) {
            return;
        }
        $this->perPage = $pagination;
    }

    public function getPagination(?int $active = null): array
    {
        if (! is_array($p = $this->getPaginationCount())) {
            return [Pagination::make($p, true)];
        }

        $options = [];

        foreach ($p as $count) {
            $options[] = Pagination::make($count, $count === $active);
        }

        return $options;
    }

    public function usePerPage(): int
    {
        $c = $this->getPaginationCount();
        if (is_int($c)) {
            return $c;
        }
        if (in_array($q = $this->getPerPageFromRequest(), $c)) {
            return $q;
        }

        return $this->getDefaultPerPage();
    }
}
