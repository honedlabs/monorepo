import { computed as e, reactive as t, ref as n, toValue as r } from "vue";
import { router as i } from "@inertiajs/vue3";
import a from "axios";
//#region node_modules/@honed/action/dist/index.es.js
function o(e, t = {}, n = {}) {
	if (!e.href || !e.method) return !1;
	if (console.log(n), e.type === "inertia") e.method === "delete" ? i.delete(e.href, n) : i[e.method](e.href, t, n);
	else {
		let r = (e) => n.onError?.call(n, e);
		e.method === "get" ? window.location.href = e.href : e.method === "delete" ? a.delete(e.href).catch(r) : a[e.method](e.href, t).catch(r);
	}
	return !0;
}
function s() {
	let t = n({
		all: !1,
		only: /* @__PURE__ */ new Set(),
		except: /* @__PURE__ */ new Set()
	});
	function r() {
		t.value.all = !0, t.value.only.clear(), t.value.except.clear();
	}
	function i() {
		t.value.all = !1, t.value.only.clear(), t.value.except.clear();
	}
	function a(...e) {
		e.forEach((e) => t.value.except.delete(e)), e.forEach((e) => t.value.only.add(e));
	}
	function o(...e) {
		e.forEach((e) => t.value.except.add(e)), e.forEach((e) => t.value.only.delete(e));
	}
	function s(e, t) {
		if (c(e) || t === !1) return o(e);
		if (!c(e) || t === !0) return a(e);
	}
	function c(e) {
		return t.value.all ? !t.value.except.has(e) : t.value.only.has(e);
	}
	let l = e(() => t.value.all && t.value.except.size === 0), u = e(() => t.value.only.size > 0 || l.value);
	function d(e) {
		return {
			"onUpdate:modelValue": (t) => {
				t ? a(e) : o(e);
			},
			modelValue: c(e),
			value: e
		};
	}
	function f() {
		return {
			"onUpdate:modelValue": (e) => {
				e ? r() : i();
			},
			modelValue: l.value
		};
	}
	return {
		allSelected: l,
		selection: t,
		hasSelected: u,
		selectAll: r,
		deselectAll: i,
		select: a,
		deselect: o,
		toggle: s,
		selected: c,
		bind: d,
		bindAll: f
	};
}
//#endregion
//#region node_modules/@honed/refine/dist/index.es.js
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
var c = () => {};
function l(e, t) {
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
function u(e, t = {}) {
	let n, i, a = c, o = (e) => {
		clearTimeout(e), a(), a = c;
	}, s;
	return (c) => {
		let l = r(e), u = r(t.maxWait);
		return n && o(n), l <= 0 || u !== void 0 && u <= 0 ? (i &&= (o(i), null), Promise.resolve(c())) : new Promise((e, r) => {
			a = t.rejectOnCancel ? r : e, s = c, u && !i && (i = setTimeout(() => {
				n && o(n), i = null, e(s());
			}, u)), n = setTimeout(() => {
				i && o(i), i = null, e(c());
			}, l);
		});
	};
}
function d(e, t = 200, n = {}) {
	return l(u(t, n), e);
}
function f(t, r, a = {}, o = {}) {
	if (!t?.[r]) throw Error("The refine must be provided with valid props and key.");
	let { onFinish: s, ...c } = a, l = n(!1), u = e(() => t[r]), f = e(() => u.value.term), p = e(() => !!u.value._sort_key), m = e(() => !!u.value._search_key), h = e(() => !!u.value._match_key), g = e(() => u.value.filters?.map((e) => ({
		...e,
		apply: (t, n = {}) => P(e, t, n),
		clear: (t = {}) => R(e, t),
		bind: (t = {}) => U(e.name, t)
	}))), _ = e(() => u.value.sorts?.map((e) => ({
		...e,
		apply: (t = {}) => F(e, e.direction, t),
		clear: (e = {}) => z(e),
		bind: (t = {}) => W(e, t)
	}))), v = e(() => u.value.searches?.map((e) => ({
		...e,
		apply: (t = {}) => L(e, t),
		clear: (t = {}) => L(e, t),
		bind: (t = {}) => K(e, t)
	}))), y = e(() => g.value.filter(({ active: e }) => e)), b = e(() => _.value.find(({ active: e }) => e)), x = e(() => v.value.filter(({ active: e }) => e));
	function S(e) {
		return Array.isArray(e) ? e.join(u.value._delimiter) : e;
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
		let n = Object.fromEntries(Object.entries(e).map(([e, t]) => [e, T(t)])), { onFinish: r, ...a } = t;
		l.value = !0, i.reload({
			...c,
			...a,
			data: n,
			onFinish: (e) => {
				l.value = !1, r?.(e), s?.(e);
			}
		});
	}
	function P(e, t, n = {}) {
		let r = D(e);
		if (!r) return console.warn(`Filter [${e}] does not exist.`);
		let { parameters: a, onFinish: u, ...d } = n;
		l.value = !0, i.reload({
			...c,
			...d,
			onFinish: (e) => {
				l.value = !1, u?.(e), s?.(e);
			},
			data: {
				[r.name]: T(t),
				...a,
				...o
			}
		});
	}
	function F(e, t = null, n = {}) {
		if (!p.value) return console.warn("Refine cannot perform sorting.");
		let r = O(e, t);
		if (!r) return console.warn(`Sort [${e}] does not exist.`);
		let { parameters: a, onFinish: o, ...d } = n;
		l.value = !0, i.reload({
			...c,
			...d,
			onFinish: (e) => {
				l.value = !1, o?.(e), s?.(e);
			},
			data: {
				[u.value._sort_key]: w(r.next),
				...a
			}
		});
	}
	function I(e, t = {}) {
		if (!m.value) return console.warn("Refine cannot perform searching.");
		e = [C, w].reduce((e, t) => t(e), e);
		let { parameters: n, onFinish: r, ...a } = t;
		l.value = !0, i.reload({
			...c,
			...a,
			onFinish: (e) => {
				l.value = !1, r?.(e), s?.(e);
			},
			data: {
				[u.value._search_key]: e,
				...n,
				...o
			}
		});
	}
	function L(e, t = {}) {
		if (!h.value || !m.value) return console.warn("Refine cannot perform matching.");
		let n = k(e);
		if (!n) return console.warn(`Match [${e}] does not exist.`);
		let r = E(n.name, x.value.map(({ name: e }) => e)), { parameters: a, onFinish: d, ...f } = t;
		l.value = !0, i.reload({
			...c,
			...f,
			onFinish: (e) => {
				l.value = !1, d?.(e), s?.(e);
			},
			data: {
				[u.value._match_key]: S(r),
				...a,
				...o
			}
		});
	}
	function R(e, t = {}) {
		if (e) return P(e, null, t);
		let { parameters: n, onFinish: r, ...a } = t;
		l.value = !0, i.reload({
			...c,
			...a,
			onFinish: (e) => {
				l.value = !1, r?.(e), s?.(e);
			},
			data: {
				...Object.fromEntries(y.value.map(({ name: e }) => [e, null])),
				...n
			}
		});
	}
	function z(e = {}) {
		if (!p.value) return console.warn("Refine cannot perform sorting.");
		let { parameters: t, onFinish: n, ...r } = e;
		l.value = !0, i.reload({
			...c,
			...r,
			onFinish: (e) => {
				l.value = !1, n?.(e), s?.(e);
			},
			data: {
				[u.value._sort_key]: null,
				...t
			}
		});
	}
	function B(e = {}) {
		I(null, e);
	}
	function V(e = {}) {
		if (!h.value) return console.warn("Refine cannot perform matching.");
		let { parameters: t, onFinish: n, ...r } = e;
		l.value = !0, i.reload({
			...c,
			...r,
			onFinish: (e) => {
				l.value = !1, n?.(e), s?.(e);
			},
			data: {
				[u.value._match_key]: null,
				...t
			}
		});
	}
	function H(e = {}) {
		let { parameters: t, onFinish: n, ...r } = e;
		l.value = !0, i.reload({
			...c,
			...r,
			onFinish: (e) => {
				l.value = !1, n?.(e), s?.(e);
			},
			data: {
				[u.value._search_key ?? ""]: void 0,
				[u.value._sort_key ?? ""]: void 0,
				[u.value._match_key ?? ""]: void 0,
				...Object.fromEntries(u.value.filters?.map((e) => [e.name, void 0]) ?? []),
				...t
			}
		});
	}
	function U(e, t = {}) {
		let n = D(e);
		if (!n) return console.warn(`Filter [${e}] does not exist.`);
		let { debounce: r = 150, transform: i = (e) => e, ...a } = t;
		return {
			"onUpdate:modelValue": d((e) => {
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
		return { onClick: d(() => {
			F(n, b.value?.direction, a);
		}, r) };
	}
	function G(e = {}) {
		if (!m.value) return console.warn("Refine cannot perform searching.");
		let { debounce: t = 750, transform: n, ...r } = e;
		return {
			"onUpdate:modelValue": d((e) => {
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
			"onUpdate:modelValue": d((e) => {
				L(e, a);
			}, r),
			modelValue: M(n),
			value: n.name
		};
	}
	return {
		processing: l,
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
//#region src/table.ts
function p(n, r, a = {}) {
	if (!n?.[r]) throw Error("The table must be provided with valid props and key.");
	let { recordOperations: c = {}, ...l } = {
		only: [...a.only ?? [], r.toString()],
		...a
	}, u = e(() => n[r]), d = e(() => u.value._id), p = s(), { processing: m, ...h } = f(n, r, l, { [u.value._page_key]: void 0 }), { onFinish: g, ..._ } = l, v = e(() => u.value.meta), y = e(() => u.value.views ?? []), b = e(() => u.value.state ?? null), x = e(() => u.value.placeholder ?? null), S = e(() => !!u.value.state), C = e(() => !!u.value._page_key && !!u.value._record_key), w = e(() => !!u.value._column_key), T = e(() => !!u.value.viewable), E = e(() => u.value.columns.filter(({ active: e, hidden: t }) => e && !t).map((e) => ({
		...e,
		isSorting: !!e.sort?.active,
		toggleSort: (t = {}) => h.applySort(e.sort, null, t)
	}))), D = e(() => u.value.columns.filter(({ hidden: e }) => !e).map((e) => ({
		...e,
		toggle: (t = {}) => J(e.name, t)
	}))), O = e(() => u.value.records.map((e) => ({
		...e,
		operations: e.operations.map((t) => ({
			...t,
			execute: (n = {}) => W(t, e, n)
		})),
		selected: p.selected(L(e)),
		default: (t = {}) => {
			let n = e.operations.find(({ default: e }) => e);
			n && W(n, e, t);
		},
		select: () => p.select(L(e)),
		deselect: () => p.deselect(L(e)),
		toggle: () => p.toggle(L(e)),
		bind: () => p.bind(L(e)),
		entry: (t) => R(e, t),
		value: (t) => z(e, t),
		extra: (t) => B(e, t)
	}))), k = e(() => !!u.value.operations.inline), A = e(() => u.value.operations.bulk.map((e) => ({
		...e,
		execute: (t = {}) => G(e, t)
	}))), j = e(() => u.value.operations.page.map((e) => ({
		...e,
		execute: (t = {}) => K(e, t)
	}))), M = e(() => u.value.pages.find(({ active: e }) => e)), N = e(() => u.value.pages), P = e(() => ({
		...u.value.paginate,
		next: (e = {}) => {
			"nextLink" in P.value && P.value.nextLink && U(P.value.nextLink, e);
		},
		previous: (e = {}) => {
			"prevLink" in P.value && P.value.prevLink && U(P.value.prevLink, e);
		},
		first: (e = {}) => {
			"firstLink" in P.value && P.value.firstLink && U(P.value.firstLink, e);
		},
		last: (e = {}) => {
			"lastLink" in P.value && P.value.lastLink && U(P.value.lastLink, e);
		},
		..."links" in u.value.paginate && u.value.paginate.links ? { links: u.value.paginate.links.map((e) => ({
			...e,
			navigate: (t = {}) => e.url && U(e.url, t)
		})) } : {}
	})), F = e(() => u.value.records.length > 0 && u.value.records.every((e) => p.selected(L(e))));
	function I(e) {
		return typeof e == "string" ? e : e.name;
	}
	function L(e) {
		return e._key;
	}
	function R(e, t) {
		return e[I(t)];
	}
	function z(e, t) {
		return R(e, t)?.v ?? null;
	}
	function B(e, t) {
		return R(e, t)?.e;
	}
	function V(e) {
		return { id: L(e) };
	}
	function H() {
		return {
			all: p.selection.value.all,
			only: Array.from(p.selection.value.only),
			except: Array.from(p.selection.value.except)
		};
	}
	function U(e, t = {}) {
		m.value = !0;
		let { onFinish: n, ...r } = t;
		i.visit(e, {
			preserveScroll: !0,
			preserveState: !0,
			..._,
			...r,
			onFinish: (e) => {
				m.value = !1, g?.(e), n?.(e);
			},
			method: "get"
		});
	}
	function W(e, t, n = {}) {
		o(e, V(t), {
			...a,
			...n
		}) || c?.[e.name]?.(t);
	}
	function G(e, t = {}) {
		return o(e, H(), {
			...a,
			...t,
			onSuccess: (n) => {
				t.onSuccess?.(n), a.onSuccess?.(n), console.log("onSuccess"), e.keep || p.deselectAll();
			}
		});
	}
	function K(e, t = {}, n = {}) {
		return o(e, t, {
			...a,
			...n
		});
	}
	function q(e, t = {}) {
		if (!C.value) return console.warn("The table does not support pagination changes.");
		let { onFinish: n, ...r } = t;
		m.value = !0, i.reload({
			..._,
			...r,
			onFinish: (e) => {
				m.value = !1, g?.(e), n?.(e);
			},
			data: {
				[u.value._record_key]: e.value,
				[u.value._page_key]: void 0
			}
		});
	}
	function J(e, t = {}) {
		if (!w.value) return console.warn("The table does not support column toggling.");
		let n = I(e);
		if (!n) return console.log(`Column [${e}] does not exist.`);
		let r = h.toggleValue(n, E.value.map(({ name: e }) => e)), { onFinish: a, ...o } = t;
		m.value = !0, i.reload({
			..._,
			...o,
			onFinish: (e) => {
				m.value = !1, g?.(e), a?.(e);
			},
			data: { [u.value._column_key]: h.delimitArray(r) }
		});
	}
	function Y() {
		p.select(...u.value.records.map((e) => L(e)));
	}
	function X() {
		p.deselect(...u.value.records.map((e) => L(e)));
	}
	function Z() {
		return {
			"onUpdate:modelValue": (e) => {
				e ? Y() : X();
			},
			modelValue: F.value
		};
	}
	return t({
		id: d,
		meta: v,
		views: y,
		emptyState: b,
		placeholder: x,
		isEmpty: S,
		isPageable: C,
		isToggleable: w,
		isViewable: T,
		getEntry: R,
		getValue: z,
		getExtra: B,
		getRecordKey: L,
		headings: E,
		columns: D,
		records: O,
		inline: k,
		bulk: A,
		page: j,
		pages: N,
		currentPage: M,
		paginator: P,
		executeInline: W,
		executeBulk: G,
		executePage: K,
		getBulkData: H,
		getRecordData: V,
		applyPage: q,
		selection: p.selection,
		select: (e) => p.select(L(e)),
		deselect: (e) => p.deselect(L(e)),
		selectPage: Y,
		deselectPage: X,
		toggle: (e) => p.toggle(L(e)),
		selected: (e) => p.selected(L(e)),
		selectAll: p.selectAll,
		deselectAll: p.deselectAll,
		isPageSelected: F,
		hasSelected: p.hasSelected,
		bindCheckbox: (e) => p.bind(L(e)),
		bindPage: Z,
		bindAll: p.bindAll,
		processing: m,
		...h
	});
}
//#endregion
//#region src/utils.ts
function m(e, t) {
	return e ? typeof e == "object" ? e.type === t : e === t : !1;
}
//#endregion
export { m as is, p as useTable };
