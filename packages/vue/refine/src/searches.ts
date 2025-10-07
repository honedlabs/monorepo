import type { PromisifyFn } from "@vueuse/shared";
import type { Refiner } from "./refiner";
import { ApplyOptions } from "./types";

export interface Search extends Refiner {}

export interface HonedSearch extends Search {
	apply: (options?: ApplyOptions) => void;
	clear: (options?: ApplyOptions) => void;
	bind: () => MatchBinding | void;
}

export interface SearchBinding {
	"onUpdate:modelValue": PromisifyFn<
		(value: string | null | undefined) => void
	>;
	modelValue: string;
}

export interface MatchBinding {
	"onUpdate:modelValue": PromisifyFn<(value: any) => void>;
	modelValue: boolean;
	value: string;
}
