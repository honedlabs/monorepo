import { computed } from "vue";
import type { StatProps, Stat, Overview } from "./types";

export function useStats<T extends StatProps>(props: T): Overview {
	const values = computed<Stat[]>(() =>
		props._values.map((value) => ({
			...value,
			stat: () => getStat(value.name),
		})),
	);

	const statKey = computed(() => props._stat_key);

	function getStat(key: string) {
		return props[key as keyof T];
	}

	return {
		values,
		statKey,
		getStat,
	};
}
