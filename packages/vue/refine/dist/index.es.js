import { toValue as I, computed as g } from "vue";
import { router as f } from "@inertiajs/vue3";
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const O = () => {
};
function L(d, u) {
  function o(...r) {
    return new Promise((m, s) => {
      Promise.resolve(d(() => u.apply(this, r), { fn: u, thisArg: this, args: r })).then(m).catch(s);
    });
  }
  return o;
}
function N(d, u = {}) {
  let o, r, m = O;
  const s = (c) => {
    clearTimeout(c), m(), m = O;
  };
  let S;
  return (c) => {
    const y = I(d), l = I(u.maxWait);
    return o && s(o), y <= 0 || l !== void 0 && l <= 0 ? (r && (s(r), r = null), Promise.resolve(c())) : new Promise((p, h) => {
      m = u.rejectOnCancel ? h : p, S = c, l && !r && (r = setTimeout(() => {
        o && s(o), r = null, p(S());
      }, l)), o = setTimeout(() => {
        r && s(r), r = null, p(c());
      }, y);
    });
  };
}
function V(d, u = 200, o = {}) {
  return L(
    N(u, o),
    d
  );
}
function Y(d, u, o = {}) {
  const r = g(() => d[u]), m = g(
    () => {
      var e;
      return ((e = r.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t, i = {}) => x(n, t, i),
        clear: (t = {}) => C(n, t),
        bind: () => E(n.name)
      }))) ?? [];
    }
  ), s = g(
    () => {
      var e;
      return ((e = r.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => $(n, n.direction, t),
        clear: (t = {}) => D(t),
        bind: () => G(n)
      }))) ?? [];
    }
  ), S = g(
    () => {
      var e;
      return (e = r.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => F(n, t),
        clear: (t = {}) => F(n, t),
        bind: () => R(n)
      }));
    }
  ), w = g(
    () => {
      var e;
      return ((e = r.value.filters) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
    }
  ), c = g(
    () => {
      var e;
      return (e = r.value.sorts) == null ? void 0 : e.find(({ active: n }) => n);
    }
  ), y = g(
    () => {
      var e;
      return ((e = r.value.searches) == null ? void 0 : e.filter(({ active: n }) => n)) ?? [];
    }
  );
  function l(e) {
    return Array.isArray(e) ? e.join(r.value.config.delimiter) : e;
  }
  function p(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function h(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function W(e) {
    return [l, p, h].reduce(
      (n, t) => t(n),
      e
    );
  }
  function M(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((t) => t !== e) : [...n, e];
  }
  function j(e) {
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
  function _(e) {
    return e ? typeof e == "string" ? w.value.some((n) => n.name === e) : e.active : !!w.value.length;
  }
  function q(e) {
    var n;
    return e ? typeof e == "string" ? ((n = c.value) == null ? void 0 : n.name) === e : e.active : !!c.value;
  }
  function U(e) {
    var n;
    return e ? typeof e == "string" ? (n = y.value) == null ? void 0 : n.some((t) => t.name === e) : e.active : !!r.value.config.search;
  }
  function z(e, n = {}) {
    const t = Object.fromEntries(
      Object.entries(e).map(([i, a]) => [i, W(a)])
    );
    f.reload({
      ...o,
      ...n,
      data: t
    });
  }
  function x(e, n, t = {}) {
    const i = typeof e == "string" ? j(e) : e;
    if (!i) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    "multiple" in i && i.multiple && n !== void 0 && (n = M(n, i.value)), f.reload({
      ...o,
      ...t,
      data: {
        [i.name]: W(n)
      }
    });
  }
  function $(e, n = null, t = {}) {
    const i = typeof e == "string" ? A(e, n) : e;
    if (!i) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    f.reload({
      ...o,
      ...t,
      data: {
        [r.value.config.sorts]: h(i.next)
      }
    });
  }
  function k(e, n = {}) {
    e = [p, h].reduce(
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
  function F(e, n = {}) {
    if (!r.value.config.matches) {
      console.warn("Matches key is not set.");
      return;
    }
    const t = typeof e == "string" ? T(e) : e;
    if (!t) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const i = M(
      t.name,
      y.value.map(({ name: a }) => a)
    );
    f.reload({
      ...o,
      ...n,
      data: {
        [r.value.config.matches]: l(i)
      }
    });
  }
  function C(e, n = {}) {
    x(e, void 0, n);
  }
  function D(e = {}) {
    f.reload({
      ...o,
      ...e,
      data: {
        [r.value.config.sorts]: void 0
      }
    });
  }
  function B(e = {}) {
    k(void 0, e);
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
        [r.value.config.matches]: void 0,
        ...Object.fromEntries(
          ((n = r.value.filters) == null ? void 0 : n.map((t) => [
            t.name,
            void 0
          ])) ?? []
        )
      }
    });
  }
  function E(e, n = {}) {
    const t = typeof e == "string" ? j(e) : e;
    if (!t) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    const i = t.value, {
      debounce: a = 250,
      transform: b = (P) => P,
      ...v
    } = n;
    return {
      "onUpdate:modelValue": V((P) => {
        x(t, b(P), v);
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
      onClick: V(() => {
        var v;
        $(t, (v = c.value) == null ? void 0 : v.direction, b);
      }, i)
    };
  }
  function K(e = {}) {
    const { debounce: n = 700, transform: t, ...i } = e;
    return {
      "onUpdate:modelValue": V(
        (a) => {
          k(a, i);
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
      "onUpdate:modelValue": V((v) => {
        F(v, b);
      }, i),
      modelValue: U(t),
      value: t.name
    };
  }
  return {
    filters: m,
    sorts: s,
    searches: S,
    getFilter: j,
    getSort: A,
    getSearch: T,
    currentFilters: w,
    currentSort: c,
    currentSearches: y,
    isFiltering: _,
    isSorting: q,
    isSearching: U,
    apply: z,
    applyFilter: x,
    applySort: $,
    applySearch: k,
    applyMatch: F,
    clearFilter: C,
    clearSort: D,
    clearSearch: B,
    clearMatch: H,
    reset: J,
    bindFilter: E,
    bindSort: G,
    bindSearch: K,
    bindMatch: R,
    stringValue: p,
    omitValue: h,
    toggleValue: M,
    delimitArray: l
  };
}
export {
  Y as useRefine
};
