import type { VisitOptions } from "@inertiajs/core";
import type { PromisifyFn } from "@vueuse/shared";
import type { Refiner } from "./refiner";

export type Direction = "asc" | "desc" | null;

export interface Sort extends Refiner {
	type: "sort" | string;
	direction: Direction;
	next: string | null;
}

export interface HonedSort extends Sort {
	apply: (options?: VisitOptions) => void;
	clear: (options?: VisitOptions) => void;
	bind: () => SortBinding | void;
}

export interface SortBinding {
    onClick: PromisifyFn<() => void>;
}