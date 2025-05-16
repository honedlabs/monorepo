import { computed, reactive } from 'vue';
import { router } from "@inertiajs/vue3";
import type { VisitOptions } from "@inertiajs/core";


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
    export interface SimplePaginatorResource<T = Record<string, any>> {
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

    export interface SimplePaginator<T = Record<string, any>> extends BasePaginator<T>, SimplePaginatorMeta {
        first_page_url: string;
    }

    export interface CursorPaginatorResource<T = Record<string, any>> {
        data: T[];
        links: {
            prev: string | null;
            next: string | null;
        };
        meta: CursorPaginatorMeta;
    }

    export interface CursorPaginator<T = Record<string, any>> extends BasePaginator<T>, CursorPaginatorMeta { }

    export interface PaginatorResource<T = Record<string, any>> {
        data: T[];
        meta: PaginatorMeta;
        links: {
            first: string;
            last: string;
            prev: string | null;
            next: string | null;
        };
    }

    export interface Paginator<T = Record<string, any>> extends BasePaginator<T>, PaginatorMeta {
        first_page_url: string;
        last_page_url: string;
        links: PaginatorLink[];
    }

    export type LengthAwarePaginatorResource<T = Record<string, any>> = PaginatorResource<T>;

    export type LengthAwarePaginator<T = Record<string, any>> = Paginator<T>;
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

export function useSimplePaginator<
    TData = Record<string, any>,
    TProps extends Record<string, any> = Record<string, any>
>(
    paginated: TProps | SimplePaginator<TData> | SimplePaginatorResource<TData>,
    key: keyof TProps | null = null,
    options: VisitOptions = {}
) {
    type PaginatedType = SimplePaginator<TData> | SimplePaginatorResource<TData>;
    
    const source = computed<PaginatedType>(() => key 
        ? (paginated as TProps)[key] as unknown as PaginatedType
        : paginated as PaginatedType
    );

    const isResource = computed(() => 
        source.value && typeof source.value === 'object' && 'meta' in source.value
    );

    const defaultOptions = {
        ...options,
        ...(isResource.value ? {
            only: [...((options.only ?? []) as string[]), key as string],
        } : {}),
    }

    const data = computed(() => source.value.data);

    const current = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).meta.current_page 
            : (source.value as SimplePaginator<TData>).current_page
    );    

    const next = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).links.next 
            : (source.value as SimplePaginator<TData>).next_page_url
    );

    const previous = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).links.prev 
            : (source.value as SimplePaginator<TData>).prev_page_url
    );

    const first = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).links.first 
            : (source.value as SimplePaginator<TData>).first_page_url
    );

    const perPage = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).meta.per_page 
            : (source.value as SimplePaginator<TData>).per_page
    );

    const from = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).meta.from 
            : (source.value as SimplePaginator<TData>).from
    );

    const to = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).meta.to 
            : (source.value as SimplePaginator<TData>).to
    );

    function navigate(url: string | null | undefined, options: VisitOptions = {}) {
        if (!url) 
            return;

        router.get(url, {}, {
            ...defaultOptions,
            ...options,
        });
    }

    function toFirst(options: VisitOptions = {}) {
        const url = first.value;
        navigate(url, {
            ...options,
        });
    }

    function toNext(options: VisitOptions = {}) {
        const url = next.value;
        navigate(url, options);
    }

    function toPrevious(options: VisitOptions = {}) {
        const url = previous.value;
        navigate(url, options);
    }


    return reactive({
        data,
        current,
        first,
        next,
        previous,
        to,
        perPage,
        from,
        navigate,
        toFirst,
        toNext,
        toPrevious,
    });
}

export function usePaginator<T>(data: Paginator<T> | PaginatorMeta) { 
    
}

export function useCursorPaginator() {

}

