import type { Ref } from "vue";
import { computed, ref } from "vue";
import type { Bulk, BulkSelection } from "./bulk-types";

export function useBulk<T = any>(): Bulk<T> {
	const selection = ref<BulkSelection<T>>({
		all: false,
		only: new Set(),
		except: new Set(),
	}) as Ref<BulkSelection<T>>;

	/**
	 * Selects all records.
	 */
	function selectAll() {
		selection.value.all = true;
		selection.value.only.clear();
		selection.value.except.clear();
	}

	/**
	 * Deselects all records.
	 */
	function deselectAll() {
		selection.value.all = false;
		selection.value.only.clear();
		selection.value.except.clear();
	}

	/**
	 * Selects the given records.
	 */
	function select(...records: T[]) {
		records.forEach((record) => selection.value.except.delete(record));
		records.forEach((record) => selection.value.only.add(record));
	}

	/**
	 * Deselects the given records.
	 */
	function deselect(...records: T[]) {
		records.forEach((record) => selection.value.except.add(record));
		records.forEach((record) => selection.value.only.delete(record));
	}

	/**
	 * Toggles selection for the given records.
	 */
	function toggle(record: T, force?: boolean) {
		if (selected(record) || force === false) return deselect(record);

		if (!selected(record) || force === true) return select(record);
	}

	/**
	 * Checks whether the given record is selected.
	 */
	function selected(record: T) {
		if (selection.value.all) {
			return !selection.value.except.has(record);
		}

		return selection.value.only.has(record);
	}

	/**
	 * Checks whether all records are selected.
	 */
	const allSelected = computed(() => {
		return selection.value.all && selection.value.except.size === 0;
	});

	/**
	 * Determine whether there are any records selected.
	 */
	const hasSelected = computed(() => {
		return selection.value.only.size > 0 || allSelected.value;
	});

	/**
	 * Binds a checkbox's properties to an individual record.
	 */
	function bind(key: T) {
		return {
			"onUpdate:modelValue": (checked: boolean | "indeterminate") => {
				if (checked) select(key);
				else deselect(key);
			},
			modelValue: selected(key),
			value: key,
		};
	}

	/**
	 * Bind the all checkbox.
	 */
	function bindAll() {
		return {
			"onUpdate:modelValue": (checked: boolean | "indeterminate") => {
				if (checked) selectAll();
				else deselectAll();
			},
			modelValue: allSelected.value,
		};
	}

	return {
		allSelected,
		selection,
		hasSelected,
		selectAll,
		deselectAll,
		select,
		deselect,
		toggle,
		selected,
		bind,
		bindAll,
	};
}
