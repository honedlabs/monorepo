import type { VisitOptions } from "@inertiajs/core";
import type { RecordBinding, InlineOperation } from "@honed/action";
import type { Column } from "./columns";

export type Identifier = string | number;

export type TableEntry<T extends Record<string, any> = Record<string, any>> = {
	[K in keyof T]: {
		v: T[K];
		e: any;
		c: string | null;
		f: boolean;
	};
} & {
	_key: Identifier;
	class: string | null;
};

export type TableRecord<T extends Record<string, any> = Record<string, any>> =
	TableEntry<T> & {
		operations: (InlineOperation & {
			execute: (options?: VisitOptions) => void;
		})[];
		selected: boolean;
		default: (options?: VisitOptions) => void;
		select: () => void;
		deselect: () => void;
		toggle: () => void;
		bind: () => RecordBinding<Identifier>;
		entry: (column: Column<T> | string) => TableEntry<T>[keyof T] | null;
		value: (column: Column<T> | string) => TableEntry<T>[keyof T]["v"] | null;
		extra: (column: Column<T> | string) => TableEntry<T>[keyof T]["e"] | null;
	};

export interface TableOptions<
	T extends Record<string, any> = Record<string, any>,
> extends VisitOptions {
	/**
	 * Mappings of operations to be applied on a record in JavaScript.
	 */
	recordOperations?: Record<string, (record: TableEntry<T>) => void>;
}
