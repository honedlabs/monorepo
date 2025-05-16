export type Pagination = 'length-aware' | 'cursor' | 'simple'

export interface PaginatorLink {
    url: string | null | undefined;
    label: string;
    active: boolean;
}

export interface PaginatorMeta {
    current_page: number;
    from: number;
    last_page: number;
    links: PaginatorLink[];
    path: string;
    per_page: number;
    to: number;
    total: number;
}

export interface CursorPaginatorMeta {
    path: string;
    per_page: number;
    next_cursor: string | null;
    prev_cursor: string | null;
}

export interface PaginatorLinks<T extends Pagination = 'length-aware'> {
    first: T extends 'cursor' ? null : string;
    last: T extends 'cursor' ? null : string;
    prev: T extends 'cursor' ? null : string;
    next: T extends 'cursor' ? null : string;
}

declare global {
    export interface PaginatorResponse<T> {
        data: T[];
        meta: PaginatorMeta;
        links: PaginatorLinks;
    }

    export type LengthAwarePaginatorResponse<T> = PaginatorResponse<T>;

    export interface Paginator<T> extends PaginatorMeta {
        data: T[];
        first_page_url: string;
        last_page_url: string;
        links: PaginatorLink[];
        next_page_url: string | null;
        prev_page_url: string | null;
    }

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