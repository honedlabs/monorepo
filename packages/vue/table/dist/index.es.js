import { ref as ee, computed as f, toValue as X, reactive as te } from "vue";
import { router as k } from "@inertiajs/vue3";
import Y from "axios";
function Q(l, m = {}, i = {}) {
  if (!l.href || !l.method)
    return !1;
  if (l.type === "inertia")
    l.method === "delete" ? k.delete(l.href, i) : k[l.method](l.href, m, i);
  else {
    const u = (p) => {
      var o;
      return (o = i.onError) == null ? void 0 : o.call(i, p);
    };
    l.method === "get" ? window.location.href = l.href : l.method === "delete" ? Y.delete(l.href).catch(u) : Y[l.method](l.href, m).catch(u);
  }
  return !0;
}
function ne() {
  const l = ee({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function m() {
    l.value.all = !0, l.value.only.clear(), l.value.except.clear();
  }
  function i() {
    l.value.all = !1, l.value.only.clear(), l.value.except.clear();
  }
  function u(...v) {
    v.forEach((h) => l.value.except.delete(h)), v.forEach((h) => l.value.only.add(h));
  }
  function p(...v) {
    v.forEach((h) => l.value.except.add(h)), v.forEach((h) => l.value.only.delete(h));
  }
  function o(v, h) {
    if (b(v) || h === !1) return p(v);
    if (!b(v) || h === !0) return u(v);
  }
  function b(v) {
    return l.value.all ? !l.value.except.has(v) : l.value.only.has(v);
  }
  const c = f(() => l.value.all && l.value.except.size === 0), _ = f(() => l.value.only.size > 0 || c.value);
  function S(v) {
    return {
      "onUpdate:modelValue": (h) => {
        h ? u(v) : p(v);
      },
      modelValue: b(v),
      value: v
    };
  }
  function x() {
    return {
      "onUpdate:modelValue": (v) => {
        v ? m() : i();
      },
      modelValue: c.value
    };
  }
  return {
    allSelected: c,
    selection: l,
    hasSelected: _,
    selectAll: m,
    deselectAll: i,
    select: u,
    deselect: p,
    toggle: o,
    selected: b,
    bind: S,
    bindAll: x
  };
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const Z = () => {
};
function le(l, m) {
  function i(...u) {
    return new Promise((p, o) => {
      Promise.resolve(l(() => m.apply(this, u), { fn: m, thisArg: this, args: u })).then(p).catch(o);
    });
  }
  return i;
}
function ae(l, m = {}) {
  let i, u, p = Z;
  const o = (c) => {
    clearTimeout(c), p(), p = Z;
  };
  let b;
  return (c) => {
    const _ = X(l), S = X(m.maxWait);
    return i && o(i), _ <= 0 || S !== void 0 && S <= 0 ? (u && (o(u), u = null), Promise.resolve(c())) : new Promise((x, v) => {
      p = m.rejectOnCancel ? v : x, b = c, S && !u && (u = setTimeout(() => {
        i && o(i), u = null, x(b());
      }, S)), i = setTimeout(() => {
        u && o(u), u = null, x(c());
      }, _);
    });
  };
}
function I(l, m = 200, i = {}) {
  return le(
    ae(m, i),
    l
  );
}
function re(l, m, i = {}) {
  if (!(l != null && l[m]))
    throw new Error("The refine must be provided with valid props and key.");
  const u = f(() => l[m]), p = f(() => !!u.value._sort_key), o = f(() => !!u.value._search_key), b = f(() => !!u.value._match_key), c = f(
    () => {
      var t;
      return (t = u.value.filters) == null ? void 0 : t.map((n) => ({
        ...n,
        apply: (r, d = {}) => V(n, r, d),
        clear: (r = {}) => O(n, r),
        bind: () => F(n.name)
      }));
    }
  ), _ = f(
    () => {
      var t;
      return (t = u.value.sorts) == null ? void 0 : t.map((n) => ({
        ...n,
        apply: (r = {}) => T(n, n.direction, r),
        clear: (r = {}) => W(r),
        bind: () => z(n)
      }));
    }
  ), S = f(
    () => {
      var t;
      return (t = u.value.searches) == null ? void 0 : t.map((n) => ({
        ...n,
        apply: (r = {}) => w(n, r),
        clear: (r = {}) => w(n, r),
        bind: () => H(n)
      }));
    }
  ), x = f(
    () => c.value.filter(({ active: t }) => t)
  ), v = f(
    () => _.value.find(({ active: t }) => t)
  ), h = f(
    () => S.value.filter(({ active: t }) => t)
  );
  function j(t) {
    return Array.isArray(t) ? t.join(u.value._delimiter) : t;
  }
  function R(t) {
    return typeof t != "string" ? t : t.trim().replace(/\s+/g, "+");
  }
  function A(t) {
    if (!["", null, void 0, []].includes(t))
      return t;
  }
  function $(t) {
    return [j, R, A].reduce(
      (n, r) => r(n),
      t
    );
  }
  function B(t, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(t) ? n.filter((r) => r !== t) : [...n, t];
  }
  function M(t) {
    return typeof t != "string" ? t : c.value.find(({ name: n }) => n === t);
  }
  function U(t, n = null) {
    return typeof t != "string" ? t : _.value.find(
      ({ name: r, direction: d }) => r === t && d === n
    );
  }
  function C(t) {
    return typeof t != "string" ? t : S.value.find(({ name: n }) => n === t);
  }
  function J(t) {
    return t ? typeof t == "string" ? x.value.some((n) => n.name === t) : t.active : !!x.value.length;
  }
  function N(t) {
    var n;
    return t ? typeof t == "string" ? ((n = v.value) == null ? void 0 : n.name) === t : t.active : !!v.value;
  }
  function D(t) {
    var n;
    return t ? typeof t == "string" ? (n = h.value) == null ? void 0 : n.some((r) => r.name === t) : t.active : !!u.value.term;
  }
  function y(t, n = {}) {
    const r = Object.fromEntries(
      Object.entries(t).map(([d, e]) => [d, $(e)])
    );
    k.reload({
      ...i,
      ...n,
      data: r
    });
  }
  function V(t, n, r = {}) {
    const d = M(t);
    if (!d) return console.warn(`Filter [${t}] does not exist.`);
    k.reload({
      ...i,
      ...r,
      data: {
        [d.name]: $(n)
      }
    });
  }
  function T(t, n = null, r = {}) {
    if (!p.value)
      return console.warn("Refine cannot perform sorting.");
    const d = U(t, n);
    if (!d) return console.warn(`Sort [${t}] does not exist.`);
    k.reload({
      ...i,
      ...r,
      data: {
        [u.value._sort_key]: A(d.next)
      }
    });
  }
  function g(t, n = {}) {
    if (!o.value)
      return console.warn("Refine cannot perform searching.");
    t = [R, A].reduce(
      (r, d) => d(r),
      t
    ), k.reload({
      ...i,
      ...n,
      data: {
        [u.value._search_key]: t
      }
    });
  }
  function w(t, n = {}) {
    if (!b.value || !o.value)
      return console.warn("Refine cannot perform matching.");
    const r = C(t);
    if (!r) return console.warn(`Match [${t}] does not exist.`);
    const d = B(
      r.name,
      h.value.map(({ name: e }) => e)
    );
    k.reload({
      ...i,
      ...n,
      data: {
        [u.value._match_key]: j(d)
      }
    });
  }
  function O(t, n = {}) {
    if (t) return V(t, null, n);
    k.reload({
      ...i,
      ...n,
      data: Object.fromEntries(
        x.value.map(({ name: r }) => [r, null])
      )
    });
  }
  function W(t = {}) {
    if (!p.value)
      return console.warn("Refine cannot perform sorting.");
    k.reload({
      ...i,
      ...t,
      data: {
        [u.value._sort_key]: null
      }
    });
  }
  function G(t = {}) {
    g(null, t);
  }
  function K(t = {}) {
    if (!b.value)
      return console.warn("Refine cannot perform matching.");
    k.reload({
      ...i,
      ...t,
      data: {
        [u.value._match_key]: null
      }
    });
  }
  function E(t = {}) {
    var n;
    k.reload({
      ...i,
      ...t,
      data: {
        [u.value._search_key ?? ""]: void 0,
        [u.value._sort_key ?? ""]: void 0,
        [u.value._match_key ?? ""]: void 0,
        ...Object.fromEntries(
          ((n = u.value.filters) == null ? void 0 : n.map((r) => [
            r.name,
            void 0
          ])) ?? []
        )
      }
    });
  }
  function F(t, n = {}) {
    const r = M(t);
    if (!r) return console.warn(`Filter [${t}] does not exist.`);
    const {
      debounce: d = 150,
      transform: e = (s) => s,
      ...a
    } = n;
    return {
      "onUpdate:modelValue": I((s) => {
        V(r, e(s), a);
      }, d),
      modelValue: r.value
    };
  }
  function z(t, n = {}) {
    if (!p.value)
      return console.warn("Refine cannot perform sorting.");
    const r = U(t);
    if (!r) return console.warn(`Sort [${t}] does not exist.`);
    const { debounce: d = 0, transform: e, ...a } = n;
    return {
      onClick: I(() => {
        var s;
        T(r, (s = v.value) == null ? void 0 : s.direction, a);
      }, d)
    };
  }
  function q(t = {}) {
    if (!o.value)
      return console.warn("Refine cannot perform searching.");
    const { debounce: n = 700, transform: r, ...d } = t;
    return {
      "onUpdate:modelValue": I(
        (e) => {
          g(e, d);
        },
        n
      ),
      modelValue: u.value.term ?? ""
    };
  }
  function H(t, n = {}) {
    if (!b.value)
      return console.warn("Refine cannot perform matching.");
    const r = C(t);
    if (!r) return console.warn(`Match [${t}] does not exist.`);
    const { debounce: d = 0, transform: e, ...a } = n;
    return {
      "onUpdate:modelValue": I((s) => {
        w(s, a);
      }, d),
      modelValue: D(r),
      value: r.name
    };
  }
  return {
    filters: c,
    sorts: _,
    searches: S,
    currentFilters: x,
    currentSort: v,
    currentSearches: h,
    isSortable: p,
    isSearchable: o,
    isMatchable: b,
    isFiltering: J,
    isSorting: N,
    isSearching: D,
    getFilter: M,
    getSort: U,
    getSearch: C,
    apply: y,
    applyFilter: V,
    applySort: T,
    applySearch: g,
    applyMatch: w,
    clearFilter: O,
    clearSort: W,
    clearSearch: G,
    clearMatch: K,
    reset: E,
    bindFilter: F,
    bindSort: z,
    bindSearch: q,
    bindMatch: H,
    stringValue: R,
    omitValue: A,
    toggleValue: B,
    delimitArray: j
  };
}
function ce(l, m, i = {}) {
  if (!(l != null && l[m]))
    throw new Error("The table must be provided with valid props and key.");
  const { recordOperations: u = {}, ...p } = {
    only: [...i.only ?? [], m.toString()],
    ...i
  }, o = f(() => l[m]), b = f(() => o.value._id), c = ne(), _ = re(l, m, p), S = f(() => o.value.meta), x = f(() => o.value.views ?? []), v = f(() => o.value.state ?? null), h = f(() => o.value.placeholder ?? null), j = f(() => !!o.value.state), R = f(
    () => !!o.value._page_key && !!o.value._record_key
  ), A = f(() => !!o.value._column_key), $ = f(
    () => o.value.columns.filter(({ active: e, hidden: a }) => e && !a).map((e) => {
      var a;
      return {
        ...e,
        isSorting: !!((a = e.sort) != null && a.active),
        toggleSort: (s = {}) => _.applySort(e.sort, null, s)
      };
    })
  ), B = f(
    () => o.value.columns.filter(({ hidden: e }) => !e).map((e) => ({
      ...e,
      toggle: (a = {}) => t(e.name, a)
    }))
  ), M = f(
    () => o.value.records.map((e) => ({
      ...e,
      /** The operations available for the record */
      operations: e.operations.map((a) => ({
        ...a,
        execute: (s = {}) => F(a, e, s)
      })),
      /** Determine if the record is selected */
      selected: c.selected(g(e)),
      /** Perform this operation when the record is clicked */
      default: (a = {}) => {
        const s = e.operations.find(
          ({ default: P }) => P
        );
        s && F(s, e, a);
      },
      /** Selects this record */
      select: () => c.select(g(e)),
      /** Deselects this record */
      deselect: () => c.deselect(g(e)),
      /** Toggles the selection of this record */
      toggle: () => c.toggle(g(e)),
      /** Bind the record to a checkbox */
      bind: () => c.bind(g(e)),
      /** Get the entry of the record for the column */
      entry: (a) => w(e, a),
      /** Get the value of the record for the column */
      value: (a) => O(e, a),
      /** Get the extra data of the record for the column */
      extra: (a) => W(e, a)
    }))
  ), U = f(() => !!o.value.operations.inline), C = f(
    () => o.value.operations.bulk.map((e) => ({
      ...e,
      execute: (a = {}) => z(e, a)
    }))
  ), J = f(
    () => o.value.operations.page.map((e) => ({
      ...e,
      execute: (a = {}) => q(e, a)
    }))
  ), N = f(
    () => o.value.pages.find(({ active: e }) => e)
  ), D = f(() => o.value.pages), y = f(() => ({
    ...o.value.paginate,
    next: (e = {}) => {
      "nextLink" in y.value && y.value.nextLink && E(y.value.nextLink, e);
    },
    previous: (e = {}) => {
      "prevLink" in y.value && y.value.prevLink && E(y.value.prevLink, e);
    },
    first: (e = {}) => {
      "firstLink" in y.value && y.value.firstLink && E(y.value.firstLink, e);
    },
    last: (e = {}) => {
      "lastLink" in y.value && y.value.lastLink && E(y.value.lastLink, e);
    },
    ..."links" in o.value.paginate && o.value.paginate.links ? {
      links: o.value.paginate.links.map((e) => ({
        ...e,
        navigate: (a = {}) => e.url && E(e.url, a)
      }))
    } : {}
  })), V = f(
    () => o.value.records.length > 0 && o.value.records.every(
      (e) => c.selected(g(e))
    )
  );
  function T(e) {
    return typeof e == "string" ? e : e.name;
  }
  function g(e) {
    return e._key;
  }
  function w(e, a) {
    const s = T(a);
    return e[s];
  }
  function O(e, a) {
    var s;
    return ((s = w(e, a)) == null ? void 0 : s.v) ?? null;
  }
  function W(e, a) {
    var s;
    return (s = w(e, a)) == null ? void 0 : s.e;
  }
  function G(e) {
    return { id: g(e) };
  }
  function K() {
    return {
      all: c.selection.value.all,
      only: Array.from(c.selection.value.only),
      except: Array.from(c.selection.value.except)
    };
  }
  function E(e, a = {}) {
    k.visit(e, {
      preserveScroll: !0,
      preserveState: !0,
      ...p,
      ...a,
      method: "get"
    });
  }
  function F(e, a, s = {}) {
    var L;
    Q(e, G(a), {
      ...i,
      ...s
    }) || (L = u == null ? void 0 : u[e.name]) == null || L.call(u, a);
  }
  function z(e, a = {}) {
    return Q(e, K(), {
      ...i,
      ...a,
      onSuccess: (s) => {
        var P, L;
        (P = a.onSuccess) == null || P.call(a, s), (L = i.onSuccess) == null || L.call(i, s), e.keep || c.deselectAll();
      }
    });
  }
  function q(e, a = {}, s = {}) {
    return Q(e, a, { ...i, ...s });
  }
  function H(e, a = {}) {
    if (!R.value)
      return console.warn("The table does not support pagination changes.");
    k.reload({
      ...p,
      ...a,
      data: {
        [o.value._record_key]: e.value,
        [o.value._page_key]: void 0
      }
    });
  }
  function t(e, a = {}) {
    if (!A.value)
      return console.warn("The table does not support column toggling.");
    const s = T(e);
    if (!s) return console.log(`Column [${e}] does not exist.`);
    const P = _.toggleValue(
      s,
      $.value.map(({ name: L }) => L)
    );
    k.reload({
      ...p,
      ...a,
      data: {
        [o.value._column_key]: _.delimitArray(P)
      }
    });
  }
  function n() {
    c.select(
      ...o.value.records.map(
        (e) => g(e)
      )
    );
  }
  function r() {
    c.deselect(
      ...o.value.records.map(
        (e) => g(e)
      )
    );
  }
  function d() {
    return {
      "onUpdate:modelValue": (e) => {
        e ? n() : r();
      },
      modelValue: V.value
    };
  }
  return te({
    /** The identifier of the table */
    id: b,
    /** Table-specific metadata */
    meta: S,
    /** The views for the table */
    views: x,
    /** The empty state for the table */
    emptyState: v,
    /** The placeholder for the search term.*/
    placeholder: h,
    /** Whether the table is empty */
    isEmpty: j,
    /** Whether the table supports changing the number of records to display per page */
    isPageable: R,
    /** Whether the table supports toggling columns */
    isToggleable: A,
    /** Get the entry of the record for the column */
    getEntry: w,
    /** Get the value of the record for the column */
    getValue: O,
    /** Get the extra data of the record for the column */
    getExtra: W,
    /** Retrieve a record's identifier */
    getRecordKey: g,
    /** The heading columns for the table */
    headings: $,
    /** All of the table's columns */
    columns: B,
    /** The records of the table */
    records: M,
    /** Whether the table has record operations */
    inline: U,
    /** The available bulk operations */
    bulk: C,
    /** The available page operations */
    page: J,
    /** The available number of records to display per page */
    pages: D,
    /** The current record per page item */
    currentPage: N,
    /** The pagination metadata */
    paginator: y,
    /** Execute an inline operation */
    executeInline: F,
    /** Execute a bulk operation */
    executeBulk: z,
    /** Execute a page operation */
    executePage: q,
    /** The bulk data */
    getBulkData: K,
    /** The record data */
    getRecordData: G,
    /** Apply a new page by changing the number of records to display */
    applyPage: H,
    /** The current selection of records */
    selection: c.selection,
    /** Select the given records */
    select: (e) => c.select(g(e)),
    /** Deselect the given records */
    deselect: (e) => c.deselect(g(e)),
    /** Select records on the current page */
    selectPage: n,
    /** Deselect records on the current page */
    deselectPage: r,
    /** Toggle the selection of the given records */
    toggle: (e) => c.toggle(g(e)),
    /** Determine if the given record is selected */
    selected: (e) => c.selected(g(e)),
    /** Select all records */
    selectAll: c.selectAll,
    /** Deselect all records */
    deselectAll: c.deselectAll,
    /** Whether all records on the current page are selected */
    isPageSelected: V,
    /** Determine if any records are selected */
    hasSelected: c.hasSelected,
    /** Bind the given record to a checkbox */
    bindCheckbox: (e) => c.bind(g(e)),
    /** Bind the select all checkbox to the current page */
    bindPage: d,
    /** Bind select all records to the checkbox */
    bindAll: c.bindAll,
    ..._
  });
}
function se(l, m) {
  return l ? typeof l == "object" ? l.type === m : l === m : !1;
}
export {
  se as is,
  ce as useTable
};
