import type { VisitOptions } from "@inertiajs/core";
import type { Executable, InlineOperation } from "@honed/action";
import type { Column } from "./columns";

export type Identifier = string | number;

export type TableEntry<T extends Record<string, any> = any> = {
	[K in keyof T]: {
		v: T[K];
		e: any;
		c: string | null;
		f: boolean;
	};
};

export interface TableRecord<
	T extends Record<string, any> = Record<string, any>,
> {
	operations: Executable<InlineOperation>[];
	default: (options?: VisitOptions) => void;
	select: () => void;
	deselect: () => void;
	toggle: () => void;
	selected: boolean;
	bind: () => any;
	entry: (column: Column<T> | string) => TableEntry<T>[keyof T] | null;
	value: (column: Column<T> | string) => TableEntry<T>[keyof T]["v"] | null;
	extra: (column: Column<T> | string) => TableEntry<T>[keyof T]["e"] | null;
}

export interface TableOptions<
	T extends Record<string, any> = Record<string, any>,
> extends VisitOptions {
	/**
	 * Mappings of operations to be applied on a record in JavaScript.
	 */
	recordOperations?: Record<string, (record: TableEntry<T>) => void>;
}
