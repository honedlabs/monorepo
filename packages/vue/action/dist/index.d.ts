import { ComputedRef } from 'vue';
import { Method } from '@inertiajs/core';
import { Ref } from 'vue';
import { VisitOptions } from '@inertiajs/core';

export declare interface Action {
    name: string;
    label: string;
    type: ActionType;
    action?: boolean;
    extra?: Record<string, unknown>;
    icon?: string;
    confirm?: Confirm;
    route?: Route;
}

export declare type ActionType = "inline" | "page" | "bulk";

export declare interface BulkAction extends Action {
    type: "bulk";
    keepSelected: boolean;
}

export declare interface BulkActionData extends Record<string, any> {
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

/**
 * Execute the action.
 */
export declare function executeAction<T extends ActionType = any>(action: T extends "inline" ? InlineAction : T extends "bulk" ? BulkAction : T extends "page" ? PageAction : Action, endpoint?: string, data?: T extends "inline" ? InlineActionData : T extends "bulk" ? BulkActionData : Record<string, any>, options?: VisitOptions): boolean;

export declare type Identifier = string | number;

export declare interface InlineAction extends Action {
    type: "inline";
    default: boolean;
}

export declare interface InlineActionData extends Record<string, any> {
    id: Identifier;
}

export declare interface PageAction extends Action {
    type: "page";
}

declare interface Route {
    href: string;
    method: Method;
}

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
