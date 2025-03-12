import { BindingOptions } from '@honed/refine';
import { BooleanFilterRefiner } from '@honed/refine';
import { BulkAction } from '@honed/action';
import { BulkSelection } from '@honed/action';
import { Config as Config_2 } from '@honed/refine';
import { Confirm } from '@honed/action';
import { DateFilterRefiner } from '@honed/refine';
import { Direction } from '@honed/refine';
import { FilterRefiner } from '@honed/refine';
import { FilterValue } from '@honed/refine';
import { InlineAction } from '@honed/action';
import { Option as Option_2 } from '@honed/refine';
import { PageAction } from '@honed/action';
import { PromisifyFn } from '@vueuse/shared';
import { Refine } from '@honed/refine';
import { Route } from '@honed/action';
import { Search } from '@honed/refine';
import { SetFilterRefiner } from '@honed/refine';
import { Sort } from '@honed/refine';
import { Visit } from '@inertiajs/core';
import { VisitCallbacks } from '@inertiajs/core';
import { VisitOptions } from '@inertiajs/core';

export declare interface CollectionPaginator {
    empty: boolean;
}

export declare interface Column<T extends Record<string, any>> {
    name: keyof T;
    label: string;
    type: "text" | "number" | "date" | "boolean" | string;
    hidden: boolean;
    active: boolean;
    toggleable: boolean;
    icon?: string;
    class?: string;
    meta?: Record<string, any>;
    sort?: {
        active: boolean;
        direction: Direction;
        next: string | null;
    };
}

declare interface Config extends Config_2 {
    endpoint: string;
    record: string;
    records: string;
    columns: string;
    pages: string;
}

export declare interface CursorPaginator extends CollectionPaginator {
    prevLink: string | null;
    nextLink: string | null;
    perPage: number;
}

export declare type Identifier = string | number;

export declare interface LengthAwarePaginator extends SimplePaginator {
    total: number;
    from: number;
    to: number;
    firstLink: string | null;
    lastLink: string | null;
    links: PaginatorLink[];
}

declare type PaginatorKind = "cursor" | "length-aware" | "simple" | "collection";

export declare interface PaginatorLink {
    url: string | null;
    label: string;
    active: boolean;
}

export declare interface PerPageRecord {
    value: number;
    active: boolean;
}

export declare interface SimplePaginator extends CursorPaginator {
    currentPage: number;
}

export declare interface Table<T extends Record<string, any> = any, U extends PaginatorKind = "length-aware"> extends Refine {
    id: string;
    records: T[] & {
        actions: InlineAction[];
    };
    paginator: U extends "length-aware" ? LengthAwarePaginator : U extends "simple" ? SimplePaginator : U extends "cursor" ? CursorPaginator : CollectionPaginator;
    columns?: Column<T>[];
    recordsPerPage: PerPageRecord[];
    toggleable: boolean;
    actions: {
        hasInline: boolean;
        bulk: BulkAction[];
        page: PageAction[];
    };
    config: Config;
    meta: Record<string, any>;
}

export declare interface TableOptions<T extends Record<string, any>> {
    /**
     * Actions to be applied on a record in JavaScript.
     */
    recordActions?: Record<string, (record: T) => void>;
}

export declare function useTable<T extends object, K extends T[keyof T] extends Refine ? keyof T : never, U extends Record<string, any> = any, V extends "cursor" | "length-aware" | "simple" | "collection" = "length-aware">(props: T, key: K, tableOptions?: TableOptions<U>, defaultOptions?: VisitOptions): {
    filters: ({
        apply: (value: T, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        clear: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
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
        apply: (value: T, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        clear: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
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
        apply: (value: T, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        clear: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
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
        apply: (value: T, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        clear: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
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
    })[];
    sorts: {
        apply: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        clear: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        bind: () => {
            onClick: PromisifyFn<() => void>;
        } | undefined;
        type: string;
        direction: Direction;
        next: string | null;
        name: string;
        label: string; /** The actions available for the record */
        active: boolean;
        meta: Record<string, any>;
    }[];
    searches: {
        apply: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        clear: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        bind: () => {
            "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
            modelValue: boolean;
            value: boolean;
        } | undefined; /** Deselects this record */
        name: string;
        label: string;
        type: string;
        active: boolean;
        meta: Record<string, any>;
    }[] | undefined;
    getFilter: (name: string) => (SetFilterRefiner | FilterRefiner | DateFilterRefiner | BooleanFilterRefiner) | undefined;
    getSort: (name: string, direction?: Direction | undefined) => Sort | undefined;
    getSearch: (name: string) => Search | undefined;
    currentFilters: () => FilterRefiner[];
    currentSort: () => Sort | undefined;
    currentSearches: () => Search[];
    isFiltering: (name?: string | (SetFilterRefiner | FilterRefiner | DateFilterRefiner | BooleanFilterRefiner) | undefined) => boolean;
    isSorting: (name?: string | Sort | undefined) => boolean;
    isSearching: (name?: string | Search | undefined) => boolean;
    apply: (values: Record<string, any>, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    applyFilter: (filter: string | (SetFilterRefiner | FilterRefiner | DateFilterRefiner | BooleanFilterRefiner), value: any, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    applySort: (sort: string | Sort, direction?: Direction | undefined, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    applySearch: (value: string | null | undefined, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    applyMatch: (value: string | Search, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    clearFilter: (filter: string | (SetFilterRefiner | FilterRefiner | DateFilterRefiner | BooleanFilterRefiner), options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    clearSort: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    clearSearch: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    clearMatch: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    reset: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    bindFilter: <T_1 extends unknown>(filter: string | (SetFilterRefiner | FilterRefiner | DateFilterRefiner | BooleanFilterRefiner), options?: BindingOptions | undefined) => {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: T_1;
        value: T_1;
    } | undefined;
    bindSort: (sort: string | Sort, options?: BindingOptions | undefined) => {
        onClick: PromisifyFn<() => void>;
    } | undefined;
    bindSearch: (options?: BindingOptions | undefined) => {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: string;
        value: string;
    };
    bindMatch: (match: string | Search, options?: BindingOptions | undefined) => {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: boolean;
        value: boolean;
    } | undefined;
    stringValue: (value: any) => any;
    omitValue: (value: any) => any;
    toggleValue: (value: any, values: any) => any;
    delimitArray: (value: any) => any;
    getRecordKey: (record: U) => Identifier;
    meta: Record<string, any>;
    headings: {
        isSorting: boolean | undefined;
        toggleSort: (options?: VisitOptions) => void;
        name: keyof U;
        label: string;
        type: string;
        hidden: boolean;
        active: boolean;
        toggleable: boolean;
        icon?: string | undefined;
        class?: string | undefined;
        meta?: Record<string, any> | undefined;
        sort?: {
            active: boolean;
            direction: Direction;
            next: string | null;
        } | undefined;
    }[];
    columns: {
        toggle: (options?: VisitOptions) => void;
        name: keyof U;
        label: string;
        type: string;
        hidden: boolean;
        active: boolean;
        toggleable: boolean;
        icon?: string | undefined;
        class?: string | undefined;
        meta?: Record<string, any> | undefined;
        sort?: {
            active: boolean;
            direction: Direction;
            next: string | null;
        } | undefined;
    }[];
    records: (U & {
        /** Perform this action when the record is clicked */
        default: (options?: VisitOptions) => void;
        /** The actions available for the record */
        actions: any;
        /** Selects this record */
        select: () => void;
        /** Deselects this record */
        deselect: () => void;
        /** Toggles the selection of this record */
        toggle: () => void;
        /** Determine if the record is selected */
        selected: boolean;
        /** Bind the record to a checkbox */
        bind: () => {
            /**
             * Actions to be applied on a record in JavaScript.
             */
            "onUpdate:modelValue": (checked: boolean | "indeterminate") => void;
            modelValue: boolean;
            value: any;
        };
    })[];
    bulkActions: {
        /** Executes this bulk action */
        execute: (options?: VisitOptions) => void;
        type: "bulk";
        keepSelected: boolean;
        name: string;
        label: string;
        action?: boolean | undefined;
        extra?: Record<string, unknown> | undefined;
        icon?: string | undefined;
        confirm?: Confirm | undefined;
        route?: Route | undefined;
    }[];
    pageActions: {
        /** Executes this page action */
        execute: (options?: VisitOptions) => void;
        type: "page";
        name: string;
        label: string;
        action?: boolean | undefined;
        extra?: Record<string, unknown> | undefined;
        icon?: string | undefined;
        confirm?: Confirm | undefined;
        route?: Route | undefined;
    }[];
    rowsPerPage: {
        /** Changes the number of records to display per page */
        apply: (options?: VisitOptions) => void;
        value: number;
        active: boolean;
    }[];
    currentPage: PerPageRecord | undefined;
    paginator: (V extends "length-aware" ? LengthAwarePaginator : V extends "simple" ? SimplePaginator : V extends "cursor" ? CursorPaginator : CollectionPaginator) & {
        links?: {
            navigate: (options?: VisitOptions) => void | "" | null;
            url: string | null;
            label: string;
            active: boolean;
        }[] | undefined;
        next: (options?: VisitOptions) => void;
        previous: (options?: VisitOptions) => void;
        first: (options?: VisitOptions) => void;
        last: (options?: VisitOptions) => void;
    };
    executeInlineAction: (action: InlineAction, record: U, options?: VisitOptions) => void;
    executeBulkAction: (action: BulkAction, options?: VisitOptions) => void;
    executePageAction: (action: PageAction, options?: VisitOptions) => void;
    applyPage: (page: PerPageRecord, options?: VisitOptions) => void;
    selection: BulkSelection<any>;
    select: (record: U) => void;
    deselect: (record: U) => void;
    selectPage: () => void;
    deselectPage: () => void;
    toggle: (record: U) => void;
    selected: (record: U) => boolean;
    selectAll: () => void;
    deselectAll: () => void;
    isPageSelected: boolean;
    hasSelected: boolean;
    bindCheckbox: (record: U) => {
        /**
         * Actions to be applied on a record in JavaScript.
         */
        "onUpdate:modelValue": (checked: boolean | "indeterminate") => void;
        modelValue: boolean;
        value: any;
    };
    bindPage: () => {
        "onUpdate:modelValue": (checked: boolean | "indeterminate") => void;
        modelValue: boolean;
    };
    bindAll: () => {
        "onUpdate:modelValue": (checked: boolean | "indeterminate") => void;
        modelValue: boolean;
        value: boolean;
    };
};

export { }
