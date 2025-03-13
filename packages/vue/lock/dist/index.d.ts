export declare function can<T extends Resource = never>(permission: Lock_2<T>, resource?: T extends Resource ? T : null): boolean;

export declare function canAll<T extends Resource = never>(permissions: Lock_2<T> | Lock_2<T>[], resource?: T extends Resource ? T : null): boolean;

export declare function canAny<T extends Resource = never>(permissions: Lock_2<T> | Lock_2<T>[], resource?: T extends Resource ? T : null): boolean;

declare type Lock_2<T extends Resource = never> = T extends Resource ? Permission<T> : string;
export { Lock_2 as Lock }

export declare type Permission<T extends Resource> = keyof T["lock"];

export declare interface Resource {
    lock: Record<string, boolean>;
}

export { }

declare module "@inertiajs/core" {
    interface PageProps {
        lock: Record<string, boolean>;
    }
}
