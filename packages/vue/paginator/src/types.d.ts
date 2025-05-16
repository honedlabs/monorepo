import type { 
    BasePaginator, 
    BasePaginatorResource,
    BasePaginatorMeta
} from './base';

export type Pagination = 'length-aware' | 'cursor' | 'simple'

export interface PaginatorLink {
    url: string | null | undefined;
    label: string;
    active: boolean;
}

export interface SimplePaginatorMeta extends BasePaginatorMeta {
    current_page: number;
    from: number;
    to: number;
}

export interface CursorPaginatorMeta extends BasePaginatorMeta {
    next_cursor: string | null;
    prev_cursor: string | null;
}

export interface PaginatorMeta extends SimplePaginatorMeta {
    last_page: number;
    links: PaginatorLink[];
    total: number;
}

declare global {
    interface SimplePaginatorResource<T = Record<string, any>> extends BasePaginatorResource<T> {
        links: {
            first: string;
            next: string | null; //
            prev: string | null; //
        };
        meta: SimplePaginatorMeta;
    }

    interface SimplePaginator<T = Record<string, any>> extends BasePaginator<T>, SimplePaginatorMeta {
        first_page_url: string;
    }

    interface CursorPaginatorResource<T = Record<string, any>> extends BasePaginatorResource<T> {
        meta: CursorPaginatorMeta;
    }

    interface CursorPaginator<T = Record<string, any>> extends BasePaginator<T>, CursorPaginatorMeta { }

    interface PaginatorResource<T = Record<string, any>> extends BasePaginatorResource<T> {
        meta: PaginatorMeta;
        links: {
            first: string; //
            last: string;
            prev: string | null; //
            next: string | null; //
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