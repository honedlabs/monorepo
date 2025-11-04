import { toValue as L, ref as te, computed as d } from "vue";
import { router as h } from "@inertiajs/vue3";
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const N = () => {
};
function re(c, v) {
  function p(...f) {
    return new Promise((o, m) => {
      Promise.resolve(c(() => v.apply(this, f), { fn: v, thisArg: this, args: f })).then(o).catch(m);
    });
  }
  return p;
}
function ie(c, v = {}) {
  let p, f, o = N;
  const m = (g) => {
    clearTimeout(g), o(), o = N;
  };
  let u;
  return (g) => {
    const w = L(c), b = L(v.maxWait);
    return p && m(p), w <= 0 || b !== void 0 && b <= 0 ? (f && (m(f), f = null), Promise.resolve(g())) : new Promise((_, O) => {
      o = v.rejectOnCancel ? O : _, u = g, b && !f && (f = setTimeout(() => {
        p && m(p), f = null, _(u());
      }, b)), p = setTimeout(() => {
        f && m(f), f = null, _(g());
      }, w);
    });
  };
}
function j(c, v = 200, p = {}) {
  return re(
    ie(v, p),
    c
  );
}
function ue(c, v, p = {}, f = {}) {
  if (!(c != null && c[v]))
    throw new Error("The refine must be provided with valid props and key.");
  const { onFinish: o, ...m } = p, u = te(!1), l = d(() => c[v]), g = d(() => l.value.term), w = d(() => !!l.value._sort_key), b = d(() => !!l.value._search_key), _ = d(() => !!l.value._match_key), O = d(
    () => {
      var e;
      return (e = l.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t, r = {}) => V(n, t, r),
        clear: (t = {}) => z(n, t),
        bind: () => H(n.name)
      }));
    }
  ), T = d(
    () => {
      var e;
      return (e = l.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => U(n, n.direction, t),
        clear: (t = {}) => B(t),
        bind: () => J(n)
      }));
    }
  ), A = d(
    () => {
      var e;
      return (e = l.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => S(n, t),
        clear: (t = {}) => S(n, t),
        bind: () => K(n)
      }));
    }
  ), k = d(
    () => O.value.filter(({ active: e }) => e)
  ), x = d(
    () => T.value.find(({ active: e }) => e)
  ), M = d(
    () => A.value.filter(({ active: e }) => e)
  );
  function $(e) {
    return Array.isArray(e) ? e.join(l.value._delimiter) : e;
  }
  function E(e) {
    return typeof e != "string" ? e : e.trim().replace(/\s+/g, "+");
  }
  function R(e) {
    if (!["", null, void 0, []].includes(e))
      return e;
  }
  function G(e) {
    return [$, E, R].reduce(
      (n, t) => t(n),
      e
    );
  }
  function I(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((t) => t !== e) : [...n, e];
  }
  function F(e) {
    return typeof e != "string" ? e : O.value.find(({ name: n }) => n === e);
  }
  function P(e, n = null) {
    return typeof e != "string" ? e : T.value.find(
      ({ name: t, direction: r }) => t === e && r === n
    );
  }
  function W(e) {
    return typeof e != "string" ? e : A.value.find(({ name: n }) => n === e);
  }
  function Q(e) {
    return e ? typeof e == "string" ? k.value.some((n) => n.name === e) : e.active : !!k.value.length;
  }
  function X(e) {
    var n;
    return e ? typeof e == "string" ? ((n = x.value) == null ? void 0 : n.name) === e : e.active : !!x.value;
  }
  function q(e) {
    var n;
    return e ? typeof e == "string" ? (n = M.value) == null ? void 0 : n.some((t) => t.name === e) : e.active : !!g.value;
  }
  function Y(e, n = {}) {
    const t = Object.fromEntries(
      Object.entries(e).map(([i, s]) => [i, G(s)])
    ), { onFinish: r, ...a } = n;
    u.value = !0, h.reload({
      ...m,
      ...a,
      data: t,
      onFinish: (i) => {
        u.value = !1, r == null || r(i), o == null || o(i);
      }
    });
  }
  function V(e, n, t = {}) {
    const r = F(e);
    if (!r) return console.warn(`Filter [${e}] does not exist.`);
    const { parameters: a, onFinish: i, ...s } = t;
    u.value = !0, h.reload({
      ...m,
      ...s,
      onFinish: (y) => {
        u.value = !1, i == null || i(y), o == null || o(y);
      },
      data: {
        [r.name]: G(n),
        ...a,
        ...f
      }
    });
  }
  function U(e, n = null, t = {}) {
    if (!w.value)
      return console.warn("Refine cannot perform sorting.");
    const r = P(e, n);
    if (!r) return console.warn(`Sort [${e}] does not exist.`);
    const { parameters: a, onFinish: i, ...s } = t;
    u.value = !0, h.reload({
      ...m,
      ...s,
      onFinish: (y) => {
        u.value = !1, i == null || i(y), o == null || o(y);
      },
      data: {
        [l.value._sort_key]: R(r.next),
        ...a
      }
    });
  }
  function C(e, n = {}) {
    if (!b.value)
      return console.warn("Refine cannot perform searching.");
    e = [E, R].reduce(
      (i, s) => s(i),
      e
    );
    const { parameters: t, onFinish: r, ...a } = n;
    u.value = !0, h.reload({
      ...m,
      ...a,
      onFinish: (i) => {
        u.value = !1, r == null || r(i), o == null || o(i);
      },
      data: {
        [l.value._search_key]: e,
        ...t,
        ...f
      }
    });
  }
  function S(e, n = {}) {
    if (!_.value || !b.value)
      return console.warn("Refine cannot perform matching.");
    const t = W(e);
    if (!t) return console.warn(`Match [${e}] does not exist.`);
    const r = I(
      t.name,
      M.value.map(({ name: y }) => y)
    ), { parameters: a, onFinish: i, ...s } = n;
    u.value = !0, h.reload({
      ...m,
      ...s,
      onFinish: (y) => {
        u.value = !1, i == null || i(y), o == null || o(y);
      },
      data: {
        [l.value._match_key]: $(r),
        ...a,
        ...f
      }
    });
  }
  function z(e, n = {}) {
    if (e) return V(e, null, n);
    const { parameters: t, onFinish: r, ...a } = n;
    u.value = !0, h.reload({
      ...m,
      ...a,
      onFinish: (i) => {
        u.value = !1, r == null || r(i), o == null || o(i);
      },
      data: {
        ...Object.fromEntries(
          k.value.map(({ name: i }) => [i, null])
        ),
        ...t
      }
    });
  }
  function B(e = {}) {
    if (!w.value)
      return console.warn("Refine cannot perform sorting.");
    const { parameters: n, onFinish: t, ...r } = e;
    u.value = !0, h.reload({
      ...m,
      ...r,
      onFinish: (a) => {
        u.value = !1, t == null || t(a), o == null || o(a);
      },
      data: {
        [l.value._sort_key]: null,
        ...n
      }
    });
  }
  function Z(e = {}) {
    C(null, e);
  }
  function D(e = {}) {
    if (!_.value)
      return console.warn("Refine cannot perform matching.");
    const { parameters: n, onFinish: t, ...r } = e;
    u.value = !0, h.reload({
      ...m,
      ...r,
      onFinish: (a) => {
        u.value = !1, t == null || t(a), o == null || o(a);
      },
      data: {
        [l.value._match_key]: null,
        ...n
      }
    });
  }
  function ee(e = {}) {
    var a;
    const { parameters: n, onFinish: t, ...r } = e;
    u.value = !0, h.reload({
      ...m,
      ...r,
      onFinish: (i) => {
        u.value = !1, t == null || t(i), o == null || o(i);
      },
      data: {
        [l.value._search_key ?? ""]: void 0,
        [l.value._sort_key ?? ""]: void 0,
        [l.value._match_key ?? ""]: void 0,
        ...Object.fromEntries(
          ((a = l.value.filters) == null ? void 0 : a.map((i) => [
            i.name,
            void 0
          ])) ?? []
        ),
        ...n
      }
    });
  }
  function H(e, n = {}) {
    const t = F(e);
    if (!t) return console.warn(`Filter [${e}] does not exist.`);
    const {
      debounce: r = 150,
      transform: a = (s) => s,
      ...i
    } = n;
    return {
      "onUpdate:modelValue": j((s) => {
        V(t, a(s), i);
      }, r),
      modelValue: t.value
    };
  }
  function J(e, n = {}) {
    if (!w.value)
      return console.warn("Refine cannot perform sorting.");
    const t = P(e);
    if (!t) return console.warn(`Sort [${e}] does not exist.`);
    const { debounce: r = 0, transform: a, ...i } = n;
    return {
      onClick: j(() => {
        var s;
        U(t, (s = x.value) == null ? void 0 : s.direction, i);
      }, r)
    };
  }
  function ne(e = {}) {
    if (!b.value)
      return console.warn("Refine cannot perform searching.");
    const { debounce: n = 700, transform: t, ...r } = e;
    return {
      "onUpdate:modelValue": j(
        (a) => {
          C(a, r);
        },
        n
      ),
      modelValue: g.value ?? ""
    };
  }
  function K(e, n = {}) {
    if (!_.value)
      return console.warn("Refine cannot perform matching.");
    const t = W(e);
    if (!t) return console.warn(`Match [${e}] does not exist.`);
    const { debounce: r = 0, transform: a, ...i } = n;
    return {
      "onUpdate:modelValue": j((s) => {
        S(s, i);
      }, r),
      modelValue: q(t),
      value: t.name
    };
  }
  return {
    processing: u,
    filters: O,
    sorts: T,
    searches: A,
    currentFilters: k,
    currentSort: x,
    currentSearches: M,
    searchTerm: g,
    isSortable: w,
    isSearchable: b,
    isMatchable: _,
    isFiltering: Q,
    isSorting: X,
    isSearching: q,
    getFilter: F,
    getSort: P,
    getSearch: W,
    apply: Y,
    applyFilter: V,
    applySort: U,
    applySearch: C,
    applyMatch: S,
    clearFilter: z,
    clearSort: B,
    clearSearch: Z,
    clearMatch: D,
    reset: ee,
    bindFilter: H,
    bindSort: J,
    bindSearch: ne,
    bindMatch: K,
    stringValue: E,
    omitValue: R,
    toggleValue: I,
    delimitArray: $
  };
}
function le(c, v) {
  return c ? typeof c == "object" ? (c == null ? void 0 : c.type) === v : c === v : !1;
}
export {
  le as is,
  ue as useRefine
};
