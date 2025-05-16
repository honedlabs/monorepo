import { computed, reactive } from 'vue';
import { router } from "@inertiajs/vue3";
import type { VisitOptions } from "@inertiajs/core";

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

    /**
     * Check if the pagination comes from a resource paginator or query paginator.
     */
    const isResource = computed(() => 
        typeof source.value === 'object' && 'meta' in source.value
    );

    const defaultOptions = {
        ...options,
        ...(isResource.value ? {
            only: [...((options.only ?? []) as string[]), key as string],
        } : {}),
    }

    /**
     * Get the data of the current page.
     */
    const data = computed(() => source.value.data);

    /**
     * Get the current page number.
     */
    const current = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).meta.current_page 
            : (source.value as SimplePaginator<TData>).current_page
    );    

    /**
     * Get the next page url.
     */
    const next = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).links.next 
            : (source.value as SimplePaginator<TData>).next_page_url
    );

    /**
     * Get the previous page url.
     */
    const previous = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).links.prev 
            : (source.value as SimplePaginator<TData>).prev_page_url
    );

    /**
     * Get the first page url.
     */
    const first = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).links.first 
            : (source.value as SimplePaginator<TData>).first_page_url
    );

    /**
     * Get the number of records per page.
     */
    const perPage = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).meta.per_page 
            : (source.value as SimplePaginator<TData>).per_page
    );

    /**
     * Get the first record number shown on the current page.
     */
    const from = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).meta.from 
            : (source.value as SimplePaginator<TData>).from
    );

    /**
     * Get the final record number shown on the current page.
     */
    const to = computed(() => 
        isResource.value 
            ? (source.value as SimplePaginatorResource<TData>).meta.to 
            : (source.value as SimplePaginator<TData>).to
    );

    /**
     * Perform a navigation to the given pagination url.
     */
    function navigate(url: string | null | undefined, options: VisitOptions = {}) {
        if (!url) 
            return;

        router.get(url, {}, {
            ...defaultOptions,
            ...options,
        });
    }

    /**
     * Perform a navigation to the first page url.
     */
    function toFirst(options: VisitOptions = {}) {
        const url = first.value;
        navigate(url, {
            ...options,
        });
    }

    /**
     * Perform a navigation to the next page url.
     */
    function toNext(options: VisitOptions = {}) {
        const url = next.value;
        navigate(url, options);
    }

    /**
     * Perform a navigation to the previous page url.
     */
    function toPrevious(options: VisitOptions = {}) {
        const url = previous.value;
        navigate(url, options);
    }

    return reactive({
        data,
        isResource,
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
