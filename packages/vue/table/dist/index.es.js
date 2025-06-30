import { ref as ne, computed as f, reactive as ee, toValue as Z } from "vue";
import { router as b } from "@inertiajs/vue3";
import le from "axios";
function ae(r, v, s, o = {}) {
  if (r.route) {
    const { url: l, method: u } = r.route;
    return r.inertia ? window.location.href = l : b.visit(l, { ...o, method: u }), !0;
  }
  if (!r.action || !v)
    return !1;
  const p = {
    ...s,
    name: r.name,
    type: r.type
  };
  return r.inertia ? b.post(v, p, o) : le.post(v, p).catch((l) => {
    var u;
    return (u = o.onError) == null ? void 0 : u.call(o, l);
  }), !0;
}
function te(r, v, s, o = {}, p = {}) {
  return ae(
    r,
    v,
    { ...o, id: s ?? void 0 },
    p
  );
}
function re(r, v, s, o = {}, p = {}) {
  return r.map((l) => ({
    ...l,
    execute: (u = {}, a = {}) => te(
      l,
      v,
      s,
      { ...p, ...u },
      { ...o, ...a }
    )
  }));
}
function oe() {
  const r = ne({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function v() {
    r.value.all = !0, r.value.only.clear(), r.value.except.clear();
  }
  function s() {
    r.value.all = !1, r.value.only.clear(), r.value.except.clear();
  }
  function o(...d) {
    d.forEach((y) => r.value.except.delete(y)), d.forEach((y) => r.value.only.add(y));
  }
  function p(...d) {
    d.forEach((y) => r.value.except.add(y)), d.forEach((y) => r.value.only.delete(y));
  }
  function l(d, y) {
    if (u(d) || y === !1) return p(d);
    if (!u(d) || y === !0) return o(d);
  }
  function u(d) {
    return r.value.all ? !r.value.except.has(d) : r.value.only.has(d);
  }
  const a = f(() => r.value.all && r.value.except.size === 0), x = f(() => r.value.only.size > 0 || a.value);
  function w(d) {
    return {
      "onUpdate:modelValue": (y) => {
        y ? o(d) : p(d);
      },
      modelValue: u(d),
      value: d
    };
  }
  function k() {
    return {
      "onUpdate:modelValue": (d) => {
        d ? v() : s();
      },
      modelValue: a.value
    };
  }
  return {
    allSelected: a,
    selection: r,
    hasSelected: x,
    selectAll: v,
    deselectAll: s,
    select: o,
    deselect: p,
    toggle: l,
    selected: u,
    bind: w,
    bindAll: k
  };
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const _ = () => {
};
function ie(r, v) {
  function s(...o) {
    return new Promise((p, l) => {
      Promise.resolve(r(() => v.apply(this, o), { fn: v, thisArg: this, args: o })).then(p).catch(l);
    });
  }
  return s;
}
function ue(r, v = {}) {
  let s, o, p = _;
  const l = (a) => {
    clearTimeout(a), p(), p = _;
  };
  let u;
  return (a) => {
    const x = Z(r), w = Z(v.maxWait);
    return s && l(s), x <= 0 || w !== void 0 && w <= 0 ? (o && (l(o), o = null), Promise.resolve(a())) : new Promise((k, d) => {
      p = v.rejectOnCancel ? d : k, u = a, w && !o && (o = setTimeout(() => {
        s && l(s), o = null, k(u());
      }, w)), s = setTimeout(() => {
        o && l(o), o = null, k(a());
      }, x);
    });
  };
}
function N(r, v = 200, s = {}) {
  return ie(
    ue(v, s),
    r
  );
}
function ce(r, v, s = {}) {
  if (!(r != null && r[v]))
    throw new Error("The refine must be provided with valid props and key.");
  const o = f(() => r[v]), p = f(() => !!o.value.sort), l = f(() => !!o.value.search), u = f(() => !!o.value.match), a = f(
    () => {
      var t;
      return (t = o.value.filters) == null ? void 0 : t.map((n) => ({
        ...n,
        apply: (i, m = {}) => E(n, i, m),
        clear: (i = {}) => j(n, i),
        bind: () => $(n.name)
      }));
    }
  ), x = f(
    () => {
      var t;
      return (t = o.value.sorts) == null ? void 0 : t.map((n) => ({
        ...n,
        apply: (i = {}) => T(n, n.direction, i),
        clear: (i = {}) => B(i),
        bind: () => F(n)
      }));
    }
  ), w = f(
    () => {
      var t;
      return (t = o.value.searches) == null ? void 0 : t.map((n) => ({
        ...n,
        apply: (i = {}) => A(n, i),
        clear: (i = {}) => A(n, i),
        bind: () => H(n)
      }));
    }
  ), k = f(
    () => a.value.filter(({ active: t }) => t)
  ), d = f(
    () => x.value.find(({ active: t }) => t)
  ), y = f(
    () => w.value.filter(({ active: t }) => t)
  );
  function U(t) {
    return Array.isArray(t) ? t.join(o.value.delimiter) : t;
  }
  function R(t) {
    return typeof t != "string" ? t : t.trim().replace(/\s+/g, "+");
  }
  function P(t) {
    if (!["", null, void 0, []].includes(t))
      return t;
  }
  function C(t) {
    return [U, R, P].reduce(
      (n, i) => i(n),
      t
    );
  }
  function I(t, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(t) ? n.filter((i) => i !== t) : [...n, t];
  }
  function O(t) {
    return typeof t != "string" ? t : a.value.find(({ name: n }) => n === t);
  }
  function W(t, n = null) {
    return typeof t != "string" ? t : x.value.find(
      ({ name: i, direction: m }) => i === t && m === n
    );
  }
  function z(t) {
    return typeof t != "string" ? t : w.value.find(({ name: n }) => n === t);
  }
  function X(t) {
    return t ? typeof t == "string" ? k.value.some((n) => n.name === t) : t.active : !!k.value.length;
  }
  function Y(t) {
    var n;
    return t ? typeof t == "string" ? ((n = d.value) == null ? void 0 : n.name) === t : t.active : !!d.value;
  }
  function K(t) {
    var n;
    return t ? typeof t == "string" ? (n = y.value) == null ? void 0 : n.some((i) => i.name === t) : t.active : !!o.value.term;
  }
  function S(t, n = {}) {
    const i = Object.fromEntries(
      Object.entries(t).map(([m, V]) => [m, C(V)])
    );
    b.reload({
      ...s,
      ...n,
      data: i
    });
  }
  function E(t, n, i = {}) {
    const m = O(t);
    if (!m) return console.warn(`Filter [${t}] does not exist.`);
    b.reload({
      ...s,
      ...i,
      data: {
        [m.name]: C(n)
      }
    });
  }
  function T(t, n = null, i = {}) {
    if (!p.value)
      return console.warn("Refine cannot perform sorting.");
    const m = W(t, n);
    if (!m) return console.warn(`Sort [${t}] does not exist.`);
    b.reload({
      ...s,
      ...i,
      data: {
        [o.value.sort]: P(m.next)
      }
    });
  }
  function h(t, n = {}) {
    if (!l.value)
      return console.warn("Refine cannot perform searching.");
    t = [R, P].reduce(
      (i, m) => m(i),
      t
    ), b.reload({
      ...s,
      ...n,
      data: {
        [o.value.search]: t
      }
    });
  }
  function A(t, n = {}) {
    if (!u.value || !l.value)
      return console.warn("Refine cannot perform matching.");
    const i = z(t);
    if (!i) return console.warn(`Match [${t}] does not exist.`);
    const m = I(
      i.name,
      y.value.map(({ name: V }) => V)
    );
    b.reload({
      ...s,
      ...n,
      data: {
        [o.value.match]: U(m)
      }
    });
  }
  function j(t, n = {}) {
    if (t) return E(t, null, n);
    b.reload({
      ...s,
      ...n,
      data: Object.fromEntries(
        k.value.map(({ name: i }) => [i, null])
      )
    });
  }
  function B(t = {}) {
    if (!p.value)
      return console.warn("Refine cannot perform sorting.");
    b.reload({
      ...s,
      ...t,
      data: {
        [o.value.sort]: null
      }
    });
  }
  function Q(t = {}) {
    h(null, t);
  }
  function q(t = {}) {
    if (!u.value)
      return console.warn("Refine cannot perform matching.");
    b.reload({
      ...s,
      ...t,
      data: {
        [o.value.match]: null
      }
    });
  }
  function G(t = {}) {
    var n;
    b.reload({
      ...s,
      ...t,
      data: {
        [o.value.search ?? ""]: void 0,
        [o.value.sort ?? ""]: void 0,
        [o.value.match ?? ""]: void 0,
        ...Object.fromEntries(
          ((n = o.value.filters) == null ? void 0 : n.map((i) => [
            i.name,
            void 0
          ])) ?? []
        )
      }
    });
  }
  function $(t, n = {}) {
    const i = O(t);
    if (!i) return console.warn(`Filter [${t}] does not exist.`);
    const {
      debounce: m = 150,
      transform: V = (e) => e,
      ...M
    } = n;
    return {
      "onUpdate:modelValue": N((e) => {
        E(i, V(e), M);
      }, m),
      modelValue: i.value
    };
  }
  function F(t, n = {}) {
    if (!p.value)
      return console.warn("Refine cannot perform sorting.");
    const i = W(t);
    if (!i) return console.warn(`Sort [${t}] does not exist.`);
    const { debounce: m = 0, transform: V, ...M } = n;
    return {
      onClick: N(() => {
        var e;
        T(i, (e = d.value) == null ? void 0 : e.direction, M);
      }, m)
    };
  }
  function D(t = {}) {
    if (!l.value)
      return console.warn("Refine cannot perform searching.");
    const { debounce: n = 700, transform: i, ...m } = t;
    return {
      "onUpdate:modelValue": N(
        (V) => {
          h(V, m);
        },
        n
      ),
      modelValue: o.value.term ?? ""
    };
  }
  function H(t, n = {}) {
    if (!u.value)
      return console.warn("Refine cannot perform matching.");
    const i = z(t);
    if (!i) return console.warn(`Match [${t}] does not exist.`);
    const { debounce: m = 0, transform: V, ...M } = n;
    return {
      "onUpdate:modelValue": N((e) => {
        A(e, M);
      }, m),
      modelValue: K(i),
      value: i.name
    };
  }
  return ee({
    filters: a,
    sorts: x,
    searches: w,
    currentFilters: k,
    currentSort: d,
    currentSearches: y,
    isSortable: p,
    isSearchable: l,
    isMatchable: u,
    isFiltering: X,
    isSorting: Y,
    isSearching: K,
    getFilter: O,
    getSort: W,
    getSearch: z,
    apply: S,
    applyFilter: E,
    applySort: T,
    applySearch: h,
    applyMatch: A,
    clearFilter: j,
    clearSort: B,
    clearSearch: Q,
    clearMatch: q,
    reset: G,
    bindFilter: $,
    bindSort: F,
    bindSearch: D,
    bindMatch: H,
    stringValue: R,
    omitValue: P,
    toggleValue: I,
    delimitArray: U
  });
}
function de(r, v, s = {}) {
  if (!(r != null && r[v]))
    throw new Error("The table must be provided with valid props and key.");
  const { recordOperations: o = {}, ...p } = {
    only: [...s.only ?? [], v.toString()],
    ...s
  }, l = f(() => r[v]), u = oe(), a = ce(r, v, p), x = f(() => l.value.id ?? null), w = f(() => l.value.meta), k = f(() => l.value.views ?? []), d = f(() => l.value.emptyState ?? null), y = f(() => l.value.placeholder ?? null), U = f(() => !!l.value.emptyState), R = f(() => !!l.value.page && !!l.value.record), P = f(() => !!l.value.column), C = f(
    () => l.value.columns.filter(({ active: e, hidden: c }) => e && !c).map((e) => {
      var c;
      return {
        ...e,
        isSorting: !!((c = e.sort) != null && c.active),
        toggleSort: (g = {}) => a.applySort(e.sort, null, g)
      };
    })
  ), I = f(
    () => l.value.columns.filter(({ hidden: e }) => !e).map((e) => ({
      ...e,
      toggle: (c = {}) => i(e.name, c)
    }))
  ), O = f(
    () => l.value.records.map((e) => ({
      /** The operations available for the record */
      operations: $(e.operations, Q(e)),
      /** The classes to apply to the record */
      class: e.class ?? null,
      /** Perform this operation when the record is clicked */
      default: (c = {}) => {
        const g = e.operations.find(
          ({ default: L }) => L
        );
        g && D(g, e, c);
      },
      /** Selects this record */
      select: () => u.select(h(e)),
      /** Deselects this record */
      deselect: () => u.deselect(h(e)),
      /** Toggles the selection of this record */
      toggle: () => u.toggle(h(e)),
      /** Determine if the record is selected */
      selected: u.selected(h(e)),
      /** Bind the record to a checkbox */
      bind: () => u.bind(h(e)),
      /** Get the entry of the record for the column */
      entry: (c) => A(e, c),
      /** Get the value of the record for the column */
      value: (c) => j(e, c),
      /** Get the extra data of the record for the column */
      extra: (c) => B(e, c)
    }))
  ), W = f(() => !!l.value.operations.inline), z = f(
    () => $(l.value.operations.bulk, q())
  ), X = f(() => $(l.value.operations.page)), Y = f(
    () => l.value.pages.find(({ active: e }) => e)
  ), K = f(() => l.value.pages), S = f(() => ({
    ...l.value.paginate,
    next: (e = {}) => {
      "nextLink" in S.value && S.value.nextLink && F(S.value.nextLink, e);
    },
    previous: (e = {}) => {
      "prevLink" in S.value && S.value.prevLink && F(S.value.prevLink, e);
    },
    first: (e = {}) => {
      "firstLink" in S.value && S.value.firstLink && F(S.value.firstLink, e);
    },
    last: (e = {}) => {
      "lastLink" in S.value && S.value.lastLink && F(S.value.lastLink, e);
    },
    ..."links" in l.value.paginate && l.value.paginate.links ? {
      links: l.value.paginate.links.map((e) => ({
        ...e,
        navigate: (c = {}) => e.url && F(e.url, c)
      }))
    } : {}
  })), E = f(
    () => l.value.records.length > 0 && l.value.records.every(
      (e) => u.selected(h(e))
    )
  );
  function T(e) {
    return typeof e == "string" ? e : e.name;
  }
  function h(e) {
    return "value" in e && typeof e.value == "function" ? e.value(l.value.key) : j(e, l.value.key);
  }
  function A(e, c) {
    const g = T(c);
    return g in e && g !== "classes" ? e[g] : null;
  }
  function j(e, c) {
    var g;
    return ((g = A(e, c)) == null ? void 0 : g.v) ?? null;
  }
  function B(e, c) {
    var g;
    return (g = A(e, c)) == null ? void 0 : g.e;
  }
  function Q(e) {
    return { record: h(e) };
  }
  function q() {
    return {
      all: u.selection.value.all,
      only: Array.from(u.selection.value.only),
      except: Array.from(u.selection.value.except)
    };
  }
  function G(e, c = {}, g = {}) {
    return te(e, l.value.endpoint, x.value, c, {
      ...p,
      ...g
    });
  }
  function $(e, c = {}) {
    return re(
      e,
      l.value.endpoint,
      x.value,
      p,
      c
    );
  }
  function F(e, c = {}) {
    b.visit(e, {
      preserveScroll: !0,
      preserveState: !0,
      ...p,
      ...c,
      method: "get"
    });
  }
  function D(e, c, g = {}) {
    var J;
    G(
      e,
      {
        record: h(c)
      },
      g
    ) || (J = o == null ? void 0 : o[e.name]) == null || J.call(o, c);
  }
  function H(e, c = {}) {
    G(e, q(), {
      ...c,
      onSuccess: (g) => {
        var L;
        (L = c.onSuccess) == null || L.call(c, g), e.keepSelected || u.deselectAll();
      }
    });
  }
  function t(e, c = {}, g = {}) {
    return G(e, c, g);
  }
  function n(e, c = {}) {
    if (!R.value)
      return console.warn("The table does not support pagination changes.");
    b.reload({
      ...p,
      ...c,
      data: {
        [l.value.record]: e.value,
        [l.value.page]: void 0
      }
    });
  }
  function i(e, c = {}) {
    if (!P.value)
      return console.warn("The table does not support column toggling.");
    const g = T(e);
    if (!g) return console.log(`Column [${e}] does not exist.`);
    const L = a.toggleValue(
      g,
      C.value.map(({ name: J }) => J)
    );
    b.reload({
      ...p,
      ...c,
      data: {
        [l.value.column]: a.delimitArray(L)
      }
    });
  }
  function m() {
    u.select(
      ...l.value.records.map(
        (e) => h(e)
      )
    );
  }
  function V() {
    u.deselect(
      ...l.value.records.map(
        (e) => h(e)
      )
    );
  }
  function M() {
    return {
      "onUpdate:modelValue": (e) => {
        e ? m() : V();
      },
      modelValue: E.value
    };
  }
  return ee({
    /** The identifier of the table */
    id: x,
    /** Table-specific metadata */
    meta: w,
    /** The views for the table */
    views: k,
    /** The empty state for the table */
    emptyState: d,
    /** The placeholder for the search term.*/
    placeholder: y,
    /** Whether the table is empty */
    isEmpty: U,
    /** Whether the table supports changing the number of records to display per page */
    isPageable: R,
    /** Whether the table supports toggling columns */
    isToggleable: P,
    /** Get the entry of the record for the column */
    getEntry: A,
    /** Get the value of the record for the column */
    getValue: j,
    /** Get the extra data of the record for the column */
    getExtra: B,
    /** Retrieve a record's identifier */
    getRecordKey: h,
    /** The heading columns for the table */
    headings: C,
    /** All of the table's columns */
    columns: I,
    /** The records of the table */
    records: O,
    /** Whether the table has record operations */
    inline: W,
    /** The available bulk operations */
    bulk: z,
    /** The available page operations */
    page: X,
    /** The available number of records to display per page */
    pages: K,
    /** The current record per page item */
    currentPage: Y,
    /** The pagination metadata */
    paginator: S,
    /** Execute an inline operation */
    executeInline: D,
    /** Execute a bulk operation */
    executeBulk: H,
    /** Execute a page operation */
    executePage: t,
    /** Apply a new page by changing the number of records to display */
    applyPage: n,
    /** The current selection of records */
    selection: u.selection,
    /** Select the given records */
    select: (e) => u.select(h(e)),
    /** Deselect the given records */
    deselect: (e) => u.deselect(h(e)),
    /** Select records on the current page */
    selectPage: m,
    /** Deselect records on the current page */
    deselectPage: V,
    /** Toggle the selection of the given records */
    toggle: (e) => u.toggle(h(e)),
    /** Determine if the given record is selected */
    selected: (e) => u.selected(h(e)),
    /** Select all records */
    selectAll: u.selectAll,
    /** Deselect all records */
    deselectAll: u.deselectAll,
    /** Whether all records on the current page are selected */
    isPageSelected: E,
    /** Determine if any records are selected */
    hasSelected: u.hasSelected,
    /** Bind the given record to a checkbox */
    bindCheckbox: (e) => u.bind(h(e)),
    /** Bind the select all checkbox to the current page */
    bindPage: M,
    /** Bind select all records to the checkbox */
    bindAll: u.bindAll,
    filters: a.filters,
    sorts: a.sorts,
    searches: a.searches,
    currentFilters: a.currentFilters,
    currentSort: a.currentSort,
    currentSearches: a.currentSearches,
    isSortable: a.isSortable,
    isSearchable: a.isSearchable,
    isMatchable: a.isMatchable,
    isFiltering: a.isFiltering,
    isSorting: a.isSorting,
    isSearching: a.isSearching,
    getFilter: a.getFilter,
    getSort: a.getSort,
    getSearch: a.getSearch,
    apply: a.apply,
    applyFilter: a.applyFilter,
    applySort: a.applySort,
    applySearch: a.applySearch,
    applyMatch: a.applyMatch,
    clearFilter: a.clearFilter,
    clearSort: a.clearSort,
    clearSearch: a.clearSearch,
    clearMatch: a.clearMatch,
    reset: a.reset,
    bindFilter: a.bindFilter,
    bindSort: a.bindSort,
    bindSearch: a.bindSearch,
    bindMatch: a.bindMatch,
    stringValue: a.stringValue,
    omitValue: a.omitValue,
    toggleValue: a.toggleValue,
    delimitArray: a.delimitArray
  });
}
function pe(r, v) {
  return r ? typeof r == "object" ? r.type === v : r === v : !1;
}
export {
  pe as is,
  de as useTable
};
