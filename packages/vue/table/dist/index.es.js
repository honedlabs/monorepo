import { ref as _, computed as h, toValue as N, reactive as Q } from "vue";
import { router as S } from "@inertiajs/vue3";
function X() {
  const o = _({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function f() {
    o.value.all = !0, o.value.only.clear(), o.value.except.clear();
  }
  function v() {
    o.value.all = !1, o.value.only.clear(), o.value.except.clear();
  }
  function l(...s) {
    s.forEach((m) => o.value.except.delete(m)), s.forEach((m) => o.value.only.add(m));
  }
  function i(...s) {
    s.forEach((m) => o.value.except.add(m)), s.forEach((m) => o.value.only.delete(m));
  }
  function u(s, m) {
    if (b(s) || m === !1)
      return i(s);
    if (!b(s) || m === !0)
      return l(s);
  }
  function b(s) {
    return o.value.all ? !o.value.except.has(s) : o.value.only.has(s);
  }
  const d = h(() => o.value.all && o.value.except.size === 0), A = h(() => o.value.only.size > 0 || d.value);
  function x(s) {
    return {
      "onUpdate:modelValue": (m) => {
        m ? l(s) : i(s);
      },
      modelValue: b(s),
      value: s
    };
  }
  function k() {
    return {
      "onUpdate:modelValue": (s) => {
        s ? f() : v();
      },
      modelValue: d.value,
      value: d.value
    };
  }
  return {
    allSelected: d,
    selection: o,
    hasSelected: A,
    selectAll: f,
    deselectAll: v,
    select: l,
    deselect: i,
    toggle: u,
    selected: b,
    bind: x,
    bindAll: k
  };
}
function J(o, f, v = {}, l = {}) {
  return o.route ? (S.visit(o.route.href, {
    ...l,
    method: o.route.method
  }), !0) : o.action && f ? (S.post(
    f,
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
function Z(o, f) {
  function v(...l) {
    return new Promise((i, u) => {
      Promise.resolve(o(() => f.apply(this, l), { fn: f, thisArg: this, args: l })).then(i).catch(u);
    });
  }
  return v;
}
function O(o, f = {}) {
  let v, l, i = Y;
  const u = (d) => {
    clearTimeout(d), i(), i = Y;
  };
  let b;
  return (d) => {
    const A = N(o), x = N(f.maxWait);
    return v && u(v), A <= 0 || x !== void 0 && x <= 0 ? (l && (u(l), l = null), Promise.resolve(d())) : new Promise((k, s) => {
      i = f.rejectOnCancel ? s : k, b = d, x && !l && (l = setTimeout(() => {
        v && u(v), l = null, k(b());
      }, x)), v = setTimeout(() => {
        l && u(l), l = null, k(d());
      }, A);
    });
  };
}
function D(o, f = 200, v = {}) {
  return Z(
    O(f, v),
    o
  );
}
function ee(o, f, v = {}) {
  const l = h(() => o[f]), i = h(
    () => {
      var e;
      return ((e = l.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (a, c = {}) => F(n, a, c),
        clear: (a = {}) => G(n, a),
        bind: () => g(n.name)
      }))) ?? [];
    }
  ), u = h(
    () => {
      var e;
      return ((e = l.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (a = {}) => M(n, n.direction, a),
        clear: (a = {}) => B(a),
        bind: () => P(n)
      }))) ?? [];
    }
  ), b = h(
    () => {
      var e;
      return (e = l.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (a = {}) => $(n, a),
        clear: (a = {}) => $(n, a),
        bind: () => K(n)
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
  function m(e) {
    var n;
    return (n = l.value.filters) == null ? void 0 : n.find((a) => a.name === e);
  }
  function U(e, n = null) {
    var a;
    return (a = l.value.sorts) == null ? void 0 : a.find(
      (c) => c.name === e && c.direction === n
    );
  }
  function C(e) {
    var n;
    return (n = l.value.searches) == null ? void 0 : n.find((a) => a.name === e);
  }
  function W() {
    var e;
    return ((e = l.value.filters) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
  }
  function p() {
    var e;
    return (e = l.value.sorts) == null ? void 0 : e.find(({ active: n }) => n);
  }
  function V() {
    var e;
    return ((e = l.value.searches) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
  }
  function y(e) {
    return e ? typeof e == "string" ? W().some((n) => n.name === e) : e.active : !!W().length;
  }
  function w(e) {
    var n;
    return e ? typeof e == "string" ? ((n = p()) == null ? void 0 : n.name) === e : e.active : !!p();
  }
  function L(e) {
    var n, a;
    return e ? typeof e == "string" ? (a = V()) == null ? void 0 : a.some((c) => c.name === e) : e.active : !!((n = V()) != null && n.length);
  }
  function q(e, n = {}) {
    const a = Object.fromEntries(
      Object.entries(e).map(([c, E]) => [c, k(E)])
    );
    S.reload({
      ...v,
      ...n,
      data: a
    });
  }
  function F(e, n, a = {}) {
    const c = typeof e == "string" ? m(e) : e;
    if (!c) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    "multiple" in c && c.multiple && (n = s(n, c.value)), S.reload({
      ...v,
      ...a,
      data: {
        [c.name]: k(n)
      }
    });
  }
  function M(e, n = null, a = {}) {
    const c = typeof e == "string" ? U(e, n) : e;
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
  function z(e, n = {}) {
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
  function $(e, n = {}) {
    if (!l.value.config.matches) {
      console.warn("Matches key is not set.");
      return;
    }
    if (!(typeof e == "string" ? C(e) : e)) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const a = s(
      e,
      V().filter(({ active: c }) => c).map(({ name: c }) => c)
    );
    S.reload({
      ...v,
      ...n,
      data: {
        [l.value.config.matches]: d(a)
      }
    });
  }
  function G(e, n = {}) {
    F(e, void 0, n);
  }
  function B(e = {}) {
    S.reload({
      ...v,
      ...e,
      data: {
        [l.value.config.sorts]: null
      }
    });
  }
  function H(e = {}) {
    z(void 0, e);
  }
  function t(e = {}) {
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
  function r(e = {}) {
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
  function g(e, n = {}) {
    const a = typeof e == "string" ? m(e) : e;
    if (!a) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    const c = a.value, {
      debounce: E = 250,
      transform: R = (I) => I,
      ...T
    } = n;
    return {
      "onUpdate:modelValue": D((I) => {
        F(a, R(I), T);
      }, E),
      modelValue: c,
      value: c
    };
  }
  function P(e, n = {}) {
    const a = typeof e == "string" ? U(e) : e;
    if (!a) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    const { debounce: c = 0, transform: E, ...R } = n;
    return {
      onClick: D(() => {
        var T;
        M(a, (T = p()) == null ? void 0 : T.direction, R);
      }, c)
    };
  }
  function j(e = {}) {
    const { debounce: n = 700, transform: a, ...c } = e;
    return {
      "onUpdate:modelValue": D((E) => {
        z(E, c);
      }, n),
      modelValue: l.value.config.search ?? "",
      value: l.value.config.search ?? ""
    };
  }
  function K(e, n = {}) {
    const a = typeof e == "string" ? C(e) : e;
    if (!a) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const { debounce: c = 0, transform: E, ...R } = n;
    return {
      "onUpdate:modelValue": D((T) => {
        $(T, R);
      }, c),
      modelValue: L(a),
      value: L(a)
    };
  }
  return {
    filters: i,
    sorts: u,
    searches: b,
    getFilter: m,
    getSort: U,
    getSearch: C,
    currentFilters: W,
    currentSort: p,
    currentSearches: V,
    isFiltering: y,
    isSorting: w,
    isSearching: L,
    apply: q,
    applyFilter: F,
    applySort: M,
    applySearch: z,
    applyMatch: $,
    clearFilter: G,
    clearSort: B,
    clearSearch: H,
    clearMatch: t,
    reset: r,
    bindFilter: g,
    bindSort: P,
    bindSearch: j,
    bindMatch: K,
    stringValue: A,
    omitValue: x,
    toggleValue: s,
    delimitArray: d
  };
}
function le(o, f, v = {}, l = {}) {
  l = {
    ...l,
    only: [...l.only ?? [], f.toString()]
  };
  const i = h(() => o[f]), u = X(), b = ee(o, f, l), d = h(() => i.value.config), A = h(() => i.value.meta), x = h(
    () => {
      var t;
      return ((t = i.value.columns) == null ? void 0 : t.filter(({ active: r, hidden: g }) => r && !g).map((r) => {
        var g;
        return {
          ...r,
          isSorting: (g = r.sort) == null ? void 0 : g.active,
          toggleSort: (P = {}) => z(r, P)
        };
      })) ?? [];
    }
  ), k = h(
    () => {
      var t;
      return ((t = i.value.columns) == null ? void 0 : t.filter(({ hidden: r }) => !r).map((r) => ({
        ...r,
        toggle: (g = {}) => $(r, g)
      }))) ?? [];
    }
  ), s = h(
    () => i.value.records.map((t) => ({
      ...t,
      /** Perform this action when the record is clicked */
      default: (r = {}) => {
        const g = t.actions.find(
          (P) => P.default
        );
        g && L(g, t, r);
      },
      /** The actions available for the record */
      actions: t.actions.map((r) => ({
        ...r,
        /** Executes this action */
        execute: (g = {}) => L(r, t, g)
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
      bind: () => u.bind(y(t))
    }))
  ), m = h(
    () => i.value.actions.bulk.map((t) => ({
      ...t,
      /** Executes this bulk action */
      execute: (r = {}) => q(t, r)
    }))
  ), U = h(
    () => i.value.actions.page.map((t) => ({
      ...t,
      /** Executes this page action */
      execute: (r = {}) => F(t, r)
    }))
  ), C = h(
    () => i.value.recordsPerPage.map((t) => ({
      ...t,
      /** Changes the number of records to display per page */
      apply: (r = {}) => M(t, r)
    }))
  ), W = h(
    () => i.value.recordsPerPage.find(({ active: t }) => t)
  ), p = h(() => ({
    ...i.value.paginator,
    next: (t = {}) => {
      "nextLink" in p.value && p.value.nextLink && w(p.value.nextLink, t);
    },
    previous: (t = {}) => {
      "prevLink" in p.value && p.value.prevLink && w(p.value.prevLink, t);
    },
    first: (t = {}) => {
      "firstLink" in p.value && p.value.firstLink && w(p.value.firstLink, t);
    },
    last: (t = {}) => {
      "lastLink" in p.value && p.value.lastLink && w(p.value.lastLink, t);
    },
    ..."links" in i.value.paginator && i.value.paginator.links ? {
      links: i.value.paginator.links.map((t) => ({
        ...t,
        navigate: (r = {}) => t.url && w(t.url, r)
      }))
    } : {}
  })), V = h(
    () => i.value.records.length > 0 && i.value.records.every(
      (t) => u.selected(y(t))
    )
  );
  function y(t) {
    return t[d.value.record];
  }
  function w(t, r = {}) {
    S.visit(t, {
      preserveScroll: !0,
      preserveState: !0,
      ...l,
      ...r,
      method: "get"
    });
  }
  function L(t, r, g = {}) {
    var j, K;
    J(
      t,
      d.value.endpoint,
      {
        table: i.value.id,
        id: y(r)
      },
      g
    ) || (K = (j = v.recordActions) == null ? void 0 : j[t.name]) == null || K.call(j, r);
  }
  function q(t, r = {}) {
    J(
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
  function F(t, r = {}) {
    J(
      t,
      d.value.endpoint,
      {
        table: i.value.id
      },
      r
    );
  }
  function M(t, r = {}) {
    S.reload({
      ...l,
      ...r,
      data: {
        [d.value.records]: t.value,
        [d.value.pages]: void 0
      }
    });
  }
  function z(t, r = {}) {
    t.sort && S.reload({
      ...l,
      ...r,
      data: {
        [d.value.sorts]: b.omitValue(t.sort.next)
      }
    });
  }
  function $(t, r = {}) {
    const g = b.toggleValue(
      t.name,
      x.value.map(({ name: P }) => P)
    );
    S.reload({
      ...l,
      ...r,
      data: {
        [d.value.columns]: b.delimitArray(g)
      }
    });
  }
  function G() {
    u.select(
      ...i.value.records.map((t) => y(t))
    );
  }
  function B() {
    u.deselect(
      ...i.value.records.map((t) => y(t))
    );
  }
  function H() {
    return {
      "onUpdate:modelValue": (t) => {
        t ? G() : B();
      },
      modelValue: V.value
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
    bulkActions: m,
    /** The available page actions */
    pageActions: U,
    /** The available number of records to display per page */
    rowsPerPage: C,
    /** The current record per page item */
    currentPage: W,
    /** The pagination metadata */
    paginator: p,
    /** Execute an inline action */
    executeInlineAction: L,
    /** Execute a bulk action */
    executeBulkAction: q,
    /** Execute a page action */
    executePageAction: F,
    /** Apply a new page by changing the number of records to display */
    applyPage: M,
    /** The current selection of records */
    selection: u.selection,
    /** Select the given records */
    select: (t) => u.select(y(t)),
    /** Deselect the given records */
    deselect: (t) => u.deselect(y(t)),
    /** Select records on the current page */
    selectPage: G,
    /** Deselect records on the current page */
    deselectPage: B,
    /** Toggle the selection of the given records */
    toggle: (t) => u.toggle(y(t)),
    /** Determine if the given record is selected */
    selected: (t) => u.selected(y(t)),
    /** Select all records */
    selectAll: u.selectAll,
    /** Deselect all records */
    deselectAll: u.deselectAll,
    /** Whether all records on the current page are selected */
    isPageSelected: V,
    /** Determine if any records are selected */
    hasSelected: u.hasSelected,
    /** Bind the given record to a checkbox */
    bindCheckbox: (t) => u.bind(y(t)),
    /** Bind the select all checkbox to the current page */
    bindPage: H,
    /** Bind select all records to the checkbox */
    bindAll: u.bindAll,
    /** Include the sorts, filters, and search query */
    ...b
  });
}
export {
  le as useTable
};
