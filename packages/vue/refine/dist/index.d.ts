import { PromisifyFn } from '@vueuse/shared';
import { VisitOptions } from '@inertiajs/core';

export declare interface BindingOptions extends VisitOptions {
    /**
     * Transform the value before it is applied.
     */
    transform?: (value: any) => any;
    /**
     * The debounce time in milliseconds.
     *
     * @default 250
     */
    debounce?: number;
}

export declare type Direction = "asc" | "desc" | null;

export declare interface Filter extends Refiner {
    type: FilterType;
    value: FilterValue;
    options: Option_2[];
}

export declare interface FilterBinding {
    "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
    modelValue: any;
}

export declare type FilterType = "boolean" | "date" | "datetime" | "multiple" | "number" | "select" | "text" | "time" | "trashed" | string;

export declare type FilterValue = string | number | boolean | null;

export declare interface HonedFilter extends Filter {
    apply: (value: any, options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => FilterBinding | void;
}

export declare interface HonedRefine {
    filters: HonedFilter[];
    sorts: HonedSort[];
    searches: HonedSearch[];
    currentFilters: HonedFilter[];
    currentSort: HonedSort | undefined;
    currentSearches: HonedSearch[];
    isSortable: boolean;
    isSearchable: boolean;
    isMatchable: boolean;
    isFiltering: (name?: Filter | string) => boolean;
    isSorting: (name?: Sort | string) => boolean;
    isSearching: (name?: Search | string) => boolean;
    getFilter: (filter: Filter | string) => Filter | undefined;
    getSort: (sort: Sort | string, dir?: Direction) => Sort | undefined;
    getSearch: (search: Search | string) => Search | undefined;
    apply: (values: Record<string, FilterValue>, options?: VisitOptions) => void;
    applyFilter: (filter: Filter | string, value: any, options?: VisitOptions) => void;
    applySort: (sort: Sort | string, direction?: Direction, options?: VisitOptions) => void;
    applySearch: (value: string | null | undefined, options?: VisitOptions) => void;
    applyMatch: (search: Search | string, options?: VisitOptions) => void;
    clearFilter: (filter?: Filter | string, options?: VisitOptions) => void;
    clearSort: (options?: VisitOptions) => void;
    clearSearch: (options?: VisitOptions) => void;
    clearMatch: (options?: VisitOptions) => void;
    reset: (options?: VisitOptions) => void;
    bindFilter: (filter: Filter | string, options?: BindingOptions) => FilterBinding | void;
    bindSort: (sort: Sort | string, options?: BindingOptions) => SortBinding | void;
    bindSearch: (options?: BindingOptions) => SearchBinding | void;
    bindMatch: (match: Search | string, options?: BindingOptions) => MatchBinding | void;
    stringValue: (value: any) => any;
    omitValue: (value: any) => any;
    toggleValue: (value: any, values: any) => any;
    delimitArray: (value: any) => string;
}

export declare interface HonedSearch extends Search {
    apply: (options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => MatchBinding | void;
}

export declare interface HonedSort extends Sort {
    apply: (options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => SortBinding | void;
}

/**
 * Check if a refiner is of a given type.
 */
export declare function is(refiner: Refiner | string | null | undefined, type: string): boolean;

export declare interface MatchBinding {
    "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
    modelValue: boolean;
    value: string;
}

declare interface Option_2 {
    label: string;
    value: FilterValue;
    active: boolean;
}
export { Option_2 as Option }

export declare interface Refine {
    _sort_key?: string;
    _search_key?: string;
    _match_key?: string;
    _delimiter: string;
    term?: string;
    placeholder?: string;
    sorts: Sort[];
    filters: Filter[];
    searches: Search[];
}

export declare interface Refiner {
    name: string;
    label: string;
    type?: string;
    active: boolean;
    meta: Record<string, any>;
}

export declare interface Search extends Refiner {
}

export declare interface SearchBinding {
    "onUpdate:modelValue": PromisifyFn<(value: string | null | undefined) => void>;
    modelValue: string;
}

export declare interface Sort extends Refiner {
    direction: Direction;
    next: string | null;
}

export declare interface SortBinding {
    onClick: PromisifyFn<() => void>;
}

export declare type UseRefine = typeof useRefine;

export declare function useRefine<T extends Record<string, Refine>>(props: T, key: keyof T, defaults?: VisitOptions): HonedRefine;

export { }
