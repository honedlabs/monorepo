import { ref as q, computed as p, toValue as Q, reactive as Z } from "vue";
import { router as S } from "@inertiajs/vue3";
function ee(r, v, c, l = {}) {
  return r.route ? (S.visit(r.route.url, {
    ...l,
    method: r.route.method
  }), !0) : r.action && v ? (S.post(
    v,
    {
      ...c,
      name: r.name,
      type: r.type
    },
    l
  ), !0) : !1;
}
function Y(r, v, c, l = {}, d = {}) {
  return ee(
    r,
    v,
    {
      ...l,
      id: c ?? void 0
    },
    {
      ...d
    }
  );
}
function ne(r, v, c, l = {}) {
  return r.map((d) => ({
    ...d,
    execute: (o = {}, u = {}) => Y(d, v, c, o, { ...l, ...u })
  }));
}
function te() {
  const r = q({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function v() {
    r.value.all = !0, r.value.only.clear(), r.value.except.clear();
  }
  function c() {
    r.value.all = !1, r.value.only.clear(), r.value.except.clear();
  }
  function l(...s) {
    s.forEach((g) => r.value.except.delete(g)), s.forEach((g) => r.value.only.add(g));
  }
  function d(...s) {
    s.forEach((g) => r.value.except.add(g)), s.forEach((g) => r.value.only.delete(g));
  }
  function o(s, g) {
    if (u(s) || g === !1) return d(s);
    if (!u(s) || g === !0) return l(s);
  }
  function u(s) {
    return r.value.all ? !r.value.except.has(s) : r.value.only.has(s);
  }
  const b = p(() => r.value.all && r.value.except.size === 0), V = p(() => r.value.only.size > 0 || b.value);
  function w(s) {
    return {
      "onUpdate:modelValue": (g) => {
        g ? l(s) : d(s);
      },
      modelValue: u(s),
      value: s
    };
  }
  function x() {
    return {
      "onUpdate:modelValue": (s) => {
        s ? v() : c();
      },
      modelValue: b.value
    };
  }
  return {
    allSelected: b,
    selection: r,
    hasSelected: V,
    selectAll: v,
    deselectAll: c,
    select: l,
    deselect: d,
    toggle: o,
    selected: u,
    bind: w,
    bindAll: x
  };
}
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const X = () => {
};
function le(r, v) {
  function c(...l) {
    return new Promise((d, o) => {
      Promise.resolve(r(() => v.apply(this, l), { fn: v, thisArg: this, args: l })).then(d).catch(o);
    });
  }
  return c;
}
function ae(r, v = {}) {
  let c, l, d = X;
  const o = (b) => {
    clearTimeout(b), d(), d = X;
  };
  let u;
  return (b) => {
    const V = Q(r), w = Q(v.maxWait);
    return c && o(c), V <= 0 || w !== void 0 && w <= 0 ? (l && (o(l), l = null), Promise.resolve(b())) : new Promise((x, s) => {
      d = v.rejectOnCancel ? s : x, u = b, w && !l && (l = setTimeout(() => {
        c && o(c), l = null, x(u());
      }, w)), c = setTimeout(() => {
        l && o(l), l = null, x(b());
      }, V);
    });
  };
}
function N(r, v = 200, c = {}) {
  return le(
    ae(v, c),
    r
  );
}
function re(r, v, c = {}) {
  const l = p(() => r[v]), d = p(() => !!l.value.sort), o = p(() => !!l.value.search), u = p(() => !!l.value.match), b = p(
    () => {
      var e;
      return (e = l.value.filters) == null ? void 0 : e.map((t) => ({
        ...t,
        apply: (a, m = {}) => M(t, a, m),
        clear: (a = {}) => K(t, a),
        bind: () => $(t.name)
      }));
    }
  ), V = p(
    () => {
      var e;
      return (e = l.value.sorts) == null ? void 0 : e.map((t) => ({
        ...t,
        apply: (a = {}) => z(t, t.direction, a),
        clear: (a = {}) => n(a),
        bind: () => H(t)
      }));
    }
  ), w = p(
    () => {
      var e;
      return (e = l.value.searches) == null ? void 0 : e.map((t) => ({
        ...t,
        apply: (a = {}) => j(t, a),
        clear: (a = {}) => j(t, a),
        bind: () => J(t)
      }));
    }
  );
  function x(e) {
    return e.filter(({ active: t }) => t);
  }
  const s = p(
    () => x(l.value.filters)
  ), g = p(
    () => {
      var e;
      return (e = x(l.value.sorts)) == null ? void 0 : e[0];
    }
  ), U = p(
    () => x(l.value.searches)
  );
  function C(e) {
    return Array.isArray(e) ? e.join(l.value.delimiter) : e;
  }
  function O(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function h(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function W(e) {
    return [C, O, h].reduce(
      (t, a) => a(t),
      e
    );
  }
  function y(e, t) {
    return t = Array.isArray(t) ? t : [t], t.includes(e) ? t.filter((a) => a !== e) : [...t, e];
  }
  function L(e) {
    var t;
    return typeof e != "string" ? e : (t = l.value.filters) == null ? void 0 : t.find(({ name: a }) => a === e);
  }
  function T(e, t = null) {
    var a;
    return typeof e != "string" ? e : (a = l.value.sorts) == null ? void 0 : a.find(
      ({ name: m, direction: k }) => m === e && k === t
    );
  }
  function E(e) {
    var t;
    return typeof e != "string" ? e : (t = l.value.searches) == null ? void 0 : t.find(({ name: a }) => a === e);
  }
  function F(e) {
    return e ? typeof e == "string" ? s.value.some((t) => t.name === e) : e.active : !!s.value.length;
  }
  function B(e) {
    var t;
    return e ? typeof e == "string" ? ((t = g.value) == null ? void 0 : t.name) === e : e.active : !!g.value;
  }
  function I(e) {
    var t;
    return e ? typeof e == "string" ? (t = U.value) == null ? void 0 : t.some((a) => a.name === e) : e.active : !!l.value.term;
  }
  function D(e, t = {}) {
    const a = Object.fromEntries(
      Object.entries(e).map(([m, k]) => [m, W(k)])
    );
    S.reload({
      ...c,
      ...t,
      data: a
    });
  }
  function M(e, t, a = {}) {
    const m = L(e);
    if (!m) return console.warn(`Filter [${e}] does not exist.`);
    S.reload({
      ...c,
      ...a,
      data: {
        [m.name]: W(t)
      }
    });
  }
  function z(e, t = null, a = {}) {
    const m = T(e, t);
    if (!m) return console.warn(`Sort [${e}] does not exist.`);
    if (!d.value)
      return console.warn("Refine cannot perform sorting.");
    S.reload({
      ...c,
      ...a,
      data: {
        [l.value.sort]: h(m.next)
      }
    });
  }
  function R(e, t = {}) {
    if (e = [O, h].reduce(
      (a, m) => m(a),
      e
    ), !o.value)
      return console.warn("Refine cannot perform searching.");
    S.reload({
      ...c,
      ...t,
      data: {
        [l.value.search]: e
      }
    });
  }
  function j(e, t = {}) {
    const a = E(e);
    if (!a) return console.warn(`Match [${e}] does not exist.`);
    if (!u.value || !o.value)
      return console.warn("Refine cannot perform matching.");
    const m = y(
      a.name,
      U.value.map(({ name: k }) => k)
    );
    S.reload({
      ...c,
      ...t,
      data: {
        [l.value.match]: C(m)
      }
    });
  }
  function K(e, t = {}) {
    if (e) return M(e, null, t);
    S.reload({
      ...c,
      ...t,
      data: Object.fromEntries(
        s.value.map(({ name: a }) => [a, null])
      )
    });
  }
  function n(e = {}) {
    if (!d.value)
      return console.warn("Refine cannot perform sorting.");
    S.reload({
      ...c,
      ...e,
      data: {
        [l.value.sort]: null
      }
    });
  }
  function i(e = {}) {
    R(null, e);
  }
  function f(e = {}) {
    if (!u.value)
      return console.warn("Refine cannot perform matching.");
    S.reload({
      ...c,
      ...e,
      data: {
        [l.value.match]: null
      }
    });
  }
  function A(e = {}) {
    var t;
    S.reload({
      ...c,
      ...e,
      data: {
        [l.value.search ?? ""]: void 0,
        [l.value.sort ?? ""]: void 0,
        [l.value.match ?? ""]: void 0,
        ...Object.fromEntries(
          ((t = l.value.filters) == null ? void 0 : t.map((a) => [
            a.name,
            void 0
          ])) ?? []
        )
      }
    });
  }
  function $(e, t = {}) {
    const a = L(e);
    if (!a) return console.warn(`Filter [${e}] does not exist.`);
    const {
      debounce: m = 250,
      transform: k = (P) => P,
      ...G
    } = t;
    return {
      "onUpdate:modelValue": N((P) => {
        M(a, k(P), G);
      }, m),
      modelValue: a.value
    };
  }
  function H(e, t = {}) {
    const a = T(e);
    if (!a) return console.warn(`Sort [${e}] does not exist.`);
    const { debounce: m = 0, transform: k, ...G } = t;
    return {
      onClick: N(() => {
        var P;
        z(a, (P = g.value) == null ? void 0 : P.direction, G);
      }, m)
    };
  }
  function _(e = {}) {
    const { debounce: t = 700, transform: a, ...m } = e;
    return {
      "onUpdate:modelValue": N(
        (k) => {
          R(k, m);
        },
        t
      ),
      modelValue: l.value.term ?? ""
    };
  }
  function J(e, t = {}) {
    const a = E(e);
    if (!a) return console.warn(`Match [${e}] does not exist.`);
    const { debounce: m = 0, transform: k, ...G } = t;
    return {
      "onUpdate:modelValue": N((P) => {
        j(P, G);
      }, m),
      modelValue: I(a),
      value: a.name
    };
  }
  return {
    filters: b,
    sorts: V,
    searches: w,
    currentFilters: s,
    currentSort: g,
    currentSearches: U,
    isSortable: d,
    isSearchable: o,
    isMatchable: u,
    isFiltering: F,
    isSorting: B,
    isSearching: I,
    getFilter: L,
    getSort: T,
    getSearch: E,
    apply: D,
    applyFilter: M,
    applySort: z,
    applySearch: R,
    applyMatch: j,
    clearFilter: K,
    clearSort: n,
    clearSearch: i,
    clearMatch: f,
    reset: A,
    bindFilter: $,
    bindSort: H,
    bindSearch: _,
    bindMatch: J,
    stringValue: O,
    omitValue: h,
    toggleValue: y,
    delimitArray: C
  };
}
function ie(r, v, c = {}) {
  if (!(r != null && r[v]))
    throw new Error("The table must be provided with valid props and key.");
  const { recordOperations: l = {}, ...d } = {
    only: [...c.only ?? [], v.toString()],
    ...c
  }, o = p(() => r[v]), u = te(), b = re(r, v, d), V = p(() => !!o.value.page && !!o.value.record), w = p(() => !!o.value.column), x = p(
    () => o.value.columns.filter(({ active: n, hidden: i }) => n && !i).map((n) => {
      var i;
      return {
        ...n,
        isSorting: !!((i = n.sort) != null && i.active),
        toggleSort: (f = {}) => b.applySort(n.sort, null, f)
      };
    })
  ), s = p(
    () => o.value.columns.filter(({ hidden: n }) => !n).map((n) => ({
      ...n,
      toggle: (i = {}) => z(n.name, i)
    }))
  ), g = p(
    () => o.value.records.map((n) => ({
      record: (({ operations: i, ...f }) => f)(n),
      /** The operations available for the record */
      operations: E(n.operations),
      /** Perform this operation when the record is clicked */
      default: (i = {}) => {
        const f = n.operations.find(
          ({ default: A }) => A
        );
        f && B(f, n, i);
      },
      /** Selects this record */
      select: () => u.select(y(n)),
      /** Deselects this record */
      deselect: () => u.deselect(y(n)),
      /** Toggles the selection of this record */
      toggle: () => u.toggle(y(n)),
      /** Determine if the record is selected */
      selected: u.selected(y(n)),
      /** Bind the record to a checkbox */
      bind: () => u.bind(y(n)),
      /** Get the value of the record for the column */
      value: (i) => {
        const f = L(i);
        return f in n ? n[f].v : null;
      },
      /** Get the extra data of the record for the column */
      extra: (i) => {
        const f = L(i);
        return console.log(f, n), f in n ? n[f].e : null;
      }
    }))
  ), U = p(() => E(o.value.operations.bulk)), C = p(() => E(o.value.operations.page)), O = p(
    () => o.value.pages.find(({ active: n }) => n)
  ), h = p(() => ({
    ...o.value.paginate,
    next: (n = {}) => {
      "nextLink" in h.value && h.value.nextLink && F(h.value.nextLink, n);
    },
    previous: (n = {}) => {
      "prevLink" in h.value && h.value.prevLink && F(h.value.prevLink, n);
    },
    first: (n = {}) => {
      "firstLink" in h.value && h.value.firstLink && F(h.value.firstLink, n);
    },
    last: (n = {}) => {
      "lastLink" in h.value && h.value.lastLink && F(h.value.lastLink, n);
    },
    ..."links" in o.value.paginate && o.value.paginate.links ? {
      links: o.value.paginate.links.map((n) => ({
        ...n,
        navigate: (i = {}) => n.url && F(n.url, i)
      }))
    } : {}
  })), W = p(
    () => o.value.records.length > 0 && o.value.records.every(
      (n) => u.selected(y(n))
    )
  );
  function y(n) {
    return n[o.value.key].v;
  }
  function L(n) {
    return typeof n == "string" ? n : n.name;
  }
  function T(n, i = {}, f = {}) {
    return Y(
      n,
      o.value.endpoint,
      o.value.id,
      i,
      {
        ...d,
        ...f
      }
    );
  }
  function E(n) {
    return ne(
      n,
      o.value.endpoint,
      o.value.id,
      d
    );
  }
  function F(n, i = {}) {
    S.visit(n, {
      preserveScroll: !0,
      preserveState: !0,
      ...d,
      ...i,
      method: "get"
    });
  }
  function B(n, i, f = {}) {
    var $;
    T(
      n,
      {
        record: y(i)
      },
      f
    ) || ($ = l == null ? void 0 : l[n.name]) == null || $.call(l, i);
  }
  function I(n, i = {}) {
    T(
      n,
      {
        all: u.selection.value.all,
        only: Array.from(u.selection.value.only),
        except: Array.from(u.selection.value.except)
      },
      {
        ...i,
        onSuccess: (f) => {
          var A;
          (A = i.onSuccess) == null || A.call(i, f), n.keepSelected || u.deselectAll();
        }
      }
    );
  }
  function D(n, i = {}, f = {}) {
    return T(n, i, f);
  }
  function M(n, i = {}) {
    if (!V.value)
      return console.warn("The table does not support pagination changes.");
    S.reload({
      ...d,
      ...i,
      data: {
        [o.value.record]: n.value,
        [o.value.page]: void 0
      }
    });
  }
  function z(n, i = {}) {
    if (!w.value)
      return console.warn("The table does not support column toggling.");
    const f = L(n);
    if (!f) return console.log(`Column [${n}] does not exist.`);
    const A = b.toggleValue(
      f,
      x.value.map(({ name: $ }) => $)
    );
    S.reload({
      ...d,
      ...i,
      data: {
        [o.value.column]: b.delimitArray(A)
      }
    });
  }
  function R() {
    u.select(
      ...o.value.records.map(
        (n) => y(n)
      )
    );
  }
  function j() {
    u.deselect(
      ...o.value.records.map(
        (n) => y(n)
      )
    );
  }
  function K() {
    return {
      "onUpdate:modelValue": (n) => {
        n ? R() : j();
      },
      modelValue: W.value
    };
  }
  return Z({
    /** The table's configuration */
    table: o,
    /** Retrieve a record's identifier */
    getRecordKey: y,
    /** Table-specific metadata */
    meta: o.value.meta,
    /** The heading columns for the table */
    headings: x,
    /** All of the table's columns */
    columns: s,
    /** The records of the table */
    records: g,
    /** Whether the table has record operations */
    inline: o.value.operations.inline,
    /** The available bulk operations */
    bulk: U,
    /** The available page operations */
    page: C,
    /** The available number of records to display per page */
    pages: o.value.pages,
    /** The current record per page item */
    currentPage: O,
    /** The pagination metadata */
    paginator: h,
    /** Execute an inline operation */
    executeInline: B,
    /** Execute a bulk operation */
    executeBulk: I,
    /** Execute a page operation */
    executePage: D,
    /** Apply a new page by changing the number of records to display */
    applyPage: M,
    /** The current selection of records */
    selection: u.selection,
    /** Select the given records */
    select: (n) => u.select(y(n)),
    /** Deselect the given records */
    deselect: (n) => u.deselect(y(n)),
    /** Select records on the current page */
    selectPage: R,
    /** Deselect records on the current page */
    deselectPage: j,
    /** Toggle the selection of the given records */
    toggle: (n) => u.toggle(y(n)),
    /** Determine if the given record is selected */
    selected: (n) => u.selected(y(n)),
    /** Select all records */
    selectAll: u.selectAll,
    /** Deselect all records */
    deselectAll: u.deselectAll,
    /** Whether all records on the current page are selected */
    isPageSelected: W,
    /** Determine if any records are selected */
    hasSelected: u.hasSelected,
    /** Bind the given record to a checkbox */
    bindCheckbox: (n) => u.bind(y(n)),
    /** Bind the select all checkbox to the current page */
    bindPage: K,
    /** Bind select all records to the checkbox */
    bindAll: u.bindAll,
    /** Include the sorts, filters, and search query */
    ...b
  });
}
function ce(r, v) {
  return r ? typeof r == "object" ? r.type === v : r === v : !1;
}
export {
  ce as is,
  ie as useTable
};
