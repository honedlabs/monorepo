import { toValue as _, computed as f, reactive as Q } from "vue";
import { router as p } from "@inertiajs/vue3";
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const q = () => {
};
function X(a, u) {
  function i(...r) {
    return new Promise((l, c) => {
      Promise.resolve(a(() => u.apply(this, r), { fn: u, thisArg: this, args: r })).then(l).catch(c);
    });
  }
  return i;
}
function Y(a, u = {}) {
  let i, r, l = q;
  const c = (s) => {
    clearTimeout(s), l(), l = q;
  };
  let g;
  return (s) => {
    const b = _(a), d = _(u.maxWait);
    return i && c(i), b <= 0 || d !== void 0 && d <= 0 ? (r && (c(r), r = null), Promise.resolve(s())) : new Promise((v, y) => {
      l = u.rejectOnCancel ? y : v, g = s, d && !r && (r = setTimeout(() => {
        i && c(i), r = null, v(g());
      }, d)), i = setTimeout(() => {
        r && c(r), r = null, v(s());
      }, b);
    });
  };
}
function V(a, u = 200, i = {}) {
  return X(
    Y(u, i),
    a
  );
}
function ne(a, u, i = {}) {
  if (!(a != null && a[u]))
    throw new Error("The refine must be provided with valid props and key.");
  const r = f(() => a[u]), l = f(() => !!r.value.sort), c = f(() => !!r.value.search), g = f(() => !!r.value.match), S = f(
    () => {
      var e;
      return (e = r.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t, o = {}) => F(n, t, o),
        clear: (t = {}) => k(n, t),
        bind: () => D(n.name)
      }));
    }
  ), s = f(
    () => {
      var e;
      return (e = r.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => $(n, n.direction, t),
        clear: (t = {}) => C(t),
        bind: () => G(n)
      }));
    }
  ), b = f(
    () => {
      var e;
      return (e = r.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => R(n, t),
        clear: (t = {}) => R(n, t),
        bind: () => I(n)
      }));
    }
  ), d = f(
    () => S.value.filter(({ active: e }) => e)
  ), v = f(
    () => s.value.find(({ active: e }) => e)
  ), y = f(
    () => b.value.filter(({ active: e }) => e)
  );
  function O(e) {
    return Array.isArray(e) ? e.join(r.value.delimiter) : e;
  }
  function j(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function x(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function P(e) {
    return [O, j, x].reduce(
      (n, t) => t(n),
      e
    );
  }
  function W(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((t) => t !== e) : [...n, e];
  }
  function T(e) {
    return typeof e != "string" ? e : S.value.find(({ name: n }) => n === e);
  }
  function A(e, n = null) {
    return typeof e != "string" ? e : s.value.find(
      ({ name: t, direction: o }) => t === e && o === n
    );
  }
  function M(e) {
    return typeof e != "string" ? e : b.value.find(({ name: n }) => n === e);
  }
  function z(e) {
    return e ? typeof e == "string" ? d.value.some((n) => n.name === e) : e.active : !!d.value.length;
  }
  function B(e) {
    var n;
    return e ? typeof e == "string" ? ((n = v.value) == null ? void 0 : n.name) === e : e.active : !!v.value;
  }
  function U(e) {
    var n;
    return e ? typeof e == "string" ? (n = y.value) == null ? void 0 : n.some((t) => t.name === e) : e.active : !!r.value.term;
  }
  function H(e, n = {}) {
    const t = Object.fromEntries(
      Object.entries(e).map(([o, m]) => [o, P(m)])
    );
    p.reload({
      ...i,
      ...n,
      data: t
    });
  }
  function F(e, n, t = {}) {
    const o = T(e);
    if (!o) return console.warn(`Filter [${e}] does not exist.`);
    p.reload({
      ...i,
      ...t,
      data: {
        [o.name]: P(n)
      }
    });
  }
  function $(e, n = null, t = {}) {
    if (!l.value)
      return console.warn("Refine cannot perform sorting.");
    const o = A(e, n);
    if (!o) return console.warn(`Sort [${e}] does not exist.`);
    p.reload({
      ...i,
      ...t,
      data: {
        [r.value.sort]: x(o.next)
      }
    });
  }
  function E(e, n = {}) {
    if (!c.value)
      return console.warn("Refine cannot perform searching.");
    e = [j, x].reduce(
      (t, o) => o(t),
      e
    ), p.reload({
      ...i,
      ...n,
      data: {
        [r.value.search]: e
      }
    });
  }
  function R(e, n = {}) {
    if (!g.value || !c.value)
      return console.warn("Refine cannot perform matching.");
    const t = M(e);
    if (!t) return console.warn(`Match [${e}] does not exist.`);
    const o = W(
      t.name,
      y.value.map(({ name: m }) => m)
    );
    p.reload({
      ...i,
      ...n,
      data: {
        [r.value.match]: O(o)
      }
    });
  }
  function k(e, n = {}) {
    if (e) return F(e, null, n);
    p.reload({
      ...i,
      ...n,
      data: Object.fromEntries(
        d.value.map(({ name: t }) => [t, null])
      )
    });
  }
  function C(e = {}) {
    if (!l.value)
      return console.warn("Refine cannot perform sorting.");
    p.reload({
      ...i,
      ...e,
      data: {
        [r.value.sort]: null
      }
    });
  }
  function J(e = {}) {
    E(null, e);
  }
  function K(e = {}) {
    if (!g.value)
      return console.warn("Refine cannot perform matching.");
    p.reload({
      ...i,
      ...e,
      data: {
        [r.value.match]: null
      }
    });
  }
  function L(e = {}) {
    var n;
    p.reload({
      ...i,
      ...e,
      data: {
        [r.value.search ?? ""]: void 0,
        [r.value.sort ?? ""]: void 0,
        [r.value.match ?? ""]: void 0,
        ...Object.fromEntries(
          ((n = r.value.filters) == null ? void 0 : n.map((t) => [
            t.name,
            void 0
          ])) ?? []
        )
      }
    });
  }
  function D(e, n = {}) {
    const t = T(e);
    if (!t) return console.warn(`Filter [${e}] does not exist.`);
    const {
      debounce: o = 150,
      transform: m = (h) => h,
      ...w
    } = n;
    return {
      "onUpdate:modelValue": V((h) => {
        F(t, m(h), w);
      }, o),
      modelValue: t.value
    };
  }
  function G(e, n = {}) {
    if (!l.value)
      return console.warn("Refine cannot perform sorting.");
    const t = A(e);
    if (!t) return console.warn(`Sort [${e}] does not exist.`);
    const { debounce: o = 0, transform: m, ...w } = n;
    return {
      onClick: V(() => {
        var h;
        $(t, (h = v.value) == null ? void 0 : h.direction, w);
      }, o)
    };
  }
  function N(e = {}) {
    if (!c.value)
      return console.warn("Refine cannot perform searching.");
    const { debounce: n = 700, transform: t, ...o } = e;
    return {
      "onUpdate:modelValue": V(
        (m) => {
          E(m, o);
        },
        n
      ),
      modelValue: r.value.term ?? ""
    };
  }
  function I(e, n = {}) {
    if (!g.value)
      return console.warn("Refine cannot perform matching.");
    const t = M(e);
    if (!t) return console.warn(`Match [${e}] does not exist.`);
    const { debounce: o = 0, transform: m, ...w } = n;
    return {
      "onUpdate:modelValue": V((h) => {
        R(h, w);
      }, o),
      modelValue: U(t),
      value: t.name
    };
  }
  return Q({
    filters: S,
    sorts: s,
    searches: b,
    currentFilters: d,
    currentSort: v,
    currentSearches: y,
    isSortable: l,
    isSearchable: c,
    isMatchable: g,
    isFiltering: z,
    isSorting: B,
    isSearching: U,
    getFilter: T,
    getSort: A,
    getSearch: M,
    apply: H,
    applyFilter: F,
    applySort: $,
    applySearch: E,
    applyMatch: R,
    clearFilter: k,
    clearSort: C,
    clearSearch: J,
    clearMatch: K,
    reset: L,
    bindFilter: D,
    bindSort: G,
    bindSearch: N,
    bindMatch: I,
    stringValue: j,
    omitValue: x,
    toggleValue: W,
    delimitArray: O
  });
}
function te(a, u) {
  return a ? typeof a == "object" ? (a == null ? void 0 : a.type) === u : a === u : !1;
}
export {
  te as is,
  ne as useRefine
};
