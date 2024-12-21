import { usePage } from "@inertiajs/vue3";
import { type Page } from "@inertiajs/core";

const page = usePage() as Page<{ auth: { abilities: Record<string, any> } }>;

export const can = (ability: string, resource: any = null): boolean =>
	(resource
		? page.props.auth.abilities[ability][resource]
		: page.props.auth.abilities[ability]) ?? false;

export const canAny = (
	abilities: string | string[],
	resource: any = null,
): boolean =>
	Array.isArray(abilities)
		? abilities.some((ability) => can(ability, resource))
		: can(abilities, resource);
