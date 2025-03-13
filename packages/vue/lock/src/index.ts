import { usePage } from "@inertiajs/vue3";
import { type Page } from "@inertiajs/core";

declare module "@inertiajs/core" {
	interface PageProps {
		lock: Record<string, boolean>;
	}
}

const page = usePage() as Page<{ lock: Record<string, boolean> }>;

export function can(ability: string, resource: any = null): boolean {
	if (resource && "lock" in resource) {
		return resource.lock[ability] ?? false;
	}

	return page.props.lock[ability] ?? false;
}

export function canAny(
	abilities: string | string[],
	resource: any = null,
): boolean {
	if (Array.isArray(abilities)) {
		return abilities.some((ability) => can(ability, resource));
	}

	return can(abilities, resource);
}

export function canAll(
	abilities: string | string[],
	resource: any = null,
): boolean {
	if (Array.isArray(abilities)) {
		return abilities.every((ability) => can(ability, resource));
	}

	return can(abilities, resource);
}
