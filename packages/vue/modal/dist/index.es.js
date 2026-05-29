import { computed as e, defineAsyncComponent as t, defineComponent as n, h as r, nextTick as i, ref as a, shallowRef as o, watch as s } from "vue";
import { router as c, usePage as l } from "@inertiajs/vue3";
import u from "axios";
//#region src/resolver.ts
var d = a(), f = {
	setResolveCallback: (e) => {
		d.value = e;
	},
	resolve: (e) => d.value(e)
}, p = { install(e, t) {
	f.setResolveCallback(t.resolve);
} }, m = l(), h = e(() => m?.props?.modal), g = e(() => h.value?.props), _ = e(() => h.value?.key), v = a(), y = o(), b = a(!1), x = a(), S = a(), C = (e) => {
	Object.entries(e).forEach(([e, t]) => [
		"post",
		"put",
		"patch",
		"delete"
	].forEach((n) => {
		u.defaults.headers[n][e] = t;
	}));
}, w = () => {
	["X-Inertia-Modal-Key", "X-Inertia-Modal-Redirect"].forEach(([e, t]) => [
		"get",
		"post",
		"put",
		"patch",
		"delete"
	].forEach((t) => {
		delete u.defaults.headers[t][e];
	}));
}, T = () => {
	C({
		"X-Inertia-Modal-Key": _.value,
		"X-Inertia-Modal-Redirect": h.value?.redirectURL
	}), u.defaults.headers.get["X-Inertia-Modal-Redirect"] = h.value?.redirectURL ?? "";
}, E = () => {
	b.value = !1, w();
}, D = () => {
	if (S.value == h.value?.nonce || !h.value?.component) return E();
	v.value != h.value?.component && (v.value = h.value.component, v.value ? y.value = t(() => f.resolve(v.value)) : y.value = !1), S.value = h.value?.nonce, x.value = y.value ? r(y.value, {
		key: _.value,
		...g.value
	}) : "", i(() => b.value = !0);
};
D(), typeof window < "u" && window.addEventListener("popstate", (e) => {
	S.value = null;
}), s(h, () => {
	h.value?.nonce !== S.value && D();
}, { deep: !0 }), s(_, T);
var O = (e = {}) => {
	var t = h.value?.redirectURL ?? h.value?.baseURL;
	if (x.value = !1, t) return c.visit(t, {
		preserveScroll: !0,
		preserveState: !0,
		...e
	});
}, k = () => ({
	show: b,
	vnode: x,
	close: E,
	redirect: O,
	props: g
}), A = n({ setup() {
	let { vnode: e } = k();
	return () => e.value;
} });
//#endregion
export { A as Modal, p as modal, k as useModal };
