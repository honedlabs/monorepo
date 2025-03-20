import { ref as _, computed as p, toValue as J, reactive as Q } from "vue";
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
  function d() {
    o.value.all = !1, o.value.only.clear(), o.value.except.clear();
  }
  function a(...c) {
    c.forEach((g) => o.value.except.delete(g)), c.forEach((g) => o.value.only.add(g));
  }
  function i(...c) {
    c.forEach((g) => o.value.except.add(g)), c.forEach((g) => o.value.only.delete(g));
  }
  function u(c, g) {
    if (b(c) || g === !1)
      return i(c);
    if (!b(c) || g === !0)
      return a(c);
  }
  function b(c) {
    return o.value.all ? !o.value.except.has(c) : o.value.only.has(c);
  }
  const f = p(() => o.value.all && o.value.except.size === 0), A = p(() => o.value.only.size > 0 || f.value);
  function S(c) {
    return {
      "onUpdate:modelValue": (g) => {
        g ? a(c) : i(c);
      },
      modelValue: b(c),
      value: c
    };
  }
  function k() {
    return {
      "onUpdate:modelValue": (c) => {
        c ? m() : d();
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
    deselectAll: d,
    select: a,
    deselect: i,
    toggle: u,
    selected: b,
    bind: S,
    bindAll: k
  };
}
function I(o, m, d = {}, a = {}) {
  return o.route ? (x.visit(o.route.href, {
    ...a,
    method: o.route.method
  }), !0) : o.action && m ? (x.post(
    m,
    {
      ...d,
      name: o.name,
      type: o.type
    },
    a
  ), !0) : !1;
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const Y = () => {
};
function Z(o, m) {
  function d(...a) {
    return new Promise((i, u) => {
      Promise.resolve(o(() => m.apply(this, a), { fn: m, thisArg: this, args: a })).then(i).catch(u);
    });
  }
  return d;
}
function O(o, m = {}) {
  let d, a, i = Y;
  const u = (f) => {
    clearTimeout(f), i(), i = Y;
  };
  let b;
  return (f) => {
    const A = J(o), S = J(m.maxWait);
    return d && u(d), A <= 0 || S !== void 0 && S <= 0 ? (a && (u(a), a = null), Promise.resolve(f())) : new Promise((k, c) => {
      i = m.rejectOnCancel ? c : k, b = f, S && !a && (a = setTimeout(() => {
        d && u(d), a = null, k(b());
      }, S)), d = setTimeout(() => {
        a && u(a), a = null, k(f());
      }, A);
    });
  };
}
function q(o, m = 200, d = {}) {
  return Z(
    O(m, d),
    o
  );
}
function ee(o, m, d = {}) {
  const a = p(() => o[m]), i = p(
    () => {
      var e;
      return ((e = a.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r, v = {}) => L(n, r, v),
        clear: (r = {}) => N(n, r),
        bind: () => l(n.name)
      }))) ?? [];
    }
  ), u = p(
    () => {
      var e;
      return ((e = a.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => M(n, n.direction, r),
        clear: (r = {}) => z(r),
        bind: () => s(n)
      }))) ?? [];
    }
  ), b = p(
    () => {
      var e;
      return (e = a.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => U(n, r),
        clear: (r = {}) => U(n, r),
        bind: () => F(n)
      }));
    }
  ), f = p(
    () => {
      var e;
      return ((e = a.value.filters) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
    }
  ), A = p(
    () => {
      var e;
      return (e = a.value.sorts) == null ? void 0 : e.find(({ active: n }) => n);
    }
  ), S = p(
    () => {
      var e;
      return ((e = a.value.searches) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
    }
  );
  function k(e) {
    return Array.isArray(e) ? e.join(a.value.config.delimiter) : e;
  }
  function c(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function g(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function B(e) {
    return [k, c, g].reduce(
      (n, r) => r(n),
      e
    );
  }
  function j(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((r) => r !== e) : [...n, e];
  }
  function C(e) {
    var n;
    return (n = a.value.filters) == null ? void 0 : n.find((r) => r.name === e);
  }
  function h(e, n = null) {
    var r;
    return (r = a.value.sorts) == null ? void 0 : r.find(
      (v) => v.name === e && v.direction === n
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
  function P(e) {
    var n;
    return e ? typeof e == "string" ? (n = S.value) == null ? void 0 : n.some((r) => r.name === e) : e.active : !!a.value.config.search;
  }
  function W(e, n = {}) {
    const r = Object.fromEntries(
      Object.entries(e).map(([v, V]) => [v, B(V)])
    );
    x.reload({
      ...d,
      ...n,
      data: r
    });
  }
  function L(e, n, r = {}) {
    const v = typeof e == "string" ? C(e) : e;
    if (!v) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    "multiple" in v && v.multiple && n !== void 0 && (n = j(n, v.value)), x.reload({
      ...d,
      ...r,
      data: {
        [v.name]: B(n)
      }
    });
  }
  function M(e, n = null, r = {}) {
    const v = typeof e == "string" ? h(e, n) : e;
    if (!v) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    x.reload({
      ...d,
      ...r,
      data: {
        [a.value.config.sorts]: g(v.next)
      }
    });
  }
  function T(e, n = {}) {
    e = [c, g].reduce(
      (r, v) => v(r),
      e
    ), x.reload({
      ...d,
      ...n,
      data: {
        [a.value.config.searches]: e
      }
    });
  }
  function U(e, n = {}) {
    if (!a.value.config.matches) {
      console.warn("Matches key is not set.");
      return;
    }
    const r = typeof e == "string" ? E(e) : e;
    if (!r) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const v = j(
      r.name,
      S.value.map(({ name: V }) => V)
    );
    x.reload({
      ...d,
      ...n,
      data: {
        [a.value.config.matches]: k(v)
      }
    });
  }
  function N(e, n = {}) {
    L(e, void 0, n);
  }
  function z(e = {}) {
    x.reload({
      ...d,
      ...e,
      data: {
        [a.value.config.sorts]: void 0
      }
    });
  }
  function R(e = {}) {
    T(void 0, e);
  }
  function D(e = {}) {
    if (!a.value.config.matches) {
      console.warn("Matches key is not set.");
      return;
    }
    x.reload({
      ...d,
      ...e,
      data: {
        [a.value.config.matches]: void 0
      }
    });
  }
  function t(e = {}) {
    var n;
    x.reload({
      ...d,
      ...e,
      data: {
        [a.value.config.searches]: void 0,
        [a.value.config.sorts]: void 0,
        [a.value.config.matches]: void 0,
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
    const r = typeof e == "string" ? C(e) : e;
    if (!r) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    const v = r.value, {
      debounce: V = 250,
      transform: G = (H) => H,
      ...$
    } = n;
    return {
      "onUpdate:modelValue": q((H) => {
        L(r, G(H), $);
      }, V),
      modelValue: v
    };
  }
  function s(e, n = {}) {
    const r = typeof e == "string" ? h(e) : e;
    if (!r) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    const { debounce: v = 0, transform: V, ...G } = n;
    return {
      onClick: q(() => {
        var $;
        M(r, ($ = A.value) == null ? void 0 : $.direction, G);
      }, v)
    };
  }
  function w(e = {}) {
    const { debounce: n = 700, transform: r, ...v } = e;
    return {
      "onUpdate:modelValue": q(
        (V) => {
          T(V, v);
        },
        n
      ),
      modelValue: a.value.config.search ?? ""
    };
  }
  function F(e, n = {}) {
    const r = typeof e == "string" ? E(e) : e;
    if (!r) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const { debounce: v = 0, transform: V, ...G } = n;
    return {
      "onUpdate:modelValue": q(($) => {
        U($, G);
      }, v),
      modelValue: P(r),
      value: r.name
    };
  }
  return {
    filters: i,
    sorts: u,
    searches: b,
    getFilter: C,
    getSort: h,
    getSearch: E,
    currentFilters: f,
    currentSort: A,
    currentSearches: S,
    isFiltering: y,
    isSorting: K,
    isSearching: P,
    apply: W,
    applyFilter: L,
    applySort: M,
    applySearch: T,
    applyMatch: U,
    clearFilter: N,
    clearSort: z,
    clearSearch: R,
    clearMatch: D,
    reset: t,
    bindFilter: l,
    bindSort: s,
    bindSearch: w,
    bindMatch: F,
    stringValue: c,
    omitValue: g,
    toggleValue: j,
    delimitArray: k
  };
}
function ae(o, m, d = {}, a = {}) {
  if (!o || !m || !o[m])
    throw new Error("Table has not been provided with valid props and key.");
  a = {
    ...a,
    only: [...a.only ?? [], m.toString()]
  };
  const i = p(() => o[m]), u = X(), b = ee(o, m, a), f = p(() => i.value.config), A = p(() => i.value.meta), S = p(
    () => {
      var t;
      return ((t = i.value.columns) == null ? void 0 : t.filter(({ active: l, hidden: s }) => l && !s).map((l) => {
        var s;
        return {
          ...l,
          isSorting: (s = l.sort) == null ? void 0 : s.active,
          toggleSort: (w = {}) => U(l, w)
        };
      })) ?? [];
    }
  ), k = p(
    () => {
      var t;
      return ((t = i.value.columns) == null ? void 0 : t.filter(({ hidden: l }) => !l).map((l) => ({
        ...l,
        toggle: (s = {}) => N(l, s)
      }))) ?? [];
    }
  ), c = p(
    () => i.value.records.map((t) => ({
      record: (({ actions: l, ...s }) => s)(t),
      /** Perform this action when the record is clicked */
      default: (l = {}) => {
        const s = t.actions.find(
          (w) => w.default
        );
        s && W(s, t, l);
      },
      /** The actions available for the record */
      actions: t.actions.map((l) => ({
        ...l,
        /** Executes this action */
        execute: (s = {}) => W(l, t, s)
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
      value: (l) => {
        var s;
        return (s = t[K(l)]) == null ? void 0 : s.value;
      },
      /** Get the extra data of the record for the column */
      extra: (l) => {
        var s;
        return (s = t[K(l)]) == null ? void 0 : s.extra;
      }
    }))
  ), g = p(
    () => i.value.actions.bulk.map((t) => ({
      ...t,
      /** Executes this bulk action */
      execute: (l = {}) => L(t, l)
    }))
  ), B = p(
    () => i.value.actions.page.map((t) => ({
      ...t,
      /** Executes this page action */
      execute: (l = {}) => M(t, l)
    }))
  ), j = p(
    () => {
      var t;
      return ((t = i.value.recordsPerPage) == null ? void 0 : t.map((l) => ({
        ...l,
        /** Changes the number of records to display per page */
        apply: (s = {}) => T(l, s)
      }))) ?? [];
    }
  ), C = p(
    () => {
      var t;
      return (t = i.value.recordsPerPage) == null ? void 0 : t.find(({ active: l }) => l);
    }
  ), h = p(() => ({
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
        navigate: (l = {}) => t.url && P(t.url, l)
      }))
    } : {}
  })), E = p(
    () => i.value.records.length > 0 && i.value.records.every(
      (t) => u.selected(y(t))
    )
  );
  function y(t) {
    return t[f.value.record].value;
  }
  function K(t) {
    return typeof t == "string" ? t : t.name;
  }
  function P(t, l = {}) {
    x.visit(t, {
      preserveScroll: !0,
      preserveState: !0,
      ...a,
      ...l,
      method: "get"
    });
  }
  function W(t, l, s = {}) {
    var F, e;
    I(
      t,
      f.value.endpoint,
      {
        table: i.value.id,
        id: y(l)
      },
      s
    ) || (e = (F = d.recordActions) == null ? void 0 : F[t.name]) == null || e.call(F, l);
  }
  function L(t, l = {}) {
    I(
      t,
      f.value.endpoint,
      {
        table: i.value.id,
        all: u.selection.value.all,
        only: Array.from(u.selection.value.only),
        except: Array.from(u.selection.value.except)
      },
      l
    );
  }
  function M(t, l = {}) {
    I(
      t,
      f.value.endpoint,
      {
        table: i.value.id
      },
      l
    );
  }
  function T(t, l = {}) {
    x.reload({
      ...a,
      ...l,
      data: {
        [f.value.records]: t.value,
        [f.value.pages]: void 0
      }
    });
  }
  function U(t, l = {}) {
    t.sort && x.reload({
      ...a,
      ...l,
      data: {
        [f.value.sorts]: b.omitValue(t.sort.next)
      }
    });
  }
  function N(t, l = {}) {
    const s = b.toggleValue(
      t.name,
      S.value.map(({ name: w }) => w)
    );
    x.reload({
      ...a,
      ...l,
      data: {
        [f.value.columns]: b.delimitArray(s)
      }
    });
  }
  function z() {
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
        t ? z() : R();
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
    bulkActions: g,
    /** The available page actions */
    pageActions: B,
    /** The available number of records to display per page */
    rowsPerPage: j,
    /** The current record per page item */
    currentPage: C,
    /** The pagination metadata */
    paginator: h,
    /** Execute an inline action */
    executeInlineAction: W,
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
    selectPage: z,
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
  ae as useTable
};
