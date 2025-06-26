import { Binding } from '@honed/action';
import { BulkOperation } from '@honed/action';
import { BulkSelection } from '@honed/action';
import { Executable } from '@honed/action';
import { HonedRefine } from '@honed/refine';
import { InlineOperation } from '@honed/action';
import { MaybeEndpoint } from '@honed/action';
import { MaybeId } from '@honed/action';
import { PageOperation } from '@honed/action';
import { PageOperationData } from '@honed/action';
import { RecordBinding } from '@honed/action';
import { Refine } from '@honed/refine';
import { Sort } from '@honed/refine';
import { VisitOptions } from '@inertiajs/core';

export declare interface Classes {
    classes?: string;
}

export declare interface CollectionPaginate {
    empty: boolean;
}

export declare interface Column<T extends Record<string, any> = Record<string, any>> {
    name: keyof T;
    label: string;
    type?: ColumnType;
    hidden: boolean;
    active: boolean;
    badge?: boolean;
    toggleable: boolean;
    class?: string;
    icon?: string;
    sort?: Pick<Sort, "active" | "direction" | "next">;
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

export declare interface Heading<T extends Record<string, any> = Record<string, any>> extends Column<T> {
    isSorting: boolean;
    toggleSort: (options?: VisitOptions) => void;
}

export declare interface HonedColumn<T extends Record<string, any> = Record<string, any>> extends Column<T> {
    toggle: (options: VisitOptions) => void;
}

export declare interface HonedTable<T extends Record<string, any> = Record<string, any>, K extends Paginate = "length-aware"> extends HonedRefine {
    id: Exclude<MaybeId, undefined>;
    meta: Record<string, any> | null;
    emptyState: EmptyState | null;
    views: View[];
    placeholder: string | null;
    isEmpty: boolean;
    isPageable: boolean;
    isToggleable: boolean;
    getRecordKey: (record: TableEntry<T>) => Identifier;
    getEntry: (record: TableEntry<T>, column: Column<T> | string) => {
        v: any;
        e: any;
        c: string | null;
        f: boolean;
    } | null;
    getValue: (record: TableEntry<T>, column: Column<T> | string) => any;
    getExtra: (record: TableEntry<T>, column: Column<T> | string) => any;
    headings: Heading<T>[];
    columns: HonedColumn<T>[];
    records: TableRecord<T>[];
    inline: boolean;
    bulk: Executable<BulkOperation>[];
    page: Executable<PageOperation>[];
    pages: PageOption[];
    currentPage: PageOption | undefined;
    paginator: PaginateMap[K];
    executeInline: (operation: InlineOperation, data: TableEntry<T>, options?: VisitOptions) => void;
    executeBulk: (operation: BulkOperation, options?: VisitOptions) => void;
    executePage: (operation: PageOperation, data?: PageOperationData, options?: VisitOptions) => void;
    applyPage: (page: PageOption, options?: VisitOptions) => void;
    selection: BulkSelection<Identifier>;
    select: (record: TableEntry<T>) => void;
    deselect: (record: TableEntry<T>) => void;
    toggle: (record: TableEntry<T>) => void;
    selectPage: () => void;
    deselectPage: () => void;
    selected: (record: TableEntry<T>) => boolean;
    selectAll: () => void;
    deselectAll: () => void;
    isPageSelected: boolean;
    hasSelected: boolean;
    bindCheckbox: (record: TableEntry<T>) => RecordBinding<Identifier>;
    bindPage: () => Binding;
    bindAll: () => Binding;
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
        operations: InlineOperation[];
    }>;
    paginate: PaginateMap[K];
    columns: Column<T>[];
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

export declare type TableEntry<T extends Record<string, any> = Record<string, any>> = {
    [K in keyof T]: {
        v: T[K];
        e: any;
        c: string | null;
        f: boolean;
    };
} & Classes;

export declare interface TableOptions<T extends Record<string, any> = Record<string, any>> extends VisitOptions {
    /**
     * Mappings of operations to be applied on a record in JavaScript.
     */
    recordOperations?: Record<string, (record: TableEntry<T>) => void>;
}

export declare interface TableRecord<T extends Record<string, any> = Record<string, any>> {
    operations: Executable<InlineOperation>[];
    classes: string | null;
    default: (options?: VisitOptions) => void;
    select: () => void;
    deselect: () => void;
    toggle: () => void;
    selected: boolean;
    bind: () => RecordBinding<Identifier>;
    entry: (column: HonedColumn<T> | string) => TableEntry<T>[keyof T] | null;
    value: (column: HonedColumn<T> | string) => TableEntry<T>[keyof T]["v"] | null;
    extra: (column: HonedColumn<T> | string) => TableEntry<T>[keyof T]["e"] | null;
}

export declare type UseTable = typeof useTable;

export declare function useTable<T extends Record<string, Table>, K extends Record<string, any> = Record<string, any>, U extends Paginate = "length-aware">(props: T, key: keyof T, defaults?: TableOptions): HonedTable<K, U>;

export declare interface View {
    id: number;
    name: string;
    view: string;
}

export { }
