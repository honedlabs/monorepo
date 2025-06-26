import { toValue as _, computed as l, reactive as Q } from "vue";
import { router as p } from "@inertiajs/vue3";
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const q = () => {
};
function X(a, u) {
  function o(...t) {
    return new Promise((f, c) => {
      Promise.resolve(a(() => u.apply(this, t), { fn: u, thisArg: this, args: t })).then(f).catch(c);
    });
  }
  return o;
}
function Y(a, u = {}) {
  let o, t, f = q;
  const c = (s) => {
    clearTimeout(s), f(), f = q;
  };
  let b;
  return (s) => {
    const g = _(a), d = _(u.maxWait);
    return o && c(o), g <= 0 || d !== void 0 && d <= 0 ? (t && (c(t), t = null), Promise.resolve(s())) : new Promise((v, y) => {
      f = u.rejectOnCancel ? y : v, b = s, d && !t && (t = setTimeout(() => {
        o && c(o), t = null, v(b());
      }, d)), o = setTimeout(() => {
        t && c(t), t = null, v(s());
      }, g);
    });
  };
}
function O(a, u = 200, o = {}) {
  return X(
    Y(u, o),
    a
  );
}
function ne(a, u, o = {}) {
  if (!(a != null && a[u]))
    throw new Error("The refine must be provided with valid props and key.");
  const t = l(() => a[u]), f = l(() => !!t.value.sort), c = l(() => !!t.value.search), b = l(() => !!t.value.match), w = l(
    () => {
      var e;
      return (e = t.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r, i = {}) => F(n, r, i),
        clear: (r = {}) => k(n, r),
        bind: () => D(n.name)
      }));
    }
  ), s = l(
    () => {
      var e;
      return (e = t.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => $(n, n.direction, r),
        clear: (r = {}) => C(r),
        bind: () => G(n)
      }));
    }
  ), g = l(
    () => {
      var e;
      return (e = t.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => V(n, r),
        clear: (r = {}) => V(n, r),
        bind: () => I(n)
      }));
    }
  ), d = l(
    () => w.value.filter(({ active: e }) => e)
  ), v = l(
    () => s.value.find(({ active: e }) => e)
  ), y = l(
    () => g.value.filter(({ active: e }) => e)
  );
  function j(e) {
    return Array.isArray(e) ? e.join(t.value.delimiter) : e;
  }
  function R(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function x(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function P(e) {
    return [j, R, x].reduce(
      (n, r) => r(n),
      e
    );
  }
  function W(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((r) => r !== e) : [...n, e];
  }
  function T(e) {
    return typeof e != "string" ? e : w.value.find(({ name: n }) => n === e);
  }
  function A(e, n = null) {
    return typeof e != "string" ? e : s.value.find(
      ({ name: r, direction: i }) => r === e && i === n
    );
  }
  function M(e) {
    return typeof e != "string" ? e : g.value.find(({ name: n }) => n === e);
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
    return e ? typeof e == "string" ? (n = y.value) == null ? void 0 : n.some((r) => r.name === e) : e.active : !!t.value.term;
  }
  function H(e, n = {}) {
    const r = Object.fromEntries(
      Object.entries(e).map(([i, m]) => [i, P(m)])
    );
    p.reload({
      ...o,
      ...n,
      data: r
    });
  }
  function F(e, n, r = {}) {
    const i = T(e);
    if (!i) return console.warn(`Filter [${e}] does not exist.`);
    p.reload({
      ...o,
      ...r,
      data: {
        [i.name]: P(n)
      }
    });
  }
  function $(e, n = null, r = {}) {
    if (!f.value)
      return console.warn("Refine cannot perform sorting.");
    const i = A(e, n);
    if (!i) return console.warn(`Sort [${e}] does not exist.`);
    p.reload({
      ...o,
      ...r,
      data: {
        [t.value.sort]: x(i.next)
      }
    });
  }
  function E(e, n = {}) {
    if (!c.value)
      return console.warn("Refine cannot perform searching.");
    e = [R, x].reduce(
      (r, i) => i(r),
      e
    ), p.reload({
      ...o,
      ...n,
      data: {
        [t.value.search]: e
      }
    });
  }
  function V(e, n = {}) {
    if (!b.value || !c.value)
      return console.warn("Refine cannot perform matching.");
    const r = M(e);
    if (!r) return console.warn(`Match [${e}] does not exist.`);
    const i = W(
      r.name,
      y.value.map(({ name: m }) => m)
    );
    p.reload({
      ...o,
      ...n,
      data: {
        [t.value.match]: j(i)
      }
    });
  }
  function k(e, n = {}) {
    if (e) return F(e, null, n);
    p.reload({
      ...o,
      ...n,
      data: Object.fromEntries(
        d.value.map(({ name: r }) => [r, null])
      )
    });
  }
  function C(e = {}) {
    if (!f.value)
      return console.warn("Refine cannot perform sorting.");
    p.reload({
      ...o,
      ...e,
      data: {
        [t.value.sort]: null
      }
    });
  }
  function J(e = {}) {
    E(null, e);
  }
  function K(e = {}) {
    if (!b.value)
      return console.warn("Refine cannot perform matching.");
    p.reload({
      ...o,
      ...e,
      data: {
        [t.value.match]: null
      }
    });
  }
  function L(e = {}) {
    var n;
    p.reload({
      ...o,
      ...e,
      data: {
        [t.value.search ?? ""]: void 0,
        [t.value.sort ?? ""]: void 0,
        [t.value.match ?? ""]: void 0,
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
    const r = T(e);
    if (!r) return console.warn(`Filter [${e}] does not exist.`);
    const {
      debounce: i = 250,
      transform: m = (h) => h,
      ...S
    } = n;
    return {
      "onUpdate:modelValue": O((h) => {
        F(r, m(h), S);
      }, i),
      modelValue: r.value
    };
  }
  function G(e, n = {}) {
    const r = A(e);
    if (!r) return console.warn(`Sort [${e}] does not exist.`);
    const { debounce: i = 0, transform: m, ...S } = n;
    return {
      onClick: O(() => {
        var h;
        $(r, (h = v.value) == null ? void 0 : h.direction, S);
      }, i)
    };
  }
  function N(e = {}) {
    const { debounce: n = 700, transform: r, ...i } = e;
    return {
      "onUpdate:modelValue": O(
        (m) => {
          E(m, i);
        },
        n
      ),
      modelValue: t.value.term ?? ""
    };
  }
  function I(e, n = {}) {
    const r = M(e);
    if (!r) return console.warn(`Match [${e}] does not exist.`);
    const { debounce: i = 0, transform: m, ...S } = n;
    return {
      "onUpdate:modelValue": O((h) => {
        V(h, S);
      }, i),
      modelValue: U(r),
      value: r.name
    };
  }
  return Q({
    filters: w,
    sorts: s,
    searches: g,
    currentFilters: d,
    currentSort: v,
    currentSearches: y,
    isSortable: f,
    isSearchable: c,
    isMatchable: b,
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
    applyMatch: V,
    clearFilter: k,
    clearSort: C,
    clearSearch: J,
    clearMatch: K,
    reset: L,
    bindFilter: D,
    bindSort: G,
    bindSearch: N,
    bindMatch: I,
    stringValue: R,
    omitValue: x,
    toggleValue: W,
    delimitArray: j
  });
}
export {
  ne as useRefine
};
