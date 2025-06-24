import { ComputedRef } from 'vue';
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

export declare type FilterType = "boolean" | "date" | "datetime" | "multiple" | "number" | "select" | "text" | "time" | "trashed" | string;

export declare type FilterValue = string | number | boolean | null;

export declare interface HonedFilter extends Filter {
    apply: (value: any, options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: unknown;
    } | undefined;
}

export declare interface HonedSearch extends Search {
    apply: (options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: boolean;
        value: string;
    } | undefined;
}

export declare interface HonedSort extends Sort {
    apply: (options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => {
        onClick: PromisifyFn<() => void>;
    } | undefined;
}

declare interface Option_2 {
    label: string;
    value: FilterValue;
    active: boolean;
}
export { Option_2 as Option }

export declare interface Refine {
    sort?: string;
    search?: string;
    match?: string;
    term?: string;
    placeholder?: string;
    delimiter: string;
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
    type: "search" | string;
}

export declare interface Sort extends Refiner {
    type: "sort" | string;
    direction: Direction;
    next: string | null;
}

export declare type UseRefine = typeof useRefine;

export declare function useRefine<T extends Record<string, Refine>>(props: T, key: keyof T, defaults?: VisitOptions): {
    filters: ComputedRef<    {
    apply: (value: T, options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => void | {
    "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
    modelValue: FilterValue;
    };
    type: string;
    value: FilterValue;
    options: Option_2[];
    name: string;
    label: string;
    active: boolean;
    meta: Record<string, any>;
    }[]>;
    sorts: ComputedRef<    {
    apply: (options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => void | {
    onClick: PromisifyFn<() => void>;
    };
    type: string;
    direction: Direction;
    next: string | null;
    name: string;
    label: string;
    active: boolean;
    meta: Record<string, any>;
    }[]>;
    searches: ComputedRef<    {
    apply: (options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => void | {
    "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
    modelValue: boolean;
    value: string;
    };
    type: string;
    name: string;
    label: string;
    active: boolean;
    meta: Record<string, any>;
    }[]>;
    currentFilters: ComputedRef<Filter[]>;
    currentSort: ComputedRef<Sort | undefined>;
    currentSearches: ComputedRef<Search[]>;
    isSortable: ComputedRef<boolean>;
    isSearchable: ComputedRef<boolean>;
    isMatchable: ComputedRef<boolean>;
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
    bindFilter: (filter: Filter | string, options?: BindingOptions) => void | {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: FilterValue;
    };
    bindSort: (sort: Sort | string, options?: BindingOptions) => void | {
        onClick: PromisifyFn<() => void>;
    };
    bindSearch: (options?: BindingOptions) => {
        "onUpdate:modelValue": PromisifyFn<(value: string | null | undefined) => void>;
        modelValue: string;
    };
    bindMatch: (match: Search | string, options?: BindingOptions) => void | {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: boolean;
        value: string;
    };
    stringValue: (value: any) => any;
    omitValue: (value: any) => any;
    toggleValue: (value: any, values: any) => any;
    delimitArray: (value: any) => any;
};

export { }
