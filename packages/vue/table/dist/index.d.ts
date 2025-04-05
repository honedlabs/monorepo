import { BindingOptions } from '@honed/refine';
import { BulkAction } from '@honed/action';
import { BulkSelection } from '@honed/action';
import { Config as Config_2 } from '@honed/refine';
import { Confirm } from '@honed/action';
import { Direction } from '@honed/refine';
import { Filter } from '@honed/refine';
import { FilterValue } from '@honed/refine';
import { InlineAction } from '@honed/action';
import { Option as Option_2 } from '@honed/refine';
import { PageAction } from '@honed/action';
import { PromisifyFn } from '@vueuse/shared';
import { Refine } from '@honed/refine';
import { Route } from '@honed/action';
import { Search } from '@honed/refine';
import { Sort } from '@honed/refine';
import { Visit } from '@inertiajs/core';
import { VisitCallbacks } from '@inertiajs/core';
import { VisitOptions } from '@inertiajs/core';

export declare type AsRecord<RecordType extends Record<string, any> = any> = {
    [K in keyof RecordType]: {
        value: RecordType[K];
        extra: Record<string, any>;
    };
};

export declare interface CollectionPaginator {
    empty: boolean;
}

export declare interface Column<T extends Record<string, any> = Record<string, any>> {
    name: keyof T;
    label: string;
    type: "array" | "badge" | "boolean" | "currency" | "date" | "hidden" | "key" | "number" | "text" | string;
    hidden: boolean;
    active: boolean;
    toggleable: boolean;
    icon?: string;
    class?: string;
    sort?: {
        active: boolean;
        direction: Direction;
        next: string | null;
    };
}

export declare interface Config extends Config_2 {
    endpoint: string;
    key: string;
    record: string;
    column: string;
    page: string;
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

export declare type PaginatorKind = "cursor" | "length-aware" | "simple" | "collection";

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

export declare interface Table<RecordType extends Record<string, any> = any, Paginator extends PaginatorKind = "length-aware"> extends Refine {
    config: Config;
    id: string;
    records: Array<AsRecord<RecordType> & {
        actions: InlineAction[];
    }>;
    paginator: Paginator extends "length-aware" ? LengthAwarePaginator : Paginator extends "simple" ? SimplePaginator : Paginator extends "cursor" ? CursorPaginator : CollectionPaginator;
    columns?: Column<RecordType>[];
    recordsPerPage?: PerPageRecord[];
    toggleable: boolean;
    actions: {
        inline: boolean;
        bulk: BulkAction[];
        page: PageAction[];
    };
    meta: Record<string, any>;
}

export declare interface TableColumn<T extends Record<string, any> = Record<string, any>> extends Column<T> {
    toggle: (options: VisitOptions) => void;
}

export declare interface TableHeading<T extends Record<string, any> = Record<string, any>> extends Column<T> {
    isSorting: boolean;
    toggleSort: (options: VisitOptions) => void;
}

export declare interface TableOptions<RecordType extends Record<string, any> = Record<string, any>> {
    /**
     * Actions to be applied on a record in JavaScript.
     */
    recordActions?: Record<string, (record: AsRecord<RecordType>) => void>;
}

export declare interface TableRecord<RecordType extends Record<string, any> = Record<string, any>> {
    record: RecordType;
    default: (options?: VisitOptions) => void;
    actions: InlineAction[];
    select: () => void;
    deselect: () => void;
    toggle: () => void;
    selected: boolean;
    bind: () => Record<string, any>;
    value: (column: Column<RecordType> | string) => any;
    extra: (column: Column<RecordType> | string) => any;
}

export declare type UseTable = typeof useTable;

export declare function useTable<Props extends object, Key extends Props[keyof Props] extends Refine ? keyof Props : never, RecordType extends Record<string, any> = any, Paginator extends PaginatorKind = "length-aware">(props: Props, key: Key, tableOptions?: TableOptions<RecordType>, defaultOptions?: VisitOptions): {
    filters: {
        apply: (value: Props, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        clear: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        bind: () => {
            "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
            modelValue: unknown;
        } | undefined;
        type: string;
        value: FilterValue;
        options: Option_2[];
        name: string;
        label: string;
        active: boolean;
        meta: Record<string, any>;
    }[];
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
        label: string;
        active: boolean;
        meta: Record<string, any>;
    }[];
    searches: {
        apply: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        clear: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
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
    }[] | undefined;
    getFilter: (name: string) => Filter | undefined;
    getSort: (name: string, direction?: Direction | undefined) => Sort | undefined;
    getSearch: (name: string) => Search | undefined;
    currentFilters: Filter[];
    currentSort: Sort | undefined;
    currentSearches: Search[];
    isFiltering: (name?: string | Filter | undefined) => boolean;
    isSorting: (name?: string | Sort | undefined) => boolean;
    isSearching: (name?: string | Search | undefined) => boolean;
    apply: (values: Record<string, any>, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    applyFilter: (filter: string | Filter, value: any, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    applySort: (sort: string | Sort, direction?: Direction | undefined, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    applySearch: (value: string | null | undefined, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    applyMatch: (search: string | Search, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    clearFilter: (filter: string | Filter, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    clearSort: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    clearSearch: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    clearMatch: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    reset: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    bindFilter: <T_1 extends unknown>(filter: string | Filter, options?: BindingOptions | undefined) => {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: T_1;
    } | undefined;
    bindSort: (sort: string | Sort, options?: BindingOptions | undefined) => {
        onClick: PromisifyFn<() => void>;
    } | undefined;
    bindSearch: (options?: BindingOptions | undefined) => {
        "onUpdate:modelValue": PromisifyFn<(value: string | null | undefined) => void>;
        modelValue: string;
    };
    bindMatch: (match: string | Search, options?: BindingOptions | undefined) => {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: boolean;
        value: string;
    } | undefined;
    stringValue: (value: any) => any;
    omitValue: (value: any) => any;
    toggleValue: (value: any, values: any) => any;
    delimitArray: (value: any) => any;
    getRecordKey: (record: AsRecord<RecordType>) => Identifier;
    meta: Record<string, any>;
    headings: {
        isSorting: boolean | undefined;
        toggleSort: (options?: VisitOptions) => void;
        name: keyof RecordType;
        /**
         * The heading columns for the table.
         */
        label: string;
        type: string;
        hidden: boolean;
        active: boolean;
        toggleable: boolean;
        icon?: string | undefined;
        class?: string | undefined;
        sort?: {
            active: boolean;
            direction: Direction;
            next: string | null;
        } | undefined;
    }[];
    columns: {
        toggle: (options?: VisitOptions) => void;
        name: keyof RecordType;
        /**
         * The heading columns for the table.
         */
        label: string;
        type: string;
        hidden: boolean;
        active: boolean;
        toggleable: boolean;
        icon?: string | undefined;
        class?: string | undefined;
        sort?: {
            active: boolean;
            direction: Direction;
            next: string | null;
        } | undefined;
    }[];
    records: {
        record: Omit<AsRecord<RecordType> & {
            actions: InlineAction[];
        }, "actions">;
        /** The actions available for the record */
        actions: {
            /** Executes this action */
            execute: (options?: VisitOptions) => void;
            type: "inline";
            default: boolean;
            name: string;
            label: string;
            icon?: string | undefined;
            extra?: Record<string, unknown> | undefined;
            action?: boolean | undefined;
            confirm?: Confirm | undefined;
            route?: Route | undefined;
        }[];
        /** Perform this action when the record is clicked */
        default: (options?: VisitOptions) => void;
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
            "onUpdate:modelValue": (checked: boolean | "indeterminate") => void;
            modelValue: boolean;
            value: Identifier;
        };
        /** Get the value of the record for the column */
        value: (column: Column<RecordType> | string) => RecordType[string] | RecordType[number] | RecordType[symbol] | null;
        /** Get the extra data of the record for the column */
        extra: (column: Column<RecordType> | string) => Record<string, any> | null;
    }[];
    inline: boolean;
    bulkActions: {
        execute: (options?: VisitOptions) => void;
        type: "bulk";
        keepSelected: boolean;
        name: string;
        label: string;
        icon?: string | undefined;
        extra?: Record<string, unknown> | undefined;
        action?: boolean | undefined;
        confirm?: Confirm | undefined;
        route?: Route | undefined;
    }[];
    pageActions: {
        execute: (options?: VisitOptions) => void;
        type: "page";
        name: string;
        label: string;
        icon?: string | undefined;
        extra?: Record<string, unknown> | undefined;
        action?: boolean | undefined;
        confirm?: Confirm | undefined;
        route?: Route | undefined;
    }[];
    rowsPerPage: {
        apply: (options?: VisitOptions) => void;
        value: number;
        active: boolean;
    }[];
    currentPage: PerPageRecord | undefined;
    paginator: (Paginator extends "length-aware" ? LengthAwarePaginator : Paginator extends "simple" ? SimplePaginator : Paginator extends "cursor" ? CursorPaginator : CollectionPaginator) & {
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
    executeInlineAction: (action: InlineAction, record: AsRecord<RecordType>, options?: VisitOptions) => void;
    executeBulkAction: (action: BulkAction, options?: VisitOptions) => void;
    executePageAction: (action: PageAction, options?: VisitOptions) => void;
    applyPage: (page: PerPageRecord, options?: VisitOptions) => void;
    selection: BulkSelection<Identifier>;
    select: (record: AsRecord<RecordType>) => void;
    deselect: (record: AsRecord<RecordType>) => void;
    selectPage: () => void;
    deselectPage: () => void;
    toggle: (record: AsRecord<RecordType>) => void;
    selected: (record: AsRecord<RecordType>) => boolean;
    selectAll: () => void;
    deselectAll: () => void;
    isPageSelected: boolean;
    hasSelected: boolean;
    bindCheckbox: (record: AsRecord<RecordType>) => {
        "onUpdate:modelValue": (checked: boolean | "indeterminate") => void;
        modelValue: boolean;
        value: Identifier;
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
