/*!
 * metismenu - v2.7.8
 * A jQuery menu plugin
 * https://github.com/onokumus/metismenu#readme
 *
 * Made by Osman Nuri Okumus <onokumus@gmail.com> (https://github.com/onokumus)
 * Under MIT License
 */
!(function (n, e) {
    "object" == typeof exports && "undefined" != typeof module ? (module.exports = e(require("jquery"))) : "function" == typeof define && define.amd ? define(["jquery"], e) : (n.metisMenu = e(n.jQuery));
})(this, function (n) {
    "use strict";
    function a(s) {
        for (var n = 1; n < arguments.length; n++) {
            var a = null != arguments[n] ? arguments[n] : {},
                e = Object.keys(a);
            "function" == typeof Object.getOwnPropertySymbols &&
                (e = e.concat(
                    Object.getOwnPropertySymbols(a).filter(function (n) {
                        return Object.getOwnPropertyDescriptor(a, n).enumerable;
                    })
                )),
                e.forEach(function (n) {
                    var e, i, t;
                    (e = s), (t = a[(i = n)]), i in e ? Object.defineProperty(e, i, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : (e[i] = t);
                });
        }
        return s;
    }
    var o,
        e,
        r,
        i,
        t,
        l,
        c,
        s,
        g = (function (t) {
            var e = "transitionend",
                s = {
                    TRANSITION_END: "mmTransitionEnd",
                    triggerTransitionEnd: function (n) {
                        t(n).trigger(e);
                    },
                    supportsTransitionEnd: function () {
                        return Boolean(e);
                    },
                };
            function n(n) {
                var e = this,
                    i = !1;
                return (
                    t(this).one(s.TRANSITION_END, function () {
                        i = !0;
                    }),
                    setTimeout(function () {
                        i || s.triggerTransitionEnd(e);
                    }, n),
                    this
                );
            }
            return (
                (t.fn.mmEmulateTransitionEnd = n),
                (t.event.special[s.TRANSITION_END] = {
                    bindType: e,
                    delegateType: e,
                    handle: function (n) {
                        if (t(n.target).is(this)) return n.handleObj.handler.apply(this, arguments);
                    },
                }),
                s
            );
        })((n = n && n.hasOwnProperty("default") ? n.default : n));
    return (
        (i = "." + (r = e = "metisMenu")),
        (t = (o = n).fn[e]),
        (l = { toggle: !0, preventDefault: !0, activeClass: "active", collapseClass: "collapse", collapseInClass: "in", collapsingClass: "collapsing", triggerElement: "a", parentTrigger: "li", subMenu: "ul" }),
        (c = { SHOW: "show" + i, SHOWN: "shown" + i, HIDE: "hide" + i, HIDDEN: "hidden" + i, CLICK_DATA_API: "click" + i + ".data-api" }),
        (s = (function () {
            function s(n, e) {
                (this.element = n), (this.config = a({}, l, e)), (this.transitioning = null), this.init();
            }
            var n = s.prototype;
            return (
                (n.init = function () {
                    var a = this,
                        r = this.config;
                    o(this.element)
                        .find(r.parentTrigger + "." + r.activeClass)
                        .has(r.subMenu)
                        .children(r.subMenu)
                        .addClass(r.collapseClass + " " + r.collapseInClass),
                        o(this.element)
                            .find(r.parentTrigger)
                            .not("." + r.activeClass)
                            .has(r.subMenu)
                            .children(r.subMenu)
                            .addClass(r.collapseClass),
                        o(this.element)
                            .find(r.parentTrigger)
                            .has(r.subMenu)
                            .children(r.triggerElement)
                            .on(c.CLICK_DATA_API, function (n) {
                                var e = o(this),
                                    i = e.parent(r.parentTrigger),
                                    t = i.siblings(r.parentTrigger).children(r.triggerElement),
                                    s = i.children(r.subMenu);
                                r.preventDefault && n.preventDefault(),
                                    "true" !== e.attr("aria-disabled") &&
                                        (i.hasClass(r.activeClass) ? (e.attr("aria-expanded", !1), a.hide(s)) : (a.show(s), e.attr("aria-expanded", !0), r.toggle && t.attr("aria-expanded", !1)),
                                        r.onTransitionStart && r.onTransitionStart(n));
                            });
                }),
                (n.show = function (n) {
                    var e = this;
                    if (!this.transitioning && !o(n).hasClass(this.config.collapsingClass)) {
                        var i = o(n),
                            t = o.Event(c.SHOW);
                        if ((i.trigger(t), !t.isDefaultPrevented())) {
                            i.parent(this.config.parentTrigger).addClass(this.config.activeClass),
                                this.config.toggle &&
                                    this.hide(
                                        i
                                            .parent(this.config.parentTrigger)
                                            .siblings()
                                            .children(this.config.subMenu + "." + this.config.collapseInClass)
                                    ),
                                i.removeClass(this.config.collapseClass).addClass(this.config.collapsingClass).height(0),
                                this.setTransitioning(!0);
                            i.height(n[0].scrollHeight)
                                .one(g.TRANSITION_END, function () {
                                    e.config &&
                                        e.element &&
                                        (i
                                            .removeClass(e.config.collapsingClass)
                                            .addClass(e.config.collapseClass + " " + e.config.collapseInClass)
                                            .height(""),
                                        e.setTransitioning(!1),
                                        i.trigger(c.SHOWN));
                                })
                                .mmEmulateTransitionEnd(350);
                        }
                    }
                }),
                (n.hide = function (n) {
                    var e = this;
                    if (!this.transitioning && o(n).hasClass(this.config.collapseInClass)) {
                        var i = o(n),
                            t = o.Event(c.HIDE);
                        if ((i.trigger(t), !t.isDefaultPrevented())) {
                            i.parent(this.config.parentTrigger).removeClass(this.config.activeClass),
                                i.height(i.height())[0].offsetHeight,
                                i.addClass(this.config.collapsingClass).removeClass(this.config.collapseClass).removeClass(this.config.collapseInClass),
                                this.setTransitioning(!0);
                            var s = function () {
                                e.config &&
                                    e.element &&
                                    (e.transitioning && e.config.onTransitionEnd && e.config.onTransitionEnd(), e.setTransitioning(!1), i.trigger(c.HIDDEN), i.removeClass(e.config.collapsingClass).addClass(e.config.collapseClass));
                            };
                            0 === i.height() || "none" === i.css("display") ? s() : i.height(0).one(g.TRANSITION_END, s).mmEmulateTransitionEnd(350);
                        }
                    }
                }),
                (n.setTransitioning = function (n) {
                    this.transitioning = n;
                }),
                (n.dispose = function () {
                    o.removeData(this.element, r),
                        o(this.element).find(this.config.parentTrigger).has(this.config.subMenu).children(this.config.triggerElement).off("click"),
                        (this.transitioning = null),
                        (this.config = null),
                        (this.element = null);
                }),
                (s.jQueryInterface = function (t) {
                    return this.each(function () {
                        var n = o(this),
                            e = n.data(r),
                            i = a({}, l, n.data(), "object" == typeof t && t ? t : {});
                        if ((!e && /dispose/.test(t) && this.dispose(), e || ((e = new s(this, i)), n.data(r, e)), "string" == typeof t)) {
                            if (void 0 === e[t]) throw new Error('No method named "' + t + '"');
                            e[t]();
                        }
                    });
                }),
                s
            );
        })()),
        (o.fn[e] = s.jQueryInterface),
        (o.fn[e].Constructor = s),
        (o.fn[e].noConflict = function () {
            return (o.fn[e] = t), s.jQueryInterface;
        }),
        s
    );
});
