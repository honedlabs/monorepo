import { toValue as z, computed as f } from "vue";
import { router as v } from "@inertiajs/vue3";
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const B = () => {
};
function Y(u, l) {
  function o(...c) {
    return new Promise((i, d) => {
      Promise.resolve(u(() => l.apply(this, c), { fn: l, thisArg: this, args: c })).then(i).catch(d);
    });
  }
  return o;
}
function Z(u, l = {}) {
  let o, c, i = B;
  const d = (m) => {
    clearTimeout(m), i(), i = B;
  };
  let h;
  return (m) => {
    const b = z(u), y = z(l.maxWait);
    return o && d(o), b <= 0 || y !== void 0 && y <= 0 ? (c && (d(c), c = null), Promise.resolve(m())) : new Promise((g, _) => {
      i = l.rejectOnCancel ? _ : g, h = m, y && !c && (c = setTimeout(() => {
        o && d(o), c = null, g(h());
      }, y)), o = setTimeout(() => {
        c && d(c), c = null, g(m());
      }, b);
    });
  };
}
function F(u, l = 200, o = {}) {
  return Y(
    Z(l, o),
    u
  );
}
function te(u, l, o = {}, c = {}) {
  if (!(u != null && u[l]))
    throw new Error("The refine must be provided with valid props and key.");
  const i = f(() => u[l]), d = f(() => i.value.term), h = f(() => !!i.value._sort_key), w = f(() => !!i.value._search_key), m = f(() => !!i.value._match_key), b = f(
    () => {
      var e;
      return (e = i.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t, r = {}) => k(n, t, r),
        clear: (t = {}) => C(n, t),
        bind: () => G(n.name)
      }));
    }
  ), y = f(
    () => {
      var e;
      return (e = i.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => $(n, n.direction, t),
        clear: (t = {}) => D(t),
        bind: () => I(n)
      }));
    }
  ), g = f(
    () => {
      var e;
      return (e = i.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => x(n, t),
        clear: (t = {}) => x(n, t),
        bind: () => q(n)
      }));
    }
  ), _ = f(
    () => b.value.filter(({ active: e }) => e)
  ), S = f(
    () => y.value.find(({ active: e }) => e)
  ), R = f(
    () => g.value.filter(({ active: e }) => e)
  );
  function V(e) {
    return Array.isArray(e) ? e.join(i.value._delimiter) : e;
  }
  function j(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function O(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function P(e) {
    return [V, j, O].reduce(
      (n, t) => t(n),
      e
    );
  }
  function W(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((t) => t !== e) : [...n, e];
  }
  function T(e) {
    return typeof e != "string" ? e : b.value.find(({ name: n }) => n === e);
  }
  function A(e, n = null) {
    return typeof e != "string" ? e : y.value.find(
      ({ name: t, direction: r }) => t === e && r === n
    );
  }
  function M(e) {
    return typeof e != "string" ? e : g.value.find(({ name: n }) => n === e);
  }
  function H(e) {
    return e ? typeof e == "string" ? _.value.some((n) => n.name === e) : e.active : !!_.value.length;
  }
  function J(e) {
    var n;
    return e ? typeof e == "string" ? ((n = S.value) == null ? void 0 : n.name) === e : e.active : !!S.value;
  }
  function U(e) {
    var n;
    return e ? typeof e == "string" ? (n = R.value) == null ? void 0 : n.some((t) => t.name === e) : e.active : !!d.value;
  }
  function K(e, n = {}) {
    const t = Object.fromEntries(
      Object.entries(e).map(([r, a]) => [r, P(a)])
    );
    v.reload({
      ...o,
      ...n,
      data: t
    });
  }
  function k(e, n, t = {}) {
    const r = T(e);
    if (!r) return console.warn(`Filter [${e}] does not exist.`);
    const { parameters: a, ...s } = t;
    v.reload({
      ...o,
      ...s,
      data: {
        [r.name]: P(n),
        ...a,
        ...c
      }
    });
  }
  function $(e, n = null, t = {}) {
    if (!h.value)
      return console.warn("Refine cannot perform sorting.");
    const r = A(e, n);
    if (!r) return console.warn(`Sort [${e}] does not exist.`);
    const { parameters: a, ...s } = t;
    v.reload({
      ...o,
      ...s,
      data: {
        [i.value._sort_key]: O(r.next),
        ...a
      }
    });
  }
  function E(e, n = {}) {
    if (!w.value)
      return console.warn("Refine cannot perform searching.");
    e = [j, O].reduce(
      (a, s) => s(a),
      e
    );
    const { parameters: t, ...r } = n;
    v.reload({
      ...o,
      ...r,
      data: {
        [i.value._search_key]: e,
        ...t,
        ...c
      }
    });
  }
  function x(e, n = {}) {
    if (!m.value || !w.value)
      return console.warn("Refine cannot perform matching.");
    const t = M(e);
    if (!t) return console.warn(`Match [${e}] does not exist.`);
    const r = W(
      t.name,
      R.value.map(({ name: p }) => p)
    ), { parameters: a, ...s } = n;
    v.reload({
      ...o,
      ...s,
      data: {
        [i.value._match_key]: V(r),
        ...a,
        ...c
      }
    });
  }
  function C(e, n = {}) {
    if (e) return k(e, null, n);
    const { parameters: t, ...r } = n;
    v.reload({
      ...o,
      ...r,
      data: {
        ...Object.fromEntries(
          _.value.map(({ name: a }) => [a, null])
        ),
        ...t
      }
    });
  }
  function D(e = {}) {
    if (!h.value)
      return console.warn("Refine cannot perform sorting.");
    const { parameters: n, ...t } = e;
    v.reload({
      ...o,
      ...t,
      data: {
        [i.value._sort_key]: null,
        ...n
      }
    });
  }
  function L(e = {}) {
    E(null, e);
  }
  function N(e = {}) {
    if (!m.value)
      return console.warn("Refine cannot perform matching.");
    const { parameters: n, ...t } = e;
    v.reload({
      ...o,
      ...t,
      data: {
        [i.value._match_key]: null,
        ...n
      }
    });
  }
  function Q(e = {}) {
    var r;
    const { parameters: n, ...t } = e;
    v.reload({
      ...o,
      ...t,
      data: {
        [i.value._search_key ?? ""]: void 0,
        [i.value._sort_key ?? ""]: void 0,
        [i.value._match_key ?? ""]: void 0,
        ...Object.fromEntries(
          ((r = i.value.filters) == null ? void 0 : r.map((a) => [
            a.name,
            void 0
          ])) ?? []
        ),
        ...n
      }
    });
  }
  function G(e, n = {}) {
    const t = T(e);
    if (!t) return console.warn(`Filter [${e}] does not exist.`);
    const {
      debounce: r = 150,
      transform: a = (p) => p,
      ...s
    } = n;
    return {
      "onUpdate:modelValue": F((p) => {
        k(t, a(p), s);
      }, r),
      modelValue: t.value
    };
  }
  function I(e, n = {}) {
    if (!h.value)
      return console.warn("Refine cannot perform sorting.");
    const t = A(e);
    if (!t) return console.warn(`Sort [${e}] does not exist.`);
    const { debounce: r = 0, transform: a, ...s } = n;
    return {
      onClick: F(() => {
        var p;
        $(t, (p = S.value) == null ? void 0 : p.direction, s);
      }, r)
    };
  }
  function X(e = {}) {
    if (!w.value)
      return console.warn("Refine cannot perform searching.");
    const { debounce: n = 700, transform: t, ...r } = e;
    return {
      "onUpdate:modelValue": F(
        (a) => {
          E(a, r);
        },
        n
      ),
      modelValue: d.value ?? ""
    };
  }
  function q(e, n = {}) {
    if (!m.value)
      return console.warn("Refine cannot perform matching.");
    const t = M(e);
    if (!t) return console.warn(`Match [${e}] does not exist.`);
    const { debounce: r = 0, transform: a, ...s } = n;
    return {
      "onUpdate:modelValue": F((p) => {
        x(p, s);
      }, r),
      modelValue: U(t),
      value: t.name
    };
  }
  return {
    filters: b,
    sorts: y,
    searches: g,
    currentFilters: _,
    currentSort: S,
    currentSearches: R,
    searchTerm: d,
    isSortable: h,
    isSearchable: w,
    isMatchable: m,
    isFiltering: H,
    isSorting: J,
    isSearching: U,
    getFilter: T,
    getSort: A,
    getSearch: M,
    apply: K,
    applyFilter: k,
    applySort: $,
    applySearch: E,
    applyMatch: x,
    clearFilter: C,
    clearSort: D,
    clearSearch: L,
    clearMatch: N,
    reset: Q,
    bindFilter: G,
    bindSort: I,
    bindSearch: X,
    bindMatch: q,
    stringValue: j,
    omitValue: O,
    toggleValue: W,
    delimitArray: V
  };
}
function re(u, l) {
  return u ? typeof u == "object" ? (u == null ? void 0 : u.type) === l : u === l : !1;
}
export {
  re as is,
  te as useRefine
};
