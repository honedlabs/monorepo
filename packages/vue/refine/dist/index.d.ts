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

export declare interface Config {
    delimiter: string;
    search: string | null;
    searches: string;
    sorts: string;
    matches?: string;
}

export declare type Direction = "asc" | "desc" | null;

export declare interface Filter extends Refiner {
    type: "filter" | string;
    value: FilterValue;
    options: Option_2[];
    multiple: boolean;
}

export declare type FilterValue = string | number | boolean | null;

declare interface Option_2 {
    label: string;
    value: FilterValue;
    active: boolean;
}
export { Option_2 as Option }

export declare interface Refine {
    sorts?: Sort[];
    filters?: Filter[];
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
    type: "search" | string;
}

export declare interface Sort extends Refiner {
    type: "sort" | string;
    direction: Direction;
    next: string | null;
}

export declare function useRefine<T extends object, K extends T[keyof T] extends Refine ? keyof T : never>(props: T, key: K, defaultOptions?: VisitOptions): {
    filters: ComputedRef<    {
    apply: (value: T, options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => {
    "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
    modelValue: unknown;
    } | undefined;
    type: string;
    value: FilterValue;
    options: Option_2[];
    multiple: boolean;
    name: string;
    label: string;
    active: boolean;
    meta: Record<string, any>;
    }[]>;
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
    searches: ComputedRef<    {
    apply: (options?: VisitOptions) => void;
    clear: (options?: VisitOptions) => void;
    bind: () => {
    "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
    modelValue: boolean;
    value: string;
    } | undefined;
    type: string;
    name: string;
    label: string;
    active: boolean;
    meta: Record<string, any>;
    }[] | undefined>;
    getFilter: (name: string) => Filter | undefined;
    getSort: (name: string, direction?: Direction) => Sort | undefined;
    getSearch: (name: string) => Search | undefined;
    currentFilters: () => Filter[];
    currentSort: () => Sort | undefined;
    currentSearches: () => Search[];
    isFiltering: (name?: Filter | string) => boolean;
    isSorting: (name?: Sort | string) => boolean;
    isSearching: (name?: Search | string) => boolean;
    apply: (values: Record<string, any>, options?: VisitOptions) => void;
    applyFilter: (filter: Filter | string, value: any, options?: VisitOptions) => void;
    applySort: (sort: Sort | string, direction?: Direction, options?: VisitOptions) => void;
    applySearch: (value: string | null | undefined, options?: VisitOptions) => void;
    applyMatch: (value: Search | string, options?: VisitOptions) => void;
    clearFilter: (filter: Filter | string, options?: VisitOptions) => void;
    clearSort: (options?: VisitOptions) => void;
    clearSearch: (options?: VisitOptions) => void;
    clearMatch: (options?: VisitOptions) => void;
    reset: (options?: VisitOptions) => void;
    bindFilter: <T_1 extends unknown>(filter: Filter | string, options?: BindingOptions) => {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: T_1;
    } | undefined;
    bindSort: (sort: Sort | string, options?: BindingOptions) => {
        onClick: PromisifyFn<() => void>;
    } | undefined;
    bindSearch: (options?: BindingOptions) => {
        "onUpdate:modelValue": PromisifyFn<(value: string | null | undefined) => void>;
        modelValue: string;
    };
    bindMatch: (match: Search | string, options?: BindingOptions) => {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: boolean;
        value: string;
    } | undefined;
    stringValue: (value: any) => any;
    omitValue: (value: any) => any;
    toggleValue: (value: any, values: any) => any;
    delimitArray: (value: any) => any;
};

export { }
