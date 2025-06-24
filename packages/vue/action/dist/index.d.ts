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

declare type DataMap = {
    inline: InlineOperationData;
    bulk: BulkOperationData;
    page: Record<string, any>;
};

/**
 * Execute an operation with full type safety.
 */
export declare function executeOperation<T extends OperationType>(action: OperationMap[T], endpoint?: string, data?: DataMap[T], options?: VisitOptions): boolean;

export declare type Identifier = string | number;

export declare interface InlineOperation extends Operation {
    type: "inline";
    default: boolean;
}

export declare interface InlineOperationData extends Record<string, any> {
    record: Identifier;
}

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

declare type OperationMap = {
    inline: InlineOperation;
    bulk: BulkOperation;
    page: PageOperation;
};

export declare type OperationType = "inline" | "page" | "bulk";

export declare interface PageOperation extends Operation {
    type: "page";
}

export declare interface Route {
    url: string;
    method: Method;
}

export declare type UseBatch = typeof useBatch;

export declare function useBatch<T extends Record<string, Batch>>(props: T, key: keyof T, defaults?: VisitOptions): {
    inline: (InlineOperation & {
        execute: (data?: InlineOperationData, options?: VisitOptions) => void;
    })[];
    bulk: (BulkOperation & {
        execute: (data?: BulkOperationData, options?: VisitOptions) => void;
    })[];
    page: (PageOperation & {
        execute: (data?: Record<string, any>, options?: VisitOptions) => void;
    })[];
    executeInline: (operation: InlineOperation, data: InlineOperationData, options?: VisitOptions) => void;
    executeBulk: (operation: BulkOperation, data: BulkOperationData, options?: VisitOptions) => void;
    executePage: (operation: PageOperation, data?: Record<string, any>, options?: VisitOptions) => void;
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
