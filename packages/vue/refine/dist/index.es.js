import { toValue as I, computed as M } from "vue";
import { router as f } from "@inertiajs/vue3";
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const O = () => {
};
function L(l, c) {
  function o(...r) {
    return new Promise((d, s) => {
      Promise.resolve(l(() => c.apply(this, r), { fn: c, thisArg: this, args: r })).then(d).catch(s);
    });
  }
  return o;
}
function N(l, c = {}) {
  let o, r, d = O;
  const s = (u) => {
    clearTimeout(u), d(), d = O;
  };
  let S;
  return (u) => {
    const m = I(l), p = I(c.maxWait);
    return o && s(o), m <= 0 || p !== void 0 && p <= 0 ? (r && (s(r), r = null), Promise.resolve(u())) : new Promise((g, h) => {
      d = c.rejectOnCancel ? h : g, S = u, p && !r && (r = setTimeout(() => {
        o && s(o), r = null, g(S());
      }, p)), o = setTimeout(() => {
        r && s(r), r = null, g(u());
      }, m);
    });
  };
}
function j(l, c = 200, o = {}) {
  return L(
    N(c, o),
    l
  );
}
function Y(l, c, o = {}) {
  const r = M(() => l[c]), d = M(
    () => {
      var e;
      return ((e = r.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t, i = {}) => F(n, t, i),
        clear: (t = {}) => C(n, t),
        bind: () => E(n.name)
      }))) ?? [];
    }
  ), s = M(
    () => {
      var e;
      return ((e = r.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => k(n, n.direction, t),
        clear: (t = {}) => D(t),
        bind: () => G(n)
      }))) ?? [];
    }
  ), S = M(
    () => {
      var e;
      return (e = r.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => V(n, t),
        clear: (t = {}) => V(n, t),
        bind: () => R(n)
      }));
    }
  );
  function v(e) {
    return Array.isArray(e) ? e.join(r.value.config.delimiter) : e;
  }
  function u(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function m(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function p(e) {
    return [v, u, m].reduce(
      (n, t) => t(n),
      e
    );
  }
  function g(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((t) => t !== e) : [...n, e];
  }
  function h(e) {
    var n;
    return (n = r.value.filters) == null ? void 0 : n.find((t) => t.name === e);
  }
  function A(e, n = null) {
    var t;
    return (t = r.value.sorts) == null ? void 0 : t.find(
      (i) => i.name === e && i.direction === n
    );
  }
  function T(e) {
    var n;
    return (n = r.value.searches) == null ? void 0 : n.find((t) => t.name === e);
  }
  function $() {
    var e;
    return ((e = r.value.filters) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
  }
  function w() {
    var e;
    return (e = r.value.sorts) == null ? void 0 : e.find(({ active: n }) => n);
  }
  function x() {
    var e;
    return ((e = r.value.searches) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
  }
  function _(e) {
    return e ? typeof e == "string" ? $().some((n) => n.name === e) : e.active : !!$().length;
  }
  function q(e) {
    var n;
    return e ? typeof e == "string" ? ((n = w()) == null ? void 0 : n.name) === e : e.active : !!w();
  }
  function U(e) {
    var n, t;
    return e ? typeof e == "string" ? (t = x()) == null ? void 0 : t.some((i) => i.name === e) : e.active : !!((n = x()) != null && n.length);
  }
  function z(e, n = {}) {
    const t = Object.fromEntries(
      Object.entries(e).map(([i, a]) => [i, p(a)])
    );
    f.reload({
      ...o,
      ...n,
      data: t
    });
  }
  function F(e, n, t = {}) {
    const i = typeof e == "string" ? h(e) : e;
    if (!i) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    "multiple" in i && i.multiple && n !== void 0 && (n = g(n, i.value)), f.reload({
      ...o,
      ...t,
      data: {
        [i.name]: p(n)
      }
    });
  }
  function k(e, n = null, t = {}) {
    const i = typeof e == "string" ? A(e, n) : e;
    if (!i) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    f.reload({
      ...o,
      ...t,
      data: {
        [r.value.config.sorts]: m(i.next)
      }
    });
  }
  function P(e, n = {}) {
    e = [u, m].reduce(
      (t, i) => i(t),
      e
    ), f.reload({
      ...o,
      ...n,
      data: {
        [r.value.config.searches]: e
      }
    });
  }
  function V(e, n = {}) {
    if (!r.value.config.matches) {
      console.warn("Matches key is not set.");
      return;
    }
    const t = typeof e == "string" ? T(e) : e;
    if (!t) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const i = g(
      t.name,
      x().map(({ name: a }) => a)
    );
    f.reload({
      ...o,
      ...n,
      data: {
        [r.value.config.matches]: v(i)
      }
    });
  }
  function C(e, n = {}) {
    F(e, void 0, n);
  }
  function D(e = {}) {
    f.reload({
      ...o,
      ...e,
      data: {
        [r.value.config.sorts]: null
      }
    });
  }
  function B(e = {}) {
    P(void 0, e);
  }
  function H(e = {}) {
    if (!r.value.config.matches) {
      console.warn("Matches key is not set.");
      return;
    }
    f.reload({
      ...o,
      ...e,
      data: {
        [r.value.config.matches]: void 0
      }
    });
  }
  function J(e = {}) {
    var n;
    f.reload({
      ...o,
      ...e,
      data: {
        [r.value.config.searches]: void 0,
        [r.value.config.sorts]: void 0,
        ...Object.fromEntries(
          ((n = r.value.filters) == null ? void 0 : n.map((t) => [
            t.name,
            void 0
          ])) ?? []
        ),
        ...r.value.config.matches ? { [r.value.config.matches]: void 0 } : {}
      }
    });
  }
  function E(e, n = {}) {
    const t = typeof e == "string" ? h(e) : e;
    if (!t) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    const i = t.value, {
      debounce: a = 250,
      transform: b = (W) => W,
      ...y
    } = n;
    return {
      "onUpdate:modelValue": j((W) => {
        F(t, b(W), y);
      }, a),
      modelValue: i
    };
  }
  function G(e, n = {}) {
    const t = typeof e == "string" ? A(e) : e;
    if (!t) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    const { debounce: i = 0, transform: a, ...b } = n;
    return {
      onClick: j(() => {
        var y;
        k(t, (y = w()) == null ? void 0 : y.direction, b);
      }, i)
    };
  }
  function K(e = {}) {
    const { debounce: n = 700, transform: t, ...i } = e;
    return {
      "onUpdate:modelValue": j(
        (a) => {
          P(a, i);
        },
        n
      ),
      modelValue: r.value.config.search ?? ""
    };
  }
  function R(e, n = {}) {
    const t = typeof e == "string" ? T(e) : e;
    if (!t) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const { debounce: i = 0, transform: a, ...b } = n;
    return {
      "onUpdate:modelValue": j((y) => {
        V(y, b);
      }, i),
      modelValue: U(t),
      value: t.name
    };
  }
  return {
    filters: d,
    sorts: s,
    searches: S,
    getFilter: h,
    getSort: A,
    getSearch: T,
    currentFilters: $,
    currentSort: w,
    currentSearches: x,
    isFiltering: _,
    isSorting: q,
    isSearching: U,
    apply: z,
    applyFilter: F,
    applySort: k,
    applySearch: P,
    applyMatch: V,
    clearFilter: C,
    clearSort: D,
    clearSearch: B,
    clearMatch: H,
    reset: J,
    bindFilter: E,
    bindSort: G,
    bindSearch: K,
    bindMatch: R,
    stringValue: u,
    omitValue: m,
    toggleValue: g,
    delimitArray: v
  };
}
export {
  Y as useRefine
};
