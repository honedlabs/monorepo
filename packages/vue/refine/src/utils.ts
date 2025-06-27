import type { Refiner } from "./types";

/**
 * Check if a refiner is of a given type.
 */
export function is(refiner: Refiner | string | null | undefined, type: string) {
	if (!refiner) return false;

	if (typeof refiner === "object") return refiner?.type === type;

	return refiner === type;
}
