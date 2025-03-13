import { usePage as l } from "@inertiajs/vue3";
const o = l();
function f(n, r = null) {
  return r && "lock" in r ? r.lock[n] ?? !1 : o.props.lock[n] ?? !1;
}
function a(n, r = null) {
  return Array.isArray(n) ? n.some((u) => f(u, r)) : f(n, r);
}
function c(n, r = null) {
  return Array.isArray(n) ? n.every((u) => f(u, r)) : f(n, r);
}
export {
  f as can,
  c as canAll,
  a as canAny
};
