import { ref as ee, computed as v, reactive as Z, toValue as Y } from "vue";
import { router as S } from "@inertiajs/vue3";
function te(l, d, s, o = {}) {
  return l.route ? (S.visit(l.route.url, {
    ...o,
    method: l.route.method
  }), !0) : l.action && d ? (S.post(
    d,
    { ...s, name: l.name, type: l.type },
    o
  ), !0) : !1;
}
function _(l, d, s, o = {}, m = {}) {
  return te(
    l,
    d,
    { ...o, id: s ?? void 0 },
    m
  );
}
function ne(l, d, s, o = {}) {
  return l.map((m) => ({
    ...m,
    execute: (u = {}, i = {}) => _(m, d, s, u, { ...o, ...i })
  }));
}
function le() {
  const l = ee({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function d() {
    l.value.all = !0, l.value.only.clear(), l.value.except.clear();
  }
  function s() {
    l.value.all = !1, l.value.only.clear(), l.value.except.clear();
  }
  function o(...f) {
    f.forEach((y) => l.value.except.delete(y)), f.forEach((y) => l.value.only.add(y));
  }
  function m(...f) {
    f.forEach((y) => l.value.except.add(y)), f.forEach((y) => l.value.only.delete(y));
  }
  function u(f, y) {
    if (i(f) || y === !1) return m(f);
    if (!i(f) || y === !0) return o(f);
  }
  function i(f) {
    return l.value.all ? !l.value.except.has(f) : l.value.only.has(f);
  }
  const h = v(() => l.value.all && l.value.except.size === 0), x = v(() => l.value.only.size > 0 || h.value);
  function w(f) {
    return {
      "onUpdate:modelValue": (y) => {
        y ? o(f) : m(f);
      },
      modelValue: i(f),
      value: f
    };
  }
  function k() {
    return {
      "onUpdate:modelValue": (f) => {
        f ? d() : s();
      },
      modelValue: h.value
    };
  }
  return {
    allSelected: h,
    selection: l,
    hasSelected: x,
    selectAll: d,
    deselectAll: s,
    select: o,
    deselect: m,
    toggle: u,
    selected: i,
    bind: w,
    bindAll: k
  };
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const Q = () => {
};
function ae(l, d) {
  function s(...o) {
    return new Promise((m, u) => {
      Promise.resolve(l(() => d.apply(this, o), { fn: d, thisArg: this, args: o })).then(m).catch(u);
    });
  }
  return s;
}
function re(l, d = {}) {
  let s, o, m = Q;
  const u = (h) => {
    clearTimeout(h), m(), m = Q;
  };
  let i;
  return (h) => {
    const x = Y(l), w = Y(d.maxWait);
    return s && u(s), x <= 0 || w !== void 0 && w <= 0 ? (o && (u(o), o = null), Promise.resolve(h())) : new Promise((k, f) => {
      m = d.rejectOnCancel ? f : k, i = h, w && !o && (o = setTimeout(() => {
        s && u(s), o = null, k(i());
      }, w)), s = setTimeout(() => {
        o && u(o), o = null, k(h());
      }, x);
    });
  };
}
function H(l, d = 200, s = {}) {
  return ae(
    re(d, s),
    l
  );
}
function oe(l, d, s = {}) {
  if (!(l != null && l[d]))
    throw new Error("The refine must be provided with valid props and key.");
  const o = v(() => l[d]), m = v(() => !!o.value.sort), u = v(() => !!o.value.search), i = v(() => !!o.value.match), h = v(
    () => {
      var e;
      return (e = o.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (a, p = {}) => P(n, a, p),
        clear: (a = {}) => C(n, a),
        bind: () => G(n.name)
      }));
    }
  ), x = v(
    () => {
      var e;
      return (e = o.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (a = {}) => F(n, n.direction, a),
        clear: (a = {}) => O(a),
        bind: () => K(n)
      }));
    }
  ), w = v(
    () => {
      var e;
      return (e = o.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (a = {}) => A(n, a),
        clear: (a = {}) => A(n, a),
        bind: () => q(n)
      }));
    }
  ), k = v(
    () => h.value.filter(({ active: e }) => e)
  ), f = v(
    () => x.value.find(({ active: e }) => e)
  ), y = v(
    () => w.value.filter(({ active: e }) => e)
  );
  function j(e) {
    return Array.isArray(e) ? e.join(o.value.delimiter) : e;
  }
  function T(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function V(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function $(e) {
    return [j, T, V].reduce(
      (n, a) => a(n),
      e
    );
  }
  function B(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((a) => a !== e) : [...n, e];
  }
  function M(e) {
    return typeof e != "string" ? e : h.value.find(({ name: n }) => n === e);
  }
  function R(e, n = null) {
    return typeof e != "string" ? e : x.value.find(
      ({ name: a, direction: p }) => a === e && p === n
    );
  }
  function U(e) {
    return typeof e != "string" ? e : w.value.find(({ name: n }) => n === e);
  }
  function J(e) {
    return e ? typeof e == "string" ? k.value.some((n) => n.name === e) : e.active : !!k.value.length;
  }
  function N(e) {
    var n;
    return e ? typeof e == "string" ? ((n = f.value) == null ? void 0 : n.name) === e : e.active : !!f.value;
  }
  function I(e) {
    var n;
    return e ? typeof e == "string" ? (n = y.value) == null ? void 0 : n.some((a) => a.name === e) : e.active : !!o.value.term;
  }
  function b(e, n = {}) {
    const a = Object.fromEntries(
      Object.entries(e).map(([p, t]) => [p, $(t)])
    );
    S.reload({
      ...s,
      ...n,
      data: a
    });
  }
  function P(e, n, a = {}) {
    const p = M(e);
    if (!p) return console.warn(`Filter [${e}] does not exist.`);
    S.reload({
      ...s,
      ...a,
      data: {
        [p.name]: $(n)
      }
    });
  }
  function F(e, n = null, a = {}) {
    if (!m.value)
      return console.warn("Refine cannot perform sorting.");
    const p = R(e, n);
    if (!p) return console.warn(`Sort [${e}] does not exist.`);
    S.reload({
      ...s,
      ...a,
      data: {
        [o.value.sort]: V(p.next)
      }
    });
  }
  function g(e, n = {}) {
    if (!u.value)
      return console.warn("Refine cannot perform searching.");
    e = [T, V].reduce(
      (a, p) => p(a),
      e
    ), S.reload({
      ...s,
      ...n,
      data: {
        [o.value.search]: e
      }
    });
  }
  function A(e, n = {}) {
    if (!i.value || !u.value)
      return console.warn("Refine cannot perform matching.");
    const a = U(e);
    if (!a) return console.warn(`Match [${e}] does not exist.`);
    const p = B(
      a.name,
      y.value.map(({ name: t }) => t)
    );
    S.reload({
      ...s,
      ...n,
      data: {
        [o.value.match]: j(p)
      }
    });
  }
  function C(e, n = {}) {
    if (e) return P(e, null, n);
    S.reload({
      ...s,
      ...n,
      data: Object.fromEntries(
        k.value.map(({ name: a }) => [a, null])
      )
    });
  }
  function O(e = {}) {
    if (!m.value)
      return console.warn("Refine cannot perform sorting.");
    S.reload({
      ...s,
      ...e,
      data: {
        [o.value.sort]: null
      }
    });
  }
  function W(e = {}) {
    g(null, e);
  }
  function z(e = {}) {
    if (!i.value)
      return console.warn("Refine cannot perform matching.");
    S.reload({
      ...s,
      ...e,
      data: {
        [o.value.match]: null
      }
    });
  }
  function E(e = {}) {
    var n;
    S.reload({
      ...s,
      ...e,
      data: {
        [o.value.search ?? ""]: void 0,
        [o.value.sort ?? ""]: void 0,
        [o.value.match ?? ""]: void 0,
        ...Object.fromEntries(
          ((n = o.value.filters) == null ? void 0 : n.map((a) => [
            a.name,
            void 0
          ])) ?? []
        )
      }
    });
  }
  function G(e, n = {}) {
    const a = M(e);
    if (!a) return console.warn(`Filter [${e}] does not exist.`);
    const {
      debounce: p = 250,
      transform: t = (c) => c,
      ...r
    } = n;
    return {
      "onUpdate:modelValue": H((c) => {
        P(a, t(c), r);
      }, p),
      modelValue: a.value
    };
  }
  function K(e, n = {}) {
    const a = R(e);
    if (!a) return console.warn(`Sort [${e}] does not exist.`);
    const { debounce: p = 0, transform: t, ...r } = n;
    return {
      onClick: H(() => {
        var c;
        F(a, (c = f.value) == null ? void 0 : c.direction, r);
      }, p)
    };
  }
  function X(e = {}) {
    const { debounce: n = 700, transform: a, ...p } = e;
    return {
      "onUpdate:modelValue": H(
        (t) => {
          g(t, p);
        },
        n
      ),
      modelValue: o.value.term ?? ""
    };
  }
  function q(e, n = {}) {
    const a = U(e);
    if (!a) return console.warn(`Match [${e}] does not exist.`);
    const { debounce: p = 0, transform: t, ...r } = n;
    return {
      "onUpdate:modelValue": H((c) => {
        A(c, r);
      }, p),
      modelValue: I(a),
      value: a.name
    };
  }
  return Z({
    filters: h,
    sorts: x,
    searches: w,
    currentFilters: k,
    currentSort: f,
    currentSearches: y,
    isSortable: m,
    isSearchable: u,
    isMatchable: i,
    isFiltering: J,
    isSorting: N,
    isSearching: I,
    getFilter: M,
    getSort: R,
    getSearch: U,
    apply: b,
    applyFilter: P,
    applySort: F,
    applySearch: g,
    applyMatch: A,
    clearFilter: C,
    clearSort: O,
    clearSearch: W,
    clearMatch: z,
    reset: E,
    bindFilter: G,
    bindSort: K,
    bindSearch: X,
    bindMatch: q,
    stringValue: T,
    omitValue: V,
    toggleValue: B,
    delimitArray: j
  });
}
function ce(l, d, s = {}) {
  if (!(l != null && l[d]))
    throw new Error("The table must be provided with valid props and key.");
  const { recordOperations: o = {}, ...m } = {
    only: [...s.only ?? [], d.toString()],
    ...s
  }, u = v(() => l[d]), i = le(), h = oe(l, d, m), x = v(() => u.value.id ?? null), w = v(() => u.value.meta), k = v(() => u.value.views ?? []), f = v(() => u.value.emptyState ?? null), y = v(() => u.value.placeholder ?? null), j = v(() => !!u.value.emptyState), T = v(() => !!u.value.page && !!u.value.record), V = v(() => !!u.value.column), $ = v(
    () => u.value.columns.filter(({ active: t, hidden: r }) => t && !r).map((t) => {
      var r;
      return {
        ...t,
        isSorting: !!((r = t.sort) != null && r.active),
        toggleSort: (c = {}) => h.applySort(t.sort, null, c)
      };
    })
  ), B = v(
    () => u.value.columns.filter(({ hidden: t }) => !t).map((t) => ({
      ...t,
      toggle: (r = {}) => e(t.name, r)
    }))
  ), M = v(
    () => u.value.records.map((t) => ({
      /** The operations available for the record */
      operations: z(t.operations),
      /** The classes to apply to the record */
      class: t.class ?? null,
      /** Perform this operation when the record is clicked */
      default: (r = {}) => {
        const c = t.operations.find(
          ({ default: L }) => L
        );
        c && G(c, t, r);
      },
      /** Selects this record */
      select: () => i.select(g(t)),
      /** Deselects this record */
      deselect: () => i.deselect(g(t)),
      /** Toggles the selection of this record */
      toggle: () => i.toggle(g(t)),
      /** Determine if the record is selected */
      selected: i.selected(g(t)),
      /** Bind the record to a checkbox */
      bind: () => i.bind(g(t)),
      /** Get the entry of the record for the column */
      entry: (r) => A(t, r),
      /** Get the value of the record for the column */
      value: (r) => C(t, r),
      /** Get the extra data of the record for the column */
      extra: (r) => O(t, r)
    }))
  ), R = v(() => !!u.value.operations.inline), U = v(() => z(u.value.operations.bulk)), J = v(() => z(u.value.operations.page)), N = v(
    () => u.value.pages.find(({ active: t }) => t)
  ), I = v(() => u.value.pages), b = v(() => ({
    ...u.value.paginate,
    next: (t = {}) => {
      "nextLink" in b.value && b.value.nextLink && E(b.value.nextLink, t);
    },
    previous: (t = {}) => {
      "prevLink" in b.value && b.value.prevLink && E(b.value.prevLink, t);
    },
    first: (t = {}) => {
      "firstLink" in b.value && b.value.firstLink && E(b.value.firstLink, t);
    },
    last: (t = {}) => {
      "lastLink" in b.value && b.value.lastLink && E(b.value.lastLink, t);
    },
    ..."links" in u.value.paginate && u.value.paginate.links ? {
      links: u.value.paginate.links.map((t) => ({
        ...t,
        navigate: (r = {}) => t.url && E(t.url, r)
      }))
    } : {}
  })), P = v(
    () => u.value.records.length > 0 && u.value.records.every(
      (t) => i.selected(g(t))
    )
  );
  function F(t) {
    return typeof t == "string" ? t : t.name;
  }
  function g(t) {
    var r;
    return (r = A(t, u.value.key)) == null ? void 0 : r.v;
  }
  function A(t, r) {
    const c = F(r);
    return c in t && c !== "classes" ? t[c] : null;
  }
  function C(t, r) {
    var c;
    return ((c = A(t, r)) == null ? void 0 : c.v) ?? null;
  }
  function O(t, r) {
    var c;
    return (c = A(t, r)) == null ? void 0 : c.e;
  }
  function W(t, r = {}, c = {}) {
    return _(t, u.value.endpoint, x.value, r, {
      ...m,
      ...c
    });
  }
  function z(t) {
    return ne(
      t,
      u.value.endpoint,
      x.value,
      m
    );
  }
  function E(t, r = {}) {
    S.visit(t, {
      preserveScroll: !0,
      preserveState: !0,
      ...m,
      ...r,
      method: "get"
    });
  }
  function G(t, r, c = {}) {
    var D;
    W(
      t,
      {
        record: g(r)
      },
      c
    ) || (D = o == null ? void 0 : o[t.name]) == null || D.call(o, r);
  }
  function K(t, r = {}) {
    W(
      t,
      {
        all: i.selection.value.all,
        only: Array.from(i.selection.value.only),
        except: Array.from(i.selection.value.except)
      },
      {
        ...r,
        onSuccess: (c) => {
          var L;
          (L = r.onSuccess) == null || L.call(r, c), t.keepSelected || i.deselectAll();
        }
      }
    );
  }
  function X(t, r = {}, c = {}) {
    return W(t, r, c);
  }
  function q(t, r = {}) {
    if (!T.value)
      return console.warn("The table does not support pagination changes.");
    S.reload({
      ...m,
      ...r,
      data: {
        [u.value.record]: t.value,
        [u.value.page]: void 0
      }
    });
  }
  function e(t, r = {}) {
    if (!V.value)
      return console.warn("The table does not support column toggling.");
    const c = F(t);
    if (!c) return console.log(`Column [${t}] does not exist.`);
    const L = h.toggleValue(
      c,
      $.value.map(({ name: D }) => D)
    );
    S.reload({
      ...m,
      ...r,
      data: {
        [u.value.column]: h.delimitArray(L)
      }
    });
  }
  function n() {
    i.select(
      ...u.value.records.map(
        (t) => g(t)
      )
    );
  }
  function a() {
    i.deselect(
      ...u.value.records.map(
        (t) => g(t)
      )
    );
  }
  function p() {
    return {
      "onUpdate:modelValue": (t) => {
        t ? n() : a();
      },
      modelValue: P.value
    };
  }
  return Z({
    /** The identifier of the table */
    id: x,
    /** Table-specific metadata */
    meta: w,
    /** The views for the table */
    views: k,
    /** The empty state for the table */
    emptyState: f,
    /** The placeholder for the search term.*/
    placeholder: y,
    /** Whether the table is empty */
    isEmpty: j,
    /** Whether the table supports changing the number of records to display per page */
    isPageable: T,
    /** Whether the table supports toggling columns */
    isToggleable: V,
    /** Get the entry of the record for the column */
    getEntry: A,
    /** Get the value of the record for the column */
    getValue: C,
    /** Get the extra data of the record for the column */
    getExtra: O,
    /** Retrieve a record's identifier */
    getRecordKey: g,
    /** The heading columns for the table */
    headings: $,
    /** All of the table's columns */
    columns: B,
    /** The records of the table */
    records: M,
    /** Whether the table has record operations */
    inline: R,
    /** The available bulk operations */
    bulk: U,
    /** The available page operations */
    page: J,
    /** The available number of records to display per page */
    pages: I,
    /** The current record per page item */
    currentPage: N,
    /** The pagination metadata */
    paginator: b,
    /** Execute an inline operation */
    executeInline: G,
    /** Execute a bulk operation */
    executeBulk: K,
    /** Execute a page operation */
    executePage: X,
    /** Apply a new page by changing the number of records to display */
    applyPage: q,
    /** The current selection of records */
    selection: i.selection,
    /** Select the given records */
    select: (t) => i.select(g(t)),
    /** Deselect the given records */
    deselect: (t) => i.deselect(g(t)),
    /** Select records on the current page */
    selectPage: n,
    /** Deselect records on the current page */
    deselectPage: a,
    /** Toggle the selection of the given records */
    toggle: (t) => i.toggle(g(t)),
    /** Determine if the given record is selected */
    selected: (t) => i.selected(g(t)),
    /** Select all records */
    selectAll: i.selectAll,
    /** Deselect all records */
    deselectAll: i.deselectAll,
    /** Whether all records on the current page are selected */
    isPageSelected: P,
    /** Determine if any records are selected */
    hasSelected: i.hasSelected,
    /** Bind the given record to a checkbox */
    bindCheckbox: (t) => i.bind(g(t)),
    /** Bind the select all checkbox to the current page */
    bindPage: p,
    /** Bind select all records to the checkbox */
    bindAll: i.bindAll,
    /** Include the sorts, filters, and search query */
    ...h
  });
}
function se(l, d) {
  return l ? typeof l == "object" ? l.type === d : l === d : !1;
}
export {
  se as is,
  ce as useTable
};
