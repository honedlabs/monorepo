import { ComputedRef } from 'vue';
import { Method } from '@inertiajs/core';
import { Ref } from 'vue';
import { Visit } from '@inertiajs/core';
import { VisitCallbacks } from '@inertiajs/core';
import { VisitOptions } from '@inertiajs/core';

declare interface Batch {
    id?: string;
    endpoint?: string;
    inline: InlineOperation[];
    bulk: BulkOperation[];
    page: PageOperation[];
}

declare interface BulkOperation extends Operation {
    type: "bulk";
    keepSelected: boolean;
}

declare interface BulkOperationData extends Record<string, any> {
    all: boolean;
    only: Identifier[];
    except: Identifier[];
}

export declare interface BulkSelection<T = any> {
    all: boolean;
    only: Set<T>;
    except: Set<T>;
}

declare interface Confirm {
    title: string;
    description: string | null;
    dismiss: string;
    submit: string;
    intent: "constructive" | "destructive" | "informative" | string;
}

declare type DataMap = {
    inline: InlineOperationData;
    bulk: BulkOperationData;
    page: Record<string, any>;
};

/**
 * Create operations with execute methods
 */
export declare function executables<T extends InlineOperation | BulkOperation | PageOperation>(operations: T[], endpoint: MaybeEndpoint, id: MaybeId, defaults?: VisitOptions): (T & {
    execute: (data?: any, options?: VisitOptions) => void;
})[];

/**
 * Execute an operation with full type safety.
 */
export declare function execute<T extends OperationType>(operation: OperationMap[T], endpoint: string | null | undefined, data?: DataMap[T], options?: VisitOptions): boolean;

/**
 * Execute an operation with common logic
 */
export declare function executor(operation: InlineOperation | BulkOperation | PageOperation, endpoint: MaybeEndpoint, id: MaybeId, data?: OperationData, options?: VisitOptions): void;

declare type Identifier = string | number;

declare interface InlineOperation extends Operation {
    type: "inline";
    default: boolean;
}

declare interface InlineOperationData extends Record<string, any> {
    record: Identifier;
}

declare type MaybeEndpoint = string | null | undefined;

declare type MaybeId = string | null | undefined;

declare interface Operation {
    name: string;
    label: string;
    type: OperationType;
    icon?: string;
    extra?: Record<string, unknown>;
    action?: boolean;
    confirm?: Confirm;
    route?: Route;
}

declare type OperationData = InlineOperationData | BulkOperationData | PageOperationData;

declare type OperationMap = {
    inline: InlineOperation;
    bulk: BulkOperation;
    page: PageOperation;
};

declare type OperationType = "inline" | "page" | "bulk";

declare interface PageOperation extends Operation {
    type: "page";
}

declare interface PageOperationData extends Record<string, any> {
}

declare interface Route {
    url: string;
    method: Method;
}

export declare type UseBatch = typeof useBatch;

export declare function useBatch<T extends Record<string, Batch>>(props: T, key: keyof T, defaults?: VisitOptions): {
    inline: (InlineOperation & {
        execute: (data?: any, options?: Partial<Visit & VisitCallbacks>) => void;
    })[];
    bulk: (BulkOperation & {
        execute: (data?: any, options?: Partial<Visit & VisitCallbacks>) => void;
    })[];
    page: (PageOperation & {
        execute: (data?: any, options?: Partial<Visit & VisitCallbacks>) => void;
    })[];
    executeInline: (operation: InlineOperation, data: InlineOperationData, options?: VisitOptions) => void;
    executeBulk: (operation: BulkOperation, data: BulkOperationData, options?: VisitOptions) => void;
    executePage: (operation: PageOperation, data?: PageOperationData, options?: VisitOptions) => void;
};

export declare type UseBulk = typeof useBulk;

export declare function useBulk<T = any>(): {
    allSelected: ComputedRef<boolean>;
    selection: Ref<BulkSelection<T>, BulkSelection<T>>;
    hasSelected: ComputedRef<boolean>;
    selectAll: () => void;
    deselectAll: () => void;
    select: (...records: T[]) => void;
    deselect: (...records: T[]) => void;
    toggle: (record: T, force?: boolean) => void;
    selected: (record: T) => boolean;
    bind: (key: T) => {
        "onUpdate:modelValue": (checked: boolean | "indeterminate") => void;
        modelValue: boolean;
        value: T;
    };
    bindAll: () => {
        "onUpdate:modelValue": (checked: boolean | "indeterminate") => void;
        modelValue: boolean;
    };
};

export { }
