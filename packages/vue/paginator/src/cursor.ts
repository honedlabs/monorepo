import { computed, reactive } from "vue";
import type { VisitOptions } from "@inertiajs/core";
import { useBasePaginator } from "./base";

export function useCursorPaginator<
    Data extends Record<string, any>,
    Props extends Record<string, any> = Record<string, any>
>(
    dataOrProps: Props | CursorPaginator<Data> | CursorPaginatorResource<Data>,
    keyOrOptions: keyof Props | VisitOptions | null = null,
    options: VisitOptions = {}
) {
    const paginator = useBasePaginator(dataOrProps, keyOrOptions, options)
    
    const nextCursor = computed(() => 
        paginator.isResource
            ? (paginator.source as unknown as CursorPaginatorResource<Data>).meta.next_cursor
            : (paginator.source as unknown as CursorPaginator<Data>).next_cursor
    )

    const prevCursor = computed(() => 
        paginator.isResource
            ? (paginator.source as unknown as CursorPaginatorResource<Data>).meta.prev_cursor
            : (paginator.source as unknown as CursorPaginator<Data>).prev_cursor
    )

    return reactive({
        ...paginator,
        nextCursor,
        prevCursor,
    })
    
}

export type UseCursorPaginator = ReturnType<typeof useCursorPaginator>
