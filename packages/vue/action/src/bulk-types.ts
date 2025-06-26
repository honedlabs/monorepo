import type { ComputedRef, Ref } from "vue";

export interface Binding {
	"onUpdate:modelValue": (value: boolean | "indeterminate") => void;
	modelValue: boolean;
}

export interface RecordBinding<T = any> extends Binding {
	value: T;
}

export interface BulkSelection<T = any> {
	all: boolean;
	only: Set<T>;
	except: Set<T>;
}

export interface Bulk<T = any> {
	allSelected: ComputedRef<boolean>;
	selection: Ref<BulkSelection<T>>;
	hasSelected: ComputedRef<boolean>;
	selectAll: () => void;
	deselectAll: () => void;
	select: (...records: T[]) => void;
	deselect: (...records: T[]) => void;
	toggle: (record: T, force?: boolean) => void;
	selected: (record: T) => boolean;
	bind: (key: T) => RecordBinding<T>;
	bindAll: () => Binding;
}
