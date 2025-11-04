import { ref as re, computed as v, toValue as te, reactive as oe } from "vue";
import { router as x } from "@inertiajs/vue3";
import le from "axios";
function ne(r, h = {}, p = {}) {
  if (!r.href || !r.method)
    return !1;
  if (r.type === "inertia")
    r.method === "delete" ? x.delete(r.href, p) : x[r.method](r.href, h, p);
  else {
    const d = (c) => {
      var o;
      return (o = p.onError) == null ? void 0 : o.call(p, c);
    };
    r.method === "get" ? window.location.href = r.href : r.method === "delete" ? le.delete(r.href).catch(d) : le[r.method](r.href, h).catch(d);
  }
  return !0;
}
function ue() {
  const r = re({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function h() {
    r.value.all = !0, r.value.only.clear(), r.value.except.clear();
  }
  function p() {
    r.value.all = !1, r.value.only.clear(), r.value.except.clear();
  }
  function d(...f) {
    f.forEach((b) => r.value.except.delete(b)), f.forEach((b) => r.value.only.add(b));
  }
  function c(...f) {
    f.forEach((b) => r.value.except.add(b)), f.forEach((b) => r.value.only.delete(b));
  }
  function o(f, b) {
    if (m(f) || b === !1) return c(f);
    if (!m(f) || b === !0) return d(f);
  }
  function m(f) {
    return r.value.all ? !r.value.except.has(f) : r.value.only.has(f);
  }
  const u = v(() => r.value.all && r.value.except.size === 0), k = v(() => r.value.only.size > 0 || u.value);
  function _(f) {
    return {
      "onUpdate:modelValue": (b) => {
        b ? d(f) : c(f);
      },
      modelValue: m(f),
      value: f
    };
  }
  function g() {
    return {
      "onUpdate:modelValue": (f) => {
        f ? h() : p();
      },
      modelValue: u.value
    };
  }
  return {
    allSelected: u,
    selection: r,
    hasSelected: k,
    selectAll: h,
    deselectAll: p,
    select: d,
    deselect: c,
    toggle: o,
    selected: m,
    bind: _,
    bindAll: g
  };
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const ae = () => {
};
function ie(r, h) {
  function p(...d) {
    return new Promise((c, o) => {
      Promise.resolve(r(() => h.apply(this, d), { fn: h, thisArg: this, args: d })).then(c).catch(o);
    });
  }
  return p;
}
function se(r, h = {}) {
  let p, d, c = ae;
  const o = (u) => {
    clearTimeout(u), c(), c = ae;
  };
  let m;
  return (u) => {
    const k = te(r), _ = te(h.maxWait);
    return p && o(p), k <= 0 || _ !== void 0 && _ <= 0 ? (d && (o(d), d = null), Promise.resolve(u())) : new Promise((g, f) => {
      c = h.rejectOnCancel ? f : g, m = u, _ && !d && (d = setTimeout(() => {
        p && o(p), d = null, g(m());
      }, _)), p = setTimeout(() => {
        d && o(d), d = null, g(u());
      }, k);
    });
  };
}
function Y(r, h = 200, p = {}) {
  return ie(
    se(h, p),
    r
  );
}
function ce(r, h, p = {}, d = {}) {
  if (!(r != null && r[h]))
    throw new Error("The refine must be provided with valid props and key.");
  const { onFinish: c, ...o } = p, m = re(!1), u = v(() => r[h]), k = v(() => u.value.term), _ = v(() => !!u.value._sort_key), g = v(() => !!u.value._search_key), f = v(() => !!u.value._match_key), b = v(
    () => {
      var n;
      return (n = u.value.filters) == null ? void 0 : n.map((l) => ({
        ...l,
        apply: (e, t = {}) => y(l, e, t),
        clear: (e = {}) => D(l, e),
        bind: () => I(l.name)
      }));
    }
  ), M = v(
    () => {
      var n;
      return (n = u.value.sorts) == null ? void 0 : n.map((l) => ({
        ...l,
        apply: (e = {}) => F(l, l.direction, e),
        clear: (e = {}) => G(e),
        bind: () => Q(l)
      }));
    }
  ), U = v(
    () => {
      var n;
      return (n = u.value.searches) == null ? void 0 : n.map((l) => ({
        ...l,
        apply: (e = {}) => A(l, e),
        clear: (e = {}) => A(l, e),
        bind: () => K(l)
      }));
    }
  ), E = v(
    () => b.value.filter(({ active: n }) => n)
  ), P = v(
    () => M.value.find(({ active: n }) => n)
  ), L = v(
    () => U.value.filter(({ active: n }) => n)
  );
  function T(n) {
    return Array.isArray(n) ? n.join(u.value._delimiter) : n;
  }
  function j(n) {
    return typeof n != "string" ? n : n.trim().replace(/\s+/g, "+");
  }
  function R(n) {
    if (!["", null, void 0, []].includes(n))
      return n;
  }
  function q(n) {
    return [T, j, R].reduce(
      (l, e) => e(l),
      n
    );
  }
  function H(n, l) {
    return l = Array.isArray(l) ? l : [l], l.includes(n) ? l.filter((e) => e !== n) : [...l, n];
  }
  function C(n) {
    return typeof n != "string" ? n : b.value.find(({ name: l }) => l === n);
  }
  function W(n, l = null) {
    return typeof n != "string" ? n : M.value.find(
      ({ name: e, direction: t }) => e === n && t === l
    );
  }
  function z(n) {
    return typeof n != "string" ? n : U.value.find(({ name: l }) => l === n);
  }
  function Z(n) {
    return n ? typeof n == "string" ? E.value.some((l) => l.name === n) : n.active : !!E.value.length;
  }
  function S(n) {
    var l;
    return n ? typeof n == "string" ? ((l = P.value) == null ? void 0 : l.name) === n : n.active : !!P.value;
  }
  function B(n) {
    var l;
    return n ? typeof n == "string" ? (l = L.value) == null ? void 0 : l.some((e) => e.name === n) : n.active : !!k.value;
  }
  function J(n, l = {}) {
    const e = Object.fromEntries(
      Object.entries(n).map(([i, s]) => [i, q(s)])
    ), { onFinish: t, ...a } = l;
    m.value = !0, x.reload({
      ...o,
      ...a,
      data: e,
      onFinish: (i) => {
        m.value = !1, t == null || t(i), c == null || c(i);
      }
    });
  }
  function y(n, l, e = {}) {
    const t = C(n);
    if (!t) return console.warn(`Filter [${n}] does not exist.`);
    const { parameters: a, onFinish: i, ...s } = e;
    m.value = !0, x.reload({
      ...o,
      ...s,
      onFinish: (w) => {
        m.value = !1, i == null || i(w), c == null || c(w);
      },
      data: {
        [t.name]: q(l),
        ...a,
        ...d
      }
    });
  }
  function F(n, l = null, e = {}) {
    if (!_.value)
      return console.warn("Refine cannot perform sorting.");
    const t = W(n, l);
    if (!t) return console.warn(`Sort [${n}] does not exist.`);
    const { parameters: a, onFinish: i, ...s } = e;
    m.value = !0, x.reload({
      ...o,
      ...s,
      onFinish: (w) => {
        m.value = !1, i == null || i(w), c == null || c(w);
      },
      data: {
        [u.value._sort_key]: R(t.next),
        ...a
      }
    });
  }
  function $(n, l = {}) {
    if (!g.value)
      return console.warn("Refine cannot perform searching.");
    n = [j, R].reduce(
      (i, s) => s(i),
      n
    );
    const { parameters: e, onFinish: t, ...a } = l;
    m.value = !0, x.reload({
      ...o,
      ...a,
      onFinish: (i) => {
        m.value = !1, t == null || t(i), c == null || c(i);
      },
      data: {
        [u.value._search_key]: n,
        ...e,
        ...d
      }
    });
  }
  function A(n, l = {}) {
    if (!f.value || !g.value)
      return console.warn("Refine cannot perform matching.");
    const e = z(n);
    if (!e) return console.warn(`Match [${n}] does not exist.`);
    const t = H(
      e.name,
      L.value.map(({ name: w }) => w)
    ), { parameters: a, onFinish: i, ...s } = l;
    m.value = !0, x.reload({
      ...o,
      ...s,
      onFinish: (w) => {
        m.value = !1, i == null || i(w), c == null || c(w);
      },
      data: {
        [u.value._match_key]: T(t),
        ...a,
        ...d
      }
    });
  }
  function D(n, l = {}) {
    if (n) return y(n, null, l);
    const { parameters: e, onFinish: t, ...a } = l;
    m.value = !0, x.reload({
      ...o,
      ...a,
      onFinish: (i) => {
        m.value = !1, t == null || t(i), c == null || c(i);
      },
      data: {
        ...Object.fromEntries(
          E.value.map(({ name: i }) => [i, null])
        ),
        ...e
      }
    });
  }
  function G(n = {}) {
    if (!_.value)
      return console.warn("Refine cannot perform sorting.");
    const { parameters: l, onFinish: e, ...t } = n;
    m.value = !0, x.reload({
      ...o,
      ...t,
      onFinish: (a) => {
        m.value = !1, e == null || e(a), c == null || c(a);
      },
      data: {
        [u.value._sort_key]: null,
        ...l
      }
    });
  }
  function V(n = {}) {
    $(null, n);
  }
  function O(n = {}) {
    if (!f.value)
      return console.warn("Refine cannot perform matching.");
    const { parameters: l, onFinish: e, ...t } = n;
    m.value = !0, x.reload({
      ...o,
      ...t,
      onFinish: (a) => {
        m.value = !1, e == null || e(a), c == null || c(a);
      },
      data: {
        [u.value._match_key]: null,
        ...l
      }
    });
  }
  function N(n = {}) {
    var l;
    const { parameters: e, onFinish: t, ...a } = n;
    m.value = !0, x.reload({
      ...o,
      ...a,
      onFinish: (i) => {
        m.value = !1, t == null || t(i), c == null || c(i);
      },
      data: {
        [u.value._search_key ?? ""]: void 0,
        [u.value._sort_key ?? ""]: void 0,
        [u.value._match_key ?? ""]: void 0,
        ...Object.fromEntries(
          ((l = u.value.filters) == null ? void 0 : l.map((i) => [
            i.name,
            void 0
          ])) ?? []
        ),
        ...e
      }
    });
  }
  function I(n, l = {}) {
    const e = C(n);
    if (!e) return console.warn(`Filter [${n}] does not exist.`);
    const {
      debounce: t = 150,
      transform: a = (s) => s,
      ...i
    } = l;
    return {
      "onUpdate:modelValue": Y((s) => {
        y(e, a(s), i);
      }, t),
      modelValue: e.value
    };
  }
  function Q(n, l = {}) {
    if (!_.value)
      return console.warn("Refine cannot perform sorting.");
    const e = W(n);
    if (!e) return console.warn(`Sort [${n}] does not exist.`);
    const { debounce: t = 0, transform: a, ...i } = l;
    return {
      onClick: Y(() => {
        var s;
        F(e, (s = P.value) == null ? void 0 : s.direction, i);
      }, t)
    };
  }
  function ee(n = {}) {
    if (!g.value)
      return console.warn("Refine cannot perform searching.");
    const { debounce: l = 700, transform: e, ...t } = n;
    return {
      "onUpdate:modelValue": Y(
        (a) => {
          $(a, t);
        },
        l
      ),
      modelValue: k.value ?? ""
    };
  }
  function K(n, l = {}) {
    if (!f.value)
      return console.warn("Refine cannot perform matching.");
    const e = z(n);
    if (!e) return console.warn(`Match [${n}] does not exist.`);
    const { debounce: t = 0, transform: a, ...i } = l;
    return {
      "onUpdate:modelValue": Y((s) => {
        A(s, i);
      }, t),
      modelValue: B(e),
      value: e.name
    };
  }
  return {
    processing: m,
    filters: b,
    sorts: M,
    searches: U,
    currentFilters: E,
    currentSort: P,
    currentSearches: L,
    searchTerm: k,
    isSortable: _,
    isSearchable: g,
    isMatchable: f,
    isFiltering: Z,
    isSorting: S,
    isSearching: B,
    getFilter: C,
    getSort: W,
    getSearch: z,
    apply: J,
    applyFilter: y,
    applySort: F,
    applySearch: $,
    applyMatch: A,
    clearFilter: D,
    clearSort: G,
    clearSearch: V,
    clearMatch: O,
    reset: N,
    bindFilter: I,
    bindSort: Q,
    bindSearch: ee,
    bindMatch: K,
    stringValue: j,
    omitValue: R,
    toggleValue: H,
    delimitArray: T
  };
}
function me(r, h, p = {}) {
  if (!(r != null && r[h]))
    throw new Error("The table must be provided with valid props and key.");
  const { recordOperations: d = {}, ...c } = {
    only: [...p.only ?? [], h.toString()],
    ...p
  }, o = v(() => r[h]), m = v(() => o.value._id), u = ue(), { processing: k, ..._ } = ce(r, h, c, {
    [o.value._page_key]: void 0
  }), { onFinish: g, ...f } = c, b = v(() => o.value.meta), M = v(() => o.value.views ?? []), U = v(() => o.value.state ?? null), E = v(() => o.value.placeholder ?? null), P = v(() => !!o.value.state), L = v(
    () => !!o.value._page_key && !!o.value._record_key
  ), T = v(() => !!o.value._column_key), j = v(
    () => o.value.columns.filter(({ active: e, hidden: t }) => e && !t).map((e) => {
      var t;
      return {
        ...e,
        isSorting: !!((t = e.sort) != null && t.active),
        toggleSort: (a = {}) => _.applySort(e.sort, null, a)
      };
    })
  ), R = v(
    () => o.value.columns.filter(({ hidden: e }) => !e).map((e) => ({
      ...e,
      toggle: (t = {}) => ee(e.name, t)
    }))
  ), q = v(
    () => o.value.records.map((e) => ({
      ...e,
      /** The operations available for the record */
      operations: e.operations.map((t) => ({
        ...t,
        execute: (a = {}) => O(t, e, a)
      })),
      /** Determine if the record is selected */
      selected: u.selected(y(e)),
      /** Perform this operation when the record is clicked */
      default: (t = {}) => {
        const a = e.operations.find(
          ({ default: i }) => i
        );
        a && O(a, e, t);
      },
      /** Selects this record */
      select: () => u.select(y(e)),
      /** Deselects this record */
      deselect: () => u.deselect(y(e)),
      /** Toggles the selection of this record */
      toggle: () => u.toggle(y(e)),
      /** Bind the record to a checkbox */
      bind: () => u.bind(y(e)),
      /** Get the entry of the record for the column */
      entry: (t) => F(e, t),
      /** Get the value of the record for the column */
      value: (t) => $(e, t),
      /** Get the extra data of the record for the column */
      extra: (t) => A(e, t)
    }))
  ), H = v(() => !!o.value.operations.inline), C = v(
    () => o.value.operations.bulk.map((e) => ({
      ...e,
      execute: (t = {}) => N(e, t)
    }))
  ), W = v(
    () => o.value.operations.page.map((e) => ({
      ...e,
      execute: (t = {}) => I(e, t)
    }))
  ), z = v(
    () => o.value.pages.find(({ active: e }) => e)
  ), Z = v(() => o.value.pages), S = v(() => ({
    ...o.value.paginate,
    next: (e = {}) => {
      "nextLink" in S.value && S.value.nextLink && V(S.value.nextLink, e);
    },
    previous: (e = {}) => {
      "prevLink" in S.value && S.value.prevLink && V(S.value.prevLink, e);
    },
    first: (e = {}) => {
      "firstLink" in S.value && S.value.firstLink && V(S.value.firstLink, e);
    },
    last: (e = {}) => {
      "lastLink" in S.value && S.value.lastLink && V(S.value.lastLink, e);
    },
    ..."links" in o.value.paginate && o.value.paginate.links ? {
      links: o.value.paginate.links.map((e) => ({
        ...e,
        navigate: (t = {}) => e.url && V(e.url, t)
      }))
    } : {}
  })), B = v(
    () => o.value.records.length > 0 && o.value.records.every(
      (e) => u.selected(y(e))
    )
  );
  function J(e) {
    return typeof e == "string" ? e : e.name;
  }
  function y(e) {
    return e._key;
  }
  function F(e, t) {
    const a = J(t);
    return e[a];
  }
  function $(e, t) {
    var a;
    return ((a = F(e, t)) == null ? void 0 : a.v) ?? null;
  }
  function A(e, t) {
    var a;
    return (a = F(e, t)) == null ? void 0 : a.e;
  }
  function D(e) {
    return { id: y(e) };
  }
  function G() {
    return {
      all: u.selection.value.all,
      only: Array.from(u.selection.value.only),
      except: Array.from(u.selection.value.except)
    };
  }
  function V(e, t = {}) {
    k.value = !0;
    const { onFinish: a, ...i } = t;
    x.visit(e, {
      preserveScroll: !0,
      preserveState: !0,
      ...f,
      ...i,
      onFinish: (s) => {
        k.value = !1, g == null || g(s), a == null || a(s);
      },
      method: "get"
    });
  }
  function O(e, t, a = {}) {
    var s;
    ne(e, D(t), {
      ...p,
      ...a
    }) || (s = d == null ? void 0 : d[e.name]) == null || s.call(d, t);
  }
  function N(e, t = {}) {
    return ne(e, G(), {
      ...p,
      ...t,
      onSuccess: (a) => {
        var i, s;
        (i = t.onSuccess) == null || i.call(t, a), (s = p.onSuccess) == null || s.call(p, a), console.log("onSuccess"), e.keep || u.deselectAll();
      }
    });
  }
  function I(e, t = {}, a = {}) {
    return ne(e, t, { ...p, ...a });
  }
  function Q(e, t = {}) {
    if (!L.value)
      return console.warn("The table does not support pagination changes.");
    const { onFinish: a, ...i } = t;
    k.value = !0, x.reload({
      ...f,
      ...i,
      onFinish: (s) => {
        k.value = !1, g == null || g(s), a == null || a(s);
      },
      data: {
        [o.value._record_key]: e.value,
        [o.value._page_key]: void 0
      }
    });
  }
  function ee(e, t = {}) {
    if (!T.value)
      return console.warn("The table does not support column toggling.");
    const a = J(e);
    if (!a) return console.log(`Column [${e}] does not exist.`);
    const i = _.toggleValue(
      a,
      j.value.map(({ name: X }) => X)
    ), { onFinish: s, ...w } = t;
    k.value = !0, x.reload({
      ...f,
      ...w,
      onFinish: (X) => {
        k.value = !1, g == null || g(X), s == null || s(X);
      },
      data: {
        [o.value._column_key]: _.delimitArray(i)
      }
    });
  }
  function K() {
    u.select(
      ...o.value.records.map(
        (e) => y(e)
      )
    );
  }
  function n() {
    u.deselect(
      ...o.value.records.map(
        (e) => y(e)
      )
    );
  }
  function l() {
    return {
      "onUpdate:modelValue": (e) => {
        e ? K() : n();
      },
      modelValue: B.value
    };
  }
  return oe({
    /** The identifier of the table */
    id: m,
    /** Table-specific metadata */
    meta: b,
    /** The views for the table */
    views: M,
    /** The empty state for the table */
    emptyState: U,
    /** The placeholder for the search term.*/
    placeholder: E,
    /** Whether the table is empty */
    isEmpty: P,
    /** Whether the table supports changing the number of records to display per page */
    isPageable: L,
    /** Whether the table supports toggling columns */
    isToggleable: T,
    /** Get the entry of the record for the column */
    getEntry: F,
    /** Get the value of the record for the column */
    getValue: $,
    /** Get the extra data of the record for the column */
    getExtra: A,
    /** Retrieve a record's identifier */
    getRecordKey: y,
    /** The heading columns for the table */
    headings: j,
    /** All of the table's columns */
    columns: R,
    /** The records of the table */
    records: q,
    /** Whether the table has record operations */
    inline: H,
    /** The available bulk operations */
    bulk: C,
    /** The available page operations */
    page: W,
    /** The available number of records to display per page */
    pages: Z,
    /** The current record per page item */
    currentPage: z,
    /** The pagination metadata */
    paginator: S,
    /** Execute an inline operation */
    executeInline: O,
    /** Execute a bulk operation */
    executeBulk: N,
    /** Execute a page operation */
    executePage: I,
    /** The bulk data */
    getBulkData: G,
    /** The record data */
    getRecordData: D,
    /** Apply a new page by changing the number of records to display */
    applyPage: Q,
    /** The current selection of records */
    selection: u.selection,
    /** Select the given records */
    select: (e) => u.select(y(e)),
    /** Deselect the given records */
    deselect: (e) => u.deselect(y(e)),
    /** Select records on the current page */
    selectPage: K,
    /** Deselect records on the current page */
    deselectPage: n,
    /** Toggle the selection of the given records */
    toggle: (e) => u.toggle(y(e)),
    /** Determine if the given record is selected */
    selected: (e) => u.selected(y(e)),
    /** Select all records */
    selectAll: u.selectAll,
    /** Deselect all records */
    deselectAll: u.deselectAll,
    /** Whether all records on the current page are selected */
    isPageSelected: B,
    /** Determine if any records are selected */
    hasSelected: u.hasSelected,
    /** Bind the given record to a checkbox */
    bindCheckbox: (e) => u.bind(y(e)),
    /** Bind the select all checkbox to the current page */
    bindPage: l,
    /** Bind select all records to the checkbox */
    bindAll: u.bindAll,
    /** The processing status */
    processing: k,
    /** The refine instance */
    ..._
  });
}
function pe(r, h) {
  return r ? typeof r == "object" ? r.type === h : r === h : !1;
}
export {
  pe as is,
  me as useTable
};
