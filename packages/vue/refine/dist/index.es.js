import { toValue as G, computed as W } from "vue";
import { router as y } from "@inertiajs/vue3";
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const R = () => {
};
function z(l, c) {
  function o(...r) {
    return new Promise((s, a) => {
      Promise.resolve(l(() => c.apply(this, r), { fn: c, thisArg: this, args: r })).then(s).catch(a);
    });
  }
  return o;
}
function B(l, c = {}) {
  let o, r, s = R;
  const a = (u) => {
    clearTimeout(u), s(), s = R;
  };
  let p;
  return (u) => {
    const g = G(l), f = G(c.maxWait);
    return o && a(o), g <= 0 || f !== void 0 && f <= 0 ? (r && (a(r), r = null), Promise.resolve(u())) : new Promise((d, V) => {
      s = c.rejectOnCancel ? V : d, p = u, f && !r && (r = setTimeout(() => {
        o && a(o), r = null, d(p());
      }, f)), o = setTimeout(() => {
        r && a(r), r = null, d(u());
      }, g);
    });
  };
}
function $(l, c = 200, o = {}) {
  return z(
    B(c, o),
    l
  );
}
function K(l, c, o = {}) {
  const r = W(() => l[c]), s = W(
    () => r.value.filters.map((e) => ({
      ...e,
      apply: (n, t = {}) => F(e, n, t),
      clear: (n = {}) => v(e, n),
      bind: () => C(e.name)
    }))
  ), a = W(
    () => r.value.sorts.map((e) => ({
      ...e,
      apply: (n = {}) => T(e, e.direction, n),
      clear: (n = {}) => k(n),
      bind: () => D(e)
    }))
  );
  function p(e) {
    return Array.isArray(e) ? e.join(r.value.config.delimiter) : e;
  }
  function S(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function u(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function g(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((t) => t !== e) : [...n, e];
  }
  function f(e, n = null) {
    return r.value.sorts.find(
      (t) => t.name === e && t.direction === n
    );
  }
  function d(e) {
    return r.value.filters.find((n) => n.name === e);
  }
  function V(e) {
    var n;
    return (n = r.value.searches) == null ? void 0 : n.find((t) => t.name === e);
  }
  function b() {
    return r.value.sorts.find(({ active: e }) => e);
  }
  function w() {
    return r.value.filters.filter(({ active: e }) => e);
  }
  function A() {
    var e;
    return ((e = r.value.searches) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
  }
  function U(e) {
    var n;
    return e ? ((n = b()) == null ? void 0 : n.name) === e : !!b();
  }
  function E(e) {
    return e ? w().some((n) => n.name === e) : !!w().length;
  }
  function I(e) {
    var n, t;
    return e ? (n = A()) == null ? void 0 : n.some((i) => i.name === e) : !!((t = A()) != null && t.length);
  }
  function F(e, n, t = {}) {
    const i = typeof e == "string" ? d(e) : e;
    if (!i) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    "multiple" in i && i.multiple && (n = g(n, i.value)), n = [p, S, u].reduce(
      (m, h) => h(m),
      n
    ), console.log(n), y.reload({
      ...o,
      ...t,
      data: {
        [i.name]: n
      }
    });
  }
  function T(e, n = null, t = {}) {
    const i = typeof e == "string" ? f(e, n) : e;
    if (!i) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    y.reload({
      ...o,
      ...t,
      data: {
        [r.value.config.sorts]: u(i.next)
      }
    });
  }
  function j(e, n = {}) {
    e = [S, u].reduce(
      (t, i) => i(t),
      e
    ), y.reload({
      ...o,
      ...n,
      data: {
        [r.value.config.searches]: e
      }
    });
  }
  function v(e, n = {}) {
    F(e, void 0, n);
  }
  function k(e = {}) {
    y.reload({
      ...o,
      ...e,
      data: {
        [r.value.config.sorts]: null
      }
    });
  }
  function O(e = {}) {
    j(void 0, e);
  }
  function _(e = {}) {
    y.reload({
      ...o,
      ...e,
      data: {
        [r.value.config.searches]: void 0,
        [r.value.config.sorts]: void 0,
        ...Object.fromEntries(
          r.value.filters.map((n) => [n.name, void 0])
        ),
        ...r.value.config.matches ? { [r.value.config.matches]: void 0 } : {}
      }
    });
  }
  function C(e, n = {}) {
    const t = typeof e == "string" ? d(e) : e;
    if (!t) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    const i = t.value, {
      debounce: m = 250,
      transform: h = (P) => P,
      ...x
    } = n;
    return {
      "onUpdate:modelValue": $((P) => {
        F(t, h(P), x);
      }, m),
      modelValue: i,
      value: i
    };
  }
  function D(e, n = {}) {
    const t = typeof e == "string" ? f(e) : e;
    if (!t) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    const { debounce: i = 0, transform: m, ...h } = n;
    return {
      onClick: $(() => {
        var x;
        T(t, (x = b()) == null ? void 0 : x.direction, h);
      }, i)
    };
  }
  function q(e = {}) {
    const { debounce: n = 700, transform: t, ...i } = e;
    return {
      "onUpdate:modelValue": $((m) => {
        j(m, i);
      }, n),
      modelValue: r.value.config.search ?? ""
    };
  }
  return {
    // refinements,
    filters: s,
    sorts: a,
    // searches,
    getSort: f,
    getFilter: d,
    getSearch: V,
    currentSort: b,
    currentFilters: w,
    currentSearches: A,
    isSorting: U,
    isFiltering: E,
    isSearching: I,
    applyFilter: F,
    applySort: T,
    applySearch: j,
    clearFilter: v,
    clearSort: k,
    clearSearch: O,
    reset: _,
    bindFilter: C,
    bindSort: D,
    // bindMatch,
    bindSearch: q,
    /** Provide the helpers */
    stringValue: S,
    omitValue: u,
    toggleValue: g,
    delimitArray: p
  };
}
export {
  K as useRefine
};
