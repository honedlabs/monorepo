import { ref as ee, computed as v, reactive as Z, toValue as X } from "vue";
import { router as b } from "@inertiajs/vue3";
import Y from "axios";
function N(a, m = {}, c = {}) {
  if (!a.href || !a.method)
    return !1;
  if (a.type === "inertia")
    a.method === "delete" ? b.delete(a.href, c) : b[a.method](a.href, m, c);
  else {
    const i = (p) => {
      var u;
      return (u = c.onError) == null ? void 0 : u.call(c, p);
    };
    a.method === "get" ? window.location.href = a.href : a.method === "delete" ? Y.delete(a.href).catch(i) : Y[a.method](a.href, m).catch(i);
  }
  return !0;
}
function te() {
  const a = ee({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function m() {
    a.value.all = !0, a.value.only.clear(), a.value.except.clear();
  }
  function c() {
    a.value.all = !1, a.value.only.clear(), a.value.except.clear();
  }
  function i(...d) {
    d.forEach((h) => a.value.except.delete(h)), d.forEach((h) => a.value.only.add(h));
  }
  function p(...d) {
    d.forEach((h) => a.value.except.add(h)), d.forEach((h) => a.value.only.delete(h));
  }
  function u(d, h) {
    if (s(d) || h === !1) return p(d);
    if (!s(d) || h === !0) return i(d);
  }
  function s(d) {
    return a.value.all ? !a.value.except.has(d) : a.value.only.has(d);
  }
  const r = v(() => a.value.all && a.value.except.size === 0), x = v(() => a.value.only.size > 0 || r.value);
  function k(d) {
    return {
      "onUpdate:modelValue": (h) => {
        h ? i(d) : p(d);
      },
      modelValue: s(d),
      value: d
    };
  }
  function _() {
    return {
      "onUpdate:modelValue": (d) => {
        d ? m() : c();
      },
      modelValue: r.value
    };
  }
  return {
    allSelected: r,
    selection: a,
    hasSelected: x,
    selectAll: m,
    deselectAll: c,
    select: i,
    deselect: p,
    toggle: u,
    selected: s,
    bind: k,
    bindAll: _
  };
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const Q = () => {
};
function ne(a, m) {
  function c(...i) {
    return new Promise((p, u) => {
      Promise.resolve(a(() => m.apply(this, i), { fn: m, thisArg: this, args: i })).then(p).catch(u);
    });
  }
  return c;
}
function le(a, m = {}) {
  let c, i, p = Q;
  const u = (r) => {
    clearTimeout(r), p(), p = Q;
  };
  let s;
  return (r) => {
    const x = X(a), k = X(m.maxWait);
    return c && u(c), x <= 0 || k !== void 0 && k <= 0 ? (i && (u(i), i = null), Promise.resolve(r())) : new Promise((_, d) => {
      p = m.rejectOnCancel ? d : _, s = r, k && !i && (i = setTimeout(() => {
        c && u(c), i = null, _(s());
      }, k)), c = setTimeout(() => {
        i && u(i), i = null, _(r());
      }, x);
    });
  };
}
function q(a, m = 200, c = {}) {
  return ne(
    le(m, c),
    a
  );
}
function ae(a, m, c = {}) {
  if (!(a != null && a[m]))
    throw new Error("The refine must be provided with valid props and key.");
  const i = v(() => a[m]), p = v(() => !!i.value._sort_key), u = v(() => !!i.value._search_key), s = v(() => !!i.value._match_key), r = v(
    () => {
      var t;
      return (t = i.value.filters) == null ? void 0 : t.map((n) => ({
        ...n,
        apply: (o, e = {}) => A(n, o, e),
        clear: (o = {}) => $(n, o),
        bind: () => O(n.name)
      }));
    }
  ), x = v(
    () => {
      var t;
      return (t = i.value.sorts) == null ? void 0 : t.map((n) => ({
        ...n,
        apply: (o = {}) => g(n, n.direction, o),
        clear: (o = {}) => U(o),
        bind: () => W(n)
      }));
    }
  ), k = v(
    () => {
      var t;
      return (t = i.value.searches) == null ? void 0 : t.map((n) => ({
        ...n,
        apply: (o = {}) => F(n, o),
        clear: (o = {}) => F(n, o),
        bind: () => K(n)
      }));
    }
  ), _ = v(
    () => r.value.filter(({ active: t }) => t)
  ), d = v(
    () => x.value.find(({ active: t }) => t)
  ), h = v(
    () => k.value.filter(({ active: t }) => t)
  );
  function P(t) {
    return Array.isArray(t) ? t.join(i.value._delimiter) : t;
  }
  function L(t) {
    return typeof t != "string" ? t : t.trim().replace(/\s+/g, "+");
  }
  function V(t) {
    if (!["", null, void 0, []].includes(t))
      return t;
  }
  function z(t) {
    return [P, L, V].reduce(
      (n, o) => o(n),
      t
    );
  }
  function B(t, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(t) ? n.filter((o) => o !== t) : [...n, t];
  }
  function R(t) {
    return typeof t != "string" ? t : r.value.find(({ name: n }) => n === t);
  }
  function T(t, n = null) {
    return typeof t != "string" ? t : x.value.find(
      ({ name: o, direction: e }) => o === t && e === n
    );
  }
  function j(t) {
    return typeof t != "string" ? t : k.value.find(({ name: n }) => n === t);
  }
  function H(t) {
    return t ? typeof t == "string" ? _.value.some((n) => n.name === t) : t.active : !!_.value.length;
  }
  function I(t) {
    var n;
    return t ? typeof t == "string" ? ((n = d.value) == null ? void 0 : n.name) === t : t.active : !!d.value;
  }
  function y(t) {
    var n;
    return t ? typeof t == "string" ? (n = h.value) == null ? void 0 : n.some((o) => o.name === t) : t.active : !!i.value.term;
  }
  function D(t, n = {}) {
    const o = Object.fromEntries(
      Object.entries(t).map(([e, l]) => [e, z(l)])
    );
    b.reload({
      ...c,
      ...n,
      data: o
    });
  }
  function A(t, n, o = {}) {
    const e = R(t);
    if (!e) return console.warn(`Filter [${t}] does not exist.`);
    b.reload({
      ...c,
      ...o,
      data: {
        [e.name]: z(n)
      }
    });
  }
  function g(t, n = null, o = {}) {
    if (!p.value)
      return console.warn("Refine cannot perform sorting.");
    const e = T(t, n);
    if (!e) return console.warn(`Sort [${t}] does not exist.`);
    b.reload({
      ...c,
      ...o,
      data: {
        [i.value._sort_key]: V(e.next)
      }
    });
  }
  function w(t, n = {}) {
    if (!u.value)
      return console.warn("Refine cannot perform searching.");
    t = [L, V].reduce(
      (o, e) => e(o),
      t
    ), b.reload({
      ...c,
      ...n,
      data: {
        [i.value._search_key]: t
      }
    });
  }
  function F(t, n = {}) {
    if (!s.value || !u.value)
      return console.warn("Refine cannot perform matching.");
    const o = j(t);
    if (!o) return console.warn(`Match [${t}] does not exist.`);
    const e = B(
      o.name,
      h.value.map(({ name: l }) => l)
    );
    b.reload({
      ...c,
      ...n,
      data: {
        [i.value._match_key]: P(e)
      }
    });
  }
  function $(t, n = {}) {
    if (t) return A(t, null, n);
    b.reload({
      ...c,
      ...n,
      data: Object.fromEntries(
        _.value.map(({ name: o }) => [o, null])
      )
    });
  }
  function U(t = {}) {
    if (!p.value)
      return console.warn("Refine cannot perform sorting.");
    b.reload({
      ...c,
      ...t,
      data: {
        [i.value._sort_key]: null
      }
    });
  }
  function G(t = {}) {
    w(null, t);
  }
  function M(t = {}) {
    if (!s.value)
      return console.warn("Refine cannot perform matching.");
    b.reload({
      ...c,
      ...t,
      data: {
        [i.value._match_key]: null
      }
    });
  }
  function C(t = {}) {
    var n;
    b.reload({
      ...c,
      ...t,
      data: {
        [i.value._search_key ?? ""]: void 0,
        [i.value._sort_key ?? ""]: void 0,
        [i.value._match_key ?? ""]: void 0,
        ...Object.fromEntries(
          ((n = i.value.filters) == null ? void 0 : n.map((o) => [
            o.name,
            void 0
          ])) ?? []
        )
      }
    });
  }
  function O(t, n = {}) {
    const o = R(t);
    if (!o) return console.warn(`Filter [${t}] does not exist.`);
    const {
      debounce: e = 150,
      transform: l = (S) => S,
      ...f
    } = n;
    return {
      "onUpdate:modelValue": q((S) => {
        A(o, l(S), f);
      }, e),
      modelValue: o.value
    };
  }
  function W(t, n = {}) {
    if (!p.value)
      return console.warn("Refine cannot perform sorting.");
    const o = T(t);
    if (!o) return console.warn(`Sort [${t}] does not exist.`);
    const { debounce: e = 0, transform: l, ...f } = n;
    return {
      onClick: q(() => {
        var S;
        g(o, (S = d.value) == null ? void 0 : S.direction, f);
      }, e)
    };
  }
  function J(t = {}) {
    if (!u.value)
      return console.warn("Refine cannot perform searching.");
    const { debounce: n = 700, transform: o, ...e } = t;
    return {
      "onUpdate:modelValue": q(
        (l) => {
          w(l, e);
        },
        n
      ),
      modelValue: i.value.term ?? ""
    };
  }
  function K(t, n = {}) {
    if (!s.value)
      return console.warn("Refine cannot perform matching.");
    const o = j(t);
    if (!o) return console.warn(`Match [${t}] does not exist.`);
    const { debounce: e = 0, transform: l, ...f } = n;
    return {
      "onUpdate:modelValue": q((S) => {
        F(S, f);
      }, e),
      modelValue: y(o),
      value: o.name
    };
  }
  return Z({
    filters: r,
    sorts: x,
    searches: k,
    currentFilters: _,
    currentSort: d,
    currentSearches: h,
    isSortable: p,
    isSearchable: u,
    isMatchable: s,
    isFiltering: H,
    isSorting: I,
    isSearching: y,
    getFilter: R,
    getSort: T,
    getSearch: j,
    apply: D,
    applyFilter: A,
    applySort: g,
    applySearch: w,
    applyMatch: F,
    clearFilter: $,
    clearSort: U,
    clearSearch: G,
    clearMatch: M,
    reset: C,
    bindFilter: O,
    bindSort: W,
    bindSearch: J,
    bindMatch: K,
    stringValue: L,
    omitValue: V,
    toggleValue: B,
    delimitArray: P
  });
}
function ue(a, m, c = {}) {
  if (!(a != null && a[m]))
    throw new Error("The table must be provided with valid props and key.");
  const { recordOperations: i = {}, ...p } = {
    only: [...c.only ?? [], m.toString()],
    ...c
  }, u = v(() => a[m]), s = te(), r = ae(a, m, p), x = v(() => u.value.meta), k = v(() => u.value.views ?? []), _ = v(() => u.value.state ?? null), d = v(() => u.value.placeholder ?? null), h = v(() => !!u.value.state), P = v(
    () => !!u.value._page_key && !!u.value._record_key
  ), L = v(() => !!u.value._column_key), V = v(
    () => u.value.columns.filter(({ active: e, hidden: l }) => e && !l).map((e) => {
      var l;
      return {
        ...e,
        isSorting: !!((l = e.sort) != null && l.active),
        toggleSort: (f = {}) => r.applySort(e.sort, null, f)
      };
    })
  ), z = v(
    () => u.value.columns.filter(({ hidden: e }) => !e).map((e) => ({
      ...e,
      toggle: (l = {}) => K(e.name, l)
    }))
  ), B = v(
    () => u.value.records.map((e) => ({
      ...e,
      /** The operations available for the record */
      operations: e.operations.map((l) => ({
        ...l,
        execute: (f = {}) => C(l, e, f)
      })),
      /** Determine if the record is selected */
      selected: s.selected(g(e)),
      /** Perform this operation when the record is clicked */
      default: (l = {}) => {
        const f = e.operations.find(
          ({ default: S }) => S
        );
        f && C(f, e, l);
      },
      /** Selects this record */
      select: () => s.select(g(e)),
      /** Deselects this record */
      deselect: () => s.deselect(g(e)),
      /** Toggles the selection of this record */
      toggle: () => s.toggle(g(e)),
      /** Bind the record to a checkbox */
      bind: () => s.bind(g(e)),
      /** Get the entry of the record for the column */
      entry: (l) => w(e, l),
      /** Get the value of the record for the column */
      value: (l) => F(e, l),
      /** Get the extra data of the record for the column */
      extra: (l) => $(e, l)
    }))
  ), R = v(() => !!u.value.operations.inline), T = v(
    () => u.value.operations.bulk.map((e) => ({
      ...e,
      execute: (l = {}) => O(e, l)
    }))
  ), j = v(
    () => u.value.operations.page.map((e) => ({
      ...e,
      execute: (l = {}) => W(e, l)
    }))
  ), H = v(
    () => u.value.pages.find(({ active: e }) => e)
  ), I = v(() => u.value.pages), y = v(() => ({
    ...u.value.paginate,
    next: (e = {}) => {
      "nextLink" in y.value && y.value.nextLink && M(y.value.nextLink, e);
    },
    previous: (e = {}) => {
      "prevLink" in y.value && y.value.prevLink && M(y.value.prevLink, e);
    },
    first: (e = {}) => {
      "firstLink" in y.value && y.value.firstLink && M(y.value.firstLink, e);
    },
    last: (e = {}) => {
      "lastLink" in y.value && y.value.lastLink && M(y.value.lastLink, e);
    },
    ..."links" in u.value.paginate && u.value.paginate.links ? {
      links: u.value.paginate.links.map((e) => ({
        ...e,
        navigate: (l = {}) => e.url && M(e.url, l)
      }))
    } : {}
  })), D = v(
    () => u.value.records.length > 0 && u.value.records.every(
      (e) => s.selected(g(e))
    )
  );
  function A(e) {
    return typeof e == "string" ? e : e.name;
  }
  function g(e) {
    return e._key;
  }
  function w(e, l) {
    const f = A(l);
    return e[f];
  }
  function F(e, l) {
    var f;
    return ((f = w(e, l)) == null ? void 0 : f.v) ?? null;
  }
  function $(e, l) {
    var f;
    return (f = w(e, l)) == null ? void 0 : f.e;
  }
  function U(e) {
    return { id: g(e) };
  }
  function G() {
    return {
      all: s.selection.value.all,
      only: Array.from(s.selection.value.only),
      except: Array.from(s.selection.value.except)
    };
  }
  function M(e, l = {}) {
    b.visit(e, {
      preserveScroll: !0,
      preserveState: !0,
      ...p,
      ...l,
      method: "get"
    });
  }
  function C(e, l, f = {}) {
    var E;
    N(e, U(l), {
      ...c,
      ...f
    }) || (E = i == null ? void 0 : i[e.name]) == null || E.call(i, l);
  }
  function O(e, l = {}) {
    return N(e, G(), {
      ...c,
      ...l,
      onSuccess: (f) => {
        var S, E;
        (S = l.onSuccess) == null || S.call(l, f), (E = c.onSuccess) == null || E.call(c, f), e.keep || s.deselectAll();
      }
    });
  }
  function W(e, l = {}, f = {}) {
    return N(e, l, { ...c, ...f });
  }
  function J(e, l = {}) {
    if (!P.value)
      return console.warn("The table does not support pagination changes.");
    b.reload({
      ...p,
      ...l,
      data: {
        [u.value._record_key]: e.value,
        [u.value._page_key]: void 0
      }
    });
  }
  function K(e, l = {}) {
    if (!L.value)
      return console.warn("The table does not support column toggling.");
    const f = A(e);
    if (!f) return console.log(`Column [${e}] does not exist.`);
    const S = r.toggleValue(
      f,
      V.value.map(({ name: E }) => E)
    );
    b.reload({
      ...p,
      ...l,
      data: {
        [u.value._column_key]: r.delimitArray(S)
      }
    });
  }
  function t() {
    s.select(
      ...u.value.records.map(
        (e) => g(e)
      )
    );
  }
  function n() {
    s.deselect(
      ...u.value.records.map(
        (e) => g(e)
      )
    );
  }
  function o() {
    return {
      "onUpdate:modelValue": (e) => {
        e ? t() : n();
      },
      modelValue: D.value
    };
  }
  return Z({
    /** Table-specific metadata */
    meta: x,
    /** The views for the table */
    views: k,
    /** The empty state for the table */
    emptyState: _,
    /** The placeholder for the search term.*/
    placeholder: d,
    /** Whether the table is empty */
    isEmpty: h,
    /** Whether the table supports changing the number of records to display per page */
    isPageable: P,
    /** Whether the table supports toggling columns */
    isToggleable: L,
    /** Get the entry of the record for the column */
    getEntry: w,
    /** Get the value of the record for the column */
    getValue: F,
    /** Get the extra data of the record for the column */
    getExtra: $,
    /** Retrieve a record's identifier */
    getRecordKey: g,
    /** The heading columns for the table */
    headings: V,
    /** All of the table's columns */
    columns: z,
    /** The records of the table */
    records: B,
    /** Whether the table has record operations */
    inline: R,
    /** The available bulk operations */
    bulk: T,
    /** The available page operations */
    page: j,
    /** The available number of records to display per page */
    pages: I,
    /** The current record per page item */
    currentPage: H,
    /** The pagination metadata */
    paginator: y,
    /** Execute an inline operation */
    executeInline: C,
    /** Execute a bulk operation */
    executeBulk: O,
    /** Execute a page operation */
    executePage: W,
    /** The bulk data */
    getBulkData: G,
    /** The record data */
    getRecordData: U,
    /** Apply a new page by changing the number of records to display */
    applyPage: J,
    /** The current selection of records */
    selection: s.selection,
    /** Select the given records */
    select: (e) => s.select(g(e)),
    /** Deselect the given records */
    deselect: (e) => s.deselect(g(e)),
    /** Select records on the current page */
    selectPage: t,
    /** Deselect records on the current page */
    deselectPage: n,
    /** Toggle the selection of the given records */
    toggle: (e) => s.toggle(g(e)),
    /** Determine if the given record is selected */
    selected: (e) => s.selected(g(e)),
    /** Select all records */
    selectAll: s.selectAll,
    /** Deselect all records */
    deselectAll: s.deselectAll,
    /** Whether all records on the current page are selected */
    isPageSelected: D,
    /** Determine if any records are selected */
    hasSelected: s.hasSelected,
    /** Bind the given record to a checkbox */
    bindCheckbox: (e) => s.bind(g(e)),
    /** Bind the select all checkbox to the current page */
    bindPage: o,
    /** Bind select all records to the checkbox */
    bindAll: s.bindAll,
    filters: r.filters,
    sorts: r.sorts,
    searches: r.searches,
    currentFilters: r.currentFilters,
    currentSort: r.currentSort,
    currentSearches: r.currentSearches,
    isSortable: r.isSortable,
    isSearchable: r.isSearchable,
    isMatchable: r.isMatchable,
    isFiltering: r.isFiltering,
    isSorting: r.isSorting,
    isSearching: r.isSearching,
    getFilter: r.getFilter,
    getSort: r.getSort,
    getSearch: r.getSearch,
    apply: r.apply,
    applyFilter: r.applyFilter,
    applySort: r.applySort,
    applySearch: r.applySearch,
    applyMatch: r.applyMatch,
    clearFilter: r.clearFilter,
    clearSort: r.clearSort,
    clearSearch: r.clearSearch,
    clearMatch: r.clearMatch,
    reset: r.reset,
    bindFilter: r.bindFilter,
    bindSort: r.bindSort,
    bindSearch: r.bindSearch,
    bindMatch: r.bindMatch,
    stringValue: r.stringValue,
    omitValue: r.omitValue,
    toggleValue: r.toggleValue,
    delimitArray: r.delimitArray
  });
}
function ce(a, m) {
  return a ? typeof a == "object" ? a.type === m : a === m : !1;
}
export {
  ce as is,
  ue as useTable
};
