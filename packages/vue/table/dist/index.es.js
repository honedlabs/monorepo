import { ref as ee, computed as s, toValue as Y, reactive as te } from "vue";
import { router as k } from "@inertiajs/vue3";
import q from "axios";
function X(a, d = {}, c = {}) {
  if (!a.href || !a.method)
    return !1;
  if (a.type === "inertia")
    a.method === "delete" ? k.delete(a.href, c) : k[a.method](a.href, d, c);
  else {
    const u = (m) => {
      var o;
      return (o = c.onError) == null ? void 0 : o.call(c, m);
    };
    a.method === "get" ? window.location.href = a.href : a.method === "delete" ? q.delete(a.href).catch(u) : q[a.method](a.href, d).catch(u);
  }
  return !0;
}
function ne() {
  const a = ee({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function d() {
    a.value.all = !0, a.value.only.clear(), a.value.except.clear();
  }
  function c() {
    a.value.all = !1, a.value.only.clear(), a.value.except.clear();
  }
  function u(...v) {
    v.forEach((p) => a.value.except.delete(p)), v.forEach((p) => a.value.only.add(p));
  }
  function m(...v) {
    v.forEach((p) => a.value.except.add(p)), v.forEach((p) => a.value.only.delete(p));
  }
  function o(v, p) {
    if (b(v) || p === !1) return m(v);
    if (!b(v) || p === !0) return u(v);
  }
  function b(v) {
    return a.value.all ? !a.value.except.has(v) : a.value.only.has(v);
  }
  const i = s(() => a.value.all && a.value.except.size === 0), _ = s(() => a.value.only.size > 0 || i.value);
  function S(v) {
    return {
      "onUpdate:modelValue": (p) => {
        p ? u(v) : m(v);
      },
      modelValue: b(v),
      value: v
    };
  }
  function w() {
    return {
      "onUpdate:modelValue": (v) => {
        v ? d() : c();
      },
      modelValue: i.value
    };
  }
  return {
    allSelected: i,
    selection: a,
    hasSelected: _,
    selectAll: d,
    deselectAll: c,
    select: u,
    deselect: m,
    toggle: o,
    selected: b,
    bind: S,
    bindAll: w
  };
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const Z = () => {
};
function le(a, d) {
  function c(...u) {
    return new Promise((m, o) => {
      Promise.resolve(a(() => d.apply(this, u), { fn: d, thisArg: this, args: u })).then(m).catch(o);
    });
  }
  return c;
}
function ae(a, d = {}) {
  let c, u, m = Z;
  const o = (i) => {
    clearTimeout(i), m(), m = Z;
  };
  let b;
  return (i) => {
    const _ = Y(a), S = Y(d.maxWait);
    return c && o(c), _ <= 0 || S !== void 0 && S <= 0 ? (u && (o(u), u = null), Promise.resolve(i())) : new Promise((w, v) => {
      m = d.rejectOnCancel ? v : w, b = i, S && !u && (u = setTimeout(() => {
        c && o(c), u = null, w(b());
      }, S)), c = setTimeout(() => {
        u && o(u), u = null, w(i());
      }, _);
    });
  };
}
function H(a, d = 200, c = {}) {
  return le(
    ae(d, c),
    a
  );
}
function re(a, d, c = {}) {
  if (!(a != null && a[d]))
    throw new Error("The refine must be provided with valid props and key.");
  const u = s(() => a[d]), m = s(() => u.value.term), o = s(() => !!u.value._sort_key), b = s(() => !!u.value._search_key), i = s(() => !!u.value._match_key), _ = s(
    () => {
      var t;
      return (t = u.value.filters) == null ? void 0 : t.map((n) => ({
        ...n,
        apply: (r, e = {}) => V(n, r, e),
        clear: (r = {}) => U(n, r),
        bind: () => W(n.name)
      }));
    }
  ), S = s(
    () => {
      var t;
      return (t = u.value.sorts) == null ? void 0 : t.map((n) => ({
        ...n,
        apply: (r = {}) => g(n, n.direction, r),
        clear: (r = {}) => C(r),
        bind: () => z(n)
      }));
    }
  ), w = s(
    () => {
      var t;
      return (t = u.value.searches) == null ? void 0 : t.map((n) => ({
        ...n,
        apply: (r = {}) => E(n, r),
        clear: (r = {}) => E(n, r),
        bind: () => K(n)
      }));
    }
  ), v = s(
    () => _.value.filter(({ active: t }) => t)
  ), p = s(
    () => S.value.find(({ active: t }) => t)
  ), F = s(
    () => w.value.filter(({ active: t }) => t)
  );
  function T(t) {
    return Array.isArray(t) ? t.join(u.value._delimiter) : t;
  }
  function R(t) {
    return typeof t != "string" ? t : t.trim().replace(/\s+/g, "+");
  }
  function A(t) {
    if (!["", null, void 0, []].includes(t))
      return t;
  }
  function B(t) {
    return [T, R, A].reduce(
      (n, r) => r(n),
      t
    );
  }
  function D(t, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(t) ? n.filter((r) => r !== t) : [...n, t];
  }
  function j(t) {
    return typeof t != "string" ? t : _.value.find(({ name: n }) => n === t);
  }
  function $(t, n = null) {
    return typeof t != "string" ? t : S.value.find(
      ({ name: r, direction: e }) => r === t && e === n
    );
  }
  function M(t) {
    return typeof t != "string" ? t : w.value.find(({ name: n }) => n === t);
  }
  function J(t) {
    return t ? typeof t == "string" ? v.value.some((n) => n.name === t) : t.active : !!v.value.length;
  }
  function N(t) {
    var n;
    return t ? typeof t == "string" ? ((n = p.value) == null ? void 0 : n.name) === t : t.active : !!p.value;
  }
  function h(t) {
    var n;
    return t ? typeof t == "string" ? (n = F.value) == null ? void 0 : n.some((r) => r.name === t) : t.active : !!m.value;
  }
  function G(t, n = {}) {
    const r = Object.fromEntries(
      Object.entries(t).map(([e, l]) => [e, B(l)])
    );
    k.reload({
      ...c,
      ...n,
      data: r
    });
  }
  function V(t, n, r = {}) {
    const e = j(t);
    if (!e) return console.warn(`Filter [${t}] does not exist.`);
    k.reload({
      ...c,
      ...r,
      data: {
        [e.name]: B(n)
      }
    });
  }
  function g(t, n = null, r = {}) {
    if (!o.value)
      return console.warn("Refine cannot perform sorting.");
    const e = $(t, n);
    if (!e) return console.warn(`Sort [${t}] does not exist.`);
    k.reload({
      ...c,
      ...r,
      data: {
        [u.value._sort_key]: A(e.next)
      }
    });
  }
  function x(t, n = {}) {
    if (!b.value)
      return console.warn("Refine cannot perform searching.");
    t = [R, A].reduce(
      (r, e) => e(r),
      t
    ), k.reload({
      ...c,
      ...n,
      data: {
        [u.value._search_key]: t
      }
    });
  }
  function E(t, n = {}) {
    if (!i.value || !b.value)
      return console.warn("Refine cannot perform matching.");
    const r = M(t);
    if (!r) return console.warn(`Match [${t}] does not exist.`);
    const e = D(
      r.name,
      F.value.map(({ name: l }) => l)
    );
    k.reload({
      ...c,
      ...n,
      data: {
        [u.value._match_key]: T(e)
      }
    });
  }
  function U(t, n = {}) {
    if (t) return V(t, null, n);
    k.reload({
      ...c,
      ...n,
      data: Object.fromEntries(
        v.value.map(({ name: r }) => [r, null])
      )
    });
  }
  function C(t = {}) {
    if (!o.value)
      return console.warn("Refine cannot perform sorting.");
    k.reload({
      ...c,
      ...t,
      data: {
        [u.value._sort_key]: null
      }
    });
  }
  function I(t = {}) {
    x(null, t);
  }
  function P(t = {}) {
    if (!i.value)
      return console.warn("Refine cannot perform matching.");
    k.reload({
      ...c,
      ...t,
      data: {
        [u.value._match_key]: null
      }
    });
  }
  function O(t = {}) {
    var n;
    k.reload({
      ...c,
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
  function W(t, n = {}) {
    const r = j(t);
    if (!r) return console.warn(`Filter [${t}] does not exist.`);
    const {
      debounce: e = 150,
      transform: l = (y) => y,
      ...f
    } = n;
    return {
      "onUpdate:modelValue": H((y) => {
        V(r, l(y), f);
      }, e),
      modelValue: r.value
    };
  }
  function z(t, n = {}) {
    if (!o.value)
      return console.warn("Refine cannot perform sorting.");
    const r = $(t);
    if (!r) return console.warn(`Sort [${t}] does not exist.`);
    const { debounce: e = 0, transform: l, ...f } = n;
    return {
      onClick: H(() => {
        var y;
        g(r, (y = p.value) == null ? void 0 : y.direction, f);
      }, e)
    };
  }
  function Q(t = {}) {
    if (!b.value)
      return console.warn("Refine cannot perform searching.");
    const { debounce: n = 700, transform: r, ...e } = t;
    return {
      "onUpdate:modelValue": H(
        (l) => {
          x(l, e);
        },
        n
      ),
      modelValue: m.value ?? ""
    };
  }
  function K(t, n = {}) {
    if (!i.value)
      return console.warn("Refine cannot perform matching.");
    const r = M(t);
    if (!r) return console.warn(`Match [${t}] does not exist.`);
    const { debounce: e = 0, transform: l, ...f } = n;
    return {
      "onUpdate:modelValue": H((y) => {
        E(y, f);
      }, e),
      modelValue: h(r),
      value: r.name
    };
  }
  return {
    filters: _,
    sorts: S,
    searches: w,
    currentFilters: v,
    currentSort: p,
    currentSearches: F,
    searchTerm: m,
    isSortable: o,
    isSearchable: b,
    isMatchable: i,
    isFiltering: J,
    isSorting: N,
    isSearching: h,
    getFilter: j,
    getSort: $,
    getSearch: M,
    apply: G,
    applyFilter: V,
    applySort: g,
    applySearch: x,
    applyMatch: E,
    clearFilter: U,
    clearSort: C,
    clearSearch: I,
    clearMatch: P,
    reset: O,
    bindFilter: W,
    bindSort: z,
    bindSearch: Q,
    bindMatch: K,
    stringValue: R,
    omitValue: A,
    toggleValue: D,
    delimitArray: T
  };
}
function ce(a, d, c = {}) {
  if (!(a != null && a[d]))
    throw new Error("The table must be provided with valid props and key.");
  const { recordOperations: u = {}, ...m } = {
    only: [...c.only ?? [], d.toString()],
    ...c
  }, o = s(() => a[d]), b = s(() => o.value._id), i = ne(), _ = re(a, d, m), S = s(() => o.value.meta), w = s(() => o.value.views ?? []), v = s(() => o.value.state ?? null), p = s(() => o.value.placeholder ?? null), F = s(() => !!o.value.state), T = s(
    () => !!o.value._page_key && !!o.value._record_key
  ), R = s(() => !!o.value._column_key), A = s(
    () => o.value.columns.filter(({ active: e, hidden: l }) => e && !l).map((e) => {
      var l;
      return {
        ...e,
        isSorting: !!((l = e.sort) != null && l.active),
        toggleSort: (f = {}) => _.applySort(e.sort, null, f)
      };
    })
  ), B = s(
    () => o.value.columns.filter(({ hidden: e }) => !e).map((e) => ({
      ...e,
      toggle: (l = {}) => K(e.name, l)
    }))
  ), D = s(
    () => o.value.records.map((e) => ({
      ...e,
      /** The operations available for the record */
      operations: e.operations.map((l) => ({
        ...l,
        execute: (f = {}) => O(l, e, f)
      })),
      /** Determine if the record is selected */
      selected: i.selected(g(e)),
      /** Perform this operation when the record is clicked */
      default: (l = {}) => {
        const f = e.operations.find(
          ({ default: y }) => y
        );
        f && O(f, e, l);
      },
      /** Selects this record */
      select: () => i.select(g(e)),
      /** Deselects this record */
      deselect: () => i.deselect(g(e)),
      /** Toggles the selection of this record */
      toggle: () => i.toggle(g(e)),
      /** Bind the record to a checkbox */
      bind: () => i.bind(g(e)),
      /** Get the entry of the record for the column */
      entry: (l) => x(e, l),
      /** Get the value of the record for the column */
      value: (l) => E(e, l),
      /** Get the extra data of the record for the column */
      extra: (l) => U(e, l)
    }))
  ), j = s(() => !!o.value.operations.inline), $ = s(
    () => o.value.operations.bulk.map((e) => ({
      ...e,
      execute: (l = {}) => W(e, l)
    }))
  ), M = s(
    () => o.value.operations.page.map((e) => ({
      ...e,
      execute: (l = {}) => z(e, l)
    }))
  ), J = s(
    () => o.value.pages.find(({ active: e }) => e)
  ), N = s(() => o.value.pages), h = s(() => ({
    ...o.value.paginate,
    next: (e = {}) => {
      "nextLink" in h.value && h.value.nextLink && P(h.value.nextLink, e);
    },
    previous: (e = {}) => {
      "prevLink" in h.value && h.value.prevLink && P(h.value.prevLink, e);
    },
    first: (e = {}) => {
      "firstLink" in h.value && h.value.firstLink && P(h.value.firstLink, e);
    },
    last: (e = {}) => {
      "lastLink" in h.value && h.value.lastLink && P(h.value.lastLink, e);
    },
    ..."links" in o.value.paginate && o.value.paginate.links ? {
      links: o.value.paginate.links.map((e) => ({
        ...e,
        navigate: (l = {}) => e.url && P(e.url, l)
      }))
    } : {}
  })), G = s(
    () => o.value.records.length > 0 && o.value.records.every(
      (e) => i.selected(g(e))
    )
  );
  function V(e) {
    return typeof e == "string" ? e : e.name;
  }
  function g(e) {
    return e._key;
  }
  function x(e, l) {
    const f = V(l);
    return e[f];
  }
  function E(e, l) {
    var f;
    return ((f = x(e, l)) == null ? void 0 : f.v) ?? null;
  }
  function U(e, l) {
    var f;
    return (f = x(e, l)) == null ? void 0 : f.e;
  }
  function C(e) {
    return { id: g(e) };
  }
  function I() {
    return {
      all: i.selection.value.all,
      only: Array.from(i.selection.value.only),
      except: Array.from(i.selection.value.except)
    };
  }
  function P(e, l = {}) {
    k.visit(e, {
      preserveScroll: !0,
      preserveState: !0,
      ...m,
      ...l,
      method: "get"
    });
  }
  function O(e, l, f = {}) {
    var L;
    X(e, C(l), {
      ...c,
      ...f
    }) || (L = u == null ? void 0 : u[e.name]) == null || L.call(u, l);
  }
  function W(e, l = {}) {
    return X(e, I(), {
      ...c,
      ...l,
      onSuccess: (f) => {
        var y, L;
        (y = l.onSuccess) == null || y.call(l, f), (L = c.onSuccess) == null || L.call(c, f), e.keep || i.deselectAll();
      }
    });
  }
  function z(e, l = {}, f = {}) {
    return X(e, l, { ...c, ...f });
  }
  function Q(e, l = {}) {
    if (!T.value)
      return console.warn("The table does not support pagination changes.");
    k.reload({
      ...m,
      ...l,
      data: {
        [o.value._record_key]: e.value,
        [o.value._page_key]: void 0
      }
    });
  }
  function K(e, l = {}) {
    if (!R.value)
      return console.warn("The table does not support column toggling.");
    const f = V(e);
    if (!f) return console.log(`Column [${e}] does not exist.`);
    const y = _.toggleValue(
      f,
      A.value.map(({ name: L }) => L)
    );
    k.reload({
      ...m,
      ...l,
      data: {
        [o.value._column_key]: _.delimitArray(y)
      }
    });
  }
  function t() {
    i.select(
      ...o.value.records.map(
        (e) => g(e)
      )
    );
  }
  function n() {
    i.deselect(
      ...o.value.records.map(
        (e) => g(e)
      )
    );
  }
  function r() {
    return {
      "onUpdate:modelValue": (e) => {
        e ? t() : n();
      },
      modelValue: G.value
    };
  }
  return te({
    /** The identifier of the table */
    id: b,
    /** Table-specific metadata */
    meta: S,
    /** The views for the table */
    views: w,
    /** The empty state for the table */
    emptyState: v,
    /** The placeholder for the search term.*/
    placeholder: p,
    /** Whether the table is empty */
    isEmpty: F,
    /** Whether the table supports changing the number of records to display per page */
    isPageable: T,
    /** Whether the table supports toggling columns */
    isToggleable: R,
    /** Get the entry of the record for the column */
    getEntry: x,
    /** Get the value of the record for the column */
    getValue: E,
    /** Get the extra data of the record for the column */
    getExtra: U,
    /** Retrieve a record's identifier */
    getRecordKey: g,
    /** The heading columns for the table */
    headings: A,
    /** All of the table's columns */
    columns: B,
    /** The records of the table */
    records: D,
    /** Whether the table has record operations */
    inline: j,
    /** The available bulk operations */
    bulk: $,
    /** The available page operations */
    page: M,
    /** The available number of records to display per page */
    pages: N,
    /** The current record per page item */
    currentPage: J,
    /** The pagination metadata */
    paginator: h,
    /** Execute an inline operation */
    executeInline: O,
    /** Execute a bulk operation */
    executeBulk: W,
    /** Execute a page operation */
    executePage: z,
    /** The bulk data */
    getBulkData: I,
    /** The record data */
    getRecordData: C,
    /** Apply a new page by changing the number of records to display */
    applyPage: Q,
    /** The current selection of records */
    selection: i.selection,
    /** Select the given records */
    select: (e) => i.select(g(e)),
    /** Deselect the given records */
    deselect: (e) => i.deselect(g(e)),
    /** Select records on the current page */
    selectPage: t,
    /** Deselect records on the current page */
    deselectPage: n,
    /** Toggle the selection of the given records */
    toggle: (e) => i.toggle(g(e)),
    /** Determine if the given record is selected */
    selected: (e) => i.selected(g(e)),
    /** Select all records */
    selectAll: i.selectAll,
    /** Deselect all records */
    deselectAll: i.deselectAll,
    /** Whether all records on the current page are selected */
    isPageSelected: G,
    /** Determine if any records are selected */
    hasSelected: i.hasSelected,
    /** Bind the given record to a checkbox */
    bindCheckbox: (e) => i.bind(g(e)),
    /** Bind the select all checkbox to the current page */
    bindPage: r,
    /** Bind select all records to the checkbox */
    bindAll: i.bindAll,
    ..._
  });
}
function se(a, d) {
  return a ? typeof a == "object" ? a.type === d : a === d : !1;
}
export {
  se as is,
  ce as useTable
};
