import { ref as _, computed as h, toValue as J, reactive as Q } from "vue";
import { router as S } from "@inertiajs/vue3";
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
  function l(...s) {
    s.forEach((p) => o.value.except.delete(p)), s.forEach((p) => o.value.only.add(p));
  }
  function i(...s) {
    s.forEach((p) => o.value.except.add(p)), s.forEach((p) => o.value.only.delete(p));
  }
  function u(s, p) {
    if (b(s) || p === !1)
      return i(s);
    if (!b(s) || p === !0)
      return l(s);
  }
  function b(s) {
    return o.value.all ? !o.value.except.has(s) : o.value.only.has(s);
  }
  const d = h(() => o.value.all && o.value.except.size === 0), A = h(() => o.value.only.size > 0 || d.value);
  function x(s) {
    return {
      "onUpdate:modelValue": (p) => {
        p ? l(s) : i(s);
      },
      modelValue: b(s),
      value: s
    };
  }
  function k() {
    return {
      "onUpdate:modelValue": (s) => {
        s ? m() : v();
      },
      modelValue: d.value,
      value: d.value
    };
  }
  return {
    allSelected: d,
    selection: o,
    hasSelected: A,
    selectAll: m,
    deselectAll: v,
    select: l,
    deselect: i,
    toggle: u,
    selected: b,
    bind: x,
    bindAll: k
  };
}
function I(o, m, v = {}, l = {}) {
  return o.route ? (S.visit(o.route.href, {
    ...l,
    method: o.route.method
  }), !0) : o.action && m ? (S.post(
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
  const u = (d) => {
    clearTimeout(d), i(), i = Y;
  };
  let b;
  return (d) => {
    const A = J(o), x = J(m.maxWait);
    return v && u(v), A <= 0 || x !== void 0 && x <= 0 ? (l && (u(l), l = null), Promise.resolve(d())) : new Promise((k, s) => {
      i = m.rejectOnCancel ? s : k, b = d, x && !l && (l = setTimeout(() => {
        v && u(v), l = null, k(b());
      }, x)), v = setTimeout(() => {
        l && u(l), l = null, k(d());
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
  const l = h(() => o[m]), i = h(
    () => {
      var e;
      return ((e = l.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (a, c = {}) => F(n, a, c),
        clear: (a = {}) => N(n, a),
        bind: () => r(n.name)
      }))) ?? [];
    }
  ), u = h(
    () => {
      var e;
      return ((e = l.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (a = {}) => M(n, n.direction, a),
        clear: (a = {}) => W(a),
        bind: () => f(n)
      }))) ?? [];
    }
  ), b = h(
    () => {
      var e;
      return (e = l.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (a = {}) => U(n, a),
        clear: (a = {}) => U(n, a),
        bind: () => E(n)
      }));
    }
  );
  function d(e) {
    return Array.isArray(e) ? e.join(l.value.config.delimiter) : e;
  }
  function A(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function x(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function k(e) {
    return [d, A, x].reduce(
      (n, a) => a(n),
      e
    );
  }
  function s(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((a) => a !== e) : [...n, e];
  }
  function p(e) {
    var n;
    return (n = l.value.filters) == null ? void 0 : n.find((a) => a.name === e);
  }
  function j(e, n = null) {
    var a;
    return (a = l.value.sorts) == null ? void 0 : a.find(
      (c) => c.name === e && c.direction === n
    );
  }
  function C(e) {
    var n;
    return (n = l.value.searches) == null ? void 0 : n.find((a) => a.name === e);
  }
  function z() {
    var e;
    return ((e = l.value.filters) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
  }
  function g() {
    var e;
    return (e = l.value.sorts) == null ? void 0 : e.find(({ active: n }) => n);
  }
  function L() {
    var e;
    return ((e = l.value.searches) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
  }
  function y(e) {
    return e ? typeof e == "string" ? z().some((n) => n.name === e) : e.active : !!z().length;
  }
  function K(e) {
    var n;
    return e ? typeof e == "string" ? ((n = g()) == null ? void 0 : n.name) === e : e.active : !!g();
  }
  function V(e) {
    var n, a;
    return e ? typeof e == "string" ? (a = L()) == null ? void 0 : a.some((c) => c.name === e) : e.active : !!((n = L()) != null && n.length);
  }
  function G(e, n = {}) {
    const a = Object.fromEntries(
      Object.entries(e).map(([c, P]) => [c, k(P)])
    );
    S.reload({
      ...v,
      ...n,
      data: a
    });
  }
  function F(e, n, a = {}) {
    const c = typeof e == "string" ? p(e) : e;
    if (!c) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    "multiple" in c && c.multiple && n !== void 0 && (n = s(n, c.value)), S.reload({
      ...v,
      ...a,
      data: {
        [c.name]: k(n)
      }
    });
  }
  function M(e, n = null, a = {}) {
    const c = typeof e == "string" ? j(e, n) : e;
    if (!c) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    S.reload({
      ...v,
      ...a,
      data: {
        [l.value.config.sorts]: x(c.next)
      }
    });
  }
  function T(e, n = {}) {
    e = [A, x].reduce(
      (a, c) => c(a),
      e
    ), S.reload({
      ...v,
      ...n,
      data: {
        [l.value.config.searches]: e
      }
    });
  }
  function U(e, n = {}) {
    if (!l.value.config.matches) {
      console.warn("Matches key is not set.");
      return;
    }
    const a = typeof e == "string" ? C(e) : e;
    if (!a) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const c = s(
      a.name,
      L().map(({ name: P }) => P)
    );
    S.reload({
      ...v,
      ...n,
      data: {
        [l.value.config.matches]: d(c)
      }
    });
  }
  function N(e, n = {}) {
    F(e, void 0, n);
  }
  function W(e = {}) {
    S.reload({
      ...v,
      ...e,
      data: {
        [l.value.config.sorts]: null
      }
    });
  }
  function R(e = {}) {
    T(void 0, e);
  }
  function D(e = {}) {
    if (!l.value.config.matches) {
      console.warn("Matches key is not set.");
      return;
    }
    S.reload({
      ...v,
      ...e,
      data: {
        [l.value.config.matches]: void 0
      }
    });
  }
  function t(e = {}) {
    var n;
    S.reload({
      ...v,
      ...e,
      data: {
        [l.value.config.searches]: void 0,
        [l.value.config.sorts]: void 0,
        ...Object.fromEntries(
          ((n = l.value.filters) == null ? void 0 : n.map((a) => [
            a.name,
            void 0
          ])) ?? []
        ),
        ...l.value.config.matches ? { [l.value.config.matches]: void 0 } : {}
      }
    });
  }
  function r(e, n = {}) {
    const a = typeof e == "string" ? p(e) : e;
    if (!a) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    const c = a.value, {
      debounce: P = 250,
      transform: B = (H) => H,
      ...$
    } = n;
    return {
      "onUpdate:modelValue": q((H) => {
        F(a, B(H), $);
      }, P),
      modelValue: c
    };
  }
  function f(e, n = {}) {
    const a = typeof e == "string" ? j(e) : e;
    if (!a) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    const { debounce: c = 0, transform: P, ...B } = n;
    return {
      onClick: q(() => {
        var $;
        M(a, ($ = g()) == null ? void 0 : $.direction, B);
      }, c)
    };
  }
  function w(e = {}) {
    const { debounce: n = 700, transform: a, ...c } = e;
    return {
      "onUpdate:modelValue": q(
        (P) => {
          T(P, c);
        },
        n
      ),
      modelValue: l.value.config.search ?? ""
    };
  }
  function E(e, n = {}) {
    const a = typeof e == "string" ? C(e) : e;
    if (!a) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const { debounce: c = 0, transform: P, ...B } = n;
    return {
      "onUpdate:modelValue": q(($) => {
        U($, B);
      }, c),
      modelValue: V(a),
      value: a.name
    };
  }
  return {
    filters: i,
    sorts: u,
    searches: b,
    getFilter: p,
    getSort: j,
    getSearch: C,
    currentFilters: z,
    currentSort: g,
    currentSearches: L,
    isFiltering: y,
    isSorting: K,
    isSearching: V,
    apply: G,
    applyFilter: F,
    applySort: M,
    applySearch: T,
    applyMatch: U,
    clearFilter: N,
    clearSort: W,
    clearSearch: R,
    clearMatch: D,
    reset: t,
    bindFilter: r,
    bindSort: f,
    bindSearch: w,
    bindMatch: E,
    stringValue: A,
    omitValue: x,
    toggleValue: s,
    delimitArray: d
  };
}
function le(o, m, v = {}, l = {}) {
  if (!o || !m || !o[m])
    throw new Error("Table has not been provided with valid props and key.");
  l = {
    ...l,
    only: [...l.only ?? [], m.toString()]
  };
  const i = h(() => o[m]), u = X(), b = ee(o, m, l), d = h(() => i.value.config), A = h(() => i.value.meta), x = h(
    () => {
      var t;
      return ((t = i.value.columns) == null ? void 0 : t.filter(({ active: r, hidden: f }) => r && !f).map((r) => {
        var f;
        return {
          ...r,
          isSorting: (f = r.sort) == null ? void 0 : f.active,
          toggleSort: (w = {}) => U(r, w)
        };
      })) ?? [];
    }
  ), k = h(
    () => {
      var t;
      return ((t = i.value.columns) == null ? void 0 : t.filter(({ hidden: r }) => !r).map((r) => ({
        ...r,
        toggle: (f = {}) => N(r, f)
      }))) ?? [];
    }
  ), s = h(
    () => i.value.records.map((t) => ({
      record: (({ actions: r, ...f }) => f)(t),
      /** Perform this action when the record is clicked */
      default: (r = {}) => {
        const f = t.actions.find(
          (w) => w.default
        );
        f && G(f, t, r);
      },
      /** The actions available for the record */
      actions: t.actions.map((r) => ({
        ...r,
        /** Executes this action */
        execute: (f = {}) => G(r, t, f)
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
      value: (r) => t[K(r)].value,
      /** Get the extra data of the record for the column */
      extra: (r) => t[K(r)].extra
    }))
  ), p = h(
    () => i.value.actions.bulk.map((t) => ({
      ...t,
      /** Executes this bulk action */
      execute: (r = {}) => F(t, r)
    }))
  ), j = h(
    () => i.value.actions.page.map((t) => ({
      ...t,
      /** Executes this page action */
      execute: (r = {}) => M(t, r)
    }))
  ), C = h(
    () => {
      var t;
      return ((t = i.value.recordsPerPage) == null ? void 0 : t.map((r) => ({
        ...r,
        /** Changes the number of records to display per page */
        apply: (f = {}) => T(r, f)
      }))) ?? [];
    }
  ), z = h(
    () => {
      var t;
      return (t = i.value.recordsPerPage) == null ? void 0 : t.find(({ active: r }) => r);
    }
  ), g = h(() => ({
    ...i.value.paginator,
    next: (t = {}) => {
      "nextLink" in g.value && g.value.nextLink && V(g.value.nextLink, t);
    },
    previous: (t = {}) => {
      "prevLink" in g.value && g.value.prevLink && V(g.value.prevLink, t);
    },
    first: (t = {}) => {
      "firstLink" in g.value && g.value.firstLink && V(g.value.firstLink, t);
    },
    last: (t = {}) => {
      "lastLink" in g.value && g.value.lastLink && V(g.value.lastLink, t);
    },
    ..."links" in i.value.paginator && i.value.paginator.links ? {
      links: i.value.paginator.links.map((t) => ({
        ...t,
        navigate: (r = {}) => t.url && V(t.url, r)
      }))
    } : {}
  })), L = h(
    () => i.value.records.length > 0 && i.value.records.every(
      (t) => u.selected(y(t))
    )
  );
  function y(t) {
    return t[d.value.record].value;
  }
  function K(t) {
    return typeof t == "string" ? t : t.name;
  }
  function V(t, r = {}) {
    S.visit(t, {
      preserveScroll: !0,
      preserveState: !0,
      ...l,
      ...r,
      method: "get"
    });
  }
  function G(t, r, f = {}) {
    var E, e;
    I(
      t,
      d.value.endpoint,
      {
        table: i.value.id,
        id: y(r)
      },
      f
    ) || (e = (E = v.recordActions) == null ? void 0 : E[t.name]) == null || e.call(E, r);
  }
  function F(t, r = {}) {
    I(
      t,
      d.value.endpoint,
      {
        table: i.value.id,
        all: u.selection.value.all,
        only: Array.from(u.selection.value.only),
        except: Array.from(u.selection.value.except)
      },
      r
    );
  }
  function M(t, r = {}) {
    I(
      t,
      d.value.endpoint,
      {
        table: i.value.id
      },
      r
    );
  }
  function T(t, r = {}) {
    S.reload({
      ...l,
      ...r,
      data: {
        [d.value.records]: t.value,
        [d.value.pages]: void 0
      }
    });
  }
  function U(t, r = {}) {
    t.sort && S.reload({
      ...l,
      ...r,
      data: {
        [d.value.sorts]: b.omitValue(t.sort.next)
      }
    });
  }
  function N(t, r = {}) {
    const f = b.toggleValue(
      t.name,
      x.value.map(({ name: w }) => w)
    );
    S.reload({
      ...l,
      ...r,
      data: {
        [d.value.columns]: b.delimitArray(f)
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
      modelValue: L.value
    };
  }
  return Q({
    /** Retrieve a record's identifier */
    getRecordKey: y,
    /** Table-specific metadata */
    meta: A,
    /** The heading columns for the table */
    headings: x,
    /** All of the table's columns */
    columns: k,
    /** The records of the table */
    records: s,
    /** The available bulk actions */
    bulkActions: p,
    /** The available page actions */
    pageActions: j,
    /** The available number of records to display per page */
    rowsPerPage: C,
    /** The current record per page item */
    currentPage: z,
    /** The pagination metadata */
    paginator: g,
    /** Execute an inline action */
    executeInlineAction: G,
    /** Execute a bulk action */
    executeBulkAction: F,
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
    isPageSelected: L,
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
