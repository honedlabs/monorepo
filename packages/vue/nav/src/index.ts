import { usePage } from "@inertiajs/vue3";
import { computed, type ComputedRef } from "vue";
import { type PageProps } from "@inertiajs/core";

interface NavBase {
	label: string;
	icon: string | null;
}

type NavOption = NavLink | NavItem | NavGroup | NavCategory;

type NavType = "links" | "items" | "groups" | "categories";

export interface NavLink extends NavBase {
	url: string;
	active: boolean;
}

export interface NavItem extends NavLink {
	description: string | null;
}

export interface NavGroup extends NavBase {
	items: NavOption[];
}

export interface NavCategory extends NavGroup {
	description: string | null;
}

export type Nav<T extends NavType = any> = T extends "links"
	? NavLink
	: T extends "items"
		? NavItem
		: T extends "groups"
			? NavGroup
			: T extends "categories"
				? NavCategory
				: NavOption;

const page = usePage<PageProps>();

declare module "@inertiajs/core" {
	interface PageProps {
		nav: Record<string, Nav[]>;
	}
}

export function useNav<T extends NavType = "links">(group?: T) {
	const nav = computed(() => page.props.nav);

	if (group) {
		return computed(() => (nav.value[group] ?? []) as Nav<T>[]);
	}

	return nav as ComputedRef<Record<string, Nav<T>[]>>;
}
