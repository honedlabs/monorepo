import type { VisitOptions } from "@inertiajs/core";
import type { PromisifyFn } from "@vueuse/shared";
import type { Refiner } from "./refiner";

export interface Option {
	label: string;
	value: FilterValue;
	active: boolean;
}

export type FilterType =
	| "boolean"
	| "date"
	| "datetime"
	| "multiple"
	| "number"
	| "select"
	| "text"
	| "time"
	| "trashed"
	| string;

export type FilterValue = string | number | boolean | null;

export interface Filter extends Refiner {
	type: FilterType;
	value: FilterValue;
	options: Option[];
}

export interface HonedFilter extends Filter {
	apply: (value: any, options?: VisitOptions) => void;
	clear: (options?: VisitOptions) => void;
	bind: () => FilterBinding | void;
}

export interface FilterBinding {
	"onUpdate:modelValue": PromisifyFn<(value: any) => void>;
	modelValue: any;
}
