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
        apply: (r, c = {}) => L(n, r, c),
        clear: (r = {}) => N(n, r),
        bind: () => a(n.name)
      }))) ?? [];
    }
  ), u = h(
    () => {
      var e;
      return ((e = l.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => M(n, n.direction, r),
        clear: (r = {}) => W(r),
        bind: () => f(n)
      }))) ?? [];
    }
  ), b = h(
    () => {
      var e;
      return (e = l.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => U(n, r),
        clear: (r = {}) => U(n, r),
        bind: () => F(n)
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
      (n, r) => r(n),
      e
    );
  }
  function s(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((r) => r !== e) : [...n, e];
  }
  function p(e) {
    var n;
    return (n = l.value.filters) == null ? void 0 : n.find((r) => r.name === e);
  }
  function j(e, n = null) {
    var r;
    return (r = l.value.sorts) == null ? void 0 : r.find(
      (c) => c.name === e && c.direction === n
    );
  }
  function C(e) {
    var n;
    return (n = l.value.searches) == null ? void 0 : n.find((r) => r.name === e);
  }
  function z() {
    var e;
    return ((e = l.value.filters) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
  }
  function g() {
    var e;
    return (e = l.value.sorts) == null ? void 0 : e.find(({ active: n }) => n);
  }
  function w() {
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
  function P(e) {
    var n, r;
    return e ? typeof e == "string" ? (r = w()) == null ? void 0 : r.some((c) => c.name === e) : e.active : !!((n = w()) != null && n.length);
  }
  function G(e, n = {}) {
    const r = Object.fromEntries(
      Object.entries(e).map(([c, E]) => [c, k(E)])
    );
    S.reload({
      ...v,
      ...n,
      data: r
    });
  }
  function L(e, n, r = {}) {
    const c = typeof e == "string" ? p(e) : e;
    if (!c) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    "multiple" in c && c.multiple && (n = s(n, c.value)), S.reload({
      ...v,
      ...r,
      data: {
        [c.name]: k(n)
      }
    });
  }
  function M(e, n = null, r = {}) {
    const c = typeof e == "string" ? j(e, n) : e;
    if (!c) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    S.reload({
      ...v,
      ...r,
      data: {
        [l.value.config.sorts]: x(c.next)
      }
    });
  }
  function T(e, n = {}) {
    e = [A, x].reduce(
      (r, c) => c(r),
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
    if (!(typeof e == "string" ? C(e) : e)) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const r = s(
      e,
      w().filter(({ active: c }) => c).map(({ name: c }) => c)
    );
    S.reload({
      ...v,
      ...n,
      data: {
        [l.value.config.matches]: d(r)
      }
    });
  }
  function N(e, n = {}) {
    L(e, void 0, n);
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
        [l.value.config.matches]: null
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
          ((n = l.value.filters) == null ? void 0 : n.map((r) => [
            r.name,
            void 0
          ])) ?? []
        ),
        ...l.value.config.matches ? { [l.value.config.matches]: void 0 } : {}
      }
    });
  }
  function a(e, n = {}) {
    const r = typeof e == "string" ? p(e) : e;
    if (!r) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    const c = r.value, {
      debounce: E = 250,
      transform: B = (H) => H,
      ...$
    } = n;
    return {
      "onUpdate:modelValue": q((H) => {
        L(r, B(H), $);
      }, E),
      modelValue: c
    };
  }
  function f(e, n = {}) {
    const r = typeof e == "string" ? j(e) : e;
    if (!r) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    const { debounce: c = 0, transform: E, ...B } = n;
    return {
      onClick: q(() => {
        var $;
        M(r, ($ = g()) == null ? void 0 : $.direction, B);
      }, c)
    };
  }
  function V(e = {}) {
    const { debounce: n = 700, transform: r, ...c } = e;
    return {
      "onUpdate:modelValue": q(
        (E) => {
          T(E, c);
        },
        n
      ),
      modelValue: l.value.config.search ?? ""
    };
  }
  function F(e, n = {}) {
    const r = typeof e == "string" ? C(e) : e;
    if (!r) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const { debounce: c = 0, transform: E, ...B } = n;
    return {
      "onUpdate:modelValue": q(($) => {
        U($, B);
      }, c),
      modelValue: P(r)
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
    currentSearches: w,
    isFiltering: y,
    isSorting: K,
    isSearching: P,
    apply: G,
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
    bindSort: f,
    bindSearch: V,
    bindMatch: F,
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
      return ((t = i.value.columns) == null ? void 0 : t.filter(({ active: a, hidden: f }) => a && !f).map((a) => {
        var f;
        return {
          ...a,
          isSorting: (f = a.sort) == null ? void 0 : f.active,
          toggleSort: (V = {}) => U(a, V)
        };
      })) ?? [];
    }
  ), k = h(
    () => {
      var t;
      return ((t = i.value.columns) == null ? void 0 : t.filter(({ hidden: a }) => !a).map((a) => ({
        ...a,
        toggle: (f = {}) => N(a, f)
      }))) ?? [];
    }
  ), s = h(
    () => i.value.records.map((t) => ({
      record: (({ actions: a, ...f }) => f)(t),
      /** Perform this action when the record is clicked */
      default: (a = {}) => {
        const f = t.actions.find(
          (V) => V.default
        );
        f && G(f, t, a);
      },
      /** The actions available for the record */
      actions: t.actions.map((a) => ({
        ...a,
        /** Executes this action */
        execute: (f = {}) => G(a, t, f)
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
      value: (a) => t[K(a)].value,
      /** Get the extra data of the record for the column */
      extra: (a) => t[K(a)].extra
    }))
  ), p = h(
    () => i.value.actions.bulk.map((t) => ({
      ...t,
      /** Executes this bulk action */
      execute: (a = {}) => L(t, a)
    }))
  ), j = h(
    () => i.value.actions.page.map((t) => ({
      ...t,
      /** Executes this page action */
      execute: (a = {}) => M(t, a)
    }))
  ), C = h(
    () => {
      var t;
      return ((t = i.value.recordsPerPage) == null ? void 0 : t.map((a) => ({
        ...a,
        /** Changes the number of records to display per page */
        apply: (f = {}) => T(a, f)
      }))) ?? [];
    }
  ), z = h(
    () => {
      var t;
      return (t = i.value.recordsPerPage) == null ? void 0 : t.find(({ active: a }) => a);
    }
  ), g = h(() => ({
    ...i.value.paginator,
    next: (t = {}) => {
      "nextLink" in g.value && g.value.nextLink && P(g.value.nextLink, t);
    },
    previous: (t = {}) => {
      "prevLink" in g.value && g.value.prevLink && P(g.value.prevLink, t);
    },
    first: (t = {}) => {
      "firstLink" in g.value && g.value.firstLink && P(g.value.firstLink, t);
    },
    last: (t = {}) => {
      "lastLink" in g.value && g.value.lastLink && P(g.value.lastLink, t);
    },
    ..."links" in i.value.paginator && i.value.paginator.links ? {
      links: i.value.paginator.links.map((t) => ({
        ...t,
        navigate: (a = {}) => t.url && P(t.url, a)
      }))
    } : {}
  })), w = h(
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
  function P(t, a = {}) {
    S.visit(t, {
      preserveScroll: !0,
      preserveState: !0,
      ...l,
      ...a,
      method: "get"
    });
  }
  function G(t, a, f = {}) {
    var F, e;
    I(
      t,
      d.value.endpoint,
      {
        table: i.value.id,
        id: y(a)
      },
      f
    ) || (e = (F = v.recordActions) == null ? void 0 : F[t.name]) == null || e.call(F, a);
  }
  function L(t, a = {}) {
    I(
      t,
      d.value.endpoint,
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
      d.value.endpoint,
      {
        table: i.value.id
      },
      a
    );
  }
  function T(t, a = {}) {
    S.reload({
      ...l,
      ...a,
      data: {
        [d.value.records]: t.value,
        [d.value.pages]: void 0
      }
    });
  }
  function U(t, a = {}) {
    t.sort && S.reload({
      ...l,
      ...a,
      data: {
        [d.value.sorts]: b.omitValue(t.sort.next)
      }
    });
  }
  function N(t, a = {}) {
    const f = b.toggleValue(
      t.name,
      x.value.map(({ name: V }) => V)
    );
    S.reload({
      ...l,
      ...a,
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
      modelValue: w.value
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
    isPageSelected: w,
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
