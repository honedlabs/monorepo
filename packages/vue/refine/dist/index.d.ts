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

export declare interface BooleanFilterRefiner extends FilterRefiner {
    type: "boolean";
    value: boolean;
}

export declare interface Config {
    delimiter: string;
    search: string | null;
    searches: string;
    sorts: string;
    matches?: string;
}

export declare interface DateFilterRefiner extends FilterRefiner {
    type: "date";
    value: string;
}

export declare type Direction = "asc" | "desc" | null;

declare type Filter = SetFilterRefiner | DateFilterRefiner | BooleanFilterRefiner | FilterRefiner;

export declare interface FilterRefiner extends Refiner {
    type: KnownFilter | string;
    value: FilterValue;
}

export declare type FilterValue = string | number | boolean | null;

export declare type KnownFilter = "filter" | "set" | "date" | "boolean" | string;

declare interface Option_2 {
    label: string;
    value: FilterValue;
    active: boolean;
}
export { Option_2 as Option }

export declare interface Refine {
    sorts: Sort[];
    filters: Filter[];
    config: Config;
    searches?: Search[];
}

export declare interface Refiner {
    name: string;
    label: string;
    type: string;
    active: boolean;
    meta: Record<string, any>;
}

export declare interface Search extends Refiner {
}

export declare interface SetFilterRefiner extends FilterRefiner {
    type: "set";
    multiple: boolean;
    options: Option_2[];
}

export declare interface Sort extends Refiner {
    type: "sort" | string;
    direction: Direction;
    next: string | null;
}

export declare function useRefine<T extends object, K extends T[keyof T] extends Refine ? keyof T : never>(props: T, key: K, defaultOptions?: VisitOptions): {
    filters: ComputedRef<({
    apply: (value: T, options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => {
    "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
    modelValue: unknown;
    value: unknown;
    } | undefined;
    type: string;
    value: FilterValue;
    name: string;
    label: string;
    active: boolean;
    meta: Record<string, any>;
    } | {
    apply: (value: T, options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => {
    "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
    modelValue: unknown;
    value: unknown;
    } | undefined;
    type: "set";
    multiple: boolean;
    options: Option_2[];
    value: FilterValue;
    name: string;
    label: string;
    active: boolean;
    meta: Record<string, any>;
    } | {
    apply: (value: T, options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => {
    "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
    modelValue: unknown;
    value: unknown;
    } | undefined;
    type: "date";
    value: string;
    name: string;
    label: string;
    active: boolean;
    meta: Record<string, any>;
    } | {
    apply: (value: T, options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => {
    "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
    modelValue: unknown;
    value: unknown;
    } | undefined;
    type: "boolean";
    value: boolean;
    name: string;
    label: string;
    active: boolean;
    meta: Record<string, any>;
    })[]>;
    sorts: ComputedRef<    {
    apply: (options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => {
    onClick: PromisifyFn<() => void>;
    } | undefined;
    type: string;
    direction: Direction;
    next: string | null;
    name: string;
    label: string;
    active: boolean;
    meta: Record<string, any>;
    }[]>;
    getSort: (name: string, direction?: Direction) => Sort | undefined;
    getFilter: (name: string) => Filter | undefined;
    getSearch: (name: string) => Search | undefined;
    currentSort: () => Sort | undefined;
    currentFilters: () => FilterRefiner[];
    currentSearches: () => Search[];
    isSorting: (name?: string) => boolean;
    isFiltering: (name?: string) => boolean;
    isSearching: (name?: string) => boolean;
    applyFilter: (filter: Filter | string, value: any, options?: VisitOptions) => void;
    applySort: (sort: Sort | string, direction?: Direction, options?: VisitOptions) => void;
    applySearch: (value: string | null | undefined, options?: VisitOptions) => void;
    clearFilter: (filter: Filter | string, options?: VisitOptions) => void;
    clearSort: (options?: VisitOptions) => void;
    clearSearch: (options?: VisitOptions) => void;
    reset: (options?: VisitOptions) => void;
    bindFilter: <T_1 extends unknown>(filter: Filter | string, options?: BindingOptions) => {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: T_1;
        value: T_1;
    } | undefined;
    bindSort: (sort: Sort | string, options?: BindingOptions) => {
        onClick: PromisifyFn<() => void>;
    } | undefined;
    bindSearch: (options?: BindingOptions) => {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: string;
    };
    /** Provide the helpers */
    stringValue: (value: any) => any;
    omitValue: (value: any) => any;
    toggleValue: (value: any, values: any) => any;
    delimitArray: (value: any) => any;
};

export { }
