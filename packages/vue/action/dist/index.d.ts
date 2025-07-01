import { ComputedRef } from 'vue';
import { Method } from '@inertiajs/core';
import { Ref } from 'vue';
import { VisitOptions } from '@inertiajs/core';

export declare interface Batch {
    id?: string;
    endpoint?: string;
    inline: InlineOperation[];
    bulk: BulkOperation[];
    page: PageOperation[];
}

export declare interface Binding {
    "onUpdate:modelValue": (value: boolean | "indeterminate") => void;
    modelValue: boolean;
}

export declare interface Bulk<T = any> {
    allSelected: ComputedRef<boolean>;
    selection: Ref<BulkSelection<T>>;
    hasSelected: ComputedRef<boolean>;
    selectAll: () => void;
    deselectAll: () => void;
    select: (...records: T[]) => void;
    deselect: (...records: T[]) => void;
    toggle: (record: T, force?: boolean) => void;
    selected: (record: T) => boolean;
    bind: (key: T) => RecordBinding<T>;
    bindAll: () => Binding;
}

export declare interface BulkOperation extends Operation {
    keep: boolean;
}

export declare interface BulkOperationData extends Record<string, any> {
    all: boolean;
    only: Identifier[];
    except: Identifier[];
}

export declare interface BulkSelection<T = any> {
    all: boolean;
    only: Set<T>;
    except: Set<T>;
}

export declare interface Confirm {
    title: string;
    description: string | null;
    dismiss: string;
    submit: string;
    intent: "constructive" | "destructive" | "informative" | string;
}

export declare type Executable<T extends Operation> = T & {
    execute: (data?: OperationData<T>, options?: VisitOptions) => boolean;
};

/**
 * Create operations with execute methods
 */
export declare function executables<T extends Operations>(operations: T[], defaults?: VisitOptions, payload?: OperationData<T>): (T & {
    execute: (data?: OperationData<T>, options?: VisitOptions) => boolean;
})[];

/**
 * Execute an operation with full type safety.
 */
export declare function execute<T extends Operations>(operation: T, data?: OperationData<T>, options?: VisitOptions): boolean;

export declare interface HonedBatch {
    inline: ComputedRef<Executable<InlineOperation>[]>;
    bulk: ComputedRef<Executable<BulkOperation>[]>;
    page: ComputedRef<Executable<PageOperation>[]>;
    executeInline: (operation: InlineOperation, data: InlineOperationData, options?: VisitOptions) => boolean;
    executeBulk: (operation: BulkOperation, data: BulkOperationData, options?: VisitOptions) => boolean;
    executePage: (operation: PageOperation, data?: PageOperationData, options?: VisitOptions) => boolean;
}

export declare type Identifier = string | number;

export declare interface InlineOperation extends Operation {
    default: boolean;
}

export declare interface InlineOperationData extends Record<string, any> {
    record: Identifier;
}

export declare interface Operation {
    name: string;
    label: string;
    icon?: string;
    confirm?: Confirm;
    type?: OperationType;
    href?: string;
    method?: Method;
    target?: string;
}

export declare type OperationData<T extends Operation> = T extends InlineOperation ? InlineOperationData : T extends BulkOperation ? BulkOperationData : PageOperationData;

export declare type Operations = InlineOperation | BulkOperation | PageOperation;

export declare type OperationType = "inertia" | "anchor";

export declare interface PageOperation extends Operation {
}

export declare interface PageOperationData extends Record<string, any> {
}

export declare interface RecordBinding<T = any> extends Binding {
    value: T;
}

export declare interface Route {
    url: string;
    method: Method;
}

export declare type UseBatch = typeof useBatch;

export declare function useBatch<T extends Record<string, Batch>>(props: T, key: keyof T, defaults?: VisitOptions): HonedBatch;

export declare type UseBulk = typeof useBulk;

export declare function useBulk<T = any>(): Bulk<T>;

export { }
