import { ref as ee, computed as s, toValue as X, reactive as te } from "vue";
import { router as _ } from "@inertiajs/vue3";
import Y from "axios";
function Q(l, d = {}, i = {}) {
  if (!l.href || !l.method)
    return !1;
  if (l.type === "inertia")
    l.method === "delete" ? _.delete(l.href, i) : _[l.method](l.href, d, i);
  else {
    const f = (c) => {
      var r;
      return (r = i.onError) == null ? void 0 : r.call(i, c);
    };
    l.method === "get" ? window.location.href = l.href : l.method === "delete" ? Y.delete(l.href).catch(f) : Y[l.method](l.href, d).catch(f);
  }
  return !0;
}
function ne() {
  const l = ee({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function d() {
    l.value.all = !0, l.value.only.clear(), l.value.except.clear();
  }
  function i() {
    l.value.all = !1, l.value.only.clear(), l.value.except.clear();
  }
  function f(...v) {
    v.forEach((g) => l.value.except.delete(g)), v.forEach((g) => l.value.only.add(g));
  }
  function c(...v) {
    v.forEach((g) => l.value.except.add(g)), v.forEach((g) => l.value.only.delete(g));
  }
  function r(v, g) {
    if (b(v) || g === !1) return c(v);
    if (!b(v) || g === !0) return f(v);
  }
  function b(v) {
    return l.value.all ? !l.value.except.has(v) : l.value.only.has(v);
  }
  const u = s(() => l.value.all && l.value.except.size === 0), k = s(() => l.value.only.size > 0 || u.value);
  function S(v) {
    return {
      "onUpdate:modelValue": (g) => {
        g ? f(v) : c(v);
      },
      modelValue: b(v),
      value: v
    };
  }
  function x() {
    return {
      "onUpdate:modelValue": (v) => {
        v ? d() : i();
      },
      modelValue: u.value
    };
  }
  return {
    allSelected: u,
    selection: l,
    hasSelected: k,
    selectAll: d,
    deselectAll: i,
    select: f,
    deselect: c,
    toggle: r,
    selected: b,
    bind: S,
    bindAll: x
  };
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const Z = () => {
};
function ae(l, d) {
  function i(...f) {
    return new Promise((c, r) => {
      Promise.resolve(l(() => d.apply(this, f), { fn: d, thisArg: this, args: f })).then(c).catch(r);
    });
  }
  return i;
}
function le(l, d = {}) {
  let i, f, c = Z;
  const r = (u) => {
    clearTimeout(u), c(), c = Z;
  };
  let b;
  return (u) => {
    const k = X(l), S = X(d.maxWait);
    return i && r(i), k <= 0 || S !== void 0 && S <= 0 ? (f && (r(f), f = null), Promise.resolve(u())) : new Promise((x, v) => {
      c = d.rejectOnCancel ? v : x, b = u, S && !f && (f = setTimeout(() => {
        i && r(i), f = null, x(b());
      }, S)), i = setTimeout(() => {
        f && r(f), f = null, x(u());
      }, k);
    });
  };
}
function H(l, d = 200, i = {}) {
  return ae(
    le(d, i),
    l
  );
}
function re(l, d, i = {}, f = {}) {
  if (!(l != null && l[d]))
    throw new Error("The refine must be provided with valid props and key.");
  const c = s(() => l[d]), r = s(() => c.value.term), b = s(() => !!c.value._sort_key), u = s(() => !!c.value._search_key), k = s(() => !!c.value._match_key), S = s(
    () => {
      var t;
      return (t = c.value.filters) == null ? void 0 : t.map((a) => ({
        ...a,
        apply: (e, n = {}) => p(a, e, n),
        clear: (e = {}) => C(a, e),
        bind: () => B(a.name)
      }));
    }
  ), x = s(
    () => {
      var t;
      return (t = c.value.sorts) == null ? void 0 : t.map((a) => ({
        ...a,
        apply: (e = {}) => w(a, a.direction, e),
        clear: (e = {}) => O(e),
        bind: () => q(a)
      }));
    }
  ), v = s(
    () => {
      var t;
      return (t = c.value.searches) == null ? void 0 : t.map((a) => ({
        ...a,
        apply: (e = {}) => A(a, e),
        clear: (e = {}) => A(a, e),
        bind: () => D(a)
      }));
    }
  ), g = s(
    () => S.value.filter(({ active: t }) => t)
  ), E = s(
    () => x.value.find(({ active: t }) => t)
  ), P = s(
    () => v.value.filter(({ active: t }) => t)
  );
  function L(t) {
    return Array.isArray(t) ? t.join(c.value._delimiter) : t;
  }
  function T(t) {
    return typeof t != "string" ? t : t.trim().replace(/\s+/g, "+");
  }
  function R(t) {
    if (!["", null, void 0, []].includes(t))
      return t;
  }
  function G(t) {
    return [L, T, R].reduce(
      (a, e) => e(a),
      t
    );
  }
  function z(t, a) {
    return a = Array.isArray(a) ? a : [a], a.includes(t) ? a.filter((e) => e !== t) : [...a, t];
  }
  function j(t) {
    return typeof t != "string" ? t : S.value.find(({ name: a }) => a === t);
  }
  function $(t, a = null) {
    return typeof t != "string" ? t : x.value.find(
      ({ name: e, direction: n }) => e === t && n === a
    );
  }
  function M(t) {
    return typeof t != "string" ? t : v.value.find(({ name: a }) => a === t);
  }
  function J(t) {
    return t ? typeof t == "string" ? g.value.some((a) => a.name === t) : t.active : !!g.value.length;
  }
  function y(t) {
    var a;
    return t ? typeof t == "string" ? ((a = E.value) == null ? void 0 : a.name) === t : t.active : !!E.value;
  }
  function U(t) {
    var a;
    return t ? typeof t == "string" ? (a = P.value) == null ? void 0 : a.some((e) => e.name === t) : t.active : !!r.value;
  }
  function I(t, a = {}) {
    const e = Object.fromEntries(
      Object.entries(t).map(([n, o]) => [n, G(o)])
    );
    _.reload({
      ...i,
      ...a,
      data: e
    });
  }
  function p(t, a, e = {}) {
    const n = j(t);
    if (!n) return console.warn(`Filter [${t}] does not exist.`);
    const { parameters: o, ...m } = e;
    _.reload({
      ...i,
      ...m,
      data: {
        [n.name]: G(a),
        ...o,
        ...f
      }
    });
  }
  function w(t, a = null, e = {}) {
    if (!b.value)
      return console.warn("Refine cannot perform sorting.");
    const n = $(t, a);
    if (!n) return console.warn(`Sort [${t}] does not exist.`);
    const { parameters: o, ...m } = e;
    _.reload({
      ...i,
      ...m,
      data: {
        [c.value._sort_key]: R(n.next),
        ...o
      }
    });
  }
  function F(t, a = {}) {
    if (!u.value)
      return console.warn("Refine cannot perform searching.");
    t = [T, R].reduce(
      (o, m) => m(o),
      t
    );
    const { parameters: e, ...n } = a;
    _.reload({
      ...i,
      ...n,
      data: {
        [c.value._search_key]: t,
        ...e,
        ...f
      }
    });
  }
  function A(t, a = {}) {
    if (!k.value || !u.value)
      return console.warn("Refine cannot perform matching.");
    const e = M(t);
    if (!e) return console.warn(`Match [${t}] does not exist.`);
    const n = z(
      e.name,
      P.value.map(({ name: h }) => h)
    ), { parameters: o, ...m } = a;
    _.reload({
      ...i,
      ...m,
      data: {
        [c.value._match_key]: L(n),
        ...o,
        ...f
      }
    });
  }
  function C(t, a = {}) {
    if (t) return p(t, null, a);
    const { parameters: e, ...n } = a;
    _.reload({
      ...i,
      ...n,
      data: {
        ...Object.fromEntries(
          g.value.map(({ name: o }) => [o, null])
        ),
        ...e
      }
    });
  }
  function O(t = {}) {
    if (!b.value)
      return console.warn("Refine cannot perform sorting.");
    const { parameters: a, ...e } = t;
    _.reload({
      ...i,
      ...e,
      data: {
        [c.value._sort_key]: null,
        ...a
      }
    });
  }
  function V(t = {}) {
    F(null, t);
  }
  function W(t = {}) {
    if (!k.value)
      return console.warn("Refine cannot perform matching.");
    const { parameters: a, ...e } = t;
    _.reload({
      ...i,
      ...e,
      data: {
        [c.value._match_key]: null,
        ...a
      }
    });
  }
  function K(t = {}) {
    var a;
    const { parameters: e, ...n } = t;
    _.reload({
      ...i,
      ...n,
      data: {
        [c.value._search_key ?? ""]: void 0,
        [c.value._sort_key ?? ""]: void 0,
        [c.value._match_key ?? ""]: void 0,
        ...Object.fromEntries(
          ((a = c.value.filters) == null ? void 0 : a.map((o) => [
            o.name,
            void 0
          ])) ?? []
        ),
        ...e
      }
    });
  }
  function B(t, a = {}) {
    const e = j(t);
    if (!e) return console.warn(`Filter [${t}] does not exist.`);
    const {
      debounce: n = 150,
      transform: o = (h) => h,
      ...m
    } = a;
    return {
      "onUpdate:modelValue": H((h) => {
        p(e, o(h), m);
      }, n),
      modelValue: e.value
    };
  }
  function q(t, a = {}) {
    if (!b.value)
      return console.warn("Refine cannot perform sorting.");
    const e = $(t);
    if (!e) return console.warn(`Sort [${t}] does not exist.`);
    const { debounce: n = 0, transform: o, ...m } = a;
    return {
      onClick: H(() => {
        var h;
        w(e, (h = E.value) == null ? void 0 : h.direction, m);
      }, n)
    };
  }
  function N(t = {}) {
    if (!u.value)
      return console.warn("Refine cannot perform searching.");
    const { debounce: a = 700, transform: e, ...n } = t;
    return {
      "onUpdate:modelValue": H(
        (o) => {
          F(o, n);
        },
        a
      ),
      modelValue: r.value ?? ""
    };
  }
  function D(t, a = {}) {
    if (!k.value)
      return console.warn("Refine cannot perform matching.");
    const e = M(t);
    if (!e) return console.warn(`Match [${t}] does not exist.`);
    const { debounce: n = 0, transform: o, ...m } = a;
    return {
      "onUpdate:modelValue": H((h) => {
        A(h, m);
      }, n),
      modelValue: U(e),
      value: e.name
    };
  }
  return {
    filters: S,
    sorts: x,
    searches: v,
    currentFilters: g,
    currentSort: E,
    currentSearches: P,
    searchTerm: r,
    isSortable: b,
    isSearchable: u,
    isMatchable: k,
    isFiltering: J,
    isSorting: y,
    isSearching: U,
    getFilter: j,
    getSort: $,
    getSearch: M,
    apply: I,
    applyFilter: p,
    applySort: w,
    applySearch: F,
    applyMatch: A,
    clearFilter: C,
    clearSort: O,
    clearSearch: V,
    clearMatch: W,
    reset: K,
    bindFilter: B,
    bindSort: q,
    bindSearch: N,
    bindMatch: D,
    stringValue: T,
    omitValue: R,
    toggleValue: z,
    delimitArray: L
  };
}
function ce(l, d, i = {}) {
  if (!(l != null && l[d]))
    throw new Error("The table must be provided with valid props and key.");
  const { recordOperations: f = {}, ...c } = {
    only: [...i.only ?? [], d.toString()],
    ...i
  }, r = s(() => l[d]), b = s(() => r.value._id), u = ne(), k = re(l, d, c, {
    [r.value._page_key]: void 0
  }), S = s(() => r.value.meta), x = s(() => r.value.views ?? []), v = s(() => r.value.state ?? null), g = s(() => r.value.placeholder ?? null), E = s(() => !!r.value.state), P = s(
    () => !!r.value._page_key && !!r.value._record_key
  ), L = s(() => !!r.value._column_key), T = s(
    () => r.value.columns.filter(({ active: e, hidden: n }) => e && !n).map((e) => {
      var n;
      return {
        ...e,
        isSorting: !!((n = e.sort) != null && n.active),
        toggleSort: (o = {}) => k.applySort(e.sort, null, o)
      };
    })
  ), R = s(
    () => r.value.columns.filter(({ hidden: e }) => !e).map((e) => ({
      ...e,
      toggle: (n = {}) => N(e.name, n)
    }))
  ), G = s(
    () => r.value.records.map((e) => ({
      ...e,
      /** The operations available for the record */
      operations: e.operations.map((n) => ({
        ...n,
        execute: (o = {}) => W(n, e, o)
      })),
      /** Determine if the record is selected */
      selected: u.selected(p(e)),
      /** Perform this operation when the record is clicked */
      default: (n = {}) => {
        const o = e.operations.find(
          ({ default: m }) => m
        );
        o && W(o, e, n);
      },
      /** Selects this record */
      select: () => u.select(p(e)),
      /** Deselects this record */
      deselect: () => u.deselect(p(e)),
      /** Toggles the selection of this record */
      toggle: () => u.toggle(p(e)),
      /** Bind the record to a checkbox */
      bind: () => u.bind(p(e)),
      /** Get the entry of the record for the column */
      entry: (n) => w(e, n),
      /** Get the value of the record for the column */
      value: (n) => F(e, n),
      /** Get the extra data of the record for the column */
      extra: (n) => A(e, n)
    }))
  ), z = s(() => !!r.value.operations.inline), j = s(
    () => r.value.operations.bulk.map((e) => ({
      ...e,
      execute: (n = {}) => K(e, n)
    }))
  ), $ = s(
    () => r.value.operations.page.map((e) => ({
      ...e,
      execute: (n = {}) => B(e, n)
    }))
  ), M = s(
    () => r.value.pages.find(({ active: e }) => e)
  ), J = s(() => r.value.pages), y = s(() => ({
    ...r.value.paginate,
    next: (e = {}) => {
      "nextLink" in y.value && y.value.nextLink && V(y.value.nextLink, e);
    },
    previous: (e = {}) => {
      "prevLink" in y.value && y.value.prevLink && V(y.value.prevLink, e);
    },
    first: (e = {}) => {
      "firstLink" in y.value && y.value.firstLink && V(y.value.firstLink, e);
    },
    last: (e = {}) => {
      "lastLink" in y.value && y.value.lastLink && V(y.value.lastLink, e);
    },
    ..."links" in r.value.paginate && r.value.paginate.links ? {
      links: r.value.paginate.links.map((e) => ({
        ...e,
        navigate: (n = {}) => e.url && V(e.url, n)
      }))
    } : {}
  })), U = s(
    () => r.value.records.length > 0 && r.value.records.every(
      (e) => u.selected(p(e))
    )
  );
  function I(e) {
    return typeof e == "string" ? e : e.name;
  }
  function p(e) {
    return e._key;
  }
  function w(e, n) {
    const o = I(n);
    return e[o];
  }
  function F(e, n) {
    var o;
    return ((o = w(e, n)) == null ? void 0 : o.v) ?? null;
  }
  function A(e, n) {
    var o;
    return (o = w(e, n)) == null ? void 0 : o.e;
  }
  function C(e) {
    return { id: p(e) };
  }
  function O() {
    return {
      all: u.selection.value.all,
      only: Array.from(u.selection.value.only),
      except: Array.from(u.selection.value.except)
    };
  }
  function V(e, n = {}) {
    _.visit(e, {
      preserveScroll: !0,
      preserveState: !0,
      ...c,
      ...n,
      method: "get"
    });
  }
  function W(e, n, o = {}) {
    var h;
    Q(e, C(n), {
      ...i,
      ...o
    }) || (h = f == null ? void 0 : f[e.name]) == null || h.call(f, n);
  }
  function K(e, n = {}) {
    return Q(e, O(), {
      ...i,
      ...n,
      onSuccess: (o) => {
        var m, h;
        (m = n.onSuccess) == null || m.call(n, o), (h = i.onSuccess) == null || h.call(i, o), console.log("onSuccess"), e.keep || u.deselectAll();
      }
    });
  }
  function B(e, n = {}, o = {}) {
    return Q(e, n, { ...i, ...o });
  }
  function q(e, n = {}) {
    if (!P.value)
      return console.warn("The table does not support pagination changes.");
    _.reload({
      ...c,
      ...n,
      data: {
        [r.value._record_key]: e.value,
        [r.value._page_key]: void 0
      }
    });
  }
  function N(e, n = {}) {
    if (!L.value)
      return console.warn("The table does not support column toggling.");
    const o = I(e);
    if (!o) return console.log(`Column [${e}] does not exist.`);
    const m = k.toggleValue(
      o,
      T.value.map(({ name: h }) => h)
    );
    _.reload({
      ...c,
      ...n,
      data: {
        [r.value._column_key]: k.delimitArray(m)
      }
    });
  }
  function D() {
    u.select(
      ...r.value.records.map(
        (e) => p(e)
      )
    );
  }
  function t() {
    u.deselect(
      ...r.value.records.map(
        (e) => p(e)
      )
    );
  }
  function a() {
    return {
      "onUpdate:modelValue": (e) => {
        e ? D() : t();
      },
      modelValue: U.value
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
    placeholder: g,
    /** Whether the table is empty */
    isEmpty: E,
    /** Whether the table supports changing the number of records to display per page */
    isPageable: P,
    /** Whether the table supports toggling columns */
    isToggleable: L,
    /** Get the entry of the record for the column */
    getEntry: w,
    /** Get the value of the record for the column */
    getValue: F,
    /** Get the extra data of the record for the column */
    getExtra: A,
    /** Retrieve a record's identifier */
    getRecordKey: p,
    /** The heading columns for the table */
    headings: T,
    /** All of the table's columns */
    columns: R,
    /** The records of the table */
    records: G,
    /** Whether the table has record operations */
    inline: z,
    /** The available bulk operations */
    bulk: j,
    /** The available page operations */
    page: $,
    /** The available number of records to display per page */
    pages: J,
    /** The current record per page item */
    currentPage: M,
    /** The pagination metadata */
    paginator: y,
    /** Execute an inline operation */
    executeInline: W,
    /** Execute a bulk operation */
    executeBulk: K,
    /** Execute a page operation */
    executePage: B,
    /** The bulk data */
    getBulkData: O,
    /** The record data */
    getRecordData: C,
    /** Apply a new page by changing the number of records to display */
    applyPage: q,
    /** The current selection of records */
    selection: u.selection,
    /** Select the given records */
    select: (e) => u.select(p(e)),
    /** Deselect the given records */
    deselect: (e) => u.deselect(p(e)),
    /** Select records on the current page */
    selectPage: D,
    /** Deselect records on the current page */
    deselectPage: t,
    /** Toggle the selection of the given records */
    toggle: (e) => u.toggle(p(e)),
    /** Determine if the given record is selected */
    selected: (e) => u.selected(p(e)),
    /** Select all records */
    selectAll: u.selectAll,
    /** Deselect all records */
    deselectAll: u.deselectAll,
    /** Whether all records on the current page are selected */
    isPageSelected: U,
    /** Determine if any records are selected */
    hasSelected: u.hasSelected,
    /** Bind the given record to a checkbox */
    bindCheckbox: (e) => u.bind(p(e)),
    /** Bind the select all checkbox to the current page */
    bindPage: a,
    /** Bind select all records to the checkbox */
    bindAll: u.bindAll,
    /** The refine instance */
    ...k
  });
}
function se(l, d) {
  return l ? typeof l == "object" ? l.type === d : l === d : !1;
}
export {
  se as is,
  ce as useTable
};
