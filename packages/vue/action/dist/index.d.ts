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
    type: "bulk";
    keepSelected: boolean;
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
    execute: (data: OperationDataMap[T["type"]], options?: VisitOptions) => boolean;
};

/**
 * Create operations with execute methods
 */
export declare function executables<T extends Operations>(operations: T[], endpoint: MaybeEndpoint, id: MaybeId, defaults?: VisitOptions): (T & {
    execute: (data?: any, options?: VisitOptions) => boolean;
})[];

/**
 * Execute an operation with full type safety.
 */
export declare function execute<T extends Operations>(operation: T, endpoint: string | null | undefined, data: OperationDataMap[typeof operation.type], options?: VisitOptions): boolean;

/**
 * Execute an operation with common logic
 */
export declare function executor(operation: Operations, endpoint: MaybeEndpoint, id: MaybeId, data?: OperationData, options?: VisitOptions): boolean;

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
    type: "inline";
    default: boolean;
}

export declare interface InlineOperationData extends Record<string, any> {
    record: Identifier;
}

export declare type MaybeEndpoint = string | null | undefined;

export declare type MaybeId = string | null | undefined;

export declare interface Operation {
    name: string;
    label: string;
    type: OperationType;
    icon?: string;
    extra?: Record<string, unknown>;
    action?: boolean;
    confirm?: Confirm;
    route?: Route;
}

export declare type OperationData = InlineOperationData | BulkOperationData | PageOperationData;

export declare type OperationDataMap = {
    inline: InlineOperationData;
    bulk: BulkOperationData;
    page: PageOperationData;
};

export declare type OperationMap = {
    inline: InlineOperation;
    bulk: BulkOperation;
    page: PageOperation;
};

export declare type Operations = InlineOperation | BulkOperation | PageOperation;

export declare type OperationType = "inline" | "page" | "bulk";

export declare interface PageOperation extends Operation {
    type: "page";
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
