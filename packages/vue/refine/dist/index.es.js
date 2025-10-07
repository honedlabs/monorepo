import { toValue as q, computed as l } from "vue";
import { router as m } from "@inertiajs/vue3";
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const z = () => {
};
function X(a, u) {
  function i(...t) {
    return new Promise((f, c) => {
      Promise.resolve(a(() => u.apply(this, t), { fn: u, thisArg: this, args: t })).then(f).catch(c);
    });
  }
  return i;
}
function Y(a, u = {}) {
  let i, t, f = z;
  const c = (s) => {
    clearTimeout(s), f(), f = z;
  };
  let h;
  return (s) => {
    const g = q(a), p = q(u.maxWait);
    return i && c(i), g <= 0 || p !== void 0 && p <= 0 ? (t && (c(t), t = null), Promise.resolve(s())) : new Promise((v, b) => {
      f = u.rejectOnCancel ? b : v, h = s, p && !t && (t = setTimeout(() => {
        i && c(i), t = null, v(h());
      }, p)), i = setTimeout(() => {
        t && c(t), t = null, v(s());
      }, g);
    });
  };
}
function F(a, u = 200, i = {}) {
  return X(
    Y(u, i),
    a
  );
}
function ne(a, u, i = {}) {
  if (!(a != null && a[u]))
    throw new Error("The refine must be provided with valid props and key.");
  const t = l(() => a[u]), f = l(() => t.value.term), c = l(() => !!t.value._sort_key), h = l(() => !!t.value._search_key), _ = l(() => !!t.value._match_key), s = l(
    () => {
      var e;
      return (e = t.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r, o = {}) => k(n, r, o),
        clear: (r = {}) => U(n, r),
        bind: () => D(n.name)
      }));
    }
  ), g = l(
    () => {
      var e;
      return (e = t.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => M(n, n.direction, r),
        clear: (r = {}) => C(r),
        bind: () => G(n)
      }));
    }
  ), p = l(
    () => {
      var e;
      return (e = t.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => x(n, r),
        clear: (r = {}) => x(n, r),
        bind: () => I(n)
      }));
    }
  ), v = l(
    () => s.value.filter(({ active: e }) => e)
  ), b = l(
    () => g.value.find(({ active: e }) => e)
  ), R = l(
    () => p.value.filter(({ active: e }) => e)
  );
  function V(e) {
    return Array.isArray(e) ? e.join(t.value._delimiter) : e;
  }
  function O(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function S(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function E(e) {
    return [V, O, S].reduce(
      (n, r) => r(n),
      e
    );
  }
  function P(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((r) => r !== e) : [...n, e];
  }
  function j(e) {
    return typeof e != "string" ? e : s.value.find(({ name: n }) => n === e);
  }
  function T(e, n = null) {
    return typeof e != "string" ? e : g.value.find(
      ({ name: r, direction: o }) => r === e && o === n
    );
  }
  function A(e) {
    return typeof e != "string" ? e : p.value.find(({ name: n }) => n === e);
  }
  function B(e) {
    return e ? typeof e == "string" ? v.value.some((n) => n.name === e) : e.active : !!v.value.length;
  }
  function H(e) {
    var n;
    return e ? typeof e == "string" ? ((n = b.value) == null ? void 0 : n.name) === e : e.active : !!b.value;
  }
  function W(e) {
    var n;
    return e ? typeof e == "string" ? (n = R.value) == null ? void 0 : n.some((r) => r.name === e) : e.active : !!f.value;
  }
  function J(e, n = {}) {
    const r = Object.fromEntries(
      Object.entries(e).map(([o, d]) => [o, E(d)])
    );
    m.reload({
      ...i,
      ...n,
      data: r
    });
  }
  function k(e, n, r = {}) {
    const o = j(e);
    if (!o) return console.warn(`Filter [${e}] does not exist.`);
    m.reload({
      ...i,
      ...r,
      data: {
        [o.name]: E(n)
      }
    });
  }
  function M(e, n = null, r = {}) {
    if (!c.value)
      return console.warn("Refine cannot perform sorting.");
    const o = T(e, n);
    if (!o) return console.warn(`Sort [${e}] does not exist.`);
    m.reload({
      ...i,
      ...r,
      data: {
        [t.value._sort_key]: S(o.next)
      }
    });
  }
  function $(e, n = {}) {
    if (!h.value)
      return console.warn("Refine cannot perform searching.");
    e = [O, S].reduce(
      (r, o) => o(r),
      e
    ), m.reload({
      ...i,
      ...n,
      data: {
        [t.value._search_key]: e
      }
    });
  }
  function x(e, n = {}) {
    if (!_.value || !h.value)
      return console.warn("Refine cannot perform matching.");
    const r = A(e);
    if (!r) return console.warn(`Match [${e}] does not exist.`);
    const o = P(
      r.name,
      R.value.map(({ name: d }) => d)
    );
    m.reload({
      ...i,
      ...n,
      data: {
        [t.value._match_key]: V(o)
      }
    });
  }
  function U(e, n = {}) {
    if (e) return k(e, null, n);
    m.reload({
      ...i,
      ...n,
      data: Object.fromEntries(
        v.value.map(({ name: r }) => [r, null])
      )
    });
  }
  function C(e = {}) {
    if (!c.value)
      return console.warn("Refine cannot perform sorting.");
    m.reload({
      ...i,
      ...e,
      data: {
        [t.value._sort_key]: null
      }
    });
  }
  function K(e = {}) {
    $(null, e);
  }
  function L(e = {}) {
    if (!_.value)
      return console.warn("Refine cannot perform matching.");
    m.reload({
      ...i,
      ...e,
      data: {
        [t.value._match_key]: null
      }
    });
  }
  function N(e = {}) {
    var n;
    m.reload({
      ...i,
      ...e,
      data: {
        [t.value._search_key ?? ""]: void 0,
        [t.value._sort_key ?? ""]: void 0,
        [t.value._match_key ?? ""]: void 0,
        ...Object.fromEntries(
          ((n = t.value.filters) == null ? void 0 : n.map((r) => [
            r.name,
            void 0
          ])) ?? []
        )
      }
    });
  }
  function D(e, n = {}) {
    const r = j(e);
    if (!r) return console.warn(`Filter [${e}] does not exist.`);
    const {
      debounce: o = 150,
      transform: d = (y) => y,
      ...w
    } = n;
    return {
      "onUpdate:modelValue": F((y) => {
        k(r, d(y), w);
      }, o),
      modelValue: r.value
    };
  }
  function G(e, n = {}) {
    if (!c.value)
      return console.warn("Refine cannot perform sorting.");
    const r = T(e);
    if (!r) return console.warn(`Sort [${e}] does not exist.`);
    const { debounce: o = 0, transform: d, ...w } = n;
    return {
      onClick: F(() => {
        var y;
        M(r, (y = b.value) == null ? void 0 : y.direction, w);
      }, o)
    };
  }
  function Q(e = {}) {
    if (!h.value)
      return console.warn("Refine cannot perform searching.");
    const { debounce: n = 700, transform: r, ...o } = e;
    return {
      "onUpdate:modelValue": F(
        (d) => {
          $(d, o);
        },
        n
      ),
      modelValue: f.value ?? ""
    };
  }
  function I(e, n = {}) {
    if (!_.value)
      return console.warn("Refine cannot perform matching.");
    const r = A(e);
    if (!r) return console.warn(`Match [${e}] does not exist.`);
    const { debounce: o = 0, transform: d, ...w } = n;
    return {
      "onUpdate:modelValue": F((y) => {
        x(y, w);
      }, o),
      modelValue: W(r),
      value: r.name
    };
  }
  return {
    filters: s,
    sorts: g,
    searches: p,
    currentFilters: v,
    currentSort: b,
    currentSearches: R,
    searchTerm: f,
    isSortable: c,
    isSearchable: h,
    isMatchable: _,
    isFiltering: B,
    isSorting: H,
    isSearching: W,
    getFilter: j,
    getSort: T,
    getSearch: A,
    apply: J,
    applyFilter: k,
    applySort: M,
    applySearch: $,
    applyMatch: x,
    clearFilter: U,
    clearSort: C,
    clearSearch: K,
    clearMatch: L,
    reset: N,
    bindFilter: D,
    bindSort: G,
    bindSearch: Q,
    bindMatch: I,
    stringValue: O,
    omitValue: S,
    toggleValue: P,
    delimitArray: V
  };
}
function re(a, u) {
  return a ? typeof a == "object" ? (a == null ? void 0 : a.type) === u : a === u : !1;
}
export {
  re as is,
  ne as useRefine
};
