import { usePage } from "@inertiajs/vue3";
import { type Page } from "@inertiajs/core";

const page = usePage() as Page<{ lock: Record<string, boolean> }>;

declare module "@inertiajs/core" {
	interface PageProps {
		lock: Record<string, boolean>;
	}
}

export interface Resource {
	lock: Record<string, boolean>;
}

export type Permission<T extends Resource> = keyof T["lock"];

export type Lock<T extends Resource = never> = T extends Resource
	? Permission<T>
	: string;

export function can<T extends Resource = never>(
	lock: Lock<T>,
	resource: T extends Resource ? T : null = null as never,
): boolean {
	if (resource && "lock" in resource) {
		return resource.lock[lock as string] ?? false;
	}

	return page.props.lock[lock as string] ?? false;
}

export function canAny<T extends Resource = never>(
	locks: Lock<T> | Lock<T>[],
	resource: T extends Resource ? T : null = null as never,
): boolean {
	if (Array.isArray(locks)) {
		return locks.some((lock) => can<T>(lock, resource));
	}

	return can<T>(locks, resource);
}

export function canAll<T extends Resource = never>(
	locks: Lock<T> | Lock<T>[],
	resource: T extends Resource ? T : null = null as never,
): boolean {
	if (Array.isArray(locks)) {
		return locks.every((lock) => can<T>(lock, resource));
	}

	return can<T>(locks, resource);
}
