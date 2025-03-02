import { ref as D, computed as p, toValue as R, reactive as _ } from "vue";
import { router as S } from "@inertiajs/vue3";
function H() {
  const a = D({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function v() {
    a.value.all = !0, a.value.only.clear(), a.value.except.clear();
  }
  function s() {
    a.value.all = !1, a.value.only.clear(), a.value.except.clear();
  }
  function l(...u) {
    u.forEach((d) => a.value.except.delete(d)), u.forEach((d) => a.value.only.add(d));
  }
  function o(...u) {
    u.forEach((d) => a.value.except.add(d)), u.forEach((d) => a.value.only.delete(d));
  }
  function i(u, d) {
    if (h(u) || d === !1)
      return o(u);
    if (!h(u) || d === !0)
      return l(u);
  }
  function h(u) {
    return a.value.all ? !a.value.except.has(u) : a.value.only.has(u);
  }
  const f = p(() => a.value.all && a.value.except.size === 0), y = p(() => a.value.only.size > 0 || f.value);
  function x(u) {
    return {
      "onUpdate:modelValue": (d) => {
        console.log("Checked:", d), d ? l(u) : o(u);
      },
      modelValue: h(u),
      value: u
    };
  }
  function b() {
    return {
      "onUpdate:modelValue": (u) => {
        console.log("Checked:", u), u ? v() : s();
      },
      modelValue: f.value
    };
  }
  return {
    allSelected: f,
    selection: a,
    hasSelected: y,
    selectAll: v,
    deselectAll: s,
    select: l,
    deselect: o,
    toggle: i,
    selected: h,
    bind: x,
    bindAll: b
  };
}
function I(a, v, s = {}, l = {}) {
  return a.route ? (S.visit(a.route.href, {
    ...l,
    method: a.route.method
  }), !0) : a.action && v ? (S.post(
    v,
    {
      ...s,
      name: a.name,
      type: a.type
    },
    l
  ), !0) : !1;
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const q = () => {
};
function J(a, v) {
  function s(...l) {
    return new Promise((o, i) => {
      Promise.resolve(a(() => v.apply(this, l), { fn: v, thisArg: this, args: l })).then(o).catch(i);
    });
  }
  return s;
}
function M(a, v = {}) {
  let s, l, o = q;
  const i = (f) => {
    clearTimeout(f), o(), o = q;
  };
  let h;
  return (f) => {
    const y = R(a), x = R(v.maxWait);
    return s && i(s), y <= 0 || x !== void 0 && x <= 0 ? (l && (i(l), l = null), Promise.resolve(f())) : new Promise((b, u) => {
      o = v.rejectOnCancel ? u : b, h = f, x && !l && (l = setTimeout(() => {
        s && i(s), l = null, b(h());
      }, x)), s = setTimeout(() => {
        l && i(l), l = null, b(f());
      }, y);
    });
  };
}
function K(a, v = 200, s = {}) {
  return J(
    M(v, s),
    a
  );
}
function N(a, v, s = {}) {
  const l = p(() => a[v]), o = p(
    () => l.value.filters.map((e) => ({
      ...e,
      apply: (n, r = {}) => P(e, n, r),
      clear: (n = {}) => U(e, n),
      bind: () => C(e.name)
    }))
  ), i = p(
    () => l.value.sorts.map((e) => ({
      ...e,
      apply: (n = {}) => w(e, e.direction, n),
      clear: (n = {}) => $(n),
      bind: () => z(e)
    }))
  );
  function h(e) {
    return Array.isArray(e) ? e.join(l.value.config.delimiter) : e;
  }
  function f(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function y(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function x(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((r) => r !== e) : [...n, e];
  }
  function b(e, n = null) {
    return l.value.sorts.find(
      (r) => r.name === e && r.direction === n
    );
  }
  function u(e) {
    return l.value.filters.find((n) => n.name === e);
  }
  function d(e) {
    var n;
    return (n = l.value.searches) == null ? void 0 : n.find((r) => r.name === e);
  }
  function V() {
    return l.value.sorts.find(({ active: e }) => e);
  }
  function L() {
    return l.value.filters.filter(({ active: e }) => e);
  }
  function m() {
    var e;
    return ((e = l.value.searches) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
  }
  function T(e) {
    var n;
    return e ? ((n = V()) == null ? void 0 : n.name) === e : !!V();
  }
  function g(e) {
    return e ? L().some((n) => n.name === e) : !!L().length;
  }
  function A(e) {
    var n, r;
    return e ? (n = m()) == null ? void 0 : n.some((c) => c.name === e) : !!((r = m()) != null && r.length);
  }
  function P(e, n, r = {}) {
    const c = typeof e == "string" ? u(e) : e;
    if (!c) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    "multiple" in c && c.multiple && (n = x(n, c.value)), n = [h, f, y].reduce(
      (k, E) => E(k),
      n
    ), console.log(n), S.reload({
      ...s,
      ...r,
      data: {
        [c.name]: n
      }
    });
  }
  function w(e, n = null, r = {}) {
    const c = typeof e == "string" ? b(e, n) : e;
    if (!c) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    S.reload({
      ...s,
      ...r,
      data: {
        [l.value.config.sorts]: y(c.next)
      }
    });
  }
  function F(e, n = {}) {
    e = [f, y].reduce(
      (r, c) => c(r),
      e
    ), S.reload({
      ...s,
      ...n,
      data: {
        [l.value.config.searches]: e
      }
    });
  }
  function U(e, n = {}) {
    P(e, void 0, n);
  }
  function $(e = {}) {
    S.reload({
      ...s,
      ...e,
      data: {
        [l.value.config.sorts]: null
      }
    });
  }
  function B(e = {}) {
    F(void 0, e);
  }
  function j(e = {}) {
    S.reload({
      ...s,
      ...e,
      data: {
        [l.value.config.searches]: void 0,
        [l.value.config.sorts]: void 0,
        ...Object.fromEntries(
          l.value.filters.map((n) => [n.name, void 0])
        ),
        ...l.value.config.matches ? { [l.value.config.matches]: void 0 } : {}
      }
    });
  }
  function C(e, n = {}) {
    const r = typeof e == "string" ? u(e) : e;
    if (!r) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    const c = r.value, {
      debounce: k = 250,
      transform: E = (G) => G,
      ...W
    } = n;
    return {
      "onUpdate:modelValue": K((G) => {
        P(r, E(G), W);
      }, k),
      modelValue: c,
      value: c
    };
  }
  function z(e, n = {}) {
    const r = typeof e == "string" ? b(e) : e;
    if (!r) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    const { debounce: c = 0, transform: k, ...E } = n;
    return {
      onClick: K(() => {
        var W;
        w(r, (W = V()) == null ? void 0 : W.direction, E);
      }, c)
    };
  }
  function t(e = {}) {
    const { debounce: n = 700, transform: r, ...c } = e;
    return {
      "onUpdate:modelValue": K((k) => {
        F(k, c);
      }, n),
      modelValue: l.value.config.search ?? ""
    };
  }
  return {
    // refinements,
    filters: o,
    sorts: i,
    // searches,
    getSort: b,
    getFilter: u,
    getSearch: d,
    currentSort: V,
    currentFilters: L,
    currentSearches: m,
    isSorting: T,
    isFiltering: g,
    isSearching: A,
    applyFilter: P,
    applySort: w,
    applySearch: F,
    clearFilter: U,
    clearSort: $,
    clearSearch: B,
    reset: j,
    bindFilter: C,
    bindSort: z,
    // bindMatch,
    bindSearch: t,
    /** Provide the helpers */
    stringValue: f,
    omitValue: y,
    toggleValue: x,
    delimitArray: h
  };
}
function Y(a, v, s = {}, l = {}) {
  l = {
    ...l,
    only: [...l.only ?? [], v.toString()]
  };
  const o = p(() => a[v]), i = H(), h = N(a, v, l), f = p(() => o.value.config), y = p(
    () => o.value.columns.filter(({ active: t, hidden: e }) => t && !e).map((t) => ({
      ...t,
      applySort: (e = {}) => $(t, e)
    }))
  ), x = p(
    () => o.value.columns.filter(({ hidden: t }) => !t).map((t) => ({
      ...t,
      toggleColumn: (e = {}) => B(t, e)
    }))
  ), b = p(
    () => o.value.records.map((t) => ({
      ...t,
      /** Perform this action when the record is clicked */
      default: (e = {}) => {
        const n = t.actions.find(
          (r) => r.default
        );
        n && P(n, t, e);
      },
      /** The actions available for the record */
      actions: t.actions.map((e) => ({
        ...e,
        /** Executes this action */
        execute: (n = {}) => P(e, t, n)
      })),
      /** Selects this record */
      select: () => i.select(g(t)),
      /** Deselects this record */
      deselect: () => i.deselect(g(t)),
      /** Toggles the selection of this record */
      toggle: () => i.toggle(g(t)),
      /** Determine if the record is selected */
      selected: i.selected(g(t)),
      /** Bind the record to a checkbox */
      bind: () => i.bind(g(t))
    }))
  ), u = p(
    () => o.value.actions.bulk.map((t) => ({
      ...t,
      /** Executes this bulk action */
      execute: (e = {}) => w(t, e)
    }))
  ), d = p(
    () => o.value.actions.page.map((t) => ({
      ...t,
      /** Executes this page action */
      execute: (e = {}) => F(t, e)
    }))
  ), V = p(
    () => o.value.recordsPerPage.map((t) => ({
      ...t,
      /** Changes the number of records to display per page */
      apply: (e = {}) => U(t, e)
    }))
  ), L = p(
    () => o.value.recordsPerPage.find(({ active: t }) => t)
  ), m = p(() => ({
    ...o.value.paginator,
    next: (t = {}) => {
      "nextLink" in m.value && m.value.nextLink && A(m.value.nextLink, t);
    },
    previous: (t = {}) => {
      "prevLink" in m.value && m.value.prevLink && A(m.value.prevLink, t);
    },
    first: (t = {}) => {
      "firstLink" in m.value && m.value.firstLink && A(m.value.firstLink, t);
    },
    last: (t = {}) => {
      "lastLink" in m.value && m.value.lastLink && A(m.value.lastLink, t);
    },
    ..."links" in o.value.paginator && o.value.paginator.links ? {
      links: o.value.paginator.links.map((t) => ({
        ...t,
        navigate: (e = {}) => t.url && A(t.url, e)
      }))
    } : {}
  })), T = p(
    () => o.value.records.length > 0 && o.value.records.every(
      (t) => i.selected(g(t))
    )
  );
  function g(t) {
    return t[f.value.record];
  }
  function A(t, e = {}) {
    S.visit(t, {
      ...l,
      ...e,
      preserveState: !0,
      method: "get"
    });
  }
  function P(t, e, n = {}) {
    var c, k;
    I(
      t,
      f.value.endpoint,
      {
        table: o.value.id,
        id: g(e)
      },
      n
    ) || (k = (c = s.recordActions) == null ? void 0 : c[t.name]) == null || k.call(c, e);
  }
  function w(t, e = {}) {
    I(
      t,
      f.value.endpoint,
      {
        table: o.value.id,
        all: i.selection.value.all,
        only: Array.from(i.selection.value.only),
        except: Array.from(i.selection.value.except)
      },
      e
    );
  }
  function F(t, e = {}) {
    I(
      t,
      f.value.endpoint,
      {
        table: o.value.id
      },
      e
    );
  }
  function U(t, e = {}) {
    S.reload({
      ...l,
      ...e,
      data: {
        [f.value.records]: t.value,
        [f.value.pages]: void 0
      }
    });
  }
  function $(t, e = {}) {
    t.sort && S.reload({
      ...l,
      ...e,
      data: {
        [f.value.sorts]: h.omitValue(t.sort.next)
      }
    });
  }
  function B(t, e = {}) {
    const n = h.toggleValue(
      t.name,
      y.value.map(({ name: r }) => r)
    );
    S.reload({
      ...l,
      ...e,
      data: {
        [f.value.columns]: h.delimitArray(n)
      }
    });
  }
  function j() {
    i.select(
      ...o.value.records.map((t) => g(t))
    );
  }
  function C() {
    i.deselect(
      ...o.value.records.map((t) => g(t))
    );
  }
  function z() {
    return {
      "onUpdate:modelValue": (t) => {
        t ? j() : C();
      },
      modelValue: T.value
    };
  }
  return _({
    headings: y,
    columns: x,
    records: b,
    bulkActions: u,
    pageActions: d,
    rowsPerPage: V,
    currentPage: L,
    paginator: m,
    isPageSelected: T,
    selectPage: j,
    deselectPage: C,
    /** The current selection of records */
    selection: i.selection,
    /** Select the given records */
    select: (t) => i.select(g(t)),
    /** Deselect the given records */
    deselect: (t) => i.deselect(g(t)),
    /** Toggle the selection of the given records */
    toggle: (t) => i.toggle(g(t)),
    /** Determine if the given record is selected */
    selected: (t) => i.selected(g(t)),
    /** Determine if any records are selected */
    hasSelected: i.hasSelected,
    /** Bind the select all checkbox to the current page */
    bindPage: z,
    /** Bind the given record to a checkbox */
    bind: (t) => i.bind(g(t)),
    /** Include the sorts, filters, and search query */
    ...h
  });
}
export {
  Y as useTable
};
