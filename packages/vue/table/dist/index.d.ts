import { BindingOptions } from '@honed/refine';
import { BulkOperation } from '@honed/action';
import { BulkSelection } from '@honed/action';
import { ComputedRef } from 'vue';
import { Direction } from '@honed/refine';
import { Executable } from '@honed/action';
import { Filter } from '@honed/refine';
import { FilterBinding } from '@honed/refine';
import { FilterValue } from '@honed/refine';
import { HonedFilter } from '@honed/refine';
import { HonedRefine } from '@honed/refine';
import { HonedSearch } from '@honed/refine';
import { HonedSort } from '@honed/refine';
import { InlineOperation } from '@honed/action';
import { MatchBinding } from '@honed/refine';
import { MaybeEndpoint } from '@honed/action';
import { MaybeId } from '@honed/action';
import { PageOperation } from '@honed/action';
import { PageOperationData } from '@honed/action';
import { Ref } from 'vue';
import { Refine } from '@honed/refine';
import { Search } from '@honed/refine';
import { SearchBinding } from '@honed/refine';
import { Sort } from '@honed/refine';
import { SortBinding } from '@honed/refine';
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

export declare interface HonedTable<T extends Record<string, any> = Record<string, any>, K extends Paginate = "length-aware"> extends HonedRefine {
    meta: ComputedRef<Record<string, any> | null>;
    isPageable: ComputedRef<boolean>;
    isToggleable: ComputedRef<boolean>;
    getRecordKey: (record: TableEntry<T>) => Identifier;
    headings: ComputedRef<Heading<T>[]>;
    columns: ComputedRef<Column<T>[]>;
    records: ComputedRef<TableRecord<T>[]>;
    inline: ComputedRef<boolean>;
    bulk: ComputedRef<Executable<BulkOperation>[]>;
    page: ComputedRef<Executable<PageOperation>[]>;
    pages: ComputedRef<PageOption[]>;
    currentPage: ComputedRef<PageOption | undefined>;
    paginator: ComputedRef<PaginateMap[K]>;
    executeInline: (operation: InlineOperation, data: TableEntry<T>, options?: VisitOptions) => void;
    executeBulk: (operation: BulkOperation, options?: VisitOptions) => void;
    executePage: (operation: PageOperation, data?: PageOperationData, options?: VisitOptions) => void;
    applyPage: (page: PageOption, options?: VisitOptions) => void;
    selection: Ref<BulkSelection<Identifier>, BulkSelection<Identifier>>;
    select: (record: TableEntry<T>) => void;
    deselect: (record: TableEntry<T>) => void;
    toggle: (record: TableEntry<T>) => void;
    selectPage: () => void;
    deselectPage: () => void;
    selected: (record: TableEntry<T>) => boolean;
    selectAll: () => void;
    deselectAll: () => void;
    isPageSelected: ComputedRef<boolean>;
    hasSelected: ComputedRef<boolean>;
    bindCheckbox: (record: TableEntry<T>) => void;
    bindPage: () => void;
    bindAll: () => void;
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

export declare interface PageBinding {
    "onUpdate:modelValue": (checked: boolean | "indeterminate") => void;
    modelValue: boolean;
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
        operations: InlineOperation[];
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

export declare type TableEntry<T extends Record<string, any> = any> = {
    [K in keyof T]: {
        v: T[K];
        e: any;
        c: string | null;
        f: boolean;
    };
};

export declare interface TableOptions<T extends Record<string, any> = Record<string, any>> extends VisitOptions {
    /**
     * Mappings of operations to be applied on a record in JavaScript.
     */
    recordOperations?: Record<string, (record: TableEntry<T>) => void>;
}

export declare interface TableRecord<T extends Record<string, any> = Record<string, any>> {
    operations: Executable<InlineOperation>[];
    default: (options?: VisitOptions) => void;
    select: () => void;
    deselect: () => void;
    toggle: () => void;
    selected: boolean;
    bind: () => any;
    entry: (column: Column<T> | string) => TableEntry<T>[keyof T] | null;
    value: (column: Column<T> | string) => TableEntry<T>[keyof T]["v"] | null;
    extra: (column: Column<T> | string) => TableEntry<T>[keyof T]["e"] | null;
}

export declare type UseTable = typeof useTable;

export declare function useTable<T extends Record<string, Table>, K extends Record<string, any> = Record<string, any>, U extends Paginate = "length-aware">(props: T, key: keyof T, defaults?: TableOptions): {
    filters: HonedFilter[];
    sorts: HonedSort[];
    searches: HonedSearch[];
    currentFilters: HonedFilter[];
    currentSort: HonedSort | undefined;
    currentSearches: HonedSearch[];
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
    bindFilter: (filter: string | Filter, options?: BindingOptions | undefined) => void | FilterBinding;
    bindSort: (sort: string | Sort, options?: BindingOptions | undefined) => void | SortBinding;
    bindSearch: (options?: BindingOptions | undefined) => void | SearchBinding;
    bindMatch: (match: string | Search, options?: BindingOptions | undefined) => void | MatchBinding;
    stringValue: (value: any) => any;
    omitValue: (value: any) => any;
    toggleValue: (value: any, values: any) => any;
    delimitArray: (value: any) => string;
    meta: Record<string, any>;
    isPageable: boolean;
    isToggleable: boolean;
    getRecordKey: (record: TableEntry<K>) => Identifier;
    headings: Heading<K>[];
    columns: Column<K>[];
    records: TableRecord<K>[];
    inline: boolean;
    bulk: Executable<BulkOperation>[];
    page: Executable<PageOperation>[];
    pages: PageOption[];
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
