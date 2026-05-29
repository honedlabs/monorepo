import { computed as e, ref as t, toValue as n } from "vue";
import { router as r } from "@inertiajs/vue3";
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
var i = () => {};
function a(e, t) {
	function n(...n) {
		return new Promise((r, i) => {
			Promise.resolve(e(() => t.apply(this, n), {
				fn: t,
				thisArg: this,
				args: n
			})).then(r).catch(i);
		});
	}
	return n;
}
function o(e, t = {}) {
	let r, a, o = i, s = (e) => {
		clearTimeout(e), o(), o = i;
	}, c;
	return (i) => {
		let l = n(e), u = n(t.maxWait);
		return r && s(r), l <= 0 || u !== void 0 && u <= 0 ? (a &&= (s(a), null), Promise.resolve(i())) : new Promise((e, n) => {
			o = t.rejectOnCancel ? n : e, c = i, u && !a && (a = setTimeout(() => {
				r && s(r), a = null, e(c());
			}, u)), r = setTimeout(() => {
				a && s(a), a = null, e(i());
			}, l);
		});
	};
}
function s(e, t = 200, n = {}) {
	return a(o(t, n), e);
}
//#endregion
//#region src/refine.ts
function c(n, i, a = {}, o = {}) {
	if (!n?.[i]) throw Error("The refine must be provided with valid props and key.");
	let { onFinish: c, ...l } = a, u = t(!1), d = e(() => n[i]), f = e(() => d.value.term), p = e(() => !!d.value._sort_key), m = e(() => !!d.value._search_key), h = e(() => !!d.value._match_key), g = e(() => d.value.filters?.map((e) => ({
		...e,
		apply: (t, n = {}) => P(e, t, n),
		clear: (t = {}) => R(e, t),
		bind: (t = {}) => U(e.name, t)
	}))), _ = e(() => d.value.sorts?.map((e) => ({
		...e,
		apply: (t = {}) => F(e, e.direction, t),
		clear: (e = {}) => z(e),
		bind: (t = {}) => W(e, t)
	}))), v = e(() => d.value.searches?.map((e) => ({
		...e,
		apply: (t = {}) => L(e, t),
		clear: (t = {}) => L(e, t),
		bind: (t = {}) => K(e, t)
	}))), y = e(() => g.value.filter(({ active: e }) => e)), b = e(() => _.value.find(({ active: e }) => e)), x = e(() => v.value.filter(({ active: e }) => e));
	function S(e) {
		return Array.isArray(e) ? e.join(d.value._delimiter) : e;
	}
	function C(e) {
		return typeof e == "string" ? e.trim().replace(/\s+/g, "+") : e;
	}
	function w(e) {
		if (![
			"",
			null,
			void 0,
			[]
		].includes(e)) return e;
	}
	function T(e) {
		return [
			S,
			C,
			w
		].reduce((e, t) => t(e), e);
	}
	function E(e, t) {
		return t = Array.isArray(t) ? t : [t], t.includes(e) ? t.filter((t) => t !== e) : [...t, e];
	}
	function D(e) {
		return typeof e == "string" ? g.value.find(({ name: t }) => t === e) : e;
	}
	function O(e, t = null) {
		return typeof e == "string" ? _.value.find(({ name: n, direction: r }) => n === e && r === t) : e;
	}
	function k(e) {
		return typeof e == "string" ? v.value.find(({ name: t }) => t === e) : e;
	}
	function A(e) {
		return e ? typeof e == "string" ? y.value.some((t) => t.name === e) : e.active : !!y.value.length;
	}
	function j(e) {
		return e ? typeof e == "string" ? b.value?.name === e : e.active : !!b.value;
	}
	function M(e) {
		return e ? typeof e == "string" ? x.value?.some((t) => t.name === e) : e.active : !!f.value;
	}
	function N(e, t = {}) {
		let n = Object.fromEntries(Object.entries(e).map(([e, t]) => [e, T(t)])), { onFinish: i, ...a } = t;
		u.value = !0, r.reload({
			...l,
			...a,
			data: n,
			onFinish: (e) => {
				u.value = !1, i?.(e), c?.(e);
			}
		});
	}
	function P(e, t, n = {}) {
		let i = D(e);
		if (!i) return console.warn(`Filter [${e}] does not exist.`);
		let { parameters: a, onFinish: s, ...d } = n;
		u.value = !0, r.reload({
			...l,
			...d,
			onFinish: (e) => {
				u.value = !1, s?.(e), c?.(e);
			},
			data: {
				[i.name]: T(t),
				...a,
				...o
			}
		});
	}
	function F(e, t = null, n = {}) {
		if (!p.value) return console.warn("Refine cannot perform sorting.");
		let i = O(e, t);
		if (!i) return console.warn(`Sort [${e}] does not exist.`);
		let { parameters: a, onFinish: o, ...s } = n;
		u.value = !0, r.reload({
			...l,
			...s,
			onFinish: (e) => {
				u.value = !1, o?.(e), c?.(e);
			},
			data: {
				[d.value._sort_key]: w(i.next),
				...a
			}
		});
	}
	function I(e, t = {}) {
		if (!m.value) return console.warn("Refine cannot perform searching.");
		e = [C, w].reduce((e, t) => t(e), e);
		let { parameters: n, onFinish: i, ...a } = t;
		u.value = !0, r.reload({
			...l,
			...a,
			onFinish: (e) => {
				u.value = !1, i?.(e), c?.(e);
			},
			data: {
				[d.value._search_key]: e,
				...n,
				...o
			}
		});
	}
	function L(e, t = {}) {
		if (!h.value || !m.value) return console.warn("Refine cannot perform matching.");
		let n = k(e);
		if (!n) return console.warn(`Match [${e}] does not exist.`);
		let i = E(n.name, x.value.map(({ name: e }) => e)), { parameters: a, onFinish: s, ...f } = t;
		u.value = !0, r.reload({
			...l,
			...f,
			onFinish: (e) => {
				u.value = !1, s?.(e), c?.(e);
			},
			data: {
				[d.value._match_key]: S(i),
				...a,
				...o
			}
		});
	}
	function R(e, t = {}) {
		if (e) return P(e, null, t);
		let { parameters: n, onFinish: i, ...a } = t;
		u.value = !0, r.reload({
			...l,
			...a,
			onFinish: (e) => {
				u.value = !1, i?.(e), c?.(e);
			},
			data: {
				...Object.fromEntries(y.value.map(({ name: e }) => [e, null])),
				...n
			}
		});
	}
	function z(e = {}) {
		if (!p.value) return console.warn("Refine cannot perform sorting.");
		let { parameters: t, onFinish: n, ...i } = e;
		u.value = !0, r.reload({
			...l,
			...i,
			onFinish: (e) => {
				u.value = !1, n?.(e), c?.(e);
			},
			data: {
				[d.value._sort_key]: null,
				...t
			}
		});
	}
	function B(e = {}) {
		I(null, e);
	}
	function V(e = {}) {
		if (!h.value) return console.warn("Refine cannot perform matching.");
		let { parameters: t, onFinish: n, ...i } = e;
		u.value = !0, r.reload({
			...l,
			...i,
			onFinish: (e) => {
				u.value = !1, n?.(e), c?.(e);
			},
			data: {
				[d.value._match_key]: null,
				...t
			}
		});
	}
	function H(e = {}) {
		let { parameters: t, onFinish: n, ...i } = e;
		u.value = !0, r.reload({
			...l,
			...i,
			onFinish: (e) => {
				u.value = !1, n?.(e), c?.(e);
			},
			data: {
				[d.value._search_key ?? ""]: void 0,
				[d.value._sort_key ?? ""]: void 0,
				[d.value._match_key ?? ""]: void 0,
				...Object.fromEntries(d.value.filters?.map((e) => [e.name, void 0]) ?? []),
				...t
			}
		});
	}
	function U(e, t = {}) {
		let n = D(e);
		if (!n) return console.warn(`Filter [${e}] does not exist.`);
		let { debounce: r = 150, transform: i = (e) => e, ...a } = t;
		return {
			"onUpdate:modelValue": s((e) => {
				P(n, i(e), a);
			}, r),
			modelValue: n.value
		};
	}
	function W(e, t = {}) {
		if (!p.value) return console.warn("Refine cannot perform sorting.");
		let n = O(e);
		if (!n) return console.warn(`Sort [${e}] does not exist.`);
		let { debounce: r = 0, transform: i, ...a } = t;
		return { onClick: s(() => {
			F(n, b.value?.direction, a);
		}, r) };
	}
	function G(e = {}) {
		if (!m.value) return console.warn("Refine cannot perform searching.");
		let { debounce: t = 750, transform: n, ...r } = e;
		return {
			"onUpdate:modelValue": s((e) => {
				I(e, r);
			}, t),
			modelValue: f.value ?? ""
		};
	}
	function K(e, t = {}) {
		if (!h.value) return console.warn("Refine cannot perform matching.");
		let n = k(e);
		if (!n) return console.warn(`Match [${e}] does not exist.`);
		let { debounce: r = 0, transform: i, ...a } = t;
		return {
			"onUpdate:modelValue": s((e) => {
				L(e, a);
			}, r),
			modelValue: M(n),
			value: n.name
		};
	}
	return {
		processing: u,
		filters: g,
		sorts: _,
		searches: v,
		currentFilters: y,
		currentSort: b,
		currentSearches: x,
		searchTerm: f,
		isSortable: p,
		isSearchable: m,
		isMatchable: h,
		isFiltering: A,
		isSorting: j,
		isSearching: M,
		getFilter: D,
		getSort: O,
		getSearch: k,
		apply: N,
		applyFilter: P,
		applySort: F,
		applySearch: I,
		applyMatch: L,
		clearFilter: R,
		clearSort: z,
		clearSearch: B,
		clearMatch: V,
		reset: H,
		bindFilter: U,
		bindSort: W,
		bindSearch: G,
		bindMatch: K,
		stringValue: C,
		omitValue: w,
		toggleValue: E,
		delimitArray: S
	};
}
//#endregion
//#region src/utils.ts
function l(e, t) {
	return e ? typeof e == "object" ? e?.type === t : e === t : !1;
}
//#endregion
export { l as is, c as useRefine };
