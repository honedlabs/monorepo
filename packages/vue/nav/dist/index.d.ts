import { ComputedRef } from 'vue';

export declare type Nav<T extends NavType = any> = T extends "links" ? NavLink : T extends "items" ? NavItem : T extends "groups" ? NavGroup : T extends "categories" ? NavCategory : NavOption;

declare interface NavBase {
    label: string;
    icon: string | null;
}

export declare interface NavCategory extends NavGroup {
    description: string | null;
}

export declare interface NavGroup extends NavBase {
    items: NavOption[];
}

export declare interface NavItem extends NavLink {
    description: string | null;
}

export declare interface NavLink extends NavBase {
    url: string;
    active: boolean;
}

declare type NavOption = NavLink | NavItem | NavGroup | NavCategory;

declare type NavType = "links" | "items" | "groups" | "categories";

export declare function useNav<T extends NavType = "links">(group?: T): ComputedRef<Nav<T>[]> | ComputedRef<Record<string, Nav<T>[]>>;

export { }


declare module "@inertiajs/core" {
    interface PageProps {
        nav: Record<string, Nav[]>;
    }
}
