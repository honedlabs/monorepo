export type Pagination = 'length-aware' | 'cursor' | 'simple'

interface BasePaginator<T> {
    data: T[];
    next_page_url: string | null;
    prev_page_url: string | null;
}

export interface PaginatorLink {
    url: string | null | undefined;
    label: string;
    active: boolean;
}

export interface SimplePaginatorMeta {
    current_page: number;
    from: number;
    path: string;
    per_page: number;
    to: number;
}

export interface CursorPaginatorMeta {
    path: string;
    per_page: number;
    next_cursor: string | null;
    prev_cursor: string | null;
}

export interface PaginatorMeta extends SimplePaginatorMeta {
    last_page: number;
    links: PaginatorLink[];
    total: number;
}

declare global {
    interface SimplePaginatorResource<T = Record<string, any>> {
        data: T[];
        links: {
            first: string | null;
            next: string | null;
            prev: string | null;
        };
        meta: {
            current_page: number;
            from: number;
            path: string;
            per_page: number;
            to: number;
        };
    }

    interface SimplePaginator<T = Record<string, any>> extends BasePaginator<T>, SimplePaginatorMeta {
        first_page_url: string;
    }

    interface CursorPaginatorResource<T = Record<string, any>> {
        data: T[];
        links: {
            prev: string | null;
            next: string | null;
        };
        meta: CursorPaginatorMeta;
    }

    interface CursorPaginator<T = Record<string, any>> extends BasePaginator<T>, CursorPaginatorMeta { }

    interface PaginatorResource<T = Record<string, any>> {
        data: T[];
        meta: PaginatorMeta;
        links: {
            first: string;
            last: string;
            prev: string | null;
            next: string | null;
        };
    }

    interface Paginator<T = Record<string, any>> extends BasePaginator<T>, PaginatorMeta {
        first_page_url: string;
        last_page_url: string;
        links: PaginatorLink[];
    }

    type LengthAwarePaginatorResource<T = Record<string, any>> = PaginatorResource<T>;

    type LengthAwarePaginator<T = Record<string, any>> = Paginator<T>;
}