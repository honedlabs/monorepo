import { ref as re, computed as c, toValue as te, reactive as ue } from "vue";
import { router as x } from "@inertiajs/vue3";
import le from "axios";
function ne(o, g = {}, p = {}) {
  if (!o.href || !o.method)
    return !1;
  if (o.type === "inertia")
    o.method === "delete" ? x.delete(o.href, p) : x[o.method](o.href, g, p);
  else {
    const d = (s) => {
      var u;
      return (u = p.onError) == null ? void 0 : u.call(p, s);
    };
    o.method === "get" ? window.location.href = o.href : o.method === "delete" ? le.delete(o.href).catch(d) : le[o.method](o.href, g).catch(d);
  }
  return !0;
}
function ie() {
  const o = re({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function g() {
    o.value.all = !0, o.value.only.clear(), o.value.except.clear();
  }
  function p() {
    o.value.all = !1, o.value.only.clear(), o.value.except.clear();
  }
  function d(...v) {
    v.forEach((k) => o.value.except.delete(k)), v.forEach((k) => o.value.only.add(k));
  }
  function s(...v) {
    v.forEach((k) => o.value.except.add(k)), v.forEach((k) => o.value.only.delete(k));
  }
  function u(v, k) {
    if (m(v) || k === !1) return s(v);
    if (!m(v) || k === !0) return d(v);
  }
  function m(v) {
    return o.value.all ? !o.value.except.has(v) : o.value.only.has(v);
  }
  const i = c(() => o.value.all && o.value.except.size === 0), _ = c(() => o.value.only.size > 0 || i.value);
  function S(v) {
    return {
      "onUpdate:modelValue": (k) => {
        k ? d(v) : s(v);
      },
      modelValue: m(v),
      value: v
    };
  }
  function y() {
    return {
      "onUpdate:modelValue": (v) => {
        v ? g() : p();
      },
      modelValue: i.value
    };
  }
  return {
    allSelected: i,
    selection: o,
    hasSelected: _,
    selectAll: g,
    deselectAll: p,
    select: d,
    deselect: s,
    toggle: u,
    selected: m,
    bind: S,
    bindAll: y
  };
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const ae = () => {
};
function se(o, g) {
  function p(...d) {
    return new Promise((s, u) => {
      Promise.resolve(o(() => g.apply(this, d), { fn: g, thisArg: this, args: d })).then(s).catch(u);
    });
  }
  return p;
}
function ce(o, g = {}) {
  let p, d, s = ae;
  const u = (i) => {
    clearTimeout(i), s(), s = ae;
  };
  let m;
  return (i) => {
    const _ = te(o), S = te(g.maxWait);
    return p && u(p), _ <= 0 || S !== void 0 && S <= 0 ? (d && (u(d), d = null), Promise.resolve(i())) : new Promise((y, v) => {
      s = g.rejectOnCancel ? v : y, m = i, S && !d && (d = setTimeout(() => {
        p && u(p), d = null, y(m());
      }, S)), p = setTimeout(() => {
        d && u(d), d = null, y(i());
      }, _);
    });
  };
}
function X(o, g = 200, p = {}) {
  return se(
    ce(g, p),
    o
  );
}
function ve(o, g, p = {}, d = {}) {
  if (!(o != null && o[g]))
    throw new Error("The refine must be provided with valid props and key.");
  const { onFinish: s, ...u } = p, m = re(!1), i = c(() => o[g]), _ = c(() => i.value.term), S = c(() => !!i.value._sort_key), y = c(() => !!i.value._search_key), v = c(() => !!i.value._match_key), k = c(
    () => {
      var n;
      return (n = i.value.filters) == null ? void 0 : n.map((l) => ({
        ...l,
        apply: (r, e = {}) => A(l, r, e),
        clear: (r = {}) => B(l, r),
        bind: (r = {}) => O(l.name, r)
      }));
    }
  ), $ = c(
    () => {
      var n;
      return (n = i.value.sorts) == null ? void 0 : n.map((l) => ({
        ...l,
        apply: (r = {}) => b(l, l.direction, r),
        clear: (r = {}) => D(r),
        bind: (r = {}) => I(l, r)
      }));
    }
  ), M = c(
    () => {
      var n;
      return (n = i.value.searches) == null ? void 0 : n.map((l) => ({
        ...l,
        apply: (r = {}) => E(l, r),
        clear: (r = {}) => E(l, r),
        bind: (r = {}) => N(l, r)
      }));
    }
  ), L = c(
    () => k.value.filter(({ active: n }) => n)
  ), T = c(
    () => $.value.find(({ active: n }) => n)
  ), j = c(
    () => M.value.filter(({ active: n }) => n)
  );
  function R(n) {
    return Array.isArray(n) ? n.join(i.value._delimiter) : n;
  }
  function U(n) {
    return typeof n != "string" ? n : n.trim().replace(/\s+/g, "+");
  }
  function V(n) {
    if (!["", null, void 0, []].includes(n))
      return n;
  }
  function K(n) {
    return [R, U, V].reduce(
      (l, r) => r(l),
      n
    );
  }
  function q(n, l) {
    return l = Array.isArray(l) ? l : [l], l.includes(n) ? l.filter((r) => r !== n) : [...l, n];
  }
  function C(n) {
    return typeof n != "string" ? n : k.value.find(({ name: l }) => l === n);
  }
  function W(n, l = null) {
    return typeof n != "string" ? n : $.value.find(
      ({ name: r, direction: e }) => r === n && e === l
    );
  }
  function z(n) {
    return typeof n != "string" ? n : M.value.find(({ name: l }) => l === n);
  }
  function Y(n) {
    return n ? typeof n == "string" ? L.value.some((l) => l.name === n) : n.active : !!L.value.length;
  }
  function Z(n) {
    var l;
    return n ? typeof n == "string" ? ((l = T.value) == null ? void 0 : l.name) === n : n.active : !!T.value;
  }
  function w(n) {
    var l;
    return n ? typeof n == "string" ? (l = j.value) == null ? void 0 : l.some((r) => r.name === n) : n.active : !!_.value;
  }
  function H(n, l = {}) {
    const r = Object.fromEntries(
      Object.entries(n).map(([a, f]) => [a, K(f)])
    ), { onFinish: e, ...t } = l;
    m.value = !0, x.reload({
      ...u,
      ...t,
      data: r,
      onFinish: (a) => {
        m.value = !1, e == null || e(a), s == null || s(a);
      }
    });
  }
  function A(n, l, r = {}) {
    const e = C(n);
    if (!e) return console.warn(`Filter [${n}] does not exist.`);
    const { parameters: t, onFinish: a, ...f } = r;
    m.value = !0, x.reload({
      ...u,
      ...f,
      onFinish: (h) => {
        m.value = !1, a == null || a(h), s == null || s(h);
      },
      data: {
        [e.name]: K(l),
        ...t,
        ...d
      }
    });
  }
  function b(n, l = null, r = {}) {
    if (!S.value)
      return console.warn("Refine cannot perform sorting.");
    const e = W(n, l);
    if (!e) return console.warn(`Sort [${n}] does not exist.`);
    const { parameters: t, onFinish: a, ...f } = r;
    m.value = !0, x.reload({
      ...u,
      ...f,
      onFinish: (h) => {
        m.value = !1, a == null || a(h), s == null || s(h);
      },
      data: {
        [i.value._sort_key]: V(e.next),
        ...t
      }
    });
  }
  function F(n, l = {}) {
    if (!y.value)
      return console.warn("Refine cannot perform searching.");
    n = [U, V].reduce(
      (a, f) => f(a),
      n
    );
    const { parameters: r, onFinish: e, ...t } = l;
    m.value = !0, x.reload({
      ...u,
      ...t,
      onFinish: (a) => {
        m.value = !1, e == null || e(a), s == null || s(a);
      },
      data: {
        [i.value._search_key]: n,
        ...r,
        ...d
      }
    });
  }
  function E(n, l = {}) {
    if (!v.value || !y.value)
      return console.warn("Refine cannot perform matching.");
    const r = z(n);
    if (!r) return console.warn(`Match [${n}] does not exist.`);
    const e = q(
      r.name,
      j.value.map(({ name: h }) => h)
    ), { parameters: t, onFinish: a, ...f } = l;
    m.value = !0, x.reload({
      ...u,
      ...f,
      onFinish: (h) => {
        m.value = !1, a == null || a(h), s == null || s(h);
      },
      data: {
        [i.value._match_key]: R(e),
        ...t,
        ...d
      }
    });
  }
  function B(n, l = {}) {
    if (n) return A(n, null, l);
    const { parameters: r, onFinish: e, ...t } = l;
    m.value = !0, x.reload({
      ...u,
      ...t,
      onFinish: (a) => {
        m.value = !1, e == null || e(a), s == null || s(a);
      },
      data: {
        ...Object.fromEntries(
          L.value.map(({ name: a }) => [a, null])
        ),
        ...r
      }
    });
  }
  function D(n = {}) {
    if (!S.value)
      return console.warn("Refine cannot perform sorting.");
    const { parameters: l, onFinish: r, ...e } = n;
    m.value = !0, x.reload({
      ...u,
      ...e,
      onFinish: (t) => {
        m.value = !1, r == null || r(t), s == null || s(t);
      },
      data: {
        [i.value._sort_key]: null,
        ...l
      }
    });
  }
  function J(n = {}) {
    F(null, n);
  }
  function P(n = {}) {
    if (!v.value)
      return console.warn("Refine cannot perform matching.");
    const { parameters: l, onFinish: r, ...e } = n;
    m.value = !0, x.reload({
      ...u,
      ...e,
      onFinish: (t) => {
        m.value = !1, r == null || r(t), s == null || s(t);
      },
      data: {
        [i.value._match_key]: null,
        ...l
      }
    });
  }
  function G(n = {}) {
    var l;
    const { parameters: r, onFinish: e, ...t } = n;
    m.value = !0, x.reload({
      ...u,
      ...t,
      onFinish: (a) => {
        m.value = !1, e == null || e(a), s == null || s(a);
      },
      data: {
        [i.value._search_key ?? ""]: void 0,
        [i.value._sort_key ?? ""]: void 0,
        [i.value._match_key ?? ""]: void 0,
        ...Object.fromEntries(
          ((l = i.value.filters) == null ? void 0 : l.map((a) => [
            a.name,
            void 0
          ])) ?? []
        ),
        ...r
      }
    });
  }
  function O(n, l = {}) {
    const r = C(n);
    if (!r) return console.warn(`Filter [${n}] does not exist.`);
    const {
      debounce: e = 150,
      transform: t = (f) => f,
      ...a
    } = l;
    return {
      "onUpdate:modelValue": X((f) => {
        A(r, t(f), a);
      }, e),
      modelValue: r.value
    };
  }
  function I(n, l = {}) {
    if (!S.value)
      return console.warn("Refine cannot perform sorting.");
    const r = W(n);
    if (!r) return console.warn(`Sort [${n}] does not exist.`);
    const { debounce: e = 0, transform: t, ...a } = l;
    return {
      onClick: X(() => {
        var f;
        b(r, (f = T.value) == null ? void 0 : f.direction, a);
      }, e)
    };
  }
  function ee(n = {}) {
    if (!y.value)
      return console.warn("Refine cannot perform searching.");
    const { debounce: l = 750, transform: r, ...e } = n;
    return {
      "onUpdate:modelValue": X(
        (t) => {
          F(t, e);
        },
        l
      ),
      modelValue: _.value ?? ""
    };
  }
  function N(n, l = {}) {
    if (!v.value)
      return console.warn("Refine cannot perform matching.");
    const r = z(n);
    if (!r) return console.warn(`Match [${n}] does not exist.`);
    const { debounce: e = 0, transform: t, ...a } = l;
    return {
      "onUpdate:modelValue": X((f) => {
        E(f, a);
      }, e),
      modelValue: w(r),
      value: r.name
    };
  }
  return {
    processing: m,
    filters: k,
    sorts: $,
    searches: M,
    currentFilters: L,
    currentSort: T,
    currentSearches: j,
    searchTerm: _,
    isSortable: S,
    isSearchable: y,
    isMatchable: v,
    isFiltering: Y,
    isSorting: Z,
    isSearching: w,
    getFilter: C,
    getSort: W,
    getSearch: z,
    apply: H,
    applyFilter: A,
    applySort: b,
    applySearch: F,
    applyMatch: E,
    clearFilter: B,
    clearSort: D,
    clearSearch: J,
    clearMatch: P,
    reset: G,
    bindFilter: O,
    bindSort: I,
    bindSearch: ee,
    bindMatch: N,
    stringValue: U,
    omitValue: V,
    toggleValue: q,
    delimitArray: R
  };
}
function pe(o, g, p = {}) {
  if (!(o != null && o[g]))
    throw new Error("The table must be provided with valid props and key.");
  const { recordOperations: d = {}, ...s } = {
    only: [...p.only ?? [], g.toString()],
    ...p
  }, u = c(() => o[g]), m = c(() => u.value._id), i = ie(), { processing: _, ...S } = ve(o, g, s, {
    [u.value._page_key]: void 0
  }), { onFinish: y, ...v } = s, k = c(() => u.value.meta), $ = c(() => u.value.views ?? []), M = c(() => u.value.state ?? null), L = c(() => u.value.placeholder ?? null), T = c(() => !!u.value.state), j = c(
    () => !!u.value._page_key && !!u.value._record_key
  ), R = c(() => !!u.value._column_key), U = c(() => !!u.value.viewable), V = c(
    () => u.value.columns.filter(({ active: e, hidden: t }) => e && !t).map((e) => {
      var t;
      return {
        ...e,
        isSorting: !!((t = e.sort) != null && t.active),
        toggleSort: (a = {}) => S.applySort(e.sort, null, a)
      };
    })
  ), K = c(
    () => u.value.columns.filter(({ hidden: e }) => !e).map((e) => ({
      ...e,
      toggle: (t = {}) => N(e.name, t)
    }))
  ), q = c(
    () => u.value.records.map((e) => ({
      ...e,
      /** The operations available for the record */
      operations: e.operations.map((t) => ({
        ...t,
        execute: (a = {}) => G(t, e, a)
      })),
      /** Determine if the record is selected */
      selected: i.selected(b(e)),
      /** Perform this operation when the record is clicked */
      default: (t = {}) => {
        const a = e.operations.find(
          ({ default: f }) => f
        );
        a && G(a, e, t);
      },
      /** Selects this record */
      select: () => i.select(b(e)),
      /** Deselects this record */
      deselect: () => i.deselect(b(e)),
      /** Toggles the selection of this record */
      toggle: () => i.toggle(b(e)),
      /** Bind the record to a checkbox */
      bind: () => i.bind(b(e)),
      /** Get the entry of the record for the column */
      entry: (t) => F(e, t),
      /** Get the value of the record for the column */
      value: (t) => E(e, t),
      /** Get the extra data of the record for the column */
      extra: (t) => B(e, t)
    }))
  ), C = c(() => !!u.value.operations.inline), W = c(
    () => u.value.operations.bulk.map((e) => ({
      ...e,
      execute: (t = {}) => O(e, t)
    }))
  ), z = c(
    () => u.value.operations.page.map((e) => ({
      ...e,
      execute: (t = {}) => I(e, t)
    }))
  ), Y = c(
    () => u.value.pages.find(({ active: e }) => e)
  ), Z = c(() => u.value.pages), w = c(() => ({
    ...u.value.paginate,
    next: (e = {}) => {
      "nextLink" in w.value && w.value.nextLink && P(w.value.nextLink, e);
    },
    previous: (e = {}) => {
      "prevLink" in w.value && w.value.prevLink && P(w.value.prevLink, e);
    },
    first: (e = {}) => {
      "firstLink" in w.value && w.value.firstLink && P(w.value.firstLink, e);
    },
    last: (e = {}) => {
      "lastLink" in w.value && w.value.lastLink && P(w.value.lastLink, e);
    },
    ..."links" in u.value.paginate && u.value.paginate.links ? {
      links: u.value.paginate.links.map((e) => ({
        ...e,
        navigate: (t = {}) => e.url && P(e.url, t)
      }))
    } : {}
  })), H = c(
    () => u.value.records.length > 0 && u.value.records.every(
      (e) => i.selected(b(e))
    )
  );
  function A(e) {
    return typeof e == "string" ? e : e.name;
  }
  function b(e) {
    return e._key;
  }
  function F(e, t) {
    const a = A(t);
    return e[a];
  }
  function E(e, t) {
    var a;
    return ((a = F(e, t)) == null ? void 0 : a.v) ?? null;
  }
  function B(e, t) {
    var a;
    return (a = F(e, t)) == null ? void 0 : a.e;
  }
  function D(e) {
    return { id: b(e) };
  }
  function J() {
    return {
      all: i.selection.value.all,
      only: Array.from(i.selection.value.only),
      except: Array.from(i.selection.value.except)
    };
  }
  function P(e, t = {}) {
    _.value = !0;
    const { onFinish: a, ...f } = t;
    x.visit(e, {
      preserveScroll: !0,
      preserveState: !0,
      ...v,
      ...f,
      onFinish: (h) => {
        _.value = !1, y == null || y(h), a == null || a(h);
      },
      method: "get"
    });
  }
  function G(e, t, a = {}) {
    var h;
    ne(e, D(t), {
      ...p,
      ...a
    }) || (h = d == null ? void 0 : d[e.name]) == null || h.call(d, t);
  }
  function O(e, t = {}) {
    return ne(e, J(), {
      ...p,
      ...t,
      onSuccess: (a) => {
        var f, h;
        (f = t.onSuccess) == null || f.call(t, a), (h = p.onSuccess) == null || h.call(p, a), console.log("onSuccess"), e.keep || i.deselectAll();
      }
    });
  }
  function I(e, t = {}, a = {}) {
    return ne(e, t, { ...p, ...a });
  }
  function ee(e, t = {}) {
    if (!j.value)
      return console.warn("The table does not support pagination changes.");
    const { onFinish: a, ...f } = t;
    _.value = !0, x.reload({
      ...v,
      ...f,
      onFinish: (h) => {
        _.value = !1, y == null || y(h), a == null || a(h);
      },
      data: {
        [u.value._record_key]: e.value,
        [u.value._page_key]: void 0
      }
    });
  }
  function N(e, t = {}) {
    if (!R.value)
      return console.warn("The table does not support column toggling.");
    const a = A(e);
    if (!a) return console.log(`Column [${e}] does not exist.`);
    const f = S.toggleValue(
      a,
      V.value.map(({ name: Q }) => Q)
    ), { onFinish: h, ...oe } = t;
    _.value = !0, x.reload({
      ...v,
      ...oe,
      onFinish: (Q) => {
        _.value = !1, y == null || y(Q), h == null || h(Q);
      },
      data: {
        [u.value._column_key]: S.delimitArray(f)
      }
    });
  }
  function n() {
    i.select(
      ...u.value.records.map(
        (e) => b(e)
      )
    );
  }
  function l() {
    i.deselect(
      ...u.value.records.map(
        (e) => b(e)
      )
    );
  }
  function r() {
    return {
      "onUpdate:modelValue": (e) => {
        e ? n() : l();
      },
      modelValue: H.value
    };
  }
  return ue({
    /** The identifier of the table */
    id: m,
    /** Table-specific metadata */
    meta: k,
    /** The views for the table */
    views: $,
    /** The empty state for the table */
    emptyState: M,
    /** The placeholder for the search term.*/
    placeholder: L,
    /** Whether the table is empty */
    isEmpty: T,
    /** Whether the table supports changing the number of records to display per page */
    isPageable: j,
    /** Whether the table supports toggling columns */
    isToggleable: R,
    /** Whether the table supports storing views */
    isViewable: U,
    /** Get the entry of the record for the column */
    getEntry: F,
    /** Get the value of the record for the column */
    getValue: E,
    /** Get the extra data of the record for the column */
    getExtra: B,
    /** Retrieve a record's identifier */
    getRecordKey: b,
    /** The heading columns for the table */
    headings: V,
    /** All of the table's columns */
    columns: K,
    /** The records of the table */
    records: q,
    /** Whether the table has record operations */
    inline: C,
    /** The available bulk operations */
    bulk: W,
    /** The available page operations */
    page: z,
    /** The available number of records to display per page */
    pages: Z,
    /** The current record per page item */
    currentPage: Y,
    /** The pagination metadata */
    paginator: w,
    /** Execute an inline operation */
    executeInline: G,
    /** Execute a bulk operation */
    executeBulk: O,
    /** Execute a page operation */
    executePage: I,
    /** The bulk data */
    getBulkData: J,
    /** The record data */
    getRecordData: D,
    /** Apply a new page by changing the number of records to display */
    applyPage: ee,
    /** The current selection of records */
    selection: i.selection,
    /** Select the given records */
    select: (e) => i.select(b(e)),
    /** Deselect the given records */
    deselect: (e) => i.deselect(b(e)),
    /** Select records on the current page */
    selectPage: n,
    /** Deselect records on the current page */
    deselectPage: l,
    /** Toggle the selection of the given records */
    toggle: (e) => i.toggle(b(e)),
    /** Determine if the given record is selected */
    selected: (e) => i.selected(b(e)),
    /** Select all records */
    selectAll: i.selectAll,
    /** Deselect all records */
    deselectAll: i.deselectAll,
    /** Whether all records on the current page are selected */
    isPageSelected: H,
    /** Determine if any records are selected */
    hasSelected: i.hasSelected,
    /** Bind the given record to a checkbox */
    bindCheckbox: (e) => i.bind(b(e)),
    /** Bind the select all checkbox to the current page */
    bindPage: r,
    /** Bind select all records to the checkbox */
    bindAll: i.bindAll,
    /** The processing status */
    processing: _,
    /** The refine instance */
    ...S
  });
}
function he(o, g) {
  return o ? typeof o == "object" ? o.type === g : o === g : !1;
}
export {
  he as is,
  pe as useTable
};
