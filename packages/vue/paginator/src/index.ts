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
    export interface SimplePaginatorResource<T> {
        data: T[];
        links: {
            first: string | null;
            next: string | null;
        };
        meta: {
            current_page: number;
            from: number;
            path: string;
            per_page: number;
            to: number;
        };
    }

    export interface SimplePaginator<T> extends BasePaginator<T>, SimplePaginatorMeta {
        first_page_url: string;
    }

    export interface CursorPaginatorResource<T> {
        data: T[];
        links: {
            prev: string | null;
            next: string | null;
        };
        meta: CursorPaginatorMeta;
    }

    export interface CursorPaginator<T> extends BasePaginator<T>, CursorPaginatorMeta { }

    export interface PaginatorResource<T> {
        data: T[];
        meta: PaginatorMeta;
        links: {
            first: string;
            last: string;
            prev: string | null;
            next: string | null;
        };
    }

    export interface Paginator<T> extends BasePaginator<T>, PaginatorMeta {
        first_page_url: string;
        last_page_url: string;
        links: PaginatorLink[];
    }

    export type LengthAwarePaginatorResource<T> = PaginatorResource<T>;

    export type LengthAwarePaginator<T> = Paginator<T>;
}

export interface PaginatorItem {
    url: string | null | undefined;
    label: string;
    isPage: boolean;
    isActive: boolean;
    isPrevious: boolean;
    isNext: boolean;
    isCurrent: boolean;
    isSeparator: boolean;
}

export const usePaginator = <T>(data: Paginator<T> | PaginatorMeta) => {
    const meta = (data as Paginator<T>).meta ?? (data as PaginatorMeta);
    
    const links = (meta.links ?? data.links!).map((link) => {
        return {
            ...link,
            url: link.url ? decodeURIComponent(link.url!) : null,
        };
    });
    
    const items = links.map((link, index) => {
        return {
            url: link.url,
            label: link.label,
            isPage: !isNaN(+link.label),
            isPrevious: index === 0,
            isNext: index === links.length - 1,
            isCurrent: link.active,
            isSeparator: link.label == "...",
            isActive: !!link.url && !link.active,
        };
    }) as PaginatorItem[];
    
    const pages: PaginatorItem[] = items.filter(
        (item) => item.isPage || item.isSeparator
    );
    
    const current = items.find((item) => item.isCurrent);
    const previous = items.find((item) => item.isPrevious)!;
    const next = items.find((item) => item.isNext)!;
    
    const first = {
        ...items[1],
        isActive: items[1].url !== current?.url,
        label: "&laquo;",
    };
    
    const last = {
        ...items[items.length - 1],
        isActive: items[items.length - 1].url !== current?.url,
        label: "&raquo;",
    };
    
    const from = meta.from;
    const to = meta.to;
    const total = meta.total;
    const itemsPerPage = meta.per_page;
    
    return {
        pages,
        items,
        previous,
        next,
        first,
        last,
        total,
        from,
        to,
        itemsPerPage,
    };
};