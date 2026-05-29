import { computed as e } from "vue";
//#region src/stats.ts
function t(t) {
	let n = e(() => t._values.map((e) => ({
		...e,
		stat: () => i(e.name)
	}))), r = e(() => t._stat_key);
	function i(e) {
		return t[e];
	}
	return {
		values: n,
		statKey: r,
		getStat: i
	};
}
//#endregion
export { t as useStats };
