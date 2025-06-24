import { toValue as q, computed as c } from "vue";
import { router as f } from "@inertiajs/vue3";
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const z = () => {
};
function X(v, l) {
  function i(...t) {
    return new Promise((s, u) => {
      Promise.resolve(v(() => l.apply(this, t), { fn: l, thisArg: this, args: t })).then(s).catch(u);
    });
  }
  return i;
}
function Y(v, l = {}) {
  let i, t, s = z;
  const u = (h) => {
    clearTimeout(h), s(), s = z;
  };
  let g;
  return (h) => {
    const S = q(v), d = q(l.maxWait);
    return i && u(i), S <= 0 || d !== void 0 && d <= 0 ? (t && (u(t), t = null), Promise.resolve(h())) : new Promise((m, b) => {
      s = l.rejectOnCancel ? b : m, g = h, d && !t && (t = setTimeout(() => {
        i && u(i), t = null, m(g());
      }, d)), i = setTimeout(() => {
        t && u(t), t = null, m(h());
      }, S);
    });
  };
}
function V(v, l = 200, i = {}) {
  return X(
    Y(l, i),
    v
  );
}
function ne(v, l, i = {}) {
  const t = c(() => v[l]), s = c(() => !!t.value.sort), u = c(() => !!t.value.search), g = c(() => !!t.value.match), W = c(
    () => {
      var e;
      return (e = t.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r, o = {}) => x(n, r, o),
        clear: (r = {}) => C(n, r),
        bind: () => G(n.name)
      }));
    }
  ), h = c(
    () => {
      var e;
      return (e = t.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => $(n, n.direction, r),
        clear: (r = {}) => D(r),
        bind: () => I(n)
      }));
    }
  ), S = c(
    () => {
      var e;
      return (e = t.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (r = {}) => F(n, r),
        clear: (r = {}) => F(n, r),
        bind: () => _(n)
      }));
    }
  );
  function d(e) {
    return e.filter(({ active: n }) => n);
  }
  const m = c(
    () => d(t.value.filters)
  ), b = c(
    () => {
      var e;
      return (e = d(t.value.sorts)) == null ? void 0 : e[0];
    }
  ), O = c(
    () => d(t.value.searches)
  );
  function j(e) {
    return Array.isArray(e) ? e.join(t.value.delimiter) : e;
  }
  function R(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function w(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function E(e) {
    return [j, R, w].reduce(
      (n, r) => r(n),
      e
    );
  }
  function U(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((r) => r !== e) : [...n, e];
  }
  function A(e) {
    var n;
    return typeof e != "string" ? e : (n = t.value.filters) == null ? void 0 : n.find(({ name: r }) => r === e);
  }
  function M(e, n = null) {
    var r;
    return typeof e != "string" ? e : (r = t.value.sorts) == null ? void 0 : r.find(
      ({ name: o, direction: a }) => o === e && a === n
    );
  }
  function T(e) {
    var n;
    return typeof e != "string" ? e : (n = t.value.searches) == null ? void 0 : n.find(({ name: r }) => r === e);
  }
  function B(e) {
    return e ? typeof e == "string" ? m.value.some((n) => n.name === e) : e.active : !!m.value.length;
  }
  function H(e) {
    var n;
    return e ? typeof e == "string" ? ((n = b.value) == null ? void 0 : n.name) === e : e.active : !!b.value;
  }
  function k(e) {
    var n;
    return e ? typeof e == "string" ? (n = O.value) == null ? void 0 : n.some((r) => r.name === e) : e.active : !!t.value.term;
  }
  function J(e, n = {}) {
    const r = Object.fromEntries(
      Object.entries(e).map(([o, a]) => [o, E(a)])
    );
    f.reload({
      ...i,
      ...n,
      data: r
    });
  }
  function x(e, n, r = {}) {
    const o = A(e);
    if (!o) return console.warn(`Filter [${e}] does not exist.`);
    f.reload({
      ...i,
      ...r,
      data: {
        [o.name]: E(n)
      }
    });
  }
  function $(e, n = null, r = {}) {
    const o = M(e, n);
    if (!o) return console.warn(`Sort [${e}] does not exist.`);
    if (!s.value)
      return console.warn("Refine cannot perform sorting.");
    f.reload({
      ...i,
      ...r,
      data: {
        [t.value.sort]: w(o.next)
      }
    });
  }
  function P(e, n = {}) {
    if (e = [R, w].reduce(
      (r, o) => o(r),
      e
    ), !u.value)
      return console.warn("Refine cannot perform searching.");
    f.reload({
      ...i,
      ...n,
      data: {
        [t.value.search]: e
      }
    });
  }
  function F(e, n = {}) {
    const r = T(e);
    if (!r) return console.warn(`Match [${e}] does not exist.`);
    if (!g.value || !u.value)
      return console.warn("Refine cannot perform matching.");
    const o = U(
      r.name,
      O.value.map(({ name: a }) => a)
    );
    f.reload({
      ...i,
      ...n,
      data: {
        [t.value.match]: j(o)
      }
    });
  }
  function C(e, n = {}) {
    if (e) return x(e, null, n);
    f.reload({
      ...i,
      ...n,
      data: Object.fromEntries(
        m.value.map(({ name: r }) => [r, null])
      )
    });
  }
  function D(e = {}) {
    if (!s.value)
      return console.warn("Refine cannot perform sorting.");
    f.reload({
      ...i,
      ...e,
      data: {
        [t.value.sort]: null
      }
    });
  }
  function K(e = {}) {
    P(null, e);
  }
  function L(e = {}) {
    if (!g.value)
      return console.warn("Refine cannot perform matching.");
    f.reload({
      ...i,
      ...e,
      data: {
        [t.value.match]: null
      }
    });
  }
  function N(e = {}) {
    var n;
    f.reload({
      ...i,
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
  function G(e, n = {}) {
    const r = A(e);
    if (!r) return console.warn(`Filter [${e}] does not exist.`);
    const {
      debounce: o = 250,
      transform: a = (p) => p,
      ...y
    } = n;
    return {
      "onUpdate:modelValue": V((p) => {
        x(r, a(p), y);
      }, o),
      modelValue: r.value
    };
  }
  function I(e, n = {}) {
    const r = M(e);
    if (!r) return console.warn(`Sort [${e}] does not exist.`);
    const { debounce: o = 0, transform: a, ...y } = n;
    return {
      onClick: V(() => {
        var p;
        $(r, (p = b.value) == null ? void 0 : p.direction, y);
      }, o)
    };
  }
  function Q(e = {}) {
    const { debounce: n = 700, transform: r, ...o } = e;
    return {
      "onUpdate:modelValue": V(
        (a) => {
          P(a, o);
        },
        n
      ),
      modelValue: t.value.term ?? ""
    };
  }
  function _(e, n = {}) {
    const r = T(e);
    if (!r) return console.warn(`Match [${e}] does not exist.`);
    const { debounce: o = 0, transform: a, ...y } = n;
    return {
      "onUpdate:modelValue": V((p) => {
        F(p, y);
      }, o),
      modelValue: k(r),
      value: r.name
    };
  }
  return {
    filters: W,
    sorts: h,
    searches: S,
    currentFilters: m,
    currentSort: b,
    currentSearches: O,
    isSortable: s,
    isSearchable: u,
    isMatchable: g,
    isFiltering: B,
    isSorting: H,
    isSearching: k,
    getFilter: A,
    getSort: M,
    getSearch: T,
    apply: J,
    applyFilter: x,
    applySort: $,
    applySearch: P,
    applyMatch: F,
    clearFilter: C,
    clearSort: D,
    clearSearch: K,
    clearMatch: L,
    reset: N,
    bindFilter: G,
    bindSort: I,
    bindSearch: Q,
    bindMatch: _,
    stringValue: R,
    omitValue: w,
    toggleValue: U,
    delimitArray: j
  };
}
export {
  ne as useRefine
};
