import { ref as Y, computed as d, toValue as J, reactive as Z } from "vue";
import { router as S } from "@inertiajs/vue3";
function _(l, v, c, a = {}) {
  return l.route ? (S.visit(l.route.url, {
    ...a,
    method: l.route.method
  }), !0) : l.action && v ? (S.post(
    v,
    { ...c, name: l.name, type: l.type },
    a
  ), !0) : !1;
}
function X(l, v, c, a = {}, m = {}) {
  return _(
    l,
    v,
    { ...a, id: c ?? void 0 },
    m
  );
}
function ee(l, v, c, a = {}) {
  return l.map((m) => ({
    ...m,
    execute: (o = {}, i = {}) => X(m, v, c, o, { ...a, ...i })
  }));
}
function te() {
  const l = Y({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function v() {
    l.value.all = !0, l.value.only.clear(), l.value.except.clear();
  }
  function c() {
    l.value.all = !1, l.value.only.clear(), l.value.except.clear();
  }
  function a(...s) {
    s.forEach((h) => l.value.except.delete(h)), s.forEach((h) => l.value.only.add(h));
  }
  function m(...s) {
    s.forEach((h) => l.value.except.add(h)), s.forEach((h) => l.value.only.delete(h));
  }
  function o(s, h) {
    if (i(s) || h === !1) return m(s);
    if (!i(s) || h === !0) return a(s);
  }
  function i(s) {
    return l.value.all ? !l.value.except.has(s) : l.value.only.has(s);
  }
  const g = d(() => l.value.all && l.value.except.size === 0), k = d(() => l.value.only.size > 0 || g.value);
  function x(s) {
    return {
      "onUpdate:modelValue": (h) => {
        h ? a(s) : m(s);
      },
      modelValue: i(s),
      value: s
    };
  }
  function w() {
    return {
      "onUpdate:modelValue": (s) => {
        s ? v() : c();
      },
      modelValue: g.value
    };
  }
  return {
    allSelected: g,
    selection: l,
    hasSelected: k,
    selectAll: v,
    deselectAll: c,
    select: a,
    deselect: m,
    toggle: o,
    selected: i,
    bind: x,
    bindAll: w
  };
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const Q = () => {
};
function ne(l, v) {
  function c(...a) {
    return new Promise((m, o) => {
      Promise.resolve(l(() => v.apply(this, a), { fn: v, thisArg: this, args: a })).then(m).catch(o);
    });
  }
  return c;
}
function le(l, v = {}) {
  let c, a, m = Q;
  const o = (g) => {
    clearTimeout(g), m(), m = Q;
  };
  let i;
  return (g) => {
    const k = J(l), x = J(v.maxWait);
    return c && o(c), k <= 0 || x !== void 0 && x <= 0 ? (a && (o(a), a = null), Promise.resolve(g())) : new Promise((w, s) => {
      m = v.rejectOnCancel ? s : w, i = g, x && !a && (a = setTimeout(() => {
        c && o(c), a = null, w(i());
      }, x)), c = setTimeout(() => {
        a && o(a), a = null, w(g());
      }, k);
    });
  };
}
function D(l, v = 200, c = {}) {
  return ne(
    le(v, c),
    l
  );
}
function ae(l, v, c = {}) {
  if (!(l != null && l[v]))
    throw new Error("The refine must be provided with valid props and key.");
  const a = d(() => l[v]), m = d(() => !!a.value.sort), o = d(() => !!a.value.search), i = d(() => !!a.value.match), g = d(
    () => {
      var e;
      return (e = a.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r, p = {}) => P(n, r, p),
        clear: (r = {}) => B(n, r),
        bind: () => q(n.name)
      }));
    }
  ), k = d(
    () => {
      var e;
      return (e = a.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => A(n, n.direction, r),
        clear: (r = {}) => I(r),
        bind: () => t(n)
      }));
    }
  ), x = d(
    () => {
      var e;
      return (e = a.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => $(n, r),
        clear: (r = {}) => $(n, r),
        bind: () => f(n)
      }));
    }
  ), w = d(
    () => g.value.filter(({ active: e }) => e)
  ), s = d(
    () => k.value.find(({ active: e }) => e)
  ), h = d(
    () => x.value.filter(({ active: e }) => e)
  );
  function M(e) {
    return Array.isArray(e) ? e.join(a.value.delimiter) : e;
  }
  function R(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function E(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function W(e) {
    return [M, R, E].reduce(
      (n, r) => r(n),
      e
    );
  }
  function z(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((r) => r !== e) : [...n, e];
  }
  function U(e) {
    return typeof e != "string" ? e : g.value.find(({ name: n }) => n === e);
  }
  function y(e, n = null) {
    return typeof e != "string" ? e : k.value.find(
      ({ name: r, direction: p }) => r === e && p === n
    );
  }
  function T(e) {
    return typeof e != "string" ? e : x.value.find(({ name: n }) => n === e);
  }
  function b(e) {
    return e ? typeof e == "string" ? w.value.some((n) => n.name === e) : e.active : !!w.value.length;
  }
  function G(e) {
    var n;
    return e ? typeof e == "string" ? ((n = s.value) == null ? void 0 : n.name) === e : e.active : !!s.value;
  }
  function F(e) {
    var n;
    return e ? typeof e == "string" ? (n = h.value) == null ? void 0 : n.some((r) => r.name === e) : e.active : !!a.value.term;
  }
  function C(e, n = {}) {
    const r = Object.fromEntries(
      Object.entries(e).map(([p, V]) => [p, W(V)])
    );
    S.reload({
      ...c,
      ...n,
      data: r
    });
  }
  function P(e, n, r = {}) {
    const p = U(e);
    if (!p) return console.warn(`Filter [${e}] does not exist.`);
    S.reload({
      ...c,
      ...r,
      data: {
        [p.name]: W(n)
      }
    });
  }
  function A(e, n = null, r = {}) {
    if (!m.value)
      return console.warn("Refine cannot perform sorting.");
    const p = y(e, n);
    if (!p) return console.warn(`Sort [${e}] does not exist.`);
    S.reload({
      ...c,
      ...r,
      data: {
        [a.value.sort]: E(p.next)
      }
    });
  }
  function j(e, n = {}) {
    if (!o.value)
      return console.warn("Refine cannot perform searching.");
    e = [R, E].reduce(
      (r, p) => p(r),
      e
    ), S.reload({
      ...c,
      ...n,
      data: {
        [a.value.search]: e
      }
    });
  }
  function $(e, n = {}) {
    if (!i.value || !o.value)
      return console.warn("Refine cannot perform matching.");
    const r = T(e);
    if (!r) return console.warn(`Match [${e}] does not exist.`);
    const p = z(
      r.name,
      h.value.map(({ name: V }) => V)
    );
    S.reload({
      ...c,
      ...n,
      data: {
        [a.value.match]: M(p)
      }
    });
  }
  function B(e, n = {}) {
    if (e) return P(e, null, n);
    S.reload({
      ...c,
      ...n,
      data: Object.fromEntries(
        w.value.map(({ name: r }) => [r, null])
      )
    });
  }
  function I(e = {}) {
    if (!m.value)
      return console.warn("Refine cannot perform sorting.");
    S.reload({
      ...c,
      ...e,
      data: {
        [a.value.sort]: null
      }
    });
  }
  function H(e = {}) {
    j(null, e);
  }
  function K(e = {}) {
    if (!i.value)
      return console.warn("Refine cannot perform matching.");
    S.reload({
      ...c,
      ...e,
      data: {
        [a.value.match]: null
      }
    });
  }
  function N(e = {}) {
    var n;
    S.reload({
      ...c,
      ...e,
      data: {
        [a.value.search ?? ""]: void 0,
        [a.value.sort ?? ""]: void 0,
        [a.value.match ?? ""]: void 0,
        ...Object.fromEntries(
          ((n = a.value.filters) == null ? void 0 : n.map((r) => [
            r.name,
            void 0
          ])) ?? []
        )
      }
    });
  }
  function q(e, n = {}) {
    const r = U(e);
    if (!r) return console.warn(`Filter [${e}] does not exist.`);
    const {
      debounce: p = 250,
      transform: V = (L) => L,
      ...O
    } = n;
    return {
      "onUpdate:modelValue": D((L) => {
        P(r, V(L), O);
      }, p),
      modelValue: r.value
    };
  }
  function t(e, n = {}) {
    const r = y(e);
    if (!r) return console.warn(`Sort [${e}] does not exist.`);
    const { debounce: p = 0, transform: V, ...O } = n;
    return {
      onClick: D(() => {
        var L;
        A(r, (L = s.value) == null ? void 0 : L.direction, O);
      }, p)
    };
  }
  function u(e = {}) {
    const { debounce: n = 700, transform: r, ...p } = e;
    return {
      "onUpdate:modelValue": D(
        (V) => {
          j(V, p);
        },
        n
      ),
      modelValue: a.value.term ?? ""
    };
  }
  function f(e, n = {}) {
    const r = T(e);
    if (!r) return console.warn(`Match [${e}] does not exist.`);
    const { debounce: p = 0, transform: V, ...O } = n;
    return {
      "onUpdate:modelValue": D((L) => {
        $(L, O);
      }, p),
      modelValue: F(r),
      value: r.name
    };
  }
  return {
    filters: g,
    sorts: k,
    searches: x,
    currentFilters: w,
    currentSort: s,
    currentSearches: h,
    isSortable: m,
    isSearchable: o,
    isMatchable: i,
    isFiltering: b,
    isSorting: G,
    isSearching: F,
    getFilter: U,
    getSort: y,
    getSearch: T,
    apply: C,
    applyFilter: P,
    applySort: A,
    applySearch: j,
    applyMatch: $,
    clearFilter: B,
    clearSort: I,
    clearSearch: H,
    clearMatch: K,
    reset: N,
    bindFilter: q,
    bindSort: t,
    bindSearch: u,
    bindMatch: f,
    stringValue: R,
    omitValue: E,
    toggleValue: z,
    delimitArray: M
  };
}
function ue(l, v, c = {}) {
  if (!(l != null && l[v]))
    throw new Error("The table must be provided with valid props and key.");
  const { recordOperations: a = {}, ...m } = {
    only: [...c.only ?? [], v.toString()],
    ...c
  }, o = d(() => l[v]), i = te(), g = ae(l, v, m), k = d(() => o.value.meta), x = d(() => !!o.value.page && !!o.value.record), w = d(() => !!o.value.column), s = d(
    () => o.value.columns.filter(({ active: t, hidden: u }) => t && !u).map((t) => {
      var u;
      return {
        ...t,
        isSorting: !!((u = t.sort) != null && u.active),
        toggleSort: (f = {}) => g.applySort(t.sort, null, f)
      };
    })
  ), h = d(
    () => o.value.columns.filter(({ hidden: t }) => !t).map((t) => ({
      ...t,
      toggle: (u = {}) => H(t.name, u)
    }))
  ), M = d(
    () => o.value.records.map((t) => ({
      /** The operations available for the record */
      operations: P(t.operations),
      /** Perform this operation when the record is clicked */
      default: (u = {}) => {
        const f = t.operations.find(
          ({ default: e }) => e
        );
        f && j(f, t, u);
      },
      /** Selects this record */
      select: () => i.select(b(t)),
      /** Deselects this record */
      deselect: () => i.deselect(b(t)),
      /** Toggles the selection of this record */
      toggle: () => i.toggle(b(t)),
      /** Determine if the record is selected */
      selected: i.selected(b(t)),
      /** Bind the record to a checkbox */
      bind: () => i.bind(b(t)),
      /** Get the entry of the record for the column */
      entry: (u) => F(t, u),
      /** Get the value of the record for the column */
      value: (u) => {
        var f;
        return ((f = F(t, u)) == null ? void 0 : f.v) ?? null;
      },
      /** Get the extra data of the record for the column */
      extra: (u) => {
        var f;
        return ((f = F(t, u)) == null ? void 0 : f.e) ?? null;
      }
    }))
  ), R = d(() => !!o.value.operations.inline), E = d(() => P(o.value.operations.bulk)), W = d(() => P(o.value.operations.page)), z = d(
    () => o.value.pages.find(({ active: t }) => t)
  ), U = d(() => o.value.pages), y = d(() => ({
    ...o.value.paginate,
    next: (t = {}) => {
      "nextLink" in y.value && y.value.nextLink && A(y.value.nextLink, t);
    },
    previous: (t = {}) => {
      "prevLink" in y.value && y.value.prevLink && A(y.value.prevLink, t);
    },
    first: (t = {}) => {
      "firstLink" in y.value && y.value.firstLink && A(y.value.firstLink, t);
    },
    last: (t = {}) => {
      "lastLink" in y.value && y.value.lastLink && A(y.value.lastLink, t);
    },
    ..."links" in o.value.paginate && o.value.paginate.links ? {
      links: o.value.paginate.links.map((t) => ({
        ...t,
        navigate: (u = {}) => t.url && A(t.url, u)
      }))
    } : {}
  })), T = d(
    () => o.value.records.length > 0 && o.value.records.every(
      (t) => i.selected(b(t))
    )
  );
  function b(t) {
    return t[o.value.key].v;
  }
  function G(t) {
    return typeof t == "string" ? t : t.name;
  }
  function F(t, u) {
    const f = G(u);
    return f in t ? t[f] : null;
  }
  function C(t, u = {}, f = {}) {
    return X(
      t,
      o.value.endpoint,
      o.value.id,
      u,
      {
        ...m,
        ...f
      }
    );
  }
  function P(t) {
    return ee(
      t,
      o.value.endpoint,
      o.value.id,
      m
    );
  }
  function A(t, u = {}) {
    S.visit(t, {
      preserveScroll: !0,
      preserveState: !0,
      ...m,
      ...u,
      method: "get"
    });
  }
  function j(t, u, f = {}) {
    var n;
    C(
      t,
      {
        record: b(u)
      },
      f
    ) || (n = a == null ? void 0 : a[t.name]) == null || n.call(a, u);
  }
  function $(t, u = {}) {
    C(
      t,
      {
        all: i.selection.value.all,
        only: Array.from(i.selection.value.only),
        except: Array.from(i.selection.value.except)
      },
      {
        ...u,
        onSuccess: (f) => {
          var e;
          (e = u.onSuccess) == null || e.call(u, f), t.keepSelected || i.deselectAll();
        }
      }
    );
  }
  function B(t, u = {}, f = {}) {
    return C(t, u, f);
  }
  function I(t, u = {}) {
    if (!x.value)
      return console.warn("The table does not support pagination changes.");
    S.reload({
      ...m,
      ...u,
      data: {
        [o.value.record]: t.value,
        [o.value.page]: void 0
      }
    });
  }
  function H(t, u = {}) {
    if (!w.value)
      return console.warn("The table does not support column toggling.");
    const f = G(t);
    if (!f) return console.log(`Column [${t}] does not exist.`);
    const e = g.toggleValue(
      f,
      s.value.map(({ name: n }) => n)
    );
    S.reload({
      ...m,
      ...u,
      data: {
        [o.value.column]: g.delimitArray(e)
      }
    });
  }
  function K() {
    i.select(
      ...o.value.records.map(
        (t) => b(t)
      )
    );
  }
  function N() {
    i.deselect(
      ...o.value.records.map(
        (t) => b(t)
      )
    );
  }
  function q() {
    return {
      "onUpdate:modelValue": (t) => {
        t ? K() : N();
      },
      modelValue: T.value
    };
  }
  return Z({
    /** Table-specific metadata */
    meta: k,
    /** Whether the table supports changing the number of records to display per page */
    isPageable: x,
    /** Whether the table supports toggling columns */
    isToggleable: w,
    /** Retrieve a record's identifier */
    getRecordKey: b,
    /** The heading columns for the table */
    headings: s,
    /** All of the table's columns */
    columns: h,
    /** The records of the table */
    records: M,
    /** Whether the table has record operations */
    inline: R,
    /** The available bulk operations */
    bulk: E,
    /** The available page operations */
    page: W,
    /** The available number of records to display per page */
    pages: U,
    /** The current record per page item */
    currentPage: z,
    /** The pagination metadata */
    paginator: y,
    /** Execute an inline operation */
    executeInline: j,
    /** Execute a bulk operation */
    executeBulk: $,
    /** Execute a page operation */
    executePage: B,
    /** Apply a new page by changing the number of records to display */
    applyPage: I,
    /** The current selection of records */
    selection: i.selection,
    /** Select the given records */
    select: (t) => i.select(b(t)),
    /** Deselect the given records */
    deselect: (t) => i.deselect(b(t)),
    /** Select records on the current page */
    selectPage: K,
    /** Deselect records on the current page */
    deselectPage: N,
    /** Toggle the selection of the given records */
    toggle: (t) => i.toggle(b(t)),
    /** Determine if the given record is selected */
    selected: (t) => i.selected(b(t)),
    /** Select all records */
    selectAll: i.selectAll,
    /** Deselect all records */
    deselectAll: i.deselectAll,
    /** Whether all records on the current page are selected */
    isPageSelected: T,
    /** Determine if any records are selected */
    hasSelected: i.hasSelected,
    /** Bind the given record to a checkbox */
    bindCheckbox: (t) => i.bind(b(t)),
    /** Bind the select all checkbox to the current page */
    bindPage: q,
    /** Bind select all records to the checkbox */
    bindAll: i.bindAll,
    /** Include the sorts, filters, and search query */
    ...g
  });
}
function ie(l, v) {
  return l ? typeof l == "object" ? l.type === v : l === v : !1;
}
export {
  ie as is,
  ue as useTable
};
