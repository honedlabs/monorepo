import { toValue as I, computed as f } from "vue";
import { router as p } from "@inertiajs/vue3";
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const q = () => {
};
function Q(a, u) {
  function i(...r) {
    return new Promise((l, c) => {
      Promise.resolve(a(() => u.apply(this, r), { fn: u, thisArg: this, args: r })).then(l).catch(c);
    });
  }
  return i;
}
function X(a, u = {}) {
  let i, r, l = q;
  const c = (s) => {
    clearTimeout(s), l(), l = q;
  };
  let h;
  return (s) => {
    const g = I(a), d = I(u.maxWait);
    return i && c(i), g <= 0 || d !== void 0 && d <= 0 ? (r && (c(r), r = null), Promise.resolve(s())) : new Promise((v, b) => {
      l = u.rejectOnCancel ? b : v, h = s, d && !r && (r = setTimeout(() => {
        i && c(i), r = null, v(h());
      }, d)), i = setTimeout(() => {
        r && c(r), r = null, v(s());
      }, g);
    });
  };
}
function F(a, u = 200, i = {}) {
  return Q(
    X(u, i),
    a
  );
}
function ee(a, u, i = {}) {
  if (!(a != null && a[u]))
    throw new Error("The refine must be provided with valid props and key.");
  const r = f(() => a[u]), l = f(() => !!r.value._sort_key), c = f(() => !!r.value._search_key), h = f(() => !!r.value._match_key), w = f(
    () => {
      var e;
      return (e = r.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t, o = {}) => k(n, t, o),
        clear: (t = {}) => W(n, t),
        bind: () => C(n.name)
      }));
    }
  ), s = f(
    () => {
      var e;
      return (e = r.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => A(n, n.direction, t),
        clear: (t = {}) => U(t),
        bind: () => D(n)
      }));
    }
  ), g = f(
    () => {
      var e;
      return (e = r.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => x(n, t),
        clear: (t = {}) => x(n, t),
        bind: () => G(n)
      }));
    }
  ), d = f(
    () => w.value.filter(({ active: e }) => e)
  ), v = f(
    () => s.value.find(({ active: e }) => e)
  ), b = f(
    () => g.value.filter(({ active: e }) => e)
  );
  function R(e) {
    return Array.isArray(e) ? e.join(r.value._delimiter) : e;
  }
  function V(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function S(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function $(e) {
    return [R, V, S].reduce(
      (n, t) => t(n),
      e
    );
  }
  function E(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((t) => t !== e) : [...n, e];
  }
  function O(e) {
    return typeof e != "string" ? e : w.value.find(({ name: n }) => n === e);
  }
  function j(e, n = null) {
    return typeof e != "string" ? e : s.value.find(
      ({ name: t, direction: o }) => t === e && o === n
    );
  }
  function T(e) {
    return typeof e != "string" ? e : g.value.find(({ name: n }) => n === e);
  }
  function z(e) {
    return e ? typeof e == "string" ? d.value.some((n) => n.name === e) : e.active : !!d.value.length;
  }
  function B(e) {
    var n;
    return e ? typeof e == "string" ? ((n = v.value) == null ? void 0 : n.name) === e : e.active : !!v.value;
  }
  function P(e) {
    var n;
    return e ? typeof e == "string" ? (n = b.value) == null ? void 0 : n.some((t) => t.name === e) : e.active : !!r.value.term;
  }
  function H(e, n = {}) {
    const t = Object.fromEntries(
      Object.entries(e).map(([o, m]) => [o, $(m)])
    );
    p.reload({
      ...i,
      ...n,
      data: t
    });
  }
  function k(e, n, t = {}) {
    const o = O(e);
    if (!o) return console.warn(`Filter [${e}] does not exist.`);
    p.reload({
      ...i,
      ...t,
      data: {
        [o.name]: $(n)
      }
    });
  }
  function A(e, n = null, t = {}) {
    if (!l.value)
      return console.warn("Refine cannot perform sorting.");
    const o = j(e, n);
    if (!o) return console.warn(`Sort [${e}] does not exist.`);
    p.reload({
      ...i,
      ...t,
      data: {
        [r.value._sort_key]: S(o.next)
      }
    });
  }
  function M(e, n = {}) {
    if (!c.value)
      return console.warn("Refine cannot perform searching.");
    e = [V, S].reduce(
      (t, o) => o(t),
      e
    ), p.reload({
      ...i,
      ...n,
      data: {
        [r.value._search_key]: e
      }
    });
  }
  function x(e, n = {}) {
    if (!h.value || !c.value)
      return console.warn("Refine cannot perform matching.");
    const t = T(e);
    if (!t) return console.warn(`Match [${e}] does not exist.`);
    const o = E(
      t.name,
      b.value.map(({ name: m }) => m)
    );
    p.reload({
      ...i,
      ...n,
      data: {
        [r.value._match_key]: R(o)
      }
    });
  }
  function W(e, n = {}) {
    if (e) return k(e, null, n);
    p.reload({
      ...i,
      ...n,
      data: Object.fromEntries(
        d.value.map(({ name: t }) => [t, null])
      )
    });
  }
  function U(e = {}) {
    if (!l.value)
      return console.warn("Refine cannot perform sorting.");
    p.reload({
      ...i,
      ...e,
      data: {
        [r.value._sort_key]: null
      }
    });
  }
  function J(e = {}) {
    M(null, e);
  }
  function K(e = {}) {
    if (!h.value)
      return console.warn("Refine cannot perform matching.");
    p.reload({
      ...i,
      ...e,
      data: {
        [r.value._match_key]: null
      }
    });
  }
  function L(e = {}) {
    var n;
    p.reload({
      ...i,
      ...e,
      data: {
        [r.value._search_key ?? ""]: void 0,
        [r.value._sort_key ?? ""]: void 0,
        [r.value._match_key ?? ""]: void 0,
        ...Object.fromEntries(
          ((n = r.value.filters) == null ? void 0 : n.map((t) => [
            t.name,
            void 0
          ])) ?? []
        )
      }
    });
  }
  function C(e, n = {}) {
    const t = O(e);
    if (!t) return console.warn(`Filter [${e}] does not exist.`);
    const {
      debounce: o = 150,
      transform: m = (y) => y,
      ..._
    } = n;
    return {
      "onUpdate:modelValue": F((y) => {
        k(t, m(y), _);
      }, o),
      modelValue: t.value
    };
  }
  function D(e, n = {}) {
    if (!l.value)
      return console.warn("Refine cannot perform sorting.");
    const t = j(e);
    if (!t) return console.warn(`Sort [${e}] does not exist.`);
    const { debounce: o = 0, transform: m, ..._ } = n;
    return {
      onClick: F(() => {
        var y;
        A(t, (y = v.value) == null ? void 0 : y.direction, _);
      }, o)
    };
  }
  function N(e = {}) {
    if (!c.value)
      return console.warn("Refine cannot perform searching.");
    const { debounce: n = 700, transform: t, ...o } = e;
    return {
      "onUpdate:modelValue": F(
        (m) => {
          M(m, o);
        },
        n
      ),
      modelValue: r.value.term ?? ""
    };
  }
  function G(e, n = {}) {
    if (!h.value)
      return console.warn("Refine cannot perform matching.");
    const t = T(e);
    if (!t) return console.warn(`Match [${e}] does not exist.`);
    const { debounce: o = 0, transform: m, ..._ } = n;
    return {
      "onUpdate:modelValue": F((y) => {
        x(y, _);
      }, o),
      modelValue: P(t),
      value: t.name
    };
  }
  return {
    filters: w,
    sorts: s,
    searches: g,
    currentFilters: d,
    currentSort: v,
    currentSearches: b,
    isSortable: l,
    isSearchable: c,
    isMatchable: h,
    isFiltering: z,
    isSorting: B,
    isSearching: P,
    getFilter: O,
    getSort: j,
    getSearch: T,
    apply: H,
    applyFilter: k,
    applySort: A,
    applySearch: M,
    applyMatch: x,
    clearFilter: W,
    clearSort: U,
    clearSearch: J,
    clearMatch: K,
    reset: L,
    bindFilter: C,
    bindSort: D,
    bindSearch: N,
    bindMatch: G,
    stringValue: V,
    omitValue: S,
    toggleValue: E,
    delimitArray: R
  };
}
function ne(a, u) {
  return a ? typeof a == "object" ? (a == null ? void 0 : a.type) === u : a === u : !1;
}
export {
  ne as is,
  ee as useRefine
};
