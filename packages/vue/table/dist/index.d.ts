import { BindingOptions } from '@honed/refine';
import { BulkOperation } from '@honed/action';
import { BulkSelection } from '@honed/action';
import { Direction } from '@honed/refine';
import { Filter } from '@honed/refine';
import { FilterValue } from '@honed/refine';
import { InlineOperation } from '@honed/action';
import { MaybeEndpoint } from '@honed/action';
import { MaybeId } from '@honed/action';
import { Option as Option_2 } from '@honed/refine';
import { PageOperation } from '@honed/action';
import { PageOperationData } from '@honed/action';
import { PromisifyFn } from '@vueuse/shared';
import { Refine } from '@honed/refine';
import { Search } from '@honed/refine';
import { Sort } from '@honed/refine';
import { Visit } from '@inertiajs/core';
import { VisitCallbacks } from '@inertiajs/core';
import { VisitOptions } from '@inertiajs/core';

export declare interface BaseColumn<T extends Record<string, any> = Record<string, any>> {
    name: keyof T;
    label: string;
    type?: ColumnType;
    hidden: boolean;
    active: boolean;
    badge?: boolean;
    toggleable: boolean;
    class?: string;
    record_class?: string;
    icon?: string;
    sort?: Pick<Sort, "active" | "direction" | "next">;
}

export declare interface CollectionPaginate {
    empty: boolean;
}

export declare interface Column<T extends Record<string, any> = Record<string, any>> extends BaseColumn<T> {
    toggle: (options: VisitOptions) => void;
}

export declare type ColumnType = "array" | "badge" | "boolean" | "color" | "date" | "datetime" | "icon" | "image" | "numeric" | "text" | "time" | string;

export declare interface CursorPaginate extends CollectionPaginate {
    prevLink: string | null;
    nextLink: string | null;
    perPage: number;
}

export declare interface EmptyState {
    title: string;
    description: string;
    icon?: string;
    operations: PageOperation[];
}

export declare interface Heading<T extends Record<string, any> = Record<string, any>> extends BaseColumn<T> {
    isSorting: boolean;
    toggleSort: (options: VisitOptions) => void;
}

export declare type Identifier = string | number;

export declare function is(column: Column | string | null | undefined, type: ColumnType): boolean;

export declare interface LengthAwarePaginate extends SimplePaginate {
    total: number;
    from: number;
    to: number;
    firstLink: string | null;
    lastLink: string | null;
    links: PaginatorLink[];
}

export declare interface PageOption {
    value: number;
    active: boolean;
}

export declare type Paginate = "cursor" | "length-aware" | "simple" | "collection";

export declare type PaginateMap = {
    cursor: CursorPaginate;
    "length-aware": LengthAwarePaginate;
    simple: SimplePaginate;
    collection: CollectionPaginate;
};

export declare interface PaginatorLink {
    url: string | null;
    label: string;
    active: boolean;
}

export declare interface SimplePaginate extends CursorPaginate {
    currentPage: number;
}

export declare interface Table<T extends Record<string, any> = Record<string, any>, K extends Paginate = "length-aware"> extends Refine {
    id: MaybeId;
    endpoint: MaybeEndpoint;
    key: string;
    column?: string;
    record?: string;
    page?: string;
    records: Array<TableEntry<T> & {
        actions: InlineOperation[];
    }>;
    paginate: PaginateMap[K];
    columns: BaseColumn<T>[];
    pages: PageOption[];
    toggleable: boolean;
    operations: {
        inline: boolean;
        bulk: BulkOperation[];
        page: PageOperation[];
    };
    emptyState?: EmptyState;
    views?: View[];
    meta: Record<string, any>;
}

export declare type TableEntry<RecordType extends Record<string, any> = any> = {
    [K in keyof RecordType]: {
        v: RecordType[K];
        e: any;
        c: string | null;
        f: boolean;
    };
};

export declare interface TableOptions<RecordType extends Record<string, any> = Record<string, any>> extends VisitOptions {
    /**
     * Mappings of operations to be applied on a record in JavaScript.
     */
    recordActions?: Record<string, (record: TableEntry<RecordType>) => void>;
}

export declare interface TableRecord<RecordType extends Record<string, any> = Record<string, any>> {
    record: RecordType;
    default: (options?: VisitOptions) => void;
    actions: InlineOperation[];
    select: () => void;
    deselect: () => void;
    toggle: () => void;
    selected: boolean;
    bind: () => Record<string, any>;
    value: (column: Column<RecordType> | string) => any;
    extra: (column: Column<RecordType> | string) => any;
}

export declare type UseTable = typeof useTable;

export declare function useTable<T extends Record<string, Table>, K extends Record<string, any> = Record<string, any>, U extends Paginate = "length-aware">(props: T, key: keyof T, defaults?: TableOptions): {
    filters: {
        apply: (value: T, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        clear: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        bind: () => void | {
            "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
            modelValue: FilterValue;
        }; /** Bind the record to a checkbox */
        type: string;
        value: FilterValue;
        options: Option_2[];
        name: string; /** Get the value of the record for the column */
        label: string;
        active: boolean;
        meta: Record<string, any>;
    }[];
    sorts: {
        apply: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        clear: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
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
    }[];
    searches: {
        apply: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
        clear: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
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
    }[];
    currentFilters: Filter[];
    currentSort: Sort | undefined;
    currentSearches: Search[];
    isSortable: boolean;
    isSearchable: boolean;
    isMatchable: boolean;
    isFiltering: (name?: string | Filter | undefined) => boolean;
    isSorting: (name?: string | Sort | undefined) => boolean;
    isSearching: (name?: string | Search | undefined) => boolean;
    getFilter: (filter: string | Filter) => Filter | undefined;
    getSort: (sort: string | Sort, dir?: Direction | undefined) => Sort | undefined;
    getSearch: (search: string | Search) => Search | undefined;
    apply: (values: Record<string, FilterValue>, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    applyFilter: (filter: string | Filter, value: any, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    applySort: (sort: string | Sort, direction?: Direction | undefined, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    applySearch: (value: string | null | undefined, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    applyMatch: (search: string | Search, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    clearFilter: (filter?: string | Filter | undefined, options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    clearSort: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    clearSearch: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    clearMatch: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    reset: (options?: Partial<Visit & VisitCallbacks> | undefined) => void;
    bindFilter: (filter: string | Filter, options?: BindingOptions | undefined) => void | {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: FilterValue;
    };
    bindSort: (sort: string | Sort, options?: BindingOptions | undefined) => void | {
        onClick: PromisifyFn<() => void>;
    };
    bindSearch: (options?: BindingOptions | undefined) => {
        "onUpdate:modelValue": PromisifyFn<(value: string | null | undefined) => void>;
        modelValue: string;
    };
    bindMatch: (match: string | Search, options?: BindingOptions | undefined) => void | {
        "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
        modelValue: boolean;
        value: string;
    };
    stringValue: (value: any) => any;
    omitValue: (value: any) => any;
    toggleValue: (value: any, values: any) => any;
    delimitArray: (value: any) => any;
    table: Table<K, U>;
    getRecordKey: (record: TableEntry<K>) => Identifier;
    meta: Record<string, any>;
    headings: Heading<K>[];
    columns: Column<K>[];
    records: {
        record: Omit<TableEntry<K> & {
            actions: InlineOperation[];
        }, "actions">;
        /** The actions available for the record */
        actions: (InlineOperation & {
            execute: (data?: any, options?: Partial<Visit & VisitCallbacks> | undefined) => boolean;
        })[];
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
        value: (column: Column<K> | string) => K[string] | K[number] | K[symbol] | null;
        /** Get the extra data of the record for the column */
        extra: (column: Column<K> | string) => any;
    }[];
    inline: boolean;
    bulk: (BulkOperation & {
        execute: (data?: any, options?: Partial<Visit & VisitCallbacks> | undefined) => boolean;
    })[];
    page: (PageOperation & {
        execute: (data?: any, options?: Partial<Visit & VisitCallbacks> | undefined) => boolean;
    })[];
    pages: {
        value: number;
        active: boolean;
    }[];
    currentPage: PageOption | undefined;
    paginator: PaginateMap[U] & {
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
    executeInline: (operation: InlineOperation, data: TableEntry<K>, options?: VisitOptions) => void;
    executeBulk: (operation: BulkOperation, options?: VisitOptions) => void;
    executePage: (operation: PageOperation, data?: PageOperationData, options?: VisitOptions) => boolean;
    applyPage: (page: PageOption, options?: VisitOptions) => void;
    selection: BulkSelection<Identifier>;
    select: (record: TableEntry<K>) => void;
    deselect: (record: TableEntry<K>) => void;
    selectPage: () => void;
    deselectPage: () => void;
    toggle: (record: TableEntry<K>) => void;
    selected: (record: TableEntry<K>) => boolean;
    selectAll: () => void;
    deselectAll: () => void;
    isPageSelected: boolean;
    hasSelected: boolean;
    bindCheckbox: (record: TableEntry<K>) => {
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
    };
};

export declare interface View {
    id: number;
    name: string;
    view: string;
}

export { }
