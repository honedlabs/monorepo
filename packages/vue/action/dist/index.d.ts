import { ComputedRef } from 'vue';
import { Method } from '@inertiajs/core';
import { Ref } from 'vue';
import { VisitOptions } from '@inertiajs/core';

export declare interface Action {
    name: string;
    label: string;
    type: ActionType;
    icon?: string;
    extra?: Record<string, unknown>;
    action?: boolean;
    confirm?: Confirm;
    route?: Route;
}

export declare interface ActionGroup {
    id?: string;
    endpoint?: string;
    inline: InlineAction[];
    bulk: BulkAction[];
    page: PageAction[];
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
    record: Identifier;
}

export declare interface PageAction extends Action {
    type: "page";
}

export declare interface Route {
    url: string;
    method: Method;
}

export declare type UseActions = typeof useActions;

export declare function useActions<Props extends object, Key extends Props[keyof Props] extends ActionGroup ? keyof Props : never>(props: Props, key: Key, defaultOptions?: VisitOptions): {
    inline: {
        execute: (data: InlineActionData, options?: VisitOptions) => void;
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
    bulk: {
        execute: (data: BulkActionData, options?: VisitOptions) => void;
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
    page: {
        execute: (data?: Record<string, any>, options?: VisitOptions) => void;
        type: "page";
        name: string;
        label: string;
        icon?: string | undefined;
        extra?: Record<string, unknown> | undefined;
        action?: boolean | undefined;
        confirm?: Confirm | undefined;
        route?: Route | undefined;
    }[];
    executeInlineAction: (action: InlineAction, data: InlineActionData, options?: VisitOptions) => void;
    executeBulkAction: (action: BulkAction, data: BulkActionData, options?: VisitOptions) => void;
    executePageAction: (action: PageAction, data?: Record<string, any>, options?: VisitOptions) => void;
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
        value: boolean;
    };
};

export { }
