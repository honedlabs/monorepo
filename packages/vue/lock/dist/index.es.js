import { usePage as a } from "@inertiajs/vue3";
const f = a();
function r(n, l = null) {
  return l && "lock" in l ? l.lock[n] ?? !1 : f.props.lock[n] ?? !1;
}
function c(n, l = null) {
  return Array.isArray(n) ? n.some((t) => r(t, l)) : r(n, l);
}
function y(n, l = null) {
  return Array.isArray(n) ? n.every((t) => r(t, l)) : r(n, l);
}
export {
  r as can,
  y as canAll,
  c as canAny
};
