import kt from "axios";
import { ref as Ct, shallowRef as gn, defineComponent as wn, markRaw as Ut, h as Me, createSSRApp as Sn } from "vue";
import { useForm as bn, useRemember as Pn } from "@inertiajs/vue3";
var Bt = typeof globalThis < "u" ? globalThis : typeof window < "u" ? window : typeof global < "u" ? global : typeof self < "u" ? self : {};
function En(t) {
  return t && t.__esModule && Object.prototype.hasOwnProperty.call(t, "default") ? t.default : t;
}
function An(t) {
  if (t.__esModule) return t;
  var e = t.default;
  if (typeof e == "function") {
    var r = function n() {
      return this instanceof n ? Reflect.construct(e, arguments, this.constructor) : e.apply(this, arguments);
    };
    r.prototype = e.prototype;
  } else r = {};
  return Object.defineProperty(r, "__esModule", { value: !0 }), Object.keys(t).forEach(function(n) {
    var a = Object.getOwnPropertyDescriptor(t, n);
    Object.defineProperty(r, n, a.get ? a : {
      enumerable: !0,
      get: function() {
        return t[n];
      }
    });
  }), r;
}
var On = function(e) {
  return $n(e) && !Rn(e);
};
function $n(t) {
  return !!t && typeof t == "object";
}
function Rn(t) {
  var e = Object.prototype.toString.call(t);
  return e === "[object RegExp]" || e === "[object Date]" || Fn(t);
}
var In = typeof Symbol == "function" && Symbol.for, xn = In ? Symbol.for("react.element") : 60103;
function Fn(t) {
  return t.$$typeof === xn;
}
function Cn(t) {
  return Array.isArray(t) ? [] : {};
}
function Ee(t, e) {
  return e.clone !== !1 && e.isMergeableObject(t) ? se(Cn(t), t, e) : t;
}
function Tn(t, e, r) {
  return t.concat(e).map(function(n) {
    return Ee(n, r);
  });
}
function qn(t, e) {
  if (!e.customMerge)
    return se;
  var r = e.customMerge(t);
  return typeof r == "function" ? r : se;
}
function Mn(t) {
  return Object.getOwnPropertySymbols ? Object.getOwnPropertySymbols(t).filter(function(e) {
    return Object.propertyIsEnumerable.call(t, e);
  }) : [];
}
function Ht(t) {
  return Object.keys(t).concat(Mn(t));
}
function Rr(t, e) {
  try {
    return e in t;
  } catch {
    return !1;
  }
}
function Dn(t, e) {
  return Rr(t, e) && !(Object.hasOwnProperty.call(t, e) && Object.propertyIsEnumerable.call(t, e));
}
function Ln(t, e, r) {
  var n = {};
  return r.isMergeableObject(t) && Ht(t).forEach(function(a) {
    n[a] = Ee(t[a], r);
  }), Ht(e).forEach(function(a) {
    Dn(t, a) || (Rr(t, a) && r.isMergeableObject(e[a]) ? n[a] = qn(a, r)(t[a], e[a], r) : n[a] = Ee(e[a], r));
  }), n;
}
function se(t, e, r) {
  r = r || {}, r.arrayMerge = r.arrayMerge || Tn, r.isMergeableObject = r.isMergeableObject || On, r.cloneUnlessOtherwiseSpecified = Ee;
  var n = Array.isArray(e), a = Array.isArray(t), i = n === a;
  return i ? n ? r.arrayMerge(t, e, r) : Ln(t, e, r) : Ee(e, r);
}
se.all = function(e, r) {
  if (!Array.isArray(e))
    throw new Error("first argument should be an array");
  return e.reduce(function(n, a) {
    return se(n, a, r);
  }, {});
};
var Nn = se, _n = Nn;
const kn = /* @__PURE__ */ En(_n);
var pe = TypeError;
const Un = {}, Bn = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: Un
}, Symbol.toStringTag, { value: "Module" })), Hn = /* @__PURE__ */ An(Bn);
var Tt = typeof Map == "function" && Map.prototype, Ye = Object.getOwnPropertyDescriptor && Tt ? Object.getOwnPropertyDescriptor(Map.prototype, "size") : null, Ue = Tt && Ye && typeof Ye.get == "function" ? Ye.get : null, jt = Tt && Map.prototype.forEach, qt = typeof Set == "function" && Set.prototype, Ze = Object.getOwnPropertyDescriptor && qt ? Object.getOwnPropertyDescriptor(Set.prototype, "size") : null, Be = qt && Ze && typeof Ze.get == "function" ? Ze.get : null, Wt = qt && Set.prototype.forEach, jn = typeof WeakMap == "function" && WeakMap.prototype, ge = jn ? WeakMap.prototype.has : null, Wn = typeof WeakSet == "function" && WeakSet.prototype, we = Wn ? WeakSet.prototype.has : null, Vn = typeof WeakRef == "function" && WeakRef.prototype, Vt = Vn ? WeakRef.prototype.deref : null, Gn = Boolean.prototype.valueOf, Kn = Object.prototype.toString, zn = Function.prototype.toString, Qn = String.prototype.match, Mt = String.prototype.slice, H = String.prototype.replace, Jn = String.prototype.toUpperCase, Gt = String.prototype.toLowerCase, Ir = RegExp.prototype.test, Kt = Array.prototype.concat, L = Array.prototype.join, Xn = Array.prototype.slice, zt = Math.floor, bt = typeof BigInt == "function" ? BigInt.prototype.valueOf : null, et = Object.getOwnPropertySymbols, Pt = typeof Symbol == "function" && typeof Symbol.iterator == "symbol" ? Symbol.prototype.toString : null, le = typeof Symbol == "function" && typeof Symbol.iterator == "object", Se = typeof Symbol == "function" && Symbol.toStringTag && (typeof Symbol.toStringTag === le || !0) ? Symbol.toStringTag : null, xr = Object.prototype.propertyIsEnumerable, Qt = (typeof Reflect == "function" ? Reflect.getPrototypeOf : Object.getPrototypeOf) || ([].__proto__ === Array.prototype ? function(t) {
  return t.__proto__;
} : null);
function Jt(t, e) {
  if (t === 1 / 0 || t === -1 / 0 || t !== t || t && t > -1e3 && t < 1e3 || Ir.call(/e/, e))
    return e;
  var r = /[0-9](?=(?:[0-9]{3})+(?![0-9]))/g;
  if (typeof t == "number") {
    var n = t < 0 ? -zt(-t) : zt(t);
    if (n !== t) {
      var a = String(n), i = Mt.call(e, a.length + 1);
      return H.call(a, r, "$&_") + "." + H.call(H.call(i, /([0-9]{3})/g, "$&_"), /_$/, "");
    }
  }
  return H.call(e, r, "$&_");
}
var Et = Hn, Xt = Et.custom, Yt = Tr(Xt) ? Xt : null, Fr = {
  __proto__: null,
  double: '"',
  single: "'"
}, Yn = {
  __proto__: null,
  double: /(["\\])/g,
  single: /(['\\])/g
}, Ve = function t(e, r, n, a) {
  var i = r || {};
  if (_(i, "quoteStyle") && !_(Fr, i.quoteStyle))
    throw new TypeError('option "quoteStyle" must be "single" or "double"');
  if (_(i, "maxStringLength") && (typeof i.maxStringLength == "number" ? i.maxStringLength < 0 && i.maxStringLength !== 1 / 0 : i.maxStringLength !== null))
    throw new TypeError('option "maxStringLength", if provided, must be a positive integer, Infinity, or `null`');
  var o = _(i, "customInspect") ? i.customInspect : !0;
  if (typeof o != "boolean" && o !== "symbol")
    throw new TypeError("option \"customInspect\", if provided, must be `true`, `false`, or `'symbol'`");
  if (_(i, "indent") && i.indent !== null && i.indent !== "	" && !(parseInt(i.indent, 10) === i.indent && i.indent > 0))
    throw new TypeError('option "indent" must be "\\t", an integer > 0, or `null`');
  if (_(i, "numericSeparator") && typeof i.numericSeparator != "boolean")
    throw new TypeError('option "numericSeparator", if provided, must be `true` or `false`');
  var c = i.numericSeparator;
  if (typeof e > "u")
    return "undefined";
  if (e === null)
    return "null";
  if (typeof e == "boolean")
    return e ? "true" : "false";
  if (typeof e == "string")
    return Mr(e, i);
  if (typeof e == "number") {
    if (e === 0)
      return 1 / 0 / e > 0 ? "0" : "-0";
    var s = String(e);
    return c ? Jt(e, s) : s;
  }
  if (typeof e == "bigint") {
    var l = String(e) + "n";
    return c ? Jt(e, l) : l;
  }
  var u = typeof i.depth > "u" ? 5 : i.depth;
  if (typeof n > "u" && (n = 0), n >= u && u > 0 && typeof e == "object")
    return At(e) ? "[Array]" : "[Object]";
  var f = ma(i, n);
  if (typeof a > "u")
    a = [];
  else if (qr(a, e) >= 0)
    return "[Circular]";
  function p(F, B, N) {
    if (B && (a = Xn.call(a), a.push(B)), N) {
      var he = {
        depth: i.depth
      };
      return _(i, "quoteStyle") && (he.quoteStyle = i.quoteStyle), t(F, he, n + 1, a);
    }
    return t(F, i, n + 1, a);
  }
  if (typeof e == "function" && !Zt(e)) {
    var y = sa(e), h = Ce(e, p);
    return "[Function" + (y ? ": " + y : " (anonymous)") + "]" + (h.length > 0 ? " { " + L.call(h, ", ") + " }" : "");
  }
  if (Tr(e)) {
    var w = le ? H.call(String(e), /^(Symbol\(.*\))_[^)]*$/, "$1") : Pt.call(e);
    return typeof e == "object" && !le ? de(w) : w;
  }
  if (ha(e)) {
    for (var S = "<" + Gt.call(String(e.nodeName)), $ = e.attributes || [], q = 0; q < $.length; q++)
      S += " " + $[q].name + "=" + Cr(Zn($[q].value), "double", i);
    return S += ">", e.childNodes && e.childNodes.length && (S += "..."), S += "</" + Gt.call(String(e.nodeName)) + ">", S;
  }
  if (At(e)) {
    if (e.length === 0)
      return "[]";
    var v = Ce(e, p);
    return f && !ya(v) ? "[" + Ot(v, f) + "]" : "[ " + L.call(v, ", ") + " ]";
  }
  if (ta(e)) {
    var k = Ce(e, p);
    return !("cause" in Error.prototype) && "cause" in e && !xr.call(e, "cause") ? "{ [" + String(e) + "] " + L.call(Kt.call("[cause]: " + p(e.cause), k), ", ") + " }" : k.length === 0 ? "[" + String(e) + "]" : "{ [" + String(e) + "] " + L.call(k, ", ") + " }";
  }
  if (typeof e == "object" && o) {
    if (Yt && typeof e[Yt] == "function" && Et)
      return Et(e, { depth: u - n });
    if (o !== "symbol" && typeof e.inspect == "function")
      return e.inspect();
  }
  if (la(e)) {
    var G = [];
    return jt && jt.call(e, function(F, B) {
      G.push(p(B, e, !0) + " => " + p(F, e));
    }), er("Map", Ue.call(e), G, f);
  }
  if (pa(e)) {
    var fe = [];
    return Wt && Wt.call(e, function(F) {
      fe.push(p(F, e));
    }), er("Set", Be.call(e), fe, f);
  }
  if (ca(e))
    return tt("WeakMap");
  if (fa(e))
    return tt("WeakSet");
  if (ua(e))
    return tt("WeakRef");
  if (na(e))
    return de(p(Number(e)));
  if (ia(e))
    return de(p(bt.call(e)));
  if (aa(e))
    return de(Gn.call(e));
  if (ra(e))
    return de(p(String(e)));
  if (typeof window < "u" && e === window)
    return "{ [object Window] }";
  if (typeof globalThis < "u" && e === globalThis || typeof Bt < "u" && e === Bt)
    return "{ [object globalThis] }";
  if (!ea(e) && !Zt(e)) {
    var ee = Ce(e, p), xe = Qt ? Qt(e) === Object.prototype : e instanceof Object || e.constructor === Object, K = e instanceof Object ? "" : "null prototype", U = !xe && Se && Object(e) === e && Se in e ? Mt.call(V(e), 8, -1) : K ? "Object" : "", Fe = xe || typeof e.constructor != "function" ? "" : e.constructor.name ? e.constructor.name + " " : "", te = Fe + (U || K ? "[" + L.call(Kt.call([], U || [], K || []), ": ") + "] " : "");
    return ee.length === 0 ? te + "{}" : f ? te + "{" + Ot(ee, f) + "}" : te + "{ " + L.call(ee, ", ") + " }";
  }
  return String(e);
};
function Cr(t, e, r) {
  var n = r.quoteStyle || e, a = Fr[n];
  return a + t + a;
}
function Zn(t) {
  return H.call(String(t), /"/g, "&quot;");
}
function Z(t) {
  return !Se || !(typeof t == "object" && (Se in t || typeof t[Se] < "u"));
}
function At(t) {
  return V(t) === "[object Array]" && Z(t);
}
function ea(t) {
  return V(t) === "[object Date]" && Z(t);
}
function Zt(t) {
  return V(t) === "[object RegExp]" && Z(t);
}
function ta(t) {
  return V(t) === "[object Error]" && Z(t);
}
function ra(t) {
  return V(t) === "[object String]" && Z(t);
}
function na(t) {
  return V(t) === "[object Number]" && Z(t);
}
function aa(t) {
  return V(t) === "[object Boolean]" && Z(t);
}
function Tr(t) {
  if (le)
    return t && typeof t == "object" && t instanceof Symbol;
  if (typeof t == "symbol")
    return !0;
  if (!t || typeof t != "object" || !Pt)
    return !1;
  try {
    return Pt.call(t), !0;
  } catch {
  }
  return !1;
}
function ia(t) {
  if (!t || typeof t != "object" || !bt)
    return !1;
  try {
    return bt.call(t), !0;
  } catch {
  }
  return !1;
}
var oa = Object.prototype.hasOwnProperty || function(t) {
  return t in this;
};
function _(t, e) {
  return oa.call(t, e);
}
function V(t) {
  return Kn.call(t);
}
function sa(t) {
  if (t.name)
    return t.name;
  var e = Qn.call(zn.call(t), /^function\s*([\w$]+)/);
  return e ? e[1] : null;
}
function qr(t, e) {
  if (t.indexOf)
    return t.indexOf(e);
  for (var r = 0, n = t.length; r < n; r++)
    if (t[r] === e)
      return r;
  return -1;
}
function la(t) {
  if (!Ue || !t || typeof t != "object")
    return !1;
  try {
    Ue.call(t);
    try {
      Be.call(t);
    } catch {
      return !0;
    }
    return t instanceof Map;
  } catch {
  }
  return !1;
}
function ca(t) {
  if (!ge || !t || typeof t != "object")
    return !1;
  try {
    ge.call(t, ge);
    try {
      we.call(t, we);
    } catch {
      return !0;
    }
    return t instanceof WeakMap;
  } catch {
  }
  return !1;
}
function ua(t) {
  if (!Vt || !t || typeof t != "object")
    return !1;
  try {
    return Vt.call(t), !0;
  } catch {
  }
  return !1;
}
function pa(t) {
  if (!Be || !t || typeof t != "object")
    return !1;
  try {
    Be.call(t);
    try {
      Ue.call(t);
    } catch {
      return !0;
    }
    return t instanceof Set;
  } catch {
  }
  return !1;
}
function fa(t) {
  if (!we || !t || typeof t != "object")
    return !1;
  try {
    we.call(t, we);
    try {
      ge.call(t, ge);
    } catch {
      return !0;
    }
    return t instanceof WeakSet;
  } catch {
  }
  return !1;
}
function ha(t) {
  return !t || typeof t != "object" ? !1 : typeof HTMLElement < "u" && t instanceof HTMLElement ? !0 : typeof t.nodeName == "string" && typeof t.getAttribute == "function";
}
function Mr(t, e) {
  if (t.length > e.maxStringLength) {
    var r = t.length - e.maxStringLength, n = "... " + r + " more character" + (r > 1 ? "s" : "");
    return Mr(Mt.call(t, 0, e.maxStringLength), e) + n;
  }
  var a = Yn[e.quoteStyle || "single"];
  a.lastIndex = 0;
  var i = H.call(H.call(t, a, "\\$1"), /[\x00-\x1f]/g, da);
  return Cr(i, "single", e);
}
function da(t) {
  var e = t.charCodeAt(0), r = {
    8: "b",
    9: "t",
    10: "n",
    12: "f",
    13: "r"
  }[e];
  return r ? "\\" + r : "\\x" + (e < 16 ? "0" : "") + Jn.call(e.toString(16));
}
function de(t) {
  return "Object(" + t + ")";
}
function tt(t) {
  return t + " { ? }";
}
function er(t, e, r, n) {
  var a = n ? Ot(r, n) : L.call(r, ", ");
  return t + " (" + e + ") {" + a + "}";
}
function ya(t) {
  for (var e = 0; e < t.length; e++)
    if (qr(t[e], `
`) >= 0)
      return !1;
  return !0;
}
function ma(t, e) {
  var r;
  if (t.indent === "	")
    r = "	";
  else if (typeof t.indent == "number" && t.indent > 0)
    r = L.call(Array(t.indent + 1), " ");
  else
    return null;
  return {
    base: r,
    prev: L.call(Array(e + 1), r)
  };
}
function Ot(t, e) {
  if (t.length === 0)
    return "";
  var r = `
` + e.prev + e.base;
  return r + L.call(t, "," + r) + `
` + e.prev;
}
function Ce(t, e) {
  var r = At(t), n = [];
  if (r) {
    n.length = t.length;
    for (var a = 0; a < t.length; a++)
      n[a] = _(t, a) ? e(t[a], t) : "";
  }
  var i = typeof et == "function" ? et(t) : [], o;
  if (le) {
    o = {};
    for (var c = 0; c < i.length; c++)
      o["$" + i[c]] = i[c];
  }
  for (var s in t)
    _(t, s) && (r && String(Number(s)) === s && s < t.length || le && o["$" + s] instanceof Symbol || (Ir.call(/[^\w$]/, s) ? n.push(e(s, t) + ": " + e(t[s], t)) : n.push(s + ": " + e(t[s], t))));
  if (typeof et == "function")
    for (var l = 0; l < i.length; l++)
      xr.call(t, i[l]) && n.push("[" + e(i[l]) + "]: " + e(t[i[l]], t));
  return n;
}
var va = Ve, ga = pe, Ge = function(t, e, r) {
  for (var n = t, a; (a = n.next) != null; n = a)
    if (a.key === e)
      return n.next = a.next, r || (a.next = /** @type {NonNullable<typeof list.next>} */
      t.next, t.next = a), a;
}, wa = function(t, e) {
  if (t) {
    var r = Ge(t, e);
    return r && r.value;
  }
}, Sa = function(t, e, r) {
  var n = Ge(t, e);
  n ? n.value = r : t.next = /** @type {import('./list.d.ts').ListNode<typeof value, typeof key>} */
  {
    // eslint-disable-line no-param-reassign, no-extra-parens
    key: e,
    next: t.next,
    value: r
  };
}, ba = function(t, e) {
  return t ? !!Ge(t, e) : !1;
}, Pa = function(t, e) {
  if (t)
    return Ge(t, e, !0);
}, Ea = function() {
  var e, r = {
    assert: function(n) {
      if (!r.has(n))
        throw new ga("Side channel does not contain " + va(n));
    },
    delete: function(n) {
      var a = e && e.next, i = Pa(e, n);
      return i && a && a === i && (e = void 0), !!i;
    },
    get: function(n) {
      return wa(e, n);
    },
    has: function(n) {
      return ba(e, n);
    },
    set: function(n, a) {
      e || (e = {
        next: void 0
      }), Sa(
        /** @type {NonNullable<typeof $o>} */
        e,
        n,
        a
      );
    }
  };
  return r;
}, Dr = Object, Aa = Error, Oa = EvalError, $a = RangeError, Ra = ReferenceError, Ia = SyntaxError, xa = URIError, Fa = Math.abs, Ca = Math.floor, Ta = Math.max, qa = Math.min, Ma = Math.pow, Da = Math.round, La = Number.isNaN || function(e) {
  return e !== e;
}, Na = La, _a = function(e) {
  return Na(e) || e === 0 ? e : e < 0 ? -1 : 1;
}, ka = Object.getOwnPropertyDescriptor, De = ka;
if (De)
  try {
    De([], "length");
  } catch {
    De = null;
  }
var Lr = De, Le = Object.defineProperty || !1;
if (Le)
  try {
    Le({}, "a", { value: 1 });
  } catch {
    Le = !1;
  }
var Ua = Le, rt, tr;
function Ba() {
  return tr || (tr = 1, rt = function() {
    if (typeof Symbol != "function" || typeof Object.getOwnPropertySymbols != "function")
      return !1;
    if (typeof Symbol.iterator == "symbol")
      return !0;
    var e = {}, r = Symbol("test"), n = Object(r);
    if (typeof r == "string" || Object.prototype.toString.call(r) !== "[object Symbol]" || Object.prototype.toString.call(n) !== "[object Symbol]")
      return !1;
    var a = 42;
    e[r] = a;
    for (var i in e)
      return !1;
    if (typeof Object.keys == "function" && Object.keys(e).length !== 0 || typeof Object.getOwnPropertyNames == "function" && Object.getOwnPropertyNames(e).length !== 0)
      return !1;
    var o = Object.getOwnPropertySymbols(e);
    if (o.length !== 1 || o[0] !== r || !Object.prototype.propertyIsEnumerable.call(e, r))
      return !1;
    if (typeof Object.getOwnPropertyDescriptor == "function") {
      var c = (
        /** @type {PropertyDescriptor} */
        Object.getOwnPropertyDescriptor(e, r)
      );
      if (c.value !== a || c.enumerable !== !0)
        return !1;
    }
    return !0;
  }), rt;
}
var nt, rr;
function Ha() {
  if (rr) return nt;
  rr = 1;
  var t = typeof Symbol < "u" && Symbol, e = Ba();
  return nt = function() {
    return typeof t != "function" || typeof Symbol != "function" || typeof t("foo") != "symbol" || typeof Symbol("bar") != "symbol" ? !1 : e();
  }, nt;
}
var at, nr;
function Nr() {
  return nr || (nr = 1, at = typeof Reflect < "u" && Reflect.getPrototypeOf || null), at;
}
var it, ar;
function _r() {
  if (ar) return it;
  ar = 1;
  var t = Dr;
  return it = t.getPrototypeOf || null, it;
}
var ot, ir;
function ja() {
  if (ir) return ot;
  ir = 1;
  var t = "Function.prototype.bind called on incompatible ", e = Object.prototype.toString, r = Math.max, n = "[object Function]", a = function(s, l) {
    for (var u = [], f = 0; f < s.length; f += 1)
      u[f] = s[f];
    for (var p = 0; p < l.length; p += 1)
      u[p + s.length] = l[p];
    return u;
  }, i = function(s, l) {
    for (var u = [], f = l, p = 0; f < s.length; f += 1, p += 1)
      u[p] = s[f];
    return u;
  }, o = function(c, s) {
    for (var l = "", u = 0; u < c.length; u += 1)
      l += c[u], u + 1 < c.length && (l += s);
    return l;
  };
  return ot = function(s) {
    var l = this;
    if (typeof l != "function" || e.apply(l) !== n)
      throw new TypeError(t + l);
    for (var u = i(arguments, 1), f, p = function() {
      if (this instanceof f) {
        var $ = l.apply(
          this,
          a(u, arguments)
        );
        return Object($) === $ ? $ : this;
      }
      return l.apply(
        s,
        a(u, arguments)
      );
    }, y = r(0, l.length - u.length), h = [], w = 0; w < y; w++)
      h[w] = "$" + w;
    if (f = Function("binder", "return function (" + o(h, ",") + "){ return binder.apply(this,arguments); }")(p), l.prototype) {
      var S = function() {
      };
      S.prototype = l.prototype, f.prototype = new S(), S.prototype = null;
    }
    return f;
  }, ot;
}
var st, or;
function Ke() {
  if (or) return st;
  or = 1;
  var t = ja();
  return st = Function.prototype.bind || t, st;
}
var lt, sr;
function Dt() {
  return sr || (sr = 1, lt = Function.prototype.call), lt;
}
var ct, lr;
function kr() {
  return lr || (lr = 1, ct = Function.prototype.apply), ct;
}
var Wa = typeof Reflect < "u" && Reflect && Reflect.apply, Va = Ke(), Ga = kr(), Ka = Dt(), za = Wa, Qa = za || Va.call(Ka, Ga), Ja = Ke(), Xa = pe, Ya = Dt(), Za = Qa, Ur = function(e) {
  if (e.length < 1 || typeof e[0] != "function")
    throw new Xa("a function is required");
  return Za(Ja, Ya, e);
}, ut, cr;
function ei() {
  if (cr) return ut;
  cr = 1;
  var t = Ur, e = Lr, r;
  try {
    r = /** @type {{ __proto__?: typeof Array.prototype }} */
    [].__proto__ === Array.prototype;
  } catch (o) {
    if (!o || typeof o != "object" || !("code" in o) || o.code !== "ERR_PROTO_ACCESS")
      throw o;
  }
  var n = !!r && e && e(
    Object.prototype,
    /** @type {keyof typeof Object.prototype} */
    "__proto__"
  ), a = Object, i = a.getPrototypeOf;
  return ut = n && typeof n.get == "function" ? t([n.get]) : typeof i == "function" ? (
    /** @type {import('./get')} */
    function(c) {
      return i(c == null ? c : a(c));
    }
  ) : !1, ut;
}
var pt, ur;
function ti() {
  if (ur) return pt;
  ur = 1;
  var t = Nr(), e = _r(), r = ei();
  return pt = t ? function(a) {
    return t(a);
  } : e ? function(a) {
    if (!a || typeof a != "object" && typeof a != "function")
      throw new TypeError("getProto: not an object");
    return e(a);
  } : r ? function(a) {
    return r(a);
  } : null, pt;
}
var ft, pr;
function ri() {
  if (pr) return ft;
  pr = 1;
  var t = Function.prototype.call, e = Object.prototype.hasOwnProperty, r = Ke();
  return ft = r.call(t, e), ft;
}
var m, ni = Dr, ai = Aa, ii = Oa, oi = $a, si = Ra, ce = Ia, ie = pe, li = xa, ci = Fa, ui = Ca, pi = Ta, fi = qa, hi = Ma, di = Da, yi = _a, Br = Function, ht = function(t) {
  try {
    return Br('"use strict"; return (' + t + ").constructor;")();
  } catch {
  }
}, Ae = Lr, mi = Ua, dt = function() {
  throw new ie();
}, vi = Ae ? function() {
  try {
    return arguments.callee, dt;
  } catch {
    try {
      return Ae(arguments, "callee").get;
    } catch {
      return dt;
    }
  }
}() : dt, re = Ha()(), A = ti(), gi = _r(), wi = Nr(), Hr = kr(), $e = Dt(), ae = {}, Si = typeof Uint8Array > "u" || !A ? m : A(Uint8Array), X = {
  __proto__: null,
  "%AggregateError%": typeof AggregateError > "u" ? m : AggregateError,
  "%Array%": Array,
  "%ArrayBuffer%": typeof ArrayBuffer > "u" ? m : ArrayBuffer,
  "%ArrayIteratorPrototype%": re && A ? A([][Symbol.iterator]()) : m,
  "%AsyncFromSyncIteratorPrototype%": m,
  "%AsyncFunction%": ae,
  "%AsyncGenerator%": ae,
  "%AsyncGeneratorFunction%": ae,
  "%AsyncIteratorPrototype%": ae,
  "%Atomics%": typeof Atomics > "u" ? m : Atomics,
  "%BigInt%": typeof BigInt > "u" ? m : BigInt,
  "%BigInt64Array%": typeof BigInt64Array > "u" ? m : BigInt64Array,
  "%BigUint64Array%": typeof BigUint64Array > "u" ? m : BigUint64Array,
  "%Boolean%": Boolean,
  "%DataView%": typeof DataView > "u" ? m : DataView,
  "%Date%": Date,
  "%decodeURI%": decodeURI,
  "%decodeURIComponent%": decodeURIComponent,
  "%encodeURI%": encodeURI,
  "%encodeURIComponent%": encodeURIComponent,
  "%Error%": ai,
  "%eval%": eval,
  // eslint-disable-line no-eval
  "%EvalError%": ii,
  "%Float16Array%": typeof Float16Array > "u" ? m : Float16Array,
  "%Float32Array%": typeof Float32Array > "u" ? m : Float32Array,
  "%Float64Array%": typeof Float64Array > "u" ? m : Float64Array,
  "%FinalizationRegistry%": typeof FinalizationRegistry > "u" ? m : FinalizationRegistry,
  "%Function%": Br,
  "%GeneratorFunction%": ae,
  "%Int8Array%": typeof Int8Array > "u" ? m : Int8Array,
  "%Int16Array%": typeof Int16Array > "u" ? m : Int16Array,
  "%Int32Array%": typeof Int32Array > "u" ? m : Int32Array,
  "%isFinite%": isFinite,
  "%isNaN%": isNaN,
  "%IteratorPrototype%": re && A ? A(A([][Symbol.iterator]())) : m,
  "%JSON%": typeof JSON == "object" ? JSON : m,
  "%Map%": typeof Map > "u" ? m : Map,
  "%MapIteratorPrototype%": typeof Map > "u" || !re || !A ? m : A((/* @__PURE__ */ new Map())[Symbol.iterator]()),
  "%Math%": Math,
  "%Number%": Number,
  "%Object%": ni,
  "%Object.getOwnPropertyDescriptor%": Ae,
  "%parseFloat%": parseFloat,
  "%parseInt%": parseInt,
  "%Promise%": typeof Promise > "u" ? m : Promise,
  "%Proxy%": typeof Proxy > "u" ? m : Proxy,
  "%RangeError%": oi,
  "%ReferenceError%": si,
  "%Reflect%": typeof Reflect > "u" ? m : Reflect,
  "%RegExp%": RegExp,
  "%Set%": typeof Set > "u" ? m : Set,
  "%SetIteratorPrototype%": typeof Set > "u" || !re || !A ? m : A((/* @__PURE__ */ new Set())[Symbol.iterator]()),
  "%SharedArrayBuffer%": typeof SharedArrayBuffer > "u" ? m : SharedArrayBuffer,
  "%String%": String,
  "%StringIteratorPrototype%": re && A ? A(""[Symbol.iterator]()) : m,
  "%Symbol%": re ? Symbol : m,
  "%SyntaxError%": ce,
  "%ThrowTypeError%": vi,
  "%TypedArray%": Si,
  "%TypeError%": ie,
  "%Uint8Array%": typeof Uint8Array > "u" ? m : Uint8Array,
  "%Uint8ClampedArray%": typeof Uint8ClampedArray > "u" ? m : Uint8ClampedArray,
  "%Uint16Array%": typeof Uint16Array > "u" ? m : Uint16Array,
  "%Uint32Array%": typeof Uint32Array > "u" ? m : Uint32Array,
  "%URIError%": li,
  "%WeakMap%": typeof WeakMap > "u" ? m : WeakMap,
  "%WeakRef%": typeof WeakRef > "u" ? m : WeakRef,
  "%WeakSet%": typeof WeakSet > "u" ? m : WeakSet,
  "%Function.prototype.call%": $e,
  "%Function.prototype.apply%": Hr,
  "%Object.defineProperty%": mi,
  "%Object.getPrototypeOf%": gi,
  "%Math.abs%": ci,
  "%Math.floor%": ui,
  "%Math.max%": pi,
  "%Math.min%": fi,
  "%Math.pow%": hi,
  "%Math.round%": di,
  "%Math.sign%": yi,
  "%Reflect.getPrototypeOf%": wi
};
if (A)
  try {
    null.error;
  } catch (t) {
    var bi = A(A(t));
    X["%Error.prototype%"] = bi;
  }
var Pi = function t(e) {
  var r;
  if (e === "%AsyncFunction%")
    r = ht("async function () {}");
  else if (e === "%GeneratorFunction%")
    r = ht("function* () {}");
  else if (e === "%AsyncGeneratorFunction%")
    r = ht("async function* () {}");
  else if (e === "%AsyncGenerator%") {
    var n = t("%AsyncGeneratorFunction%");
    n && (r = n.prototype);
  } else if (e === "%AsyncIteratorPrototype%") {
    var a = t("%AsyncGenerator%");
    a && A && (r = A(a.prototype));
  }
  return X[e] = r, r;
}, fr = {
  __proto__: null,
  "%ArrayBufferPrototype%": ["ArrayBuffer", "prototype"],
  "%ArrayPrototype%": ["Array", "prototype"],
  "%ArrayProto_entries%": ["Array", "prototype", "entries"],
  "%ArrayProto_forEach%": ["Array", "prototype", "forEach"],
  "%ArrayProto_keys%": ["Array", "prototype", "keys"],
  "%ArrayProto_values%": ["Array", "prototype", "values"],
  "%AsyncFunctionPrototype%": ["AsyncFunction", "prototype"],
  "%AsyncGenerator%": ["AsyncGeneratorFunction", "prototype"],
  "%AsyncGeneratorPrototype%": ["AsyncGeneratorFunction", "prototype", "prototype"],
  "%BooleanPrototype%": ["Boolean", "prototype"],
  "%DataViewPrototype%": ["DataView", "prototype"],
  "%DatePrototype%": ["Date", "prototype"],
  "%ErrorPrototype%": ["Error", "prototype"],
  "%EvalErrorPrototype%": ["EvalError", "prototype"],
  "%Float32ArrayPrototype%": ["Float32Array", "prototype"],
  "%Float64ArrayPrototype%": ["Float64Array", "prototype"],
  "%FunctionPrototype%": ["Function", "prototype"],
  "%Generator%": ["GeneratorFunction", "prototype"],
  "%GeneratorPrototype%": ["GeneratorFunction", "prototype", "prototype"],
  "%Int8ArrayPrototype%": ["Int8Array", "prototype"],
  "%Int16ArrayPrototype%": ["Int16Array", "prototype"],
  "%Int32ArrayPrototype%": ["Int32Array", "prototype"],
  "%JSONParse%": ["JSON", "parse"],
  "%JSONStringify%": ["JSON", "stringify"],
  "%MapPrototype%": ["Map", "prototype"],
  "%NumberPrototype%": ["Number", "prototype"],
  "%ObjectPrototype%": ["Object", "prototype"],
  "%ObjProto_toString%": ["Object", "prototype", "toString"],
  "%ObjProto_valueOf%": ["Object", "prototype", "valueOf"],
  "%PromisePrototype%": ["Promise", "prototype"],
  "%PromiseProto_then%": ["Promise", "prototype", "then"],
  "%Promise_all%": ["Promise", "all"],
  "%Promise_reject%": ["Promise", "reject"],
  "%Promise_resolve%": ["Promise", "resolve"],
  "%RangeErrorPrototype%": ["RangeError", "prototype"],
  "%ReferenceErrorPrototype%": ["ReferenceError", "prototype"],
  "%RegExpPrototype%": ["RegExp", "prototype"],
  "%SetPrototype%": ["Set", "prototype"],
  "%SharedArrayBufferPrototype%": ["SharedArrayBuffer", "prototype"],
  "%StringPrototype%": ["String", "prototype"],
  "%SymbolPrototype%": ["Symbol", "prototype"],
  "%SyntaxErrorPrototype%": ["SyntaxError", "prototype"],
  "%TypedArrayPrototype%": ["TypedArray", "prototype"],
  "%TypeErrorPrototype%": ["TypeError", "prototype"],
  "%Uint8ArrayPrototype%": ["Uint8Array", "prototype"],
  "%Uint8ClampedArrayPrototype%": ["Uint8ClampedArray", "prototype"],
  "%Uint16ArrayPrototype%": ["Uint16Array", "prototype"],
  "%Uint32ArrayPrototype%": ["Uint32Array", "prototype"],
  "%URIErrorPrototype%": ["URIError", "prototype"],
  "%WeakMapPrototype%": ["WeakMap", "prototype"],
  "%WeakSetPrototype%": ["WeakSet", "prototype"]
}, Re = Ke(), He = ri(), Ei = Re.call($e, Array.prototype.concat), Ai = Re.call(Hr, Array.prototype.splice), hr = Re.call($e, String.prototype.replace), je = Re.call($e, String.prototype.slice), Oi = Re.call($e, RegExp.prototype.exec), $i = /[^%.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|%$))/g, Ri = /\\(\\)?/g, Ii = function(e) {
  var r = je(e, 0, 1), n = je(e, -1);
  if (r === "%" && n !== "%")
    throw new ce("invalid intrinsic syntax, expected closing `%`");
  if (n === "%" && r !== "%")
    throw new ce("invalid intrinsic syntax, expected opening `%`");
  var a = [];
  return hr(e, $i, function(i, o, c, s) {
    a[a.length] = c ? hr(s, Ri, "$1") : o || i;
  }), a;
}, xi = function(e, r) {
  var n = e, a;
  if (He(fr, n) && (a = fr[n], n = "%" + a[0] + "%"), He(X, n)) {
    var i = X[n];
    if (i === ae && (i = Pi(n)), typeof i > "u" && !r)
      throw new ie("intrinsic " + e + " exists, but is not available. Please file an issue!");
    return {
      alias: a,
      name: n,
      value: i
    };
  }
  throw new ce("intrinsic " + e + " does not exist!");
}, Lt = function(e, r) {
  if (typeof e != "string" || e.length === 0)
    throw new ie("intrinsic name must be a non-empty string");
  if (arguments.length > 1 && typeof r != "boolean")
    throw new ie('"allowMissing" argument must be a boolean');
  if (Oi(/^%?[^%]*%?$/, e) === null)
    throw new ce("`%` may not be present anywhere but at the beginning and end of the intrinsic name");
  var n = Ii(e), a = n.length > 0 ? n[0] : "", i = xi("%" + a + "%", r), o = i.name, c = i.value, s = !1, l = i.alias;
  l && (a = l[0], Ai(n, Ei([0, 1], l)));
  for (var u = 1, f = !0; u < n.length; u += 1) {
    var p = n[u], y = je(p, 0, 1), h = je(p, -1);
    if ((y === '"' || y === "'" || y === "`" || h === '"' || h === "'" || h === "`") && y !== h)
      throw new ce("property names with quotes must have matching quotes");
    if ((p === "constructor" || !f) && (s = !0), a += "." + p, o = "%" + a + "%", He(X, o))
      c = X[o];
    else if (c != null) {
      if (!(p in c)) {
        if (!r)
          throw new ie("base intrinsic for " + e + " exists, but the property is not available.");
        return;
      }
      if (Ae && u + 1 >= n.length) {
        var w = Ae(c, p);
        f = !!w, f && "get" in w && !("originalValue" in w.get) ? c = w.get : c = c[p];
      } else
        f = He(c, p), c = c[p];
      f && !s && (X[o] = c);
    }
  }
  return c;
}, jr = Lt, Wr = Ur, Fi = Wr([jr("%String.prototype.indexOf%")]), Vr = function(e, r) {
  var n = (
    /** @type {(this: unknown, ...args: unknown[]) => unknown} */
    jr(e, !!r)
  );
  return typeof n == "function" && Fi(e, ".prototype.") > -1 ? Wr(
    /** @type {const} */
    [n]
  ) : n;
}, Ci = Lt, Ie = Vr, Ti = Ve, qi = pe, dr = Ci("%Map%", !0), Mi = Ie("Map.prototype.get", !0), Di = Ie("Map.prototype.set", !0), Li = Ie("Map.prototype.has", !0), Ni = Ie("Map.prototype.delete", !0), _i = Ie("Map.prototype.size", !0), Gr = !!dr && /** @type {Exclude<import('.'), false>} */
function() {
  var e, r = {
    assert: function(n) {
      if (!r.has(n))
        throw new qi("Side channel does not contain " + Ti(n));
    },
    delete: function(n) {
      if (e) {
        var a = Ni(e, n);
        return _i(e) === 0 && (e = void 0), a;
      }
      return !1;
    },
    get: function(n) {
      if (e)
        return Mi(e, n);
    },
    has: function(n) {
      return e ? Li(e, n) : !1;
    },
    set: function(n, a) {
      e || (e = new dr()), Di(e, n, a);
    }
  };
  return r;
}, ki = Lt, ze = Vr, Ui = Ve, Te = Gr, Bi = pe, ne = ki("%WeakMap%", !0), Hi = ze("WeakMap.prototype.get", !0), ji = ze("WeakMap.prototype.set", !0), Wi = ze("WeakMap.prototype.has", !0), Vi = ze("WeakMap.prototype.delete", !0), Gi = ne ? (
  /** @type {Exclude<import('.'), false>} */
  function() {
    var e, r, n = {
      assert: function(a) {
        if (!n.has(a))
          throw new Bi("Side channel does not contain " + Ui(a));
      },
      delete: function(a) {
        if (ne && a && (typeof a == "object" || typeof a == "function")) {
          if (e)
            return Vi(e, a);
        } else if (Te && r)
          return r.delete(a);
        return !1;
      },
      get: function(a) {
        return ne && a && (typeof a == "object" || typeof a == "function") && e ? Hi(e, a) : r && r.get(a);
      },
      has: function(a) {
        return ne && a && (typeof a == "object" || typeof a == "function") && e ? Wi(e, a) : !!r && r.has(a);
      },
      set: function(a, i) {
        ne && a && (typeof a == "object" || typeof a == "function") ? (e || (e = new ne()), ji(e, a, i)) : Te && (r || (r = Te()), r.set(a, i));
      }
    };
    return n;
  }
) : Te, Ki = pe, zi = Ve, Qi = Ea, Ji = Gr, Xi = Gi, Yi = Xi || Ji || Qi, Zi = function() {
  var e, r = {
    assert: function(n) {
      if (!r.has(n))
        throw new Ki("Side channel does not contain " + zi(n));
    },
    delete: function(n) {
      return !!e && e.delete(n);
    },
    get: function(n) {
      return e && e.get(n);
    },
    has: function(n) {
      return !!e && e.has(n);
    },
    set: function(n, a) {
      e || (e = Yi()), e.set(n, a);
    }
  };
  return r;
}, eo = String.prototype.replace, to = /%20/g, yt = {
  RFC1738: "RFC1738",
  RFC3986: "RFC3986"
}, Nt = {
  default: yt.RFC3986,
  formatters: {
    RFC1738: function(t) {
      return eo.call(t, to, "+");
    },
    RFC3986: function(t) {
      return String(t);
    }
  },
  RFC1738: yt.RFC1738,
  RFC3986: yt.RFC3986
}, ro = Nt, mt = Object.prototype.hasOwnProperty, Q = Array.isArray, M = function() {
  for (var t = [], e = 0; e < 256; ++e)
    t.push("%" + ((e < 16 ? "0" : "") + e.toString(16)).toUpperCase());
  return t;
}(), no = function(e) {
  for (; e.length > 1; ) {
    var r = e.pop(), n = r.obj[r.prop];
    if (Q(n)) {
      for (var a = [], i = 0; i < n.length; ++i)
        typeof n[i] < "u" && a.push(n[i]);
      r.obj[r.prop] = a;
    }
  }
}, Kr = function(e, r) {
  for (var n = r && r.plainObjects ? { __proto__: null } : {}, a = 0; a < e.length; ++a)
    typeof e[a] < "u" && (n[a] = e[a]);
  return n;
}, ao = function t(e, r, n) {
  if (!r)
    return e;
  if (typeof r != "object" && typeof r != "function") {
    if (Q(e))
      e.push(r);
    else if (e && typeof e == "object")
      (n && (n.plainObjects || n.allowPrototypes) || !mt.call(Object.prototype, r)) && (e[r] = !0);
    else
      return [e, r];
    return e;
  }
  if (!e || typeof e != "object")
    return [e].concat(r);
  var a = e;
  return Q(e) && !Q(r) && (a = Kr(e, n)), Q(e) && Q(r) ? (r.forEach(function(i, o) {
    if (mt.call(e, o)) {
      var c = e[o];
      c && typeof c == "object" && i && typeof i == "object" ? e[o] = t(c, i, n) : e.push(i);
    } else
      e[o] = i;
  }), e) : Object.keys(r).reduce(function(i, o) {
    var c = r[o];
    return mt.call(i, o) ? i[o] = t(i[o], c, n) : i[o] = c, i;
  }, a);
}, io = function(e, r) {
  return Object.keys(r).reduce(function(n, a) {
    return n[a] = r[a], n;
  }, e);
}, oo = function(t, e, r) {
  var n = t.replace(/\+/g, " ");
  if (r === "iso-8859-1")
    return n.replace(/%[0-9a-f]{2}/gi, unescape);
  try {
    return decodeURIComponent(n);
  } catch {
    return n;
  }
}, vt = 1024, so = function(e, r, n, a, i) {
  if (e.length === 0)
    return e;
  var o = e;
  if (typeof e == "symbol" ? o = Symbol.prototype.toString.call(e) : typeof e != "string" && (o = String(e)), n === "iso-8859-1")
    return escape(o).replace(/%u[0-9a-f]{4}/gi, function(y) {
      return "%26%23" + parseInt(y.slice(2), 16) + "%3B";
    });
  for (var c = "", s = 0; s < o.length; s += vt) {
    for (var l = o.length >= vt ? o.slice(s, s + vt) : o, u = [], f = 0; f < l.length; ++f) {
      var p = l.charCodeAt(f);
      if (p === 45 || p === 46 || p === 95 || p === 126 || p >= 48 && p <= 57 || p >= 65 && p <= 90 || p >= 97 && p <= 122 || i === ro.RFC1738 && (p === 40 || p === 41)) {
        u[u.length] = l.charAt(f);
        continue;
      }
      if (p < 128) {
        u[u.length] = M[p];
        continue;
      }
      if (p < 2048) {
        u[u.length] = M[192 | p >> 6] + M[128 | p & 63];
        continue;
      }
      if (p < 55296 || p >= 57344) {
        u[u.length] = M[224 | p >> 12] + M[128 | p >> 6 & 63] + M[128 | p & 63];
        continue;
      }
      f += 1, p = 65536 + ((p & 1023) << 10 | l.charCodeAt(f) & 1023), u[u.length] = M[240 | p >> 18] + M[128 | p >> 12 & 63] + M[128 | p >> 6 & 63] + M[128 | p & 63];
    }
    c += u.join("");
  }
  return c;
}, lo = function(e) {
  for (var r = [{ obj: { o: e }, prop: "o" }], n = [], a = 0; a < r.length; ++a)
    for (var i = r[a], o = i.obj[i.prop], c = Object.keys(o), s = 0; s < c.length; ++s) {
      var l = c[s], u = o[l];
      typeof u == "object" && u !== null && n.indexOf(u) === -1 && (r.push({ obj: o, prop: l }), n.push(u));
    }
  return no(r), e;
}, co = function(e) {
  return Object.prototype.toString.call(e) === "[object RegExp]";
}, uo = function(e) {
  return !e || typeof e != "object" ? !1 : !!(e.constructor && e.constructor.isBuffer && e.constructor.isBuffer(e));
}, po = function(e, r) {
  return [].concat(e, r);
}, fo = function(e, r) {
  if (Q(e)) {
    for (var n = [], a = 0; a < e.length; a += 1)
      n.push(r(e[a]));
    return n;
  }
  return r(e);
}, zr = {
  arrayToObject: Kr,
  assign: io,
  combine: po,
  compact: lo,
  decode: oo,
  encode: so,
  isBuffer: uo,
  isRegExp: co,
  maybeMap: fo,
  merge: ao
}, Qr = Zi, Ne = zr, be = Nt, ho = Object.prototype.hasOwnProperty, Jr = {
  brackets: function(e) {
    return e + "[]";
  },
  comma: "comma",
  indices: function(e, r) {
    return e + "[" + r + "]";
  },
  repeat: function(e) {
    return e;
  }
}, D = Array.isArray, yo = Array.prototype.push, Xr = function(t, e) {
  yo.apply(t, D(e) ? e : [e]);
}, mo = Date.prototype.toISOString, yr = be.default, E = {
  addQueryPrefix: !1,
  allowDots: !1,
  allowEmptyArrays: !1,
  arrayFormat: "indices",
  charset: "utf-8",
  charsetSentinel: !1,
  commaRoundTrip: !1,
  delimiter: "&",
  encode: !0,
  encodeDotInKeys: !1,
  encoder: Ne.encode,
  encodeValuesOnly: !1,
  filter: void 0,
  format: yr,
  formatter: be.formatters[yr],
  // deprecated
  indices: !1,
  serializeDate: function(e) {
    return mo.call(e);
  },
  skipNulls: !1,
  strictNullHandling: !1
}, vo = function(e) {
  return typeof e == "string" || typeof e == "number" || typeof e == "boolean" || typeof e == "symbol" || typeof e == "bigint";
}, gt = {}, go = function t(e, r, n, a, i, o, c, s, l, u, f, p, y, h, w, S, $, q) {
  for (var v = e, k = q, G = 0, fe = !1; (k = k.get(gt)) !== void 0 && !fe; ) {
    var ee = k.get(e);
    if (G += 1, typeof ee < "u") {
      if (ee === G)
        throw new RangeError("Cyclic object value");
      fe = !0;
    }
    typeof k.get(gt) > "u" && (G = 0);
  }
  if (typeof u == "function" ? v = u(r, v) : v instanceof Date ? v = y(v) : n === "comma" && D(v) && (v = Ne.maybeMap(v, function(Xe) {
    return Xe instanceof Date ? y(Xe) : Xe;
  })), v === null) {
    if (o)
      return l && !S ? l(r, E.encoder, $, "key", h) : r;
    v = "";
  }
  if (vo(v) || Ne.isBuffer(v)) {
    if (l) {
      var xe = S ? r : l(r, E.encoder, $, "key", h);
      return [w(xe) + "=" + w(l(v, E.encoder, $, "value", h))];
    }
    return [w(r) + "=" + w(String(v))];
  }
  var K = [];
  if (typeof v > "u")
    return K;
  var U;
  if (n === "comma" && D(v))
    S && l && (v = Ne.maybeMap(v, l)), U = [{ value: v.length > 0 ? v.join(",") || null : void 0 }];
  else if (D(u))
    U = u;
  else {
    var Fe = Object.keys(v);
    U = f ? Fe.sort(f) : Fe;
  }
  var te = s ? String(r).replace(/\./g, "%2E") : String(r), F = a && D(v) && v.length === 1 ? te + "[]" : te;
  if (i && D(v) && v.length === 0)
    return F + "[]";
  for (var B = 0; B < U.length; ++B) {
    var N = U[B], he = typeof N == "object" && N && typeof N.value < "u" ? N.value : v[N];
    if (!(c && he === null)) {
      var Je = p && s ? String(N).replace(/\./g, "%2E") : String(N), vn = D(v) ? typeof n == "function" ? n(F, Je) : F : F + (p ? "." + Je : "[" + Je + "]");
      q.set(e, G);
      var _t = Qr();
      _t.set(gt, q), Xr(K, t(
        he,
        vn,
        n,
        a,
        i,
        o,
        c,
        s,
        n === "comma" && S && D(v) ? null : l,
        u,
        f,
        p,
        y,
        h,
        w,
        S,
        $,
        _t
      ));
    }
  }
  return K;
}, wo = function(e) {
  if (!e)
    return E;
  if (typeof e.allowEmptyArrays < "u" && typeof e.allowEmptyArrays != "boolean")
    throw new TypeError("`allowEmptyArrays` option can only be `true` or `false`, when provided");
  if (typeof e.encodeDotInKeys < "u" && typeof e.encodeDotInKeys != "boolean")
    throw new TypeError("`encodeDotInKeys` option can only be `true` or `false`, when provided");
  if (e.encoder !== null && typeof e.encoder < "u" && typeof e.encoder != "function")
    throw new TypeError("Encoder has to be a function.");
  var r = e.charset || E.charset;
  if (typeof e.charset < "u" && e.charset !== "utf-8" && e.charset !== "iso-8859-1")
    throw new TypeError("The charset option must be either utf-8, iso-8859-1, or undefined");
  var n = be.default;
  if (typeof e.format < "u") {
    if (!ho.call(be.formatters, e.format))
      throw new TypeError("Unknown format option provided.");
    n = e.format;
  }
  var a = be.formatters[n], i = E.filter;
  (typeof e.filter == "function" || D(e.filter)) && (i = e.filter);
  var o;
  if (e.arrayFormat in Jr ? o = e.arrayFormat : "indices" in e ? o = e.indices ? "indices" : "repeat" : o = E.arrayFormat, "commaRoundTrip" in e && typeof e.commaRoundTrip != "boolean")
    throw new TypeError("`commaRoundTrip` must be a boolean, or absent");
  var c = typeof e.allowDots > "u" ? e.encodeDotInKeys === !0 ? !0 : E.allowDots : !!e.allowDots;
  return {
    addQueryPrefix: typeof e.addQueryPrefix == "boolean" ? e.addQueryPrefix : E.addQueryPrefix,
    allowDots: c,
    allowEmptyArrays: typeof e.allowEmptyArrays == "boolean" ? !!e.allowEmptyArrays : E.allowEmptyArrays,
    arrayFormat: o,
    charset: r,
    charsetSentinel: typeof e.charsetSentinel == "boolean" ? e.charsetSentinel : E.charsetSentinel,
    commaRoundTrip: !!e.commaRoundTrip,
    delimiter: typeof e.delimiter > "u" ? E.delimiter : e.delimiter,
    encode: typeof e.encode == "boolean" ? e.encode : E.encode,
    encodeDotInKeys: typeof e.encodeDotInKeys == "boolean" ? e.encodeDotInKeys : E.encodeDotInKeys,
    encoder: typeof e.encoder == "function" ? e.encoder : E.encoder,
    encodeValuesOnly: typeof e.encodeValuesOnly == "boolean" ? e.encodeValuesOnly : E.encodeValuesOnly,
    filter: i,
    format: n,
    formatter: a,
    serializeDate: typeof e.serializeDate == "function" ? e.serializeDate : E.serializeDate,
    skipNulls: typeof e.skipNulls == "boolean" ? e.skipNulls : E.skipNulls,
    sort: typeof e.sort == "function" ? e.sort : null,
    strictNullHandling: typeof e.strictNullHandling == "boolean" ? e.strictNullHandling : E.strictNullHandling
  };
}, So = function(t, e) {
  var r = t, n = wo(e), a, i;
  typeof n.filter == "function" ? (i = n.filter, r = i("", r)) : D(n.filter) && (i = n.filter, a = i);
  var o = [];
  if (typeof r != "object" || r === null)
    return "";
  var c = Jr[n.arrayFormat], s = c === "comma" && n.commaRoundTrip;
  a || (a = Object.keys(r)), n.sort && a.sort(n.sort);
  for (var l = Qr(), u = 0; u < a.length; ++u) {
    var f = a[u], p = r[f];
    n.skipNulls && p === null || Xr(o, go(
      p,
      f,
      c,
      s,
      n.allowEmptyArrays,
      n.strictNullHandling,
      n.skipNulls,
      n.encodeDotInKeys,
      n.encode ? n.encoder : null,
      n.filter,
      n.sort,
      n.allowDots,
      n.serializeDate,
      n.format,
      n.formatter,
      n.encodeValuesOnly,
      n.charset,
      l
    ));
  }
  var y = o.join(n.delimiter), h = n.addQueryPrefix === !0 ? "?" : "";
  return n.charsetSentinel && (n.charset === "iso-8859-1" ? h += "utf8=%26%2310003%3B&" : h += "utf8=%E2%9C%93&"), y.length > 0 ? h + y : "";
}, Y = zr, $t = Object.prototype.hasOwnProperty, mr = Array.isArray, b = {
  allowDots: !1,
  allowEmptyArrays: !1,
  allowPrototypes: !1,
  allowSparse: !1,
  arrayLimit: 20,
  charset: "utf-8",
  charsetSentinel: !1,
  comma: !1,
  decodeDotInKeys: !1,
  decoder: Y.decode,
  delimiter: "&",
  depth: 5,
  duplicates: "combine",
  ignoreQueryPrefix: !1,
  interpretNumericEntities: !1,
  parameterLimit: 1e3,
  parseArrays: !0,
  plainObjects: !1,
  strictDepth: !1,
  strictNullHandling: !1,
  throwOnLimitExceeded: !1
}, bo = function(t) {
  return t.replace(/&#(\d+);/g, function(e, r) {
    return String.fromCharCode(parseInt(r, 10));
  });
}, Yr = function(t, e, r) {
  if (t && typeof t == "string" && e.comma && t.indexOf(",") > -1)
    return t.split(",");
  if (e.throwOnLimitExceeded && r >= e.arrayLimit)
    throw new RangeError("Array limit exceeded. Only " + e.arrayLimit + " element" + (e.arrayLimit === 1 ? "" : "s") + " allowed in an array.");
  return t;
}, Po = "utf8=%26%2310003%3B", Eo = "utf8=%E2%9C%93", Ao = function(e, r) {
  var n = { __proto__: null }, a = r.ignoreQueryPrefix ? e.replace(/^\?/, "") : e;
  a = a.replace(/%5B/gi, "[").replace(/%5D/gi, "]");
  var i = r.parameterLimit === 1 / 0 ? void 0 : r.parameterLimit, o = a.split(
    r.delimiter,
    r.throwOnLimitExceeded ? i + 1 : i
  );
  if (r.throwOnLimitExceeded && o.length > i)
    throw new RangeError("Parameter limit exceeded. Only " + i + " parameter" + (i === 1 ? "" : "s") + " allowed.");
  var c = -1, s, l = r.charset;
  if (r.charsetSentinel)
    for (s = 0; s < o.length; ++s)
      o[s].indexOf("utf8=") === 0 && (o[s] === Eo ? l = "utf-8" : o[s] === Po && (l = "iso-8859-1"), c = s, s = o.length);
  for (s = 0; s < o.length; ++s)
    if (s !== c) {
      var u = o[s], f = u.indexOf("]="), p = f === -1 ? u.indexOf("=") : f + 1, y, h;
      p === -1 ? (y = r.decoder(u, b.decoder, l, "key"), h = r.strictNullHandling ? null : "") : (y = r.decoder(u.slice(0, p), b.decoder, l, "key"), h = Y.maybeMap(
        Yr(
          u.slice(p + 1),
          r,
          mr(n[y]) ? n[y].length : 0
        ),
        function(S) {
          return r.decoder(S, b.decoder, l, "value");
        }
      )), h && r.interpretNumericEntities && l === "iso-8859-1" && (h = bo(String(h))), u.indexOf("[]=") > -1 && (h = mr(h) ? [h] : h);
      var w = $t.call(n, y);
      w && r.duplicates === "combine" ? n[y] = Y.combine(n[y], h) : (!w || r.duplicates === "last") && (n[y] = h);
    }
  return n;
}, Oo = function(t, e, r, n) {
  var a = 0;
  if (t.length > 0 && t[t.length - 1] === "[]") {
    var i = t.slice(0, -1).join("");
    a = Array.isArray(e) && e[i] ? e[i].length : 0;
  }
  for (var o = n ? e : Yr(e, r, a), c = t.length - 1; c >= 0; --c) {
    var s, l = t[c];
    if (l === "[]" && r.parseArrays)
      s = r.allowEmptyArrays && (o === "" || r.strictNullHandling && o === null) ? [] : Y.combine([], o);
    else {
      s = r.plainObjects ? { __proto__: null } : {};
      var u = l.charAt(0) === "[" && l.charAt(l.length - 1) === "]" ? l.slice(1, -1) : l, f = r.decodeDotInKeys ? u.replace(/%2E/g, ".") : u, p = parseInt(f, 10);
      !r.parseArrays && f === "" ? s = { 0: o } : !isNaN(p) && l !== f && String(p) === f && p >= 0 && r.parseArrays && p <= r.arrayLimit ? (s = [], s[p] = o) : f !== "__proto__" && (s[f] = o);
    }
    o = s;
  }
  return o;
}, $o = function(e, r, n, a) {
  if (e) {
    var i = n.allowDots ? e.replace(/\.([^.[]+)/g, "[$1]") : e, o = /(\[[^[\]]*])/, c = /(\[[^[\]]*])/g, s = n.depth > 0 && o.exec(i), l = s ? i.slice(0, s.index) : i, u = [];
    if (l) {
      if (!n.plainObjects && $t.call(Object.prototype, l) && !n.allowPrototypes)
        return;
      u.push(l);
    }
    for (var f = 0; n.depth > 0 && (s = c.exec(i)) !== null && f < n.depth; ) {
      if (f += 1, !n.plainObjects && $t.call(Object.prototype, s[1].slice(1, -1)) && !n.allowPrototypes)
        return;
      u.push(s[1]);
    }
    if (s) {
      if (n.strictDepth === !0)
        throw new RangeError("Input depth exceeded depth option of " + n.depth + " and strictDepth is true");
      u.push("[" + i.slice(s.index) + "]");
    }
    return Oo(u, r, n, a);
  }
}, Ro = function(e) {
  if (!e)
    return b;
  if (typeof e.allowEmptyArrays < "u" && typeof e.allowEmptyArrays != "boolean")
    throw new TypeError("`allowEmptyArrays` option can only be `true` or `false`, when provided");
  if (typeof e.decodeDotInKeys < "u" && typeof e.decodeDotInKeys != "boolean")
    throw new TypeError("`decodeDotInKeys` option can only be `true` or `false`, when provided");
  if (e.decoder !== null && typeof e.decoder < "u" && typeof e.decoder != "function")
    throw new TypeError("Decoder has to be a function.");
  if (typeof e.charset < "u" && e.charset !== "utf-8" && e.charset !== "iso-8859-1")
    throw new TypeError("The charset option must be either utf-8, iso-8859-1, or undefined");
  if (typeof e.throwOnLimitExceeded < "u" && typeof e.throwOnLimitExceeded != "boolean")
    throw new TypeError("`throwOnLimitExceeded` option must be a boolean");
  var r = typeof e.charset > "u" ? b.charset : e.charset, n = typeof e.duplicates > "u" ? b.duplicates : e.duplicates;
  if (n !== "combine" && n !== "first" && n !== "last")
    throw new TypeError("The duplicates option must be either combine, first, or last");
  var a = typeof e.allowDots > "u" ? e.decodeDotInKeys === !0 ? !0 : b.allowDots : !!e.allowDots;
  return {
    allowDots: a,
    allowEmptyArrays: typeof e.allowEmptyArrays == "boolean" ? !!e.allowEmptyArrays : b.allowEmptyArrays,
    allowPrototypes: typeof e.allowPrototypes == "boolean" ? e.allowPrototypes : b.allowPrototypes,
    allowSparse: typeof e.allowSparse == "boolean" ? e.allowSparse : b.allowSparse,
    arrayLimit: typeof e.arrayLimit == "number" ? e.arrayLimit : b.arrayLimit,
    charset: r,
    charsetSentinel: typeof e.charsetSentinel == "boolean" ? e.charsetSentinel : b.charsetSentinel,
    comma: typeof e.comma == "boolean" ? e.comma : b.comma,
    decodeDotInKeys: typeof e.decodeDotInKeys == "boolean" ? e.decodeDotInKeys : b.decodeDotInKeys,
    decoder: typeof e.decoder == "function" ? e.decoder : b.decoder,
    delimiter: typeof e.delimiter == "string" || Y.isRegExp(e.delimiter) ? e.delimiter : b.delimiter,
    // eslint-disable-next-line no-implicit-coercion, no-extra-parens
    depth: typeof e.depth == "number" || e.depth === !1 ? +e.depth : b.depth,
    duplicates: n,
    ignoreQueryPrefix: e.ignoreQueryPrefix === !0,
    interpretNumericEntities: typeof e.interpretNumericEntities == "boolean" ? e.interpretNumericEntities : b.interpretNumericEntities,
    parameterLimit: typeof e.parameterLimit == "number" ? e.parameterLimit : b.parameterLimit,
    parseArrays: e.parseArrays !== !1,
    plainObjects: typeof e.plainObjects == "boolean" ? e.plainObjects : b.plainObjects,
    strictDepth: typeof e.strictDepth == "boolean" ? !!e.strictDepth : b.strictDepth,
    strictNullHandling: typeof e.strictNullHandling == "boolean" ? e.strictNullHandling : b.strictNullHandling,
    throwOnLimitExceeded: typeof e.throwOnLimitExceeded == "boolean" ? e.throwOnLimitExceeded : !1
  };
}, Io = function(t, e) {
  var r = Ro(e);
  if (t === "" || t === null || typeof t > "u")
    return r.plainObjects ? { __proto__: null } : {};
  for (var n = typeof t == "string" ? Ao(t, r) : t, a = r.plainObjects ? { __proto__: null } : {}, i = Object.keys(n), o = 0; o < i.length; ++o) {
    var c = i[o], s = $o(c, n[c], r, typeof t == "string");
    a = Y.merge(a, s, r);
  }
  return r.allowSparse === !0 ? a : Y.compact(a);
}, xo = So, Fo = Io, Co = Nt, vr = {
  formats: Co,
  parse: Fo,
  stringify: xo
};
function Rt(t, e) {
  let r;
  return function(...n) {
    clearTimeout(r), r = setTimeout(() => t.apply(this, n), e);
  };
}
function T(t, e) {
  return document.dispatchEvent(new CustomEvent(`inertia:${t}`, e));
}
var gr = (t) => T("before", { cancelable: !0, detail: { visit: t } }), To = (t) => T("error", { detail: { errors: t } }), qo = (t) => T("exception", { cancelable: !0, detail: { exception: t } }), Mo = (t) => T("finish", { detail: { visit: t } }), Do = (t) => T("invalid", { cancelable: !0, detail: { response: t } }), Pe = (t) => T("navigate", { detail: { page: t } }), Lo = (t) => T("progress", { detail: { progress: t } }), No = (t) => T("start", { detail: { visit: t } }), _o = (t) => T("success", { detail: { page: t } }), ko = (t, e) => T("prefetched", { detail: { fetchedAt: Date.now(), response: t.data, visit: e } }), Uo = (t) => T("prefetching", { detail: { visit: t } }), R = class {
  static set(t, e) {
    typeof window < "u" && window.sessionStorage.setItem(t, JSON.stringify(e));
  }
  static get(t) {
    if (typeof window < "u") return JSON.parse(window.sessionStorage.getItem(t) || "null");
  }
  static merge(t, e) {
    let r = this.get(t);
    r === null ? this.set(t, e) : this.set(t, { ...r, ...e });
  }
  static remove(t) {
    typeof window < "u" && window.sessionStorage.removeItem(t);
  }
  static removeNested(t, e) {
    let r = this.get(t);
    r !== null && (delete r[e], this.set(t, r));
  }
  static exists(t) {
    try {
      return this.get(t) !== null;
    } catch {
      return !1;
    }
  }
  static clear() {
    typeof window < "u" && window.sessionStorage.clear();
  }
};
R.locationVisitKey = "inertiaLocationVisit";
var Bo = async (t) => {
  if (typeof window > "u") throw new Error("Unable to encrypt history");
  let e = Zr(), r = await en(), n = await Ko(r);
  if (!n) throw new Error("Unable to encrypt history");
  return await jo(e, n, t);
}, ue = { key: "historyKey", iv: "historyIv" }, Ho = async (t) => {
  let e = Zr(), r = await en();
  if (!r) throw new Error("Unable to decrypt history");
  return await Wo(e, r, t);
}, jo = async (t, e, r) => {
  if (typeof window > "u") throw new Error("Unable to encrypt history");
  if (typeof window.crypto.subtle > "u") return console.warn("Encryption is not supported in this environment. SSL is required."), Promise.resolve(r);
  let n = new TextEncoder(), a = JSON.stringify(r), i = new Uint8Array(a.length * 3), o = n.encodeInto(a, i);
  return window.crypto.subtle.encrypt({ name: "AES-GCM", iv: t }, e, i.subarray(0, o.written));
}, Wo = async (t, e, r) => {
  if (typeof window.crypto.subtle > "u") return console.warn("Decryption is not supported in this environment. SSL is required."), Promise.resolve(r);
  let n = await window.crypto.subtle.decrypt({ name: "AES-GCM", iv: t }, e, r);
  return JSON.parse(new TextDecoder().decode(n));
}, Zr = () => {
  let t = R.get(ue.iv);
  if (t) return new Uint8Array(t);
  let e = window.crypto.getRandomValues(new Uint8Array(12));
  return R.set(ue.iv, Array.from(e)), e;
}, Vo = async () => typeof window.crypto.subtle > "u" ? (console.warn("Encryption is not supported in this environment. SSL is required."), Promise.resolve(null)) : window.crypto.subtle.generateKey({ name: "AES-GCM", length: 256 }, !0, ["encrypt", "decrypt"]), Go = async (t) => {
  if (typeof window.crypto.subtle > "u") return console.warn("Encryption is not supported in this environment. SSL is required."), Promise.resolve();
  let e = await window.crypto.subtle.exportKey("raw", t);
  R.set(ue.key, Array.from(new Uint8Array(e)));
}, Ko = async (t) => {
  if (t) return t;
  let e = await Vo();
  return e ? (await Go(e), e) : null;
}, en = async () => {
  let t = R.get(ue.key);
  return t ? await window.crypto.subtle.importKey("raw", new Uint8Array(t), { name: "AES-GCM", length: 256 }, !0, ["encrypt", "decrypt"]) : null;
}, C = class {
  static save() {
    g.saveScrollPositions(Array.from(this.regions()).map((t) => ({ top: t.scrollTop, left: t.scrollLeft })));
  }
  static regions() {
    return document.querySelectorAll("[scroll-region]");
  }
  static reset() {
    typeof window < "u" && window.scrollTo(0, 0), this.regions().forEach((t) => {
      typeof t.scrollTo == "function" ? t.scrollTo(0, 0) : (t.scrollTop = 0, t.scrollLeft = 0);
    }), this.save(), window.location.hash && setTimeout(() => {
      var t;
      return (t = document.getElementById(window.location.hash.slice(1))) == null ? void 0 : t.scrollIntoView();
    });
  }
  static restore(t) {
    this.restoreDocument(), this.regions().forEach((e, r) => {
      let n = t[r];
      n && (typeof e.scrollTo == "function" ? e.scrollTo(n.left, n.top) : (e.scrollTop = n.top, e.scrollLeft = n.left));
    });
  }
  static restoreDocument() {
    let t = g.getDocumentScrollPosition();
    typeof window < "u" && window.scrollTo(t.left, t.top);
  }
  static onScroll(t) {
    let e = t.target;
    typeof e.hasAttribute == "function" && e.hasAttribute("scroll-region") && this.save();
  }
  static onWindowScroll() {
    g.saveDocumentScrollPosition({ top: window.scrollY, left: window.scrollX });
  }
};
function It(t) {
  return t instanceof File || t instanceof Blob || t instanceof FileList && t.length > 0 || t instanceof FormData && Array.from(t.values()).some((e) => It(e)) || typeof t == "object" && t !== null && Object.values(t).some((e) => It(e));
}
var wr = (t) => t instanceof FormData;
function tn(t, e = new FormData(), r = null) {
  t = t || {};
  for (let n in t) Object.prototype.hasOwnProperty.call(t, n) && nn(e, rn(r, n), t[n]);
  return e;
}
function rn(t, e) {
  return t ? t + "[" + e + "]" : e;
}
function nn(t, e, r) {
  if (Array.isArray(r)) return Array.from(r.keys()).forEach((n) => nn(t, rn(e, n.toString()), r[n]));
  if (r instanceof Date) return t.append(e, r.toISOString());
  if (r instanceof File) return t.append(e, r, r.name);
  if (r instanceof Blob) return t.append(e, r);
  if (typeof r == "boolean") return t.append(e, r ? "1" : "0");
  if (typeof r == "string") return t.append(e, r);
  if (typeof r == "number") return t.append(e, `${r}`);
  if (r == null) return t.append(e, "");
  tn(r, t, e);
}
function j(t) {
  return new URL(t.toString(), typeof window > "u" ? void 0 : window.location.toString());
}
var zo = (t, e, r, n, a) => {
  let i = typeof t == "string" ? j(t) : t;
  if ((It(e) || n) && !wr(e) && (e = tn(e)), wr(e)) return [i, e];
  let [o, c] = Qo(r, i, e, a);
  return [j(o), c];
};
function Qo(t, e, r, n = "brackets") {
  let a = /^https?:\/\//.test(e.toString()), i = a || e.toString().startsWith("/"), o = !i && !e.toString().startsWith("#") && !e.toString().startsWith("?"), c = e.toString().includes("?") || t === "get" && Object.keys(r).length, s = e.toString().includes("#"), l = new URL(e.toString(), "http://localhost");
  return t === "get" && Object.keys(r).length && (l.search = vr.stringify(kn(vr.parse(l.search, { ignoreQueryPrefix: !0 }), r), { encodeValuesOnly: !0, arrayFormat: n }), r = {}), [[a ? `${l.protocol}//${l.host}` : "", i ? l.pathname : "", o ? l.pathname.substring(1) : "", c ? l.search : "", s ? l.hash : ""].join(""), r];
}
function We(t) {
  return t = new URL(t.href), t.hash = "", t;
}
var Sr = (t, e) => {
  t.hash && !e.hash && We(t).href === e.href && (e.hash = t.hash);
}, xt = (t, e) => We(t).href === We(e).href, Jo = class {
  constructor() {
    this.componentId = {}, this.listeners = [], this.isFirstPageLoad = !0, this.cleared = !1;
  }
  init({ initialPage: t, swapComponent: e, resolveComponent: r }) {
    return this.page = t, this.swapComponent = e, this.resolveComponent = r, this;
  }
  set(t, { replace: e = !1, preserveScroll: r = !1, preserveState: n = !1 } = {}) {
    this.componentId = {};
    let a = this.componentId;
    return t.clearHistory && g.clear(), this.resolve(t.component).then((i) => {
      if (a !== this.componentId) return;
      t.rememberedState ?? (t.rememberedState = {});
      let o = typeof window < "u" ? window.location : new URL(t.url);
      return e = e || xt(j(t.url), o), new Promise((c) => {
        e ? g.replaceState(t, () => c(null)) : g.pushState(t, () => c(null));
      }).then(() => {
        let c = !this.isTheSame(t);
        return this.page = t, this.cleared = !1, c && this.fireEventsFor("newComponent"), this.isFirstPageLoad && this.fireEventsFor("firstLoad"), this.isFirstPageLoad = !1, this.swap({ component: i, page: t, preserveState: n }).then(() => {
          r || C.reset(), J.fireInternalEvent("loadDeferredProps"), e || Pe(t);
        });
      });
    });
  }
  setQuietly(t, { preserveState: e = !1 } = {}) {
    return this.resolve(t.component).then((r) => (this.page = t, this.cleared = !1, g.setCurrent(t), this.swap({ component: r, page: t, preserveState: e })));
  }
  clear() {
    this.cleared = !0;
  }
  isCleared() {
    return this.cleared;
  }
  get() {
    return this.page;
  }
  merge(t) {
    this.page = { ...this.page, ...t };
  }
  setUrlHash(t) {
    this.page.url.includes(t) || (this.page.url += t);
  }
  remember(t) {
    this.page.rememberedState = t;
  }
  swap({ component: t, page: e, preserveState: r }) {
    return this.swapComponent({ component: t, page: e, preserveState: r });
  }
  resolve(t) {
    return Promise.resolve(this.resolveComponent(t));
  }
  isTheSame(t) {
    return this.page.component === t.component;
  }
  on(t, e) {
    return this.listeners.push({ event: t, callback: e }), () => {
      this.listeners = this.listeners.filter((r) => r.event !== t && r.callback !== e);
    };
  }
  fireEventsFor(t) {
    this.listeners.filter((e) => e.event === t).forEach((e) => e.callback());
  }
}, d = new Jo(), an = class {
  constructor() {
    this.items = [], this.processingPromise = null;
  }
  add(t) {
    return this.items.push(t), this.process();
  }
  process() {
    return this.processingPromise ?? (this.processingPromise = this.processNext().then(() => {
      this.processingPromise = null;
    })), this.processingPromise;
  }
  processNext() {
    let t = this.items.shift();
    return t ? Promise.resolve(t()).then(() => this.processNext()) : Promise.resolve();
  }
}, me = typeof window > "u", ye = new an(), br = !me && /CriOS/.test(window.navigator.userAgent), Xo = class {
  constructor() {
    this.rememberedState = "rememberedState", this.scrollRegions = "scrollRegions", this.preserveUrl = !1, this.current = {}, this.initialState = null;
  }
  remember(t, e) {
    var r;
    this.replaceState({ ...d.get(), rememberedState: { ...((r = d.get()) == null ? void 0 : r.rememberedState) ?? {}, [e]: t } });
  }
  restore(t) {
    var e, r;
    if (!me) return (r = (e = this.initialState) == null ? void 0 : e[this.rememberedState]) == null ? void 0 : r[t];
  }
  pushState(t, e = null) {
    if (!me) {
      if (this.preserveUrl) {
        e && e();
        return;
      }
      this.current = t, ye.add(() => this.getPageData(t).then((r) => {
        let n = () => {
          this.doPushState({ page: r }, t.url), e && e();
        };
        br ? setTimeout(n) : n();
      }));
    }
  }
  getPageData(t) {
    return new Promise((e) => t.encryptHistory ? Bo(t).then(e) : e(t));
  }
  processQueue() {
    return ye.process();
  }
  decrypt(t = null) {
    var r;
    if (me) return Promise.resolve(t ?? d.get());
    let e = t ?? ((r = window.history.state) == null ? void 0 : r.page);
    return this.decryptPageData(e).then((n) => {
      if (!n) throw new Error("Unable to decrypt history");
      return this.initialState === null ? this.initialState = n ?? void 0 : this.current = n ?? {}, n;
    });
  }
  decryptPageData(t) {
    return t instanceof ArrayBuffer ? Ho(t) : Promise.resolve(t);
  }
  saveScrollPositions(t) {
    ye.add(() => Promise.resolve().then(() => {
      var e;
      (e = window.history.state) != null && e.page && this.doReplaceState({ page: window.history.state.page, scrollRegions: t }, this.current.url);
    }));
  }
  saveDocumentScrollPosition(t) {
    ye.add(() => Promise.resolve().then(() => {
      var e;
      (e = window.history.state) != null && e.page && this.doReplaceState({ page: window.history.state.page, documentScrollPosition: t }, this.current.url);
    }));
  }
  getScrollRegions() {
    var t;
    return ((t = window.history.state) == null ? void 0 : t.scrollRegions) || [];
  }
  getDocumentScrollPosition() {
    var t;
    return ((t = window.history.state) == null ? void 0 : t.documentScrollPosition) || { top: 0, left: 0 };
  }
  replaceState(t, e = null) {
    if (d.merge(t), !me) {
      if (this.preserveUrl) {
        e && e();
        return;
      }
      this.current = t, ye.add(() => this.getPageData(t).then((r) => {
        let n = () => {
          this.doReplaceState({ page: r }, t.url), e && e();
        };
        br ? setTimeout(n) : n();
      }));
    }
  }
  doReplaceState(t, e) {
    var r, n;
    window.history.replaceState({ ...t, scrollRegions: t.scrollRegions ?? ((r = window.history.state) == null ? void 0 : r.scrollRegions), documentScrollPosition: t.documentScrollPosition ?? ((n = window.history.state) == null ? void 0 : n.documentScrollPosition) }, "", e);
  }
  doPushState(t, e) {
    window.history.pushState(t, "", e);
  }
  getState(t, e) {
    var r;
    return ((r = this.current) == null ? void 0 : r[t]) ?? e;
  }
  deleteState(t) {
    this.current[t] !== void 0 && (delete this.current[t], this.replaceState(this.current));
  }
  hasAnyState() {
    return !!this.getAllState();
  }
  clear() {
    R.remove(ue.key), R.remove(ue.iv);
  }
  setCurrent(t) {
    this.current = t;
  }
  isValidState(t) {
    return !!t.page;
  }
  getAllState() {
    return this.current;
  }
};
typeof window < "u" && window.history.scrollRestoration && (window.history.scrollRestoration = "manual");
var g = new Xo(), Yo = class {
  constructor() {
    this.internalListeners = [];
  }
  init() {
    typeof window < "u" && (window.addEventListener("popstate", this.handlePopstateEvent.bind(this)), window.addEventListener("scroll", Rt(C.onWindowScroll.bind(C), 100), !0)), typeof document < "u" && document.addEventListener("scroll", Rt(C.onScroll.bind(C), 100), !0);
  }
  onGlobalEvent(t, e) {
    let r = (n) => {
      let a = e(n);
      n.cancelable && !n.defaultPrevented && a === !1 && n.preventDefault();
    };
    return this.registerListener(`inertia:${t}`, r);
  }
  on(t, e) {
    return this.internalListeners.push({ event: t, listener: e }), () => {
      this.internalListeners = this.internalListeners.filter((r) => r.listener !== e);
    };
  }
  onMissingHistoryItem() {
    d.clear(), this.fireInternalEvent("missingHistoryItem");
  }
  fireInternalEvent(t) {
    this.internalListeners.filter((e) => e.event === t).forEach((e) => e.listener());
  }
  registerListener(t, e) {
    return document.addEventListener(t, e), () => document.removeEventListener(t, e);
  }
  handlePopstateEvent(t) {
    let e = t.state || null;
    if (e === null) {
      let r = j(d.get().url);
      r.hash = window.location.hash, g.replaceState({ ...d.get(), url: r.href }), C.reset();
      return;
    }
    if (!g.isValidState(e)) return this.onMissingHistoryItem();
    g.decrypt(e.page).then((r) => {
      d.setQuietly(r, { preserveState: !1 }).then(() => {
        C.restore(g.getScrollRegions()), Pe(d.get());
      });
    }).catch(() => {
      this.onMissingHistoryItem();
    });
  }
}, J = new Yo(), Zo = class {
  constructor() {
    this.type = this.resolveType();
  }
  resolveType() {
    return typeof window > "u" ? "navigate" : window.performance && window.performance.getEntriesByType && window.performance.getEntriesByType("navigation").length > 0 ? window.performance.getEntriesByType("navigation")[0].type : "navigate";
  }
  get() {
    return this.type;
  }
  isBackForward() {
    return this.type === "back_forward";
  }
  isReload() {
    return this.type === "reload";
  }
}, wt = new Zo(), es = class {
  static handle() {
    this.clearRememberedStateOnReload(), [this.handleBackForward, this.handleLocation, this.handleDefault].find((t) => t.bind(this)());
  }
  static clearRememberedStateOnReload() {
    wt.isReload() && g.deleteState(g.rememberedState);
  }
  static handleBackForward() {
    if (!wt.isBackForward() || !g.hasAnyState()) return !1;
    let t = g.getScrollRegions();
    return g.decrypt().then((e) => {
      d.set(e, { preserveScroll: !0, preserveState: !0 }).then(() => {
        C.restore(t), Pe(d.get());
      });
    }).catch(() => {
      J.onMissingHistoryItem();
    }), !0;
  }
  static handleLocation() {
    if (!R.exists(R.locationVisitKey)) return !1;
    let t = R.get(R.locationVisitKey) || {};
    return R.remove(R.locationVisitKey), typeof window < "u" && d.setUrlHash(window.location.hash), g.decrypt().then(() => {
      let e = g.getState(g.rememberedState, {}), r = g.getScrollRegions();
      d.remember(e), d.set(d.get(), { preserveScroll: t.preserveScroll, preserveState: !0 }).then(() => {
        t.preserveScroll && C.restore(r), Pe(d.get());
      });
    }).catch(() => {
      J.onMissingHistoryItem();
    }), !0;
  }
  static handleDefault() {
    typeof window < "u" && d.setUrlHash(window.location.hash), d.set(d.get(), { preserveScroll: !0, preserveState: !0 }).then(() => {
      wt.isReload() && C.restore(g.getScrollRegions()), Pe(d.get());
    });
  }
}, ts = class {
  constructor(t, e, r) {
    this.id = null, this.throttle = !1, this.keepAlive = !1, this.cbCount = 0, this.keepAlive = r.keepAlive ?? !1, this.cb = e, this.interval = t, (r.autoStart ?? !0) && this.start();
  }
  stop() {
    this.id && clearInterval(this.id);
  }
  start() {
    typeof window > "u" || (this.stop(), this.id = window.setInterval(() => {
      (!this.throttle || this.cbCount % 10 === 0) && this.cb(), this.throttle && this.cbCount++;
    }, this.interval));
  }
  isInBackground(t) {
    this.throttle = this.keepAlive ? !1 : t, this.throttle && (this.cbCount = 0);
  }
}, rs = class {
  constructor() {
    this.polls = [], this.setupVisibilityListener();
  }
  add(t, e, r) {
    let n = new ts(t, e, r);
    return this.polls.push(n), { stop: () => n.stop(), start: () => n.start() };
  }
  clear() {
    this.polls.forEach((t) => t.stop()), this.polls = [];
  }
  setupVisibilityListener() {
    typeof document > "u" || document.addEventListener("visibilitychange", () => {
      this.polls.forEach((t) => t.isInBackground(document.hidden));
    }, !1);
  }
}, ns = new rs(), on = (t, e, r) => {
  if (t === e) return !0;
  for (let n in t) if (!r.includes(n) && t[n] !== e[n] && !as(t[n], e[n])) return !1;
  return !0;
}, as = (t, e) => {
  switch (typeof t) {
    case "object":
      return on(t, e, []);
    case "function":
      return t.toString() === e.toString();
    default:
      return t === e;
  }
}, is = { ms: 1, s: 1e3, m: 6e4, h: 36e5, d: 864e5 }, Pr = (t) => {
  if (typeof t == "number") return t;
  for (let [e, r] of Object.entries(is)) if (t.endsWith(e)) return parseFloat(t) * r;
  return parseInt(t);
}, os = class {
  constructor() {
    this.cached = [], this.inFlightRequests = [], this.removalTimers = [], this.currentUseId = null;
  }
  add(t, e, { cacheFor: r }) {
    if (this.findInFlight(t)) return Promise.resolve();
    let n = this.findCached(t);
    if (!t.fresh && n && n.staleTimestamp > Date.now()) return Promise.resolve();
    let [a, i] = this.extractStaleValues(r), o = new Promise((c, s) => {
      e({ ...t, onCancel: () => {
        this.remove(t), t.onCancel(), s();
      }, onError: (l) => {
        this.remove(t), t.onError(l), s();
      }, onPrefetching(l) {
        t.onPrefetching(l);
      }, onPrefetched(l, u) {
        t.onPrefetched(l, u);
      }, onPrefetchResponse(l) {
        c(l);
      } });
    }).then((c) => (this.remove(t), this.cached.push({ params: { ...t }, staleTimestamp: Date.now() + a, response: o, singleUse: r === 0, timestamp: Date.now(), inFlight: !1 }), this.scheduleForRemoval(t, i), this.inFlightRequests = this.inFlightRequests.filter((s) => !this.paramsAreEqual(s.params, t)), c.handlePrefetch(), c));
    return this.inFlightRequests.push({ params: { ...t }, response: o, staleTimestamp: null, inFlight: !0 }), o;
  }
  removeAll() {
    this.cached = [], this.removalTimers.forEach((t) => {
      clearTimeout(t.timer);
    }), this.removalTimers = [];
  }
  remove(t) {
    this.cached = this.cached.filter((e) => !this.paramsAreEqual(e.params, t)), this.clearTimer(t);
  }
  extractStaleValues(t) {
    let [e, r] = this.cacheForToStaleAndExpires(t);
    return [Pr(e), Pr(r)];
  }
  cacheForToStaleAndExpires(t) {
    if (!Array.isArray(t)) return [t, t];
    switch (t.length) {
      case 0:
        return [0, 0];
      case 1:
        return [t[0], t[0]];
      default:
        return [t[0], t[1]];
    }
  }
  clearTimer(t) {
    let e = this.removalTimers.find((r) => this.paramsAreEqual(r.params, t));
    e && (clearTimeout(e.timer), this.removalTimers = this.removalTimers.filter((r) => r !== e));
  }
  scheduleForRemoval(t, e) {
    if (!(typeof window > "u") && (this.clearTimer(t), e > 0)) {
      let r = window.setTimeout(() => this.remove(t), e);
      this.removalTimers.push({ params: t, timer: r });
    }
  }
  get(t) {
    return this.findCached(t) || this.findInFlight(t);
  }
  use(t, e) {
    let r = `${e.url.pathname}-${Date.now()}-${Math.random().toString(36).substring(7)}`;
    return this.currentUseId = r, t.response.then((n) => {
      if (this.currentUseId === r) return n.mergeParams({ ...e, onPrefetched: () => {
      } }), this.removeSingleUseItems(e), n.handle();
    });
  }
  removeSingleUseItems(t) {
    this.cached = this.cached.filter((e) => this.paramsAreEqual(e.params, t) ? !e.singleUse : !0);
  }
  findCached(t) {
    return this.cached.find((e) => this.paramsAreEqual(e.params, t)) || null;
  }
  findInFlight(t) {
    return this.inFlightRequests.find((e) => this.paramsAreEqual(e.params, t)) || null;
  }
  paramsAreEqual(t, e) {
    return on(t, e, ["showProgress", "replace", "prefetch", "onBefore", "onStart", "onProgress", "onFinish", "onCancel", "onSuccess", "onError", "onPrefetched", "onCancelToken", "onPrefetching", "async"]);
  }
}, z = new os(), ss = class sn {
  constructor(e) {
    if (this.callbacks = [], !e.prefetch) this.params = e;
    else {
      let r = { onBefore: this.wrapCallback(e, "onBefore"), onStart: this.wrapCallback(e, "onStart"), onProgress: this.wrapCallback(e, "onProgress"), onFinish: this.wrapCallback(e, "onFinish"), onCancel: this.wrapCallback(e, "onCancel"), onSuccess: this.wrapCallback(e, "onSuccess"), onError: this.wrapCallback(e, "onError"), onCancelToken: this.wrapCallback(e, "onCancelToken"), onPrefetched: this.wrapCallback(e, "onPrefetched"), onPrefetching: this.wrapCallback(e, "onPrefetching") };
      this.params = { ...e, ...r, onPrefetchResponse: e.onPrefetchResponse || (() => {
      }) };
    }
  }
  static create(e) {
    return new sn(e);
  }
  data() {
    return this.params.method === "get" ? {} : this.params.data;
  }
  queryParams() {
    return this.params.method === "get" ? this.params.data : {};
  }
  isPartial() {
    return this.params.only.length > 0 || this.params.except.length > 0 || this.params.reset.length > 0;
  }
  onCancelToken(e) {
    this.params.onCancelToken({ cancel: e });
  }
  markAsFinished() {
    this.params.completed = !0, this.params.cancelled = !1, this.params.interrupted = !1;
  }
  markAsCancelled({ cancelled: e = !0, interrupted: r = !1 }) {
    this.params.onCancel(), this.params.completed = !1, this.params.cancelled = e, this.params.interrupted = r;
  }
  wasCancelledAtAll() {
    return this.params.cancelled || this.params.interrupted;
  }
  onFinish() {
    this.params.onFinish(this.params);
  }
  onStart() {
    this.params.onStart(this.params);
  }
  onPrefetching() {
    this.params.onPrefetching(this.params);
  }
  onPrefetchResponse(e) {
    this.params.onPrefetchResponse && this.params.onPrefetchResponse(e);
  }
  all() {
    return this.params;
  }
  headers() {
    let e = { ...this.params.headers };
    this.isPartial() && (e["X-Inertia-Partial-Component"] = d.get().component);
    let r = this.params.only.concat(this.params.reset);
    return r.length > 0 && (e["X-Inertia-Partial-Data"] = r.join(",")), this.params.except.length > 0 && (e["X-Inertia-Partial-Except"] = this.params.except.join(",")), this.params.reset.length > 0 && (e["X-Inertia-Reset"] = this.params.reset.join(",")), this.params.errorBag && this.params.errorBag.length > 0 && (e["X-Inertia-Error-Bag"] = this.params.errorBag), e;
  }
  setPreserveOptions(e) {
    this.params.preserveScroll = this.resolvePreserveOption(this.params.preserveScroll, e), this.params.preserveState = this.resolvePreserveOption(this.params.preserveState, e);
  }
  runCallbacks() {
    this.callbacks.forEach(({ name: e, args: r }) => {
      this.params[e](...r);
    });
  }
  merge(e) {
    this.params = { ...this.params, ...e };
  }
  wrapCallback(e, r) {
    return (...n) => {
      this.recordCallback(r, n), e[r](...n);
    };
  }
  recordCallback(e, r) {
    this.callbacks.push({ name: e, args: r });
  }
  resolvePreserveOption(e, r) {
    return typeof e == "function" ? e(r) : e === "errors" ? Object.keys(r.props.errors || {}).length > 0 : e;
  }
}, ls = { modal: null, listener: null, show(t) {
  typeof t == "object" && (t = `All Inertia requests must receive a valid Inertia response, however a plain JSON response was received.<hr>${JSON.stringify(t)}`);
  let e = document.createElement("html");
  e.innerHTML = t, e.querySelectorAll("a").forEach((n) => n.setAttribute("target", "_top")), this.modal = document.createElement("div"), this.modal.style.position = "fixed", this.modal.style.width = "100vw", this.modal.style.height = "100vh", this.modal.style.padding = "50px", this.modal.style.boxSizing = "border-box", this.modal.style.backgroundColor = "rgba(0, 0, 0, .6)", this.modal.style.zIndex = 2e5, this.modal.addEventListener("click", () => this.hide());
  let r = document.createElement("iframe");
  if (r.style.backgroundColor = "white", r.style.borderRadius = "5px", r.style.width = "100%", r.style.height = "100%", this.modal.appendChild(r), document.body.prepend(this.modal), document.body.style.overflow = "hidden", !r.contentWindow) throw new Error("iframe not yet ready.");
  r.contentWindow.document.open(), r.contentWindow.document.write(e.outerHTML), r.contentWindow.document.close(), this.listener = this.hideOnEscape.bind(this), document.addEventListener("keydown", this.listener);
}, hide() {
  this.modal.outerHTML = "", this.modal = null, document.body.style.overflow = "visible", document.removeEventListener("keydown", this.listener);
}, hideOnEscape(t) {
  t.keyCode === 27 && this.hide();
} }, cs = new an(), Er = class ln {
  constructor(e, r, n) {
    this.requestParams = e, this.response = r, this.originatingPage = n;
  }
  static create(e, r, n) {
    return new ln(e, r, n);
  }
  async handlePrefetch() {
    xt(this.requestParams.all().url, window.location) && this.handle();
  }
  async handle() {
    return cs.add(() => this.process());
  }
  async process() {
    if (this.requestParams.all().prefetch) return this.requestParams.all().prefetch = !1, this.requestParams.all().onPrefetched(this.response, this.requestParams.all()), ko(this.response, this.requestParams.all()), Promise.resolve();
    if (this.requestParams.runCallbacks(), !this.isInertiaResponse()) return this.handleNonInertiaResponse();
    await g.processQueue(), g.preserveUrl = this.requestParams.all().preserveUrl, await this.setPage();
    let e = d.get().props.errors || {};
    if (Object.keys(e).length > 0) {
      let r = this.getScopedErrors(e);
      return To(r), this.requestParams.all().onError(r);
    }
    _o(d.get()), await this.requestParams.all().onSuccess(d.get()), g.preserveUrl = !1;
  }
  mergeParams(e) {
    this.requestParams.merge(e);
  }
  async handleNonInertiaResponse() {
    if (this.isLocationVisit()) {
      let r = j(this.getHeader("x-inertia-location"));
      return Sr(this.requestParams.all().url, r), this.locationVisit(r);
    }
    let e = { ...this.response, data: this.getDataFromResponse(this.response.data) };
    if (Do(e)) return ls.show(e.data);
  }
  isInertiaResponse() {
    return this.hasHeader("x-inertia");
  }
  hasStatus(e) {
    return this.response.status === e;
  }
  getHeader(e) {
    return this.response.headers[e];
  }
  hasHeader(e) {
    return this.getHeader(e) !== void 0;
  }
  isLocationVisit() {
    return this.hasStatus(409) && this.hasHeader("x-inertia-location");
  }
  locationVisit(e) {
    try {
      if (R.set(R.locationVisitKey, { preserveScroll: this.requestParams.all().preserveScroll === !0 }), typeof window > "u") return;
      xt(window.location, e) ? window.location.reload() : window.location.href = e.href;
    } catch {
      return !1;
    }
  }
  async setPage() {
    let e = this.getDataFromResponse(this.response.data);
    return this.shouldSetPage(e) ? (this.mergeProps(e), await this.setRememberedState(e), this.requestParams.setPreserveOptions(e), e.url = g.preserveUrl ? d.get().url : this.pageUrl(e), d.set(e, { replace: this.requestParams.all().replace, preserveScroll: this.requestParams.all().preserveScroll, preserveState: this.requestParams.all().preserveState })) : Promise.resolve();
  }
  getDataFromResponse(e) {
    if (typeof e != "string") return e;
    try {
      return JSON.parse(e);
    } catch {
      return e;
    }
  }
  shouldSetPage(e) {
    if (!this.requestParams.all().async || this.originatingPage.component !== e.component) return !0;
    if (this.originatingPage.component !== d.get().component) return !1;
    let r = j(this.originatingPage.url), n = j(d.get().url);
    return r.origin === n.origin && r.pathname === n.pathname;
  }
  pageUrl(e) {
    let r = j(e.url);
    return Sr(this.requestParams.all().url, r), r.pathname + r.search + r.hash;
  }
  mergeProps(e) {
    this.requestParams.isPartial() && e.component === d.get().component && ((e.mergeProps || []).forEach((r) => {
      let n = e.props[r];
      Array.isArray(n) ? e.props[r] = [...d.get().props[r] || [], ...n] : typeof n == "object" && (e.props[r] = { ...d.get().props[r] || [], ...n });
    }), e.props = { ...d.get().props, ...e.props });
  }
  async setRememberedState(e) {
    let r = await g.getState(g.rememberedState, {});
    this.requestParams.all().preserveState && r && e.component === d.get().component && (e.rememberedState = r);
  }
  getScopedErrors(e) {
    return this.requestParams.all().errorBag ? e[this.requestParams.all().errorBag || ""] || {} : e;
  }
}, Ar = class cn {
  constructor(e, r) {
    this.page = r, this.requestHasFinished = !1, this.requestParams = ss.create(e), this.cancelToken = new AbortController();
  }
  static create(e, r) {
    return new cn(e, r);
  }
  async send() {
    this.requestParams.onCancelToken(() => this.cancel({ cancelled: !0 })), No(this.requestParams.all()), this.requestParams.onStart(), this.requestParams.all().prefetch && (this.requestParams.onPrefetching(), Uo(this.requestParams.all()));
    let e = this.requestParams.all().prefetch;
    return kt({ method: this.requestParams.all().method, url: We(this.requestParams.all().url).href, data: this.requestParams.data(), params: this.requestParams.queryParams(), signal: this.cancelToken.signal, headers: this.getHeaders(), onUploadProgress: this.onProgress.bind(this), responseType: "text" }).then((r) => (this.response = Er.create(this.requestParams, r, this.page), this.response.handle())).catch((r) => r != null && r.response ? (this.response = Er.create(this.requestParams, r.response, this.page), this.response.handle()) : Promise.reject(r)).catch((r) => {
      if (!kt.isCancel(r) && qo(r)) return Promise.reject(r);
    }).finally(() => {
      this.finish(), e && this.response && this.requestParams.onPrefetchResponse(this.response);
    });
  }
  finish() {
    this.requestParams.wasCancelledAtAll() || (this.requestParams.markAsFinished(), this.fireFinishEvents());
  }
  fireFinishEvents() {
    this.requestHasFinished || (this.requestHasFinished = !0, Mo(this.requestParams.all()), this.requestParams.onFinish());
  }
  cancel({ cancelled: e = !1, interrupted: r = !1 }) {
    this.requestHasFinished || (this.cancelToken.abort(), this.requestParams.markAsCancelled({ cancelled: e, interrupted: r }), this.fireFinishEvents());
  }
  onProgress(e) {
    this.requestParams.data() instanceof FormData && (e.percentage = e.progress ? Math.round(e.progress * 100) : 0, Lo(e), this.requestParams.all().onProgress(e));
  }
  getHeaders() {
    let e = { ...this.requestParams.headers(), Accept: "text/html, application/xhtml+xml", "X-Requested-With": "XMLHttpRequest", "X-Inertia": !0 };
    return d.get().version && (e["X-Inertia-Version"] = d.get().version), e;
  }
}, Or = class {
  constructor({ maxConcurrent: t, interruptible: e }) {
    this.requests = [], this.maxConcurrent = t, this.interruptible = e;
  }
  send(t) {
    this.requests.push(t), t.send().then(() => {
      this.requests = this.requests.filter((e) => e !== t);
    });
  }
  interruptInFlight() {
    this.cancel({ interrupted: !0 }, !1);
  }
  cancelInFlight() {
    this.cancel({ cancelled: !0 }, !0);
  }
  cancel({ cancelled: t = !1, interrupted: e = !1 } = {}, r) {
    var n;
    this.shouldCancel(r) && ((n = this.requests.shift()) == null || n.cancel({ interrupted: e, cancelled: t }));
  }
  shouldCancel(t) {
    return t ? !0 : this.interruptible && this.requests.length >= this.maxConcurrent;
  }
}, us = class {
  constructor() {
    this.syncRequestStream = new Or({ maxConcurrent: 1, interruptible: !0 }), this.asyncRequestStream = new Or({ maxConcurrent: 1 / 0, interruptible: !1 });
  }
  init({ initialPage: t, resolveComponent: e, swapComponent: r }) {
    d.init({ initialPage: t, resolveComponent: e, swapComponent: r }), es.handle(), J.init(), J.on("missingHistoryItem", () => {
      typeof window < "u" && this.visit(window.location.href, { preserveState: !0, preserveScroll: !0, replace: !0 });
    }), J.on("loadDeferredProps", () => {
      this.loadDeferredProps();
    });
  }
  get(t, e = {}, r = {}) {
    return this.visit(t, { ...r, method: "get", data: e });
  }
  post(t, e = {}, r = {}) {
    return this.visit(t, { preserveState: !0, ...r, method: "post", data: e });
  }
  put(t, e = {}, r = {}) {
    return this.visit(t, { preserveState: !0, ...r, method: "put", data: e });
  }
  patch(t, e = {}, r = {}) {
    return this.visit(t, { preserveState: !0, ...r, method: "patch", data: e });
  }
  delete(t, e = {}) {
    return this.visit(t, { preserveState: !0, ...e, method: "delete" });
  }
  reload(t = {}) {
    if (!(typeof window > "u")) return this.visit(window.location.href, { ...t, preserveScroll: !0, preserveState: !0, async: !0, headers: { ...t.headers || {}, "Cache-Control": "no-cache" } });
  }
  remember(t, e = "default") {
    g.remember(t, e);
  }
  restore(t = "default") {
    return g.restore(t);
  }
  on(t, e) {
    return typeof window > "u" ? () => {
    } : J.onGlobalEvent(t, e);
  }
  cancel() {
    this.syncRequestStream.cancelInFlight();
  }
  cancelAll() {
    this.asyncRequestStream.cancelInFlight(), this.syncRequestStream.cancelInFlight();
  }
  poll(t, e = {}, r = {}) {
    return ns.add(t, () => this.reload(e), { autoStart: r.autoStart ?? !0, keepAlive: r.keepAlive ?? !1 });
  }
  visit(t, e = {}) {
    let r = this.getPendingVisit(t, { ...e, showProgress: e.showProgress ?? !e.async }), n = this.getVisitEvents(e);
    if (n.onBefore(r) === !1 || !gr(r)) return;
    let a = r.async ? this.asyncRequestStream : this.syncRequestStream;
    a.interruptInFlight(), !d.isCleared() && !r.preserveUrl && C.save();
    let i = { ...r, ...n }, o = z.get(i);
    o ? ($r(o.inFlight), z.use(o, i)) : ($r(!0), a.send(Ar.create(i, d.get())));
  }
  getCached(t, e = {}) {
    return z.findCached(this.getPrefetchParams(t, e));
  }
  flush(t, e = {}) {
    z.remove(this.getPrefetchParams(t, e));
  }
  flushAll() {
    z.removeAll();
  }
  getPrefetching(t, e = {}) {
    return z.findInFlight(this.getPrefetchParams(t, e));
  }
  prefetch(t, e = {}, { cacheFor: r = 3e4 }) {
    if (e.method !== "get") throw new Error("Prefetch requests must use the GET method");
    let n = this.getPendingVisit(t, { ...e, async: !0, showProgress: !1, prefetch: !0 }), a = n.url.origin + n.url.pathname + n.url.search, i = window.location.origin + window.location.pathname + window.location.search;
    if (a === i) return;
    let o = this.getVisitEvents(e);
    if (o.onBefore(n) === !1 || !gr(n)) return;
    mn(), this.asyncRequestStream.interruptInFlight();
    let c = { ...n, ...o };
    new Promise((s) => {
      let l = () => {
        d.get() ? s() : setTimeout(l, 50);
      };
      l();
    }).then(() => {
      z.add(c, (s) => {
        this.asyncRequestStream.send(Ar.create(s, d.get()));
      }, { cacheFor: r });
    });
  }
  clearHistory() {
    g.clear();
  }
  decryptHistory() {
    return g.decrypt();
  }
  replace(t) {
    this.clientVisit(t, { replace: !0 });
  }
  push(t) {
    this.clientVisit(t);
  }
  clientVisit(t, { replace: e = !1 } = {}) {
    let r = d.get(), n = typeof t.props == "function" ? t.props(r.props) : t.props ?? r.props;
    d.set({ ...r, ...t, props: n }, { replace: e, preserveScroll: t.preserveScroll, preserveState: t.preserveState });
  }
  getPrefetchParams(t, e) {
    return { ...this.getPendingVisit(t, { ...e, async: !0, showProgress: !1, prefetch: !0 }), ...this.getVisitEvents(e) };
  }
  getPendingVisit(t, e, r = {}) {
    let n = { method: "get", data: {}, replace: !1, preserveScroll: !1, preserveState: !1, only: [], except: [], headers: {}, errorBag: "", forceFormData: !1, queryStringArrayFormat: "brackets", async: !1, showProgress: !0, fresh: !1, reset: [], preserveUrl: !1, prefetch: !1, ...e }, [a, i] = zo(t, n.data, n.method, n.forceFormData, n.queryStringArrayFormat);
    return { cancelled: !1, completed: !1, interrupted: !1, ...n, ...r, url: a, data: i };
  }
  getVisitEvents(t) {
    return { onCancelToken: t.onCancelToken || (() => {
    }), onBefore: t.onBefore || (() => {
    }), onStart: t.onStart || (() => {
    }), onProgress: t.onProgress || (() => {
    }), onFinish: t.onFinish || (() => {
    }), onCancel: t.onCancel || (() => {
    }), onSuccess: t.onSuccess || (() => {
    }), onError: t.onError || (() => {
    }), onPrefetched: t.onPrefetched || (() => {
    }), onPrefetching: t.onPrefetching || (() => {
    }) };
  }
  loadDeferredProps() {
    var e;
    let t = (e = d.get()) == null ? void 0 : e.deferredProps;
    t && Object.entries(t).forEach(([r, n]) => {
      this.reload({ only: n });
    });
  }
}, ps = { buildDOMElement(t) {
  let e = document.createElement("template");
  e.innerHTML = t;
  let r = e.content.firstChild;
  if (!t.startsWith("<script ")) return r;
  let n = document.createElement("script");
  return n.innerHTML = r.innerHTML, r.getAttributeNames().forEach((a) => {
    n.setAttribute(a, r.getAttribute(a) || "");
  }), n;
}, isInertiaManagedElement(t) {
  return t.nodeType === Node.ELEMENT_NODE && t.getAttribute("inertia") !== null;
}, findMatchingElementIndex(t, e) {
  let r = t.getAttribute("inertia");
  return r !== null ? e.findIndex((n) => n.getAttribute("inertia") === r) : -1;
}, update: Rt(function(t) {
  let e = t.map((r) => this.buildDOMElement(r));
  Array.from(document.head.childNodes).filter((r) => this.isInertiaManagedElement(r)).forEach((r) => {
    var i, o;
    let n = this.findMatchingElementIndex(r, e);
    if (n === -1) {
      (i = r == null ? void 0 : r.parentNode) == null || i.removeChild(r);
      return;
    }
    let a = e.splice(n, 1)[0];
    a && !r.isEqualNode(a) && ((o = r == null ? void 0 : r.parentNode) == null || o.replaceChild(a, r));
  }), e.forEach((r) => document.head.appendChild(r));
}, 1) };
function fs(t, e, r) {
  let n = {}, a = 0;
  function i() {
    let u = a += 1;
    return n[u] = [], u.toString();
  }
  function o(u) {
    u === null || Object.keys(n).indexOf(u) === -1 || (delete n[u], l());
  }
  function c(u, f = []) {
    u !== null && Object.keys(n).indexOf(u) > -1 && (n[u] = f), l();
  }
  function s() {
    let u = e(""), f = { ...u ? { title: `<title inertia="">${u}</title>` } : {} }, p = Object.values(n).reduce((y, h) => y.concat(h), []).reduce((y, h) => {
      if (h.indexOf("<") === -1) return y;
      if (h.indexOf("<title ") === 0) {
        let S = h.match(/(<title [^>]+>)(.*?)(<\/title>)/);
        return y.title = S ? `${S[1]}${e(S[2])}${S[3]}` : h, y;
      }
      let w = h.match(/ inertia="[^"]+"/);
      return w ? y[w[0]] = h : y[Object.keys(y).length] = h, y;
    }, f);
    return Object.values(p);
  }
  function l() {
    t ? r(s()) : ps.update(s());
  }
  return l(), { forceUpdate: l, createProvider: function() {
    let u = i();
    return { update: (f) => c(u, f), disconnect: () => o(u) };
  } };
}
var P = "nprogress", O = { minimum: 0.08, easing: "linear", positionUsing: "translate3d", speed: 200, trickle: !0, trickleSpeed: 200, showSpinner: !0, barSelector: '[role="bar"]', spinnerSelector: '[role="spinner"]', parent: "body", color: "#29d", includeCSS: !0, template: ['<div class="bar" role="bar">', '<div class="peg"></div>', "</div>", '<div class="spinner" role="spinner">', '<div class="spinner-icon"></div>', "</div>"].join("") }, W = null, hs = (t) => {
  Object.assign(O, t), O.includeCSS && ws(O.color);
}, Qe = (t) => {
  let e = un();
  t = yn(t, O.minimum, 1), W = t === 1 ? null : t;
  let r = ys(!e), n = r.querySelector(O.barSelector), a = O.speed, i = O.easing;
  r.offsetWidth, gs((o) => {
    let c = O.positionUsing === "translate3d" ? { transition: `all ${a}ms ${i}`, transform: `translate3d(${_e(t)}%,0,0)` } : O.positionUsing === "translate" ? { transition: `all ${a}ms ${i}`, transform: `translate(${_e(t)}%,0)` } : { marginLeft: `${_e(t)}%` };
    for (let s in c) n.style[s] = c[s];
    if (t !== 1) return setTimeout(o, a);
    r.style.transition = "none", r.style.opacity = "1", r.offsetWidth, setTimeout(() => {
      r.style.transition = `all ${a}ms linear`, r.style.opacity = "0", setTimeout(() => {
        dn(), o();
      }, a);
    }, a);
  });
}, un = () => typeof W == "number", pn = () => {
  W || Qe(0);
  let t = function() {
    setTimeout(function() {
      W && (fn(), t());
    }, O.trickleSpeed);
  };
  O.trickle && t();
}, ds = (t) => {
  !t && !W || (fn(0.3 + 0.5 * Math.random()), Qe(1));
}, fn = (t) => {
  let e = W;
  if (e === null) return pn();
  if (!(e > 1)) return t = typeof t == "number" ? t : (() => {
    let r = { 0.1: [0, 0.2], 0.04: [0.2, 0.5], 0.02: [0.5, 0.8], 5e-3: [0.8, 0.99] };
    for (let n in r) if (e >= r[n][0] && e < r[n][1]) return parseFloat(n);
    return 0;
  })(), Qe(yn(e + t, 0, 0.994));
}, ys = (t) => {
  var i;
  if (ms()) return document.getElementById(P);
  document.documentElement.classList.add(`${P}-busy`);
  let e = document.createElement("div");
  e.id = P, e.innerHTML = O.template;
  let r = e.querySelector(O.barSelector), n = t ? "-100" : _e(W || 0), a = hn();
  return r.style.transition = "all 0 linear", r.style.transform = `translate3d(${n}%,0,0)`, O.showSpinner || ((i = e.querySelector(O.spinnerSelector)) == null || i.remove()), a !== document.body && a.classList.add(`${P}-custom-parent`), a.appendChild(e), e;
}, hn = () => vs(O.parent) ? O.parent : document.querySelector(O.parent), dn = () => {
  var t;
  document.documentElement.classList.remove(`${P}-busy`), hn().classList.remove(`${P}-custom-parent`), (t = document.getElementById(P)) == null || t.remove();
}, ms = () => document.getElementById(P) !== null, vs = (t) => typeof HTMLElement == "object" ? t instanceof HTMLElement : t && typeof t == "object" && t.nodeType === 1 && typeof t.nodeName == "string";
function yn(t, e, r) {
  return t < e ? e : t > r ? r : t;
}
var _e = (t) => (-1 + t) * 100, gs = /* @__PURE__ */ (() => {
  let t = [], e = () => {
    let r = t.shift();
    r && r(e);
  };
  return (r) => {
    t.push(r), t.length === 1 && e();
  };
})(), ws = (t) => {
  let e = document.createElement("style");
  e.textContent = `
    #${P} {
      pointer-events: none;
    }

    #${P} .bar {
      background: ${t};

      position: fixed;
      z-index: 1031;
      top: 0;
      left: 0;

      width: 100%;
      height: 2px;
    }

    #${P} .peg {
      display: block;
      position: absolute;
      right: 0px;
      width: 100px;
      height: 100%;
      box-shadow: 0 0 10px ${t}, 0 0 5px ${t};
      opacity: 1.0;

      transform: rotate(3deg) translate(0px, -4px);
    }

    #${P} .spinner {
      display: block;
      position: fixed;
      z-index: 1031;
      top: 15px;
      right: 15px;
    }

    #${P} .spinner-icon {
      width: 18px;
      height: 18px;
      box-sizing: border-box;

      border: solid 2px transparent;
      border-top-color: ${t};
      border-left-color: ${t};
      border-radius: 50%;

      animation: ${P}-spinner 400ms linear infinite;
    }

    .${P}-custom-parent {
      overflow: hidden;
      position: relative;
    }

    .${P}-custom-parent #${P} .spinner,
    .${P}-custom-parent #${P} .bar {
      position: absolute;
    }

    @keyframes ${P}-spinner {
      0%   { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  `, document.head.appendChild(e);
}, oe = (() => {
  if (typeof document > "u") return null;
  let t = document.createElement("style");
  return t.innerHTML = `#${P} { display: none; }`, t;
})(), Ss = () => {
  if (oe && document.head.contains(oe)) return document.head.removeChild(oe);
}, bs = () => {
  oe && !document.head.contains(oe) && document.head.appendChild(oe);
}, x = { configure: hs, isStarted: un, done: ds, set: Qe, remove: dn, start: pn, status: W, show: Ss, hide: bs }, ke = 0, $r = (t = !1) => {
  ke = Math.max(0, ke - 1), (t || ke === 0) && x.show();
}, mn = () => {
  ke++, x.hide();
};
function Ps(t) {
  document.addEventListener("inertia:start", (e) => Es(e, t)), document.addEventListener("inertia:progress", As);
}
function Es(t, e) {
  t.detail.visit.showProgress || mn();
  let r = setTimeout(() => x.start(), e);
  document.addEventListener("inertia:finish", (n) => Os(n, r), { once: !0 });
}
function As(t) {
  var e;
  x.isStarted() && ((e = t.detail.progress) != null && e.percentage) && x.set(Math.max(x.status, t.detail.progress.percentage / 100 * 0.9));
}
function Os(t, e) {
  clearTimeout(e), x.isStarted() && (t.detail.visit.completed ? x.done() : t.detail.visit.interrupted ? x.set(0) : t.detail.visit.cancelled && (x.done(), x.remove()));
}
function $s({ delay: t = 250, color: e = "#29d", includeCSS: r = !0, showSpinner: n = !1 } = {}) {
  Ps(t), x.configure({ showSpinner: n, includeCSS: r, color: e });
}
var Oe = new us();
/* NProgress, (c) 2013, 2014 Rico Sta. Cruz - http://ricostacruz.com/nprogress
* @license MIT */
const I = Ct(null), ve = Ct(null), St = gn(null), qe = Ct(null);
let Ft = null;
const Rs = wn({
  name: "Inertia",
  props: {
    initialPage: {
      type: Object,
      required: !0
    },
    initialComponent: {
      type: Object,
      required: !1
    },
    resolveComponent: {
      type: Function,
      required: !1
    },
    titleCallback: {
      type: Function,
      required: !1,
      default: (t) => t
    },
    onHeadUpdate: {
      type: Function,
      required: !1,
      default: () => () => {
      }
    }
  },
  setup({
    initialPage: t,
    initialComponent: e,
    resolveComponent: r,
    titleCallback: n,
    onHeadUpdate: a
  }) {
    I.value = e ? Ut(e) : null, ve.value = t, qe.value = null;
    const i = typeof window > "u";
    return Ft = fs(i, n, a), i || (Oe.init({
      initialPage: t,
      resolveComponent: r,
      swapComponent: async (o) => {
        I.value = Ut(o.component), ve.value = o.page, qe.value = o.preserveState ? qe.value : Date.now();
      }
    }), Oe.on("navigate", () => Ft.forceUpdate())), () => {
      if (I.value) {
        I.value.inheritAttrs = !!I.value.inheritAttrs;
        const o = Me(I.value, {
          ...ve.value.props,
          key: qe.value
        });
        return St.value && (I.value.layout = St.value, St.value = null), I.value.layout ? typeof I.value.layout == "function" ? I.value.layout(Me, o) : (Array.isArray(I.value.layout) ? I.value.layout : [I.value.layout]).concat(o).reverse().reduce((c, s) => (s.inheritAttrs = !!s.inheritAttrs, Me(s, { ...ve.value.props }, () => c))) : o;
      }
    };
  }
}), Is = {
  install(t) {
    Oe.form = bn, Object.defineProperty(t.config.globalProperties, "$inertia", {
      get: () => Oe
    }), Object.defineProperty(t.config.globalProperties, "$page", {
      get: () => ve.value
    }), Object.defineProperty(t.config.globalProperties, "$headManager", {
      get: () => Ft
    }), t.mixin(Pn);
  }
};
async function Ts({
  id: t = "app",
  resolve: e,
  layout: r,
  setup: n,
  title: a,
  progress: i = {},
  page: o,
  render: c
}) {
  const s = typeof window > "u", l = s ? null : document.getElementById(t), u = o || JSON.parse(l.dataset.page), f = JSON.parse(l.dataset.layout), p = async (w, S) => {
    const $ = await e(w), q = S ? await r(S) : null;
    return $.default.layout = $.default.layout || q, $;
  };
  let y = [];
  const h = await Promise.all([
    p(u.component, f.component),
    Oe.decryptHistory().catch(() => {
    })
  ]).then(([w]) => n({
    el: l,
    App: Rs,
    props: {
      initialPage: u,
      initialComponent: w,
      resolveComponent: p,
      titleCallback: a,
      onHeadUpdate: s ? (S) => y = S : null
    },
    plugin: Is
  }));
  if (!s && i && $s(i), s && c) {
    const w = await c(
      Sn({
        render: () => Me("div", {
          id: t,
          "data-page": JSON.stringify(u),
          innerHTML: h ? c(h) : ""
        })
      })
    );
    return { head: y, body: w };
  }
}
export {
  Ts as default
};
