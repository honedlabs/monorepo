import type { VisitOptions } from "@inertiajs/core";
import type { Sort } from "@honed/refine";

export type ColumnType =
	| "array"
	| "badge"
	| "boolean"
	| "color"
	| "date"
	| "datetime"
	| "icon"
	| "image"
	| "numeric"
	| "text"
	| "time"
	| string;

export interface BaseColumn<
	T extends Record<string, any> = Record<string, any>,
> {
	name: keyof T;
	label: string;
	type?: ColumnType;
	hidden: boolean;
	active: boolean;
	badge?: boolean;
	toggleable: boolean;
	class?: string;
	record_class?: string;
	icon?: string;
	sort?: Pick<Sort, "active" | "direction" | "next">;
}

export interface Column<T extends Record<string, any> = Record<string, any>>
	extends BaseColumn<T> {
	toggle: (options: VisitOptions) => void;
}

export interface Heading<T extends Record<string, any> = Record<string, any>>
	extends BaseColumn<T> {
	isSorting: boolean;
	toggleSort: (options: VisitOptions) => void;
}
