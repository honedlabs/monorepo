declare interface NavBase {
    label: string;
    icon?: string;
}

export declare interface NavGroup extends NavBase {
    items: NavOption[];
}

export declare interface NavItem extends NavBase {
    href: string;
    active: boolean;
}

declare type NavOption = NavGroup | NavItem;

export declare type NavProps = Record<string, NavOption>;

export declare const useNav: (group?: keyof NavProps) => NavOption | NavProps;

export { }


declare module "@inertiajs/core" {
    interface PageProps {
        nav: NavProps;
    }
}
