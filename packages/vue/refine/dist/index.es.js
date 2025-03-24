import { toValue as I, computed as g } from "vue";
import { router as s } from "@inertiajs/vue3";
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const O = () => {
};
function L(d, u) {
  function o(...r) {
    return new Promise((m, l) => {
      Promise.resolve(d(() => u.apply(this, r), { fn: u, thisArg: this, args: r })).then(m).catch(l);
    });
  }
  return o;
}
function N(d, u = {}) {
  let o, r, m = O;
  const l = (c) => {
    clearTimeout(c), m(), m = O;
  };
  let S;
  return (c) => {
    const y = I(d), f = I(u.maxWait);
    return o && l(o), y <= 0 || f !== void 0 && f <= 0 ? (r && (l(r), r = null), Promise.resolve(c())) : new Promise((p, v) => {
      m = u.rejectOnCancel ? v : p, S = c, f && !r && (r = setTimeout(() => {
        o && l(o), r = null, p(S());
      }, f)), o = setTimeout(() => {
        r && l(r), r = null, p(c());
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
        apply: (t, i = {}) => F(n, t, i),
        clear: (t = {}) => C(n, t),
        bind: () => E(n.name)
      }))) ?? [];
    }
  ), l = g(
    () => {
      var e;
      return ((e = r.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => T(n, n.direction, t),
        clear: (t = {}) => D(t),
        bind: () => G(n)
      }))) ?? [];
    }
  ), S = g(
    () => {
      var e;
      return (e = r.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => w(n, t),
        clear: (t = {}) => w(n, t),
        bind: () => R(n)
      }));
    }
  ), x = g(
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
  function f(e) {
    return Array.isArray(e) ? e.join(r.value.config.delimiter) : e;
  }
  function p(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function v(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function W(e) {
    return [f, p, v].reduce(
      (n, t) => t(n),
      e
    );
  }
  function k(e, n) {
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
  function M(e) {
    var n;
    return (n = r.value.searches) == null ? void 0 : n.find((t) => t.name === e);
  }
  function _(e) {
    return e ? typeof e == "string" ? x.value.some((n) => n.name === e) : e.active : !!x.value.length;
  }
  function q(e) {
    var n;
    return e ? typeof e == "string" ? ((n = c.value) == null ? void 0 : n.name) === e : e.active : !!c.value;
  }
  function U(e) {
    var n;
    return e ? typeof e == "string" ? (n = y.value) == null ? void 0 : n.some((t) => t.name === e) : e.active : !!r.value.config.term;
  }
  function z(e, n = {}) {
    const t = Object.fromEntries(
      Object.entries(e).map(([i, a]) => [i, W(a)])
    );
    s.reload({
      ...o,
      ...n,
      data: t
    });
  }
  function F(e, n, t = {}) {
    const i = typeof e == "string" ? j(e) : e;
    if (!i) {
      console.warn(`Filter [${e}] does not exist.`);
      return;
    }
    s.reload({
      ...o,
      ...t,
      data: {
        [i.name]: W(n)
      }
    });
  }
  function T(e, n = null, t = {}) {
    const i = typeof e == "string" ? A(e, n) : e;
    if (!i) {
      console.warn(`Sort [${e}] does not exist.`);
      return;
    }
    s.reload({
      ...o,
      ...t,
      data: {
        [r.value.config.sort]: v(i.next)
      }
    });
  }
  function $(e, n = {}) {
    e = [p, v].reduce(
      (t, i) => i(t),
      e
    ), s.reload({
      ...o,
      ...n,
      data: {
        [r.value.config.search]: e
      }
    });
  }
  function w(e, n = {}) {
    const t = typeof e == "string" ? M(e) : e;
    if (!t) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const i = k(
      t.name,
      y.value.map(({ name: a }) => a)
    );
    s.reload({
      ...o,
      ...n,
      data: {
        [r.value.config.match]: f(i)
      }
    });
  }
  function C(e, n = {}) {
    F(e, void 0, n);
  }
  function D(e = {}) {
    s.reload({
      ...o,
      ...e,
      data: {
        [r.value.config.sort]: void 0
      }
    });
  }
  function B(e = {}) {
    $(void 0, e);
  }
  function H(e = {}) {
    if (!r.value.config.match) {
      console.warn("Matches key is not set.");
      return;
    }
    s.reload({
      ...o,
      ...e,
      data: {
        [r.value.config.match]: void 0
      }
    });
  }
  function J(e = {}) {
    var n;
    s.reload({
      ...o,
      ...e,
      data: {
        [r.value.config.search]: void 0,
        [r.value.config.sort]: void 0,
        [r.value.config.match]: void 0,
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
      ...h
    } = n;
    return {
      "onUpdate:modelValue": V((P) => {
        F(t, b(P), h);
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
        var h;
        T(t, (h = c.value) == null ? void 0 : h.direction, b);
      }, i)
    };
  }
  function K(e = {}) {
    const { debounce: n = 700, transform: t, ...i } = e;
    return {
      "onUpdate:modelValue": V(
        (a) => {
          $(a, i);
        },
        n
      ),
      modelValue: r.value.config.term ?? ""
    };
  }
  function R(e, n = {}) {
    const t = typeof e == "string" ? M(e) : e;
    if (!t) {
      console.warn(`Match [${e}] does not exist.`);
      return;
    }
    const { debounce: i = 0, transform: a, ...b } = n;
    return {
      "onUpdate:modelValue": V((h) => {
        w(h, b);
      }, i),
      modelValue: U(t),
      value: t.name
    };
  }
  return {
    filters: m,
    sorts: l,
    searches: S,
    getFilter: j,
    getSort: A,
    getSearch: M,
    currentFilters: x,
    currentSort: c,
    currentSearches: y,
    isFiltering: _,
    isSorting: q,
    isSearching: U,
    apply: z,
    applyFilter: F,
    applySort: T,
    applySearch: $,
    applyMatch: w,
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
    omitValue: v,
    toggleValue: k,
    delimitArray: f
  };
}
export {
  Y as useRefine
};
