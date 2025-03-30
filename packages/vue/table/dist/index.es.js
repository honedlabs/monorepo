import { ref as _, computed as g, toValue as J, reactive as Q } from "vue";
import { router as x } from "@inertiajs/vue3";
function X() {
  const o = _({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function m() {
    o.value.all = !0, o.value.only.clear(), o.value.except.clear();
  }
  function v() {
    o.value.all = !1, o.value.only.clear(), o.value.except.clear();
  }
  function l(...c) {
    c.forEach((p) => o.value.except.delete(p)), c.forEach((p) => o.value.only.add(p));
  }
  function i(...c) {
    c.forEach((p) => o.value.except.add(p)), c.forEach((p) => o.value.only.delete(p));
  }
  function u(c, p) {
    if (b(c) || p === !1)
      return i(c);
    if (!b(c) || p === !0)
      return l(c);
  }
  function b(c) {
    return o.value.all ? !o.value.except.has(c) : o.value.only.has(c);
  }
  const f = g(() => o.value.all && o.value.except.size === 0), A = g(() => o.value.only.size > 0 || f.value);
  function S(c) {
    return {
      "onUpdate:modelValue": (p) => {
        p ? l(c) : i(c);
      },
      modelValue: b(c),
      value: c
    };
  }
  function k() {
    return {
      "onUpdate:modelValue": (c) => {
        c ? m() : v();
      },
      modelValue: f.value,
      value: f.value
    };
  }
  return {
    allSelected: f,
    selection: o,
    hasSelected: A,
    selectAll: m,
    deselectAll: v,
    select: l,
    deselect: i,
    toggle: u,
    selected: b,
    bind: S,
    bindAll: k
  };
}
function I(o, m, v = {}, l = {}) {
  return o.route ? (x.visit(o.route.url, {
    ...l,
    method: o.route.method
  }), !0) : o.action && m ? (x.post(
    m,
    {
      ...v,
      name: o.name,
      type: o.type
    },
    l
  ), !0) : !1;
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const Y = () => {
};
function Z(o, m) {
  function v(...l) {
    return new Promise((i, u) => {
      Promise.resolve(o(() => m.apply(this, l), { fn: m, thisArg: this, args: l })).then(i).catch(u);
    });
  }
  return v;
}
function O(o, m = {}) {
  let v, l, i = Y;
  const u = (f) => {
    clearTimeout(f), i(), i = Y;
  };
  let b;
  return (f) => {
    const A = J(o), S = J(m.maxWait);
    return v && u(v), A <= 0 || S !== void 0 && S <= 0 ? (l && (u(l), l = null), Promise.resolve(f())) : new Promise((k, c) => {
      i = m.rejectOnCancel ? c : k, b = f, S && !l && (l = setTimeout(() => {
        v && u(v), l = null, k(b());
      }, S)), v = setTimeout(() => {
        l && u(l), l = null, k(f());
      }, A);
    });
  };
}
function q(o, m = 200, v = {}) {
  return Z(
    O(m, v),
    o
  );
}
function ee(o, m, v = {}) {
  const l = g(() => o[m]), i = g(
    () => {
      var e;
      return ((e = l.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r, d = {}) => L(n, r, d),
        clear: (r = {}) => N(n, r),
        bind: () => a(n.name)
      }))) ?? [];
    }
  ), u = g(
    () => {
      var e;
      return ((e = l.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => M(n, n.direction, r),
        clear: (r = {}) => W(r),
        bind: () => s(n)
      }))) ?? [];
    }
  ), b = g(
    () => {
      var e;
      return (e = l.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => U(n, r),
        clear: (r = {}) => U(n, r),
        bind: () => F(n)
      }));
    }
  ), f = g(
    () => {
      var e;
      return ((e = l.value.filters) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
    }
  ), A = g(
    () => {
      var e;
      return (e = l.value.sorts) == null ? void 0 : e.find(({ active: n }) => n);
    }
  ), S = g(
    () => {
      var e;
      return ((e = l.value.searches) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
    }
  );
  function k(e) {
    return Array.isArray(e) ? e.join(l.value.config.delimiter) : e;
  }
  function c(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function p(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function G(e) {
    return [k, c, p].reduce(
      (n, r) => r(n),
      e
    );
  }
  function B(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((r) => r !== e) : [...n, e];
  }
  function j(e) {
    var n;
    return (n = l.value.filters) == null ? void 0 : n.find((r) => r.name === e);
  }
  function h(e, n = null) {
    var r;
    return (r = l.value.sorts) == null ? void 0 : r.find(
      (d) => d.name === e && d.direction === n
    );
  }
  function E(e) {
    var n;
    return (n = l.value.searches) == null ? void 0 : n.find((r) => r.name === e);
  }
  function y(e) {
    return e ? typeof e == "string" ? f.value.some((n) => n.name === e) : e.active : !!f.value.length;
  }
  function K(e) {
    var n;
    return e ? typeof e == "string" ? ((n = A.value) == null ? void 0 : n.name) === e : e.active : !!A.value;
  }
  function P(e) {
    var n;
    return e ? typeof e == "string" ? (n = S.value) == null ? void 0 : n.some((r) => r.name === e) : e.active : !!l.value.config.term;
  }
  function C(e, n = {}) {
    const r = Object.fromEntries(
      Object.entries(e).map(([d, V]) => [d, G(V)])
    );
    x.reload({
      ...v,
      ...n,
      data: r
    });
  }
  function L(e, n, r = {}) {
    const d = typeof e == "string" ? j(e) : e;
    if (!d) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    x.reload({
      ...v,
      ...r,
      data: {
        [d.name]: G(n)
      }
    });
  }
  function M(e, n = null, r = {}) {
    const d = typeof e == "string" ? h(e, n) : e;
    if (!d) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    x.reload({
      ...v,
      ...r,
      data: {
        [l.value.config.sort]: p(d.next)
      }
    });
  }
  function T(e, n = {}) {
    e = [c, p].reduce(
      (r, d) => d(r),
      e
    ), x.reload({
      ...v,
      ...n,
      data: {
        [l.value.config.search]: e
      }
    });
  }
  function U(e, n = {}) {
    const r = typeof e == "string" ? E(e) : e;
    if (!r) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const d = B(
      r.name,
      S.value.map(({ name: V }) => V)
    );
    x.reload({
      ...v,
      ...n,
      data: {
        [l.value.config.match]: k(d)
      }
    });
  }
  function N(e, n = {}) {
    L(e, void 0, n);
  }
  function W(e = {}) {
    x.reload({
      ...v,
      ...e,
      data: {
        [l.value.config.sort]: void 0
      }
    });
  }
  function R(e = {}) {
    T(void 0, e);
  }
  function D(e = {}) {
    if (!l.value.config.match) {
      console.warn("Matches key is not set.");
      return;
    }
    x.reload({
      ...v,
      ...e,
      data: {
        [l.value.config.match]: void 0
      }
    });
  }
  function t(e = {}) {
    var n;
    x.reload({
      ...v,
      ...e,
      data: {
        [l.value.config.search]: void 0,
        [l.value.config.sort]: void 0,
        [l.value.config.match]: void 0,
        ...Object.fromEntries(
          ((n = l.value.filters) == null ? void 0 : n.map((r) => [
            r.name,
            void 0
          ])) ?? []
        )
      }
    });
  }
  function a(e, n = {}) {
    const r = typeof e == "string" ? j(e) : e;
    if (!r) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    const d = r.value, {
      debounce: V = 250,
      transform: z = (H) => H,
      ...$
    } = n;
    return {
      "onUpdate:modelValue": q((H) => {
        L(r, z(H), $);
      }, V),
      modelValue: d
    };
  }
  function s(e, n = {}) {
    const r = typeof e == "string" ? h(e) : e;
    if (!r) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    const { debounce: d = 0, transform: V, ...z } = n;
    return {
      onClick: q(() => {
        var $;
        M(r, ($ = A.value) == null ? void 0 : $.direction, z);
      }, d)
    };
  }
  function w(e = {}) {
    const { debounce: n = 700, transform: r, ...d } = e;
    return {
      "onUpdate:modelValue": q(
        (V) => {
          T(V, d);
        },
        n
      ),
      modelValue: l.value.config.term ?? ""
    };
  }
  function F(e, n = {}) {
    const r = typeof e == "string" ? E(e) : e;
    if (!r) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const { debounce: d = 0, transform: V, ...z } = n;
    return {
      "onUpdate:modelValue": q(($) => {
        U($, z);
      }, d),
      modelValue: P(r),
      value: r.name
    };
  }
  return {
    filters: i,
    sorts: u,
    searches: b,
    getFilter: j,
    getSort: h,
    getSearch: E,
    currentFilters: f,
    currentSort: A,
    currentSearches: S,
    isFiltering: y,
    isSorting: K,
    isSearching: P,
    apply: C,
    applyFilter: L,
    applySort: M,
    applySearch: T,
    applyMatch: U,
    clearFilter: N,
    clearSort: W,
    clearSearch: R,
    clearMatch: D,
    reset: t,
    bindFilter: a,
    bindSort: s,
    bindSearch: w,
    bindMatch: F,
    stringValue: c,
    omitValue: p,
    toggleValue: B,
    delimitArray: k
  };
}
function le(o, m, v = {}, l = {}) {
  if (!o || !m || !o[m])
    throw new Error("Table has not been provided with valid props and key.");
  l = {
    ...l,
    only: [...l.only ?? [], m.toString()]
  };
  const i = g(() => o[m]), u = X(), b = ee(o, m, l), f = g(() => i.value.config), A = g(() => i.value.meta), S = g(
    () => {
      var t;
      return ((t = i.value.columns) == null ? void 0 : t.filter(({ active: a, hidden: s }) => a && !s).map((a) => {
        var s;
        return {
          ...a,
          isSorting: (s = a.sort) == null ? void 0 : s.active,
          toggleSort: (w = {}) => U(a, w)
        };
      })) ?? [];
    }
  ), k = g(
    () => {
      var t;
      return ((t = i.value.columns) == null ? void 0 : t.filter(({ hidden: a }) => !a).map((a) => ({
        ...a,
        toggle: (s = {}) => N(a, s)
      }))) ?? [];
    }
  ), c = g(
    () => i.value.records.map((t) => ({
      record: (({ actions: a, ...s }) => s)(t),
      /** Perform this action when the record is clicked */
      default: (a = {}) => {
        const s = t.actions.find(
          (w) => w.default
        );
        s && C(s, t, a);
      },
      /** The actions available for the record */
      actions: t.actions.map((a) => ({
        ...a,
        /** Executes this action */
        execute: (s = {}) => C(a, t, s)
      })),
      /** Selects this record */
      select: () => u.select(y(t)),
      /** Deselects this record */
      deselect: () => u.deselect(y(t)),
      /** Toggles the selection of this record */
      toggle: () => u.toggle(y(t)),
      /** Determine if the record is selected */
      selected: u.selected(y(t)),
      /** Bind the record to a checkbox */
      bind: () => u.bind(y(t)),
      /** Get the value of the record for the column */
      value: (a) => {
        const s = K(a);
        return s in t ? t[s].value : null;
      },
      /** Get the extra data of the record for the column */
      extra: (a) => {
        const s = K(a);
        return s in t ? t[s].extra : null;
      }
    }))
  ), p = g(
    () => i.value.actions.bulk.map((t) => ({
      ...t,
      /** Executes this bulk action */
      execute: (a = {}) => L(t, a)
    }))
  ), G = g(
    () => i.value.actions.page.map((t) => ({
      ...t,
      /** Executes this page action */
      execute: (a = {}) => M(t, a)
    }))
  ), B = g(
    () => {
      var t;
      return ((t = i.value.recordsPerPage) == null ? void 0 : t.map((a) => ({
        ...a,
        /** Changes the number of records to display per page */
        apply: (s = {}) => T(a, s)
      }))) ?? [];
    }
  ), j = g(
    () => {
      var t;
      return (t = i.value.recordsPerPage) == null ? void 0 : t.find(({ active: a }) => a);
    }
  ), h = g(() => ({
    ...i.value.paginator,
    next: (t = {}) => {
      "nextLink" in h.value && h.value.nextLink && P(h.value.nextLink, t);
    },
    previous: (t = {}) => {
      "prevLink" in h.value && h.value.prevLink && P(h.value.prevLink, t);
    },
    first: (t = {}) => {
      "firstLink" in h.value && h.value.firstLink && P(h.value.firstLink, t);
    },
    last: (t = {}) => {
      "lastLink" in h.value && h.value.lastLink && P(h.value.lastLink, t);
    },
    ..."links" in i.value.paginator && i.value.paginator.links ? {
      links: i.value.paginator.links.map((t) => ({
        ...t,
        navigate: (a = {}) => t.url && P(t.url, a)
      }))
    } : {}
  })), E = g(
    () => i.value.records.length > 0 && i.value.records.every(
      (t) => u.selected(y(t))
    )
  );
  function y(t) {
    return t[f.value.key].value;
  }
  function K(t) {
    return typeof t == "string" ? t : t.name;
  }
  function P(t, a = {}) {
    x.visit(t, {
      preserveScroll: !0,
      preserveState: !0,
      ...l,
      ...a,
      method: "get"
    });
  }
  function C(t, a, s = {}) {
    var F, e;
    I(
      t,
      f.value.endpoint,
      {
        table: i.value.id,
        id: y(a)
      },
      s
    ) || (e = (F = v.recordActions) == null ? void 0 : F[t.name]) == null || e.call(F, a);
  }
  function L(t, a = {}) {
    I(
      t,
      f.value.endpoint,
      {
        table: i.value.id,
        all: u.selection.value.all,
        only: Array.from(u.selection.value.only),
        except: Array.from(u.selection.value.except)
      },
      a
    );
  }
  function M(t, a = {}) {
    I(
      t,
      f.value.endpoint,
      {
        table: i.value.id
      },
      a
    );
  }
  function T(t, a = {}) {
    x.reload({
      ...l,
      ...a,
      data: {
        [f.value.record]: t.value,
        [f.value.page]: void 0
      }
    });
  }
  function U(t, a = {}) {
    t.sort && x.reload({
      ...l,
      ...a,
      data: {
        [f.value.sort]: b.omitValue(t.sort.next)
      }
    });
  }
  function N(t, a = {}) {
    const s = b.toggleValue(
      t.name,
      S.value.map(({ name: w }) => w)
    );
    x.reload({
      ...l,
      ...a,
      data: {
        [f.value.column]: b.delimitArray(s)
      }
    });
  }
  function W() {
    u.select(
      ...i.value.records.map(
        (t) => y(t)
      )
    );
  }
  function R() {
    u.deselect(
      ...i.value.records.map(
        (t) => y(t)
      )
    );
  }
  function D() {
    return {
      "onUpdate:modelValue": (t) => {
        t ? W() : R();
      },
      modelValue: E.value
    };
  }
  return Q({
    /** Retrieve a record's identifier */
    getRecordKey: y,
    /** Table-specific metadata */
    meta: A,
    /** The heading columns for the table */
    headings: S,
    /** All of the table's columns */
    columns: k,
    /** The records of the table */
    records: c,
    /** The available bulk actions */
    bulkActions: p,
    /** The available page actions */
    pageActions: G,
    /** The available number of records to display per page */
    rowsPerPage: B,
    /** The current record per page item */
    currentPage: j,
    /** The pagination metadata */
    paginator: h,
    /** Execute an inline action */
    executeInlineAction: C,
    /** Execute a bulk action */
    executeBulkAction: L,
    /** Execute a page action */
    executePageAction: M,
    /** Apply a new page by changing the number of records to display */
    applyPage: T,
    /** The current selection of records */
    selection: u.selection,
    /** Select the given records */
    select: (t) => u.select(y(t)),
    /** Deselect the given records */
    deselect: (t) => u.deselect(y(t)),
    /** Select records on the current page */
    selectPage: W,
    /** Deselect records on the current page */
    deselectPage: R,
    /** Toggle the selection of the given records */
    toggle: (t) => u.toggle(y(t)),
    /** Determine if the given record is selected */
    selected: (t) => u.selected(y(t)),
    /** Select all records */
    selectAll: u.selectAll,
    /** Deselect all records */
    deselectAll: u.deselectAll,
    /** Whether all records on the current page are selected */
    isPageSelected: E,
    /** Determine if any records are selected */
    hasSelected: u.hasSelected,
    /** Bind the given record to a checkbox */
    bindCheckbox: (t) => u.bind(y(t)),
    /** Bind the select all checkbox to the current page */
    bindPage: D,
    /** Bind select all records to the checkbox */
    bindAll: u.bindAll,
    /** Include the sorts, filters, and search query */
    ...b
  });
}
export {
  le as useTable
};
