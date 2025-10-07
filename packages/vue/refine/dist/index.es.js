import { toValue as q, computed as f } from "vue";
import { router as v } from "@inertiajs/vue3";
typeof WorkerGlobalScope < "u" && globalThis instanceof WorkerGlobalScope;
const z = () => {
};
function X(u, c) {
  function o(...r) {
    return new Promise((m, s) => {
      Promise.resolve(u(() => c.apply(this, r), { fn: c, thisArg: this, args: r })).then(m).catch(s);
    });
  }
  return o;
}
function Y(u, c = {}) {
  let o, r, m = z;
  const s = (p) => {
    clearTimeout(p), m(), m = z;
  };
  let g;
  return (p) => {
    const b = q(u), y = q(c.maxWait);
    return o && s(o), b <= 0 || y !== void 0 && y <= 0 ? (r && (s(r), r = null), Promise.resolve(p())) : new Promise((h, _) => {
      m = c.rejectOnCancel ? _ : h, g = p, y && !r && (r = setTimeout(() => {
        o && s(o), r = null, h(g());
      }, y)), o = setTimeout(() => {
        r && s(r), r = null, h(p());
      }, b);
    });
  };
}
function x(u, c = 200, o = {}) {
  return X(
    Y(c, o),
    u
  );
}
function ne(u, c, o = {}) {
  if (!(u != null && u[c]))
    throw new Error("The refine must be provided with valid props and key.");
  const r = f(() => u[c]), m = f(() => r.value.term), s = f(() => !!r.value._sort_key), g = f(() => !!r.value._search_key), w = f(() => !!r.value._match_key), p = f(
    () => {
      var e;
      return (e = r.value.filters) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t, i = {}) => O(n, t, i),
        clear: (t = {}) => U(n, t),
        bind: () => D(n.name)
      }));
    }
  ), b = f(
    () => {
      var e;
      return (e = r.value.sorts) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => M(n, n.direction, t),
        clear: (t = {}) => C(t),
        bind: () => G(n)
      }));
    }
  ), y = f(
    () => {
      var e;
      return (e = r.value.searches) == null ? void 0 : e.map((n) => ({
        ...n,
        apply: (t = {}) => k(n, t),
        clear: (t = {}) => k(n, t),
        bind: () => I(n)
      }));
    }
  ), h = f(
    () => p.value.filter(({ active: e }) => e)
  ), _ = f(
    () => b.value.find(({ active: e }) => e)
  ), F = f(
    () => y.value.filter(({ active: e }) => e)
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
  function E(e) {
    return [R, V, S].reduce(
      (n, t) => t(n),
      e
    );
  }
  function P(e, n) {
    return n = Array.isArray(n) ? n : [n], n.includes(e) ? n.filter((t) => t !== e) : [...n, e];
  }
  function j(e) {
    return typeof e != "string" ? e : p.value.find(({ name: n }) => n === e);
  }
  function T(e, n = null) {
    return typeof e != "string" ? e : b.value.find(
      ({ name: t, direction: i }) => t === e && i === n
    );
  }
  function A(e) {
    return typeof e != "string" ? e : y.value.find(({ name: n }) => n === e);
  }
  function B(e) {
    return e ? typeof e == "string" ? h.value.some((n) => n.name === e) : e.active : !!h.value.length;
  }
  function H(e) {
    var n;
    return e ? typeof e == "string" ? ((n = _.value) == null ? void 0 : n.name) === e : e.active : !!_.value;
  }
  function W(e) {
    var n;
    return e ? typeof e == "string" ? (n = F.value) == null ? void 0 : n.some((t) => t.name === e) : e.active : !!m.value;
  }
  function J(e, n = {}) {
    const t = Object.fromEntries(
      Object.entries(e).map(([i, a]) => [i, E(a)])
    );
    v.reload({
      ...o,
      ...n,
      data: t
    });
  }
  function O(e, n, t = {}) {
    const i = j(e);
    if (!i) return console.warn(`Filter [${e}] does not exist.`);
    const { parameters: a, ...l } = t;
    v.reload({
      ...o,
      ...l,
      data: {
        [i.name]: E(n),
        ...a
      }
    });
  }
  function M(e, n = null, t = {}) {
    if (!s.value)
      return console.warn("Refine cannot perform sorting.");
    const i = T(e, n);
    if (!i) return console.warn(`Sort [${e}] does not exist.`);
    const { parameters: a, ...l } = t;
    v.reload({
      ...o,
      ...l,
      data: {
        [r.value._sort_key]: S(i.next),
        ...a
      }
    });
  }
  function $(e, n = {}) {
    if (!g.value)
      return console.warn("Refine cannot perform searching.");
    e = [V, S].reduce(
      (a, l) => l(a),
      e
    );
    const { parameters: t, ...i } = n;
    v.reload({
      ...o,
      ...i,
      data: {
        [r.value._search_key]: e,
        ...t
      }
    });
  }
  function k(e, n = {}) {
    if (!w.value || !g.value)
      return console.warn("Refine cannot perform matching.");
    const t = A(e);
    if (!t) return console.warn(`Match [${e}] does not exist.`);
    const i = P(
      t.name,
      F.value.map(({ name: d }) => d)
    ), { parameters: a, ...l } = n;
    v.reload({
      ...o,
      ...l,
      data: {
        [r.value._match_key]: R(i),
        ...a
      }
    });
  }
  function U(e, n = {}) {
    if (e) return O(e, null, n);
    const { parameters: t, ...i } = n;
    v.reload({
      ...o,
      ...i,
      data: {
        ...Object.fromEntries(
          h.value.map(({ name: a }) => [a, null])
        ),
        ...t
      }
    });
  }
  function C(e = {}) {
    if (!s.value)
      return console.warn("Refine cannot perform sorting.");
    const { parameters: n, ...t } = e;
    v.reload({
      ...o,
      ...t,
      data: {
        [r.value._sort_key]: null,
        ...n
      }
    });
  }
  function K(e = {}) {
    $(null, e);
  }
  function L(e = {}) {
    if (!w.value)
      return console.warn("Refine cannot perform matching.");
    const { parameters: n, ...t } = e;
    v.reload({
      ...o,
      ...t,
      data: {
        [r.value._match_key]: null,
        ...n
      }
    });
  }
  function N(e = {}) {
    var i;
    const { parameters: n, ...t } = e;
    v.reload({
      ...o,
      ...t,
      data: {
        [r.value._search_key ?? ""]: void 0,
        [r.value._sort_key ?? ""]: void 0,
        [r.value._match_key ?? ""]: void 0,
        ...Object.fromEntries(
          ((i = r.value.filters) == null ? void 0 : i.map((a) => [
            a.name,
            void 0
          ])) ?? []
        ),
        ...n
      }
    });
  }
  function D(e, n = {}) {
    const t = j(e);
    if (!t) return console.warn(`Filter [${e}] does not exist.`);
    const {
      debounce: i = 150,
      transform: a = (d) => d,
      ...l
    } = n;
    return {
      "onUpdate:modelValue": x((d) => {
        O(t, a(d), l);
      }, i),
      modelValue: t.value
    };
  }
  function G(e, n = {}) {
    if (!s.value)
      return console.warn("Refine cannot perform sorting.");
    const t = T(e);
    if (!t) return console.warn(`Sort [${e}] does not exist.`);
    const { debounce: i = 0, transform: a, ...l } = n;
    return {
      onClick: x(() => {
        var d;
        M(t, (d = _.value) == null ? void 0 : d.direction, l);
      }, i)
    };
  }
  function Q(e = {}) {
    if (!g.value)
      return console.warn("Refine cannot perform searching.");
    const { debounce: n = 700, transform: t, ...i } = e;
    return {
      "onUpdate:modelValue": x(
        (a) => {
          $(a, i);
        },
        n
      ),
      modelValue: m.value ?? ""
    };
  }
  function I(e, n = {}) {
    if (!w.value)
      return console.warn("Refine cannot perform matching.");
    const t = A(e);
    if (!t) return console.warn(`Match [${e}] does not exist.`);
    const { debounce: i = 0, transform: a, ...l } = n;
    return {
      "onUpdate:modelValue": x((d) => {
        k(d, l);
      }, i),
      modelValue: W(t),
      value: t.name
    };
  }
  return {
    filters: p,
    sorts: b,
    searches: y,
    currentFilters: h,
    currentSort: _,
    currentSearches: F,
    searchTerm: m,
    isSortable: s,
    isSearchable: g,
    isMatchable: w,
    isFiltering: B,
    isSorting: H,
    isSearching: W,
    getFilter: j,
    getSort: T,
    getSearch: A,
    apply: J,
    applyFilter: O,
    applySort: M,
    applySearch: $,
    applyMatch: k,
    clearFilter: U,
    clearSort: C,
    clearSearch: K,
    clearMatch: L,
    reset: N,
    bindFilter: D,
    bindSort: G,
    bindSearch: Q,
    bindMatch: I,
    stringValue: V,
    omitValue: S,
    toggleValue: P,
    delimitArray: R
  };
}
function te(u, c) {
  return u ? typeof u == "object" ? (u == null ? void 0 : u.type) === c : u === c : !1;
}
export {
  te as is,
  ne as useRefine
};
