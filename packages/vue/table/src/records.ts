import type { VisitOptions } from "@inertiajs/core";
import type { RecordBinding, Executable, InlineOperation } from "@honed/action";
import type { HonedColumn } from "./columns";

export type Identifier = string | number;

export interface Classes {
	classes?: string;
}

export type TableEntry<T extends Record<string, any> = Record<string, any>> = {
	[K in keyof T]: {
		v: T[K];
		e: any;
		c: string | null;
		f: boolean;
	};
} & Classes;

export interface TableRecord<
	T extends Record<string, any> = Record<string, any>,
> {
	operations: Executable<InlineOperation>[];
	classes: string | null;
	default: (options?: VisitOptions) => void;
	select: () => void;
	deselect: () => void;
	toggle: () => void;
	selected: boolean;
	bind: () => RecordBinding<Identifier>;
	entry: (column: HonedColumn<T> | string) => TableEntry<T>[keyof T] | null;
	value: (
		column: HonedColumn<T> | string,
	) => TableEntry<T>[keyof T]["v"] | null;
	extra: (
		column: HonedColumn<T> | string,
	) => TableEntry<T>[keyof T]["e"] | null;
}

export interface TableOptions<
	T extends Record<string, any> = Record<string, any>,
> extends VisitOptions {
	/**
	 * Mappings of operations to be applied on a record in JavaScript.
	 */
	recordOperations?: Record<string, (record: TableEntry<T>) => void>;
}
