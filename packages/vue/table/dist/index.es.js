import { ref as _, computed as g, toValue as J, reactive as Q } from "vue";
import { router as x } from "@inertiajs/vue3";
function I(o, m, v = {}, a = {}) {
  return o.route ? (x.visit(o.route.url, {
    ...a,
    method: o.route.method
  }), !0) : o.action && m ? (x.post(
    m,
    {
      ...v,
      name: o.name,
      type: o.type
    },
    a
  ), !0) : !1;
}
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
  function a(...s) {
    s.forEach((p) => o.value.except.delete(p)), s.forEach((p) => o.value.only.add(p));
  }
  function i(...s) {
    s.forEach((p) => o.value.except.add(p)), s.forEach((p) => o.value.only.delete(p));
  }
  function u(s, p) {
    if (b(s) || p === !1)
      return i(s);
    if (!b(s) || p === !0)
      return a(s);
  }
  function b(s) {
    return o.value.all ? !o.value.except.has(s) : o.value.only.has(s);
  }
  const f = g(() => o.value.all && o.value.except.size === 0), A = g(() => o.value.only.size > 0 || f.value);
  function S(s) {
    return {
      "onUpdate:modelValue": (p) => {
        p ? a(s) : i(s);
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
    select: a,
    deselect: i,
    toggle: u,
    selected: b,
    bind: S,
    bindAll: k
  };
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const Y = () => {
};
function Z(o, m) {
  function v(...a) {
    return new Promise((i, u) => {
      Promise.resolve(o(() => m.apply(this, a), { fn: m, thisArg: this, args: a })).then(i).catch(u);
    });
  }
  return v;
}
function O(o, m = {}) {
  let v, a, i = Y;
  const u = (f) => {
    clearTimeout(f), i(), i = Y;
  };
  let b;
  return (f) => {
    const A = J(o), S = J(m.maxWait);
    return v && u(v), A <= 0 || S !== void 0 && S <= 0 ? (a && (u(a), a = null), Promise.resolve(f())) : new Promise((k, s) => {
      i = m.rejectOnCancel ? s : k, b = f, S && !a && (a = setTimeout(() => {
        v && u(v), a = null, k(b());
      }, S)), v = setTimeout(() => {
        a && u(a), a = null, k(f());
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
  const a = g(() => o[m]), i = g(
    () => {
      var e;
      return ((e = a.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r, d = {}) => L(n, r, d),
        clear: (r = {}) => N(n, r),
        bind: () => l(n.name)
      }))) ?? [];
    }
  ), u = g(
    () => {
      var e;
      return ((e = a.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => M(n, n.direction, r),
        clear: (r = {}) => W(r),
        bind: () => c(n)
      }))) ?? [];
    }
  ), b = g(
    () => {
      var e;
      return (e = a.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => U(n, r),
        clear: (r = {}) => U(n, r),
        bind: () => F(n)
      }));
    }
  ), f = g(
    () => {
      var e;
      return ((e = a.value.filters) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
    }
  ), A = g(
    () => {
      var e;
      return (e = a.value.sorts) == null ? void 0 : e.find(({ active: n }) => n);
    }
  ), S = g(
    () => {
      var e;
      return ((e = a.value.searches) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
    }
  );
  function k(e) {
    return Array.isArray(e) ? e.join(a.value.config.delimiter) : e;
  }
  function s(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function p(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function G(e) {
    return [k, s, p].reduce(
      (n, r) => r(n),
      e
    );
  }
  function B(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((r) => r !== e) : [...n, e];
  }
  function j(e) {
    var n;
    return (n = a.value.filters) == null ? void 0 : n.find((r) => r.name === e);
  }
  function h(e, n = null) {
    var r;
    return (r = a.value.sorts) == null ? void 0 : r.find(
      (d) => d.name === e && d.direction === n
    );
  }
  function E(e) {
    var n;
    return (n = a.value.searches) == null ? void 0 : n.find((r) => r.name === e);
  }
  function y(e) {
    return e ? typeof e == "string" ? f.value.some((n) => n.name === e) : e.active : !!f.value.length;
  }
  function K(e) {
    var n;
    return e ? typeof e == "string" ? ((n = A.value) == null ? void 0 : n.name) === e : e.active : !!A.value;
  }
  function w(e) {
    var n;
    return e ? typeof e == "string" ? (n = S.value) == null ? void 0 : n.some((r) => r.name === e) : e.active : !!a.value.config.term;
  }
  function C(e, n = {}) {
    const r = Object.fromEntries(
      Object.entries(e).map(([d, P]) => [d, G(P)])
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
        [a.value.config.sort]: p(d.next)
      }
    });
  }
  function T(e, n = {}) {
    e = [s, p].reduce(
      (r, d) => d(r),
      e
    ), x.reload({
      ...v,
      ...n,
      data: {
        [a.value.config.search]: e
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
      S.value.map(({ name: P }) => P)
    );
    x.reload({
      ...v,
      ...n,
      data: {
        [a.value.config.match]: k(d)
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
        [a.value.config.sort]: void 0
      }
    });
  }
  function R(e = {}) {
    T(void 0, e);
  }
  function D(e = {}) {
    if (!a.value.config.match) {
      console.warn("Matches key is not set.");
      return;
    }
    x.reload({
      ...v,
      ...e,
      data: {
        [a.value.config.match]: void 0
      }
    });
  }
  function t(e = {}) {
    var n;
    x.reload({
      ...v,
      ...e,
      data: {
        [a.value.config.search]: void 0,
        [a.value.config.sort]: void 0,
        [a.value.config.match]: void 0,
        ...Object.fromEntries(
          ((n = a.value.filters) == null ? void 0 : n.map((r) => [
            r.name,
            void 0
          ])) ?? []
        )
      }
    });
  }
  function l(e, n = {}) {
    const r = typeof e == "string" ? j(e) : e;
    if (!r) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    const d = r.value, {
      debounce: P = 250,
      transform: z = (H) => H,
      ...$
    } = n;
    return {
      "onUpdate:modelValue": q((H) => {
        L(r, z(H), $);
      }, P),
      modelValue: d
    };
  }
  function c(e, n = {}) {
    const r = typeof e == "string" ? h(e) : e;
    if (!r) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    const { debounce: d = 0, transform: P, ...z } = n;
    return {
      onClick: q(() => {
        var $;
        M(r, ($ = A.value) == null ? void 0 : $.direction, z);
      }, d)
    };
  }
  function V(e = {}) {
    const { debounce: n = 700, transform: r, ...d } = e;
    return {
      "onUpdate:modelValue": q(
        (P) => {
          T(P, d);
        },
        n
      ),
      modelValue: a.value.config.term ?? ""
    };
  }
  function F(e, n = {}) {
    const r = typeof e == "string" ? E(e) : e;
    if (!r) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const { debounce: d = 0, transform: P, ...z } = n;
    return {
      "onUpdate:modelValue": q(($) => {
        U($, z);
      }, d),
      modelValue: w(r),
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
    isSearching: w,
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
    bindFilter: l,
    bindSort: c,
    bindSearch: V,
    bindMatch: F,
    stringValue: s,
    omitValue: p,
    toggleValue: B,
    delimitArray: k
  };
}
function le(o, m, v = {}, a = {}) {
  if (!o || !m || !o[m])
    throw new Error("Table has not been provided with valid props and key.");
  a = {
    ...a,
    only: [...a.only ?? [], m.toString()]
  };
  const i = g(() => o[m]), u = X(), b = ee(o, m, a), f = g(() => i.value.config), A = g(() => i.value.meta), S = g(
    () => {
      var t;
      return ((t = i.value.columns) == null ? void 0 : t.filter(({ active: l, hidden: c }) => l && !c).map((l) => {
        var c;
        return {
          ...l,
          isSorting: (c = l.sort) == null ? void 0 : c.active,
          toggleSort: (V = {}) => U(l, V)
        };
      })) ?? [];
    }
  ), k = g(
    () => {
      var t;
      return ((t = i.value.columns) == null ? void 0 : t.filter(({ hidden: l }) => !l).map((l) => ({
        ...l,
        toggle: (c = {}) => N(l, c)
      }))) ?? [];
    }
  ), s = g(
    () => i.value.records.map((t) => ({
      record: (({ actions: l, ...c }) => c)(t),
      /** The actions available for the record */
      actions: t.actions.map((l) => ({
        ...l,
        /** Executes this action */
        execute: (c = {}) => C(l, t, c)
      })),
      /** Perform this action when the record is clicked */
      default: (l = {}) => {
        const c = t.actions.find(
          (V) => V.default
        );
        c && C(c, t, l);
      },
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
      value: (l) => {
        const c = K(l);
        return c in t ? t[c].value : null;
      },
      /** Get the extra data of the record for the column */
      extra: (l) => {
        const c = K(l);
        return c in t ? t[c].extra : null;
      }
    }))
  ), p = g(
    () => i.value.actions.bulk.map((t) => ({
      ...t,
      execute: (l = {}) => L(t, l)
    }))
  ), G = g(
    () => i.value.actions.page.map((t) => ({
      ...t,
      execute: (l = {}) => M(t, l)
    }))
  ), B = g(
    () => {
      var t;
      return ((t = i.value.recordsPerPage) == null ? void 0 : t.map((l) => ({
        ...l,
        apply: (c = {}) => T(l, c)
      }))) ?? [];
    }
  ), j = g(
    () => {
      var t;
      return (t = i.value.recordsPerPage) == null ? void 0 : t.find(({ active: l }) => l);
    }
  ), h = g(() => ({
    ...i.value.paginator,
    next: (t = {}) => {
      "nextLink" in h.value && h.value.nextLink && w(h.value.nextLink, t);
    },
    previous: (t = {}) => {
      "prevLink" in h.value && h.value.prevLink && w(h.value.prevLink, t);
    },
    first: (t = {}) => {
      "firstLink" in h.value && h.value.firstLink && w(h.value.firstLink, t);
    },
    last: (t = {}) => {
      "lastLink" in h.value && h.value.lastLink && w(h.value.lastLink, t);
    },
    ..."links" in i.value.paginator && i.value.paginator.links ? {
      links: i.value.paginator.links.map((t) => ({
        ...t,
        navigate: (l = {}) => t.url && w(t.url, l)
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
  function w(t, l = {}) {
    x.visit(t, {
      preserveScroll: !0,
      preserveState: !0,
      ...a,
      ...l,
      method: "get"
    });
  }
  function C(t, l, c = {}) {
    var F, e;
    I(
      t,
      f.value.endpoint,
      {
        id: i.value.id,
        record: y(l)
      },
      c
    ) || (e = (F = v.recordActions) == null ? void 0 : F[t.name]) == null || e.call(F, l);
  }
  function L(t, l = {}) {
    I(
      t,
      f.value.endpoint,
      {
        id: i.value.id,
        all: u.selection.value.all,
        only: Array.from(u.selection.value.only),
        except: Array.from(u.selection.value.except)
      },
      {
        ...l,
        onSuccess: (c) => {
          var V;
          (V = l.onSuccess) == null || V.call(l, c), t.keepSelected || u.deselectAll();
        }
      }
    );
  }
  function M(t, l = {}) {
    I(
      t,
      f.value.endpoint,
      {
        id: i.value.id
      },
      l
    );
  }
  function T(t, l = {}) {
    x.reload({
      ...a,
      ...l,
      data: {
        [f.value.record]: t.value,
        [f.value.page]: void 0
      }
    });
  }
  function U(t, l = {}) {
    t.sort && x.reload({
      ...a,
      ...l,
      data: {
        [f.value.sort]: b.omitValue(t.sort.next)
      }
    });
  }
  function N(t, l = {}) {
    const c = b.toggleValue(
      t.name,
      S.value.map(({ name: V }) => V)
    );
    x.reload({
      ...a,
      ...l,
      data: {
        [f.value.column]: b.delimitArray(c)
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
    records: s,
    /** Whether the table has record actions */
    inline: i.value.actions.inline,
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
