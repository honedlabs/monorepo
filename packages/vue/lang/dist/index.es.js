import { usePage as c } from "@inertiajs/vue3";
const l = c();
function p() {
  function o(n, e = {}) {
    const t = f(n);
    if (typeof t != "string") return n;
    let r = t;
    return typeof e == "string" ? r += " " + e : typeof e == "object" && (r = u(r, e)), r;
  }
  function i(n, e = {}) {
    return o(n, e);
  }
  function u(n, e) {
    return Object.entries(e).reduce(
      (t, [r, s]) => t.replaceAll(`:${r}`, String(s)),
      n
    );
  }
  function f(n) {
    const e = n.split(".");
    let t = l.props._lang;
    for (const r of e) {
      if (typeof t != "object" || t === null) return;
      t = t[r];
    }
    return typeof t == "string" ? t : void 0;
  }
  return { __: i, trans: o };
}
export {
  p as useLang
};
