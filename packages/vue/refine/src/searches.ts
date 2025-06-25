import type { VisitOptions } from "@inertiajs/core";
import type { PromisifyFn } from "@vueuse/shared";
import type { Refiner } from "./refiner";

export interface Search extends Refiner { }

export interface HonedSearch extends Search {
	apply: (options?: VisitOptions) => void;
	clear: (options?: VisitOptions) => void;
	bind: () => MatchBinding | void;
}


export interface SearchBinding {
    "onUpdate:modelValue": PromisifyFn<(value: string | null | undefined) => void>;
    modelValue: string;
}

export interface MatchBinding {
    "onUpdate:modelValue": PromisifyFn<(value: any) => void>;
    modelValue: boolean;
    value: string;
}