export declare function can(ability: string, resource?: any): boolean;

export declare function canAll(abilities: string | string[], resource?: any): boolean;

export declare function canAny(abilities: string | string[], resource?: any): boolean;

export { }

declare module "@inertiajs/core" {
    interface PageProps {
        lock: Record<string, boolean>;
    }
}
