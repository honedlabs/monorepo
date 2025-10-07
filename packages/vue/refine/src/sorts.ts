import type { PromisifyFn } from "@vueuse/shared";
import type { Refiner } from "./refiner";
import type { ApplyOptions } from "./types";

export type Direction = "asc" | "desc" | null;

export interface Sort extends Refiner {
	direction: Direction;
	next: string | null;
}

export interface HonedSort extends Sort {
	apply: (options?: ApplyOptions) => void;
	clear: (options?: ApplyOptions) => void;
	bind: () => SortBinding | void;
}

export interface SortBinding {
	onClick: PromisifyFn<() => void>;
}
