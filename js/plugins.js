/*!
 * Bootstrap v4.6.2 (https://getbootstrap.com/)
 * Copyright 2011-2022 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
 */
!(function (t, e) {
  "object" == typeof exports && "undefined" != typeof module
      ? e(exports, require("jquery"))
      : "function" == typeof define && define.amd
      ? define(["exports", "jquery"], e)
      : e(((t = "undefined" != typeof globalThis ? globalThis : t || self).bootstrap = {}), t.jQuery);
})(this, function (t, e) {
  "use strict";
  function n(t) {
      return t && "object" == typeof t && "default" in t ? t : { default: t };
  }
  var i = n(e);
  function o(t, e) {
      for (var n = 0; n < e.length; n++) {
          var i = e[n];
          (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i);
      }
  }
  function r(t, e, n) {
      return e && o(t.prototype, e), n && o(t, n), Object.defineProperty(t, "prototype", { writable: !1 }), t;
  }
  function a() {
      return (
          (a = Object.assign
              ? Object.assign.bind()
              : function (t) {
                    for (var e = 1; e < arguments.length; e++) {
                        var n = arguments[e];
                        for (var i in n) Object.prototype.hasOwnProperty.call(n, i) && (t[i] = n[i]);
                    }
                    return t;
                }),
          a.apply(this, arguments)
      );
  }
  function s(t, e) {
      return (
          (s = Object.setPrototypeOf
              ? Object.setPrototypeOf.bind()
              : function (t, e) {
                    return (t.__proto__ = e), t;
                }),
          s(t, e)
      );
  }
  var l = "transitionend";
  var u = {
      TRANSITION_END: "bsTransitionEnd",
      getUID: function (t) {
          do {
              t += ~~(1e6 * Math.random());
          } while (document.getElementById(t));
          return t;
      },
      getSelectorFromElement: function (t) {
          var e = t.getAttribute("data-target");
          if (!e || "#" === e) {
              var n = t.getAttribute("href");
              e = n && "#" !== n ? n.trim() : "";
          }
          try {
              return document.querySelector(e) ? e : null;
          } catch (t) {
              return null;
          }
      },
      getTransitionDurationFromElement: function (t) {
          if (!t) return 0;
          var e = i.default(t).css("transition-duration"),
              n = i.default(t).css("transition-delay"),
              o = parseFloat(e),
              r = parseFloat(n);
          return o || r ? ((e = e.split(",")[0]), (n = n.split(",")[0]), 1e3 * (parseFloat(e) + parseFloat(n))) : 0;
      },
      reflow: function (t) {
          return t.offsetHeight;
      },
      triggerTransitionEnd: function (t) {
          i.default(t).trigger(l);
      },
      supportsTransitionEnd: function () {
          return Boolean(l);
      },
      isElement: function (t) {
          return (t[0] || t).nodeType;
      },
      typeCheckConfig: function (t, e, n) {
          for (var i in n)
              if (Object.prototype.hasOwnProperty.call(n, i)) {
                  var o = n[i],
                      r = e[i],
                      a =
                          r && u.isElement(r)
                              ? "element"
                              : null === (s = r) || "undefined" == typeof s
                              ? "" + s
                              : {}.toString
                                    .call(s)
                                    .match(/\s([a-z]+)/i)[1]
                                    .toLowerCase();
                  if (!new RegExp(o).test(a)) throw new Error(t.toUpperCase() + ': Option "' + i + '" provided type "' + a + '" but expected type "' + o + '".');
              }
          var s;
      },
      findShadowRoot: function (t) {
          if (!document.documentElement.attachShadow) return null;
          if ("function" == typeof t.getRootNode) {
              var e = t.getRootNode();
              return e instanceof ShadowRoot ? e : null;
          }
          return t instanceof ShadowRoot ? t : t.parentNode ? u.findShadowRoot(t.parentNode) : null;
      },
      jQueryDetection: function () {
          if ("undefined" == typeof i.default) throw new TypeError("Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");
          var t = i.default.fn.jquery.split(" ")[0].split(".");
          if ((t[0] < 2 && t[1] < 9) || (1 === t[0] && 9 === t[1] && t[2] < 1) || t[0] >= 4) throw new Error("Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0");
      },
  };
  u.jQueryDetection(),
      (i.default.fn.emulateTransitionEnd = function (t) {
          var e = this,
              n = !1;
          return (
              i.default(this).one(u.TRANSITION_END, function () {
                  n = !0;
              }),
              setTimeout(function () {
                  n || u.triggerTransitionEnd(e);
              }, t),
              this
          );
      }),
      (i.default.event.special[u.TRANSITION_END] = {
          bindType: l,
          delegateType: l,
          handle: function (t) {
              if (i.default(t.target).is(this)) return t.handleObj.handler.apply(this, arguments);
          },
      });
  var f = "bs.alert",
      d = i.default.fn.alert,
      c = (function () {
          function t(t) {
              this._element = t;
          }
          var e = t.prototype;
          return (
              (e.close = function (t) {
                  var e = this._element;
                  t && (e = this._getRootElement(t)), this._triggerCloseEvent(e).isDefaultPrevented() || this._removeElement(e);
              }),
              (e.dispose = function () {
                  i.default.removeData(this._element, f), (this._element = null);
              }),
              (e._getRootElement = function (t) {
                  var e = u.getSelectorFromElement(t),
                      n = !1;
                  return e && (n = document.querySelector(e)), n || (n = i.default(t).closest(".alert")[0]), n;
              }),
              (e._triggerCloseEvent = function (t) {
                  var e = i.default.Event("close.bs.alert");
                  return i.default(t).trigger(e), e;
              }),
              (e._removeElement = function (t) {
                  var e = this;
                  if ((i.default(t).removeClass("show"), i.default(t).hasClass("fade"))) {
                      var n = u.getTransitionDurationFromElement(t);
                      i.default(t)
                          .one(u.TRANSITION_END, function (n) {
                              return e._destroyElement(t, n);
                          })
                          .emulateTransitionEnd(n);
                  } else this._destroyElement(t);
              }),
              (e._destroyElement = function (t) {
                  i.default(t).detach().trigger("closed.bs.alert").remove();
              }),
              (t._jQueryInterface = function (e) {
                  return this.each(function () {
                      var n = i.default(this),
                          o = n.data(f);
                      o || ((o = new t(this)), n.data(f, o)), "close" === e && o[e](this);
                  });
              }),
              (t._handleDismiss = function (t) {
                  return function (e) {
                      e && e.preventDefault(), t.close(this);
                  };
              }),
              r(t, null, [
                  {
                      key: "VERSION",
                      get: function () {
                          return "4.6.2";
                      },
                  },
              ]),
              t
          );
      })();
  i.default(document).on("click.bs.alert.data-api", '[data-dismiss="alert"]', c._handleDismiss(new c())),
      (i.default.fn.alert = c._jQueryInterface),
      (i.default.fn.alert.Constructor = c),
      (i.default.fn.alert.noConflict = function () {
          return (i.default.fn.alert = d), c._jQueryInterface;
      });
  var h = "bs.button",
      p = i.default.fn.button,
      m = "active",
      g = '[data-toggle^="button"]',
      _ = 'input:not([type="hidden"])',
      v = ".btn",
      b = (function () {
          function t(t) {
              (this._element = t), (this.shouldAvoidTriggerChange = !1);
          }
          var e = t.prototype;
          return (
              (e.toggle = function () {
                  var t = !0,
                      e = !0,
                      n = i.default(this._element).closest('[data-toggle="buttons"]')[0];
                  if (n) {
                      var o = this._element.querySelector(_);
                      if (o) {
                          if ("radio" === o.type)
                              if (o.checked && this._element.classList.contains(m)) t = !1;
                              else {
                                  var r = n.querySelector(".active");
                                  r && i.default(r).removeClass(m);
                              }
                          t && (("checkbox" !== o.type && "radio" !== o.type) || (o.checked = !this._element.classList.contains(m)), this.shouldAvoidTriggerChange || i.default(o).trigger("change")), o.focus(), (e = !1);
                      }
                  }
                  this._element.hasAttribute("disabled") ||
                      this._element.classList.contains("disabled") ||
                      (e && this._element.setAttribute("aria-pressed", !this._element.classList.contains(m)), t && i.default(this._element).toggleClass(m));
              }),
              (e.dispose = function () {
                  i.default.removeData(this._element, h), (this._element = null);
              }),
              (t._jQueryInterface = function (e, n) {
                  return this.each(function () {
                      var o = i.default(this),
                          r = o.data(h);
                      r || ((r = new t(this)), o.data(h, r)), (r.shouldAvoidTriggerChange = n), "toggle" === e && r[e]();
                  });
              }),
              r(t, null, [
                  {
                      key: "VERSION",
                      get: function () {
                          return "4.6.2";
                      },
                  },
              ]),
              t
          );
      })();
  i
      .default(document)
      .on("click.bs.button.data-api", g, function (t) {
          var e = t.target,
              n = e;
          if ((i.default(e).hasClass("btn") || (e = i.default(e).closest(v)[0]), !e || e.hasAttribute("disabled") || e.classList.contains("disabled"))) t.preventDefault();
          else {
              var o = e.querySelector(_);
              if (o && (o.hasAttribute("disabled") || o.classList.contains("disabled"))) return void t.preventDefault();
              ("INPUT" !== n.tagName && "LABEL" === e.tagName) || b._jQueryInterface.call(i.default(e), "toggle", "INPUT" === n.tagName);
          }
      })
      .on("focus.bs.button.data-api blur.bs.button.data-api", g, function (t) {
          var e = i.default(t.target).closest(v)[0];
          i.default(e).toggleClass("focus", /^focus(in)?$/.test(t.type));
      }),
      i.default(window).on("load.bs.button.data-api", function () {
          for (var t = [].slice.call(document.querySelectorAll('[data-toggle="buttons"] .btn')), e = 0, n = t.length; e < n; e++) {
              var i = t[e],
                  o = i.querySelector(_);
              o.checked || o.hasAttribute("checked") ? i.classList.add(m) : i.classList.remove(m);
          }
          for (var r = 0, a = (t = [].slice.call(document.querySelectorAll('[data-toggle="button"]'))).length; r < a; r++) {
              var s = t[r];
              "true" === s.getAttribute("aria-pressed") ? s.classList.add(m) : s.classList.remove(m);
          }
      }),
      (i.default.fn.button = b._jQueryInterface),
      (i.default.fn.button.Constructor = b),
      (i.default.fn.button.noConflict = function () {
          return (i.default.fn.button = p), b._jQueryInterface;
      });
  var y = "carousel",
      E = "bs.carousel",
      w = i.default.fn[y],
      T = "active",
      C = "next",
      S = "prev",
      N = "slid.bs.carousel",
      D = ".active.carousel-item",
      A = { interval: 5e3, keyboard: !0, slide: !1, pause: "hover", wrap: !0, touch: !0 },
      k = { interval: "(number|boolean)", keyboard: "boolean", slide: "(boolean|string)", pause: "(string|boolean)", wrap: "boolean", touch: "boolean" },
      I = { TOUCH: "touch", PEN: "pen" },
      O = (function () {
          function t(t, e) {
              (this._items = null),
                  (this._interval = null),
                  (this._activeElement = null),
                  (this._isPaused = !1),
                  (this._isSliding = !1),
                  (this.touchTimeout = null),
                  (this.touchStartX = 0),
                  (this.touchDeltaX = 0),
                  (this._config = this._getConfig(e)),
                  (this._element = t),
                  (this._indicatorsElement = this._element.querySelector(".carousel-indicators")),
                  (this._touchSupported = "ontouchstart" in document.documentElement || navigator.maxTouchPoints > 0),
                  (this._pointerEvent = Boolean(window.PointerEvent || window.MSPointerEvent)),
                  this._addEventListeners();
          }
          var e = t.prototype;
          return (
              (e.next = function () {
                  this._isSliding || this._slide(C);
              }),
              (e.nextWhenVisible = function () {
                  var t = i.default(this._element);
                  !document.hidden && t.is(":visible") && "hidden" !== t.css("visibility") && this.next();
              }),
              (e.prev = function () {
                  this._isSliding || this._slide(S);
              }),
              (e.pause = function (t) {
                  t || (this._isPaused = !0), this._element.querySelector(".carousel-item-next, .carousel-item-prev") && (u.triggerTransitionEnd(this._element), this.cycle(!0)), clearInterval(this._interval), (this._interval = null);
              }),
              (e.cycle = function (t) {
                  t || (this._isPaused = !1),
                      this._interval && (clearInterval(this._interval), (this._interval = null)),
                      this._config.interval && !this._isPaused && (this._updateInterval(), (this._interval = setInterval((document.visibilityState ? this.nextWhenVisible : this.next).bind(this), this._config.interval)));
              }),
              (e.to = function (t) {
                  var e = this;
                  this._activeElement = this._element.querySelector(D);
                  var n = this._getItemIndex(this._activeElement);
                  if (!(t > this._items.length - 1 || t < 0))
                      if (this._isSliding)
                          i.default(this._element).one(N, function () {
                              return e.to(t);
                          });
                      else {
                          if (n === t) return this.pause(), void this.cycle();
                          var o = t > n ? C : S;
                          this._slide(o, this._items[t]);
                      }
              }),
              (e.dispose = function () {
                  i.default(this._element).off(".bs.carousel"),
                      i.default.removeData(this._element, E),
                      (this._items = null),
                      (this._config = null),
                      (this._element = null),
                      (this._interval = null),
                      (this._isPaused = null),
                      (this._isSliding = null),
                      (this._activeElement = null),
                      (this._indicatorsElement = null);
              }),
              (e._getConfig = function (t) {
                  return (t = a({}, A, t)), u.typeCheckConfig(y, t, k), t;
              }),
              (e._handleSwipe = function () {
                  var t = Math.abs(this.touchDeltaX);
                  if (!(t <= 40)) {
                      var e = t / this.touchDeltaX;
                      (this.touchDeltaX = 0), e > 0 && this.prev(), e < 0 && this.next();
                  }
              }),
              (e._addEventListeners = function () {
                  var t = this;
                  this._config.keyboard &&
                      i.default(this._element).on("keydown.bs.carousel", function (e) {
                          return t._keydown(e);
                      }),
                      "hover" === this._config.pause &&
                          i
                              .default(this._element)
                              .on("mouseenter.bs.carousel", function (e) {
                                  return t.pause(e);
                              })
                              .on("mouseleave.bs.carousel", function (e) {
                                  return t.cycle(e);
                              }),
                      this._config.touch && this._addTouchEventListeners();
              }),
              (e._addTouchEventListeners = function () {
                  var t = this;
                  if (this._touchSupported) {
                      var e = function (e) {
                              t._pointerEvent && I[e.originalEvent.pointerType.toUpperCase()] ? (t.touchStartX = e.originalEvent.clientX) : t._pointerEvent || (t.touchStartX = e.originalEvent.touches[0].clientX);
                          },
                          n = function (e) {
                              t._pointerEvent && I[e.originalEvent.pointerType.toUpperCase()] && (t.touchDeltaX = e.originalEvent.clientX - t.touchStartX),
                                  t._handleSwipe(),
                                  "hover" === t._config.pause &&
                                      (t.pause(),
                                      t.touchTimeout && clearTimeout(t.touchTimeout),
                                      (t.touchTimeout = setTimeout(function (e) {
                                          return t.cycle(e);
                                      }, 500 + t._config.interval)));
                          };
                      i.default(this._element.querySelectorAll(".carousel-item img")).on("dragstart.bs.carousel", function (t) {
                          return t.preventDefault();
                      }),
                          this._pointerEvent
                              ? (i.default(this._element).on("pointerdown.bs.carousel", function (t) {
                                    return e(t);
                                }),
                                i.default(this._element).on("pointerup.bs.carousel", function (t) {
                                    return n(t);
                                }),
                                this._element.classList.add("pointer-event"))
                              : (i.default(this._element).on("touchstart.bs.carousel", function (t) {
                                    return e(t);
                                }),
                                i.default(this._element).on("touchmove.bs.carousel", function (e) {
                                    return (function (e) {
                                        t.touchDeltaX = e.originalEvent.touches && e.originalEvent.touches.length > 1 ? 0 : e.originalEvent.touches[0].clientX - t.touchStartX;
                                    })(e);
                                }),
                                i.default(this._element).on("touchend.bs.carousel", function (t) {
                                    return n(t);
                                }));
                  }
              }),
              (e._keydown = function (t) {
                  if (!/input|textarea/i.test(t.target.tagName))
                      switch (t.which) {
                          case 37:
                              t.preventDefault(), this.prev();
                              break;
                          case 39:
                              t.preventDefault(), this.next();
                      }
              }),
              (e._getItemIndex = function (t) {
                  return (this._items = t && t.parentNode ? [].slice.call(t.parentNode.querySelectorAll(".carousel-item")) : []), this._items.indexOf(t);
              }),
              (e._getItemByDirection = function (t, e) {
                  var n = t === C,
                      i = t === S,
                      o = this._getItemIndex(e),
                      r = this._items.length - 1;
                  if (((i && 0 === o) || (n && o === r)) && !this._config.wrap) return e;
                  var a = (o + (t === S ? -1 : 1)) % this._items.length;
                  return -1 === a ? this._items[this._items.length - 1] : this._items[a];
              }),
              (e._triggerSlideEvent = function (t, e) {
                  var n = this._getItemIndex(t),
                      o = this._getItemIndex(this._element.querySelector(D)),
                      r = i.default.Event("slide.bs.carousel", { relatedTarget: t, direction: e, from: o, to: n });
                  return i.default(this._element).trigger(r), r;
              }),
              (e._setActiveIndicatorElement = function (t) {
                  if (this._indicatorsElement) {
                      var e = [].slice.call(this._indicatorsElement.querySelectorAll(".active"));
                      i.default(e).removeClass(T);
                      var n = this._indicatorsElement.children[this._getItemIndex(t)];
                      n && i.default(n).addClass(T);
                  }
              }),
              (e._updateInterval = function () {
                  var t = this._activeElement || this._element.querySelector(D);
                  if (t) {
                      var e = parseInt(t.getAttribute("data-interval"), 10);
                      e ? ((this._config.defaultInterval = this._config.defaultInterval || this._config.interval), (this._config.interval = e)) : (this._config.interval = this._config.defaultInterval || this._config.interval);
                  }
              }),
              (e._slide = function (t, e) {
                  var n,
                      o,
                      r,
                      a = this,
                      s = this._element.querySelector(D),
                      l = this._getItemIndex(s),
                      f = e || (s && this._getItemByDirection(t, s)),
                      d = this._getItemIndex(f),
                      c = Boolean(this._interval);
                  if ((t === C ? ((n = "carousel-item-left"), (o = "carousel-item-next"), (r = "left")) : ((n = "carousel-item-right"), (o = "carousel-item-prev"), (r = "right")), f && i.default(f).hasClass(T))) this._isSliding = !1;
                  else if (!this._triggerSlideEvent(f, r).isDefaultPrevented() && s && f) {
                      (this._isSliding = !0), c && this.pause(), this._setActiveIndicatorElement(f), (this._activeElement = f);
                      var h = i.default.Event(N, { relatedTarget: f, direction: r, from: l, to: d });
                      if (i.default(this._element).hasClass("slide")) {
                          i.default(f).addClass(o), u.reflow(f), i.default(s).addClass(n), i.default(f).addClass(n);
                          var p = u.getTransitionDurationFromElement(s);
                          i.default(s)
                              .one(u.TRANSITION_END, function () {
                                  i
                                      .default(f)
                                      .removeClass(n + " " + o)
                                      .addClass(T),
                                      i.default(s).removeClass("active " + o + " " + n),
                                      (a._isSliding = !1),
                                      setTimeout(function () {
                                          return i.default(a._element).trigger(h);
                                      }, 0);
                              })
                              .emulateTransitionEnd(p);
                      } else i.default(s).removeClass(T), i.default(f).addClass(T), (this._isSliding = !1), i.default(this._element).trigger(h);
                      c && this.cycle();
                  }
              }),
              (t._jQueryInterface = function (e) {
                  return this.each(function () {
                      var n = i.default(this).data(E),
                          o = a({}, A, i.default(this).data());
                      "object" == typeof e && (o = a({}, o, e));
                      var r = "string" == typeof e ? e : o.slide;
                      if ((n || ((n = new t(this, o)), i.default(this).data(E, n)), "number" == typeof e)) n.to(e);
                      else if ("string" == typeof r) {
                          if ("undefined" == typeof n[r]) throw new TypeError('No method named "' + r + '"');
                          n[r]();
                      } else o.interval && o.ride && (n.pause(), n.cycle());
                  });
              }),
              (t._dataApiClickHandler = function (e) {
                  var n = u.getSelectorFromElement(this);
                  if (n) {
                      var o = i.default(n)[0];
                      if (o && i.default(o).hasClass("carousel")) {
                          var r = a({}, i.default(o).data(), i.default(this).data()),
                              s = this.getAttribute("data-slide-to");
                          s && (r.interval = !1), t._jQueryInterface.call(i.default(o), r), s && i.default(o).data(E).to(s), e.preventDefault();
                      }
                  }
              }),
              r(t, null, [
                  {
                      key: "VERSION",
                      get: function () {
                          return "4.6.2";
                      },
                  },
                  {
                      key: "Default",
                      get: function () {
                          return A;
                      },
                  },
              ]),
              t
          );
      })();
  i.default(document).on("click.bs.carousel.data-api", "[data-slide], [data-slide-to]", O._dataApiClickHandler),
      i.default(window).on("load.bs.carousel.data-api", function () {
          for (var t = [].slice.call(document.querySelectorAll('[data-ride="carousel"]')), e = 0, n = t.length; e < n; e++) {
              var o = i.default(t[e]);
              O._jQueryInterface.call(o, o.data());
          }
      }),
      (i.default.fn[y] = O._jQueryInterface),
      (i.default.fn[y].Constructor = O),
      (i.default.fn[y].noConflict = function () {
          return (i.default.fn[y] = w), O._jQueryInterface;
      });
  var x = "collapse",
      j = "bs.collapse",
      L = i.default.fn[x],
      P = "show",
      F = "collapse",
      R = "collapsing",
      B = "collapsed",
      H = "width",
      M = '[data-toggle="collapse"]',
      q = { toggle: !0, parent: "" },
      Q = { toggle: "boolean", parent: "(string|element)" },
      W = (function () {
          function t(t, e) {
              (this._isTransitioning = !1),
                  (this._element = t),
                  (this._config = this._getConfig(e)),
                  (this._triggerArray = [].slice.call(document.querySelectorAll('[data-toggle="collapse"][href="#' + t.id + '"],[data-toggle="collapse"][data-target="#' + t.id + '"]')));
              for (var n = [].slice.call(document.querySelectorAll(M)), i = 0, o = n.length; i < o; i++) {
                  var r = n[i],
                      a = u.getSelectorFromElement(r),
                      s = [].slice.call(document.querySelectorAll(a)).filter(function (e) {
                          return e === t;
                      });
                  null !== a && s.length > 0 && ((this._selector = a), this._triggerArray.push(r));
              }
              (this._parent = this._config.parent ? this._getParent() : null), this._config.parent || this._addAriaAndCollapsedClass(this._element, this._triggerArray), this._config.toggle && this.toggle();
          }
          var e = t.prototype;
          return (
              (e.toggle = function () {
                  i.default(this._element).hasClass(P) ? this.hide() : this.show();
              }),
              (e.show = function () {
                  var e,
                      n,
                      o = this;
                  if (
                      !(
                          this._isTransitioning ||
                          i.default(this._element).hasClass(P) ||
                          (this._parent &&
                              0 ===
                                  (e = [].slice.call(this._parent.querySelectorAll(".show, .collapsing")).filter(function (t) {
                                      return "string" == typeof o._config.parent ? t.getAttribute("data-parent") === o._config.parent : t.classList.contains(F);
                                  })).length &&
                              (e = null),
                          e && (n = i.default(e).not(this._selector).data(j)) && n._isTransitioning)
                      )
                  ) {
                      var r = i.default.Event("show.bs.collapse");
                      if ((i.default(this._element).trigger(r), !r.isDefaultPrevented())) {
                          e && (t._jQueryInterface.call(i.default(e).not(this._selector), "hide"), n || i.default(e).data(j, null));
                          var a = this._getDimension();
                          i.default(this._element).removeClass(F).addClass(R), (this._element.style[a] = 0), this._triggerArray.length && i.default(this._triggerArray).removeClass(B).attr("aria-expanded", !0), this.setTransitioning(!0);
                          var s = "scroll" + (a[0].toUpperCase() + a.slice(1)),
                              l = u.getTransitionDurationFromElement(this._element);
                          i
                              .default(this._element)
                              .one(u.TRANSITION_END, function () {
                                  i.default(o._element).removeClass(R).addClass("collapse show"), (o._element.style[a] = ""), o.setTransitioning(!1), i.default(o._element).trigger("shown.bs.collapse");
                              })
                              .emulateTransitionEnd(l),
                              (this._element.style[a] = this._element[s] + "px");
                      }
                  }
              }),
              (e.hide = function () {
                  var t = this;
                  if (!this._isTransitioning && i.default(this._element).hasClass(P)) {
                      var e = i.default.Event("hide.bs.collapse");
                      if ((i.default(this._element).trigger(e), !e.isDefaultPrevented())) {
                          var n = this._getDimension();
                          (this._element.style[n] = this._element.getBoundingClientRect()[n] + "px"), u.reflow(this._element), i.default(this._element).addClass(R).removeClass("collapse show");
                          var o = this._triggerArray.length;
                          if (o > 0)
                              for (var r = 0; r < o; r++) {
                                  var a = this._triggerArray[r],
                                      s = u.getSelectorFromElement(a);
                                  null !== s && (i.default([].slice.call(document.querySelectorAll(s))).hasClass(P) || i.default(a).addClass(B).attr("aria-expanded", !1));
                              }
                          this.setTransitioning(!0), (this._element.style[n] = "");
                          var l = u.getTransitionDurationFromElement(this._element);
                          i.default(this._element)
                              .one(u.TRANSITION_END, function () {
                                  t.setTransitioning(!1), i.default(t._element).removeClass(R).addClass(F).trigger("hidden.bs.collapse");
                              })
                              .emulateTransitionEnd(l);
                      }
                  }
              }),
              (e.setTransitioning = function (t) {
                  this._isTransitioning = t;
              }),
              (e.dispose = function () {
                  i.default.removeData(this._element, j), (this._config = null), (this._parent = null), (this._element = null), (this._triggerArray = null), (this._isTransitioning = null);
              }),
              (e._getConfig = function (t) {
                  return ((t = a({}, q, t)).toggle = Boolean(t.toggle)), u.typeCheckConfig(x, t, Q), t;
              }),
              (e._getDimension = function () {
                  return i.default(this._element).hasClass(H) ? H : "height";
              }),
              (e._getParent = function () {
                  var e,
                      n = this;
                  u.isElement(this._config.parent) ? ((e = this._config.parent), "undefined" != typeof this._config.parent.jquery && (e = this._config.parent[0])) : (e = document.querySelector(this._config.parent));
                  var o = '[data-toggle="collapse"][data-parent="' + this._config.parent + '"]',
                      r = [].slice.call(e.querySelectorAll(o));
                  return (
                      i.default(r).each(function (e, i) {
                          n._addAriaAndCollapsedClass(t._getTargetFromElement(i), [i]);
                      }),
                      e
                  );
              }),
              (e._addAriaAndCollapsedClass = function (t, e) {
                  var n = i.default(t).hasClass(P);
                  e.length && i.default(e).toggleClass(B, !n).attr("aria-expanded", n);
              }),
              (t._getTargetFromElement = function (t) {
                  var e = u.getSelectorFromElement(t);
                  return e ? document.querySelector(e) : null;
              }),
              (t._jQueryInterface = function (e) {
                  return this.each(function () {
                      var n = i.default(this),
                          o = n.data(j),
                          r = a({}, q, n.data(), "object" == typeof e && e ? e : {});
                      if ((!o && r.toggle && "string" == typeof e && /show|hide/.test(e) && (r.toggle = !1), o || ((o = new t(this, r)), n.data(j, o)), "string" == typeof e)) {
                          if ("undefined" == typeof o[e]) throw new TypeError('No method named "' + e + '"');
                          o[e]();
                      }
                  });
              }),
              r(t, null, [
                  {
                      key: "VERSION",
                      get: function () {
                          return "4.6.2";
                      },
                  },
                  {
                      key: "Default",
                      get: function () {
                          return q;
                      },
                  },
              ]),
              t
          );
      })();
  i.default(document).on("click.bs.collapse.data-api", M, function (t) {
      "A" === t.currentTarget.tagName && t.preventDefault();
      var e = i.default(this),
          n = u.getSelectorFromElement(this),
          o = [].slice.call(document.querySelectorAll(n));
      i.default(o).each(function () {
          var t = i.default(this),
              n = t.data(j) ? "toggle" : e.data();
          W._jQueryInterface.call(t, n);
      });
  }),
      (i.default.fn[x] = W._jQueryInterface),
      (i.default.fn[x].Constructor = W),
      (i.default.fn[x].noConflict = function () {
          return (i.default.fn[x] = L), W._jQueryInterface;
      });
  var U = "undefined" != typeof window && "undefined" != typeof document && "undefined" != typeof navigator,
      V = (function () {
          for (var t = ["Edge", "Trident", "Firefox"], e = 0; e < t.length; e += 1) if (U && navigator.userAgent.indexOf(t[e]) >= 0) return 1;
          return 0;
      })(),
      Y =
          U && window.Promise
              ? function (t) {
                    var e = !1;
                    return function () {
                        e ||
                            ((e = !0),
                            window.Promise.resolve().then(function () {
                                (e = !1), t();
                            }));
                    };
                }
              : function (t) {
                    var e = !1;
                    return function () {
                        e ||
                            ((e = !0),
                            setTimeout(function () {
                                (e = !1), t();
                            }, V));
                    };
                };
  function z(t) {
      return t && "[object Function]" === {}.toString.call(t);
  }
  function K(t, e) {
      if (1 !== t.nodeType) return [];
      var n = t.ownerDocument.defaultView.getComputedStyle(t, null);
      return e ? n[e] : n;
  }
  function X(t) {
      return "HTML" === t.nodeName ? t : t.parentNode || t.host;
  }
  function G(t) {
      if (!t) return document.body;
      switch (t.nodeName) {
          case "HTML":
          case "BODY":
              return t.ownerDocument.body;
          case "#document":
              return t.body;
      }
      var e = K(t),
          n = e.overflow,
          i = e.overflowX,
          o = e.overflowY;
      return /(auto|scroll|overlay)/.test(n + o + i) ? t : G(X(t));
  }
  function $(t) {
      return t && t.referenceNode ? t.referenceNode : t;
  }
  var J = U && !(!window.MSInputMethodContext || !document.documentMode),
      Z = U && /MSIE 10/.test(navigator.userAgent);
  function tt(t) {
      return 11 === t ? J : 10 === t ? Z : J || Z;
  }
  function et(t) {
      if (!t) return document.documentElement;
      for (var e = tt(10) ? document.body : null, n = t.offsetParent || null; n === e && t.nextElementSibling; ) n = (t = t.nextElementSibling).offsetParent;
      var i = n && n.nodeName;
      return i && "BODY" !== i && "HTML" !== i ? (-1 !== ["TH", "TD", "TABLE"].indexOf(n.nodeName) && "static" === K(n, "position") ? et(n) : n) : t ? t.ownerDocument.documentElement : document.documentElement;
  }
  function nt(t) {
      return null !== t.parentNode ? nt(t.parentNode) : t;
  }
  function it(t, e) {
      if (!(t && t.nodeType && e && e.nodeType)) return document.documentElement;
      var n = t.compareDocumentPosition(e) & Node.DOCUMENT_POSITION_FOLLOWING,
          i = n ? t : e,
          o = n ? e : t,
          r = document.createRange();
      r.setStart(i, 0), r.setEnd(o, 0);
      var a,
          s,
          l = r.commonAncestorContainer;
      if ((t !== l && e !== l) || i.contains(o)) return "BODY" === (s = (a = l).nodeName) || ("HTML" !== s && et(a.firstElementChild) !== a) ? et(l) : l;
      var u = nt(t);
      return u.host ? it(u.host, e) : it(t, nt(e).host);
  }
  function ot(t) {
      var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "top",
          n = "top" === e ? "scrollTop" : "scrollLeft",
          i = t.nodeName;
      if ("BODY" === i || "HTML" === i) {
          var o = t.ownerDocument.documentElement,
              r = t.ownerDocument.scrollingElement || o;
          return r[n];
      }
      return t[n];
  }
  function rt(t, e) {
      var n = arguments.length > 2 && void 0 !== arguments[2] && arguments[2],
          i = ot(e, "top"),
          o = ot(e, "left"),
          r = n ? -1 : 1;
      return (t.top += i * r), (t.bottom += i * r), (t.left += o * r), (t.right += o * r), t;
  }
  function at(t, e) {
      var n = "x" === e ? "Left" : "Top",
          i = "Left" === n ? "Right" : "Bottom";
      return parseFloat(t["border" + n + "Width"]) + parseFloat(t["border" + i + "Width"]);
  }
  function st(t, e, n, i) {
      return Math.max(
          e["offset" + t],
          e["scroll" + t],
          n["client" + t],
          n["offset" + t],
          n["scroll" + t],
          tt(10) ? parseInt(n["offset" + t]) + parseInt(i["margin" + ("Height" === t ? "Top" : "Left")]) + parseInt(i["margin" + ("Height" === t ? "Bottom" : "Right")]) : 0
      );
  }
  function lt(t) {
      var e = t.body,
          n = t.documentElement,
          i = tt(10) && getComputedStyle(n);
      return { height: st("Height", e, n, i), width: st("Width", e, n, i) };
  }
  var ut = function (t, e) {
          if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function");
      },
      ft = (function () {
          function t(t, e) {
              for (var n = 0; n < e.length; n++) {
                  var i = e[n];
                  (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i);
              }
          }
          return function (e, n, i) {
              return n && t(e.prototype, n), i && t(e, i), e;
          };
      })(),
      dt = function (t, e, n) {
          return e in t ? Object.defineProperty(t, e, { value: n, enumerable: !0, configurable: !0, writable: !0 }) : (t[e] = n), t;
      },
      ct =
          Object.assign ||
          function (t) {
              for (var e = 1; e < arguments.length; e++) {
                  var n = arguments[e];
                  for (var i in n) Object.prototype.hasOwnProperty.call(n, i) && (t[i] = n[i]);
              }
              return t;
          };
  function ht(t) {
      return ct({}, t, { right: t.left + t.width, bottom: t.top + t.height });
  }
  function pt(t) {
      var e = {};
      try {
          if (tt(10)) {
              e = t.getBoundingClientRect();
              var n = ot(t, "top"),
                  i = ot(t, "left");
              (e.top += n), (e.left += i), (e.bottom += n), (e.right += i);
          } else e = t.getBoundingClientRect();
      } catch (t) {}
      var o = { left: e.left, top: e.top, width: e.right - e.left, height: e.bottom - e.top },
          r = "HTML" === t.nodeName ? lt(t.ownerDocument) : {},
          a = r.width || t.clientWidth || o.width,
          s = r.height || t.clientHeight || o.height,
          l = t.offsetWidth - a,
          u = t.offsetHeight - s;
      if (l || u) {
          var f = K(t);
          (l -= at(f, "x")), (u -= at(f, "y")), (o.width -= l), (o.height -= u);
      }
      return ht(o);
  }
  function mt(t, e) {
      var n = arguments.length > 2 && void 0 !== arguments[2] && arguments[2],
          i = tt(10),
          o = "HTML" === e.nodeName,
          r = pt(t),
          a = pt(e),
          s = G(t),
          l = K(e),
          u = parseFloat(l.borderTopWidth),
          f = parseFloat(l.borderLeftWidth);
      n && o && ((a.top = Math.max(a.top, 0)), (a.left = Math.max(a.left, 0)));
      var d = ht({ top: r.top - a.top - u, left: r.left - a.left - f, width: r.width, height: r.height });
      if (((d.marginTop = 0), (d.marginLeft = 0), !i && o)) {
          var c = parseFloat(l.marginTop),
              h = parseFloat(l.marginLeft);
          (d.top -= u - c), (d.bottom -= u - c), (d.left -= f - h), (d.right -= f - h), (d.marginTop = c), (d.marginLeft = h);
      }
      return (i && !n ? e.contains(s) : e === s && "BODY" !== s.nodeName) && (d = rt(d, e)), d;
  }
  function gt(t) {
      var e = arguments.length > 1 && void 0 !== arguments[1] && arguments[1],
          n = t.ownerDocument.documentElement,
          i = mt(t, n),
          o = Math.max(n.clientWidth, window.innerWidth || 0),
          r = Math.max(n.clientHeight, window.innerHeight || 0),
          a = e ? 0 : ot(n),
          s = e ? 0 : ot(n, "left"),
          l = { top: a - i.top + i.marginTop, left: s - i.left + i.marginLeft, width: o, height: r };
      return ht(l);
  }
  function _t(t) {
      var e = t.nodeName;
      if ("BODY" === e || "HTML" === e) return !1;
      if ("fixed" === K(t, "position")) return !0;
      var n = X(t);
      return !!n && _t(n);
  }
  function vt(t) {
      if (!t || !t.parentElement || tt()) return document.documentElement;
      for (var e = t.parentElement; e && "none" === K(e, "transform"); ) e = e.parentElement;
      return e || document.documentElement;
  }
  function bt(t, e, n, i) {
      var o = arguments.length > 4 && void 0 !== arguments[4] && arguments[4],
          r = { top: 0, left: 0 },
          a = o ? vt(t) : it(t, $(e));
      if ("viewport" === i) r = gt(a, o);
      else {
          var s = void 0;
          "scrollParent" === i ? "BODY" === (s = G(X(e))).nodeName && (s = t.ownerDocument.documentElement) : (s = "window" === i ? t.ownerDocument.documentElement : i);
          var l = mt(s, a, o);
          if ("HTML" !== s.nodeName || _t(a)) r = l;
          else {
              var u = lt(t.ownerDocument),
                  f = u.height,
                  d = u.width;
              (r.top += l.top - l.marginTop), (r.bottom = f + l.top), (r.left += l.left - l.marginLeft), (r.right = d + l.left);
          }
      }
      var c = "number" == typeof (n = n || 0);
      return (r.left += c ? n : n.left || 0), (r.top += c ? n : n.top || 0), (r.right -= c ? n : n.right || 0), (r.bottom -= c ? n : n.bottom || 0), r;
  }
  function yt(t) {
      return t.width * t.height;
  }
  function Et(t, e, n, i, o) {
      var r = arguments.length > 5 && void 0 !== arguments[5] ? arguments[5] : 0;
      if (-1 === t.indexOf("auto")) return t;
      var a = bt(n, i, r, o),
          s = { top: { width: a.width, height: e.top - a.top }, right: { width: a.right - e.right, height: a.height }, bottom: { width: a.width, height: a.bottom - e.bottom }, left: { width: e.left - a.left, height: a.height } },
          l = Object.keys(s)
              .map(function (t) {
                  return ct({ key: t }, s[t], { area: yt(s[t]) });
              })
              .sort(function (t, e) {
                  return e.area - t.area;
              }),
          u = l.filter(function (t) {
              var e = t.width,
                  i = t.height;
              return e >= n.clientWidth && i >= n.clientHeight;
          }),
          f = u.length > 0 ? u[0].key : l[0].key,
          d = t.split("-")[1];
      return f + (d ? "-" + d : "");
  }
  function wt(t, e, n) {
      var i = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : null,
          o = i ? vt(e) : it(e, $(n));
      return mt(n, o, i);
  }
  function Tt(t) {
      var e = t.ownerDocument.defaultView.getComputedStyle(t),
          n = parseFloat(e.marginTop || 0) + parseFloat(e.marginBottom || 0),
          i = parseFloat(e.marginLeft || 0) + parseFloat(e.marginRight || 0);
      return { width: t.offsetWidth + i, height: t.offsetHeight + n };
  }
  function Ct(t) {
      var e = { left: "right", right: "left", bottom: "top", top: "bottom" };
      return t.replace(/left|right|bottom|top/g, function (t) {
          return e[t];
      });
  }
  function St(t, e, n) {
      n = n.split("-")[0];
      var i = Tt(t),
          o = { width: i.width, height: i.height },
          r = -1 !== ["right", "left"].indexOf(n),
          a = r ? "top" : "left",
          s = r ? "left" : "top",
          l = r ? "height" : "width",
          u = r ? "width" : "height";
      return (o[a] = e[a] + e[l] / 2 - i[l] / 2), (o[s] = n === s ? e[s] - i[u] : e[Ct(s)]), o;
  }
  function Nt(t, e) {
      return Array.prototype.find ? t.find(e) : t.filter(e)[0];
  }
  function Dt(t, e, n) {
      return (
          (void 0 === n
              ? t
              : t.slice(
                    0,
                    (function (t, e, n) {
                        if (Array.prototype.findIndex)
                            return t.findIndex(function (t) {
                                return t.name === n;
                            });
                        var i = Nt(t, function (t) {
                            return t.name === n;
                        });
                        return t.indexOf(i);
                    })(t, 0, n)
                )
          ).forEach(function (t) {
              t.function && console.warn("`modifier.function` is deprecated, use `modifier.fn`!");
              var n = t.function || t.fn;
              t.enabled && z(n) && ((e.offsets.popper = ht(e.offsets.popper)), (e.offsets.reference = ht(e.offsets.reference)), (e = n(e, t)));
          }),
          e
      );
  }
  function At() {
      if (!this.state.isDestroyed) {
          var t = { instance: this, styles: {}, arrowStyles: {}, attributes: {}, flipped: !1, offsets: {} };
          (t.offsets.reference = wt(this.state, this.popper, this.reference, this.options.positionFixed)),
              (t.placement = Et(this.options.placement, t.offsets.reference, this.popper, this.reference, this.options.modifiers.flip.boundariesElement, this.options.modifiers.flip.padding)),
              (t.originalPlacement = t.placement),
              (t.positionFixed = this.options.positionFixed),
              (t.offsets.popper = St(this.popper, t.offsets.reference, t.placement)),
              (t.offsets.popper.position = this.options.positionFixed ? "fixed" : "absolute"),
              (t = Dt(this.modifiers, t)),
              this.state.isCreated ? this.options.onUpdate(t) : ((this.state.isCreated = !0), this.options.onCreate(t));
      }
  }
  function kt(t, e) {
      return t.some(function (t) {
          var n = t.name;
          return t.enabled && n === e;
      });
  }
  function It(t) {
      for (var e = [!1, "ms", "Webkit", "Moz", "O"], n = t.charAt(0).toUpperCase() + t.slice(1), i = 0; i < e.length; i++) {
          var o = e[i],
              r = o ? "" + o + n : t;
          if ("undefined" != typeof document.body.style[r]) return r;
      }
      return null;
  }
  function Ot() {
      return (
          (this.state.isDestroyed = !0),
          kt(this.modifiers, "applyStyle") &&
              (this.popper.removeAttribute("x-placement"),
              (this.popper.style.position = ""),
              (this.popper.style.top = ""),
              (this.popper.style.left = ""),
              (this.popper.style.right = ""),
              (this.popper.style.bottom = ""),
              (this.popper.style.willChange = ""),
              (this.popper.style[It("transform")] = "")),
          this.disableEventListeners(),
          this.options.removeOnDestroy && this.popper.parentNode.removeChild(this.popper),
          this
      );
  }
  function xt(t) {
      var e = t.ownerDocument;
      return e ? e.defaultView : window;
  }
  function jt(t, e, n, i) {
      var o = "BODY" === t.nodeName,
          r = o ? t.ownerDocument.defaultView : t;
      r.addEventListener(e, n, { passive: !0 }), o || jt(G(r.parentNode), e, n, i), i.push(r);
  }
  function Lt(t, e, n, i) {
      (n.updateBound = i), xt(t).addEventListener("resize", n.updateBound, { passive: !0 });
      var o = G(t);
      return jt(o, "scroll", n.updateBound, n.scrollParents), (n.scrollElement = o), (n.eventsEnabled = !0), n;
  }
  function Pt() {
      this.state.eventsEnabled || (this.state = Lt(this.reference, this.options, this.state, this.scheduleUpdate));
  }
  function Ft() {
      var t, e;
      this.state.eventsEnabled &&
          (cancelAnimationFrame(this.scheduleUpdate),
          (this.state =
              ((t = this.reference),
              (e = this.state),
              xt(t).removeEventListener("resize", e.updateBound),
              e.scrollParents.forEach(function (t) {
                  t.removeEventListener("scroll", e.updateBound);
              }),
              (e.updateBound = null),
              (e.scrollParents = []),
              (e.scrollElement = null),
              (e.eventsEnabled = !1),
              e)));
  }
  function Rt(t) {
      return "" !== t && !isNaN(parseFloat(t)) && isFinite(t);
  }
  function Bt(t, e) {
      Object.keys(e).forEach(function (n) {
          var i = "";
          -1 !== ["width", "height", "top", "right", "bottom", "left"].indexOf(n) && Rt(e[n]) && (i = "px"), (t.style[n] = e[n] + i);
      });
  }
  var Ht = U && /Firefox/i.test(navigator.userAgent);
  function Mt(t, e, n) {
      var i = Nt(t, function (t) {
              return t.name === e;
          }),
          o =
              !!i &&
              t.some(function (t) {
                  return t.name === n && t.enabled && t.order < i.order;
              });
      if (!o) {
          var r = "`" + e + "`",
              a = "`" + n + "`";
          console.warn(a + " modifier is required by " + r + " modifier in order to work, be sure to include it before " + r + "!");
      }
      return o;
  }
  var qt = ["auto-start", "auto", "auto-end", "top-start", "top", "top-end", "right-start", "right", "right-end", "bottom-end", "bottom", "bottom-start", "left-end", "left", "left-start"],
      Qt = qt.slice(3);
  function Wt(t) {
      var e = arguments.length > 1 && void 0 !== arguments[1] && arguments[1],
          n = Qt.indexOf(t),
          i = Qt.slice(n + 1).concat(Qt.slice(0, n));
      return e ? i.reverse() : i;
  }
  var Ut = {
          placement: "bottom",
          positionFixed: !1,
          eventsEnabled: !0,
          removeOnDestroy: !1,
          onCreate: function () {},
          onUpdate: function () {},
          modifiers: {
              shift: {
                  order: 100,
                  enabled: !0,
                  fn: function (t) {
                      var e = t.placement,
                          n = e.split("-")[0],
                          i = e.split("-")[1];
                      if (i) {
                          var o = t.offsets,
                              r = o.reference,
                              a = o.popper,
                              s = -1 !== ["bottom", "top"].indexOf(n),
                              l = s ? "left" : "top",
                              u = s ? "width" : "height",
                              f = { start: dt({}, l, r[l]), end: dt({}, l, r[l] + r[u] - a[u]) };
                          t.offsets.popper = ct({}, a, f[i]);
                      }
                      return t;
                  },
              },
              offset: {
                  order: 200,
                  enabled: !0,
                  fn: function (t, e) {
                      var n,
                          i = e.offset,
                          o = t.placement,
                          r = t.offsets,
                          a = r.popper,
                          s = r.reference,
                          l = o.split("-")[0];
                      return (
                          (n = Rt(+i)
                              ? [+i, 0]
                              : (function (t, e, n, i) {
                                    var o = [0, 0],
                                        r = -1 !== ["right", "left"].indexOf(i),
                                        a = t.split(/(\+|\-)/).map(function (t) {
                                            return t.trim();
                                        }),
                                        s = a.indexOf(
                                            Nt(a, function (t) {
                                                return -1 !== t.search(/,|\s/);
                                            })
                                        );
                                    a[s] && -1 === a[s].indexOf(",") && console.warn("Offsets separated by white space(s) are deprecated, use a comma (,) instead.");
                                    var l = /\s*,\s*|\s+/,
                                        u = -1 !== s ? [a.slice(0, s).concat([a[s].split(l)[0]]), [a[s].split(l)[1]].concat(a.slice(s + 1))] : [a];
                                    return (
                                        (u = u.map(function (t, i) {
                                            var o = (1 === i ? !r : r) ? "height" : "width",
                                                a = !1;
                                            return t
                                                .reduce(function (t, e) {
                                                    return "" === t[t.length - 1] && -1 !== ["+", "-"].indexOf(e) ? ((t[t.length - 1] = e), (a = !0), t) : a ? ((t[t.length - 1] += e), (a = !1), t) : t.concat(e);
                                                }, [])
                                                .map(function (t) {
                                                    return (function (t, e, n, i) {
                                                        var o = t.match(/((?:\-|\+)?\d*\.?\d*)(.*)/),
                                                            r = +o[1],
                                                            a = o[2];
                                                        return r
                                                            ? 0 === a.indexOf("%")
                                                                ? (ht("%p" === a ? n : i)[e] / 100) * r
                                                                : "vh" === a || "vw" === a
                                                                ? (("vh" === a ? Math.max(document.documentElement.clientHeight, window.innerHeight || 0) : Math.max(document.documentElement.clientWidth, window.innerWidth || 0)) / 100) * r
                                                                : r
                                                            : t;
                                                    })(t, o, e, n);
                                                });
                                        })),
                                        u.forEach(function (t, e) {
                                            t.forEach(function (n, i) {
                                                Rt(n) && (o[e] += n * ("-" === t[i - 1] ? -1 : 1));
                                            });
                                        }),
                                        o
                                    );
                                })(i, a, s, l)),
                          "left" === l
                              ? ((a.top += n[0]), (a.left -= n[1]))
                              : "right" === l
                              ? ((a.top += n[0]), (a.left += n[1]))
                              : "top" === l
                              ? ((a.left += n[0]), (a.top -= n[1]))
                              : "bottom" === l && ((a.left += n[0]), (a.top += n[1])),
                          (t.popper = a),
                          t
                      );
                  },
                  offset: 0,
              },
              preventOverflow: {
                  order: 300,
                  enabled: !0,
                  fn: function (t, e) {
                      var n = e.boundariesElement || et(t.instance.popper);
                      t.instance.reference === n && (n = et(n));
                      var i = It("transform"),
                          o = t.instance.popper.style,
                          r = o.top,
                          a = o.left,
                          s = o[i];
                      (o.top = ""), (o.left = ""), (o[i] = "");
                      var l = bt(t.instance.popper, t.instance.reference, e.padding, n, t.positionFixed);
                      (o.top = r), (o.left = a), (o[i] = s), (e.boundaries = l);
                      var u = e.priority,
                          f = t.offsets.popper,
                          d = {
                              primary: function (t) {
                                  var n = f[t];
                                  return f[t] < l[t] && !e.escapeWithReference && (n = Math.max(f[t], l[t])), dt({}, t, n);
                              },
                              secondary: function (t) {
                                  var n = "right" === t ? "left" : "top",
                                      i = f[n];
                                  return f[t] > l[t] && !e.escapeWithReference && (i = Math.min(f[n], l[t] - ("right" === t ? f.width : f.height))), dt({}, n, i);
                              },
                          };
                      return (
                          u.forEach(function (t) {
                              var e = -1 !== ["left", "top"].indexOf(t) ? "primary" : "secondary";
                              f = ct({}, f, d[e](t));
                          }),
                          (t.offsets.popper = f),
                          t
                      );
                  },
                  priority: ["left", "right", "top", "bottom"],
                  padding: 5,
                  boundariesElement: "scrollParent",
              },
              keepTogether: {
                  order: 400,
                  enabled: !0,
                  fn: function (t) {
                      var e = t.offsets,
                          n = e.popper,
                          i = e.reference,
                          o = t.placement.split("-")[0],
                          r = Math.floor,
                          a = -1 !== ["top", "bottom"].indexOf(o),
                          s = a ? "right" : "bottom",
                          l = a ? "left" : "top",
                          u = a ? "width" : "height";
                      return n[s] < r(i[l]) && (t.offsets.popper[l] = r(i[l]) - n[u]), n[l] > r(i[s]) && (t.offsets.popper[l] = r(i[s])), t;
                  },
              },
              arrow: {
                  order: 500,
                  enabled: !0,
                  fn: function (t, e) {
                      var n;
                      if (!Mt(t.instance.modifiers, "arrow", "keepTogether")) return t;
                      var i = e.element;
                      if ("string" == typeof i) {
                          if (!(i = t.instance.popper.querySelector(i))) return t;
                      } else if (!t.instance.popper.contains(i)) return console.warn("WARNING: `arrow.element` must be child of its popper element!"), t;
                      var o = t.placement.split("-")[0],
                          r = t.offsets,
                          a = r.popper,
                          s = r.reference,
                          l = -1 !== ["left", "right"].indexOf(o),
                          u = l ? "height" : "width",
                          f = l ? "Top" : "Left",
                          d = f.toLowerCase(),
                          c = l ? "left" : "top",
                          h = l ? "bottom" : "right",
                          p = Tt(i)[u];
                      s[h] - p < a[d] && (t.offsets.popper[d] -= a[d] - (s[h] - p)), s[d] + p > a[h] && (t.offsets.popper[d] += s[d] + p - a[h]), (t.offsets.popper = ht(t.offsets.popper));
                      var m = s[d] + s[u] / 2 - p / 2,
                          g = K(t.instance.popper),
                          _ = parseFloat(g["margin" + f]),
                          v = parseFloat(g["border" + f + "Width"]),
                          b = m - t.offsets.popper[d] - _ - v;
                      return (b = Math.max(Math.min(a[u] - p, b), 0)), (t.arrowElement = i), (t.offsets.arrow = (dt((n = {}), d, Math.round(b)), dt(n, c, ""), n)), t;
                  },
                  element: "[x-arrow]",
              },
              flip: {
                  order: 600,
                  enabled: !0,
                  fn: function (t, e) {
                      if (kt(t.instance.modifiers, "inner")) return t;
                      if (t.flipped && t.placement === t.originalPlacement) return t;
                      var n = bt(t.instance.popper, t.instance.reference, e.padding, e.boundariesElement, t.positionFixed),
                          i = t.placement.split("-")[0],
                          o = Ct(i),
                          r = t.placement.split("-")[1] || "",
                          a = [];
                      switch (e.behavior) {
                          case "flip":
                              a = [i, o];
                              break;
                          case "clockwise":
                              a = Wt(i);
                              break;
                          case "counterclockwise":
                              a = Wt(i, !0);
                              break;
                          default:
                              a = e.behavior;
                      }
                      return (
                          a.forEach(function (s, l) {
                              if (i !== s || a.length === l + 1) return t;
                              (i = t.placement.split("-")[0]), (o = Ct(i));
                              var u = t.offsets.popper,
                                  f = t.offsets.reference,
                                  d = Math.floor,
                                  c = ("left" === i && d(u.right) > d(f.left)) || ("right" === i && d(u.left) < d(f.right)) || ("top" === i && d(u.bottom) > d(f.top)) || ("bottom" === i && d(u.top) < d(f.bottom)),
                                  h = d(u.left) < d(n.left),
                                  p = d(u.right) > d(n.right),
                                  m = d(u.top) < d(n.top),
                                  g = d(u.bottom) > d(n.bottom),
                                  _ = ("left" === i && h) || ("right" === i && p) || ("top" === i && m) || ("bottom" === i && g),
                                  v = -1 !== ["top", "bottom"].indexOf(i),
                                  b = !!e.flipVariations && ((v && "start" === r && h) || (v && "end" === r && p) || (!v && "start" === r && m) || (!v && "end" === r && g)),
                                  y = !!e.flipVariationsByContent && ((v && "start" === r && p) || (v && "end" === r && h) || (!v && "start" === r && g) || (!v && "end" === r && m)),
                                  E = b || y;
                              (c || _ || E) &&
                                  ((t.flipped = !0),
                                  (c || _) && (i = a[l + 1]),
                                  E &&
                                      (r = (function (t) {
                                          return "end" === t ? "start" : "start" === t ? "end" : t;
                                      })(r)),
                                  (t.placement = i + (r ? "-" + r : "")),
                                  (t.offsets.popper = ct({}, t.offsets.popper, St(t.instance.popper, t.offsets.reference, t.placement))),
                                  (t = Dt(t.instance.modifiers, t, "flip")));
                          }),
                          t
                      );
                  },
                  behavior: "flip",
                  padding: 5,
                  boundariesElement: "viewport",
                  flipVariations: !1,
                  flipVariationsByContent: !1,
              },
              inner: {
                  order: 700,
                  enabled: !1,
                  fn: function (t) {
                      var e = t.placement,
                          n = e.split("-")[0],
                          i = t.offsets,
                          o = i.popper,
                          r = i.reference,
                          a = -1 !== ["left", "right"].indexOf(n),
                          s = -1 === ["top", "left"].indexOf(n);
                      return (o[a ? "left" : "top"] = r[n] - (s ? o[a ? "width" : "height"] : 0)), (t.placement = Ct(e)), (t.offsets.popper = ht(o)), t;
                  },
              },
              hide: {
                  order: 800,
                  enabled: !0,
                  fn: function (t) {
                      if (!Mt(t.instance.modifiers, "hide", "preventOverflow")) return t;
                      var e = t.offsets.reference,
                          n = Nt(t.instance.modifiers, function (t) {
                              return "preventOverflow" === t.name;
                          }).boundaries;
                      if (e.bottom < n.top || e.left > n.right || e.top > n.bottom || e.right < n.left) {
                          if (!0 === t.hide) return t;
                          (t.hide = !0), (t.attributes["x-out-of-boundaries"] = "");
                      } else {
                          if (!1 === t.hide) return t;
                          (t.hide = !1), (t.attributes["x-out-of-boundaries"] = !1);
                      }
                      return t;
                  },
              },
              computeStyle: {
                  order: 850,
                  enabled: !0,
                  fn: function (t, e) {
                      var n = e.x,
                          i = e.y,
                          o = t.offsets.popper,
                          r = Nt(t.instance.modifiers, function (t) {
                              return "applyStyle" === t.name;
                          }).gpuAcceleration;
                      void 0 !== r && console.warn("WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!");
                      var a,
                          s,
                          l = void 0 !== r ? r : e.gpuAcceleration,
                          u = et(t.instance.popper),
                          f = pt(u),
                          d = { position: o.position },
                          c = (function (t, e) {
                              var n = t.offsets,
                                  i = n.popper,
                                  o = n.reference,
                                  r = Math.round,
                                  a = Math.floor,
                                  s = function (t) {
                                      return t;
                                  },
                                  l = r(o.width),
                                  u = r(i.width),
                                  f = -1 !== ["left", "right"].indexOf(t.placement),
                                  d = -1 !== t.placement.indexOf("-"),
                                  c = e ? (f || d || l % 2 == u % 2 ? r : a) : s,
                                  h = e ? r : s;
                              return { left: c(l % 2 == 1 && u % 2 == 1 && !d && e ? i.left - 1 : i.left), top: h(i.top), bottom: h(i.bottom), right: c(i.right) };
                          })(t, window.devicePixelRatio < 2 || !Ht),
                          h = "bottom" === n ? "top" : "bottom",
                          p = "right" === i ? "left" : "right",
                          m = It("transform");
                      if (
                          ((s = "bottom" === h ? ("HTML" === u.nodeName ? -u.clientHeight + c.bottom : -f.height + c.bottom) : c.top),
                          (a = "right" === p ? ("HTML" === u.nodeName ? -u.clientWidth + c.right : -f.width + c.right) : c.left),
                          l && m)
                      )
                          (d[m] = "translate3d(" + a + "px, " + s + "px, 0)"), (d[h] = 0), (d[p] = 0), (d.willChange = "transform");
                      else {
                          var g = "bottom" === h ? -1 : 1,
                              _ = "right" === p ? -1 : 1;
                          (d[h] = s * g), (d[p] = a * _), (d.willChange = h + ", " + p);
                      }
                      var v = { "x-placement": t.placement };
                      return (t.attributes = ct({}, v, t.attributes)), (t.styles = ct({}, d, t.styles)), (t.arrowStyles = ct({}, t.offsets.arrow, t.arrowStyles)), t;
                  },
                  gpuAcceleration: !0,
                  x: "bottom",
                  y: "right",
              },
              applyStyle: {
                  order: 900,
                  enabled: !0,
                  fn: function (t) {
                      var e, n;
                      return (
                          Bt(t.instance.popper, t.styles),
                          (e = t.instance.popper),
                          (n = t.attributes),
                          Object.keys(n).forEach(function (t) {
                              !1 !== n[t] ? e.setAttribute(t, n[t]) : e.removeAttribute(t);
                          }),
                          t.arrowElement && Object.keys(t.arrowStyles).length && Bt(t.arrowElement, t.arrowStyles),
                          t
                      );
                  },
                  onLoad: function (t, e, n, i, o) {
                      var r = wt(o, e, t, n.positionFixed),
                          a = Et(n.placement, r, e, t, n.modifiers.flip.boundariesElement, n.modifiers.flip.padding);
                      return e.setAttribute("x-placement", a), Bt(e, { position: n.positionFixed ? "fixed" : "absolute" }), n;
                  },
                  gpuAcceleration: void 0,
              },
          },
      },
      Vt = (function () {
          function t(e, n) {
              var i = this,
                  o = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {};
              ut(this, t),
                  (this.scheduleUpdate = function () {
                      return requestAnimationFrame(i.update);
                  }),
                  (this.update = Y(this.update.bind(this))),
                  (this.options = ct({}, t.Defaults, o)),
                  (this.state = { isDestroyed: !1, isCreated: !1, scrollParents: [] }),
                  (this.reference = e && e.jquery ? e[0] : e),
                  (this.popper = n && n.jquery ? n[0] : n),
                  (this.options.modifiers = {}),
                  Object.keys(ct({}, t.Defaults.modifiers, o.modifiers)).forEach(function (e) {
                      i.options.modifiers[e] = ct({}, t.Defaults.modifiers[e] || {}, o.modifiers ? o.modifiers[e] : {});
                  }),
                  (this.modifiers = Object.keys(this.options.modifiers)
                      .map(function (t) {
                          return ct({ name: t }, i.options.modifiers[t]);
                      })
                      .sort(function (t, e) {
                          return t.order - e.order;
                      })),
                  this.modifiers.forEach(function (t) {
                      t.enabled && z(t.onLoad) && t.onLoad(i.reference, i.popper, i.options, t, i.state);
                  }),
                  this.update();
              var r = this.options.eventsEnabled;
              r && this.enableEventListeners(), (this.state.eventsEnabled = r);
          }
          return (
              ft(t, [
                  {
                      key: "update",
                      value: function () {
                          return At.call(this);
                      },
                  },
                  {
                      key: "destroy",
                      value: function () {
                          return Ot.call(this);
                      },
                  },
                  {
                      key: "enableEventListeners",
                      value: function () {
                          return Pt.call(this);
                      },
                  },
                  {
                      key: "disableEventListeners",
                      value: function () {
                          return Ft.call(this);
                      },
                  },
              ]),
              t
          );
      })();
  (Vt.Utils = ("undefined" != typeof window ? window : global).PopperUtils), (Vt.placements = qt), (Vt.Defaults = Ut);
  var Yt = Vt,
      zt = "dropdown",
      Kt = "bs.dropdown",
      Xt = i.default.fn[zt],
      Gt = new RegExp("38|40|27"),
      $t = "disabled",
      Jt = "show",
      Zt = "dropdown-menu-right",
      te = "hide.bs.dropdown",
      ee = "hidden.bs.dropdown",
      ne = "click.bs.dropdown.data-api",
      ie = "keydown.bs.dropdown.data-api",
      oe = '[data-toggle="dropdown"]',
      re = ".dropdown-menu",
      ae = { offset: 0, flip: !0, boundary: "scrollParent", reference: "toggle", display: "dynamic", popperConfig: null },
      se = { offset: "(number|string|function)", flip: "boolean", boundary: "(string|element)", reference: "(string|element)", display: "string", popperConfig: "(null|object)" },
      le = (function () {
          function t(t, e) {
              (this._element = t), (this._popper = null), (this._config = this._getConfig(e)), (this._menu = this._getMenuElement()), (this._inNavbar = this._detectNavbar()), this._addEventListeners();
          }
          var e = t.prototype;
          return (
              (e.toggle = function () {
                  if (!this._element.disabled && !i.default(this._element).hasClass($t)) {
                      var e = i.default(this._menu).hasClass(Jt);
                      t._clearMenus(), e || this.show(!0);
                  }
              }),
              (e.show = function (e) {
                  if ((void 0 === e && (e = !1), !(this._element.disabled || i.default(this._element).hasClass($t) || i.default(this._menu).hasClass(Jt)))) {
                      var n = { relatedTarget: this._element },
                          o = i.default.Event("show.bs.dropdown", n),
                          r = t._getParentFromElement(this._element);
                      if ((i.default(r).trigger(o), !o.isDefaultPrevented())) {
                          if (!this._inNavbar && e) {
                              if ("undefined" == typeof Yt) throw new TypeError("Bootstrap's dropdowns require Popper (https://popper.js.org)");
                              var a = this._element;
                              "parent" === this._config.reference ? (a = r) : u.isElement(this._config.reference) && ((a = this._config.reference), "undefined" != typeof this._config.reference.jquery && (a = this._config.reference[0])),
                                  "scrollParent" !== this._config.boundary && i.default(r).addClass("position-static"),
                                  (this._popper = new Yt(a, this._menu, this._getPopperConfig()));
                          }
                          "ontouchstart" in document.documentElement && 0 === i.default(r).closest(".navbar-nav").length && i.default(document.body).children().on("mouseover", null, i.default.noop),
                              this._element.focus(),
                              this._element.setAttribute("aria-expanded", !0),
                              i.default(this._menu).toggleClass(Jt),
                              i.default(r).toggleClass(Jt).trigger(i.default.Event("shown.bs.dropdown", n));
                      }
                  }
              }),
              (e.hide = function () {
                  if (!this._element.disabled && !i.default(this._element).hasClass($t) && i.default(this._menu).hasClass(Jt)) {
                      var e = { relatedTarget: this._element },
                          n = i.default.Event(te, e),
                          o = t._getParentFromElement(this._element);
                      i.default(o).trigger(n), n.isDefaultPrevented() || (this._popper && this._popper.destroy(), i.default(this._menu).toggleClass(Jt), i.default(o).toggleClass(Jt).trigger(i.default.Event(ee, e)));
                  }
              }),
              (e.dispose = function () {
                  i.default.removeData(this._element, Kt), i.default(this._element).off(".bs.dropdown"), (this._element = null), (this._menu = null), null !== this._popper && (this._popper.destroy(), (this._popper = null));
              }),
              (e.update = function () {
                  (this._inNavbar = this._detectNavbar()), null !== this._popper && this._popper.scheduleUpdate();
              }),
              (e._addEventListeners = function () {
                  var t = this;
                  i.default(this._element).on("click.bs.dropdown", function (e) {
                      e.preventDefault(), e.stopPropagation(), t.toggle();
                  });
              }),
              (e._getConfig = function (t) {
                  return (t = a({}, this.constructor.Default, i.default(this._element).data(), t)), u.typeCheckConfig(zt, t, this.constructor.DefaultType), t;
              }),
              (e._getMenuElement = function () {
                  if (!this._menu) {
                      var e = t._getParentFromElement(this._element);
                      e && (this._menu = e.querySelector(re));
                  }
                  return this._menu;
              }),
              (e._getPlacement = function () {
                  var t = i.default(this._element.parentNode),
                      e = "bottom-start";
                  return (
                      t.hasClass("dropup")
                          ? (e = i.default(this._menu).hasClass(Zt) ? "top-end" : "top-start")
                          : t.hasClass("dropright")
                          ? (e = "right-start")
                          : t.hasClass("dropleft")
                          ? (e = "left-start")
                          : i.default(this._menu).hasClass(Zt) && (e = "bottom-end"),
                      e
                  );
              }),
              (e._detectNavbar = function () {
                  return i.default(this._element).closest(".navbar").length > 0;
              }),
              (e._getOffset = function () {
                  var t = this,
                      e = {};
                  return (
                      "function" == typeof this._config.offset
                          ? (e.fn = function (e) {
                                return (e.offsets = a({}, e.offsets, t._config.offset(e.offsets, t._element))), e;
                            })
                          : (e.offset = this._config.offset),
                      e
                  );
              }),
              (e._getPopperConfig = function () {
                  var t = { placement: this._getPlacement(), modifiers: { offset: this._getOffset(), flip: { enabled: this._config.flip }, preventOverflow: { boundariesElement: this._config.boundary } } };
                  return "static" === this._config.display && (t.modifiers.applyStyle = { enabled: !1 }), a({}, t, this._config.popperConfig);
              }),
              (t._jQueryInterface = function (e) {
                  return this.each(function () {
                      var n = i.default(this).data(Kt);
                      if ((n || ((n = new t(this, "object" == typeof e ? e : null)), i.default(this).data(Kt, n)), "string" == typeof e)) {
                          if ("undefined" == typeof n[e]) throw new TypeError('No method named "' + e + '"');
                          n[e]();
                      }
                  });
              }),
              (t._clearMenus = function (e) {
                  if (!e || (3 !== e.which && ("keyup" !== e.type || 9 === e.which)))
                      for (var n = [].slice.call(document.querySelectorAll(oe)), o = 0, r = n.length; o < r; o++) {
                          var a = t._getParentFromElement(n[o]),
                              s = i.default(n[o]).data(Kt),
                              l = { relatedTarget: n[o] };
                          if ((e && "click" === e.type && (l.clickEvent = e), s)) {
                              var u = s._menu;
                              if (i.default(a).hasClass(Jt) && !(e && (("click" === e.type && /input|textarea/i.test(e.target.tagName)) || ("keyup" === e.type && 9 === e.which)) && i.default.contains(a, e.target))) {
                                  var f = i.default.Event(te, l);
                                  i.default(a).trigger(f),
                                      f.isDefaultPrevented() ||
                                          ("ontouchstart" in document.documentElement && i.default(document.body).children().off("mouseover", null, i.default.noop),
                                          n[o].setAttribute("aria-expanded", "false"),
                                          s._popper && s._popper.destroy(),
                                          i.default(u).removeClass(Jt),
                                          i.default(a).removeClass(Jt).trigger(i.default.Event(ee, l)));
                              }
                          }
                      }
              }),
              (t._getParentFromElement = function (t) {
                  var e,
                      n = u.getSelectorFromElement(t);
                  return n && (e = document.querySelector(n)), e || t.parentNode;
              }),
              (t._dataApiKeydownHandler = function (e) {
                  if (
                      !(/input|textarea/i.test(e.target.tagName) ? 32 === e.which || (27 !== e.which && ((40 !== e.which && 38 !== e.which) || i.default(e.target).closest(re).length)) : !Gt.test(e.which)) &&
                      !this.disabled &&
                      !i.default(this).hasClass($t)
                  ) {
                      var n = t._getParentFromElement(this),
                          o = i.default(n).hasClass(Jt);
                      if (o || 27 !== e.which) {
                          if ((e.preventDefault(), e.stopPropagation(), !o || 27 === e.which || 32 === e.which)) return 27 === e.which && i.default(n.querySelector(oe)).trigger("focus"), void i.default(this).trigger("click");
                          var r = [].slice.call(n.querySelectorAll(".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)")).filter(function (t) {
                              return i.default(t).is(":visible");
                          });
                          if (0 !== r.length) {
                              var a = r.indexOf(e.target);
                              38 === e.which && a > 0 && a--, 40 === e.which && a < r.length - 1 && a++, a < 0 && (a = 0), r[a].focus();
                          }
                      }
                  }
              }),
              r(t, null, [
                  {
                      key: "VERSION",
                      get: function () {
                          return "4.6.2";
                      },
                  },
                  {
                      key: "Default",
                      get: function () {
                          return ae;
                      },
                  },
                  {
                      key: "DefaultType",
                      get: function () {
                          return se;
                      },
                  },
              ]),
              t
          );
      })();
  i
      .default(document)
      .on(ie, oe, le._dataApiKeydownHandler)
      .on(ie, re, le._dataApiKeydownHandler)
      .on(ne + " keyup.bs.dropdown.data-api", le._clearMenus)
      .on(ne, oe, function (t) {
          t.preventDefault(), t.stopPropagation(), le._jQueryInterface.call(i.default(this), "toggle");
      })
      .on(ne, ".dropdown form", function (t) {
          t.stopPropagation();
      }),
      (i.default.fn[zt] = le._jQueryInterface),
      (i.default.fn[zt].Constructor = le),
      (i.default.fn[zt].noConflict = function () {
          return (i.default.fn[zt] = Xt), le._jQueryInterface;
      });
  var ue = "bs.modal",
      fe = i.default.fn.modal,
      de = "modal-open",
      ce = "fade",
      he = "show",
      pe = "modal-static",
      me = "hidden.bs.modal",
      ge = "show.bs.modal",
      _e = "focusin.bs.modal",
      ve = "resize.bs.modal",
      be = "click.dismiss.bs.modal",
      ye = "keydown.dismiss.bs.modal",
      Ee = "mousedown.dismiss.bs.modal",
      we = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top",
      Te = { backdrop: !0, keyboard: !0, focus: !0, show: !0 },
      Ce = { backdrop: "(boolean|string)", keyboard: "boolean", focus: "boolean", show: "boolean" },
      Se = (function () {
          function t(t, e) {
              (this._config = this._getConfig(e)),
                  (this._element = t),
                  (this._dialog = t.querySelector(".modal-dialog")),
                  (this._backdrop = null),
                  (this._isShown = !1),
                  (this._isBodyOverflowing = !1),
                  (this._ignoreBackdropClick = !1),
                  (this._isTransitioning = !1),
                  (this._scrollbarWidth = 0);
          }
          var e = t.prototype;
          return (
              (e.toggle = function (t) {
                  return this._isShown ? this.hide() : this.show(t);
              }),
              (e.show = function (t) {
                  var e = this;
                  if (!this._isShown && !this._isTransitioning) {
                      var n = i.default.Event(ge, { relatedTarget: t });
                      i.default(this._element).trigger(n),
                          n.isDefaultPrevented() ||
                              ((this._isShown = !0),
                              i.default(this._element).hasClass(ce) && (this._isTransitioning = !0),
                              this._checkScrollbar(),
                              this._setScrollbar(),
                              this._adjustDialog(),
                              this._setEscapeEvent(),
                              this._setResizeEvent(),
                              i.default(this._element).on(be, '[data-dismiss="modal"]', function (t) {
                                  return e.hide(t);
                              }),
                              i.default(this._dialog).on(Ee, function () {
                                  i.default(e._element).one("mouseup.dismiss.bs.modal", function (t) {
                                      i.default(t.target).is(e._element) && (e._ignoreBackdropClick = !0);
                                  });
                              }),
                              this._showBackdrop(function () {
                                  return e._showElement(t);
                              }));
                  }
              }),
              (e.hide = function (t) {
                  var e = this;
                  if ((t && t.preventDefault(), this._isShown && !this._isTransitioning)) {
                      var n = i.default.Event("hide.bs.modal");
                      if ((i.default(this._element).trigger(n), this._isShown && !n.isDefaultPrevented())) {
                          this._isShown = !1;
                          var o = i.default(this._element).hasClass(ce);
                          if (
                              (o && (this._isTransitioning = !0),
                              this._setEscapeEvent(),
                              this._setResizeEvent(),
                              i.default(document).off(_e),
                              i.default(this._element).removeClass(he),
                              i.default(this._element).off(be),
                              i.default(this._dialog).off(Ee),
                              o)
                          ) {
                              var r = u.getTransitionDurationFromElement(this._element);
                              i.default(this._element)
                                  .one(u.TRANSITION_END, function (t) {
                                      return e._hideModal(t);
                                  })
                                  .emulateTransitionEnd(r);
                          } else this._hideModal();
                      }
                  }
              }),
              (e.dispose = function () {
                  [window, this._element, this._dialog].forEach(function (t) {
                      return i.default(t).off(".bs.modal");
                  }),
                      i.default(document).off(_e),
                      i.default.removeData(this._element, ue),
                      (this._config = null),
                      (this._element = null),
                      (this._dialog = null),
                      (this._backdrop = null),
                      (this._isShown = null),
                      (this._isBodyOverflowing = null),
                      (this._ignoreBackdropClick = null),
                      (this._isTransitioning = null),
                      (this._scrollbarWidth = null);
              }),
              (e.handleUpdate = function () {
                  this._adjustDialog();
              }),
              (e._getConfig = function (t) {
                  return (t = a({}, Te, t)), u.typeCheckConfig("modal", t, Ce), t;
              }),
              (e._triggerBackdropTransition = function () {
                  var t = this,
                      e = i.default.Event("hidePrevented.bs.modal");
                  if ((i.default(this._element).trigger(e), !e.isDefaultPrevented())) {
                      var n = this._element.scrollHeight > document.documentElement.clientHeight;
                      n || (this._element.style.overflowY = "hidden"), this._element.classList.add(pe);
                      var o = u.getTransitionDurationFromElement(this._dialog);
                      i.default(this._element).off(u.TRANSITION_END),
                          i
                              .default(this._element)
                              .one(u.TRANSITION_END, function () {
                                  t._element.classList.remove(pe),
                                      n ||
                                          i
                                              .default(t._element)
                                              .one(u.TRANSITION_END, function () {
                                                  t._element.style.overflowY = "";
                                              })
                                              .emulateTransitionEnd(t._element, o);
                              })
                              .emulateTransitionEnd(o),
                          this._element.focus();
                  }
              }),
              (e._showElement = function (t) {
                  var e = this,
                      n = i.default(this._element).hasClass(ce),
                      o = this._dialog ? this._dialog.querySelector(".modal-body") : null;
                  (this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE) || document.body.appendChild(this._element),
                      (this._element.style.display = "block"),
                      this._element.removeAttribute("aria-hidden"),
                      this._element.setAttribute("aria-modal", !0),
                      this._element.setAttribute("role", "dialog"),
                      i.default(this._dialog).hasClass("modal-dialog-scrollable") && o ? (o.scrollTop = 0) : (this._element.scrollTop = 0),
                      n && u.reflow(this._element),
                      i.default(this._element).addClass(he),
                      this._config.focus && this._enforceFocus();
                  var r = i.default.Event("shown.bs.modal", { relatedTarget: t }),
                      a = function () {
                          e._config.focus && e._element.focus(), (e._isTransitioning = !1), i.default(e._element).trigger(r);
                      };
                  if (n) {
                      var s = u.getTransitionDurationFromElement(this._dialog);
                      i.default(this._dialog).one(u.TRANSITION_END, a).emulateTransitionEnd(s);
                  } else a();
              }),
              (e._enforceFocus = function () {
                  var t = this;
                  i.default(document)
                      .off(_e)
                      .on(_e, function (e) {
                          document !== e.target && t._element !== e.target && 0 === i.default(t._element).has(e.target).length && t._element.focus();
                      });
              }),
              (e._setEscapeEvent = function () {
                  var t = this;
                  this._isShown
                      ? i.default(this._element).on(ye, function (e) {
                            t._config.keyboard && 27 === e.which ? (e.preventDefault(), t.hide()) : t._config.keyboard || 27 !== e.which || t._triggerBackdropTransition();
                        })
                      : this._isShown || i.default(this._element).off(ye);
              }),
              (e._setResizeEvent = function () {
                  var t = this;
                  this._isShown
                      ? i.default(window).on(ve, function (e) {
                            return t.handleUpdate(e);
                        })
                      : i.default(window).off(ve);
              }),
              (e._hideModal = function () {
                  var t = this;
                  (this._element.style.display = "none"),
                      this._element.setAttribute("aria-hidden", !0),
                      this._element.removeAttribute("aria-modal"),
                      this._element.removeAttribute("role"),
                      (this._isTransitioning = !1),
                      this._showBackdrop(function () {
                          i.default(document.body).removeClass(de), t._resetAdjustments(), t._resetScrollbar(), i.default(t._element).trigger(me);
                      });
              }),
              (e._removeBackdrop = function () {
                  this._backdrop && (i.default(this._backdrop).remove(), (this._backdrop = null));
              }),
              (e._showBackdrop = function (t) {
                  var e = this,
                      n = i.default(this._element).hasClass(ce) ? ce : "";
                  if (this._isShown && this._config.backdrop) {
                      if (
                          ((this._backdrop = document.createElement("div")),
                          (this._backdrop.className = "modal-backdrop"),
                          n && this._backdrop.classList.add(n),
                          i.default(this._backdrop).appendTo(document.body),
                          i.default(this._element).on(be, function (t) {
                              e._ignoreBackdropClick ? (e._ignoreBackdropClick = !1) : t.target === t.currentTarget && ("static" === e._config.backdrop ? e._triggerBackdropTransition() : e.hide());
                          }),
                          n && u.reflow(this._backdrop),
                          i.default(this._backdrop).addClass(he),
                          !t)
                      )
                          return;
                      if (!n) return void t();
                      var o = u.getTransitionDurationFromElement(this._backdrop);
                      i.default(this._backdrop).one(u.TRANSITION_END, t).emulateTransitionEnd(o);
                  } else if (!this._isShown && this._backdrop) {
                      i.default(this._backdrop).removeClass(he);
                      var r = function () {
                          e._removeBackdrop(), t && t();
                      };
                      if (i.default(this._element).hasClass(ce)) {
                          var a = u.getTransitionDurationFromElement(this._backdrop);
                          i.default(this._backdrop).one(u.TRANSITION_END, r).emulateTransitionEnd(a);
                      } else r();
                  } else t && t();
              }),
              (e._adjustDialog = function () {
                  var t = this._element.scrollHeight > document.documentElement.clientHeight;
                  !this._isBodyOverflowing && t && (this._element.style.paddingLeft = this._scrollbarWidth + "px"), this._isBodyOverflowing && !t && (this._element.style.paddingRight = this._scrollbarWidth + "px");
              }),
              (e._resetAdjustments = function () {
                  (this._element.style.paddingLeft = ""), (this._element.style.paddingRight = "");
              }),
              (e._checkScrollbar = function () {
                  var t = document.body.getBoundingClientRect();
                  (this._isBodyOverflowing = Math.round(t.left + t.right) < window.innerWidth), (this._scrollbarWidth = this._getScrollbarWidth());
              }),
              (e._setScrollbar = function () {
                  var t = this;
                  if (this._isBodyOverflowing) {
                      var e = [].slice.call(document.querySelectorAll(we)),
                          n = [].slice.call(document.querySelectorAll(".sticky-top"));
                      i.default(e).each(function (e, n) {
                          var o = n.style.paddingRight,
                              r = i.default(n).css("padding-right");
                          i.default(n)
                              .data("padding-right", o)
                              .css("padding-right", parseFloat(r) + t._scrollbarWidth + "px");
                      }),
                          i.default(n).each(function (e, n) {
                              var o = n.style.marginRight,
                                  r = i.default(n).css("margin-right");
                              i.default(n)
                                  .data("margin-right", o)
                                  .css("margin-right", parseFloat(r) - t._scrollbarWidth + "px");
                          });
                      var o = document.body.style.paddingRight,
                          r = i.default(document.body).css("padding-right");
                      i.default(document.body)
                          .data("padding-right", o)
                          .css("padding-right", parseFloat(r) + this._scrollbarWidth + "px");
                  }
                  i.default(document.body).addClass(de);
              }),
              (e._resetScrollbar = function () {
                  var t = [].slice.call(document.querySelectorAll(we));
                  i.default(t).each(function (t, e) {
                      var n = i.default(e).data("padding-right");
                      i.default(e).removeData("padding-right"), (e.style.paddingRight = n || "");
                  });
                  var e = [].slice.call(document.querySelectorAll(".sticky-top"));
                  i.default(e).each(function (t, e) {
                      var n = i.default(e).data("margin-right");
                      "undefined" != typeof n && i.default(e).css("margin-right", n).removeData("margin-right");
                  });
                  var n = i.default(document.body).data("padding-right");
                  i.default(document.body).removeData("padding-right"), (document.body.style.paddingRight = n || "");
              }),
              (e._getScrollbarWidth = function () {
                  var t = document.createElement("div");
                  (t.className = "modal-scrollbar-measure"), document.body.appendChild(t);
                  var e = t.getBoundingClientRect().width - t.clientWidth;
                  return document.body.removeChild(t), e;
              }),
              (t._jQueryInterface = function (e, n) {
                  return this.each(function () {
                      var o = i.default(this).data(ue),
                          r = a({}, Te, i.default(this).data(), "object" == typeof e && e ? e : {});
                      if ((o || ((o = new t(this, r)), i.default(this).data(ue, o)), "string" == typeof e)) {
                          if ("undefined" == typeof o[e]) throw new TypeError('No method named "' + e + '"');
                          o[e](n);
                      } else r.show && o.show(n);
                  });
              }),
              r(t, null, [
                  {
                      key: "VERSION",
                      get: function () {
                          return "4.6.2";
                      },
                  },
                  {
                      key: "Default",
                      get: function () {
                          return Te;
                      },
                  },
              ]),
              t
          );
      })();
  i.default(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function (t) {
      var e,
          n = this,
          o = u.getSelectorFromElement(this);
      o && (e = document.querySelector(o));
      var r = i.default(e).data(ue) ? "toggle" : a({}, i.default(e).data(), i.default(this).data());
      ("A" !== this.tagName && "AREA" !== this.tagName) || t.preventDefault();
      var s = i.default(e).one(ge, function (t) {
          t.isDefaultPrevented() ||
              s.one(me, function () {
                  i.default(n).is(":visible") && n.focus();
              });
      });
      Se._jQueryInterface.call(i.default(e), r, this);
  }),
      (i.default.fn.modal = Se._jQueryInterface),
      (i.default.fn.modal.Constructor = Se),
      (i.default.fn.modal.noConflict = function () {
          return (i.default.fn.modal = fe), Se._jQueryInterface;
      });
  var Ne = ["background", "cite", "href", "itemtype", "longdesc", "poster", "src", "xlink:href"],
      De = /^(?:(?:https?|mailto|ftp|tel|file|sms):|[^#&/:?]*(?:[#/?]|$))/i,
      Ae = /^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[\d+/a-z]+=*$/i;
  function ke(t, e, n) {
      if (0 === t.length) return t;
      if (n && "function" == typeof n) return n(t);
      for (
          var i = new window.DOMParser().parseFromString(t, "text/html"),
              o = Object.keys(e),
              r = [].slice.call(i.body.querySelectorAll("*")),
              a = function (t, n) {
                  var i = r[t],
                      a = i.nodeName.toLowerCase();
                  if (-1 === o.indexOf(i.nodeName.toLowerCase())) return i.parentNode.removeChild(i), "continue";
                  var s = [].slice.call(i.attributes),
                      l = [].concat(e["*"] || [], e[a] || []);
                  s.forEach(function (t) {
                      (function (t, e) {
                          var n = t.nodeName.toLowerCase();
                          if (-1 !== e.indexOf(n)) return -1 === Ne.indexOf(n) || Boolean(De.test(t.nodeValue) || Ae.test(t.nodeValue));
                          for (
                              var i = e.filter(function (t) {
                                      return t instanceof RegExp;
                                  }),
                                  o = 0,
                                  r = i.length;
                              o < r;
                              o++
                          )
                              if (i[o].test(n)) return !0;
                          return !1;
                      })(t, l) || i.removeAttribute(t.nodeName);
                  });
              },
              s = 0,
              l = r.length;
          s < l;
          s++
      )
          a(s);
      return i.body.innerHTML;
  }
  var Ie = "tooltip",
      Oe = "bs.tooltip",
      xe = i.default.fn.tooltip,
      je = new RegExp("(^|\\s)bs-tooltip\\S+", "g"),
      Le = ["sanitize", "whiteList", "sanitizeFn"],
      Pe = "fade",
      Fe = "show",
      Re = "show",
      Be = "out",
      He = "hover",
      Me = "focus",
      qe = { AUTO: "auto", TOP: "top", RIGHT: "right", BOTTOM: "bottom", LEFT: "left" },
      Qe = {
          animation: !0,
          template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
          trigger: "hover focus",
          title: "",
          delay: 0,
          html: !1,
          selector: !1,
          placement: "top",
          offset: 0,
          container: !1,
          fallbackPlacement: "flip",
          boundary: "scrollParent",
          customClass: "",
          sanitize: !0,
          sanitizeFn: null,
          whiteList: {
              "*": ["class", "dir", "id", "lang", "role", /^aria-[\w-]*$/i],
              a: ["target", "href", "title", "rel"],
              area: [],
              b: [],
              br: [],
              col: [],
              code: [],
              div: [],
              em: [],
              hr: [],
              h1: [],
              h2: [],
              h3: [],
              h4: [],
              h5: [],
              h6: [],
              i: [],
              img: ["src", "srcset", "alt", "title", "width", "height"],
              li: [],
              ol: [],
              p: [],
              pre: [],
              s: [],
              small: [],
              span: [],
              sub: [],
              sup: [],
              strong: [],
              u: [],
              ul: [],
          },
          popperConfig: null,
      },
      We = {
          animation: "boolean",
          template: "string",
          title: "(string|element|function)",
          trigger: "string",
          delay: "(number|object)",
          html: "boolean",
          selector: "(string|boolean)",
          placement: "(string|function)",
          offset: "(number|string|function)",
          container: "(string|element|boolean)",
          fallbackPlacement: "(string|array)",
          boundary: "(string|element)",
          customClass: "(string|function)",
          sanitize: "boolean",
          sanitizeFn: "(null|function)",
          whiteList: "object",
          popperConfig: "(null|object)",
      },
      Ue = {
          HIDE: "hide.bs.tooltip",
          HIDDEN: "hidden.bs.tooltip",
          SHOW: "show.bs.tooltip",
          SHOWN: "shown.bs.tooltip",
          INSERTED: "inserted.bs.tooltip",
          CLICK: "click.bs.tooltip",
          FOCUSIN: "focusin.bs.tooltip",
          FOCUSOUT: "focusout.bs.tooltip",
          MOUSEENTER: "mouseenter.bs.tooltip",
          MOUSELEAVE: "mouseleave.bs.tooltip",
      },
      Ve = (function () {
          function t(t, e) {
              if ("undefined" == typeof Yt) throw new TypeError("Bootstrap's tooltips require Popper (https://popper.js.org)");
              (this._isEnabled = !0), (this._timeout = 0), (this._hoverState = ""), (this._activeTrigger = {}), (this._popper = null), (this.element = t), (this.config = this._getConfig(e)), (this.tip = null), this._setListeners();
          }
          var e = t.prototype;
          return (
              (e.enable = function () {
                  this._isEnabled = !0;
              }),
              (e.disable = function () {
                  this._isEnabled = !1;
              }),
              (e.toggleEnabled = function () {
                  this._isEnabled = !this._isEnabled;
              }),
              (e.toggle = function (t) {
                  if (this._isEnabled)
                      if (t) {
                          var e = this.constructor.DATA_KEY,
                              n = i.default(t.currentTarget).data(e);
                          n || ((n = new this.constructor(t.currentTarget, this._getDelegateConfig())), i.default(t.currentTarget).data(e, n)),
                              (n._activeTrigger.click = !n._activeTrigger.click),
                              n._isWithActiveTrigger() ? n._enter(null, n) : n._leave(null, n);
                      } else {
                          if (i.default(this.getTipElement()).hasClass(Fe)) return void this._leave(null, this);
                          this._enter(null, this);
                      }
              }),
              (e.dispose = function () {
                  clearTimeout(this._timeout),
                      i.default.removeData(this.element, this.constructor.DATA_KEY),
                      i.default(this.element).off(this.constructor.EVENT_KEY),
                      i.default(this.element).closest(".modal").off("hide.bs.modal", this._hideModalHandler),
                      this.tip && i.default(this.tip).remove(),
                      (this._isEnabled = null),
                      (this._timeout = null),
                      (this._hoverState = null),
                      (this._activeTrigger = null),
                      this._popper && this._popper.destroy(),
                      (this._popper = null),
                      (this.element = null),
                      (this.config = null),
                      (this.tip = null);
              }),
              (e.show = function () {
                  var t = this;
                  if ("none" === i.default(this.element).css("display")) throw new Error("Please use show on visible elements");
                  var e = i.default.Event(this.constructor.Event.SHOW);
                  if (this.isWithContent() && this._isEnabled) {
                      i.default(this.element).trigger(e);
                      var n = u.findShadowRoot(this.element),
                          o = i.default.contains(null !== n ? n : this.element.ownerDocument.documentElement, this.element);
                      if (e.isDefaultPrevented() || !o) return;
                      var r = this.getTipElement(),
                          a = u.getUID(this.constructor.NAME);
                      r.setAttribute("id", a), this.element.setAttribute("aria-describedby", a), this.setContent(), this.config.animation && i.default(r).addClass(Pe);
                      var s = "function" == typeof this.config.placement ? this.config.placement.call(this, r, this.element) : this.config.placement,
                          l = this._getAttachment(s);
                      this.addAttachmentClass(l);
                      var f = this._getContainer();
                      i.default(r).data(this.constructor.DATA_KEY, this),
                          i.default.contains(this.element.ownerDocument.documentElement, this.tip) || i.default(r).appendTo(f),
                          i.default(this.element).trigger(this.constructor.Event.INSERTED),
                          (this._popper = new Yt(this.element, r, this._getPopperConfig(l))),
                          i.default(r).addClass(Fe),
                          i.default(r).addClass(this.config.customClass),
                          "ontouchstart" in document.documentElement && i.default(document.body).children().on("mouseover", null, i.default.noop);
                      var d = function () {
                          t.config.animation && t._fixTransition();
                          var e = t._hoverState;
                          (t._hoverState = null), i.default(t.element).trigger(t.constructor.Event.SHOWN), e === Be && t._leave(null, t);
                      };
                      if (i.default(this.tip).hasClass(Pe)) {
                          var c = u.getTransitionDurationFromElement(this.tip);
                          i.default(this.tip).one(u.TRANSITION_END, d).emulateTransitionEnd(c);
                      } else d();
                  }
              }),
              (e.hide = function (t) {
                  var e = this,
                      n = this.getTipElement(),
                      o = i.default.Event(this.constructor.Event.HIDE),
                      r = function () {
                          e._hoverState !== Re && n.parentNode && n.parentNode.removeChild(n),
                              e._cleanTipClass(),
                              e.element.removeAttribute("aria-describedby"),
                              i.default(e.element).trigger(e.constructor.Event.HIDDEN),
                              null !== e._popper && e._popper.destroy(),
                              t && t();
                      };
                  if ((i.default(this.element).trigger(o), !o.isDefaultPrevented())) {
                      if (
                          (i.default(n).removeClass(Fe),
                          "ontouchstart" in document.documentElement && i.default(document.body).children().off("mouseover", null, i.default.noop),
                          (this._activeTrigger.click = !1),
                          (this._activeTrigger.focus = !1),
                          (this._activeTrigger.hover = !1),
                          i.default(this.tip).hasClass(Pe))
                      ) {
                          var a = u.getTransitionDurationFromElement(n);
                          i.default(n).one(u.TRANSITION_END, r).emulateTransitionEnd(a);
                      } else r();
                      this._hoverState = "";
                  }
              }),
              (e.update = function () {
                  null !== this._popper && this._popper.scheduleUpdate();
              }),
              (e.isWithContent = function () {
                  return Boolean(this.getTitle());
              }),
              (e.addAttachmentClass = function (t) {
                  i.default(this.getTipElement()).addClass("bs-tooltip-" + t);
              }),
              (e.getTipElement = function () {
                  return (this.tip = this.tip || i.default(this.config.template)[0]), this.tip;
              }),
              (e.setContent = function () {
                  var t = this.getTipElement();
                  this.setElementContent(i.default(t.querySelectorAll(".tooltip-inner")), this.getTitle()), i.default(t).removeClass("fade show");
              }),
              (e.setElementContent = function (t, e) {
                  "object" != typeof e || (!e.nodeType && !e.jquery)
                      ? this.config.html
                          ? (this.config.sanitize && (e = ke(e, this.config.whiteList, this.config.sanitizeFn)), t.html(e))
                          : t.text(e)
                      : this.config.html
                      ? i.default(e).parent().is(t) || t.empty().append(e)
                      : t.text(i.default(e).text());
              }),
              (e.getTitle = function () {
                  var t = this.element.getAttribute("data-original-title");
                  return t || (t = "function" == typeof this.config.title ? this.config.title.call(this.element) : this.config.title), t;
              }),
              (e._getPopperConfig = function (t) {
                  var e = this;
                  return a(
                      {},
                      {
                          placement: t,
                          modifiers: { offset: this._getOffset(), flip: { behavior: this.config.fallbackPlacement }, arrow: { element: ".arrow" }, preventOverflow: { boundariesElement: this.config.boundary } },
                          onCreate: function (t) {
                              t.originalPlacement !== t.placement && e._handlePopperPlacementChange(t);
                          },
                          onUpdate: function (t) {
                              return e._handlePopperPlacementChange(t);
                          },
                      },
                      this.config.popperConfig
                  );
              }),
              (e._getOffset = function () {
                  var t = this,
                      e = {};
                  return (
                      "function" == typeof this.config.offset
                          ? (e.fn = function (e) {
                                return (e.offsets = a({}, e.offsets, t.config.offset(e.offsets, t.element))), e;
                            })
                          : (e.offset = this.config.offset),
                      e
                  );
              }),
              (e._getContainer = function () {
                  return !1 === this.config.container ? document.body : u.isElement(this.config.container) ? i.default(this.config.container) : i.default(document).find(this.config.container);
              }),
              (e._getAttachment = function (t) {
                  return qe[t.toUpperCase()];
              }),
              (e._setListeners = function () {
                  var t = this;
                  this.config.trigger.split(" ").forEach(function (e) {
                      if ("click" === e)
                          i.default(t.element).on(t.constructor.Event.CLICK, t.config.selector, function (e) {
                              return t.toggle(e);
                          });
                      else if ("manual" !== e) {
                          var n = e === He ? t.constructor.Event.MOUSEENTER : t.constructor.Event.FOCUSIN,
                              o = e === He ? t.constructor.Event.MOUSELEAVE : t.constructor.Event.FOCUSOUT;
                          i.default(t.element)
                              .on(n, t.config.selector, function (e) {
                                  return t._enter(e);
                              })
                              .on(o, t.config.selector, function (e) {
                                  return t._leave(e);
                              });
                      }
                  }),
                      (this._hideModalHandler = function () {
                          t.element && t.hide();
                      }),
                      i.default(this.element).closest(".modal").on("hide.bs.modal", this._hideModalHandler),
                      this.config.selector ? (this.config = a({}, this.config, { trigger: "manual", selector: "" })) : this._fixTitle();
              }),
              (e._fixTitle = function () {
                  var t = typeof this.element.getAttribute("data-original-title");
                  (this.element.getAttribute("title") || "string" !== t) && (this.element.setAttribute("data-original-title", this.element.getAttribute("title") || ""), this.element.setAttribute("title", ""));
              }),
              (e._enter = function (t, e) {
                  var n = this.constructor.DATA_KEY;
                  (e = e || i.default(t.currentTarget).data(n)) || ((e = new this.constructor(t.currentTarget, this._getDelegateConfig())), i.default(t.currentTarget).data(n, e)),
                      t && (e._activeTrigger["focusin" === t.type ? Me : He] = !0),
                      i.default(e.getTipElement()).hasClass(Fe) || e._hoverState === Re
                          ? (e._hoverState = Re)
                          : (clearTimeout(e._timeout),
                            (e._hoverState = Re),
                            e.config.delay && e.config.delay.show
                                ? (e._timeout = setTimeout(function () {
                                      e._hoverState === Re && e.show();
                                  }, e.config.delay.show))
                                : e.show());
              }),
              (e._leave = function (t, e) {
                  var n = this.constructor.DATA_KEY;
                  (e = e || i.default(t.currentTarget).data(n)) || ((e = new this.constructor(t.currentTarget, this._getDelegateConfig())), i.default(t.currentTarget).data(n, e)),
                      t && (e._activeTrigger["focusout" === t.type ? Me : He] = !1),
                      e._isWithActiveTrigger() ||
                          (clearTimeout(e._timeout),
                          (e._hoverState = Be),
                          e.config.delay && e.config.delay.hide
                              ? (e._timeout = setTimeout(function () {
                                    e._hoverState === Be && e.hide();
                                }, e.config.delay.hide))
                              : e.hide());
              }),
              (e._isWithActiveTrigger = function () {
                  for (var t in this._activeTrigger) if (this._activeTrigger[t]) return !0;
                  return !1;
              }),
              (e._getConfig = function (t) {
                  var e = i.default(this.element).data();
                  return (
                      Object.keys(e).forEach(function (t) {
                          -1 !== Le.indexOf(t) && delete e[t];
                      }),
                      "number" == typeof (t = a({}, this.constructor.Default, e, "object" == typeof t && t ? t : {})).delay && (t.delay = { show: t.delay, hide: t.delay }),
                      "number" == typeof t.title && (t.title = t.title.toString()),
                      "number" == typeof t.content && (t.content = t.content.toString()),
                      u.typeCheckConfig(Ie, t, this.constructor.DefaultType),
                      t.sanitize && (t.template = ke(t.template, t.whiteList, t.sanitizeFn)),
                      t
                  );
              }),
              (e._getDelegateConfig = function () {
                  var t = {};
                  if (this.config) for (var e in this.config) this.constructor.Default[e] !== this.config[e] && (t[e] = this.config[e]);
                  return t;
              }),
              (e._cleanTipClass = function () {
                  var t = i.default(this.getTipElement()),
                      e = t.attr("class").match(je);
                  null !== e && e.length && t.removeClass(e.join(""));
              }),
              (e._handlePopperPlacementChange = function (t) {
                  (this.tip = t.instance.popper), this._cleanTipClass(), this.addAttachmentClass(this._getAttachment(t.placement));
              }),
              (e._fixTransition = function () {
                  var t = this.getTipElement(),
                      e = this.config.animation;
                  null === t.getAttribute("x-placement") && (i.default(t).removeClass(Pe), (this.config.animation = !1), this.hide(), this.show(), (this.config.animation = e));
              }),
              (t._jQueryInterface = function (e) {
                  return this.each(function () {
                      var n = i.default(this),
                          o = n.data(Oe),
                          r = "object" == typeof e && e;
                      if ((o || !/dispose|hide/.test(e)) && (o || ((o = new t(this, r)), n.data(Oe, o)), "string" == typeof e)) {
                          if ("undefined" == typeof o[e]) throw new TypeError('No method named "' + e + '"');
                          o[e]();
                      }
                  });
              }),
              r(t, null, [
                  {
                      key: "VERSION",
                      get: function () {
                          return "4.6.2";
                      },
                  },
                  {
                      key: "Default",
                      get: function () {
                          return Qe;
                      },
                  },
                  {
                      key: "NAME",
                      get: function () {
                          return Ie;
                      },
                  },
                  {
                      key: "DATA_KEY",
                      get: function () {
                          return Oe;
                      },
                  },
                  {
                      key: "Event",
                      get: function () {
                          return Ue;
                      },
                  },
                  {
                      key: "EVENT_KEY",
                      get: function () {
                          return ".bs.tooltip";
                      },
                  },
                  {
                      key: "DefaultType",
                      get: function () {
                          return We;
                      },
                  },
              ]),
              t
          );
      })();
  (i.default.fn.tooltip = Ve._jQueryInterface),
      (i.default.fn.tooltip.Constructor = Ve),
      (i.default.fn.tooltip.noConflict = function () {
          return (i.default.fn.tooltip = xe), Ve._jQueryInterface;
      });
  var Ye = "bs.popover",
      ze = i.default.fn.popover,
      Ke = new RegExp("(^|\\s)bs-popover\\S+", "g"),
      Xe = a({}, Ve.Default, { placement: "right", trigger: "click", content: "", template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>' }),
      Ge = a({}, Ve.DefaultType, { content: "(string|element|function)" }),
      $e = {
          HIDE: "hide.bs.popover",
          HIDDEN: "hidden.bs.popover",
          SHOW: "show.bs.popover",
          SHOWN: "shown.bs.popover",
          INSERTED: "inserted.bs.popover",
          CLICK: "click.bs.popover",
          FOCUSIN: "focusin.bs.popover",
          FOCUSOUT: "focusout.bs.popover",
          MOUSEENTER: "mouseenter.bs.popover",
          MOUSELEAVE: "mouseleave.bs.popover",
      },
      Je = (function (t) {
          var e, n;
          function o() {
              return t.apply(this, arguments) || this;
          }
          (n = t), ((e = o).prototype = Object.create(n.prototype)), (e.prototype.constructor = e), s(e, n);
          var a = o.prototype;
          return (
              (a.isWithContent = function () {
                  return this.getTitle() || this._getContent();
              }),
              (a.addAttachmentClass = function (t) {
                  i.default(this.getTipElement()).addClass("bs-popover-" + t);
              }),
              (a.getTipElement = function () {
                  return (this.tip = this.tip || i.default(this.config.template)[0]), this.tip;
              }),
              (a.setContent = function () {
                  var t = i.default(this.getTipElement());
                  this.setElementContent(t.find(".popover-header"), this.getTitle());
                  var e = this._getContent();
                  "function" == typeof e && (e = e.call(this.element)), this.setElementContent(t.find(".popover-body"), e), t.removeClass("fade show");
              }),
              (a._getContent = function () {
                  return this.element.getAttribute("data-content") || this.config.content;
              }),
              (a._cleanTipClass = function () {
                  var t = i.default(this.getTipElement()),
                      e = t.attr("class").match(Ke);
                  null !== e && e.length > 0 && t.removeClass(e.join(""));
              }),
              (o._jQueryInterface = function (t) {
                  return this.each(function () {
                      var e = i.default(this).data(Ye),
                          n = "object" == typeof t ? t : null;
                      if ((e || !/dispose|hide/.test(t)) && (e || ((e = new o(this, n)), i.default(this).data(Ye, e)), "string" == typeof t)) {
                          if ("undefined" == typeof e[t]) throw new TypeError('No method named "' + t + '"');
                          e[t]();
                      }
                  });
              }),
              r(o, null, [
                  {
                      key: "VERSION",
                      get: function () {
                          return "4.6.2";
                      },
                  },
                  {
                      key: "Default",
                      get: function () {
                          return Xe;
                      },
                  },
                  {
                      key: "NAME",
                      get: function () {
                          return "popover";
                      },
                  },
                  {
                      key: "DATA_KEY",
                      get: function () {
                          return Ye;
                      },
                  },
                  {
                      key: "Event",
                      get: function () {
                          return $e;
                      },
                  },
                  {
                      key: "EVENT_KEY",
                      get: function () {
                          return ".bs.popover";
                      },
                  },
                  {
                      key: "DefaultType",
                      get: function () {
                          return Ge;
                      },
                  },
              ]),
              o
          );
      })(Ve);
  (i.default.fn.popover = Je._jQueryInterface),
      (i.default.fn.popover.Constructor = Je),
      (i.default.fn.popover.noConflict = function () {
          return (i.default.fn.popover = ze), Je._jQueryInterface;
      });
  var Ze = "scrollspy",
      tn = "bs.scrollspy",
      en = i.default.fn[Ze],
      nn = "active",
      on = "position",
      rn = ".nav, .list-group",
      an = { offset: 10, method: "auto", target: "" },
      sn = { offset: "number", method: "string", target: "(string|element)" },
      ln = (function () {
          function t(t, e) {
              var n = this;
              (this._element = t),
                  (this._scrollElement = "BODY" === t.tagName ? window : t),
                  (this._config = this._getConfig(e)),
                  (this._selector = this._config.target + " .nav-link," + this._config.target + " .list-group-item," + this._config.target + " .dropdown-item"),
                  (this._offsets = []),
                  (this._targets = []),
                  (this._activeTarget = null),
                  (this._scrollHeight = 0),
                  i.default(this._scrollElement).on("scroll.bs.scrollspy", function (t) {
                      return n._process(t);
                  }),
                  this.refresh(),
                  this._process();
          }
          var e = t.prototype;
          return (
              (e.refresh = function () {
                  var t = this,
                      e = this._scrollElement === this._scrollElement.window ? "offset" : on,
                      n = "auto" === this._config.method ? e : this._config.method,
                      o = n === on ? this._getScrollTop() : 0;
                  (this._offsets = []),
                      (this._targets = []),
                      (this._scrollHeight = this._getScrollHeight()),
                      [].slice
                          .call(document.querySelectorAll(this._selector))
                          .map(function (t) {
                              var e,
                                  r = u.getSelectorFromElement(t);
                              if ((r && (e = document.querySelector(r)), e)) {
                                  var a = e.getBoundingClientRect();
                                  if (a.width || a.height) return [i.default(e)[n]().top + o, r];
                              }
                              return null;
                          })
                          .filter(Boolean)
                          .sort(function (t, e) {
                              return t[0] - e[0];
                          })
                          .forEach(function (e) {
                              t._offsets.push(e[0]), t._targets.push(e[1]);
                          });
              }),
              (e.dispose = function () {
                  i.default.removeData(this._element, tn),
                      i.default(this._scrollElement).off(".bs.scrollspy"),
                      (this._element = null),
                      (this._scrollElement = null),
                      (this._config = null),
                      (this._selector = null),
                      (this._offsets = null),
                      (this._targets = null),
                      (this._activeTarget = null),
                      (this._scrollHeight = null);
              }),
              (e._getConfig = function (t) {
                  if ("string" != typeof (t = a({}, an, "object" == typeof t && t ? t : {})).target && u.isElement(t.target)) {
                      var e = i.default(t.target).attr("id");
                      e || ((e = u.getUID(Ze)), i.default(t.target).attr("id", e)), (t.target = "#" + e);
                  }
                  return u.typeCheckConfig(Ze, t, sn), t;
              }),
              (e._getScrollTop = function () {
                  return this._scrollElement === window ? this._scrollElement.pageYOffset : this._scrollElement.scrollTop;
              }),
              (e._getScrollHeight = function () {
                  return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
              }),
              (e._getOffsetHeight = function () {
                  return this._scrollElement === window ? window.innerHeight : this._scrollElement.getBoundingClientRect().height;
              }),
              (e._process = function () {
                  var t = this._getScrollTop() + this._config.offset,
                      e = this._getScrollHeight(),
                      n = this._config.offset + e - this._getOffsetHeight();
                  if ((this._scrollHeight !== e && this.refresh(), t >= n)) {
                      var i = this._targets[this._targets.length - 1];
                      this._activeTarget !== i && this._activate(i);
                  } else {
                      if (this._activeTarget && t < this._offsets[0] && this._offsets[0] > 0) return (this._activeTarget = null), void this._clear();
                      for (var o = this._offsets.length; o--; )
                          this._activeTarget !== this._targets[o] && t >= this._offsets[o] && ("undefined" == typeof this._offsets[o + 1] || t < this._offsets[o + 1]) && this._activate(this._targets[o]);
                  }
              }),
              (e._activate = function (t) {
                  (this._activeTarget = t), this._clear();
                  var e = this._selector.split(",").map(function (e) {
                          return e + '[data-target="' + t + '"],' + e + '[href="' + t + '"]';
                      }),
                      n = i.default([].slice.call(document.querySelectorAll(e.join(","))));
                  n.hasClass("dropdown-item")
                      ? (n.closest(".dropdown").find(".dropdown-toggle").addClass(nn), n.addClass(nn))
                      : (n.addClass(nn), n.parents(rn).prev(".nav-link, .list-group-item").addClass(nn), n.parents(rn).prev(".nav-item").children(".nav-link").addClass(nn)),
                      i.default(this._scrollElement).trigger("activate.bs.scrollspy", { relatedTarget: t });
              }),
              (e._clear = function () {
                  [].slice
                      .call(document.querySelectorAll(this._selector))
                      .filter(function (t) {
                          return t.classList.contains(nn);
                      })
                      .forEach(function (t) {
                          return t.classList.remove(nn);
                      });
              }),
              (t._jQueryInterface = function (e) {
                  return this.each(function () {
                      var n = i.default(this).data(tn);
                      if ((n || ((n = new t(this, "object" == typeof e && e)), i.default(this).data(tn, n)), "string" == typeof e)) {
                          if ("undefined" == typeof n[e]) throw new TypeError('No method named "' + e + '"');
                          n[e]();
                      }
                  });
              }),
              r(t, null, [
                  {
                      key: "VERSION",
                      get: function () {
                          return "4.6.2";
                      },
                  },
                  {
                      key: "Default",
                      get: function () {
                          return an;
                      },
                  },
              ]),
              t
          );
      })();
  i.default(window).on("load.bs.scrollspy.data-api", function () {
      for (var t = [].slice.call(document.querySelectorAll('[data-spy="scroll"]')), e = t.length; e--; ) {
          var n = i.default(t[e]);
          ln._jQueryInterface.call(n, n.data());
      }
  }),
      (i.default.fn[Ze] = ln._jQueryInterface),
      (i.default.fn[Ze].Constructor = ln),
      (i.default.fn[Ze].noConflict = function () {
          return (i.default.fn[Ze] = en), ln._jQueryInterface;
      });
  var un = "bs.tab",
      fn = i.default.fn.tab,
      dn = "active",
      cn = "fade",
      hn = "show",
      pn = ".active",
      mn = "> li > .active",
      gn = (function () {
          function t(t) {
              this._element = t;
          }
          var e = t.prototype;
          return (
              (e.show = function () {
                  var t = this;
                  if (
                      !(
                          (this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && i.default(this._element).hasClass(dn)) ||
                          i.default(this._element).hasClass("disabled") ||
                          this._element.hasAttribute("disabled")
                      )
                  ) {
                      var e,
                          n,
                          o = i.default(this._element).closest(".nav, .list-group")[0],
                          r = u.getSelectorFromElement(this._element);
                      if (o) {
                          var a = "UL" === o.nodeName || "OL" === o.nodeName ? mn : pn;
                          n = (n = i.default.makeArray(i.default(o).find(a)))[n.length - 1];
                      }
                      var s = i.default.Event("hide.bs.tab", { relatedTarget: this._element }),
                          l = i.default.Event("show.bs.tab", { relatedTarget: n });
                      if ((n && i.default(n).trigger(s), i.default(this._element).trigger(l), !l.isDefaultPrevented() && !s.isDefaultPrevented())) {
                          r && (e = document.querySelector(r)), this._activate(this._element, o);
                          var f = function () {
                              var e = i.default.Event("hidden.bs.tab", { relatedTarget: t._element }),
                                  o = i.default.Event("shown.bs.tab", { relatedTarget: n });
                              i.default(n).trigger(e), i.default(t._element).trigger(o);
                          };
                          e ? this._activate(e, e.parentNode, f) : f();
                      }
                  }
              }),
              (e.dispose = function () {
                  i.default.removeData(this._element, un), (this._element = null);
              }),
              (e._activate = function (t, e, n) {
                  var o = this,
                      r = (!e || ("UL" !== e.nodeName && "OL" !== e.nodeName) ? i.default(e).children(pn) : i.default(e).find(mn))[0],
                      a = n && r && i.default(r).hasClass(cn),
                      s = function () {
                          return o._transitionComplete(t, r, n);
                      };
                  if (r && a) {
                      var l = u.getTransitionDurationFromElement(r);
                      i.default(r).removeClass(hn).one(u.TRANSITION_END, s).emulateTransitionEnd(l);
                  } else s();
              }),
              (e._transitionComplete = function (t, e, n) {
                  if (e) {
                      i.default(e).removeClass(dn);
                      var o = i.default(e.parentNode).find("> .dropdown-menu .active")[0];
                      o && i.default(o).removeClass(dn), "tab" === e.getAttribute("role") && e.setAttribute("aria-selected", !1);
                  }
                  i.default(t).addClass(dn), "tab" === t.getAttribute("role") && t.setAttribute("aria-selected", !0), u.reflow(t), t.classList.contains(cn) && t.classList.add(hn);
                  var r = t.parentNode;
                  if ((r && "LI" === r.nodeName && (r = r.parentNode), r && i.default(r).hasClass("dropdown-menu"))) {
                      var a = i.default(t).closest(".dropdown")[0];
                      if (a) {
                          var s = [].slice.call(a.querySelectorAll(".dropdown-toggle"));
                          i.default(s).addClass(dn);
                      }
                      t.setAttribute("aria-expanded", !0);
                  }
                  n && n();
              }),
              (t._jQueryInterface = function (e) {
                  return this.each(function () {
                      var n = i.default(this),
                          o = n.data(un);
                      if ((o || ((o = new t(this)), n.data(un, o)), "string" == typeof e)) {
                          if ("undefined" == typeof o[e]) throw new TypeError('No method named "' + e + '"');
                          o[e]();
                      }
                  });
              }),
              r(t, null, [
                  {
                      key: "VERSION",
                      get: function () {
                          return "4.6.2";
                      },
                  },
              ]),
              t
          );
      })();
  i.default(document).on("click.bs.tab.data-api", '[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]', function (t) {
      t.preventDefault(), gn._jQueryInterface.call(i.default(this), "show");
  }),
      (i.default.fn.tab = gn._jQueryInterface),
      (i.default.fn.tab.Constructor = gn),
      (i.default.fn.tab.noConflict = function () {
          return (i.default.fn.tab = fn), gn._jQueryInterface;
      });
  var _n = "bs.toast",
      vn = i.default.fn.toast,
      bn = "hide",
      yn = "show",
      En = "showing",
      wn = "click.dismiss.bs.toast",
      Tn = { animation: !0, autohide: !0, delay: 500 },
      Cn = { animation: "boolean", autohide: "boolean", delay: "number" },
      Sn = (function () {
          function t(t, e) {
              (this._element = t), (this._config = this._getConfig(e)), (this._timeout = null), this._setListeners();
          }
          var e = t.prototype;
          return (
              (e.show = function () {
                  var t = this,
                      e = i.default.Event("show.bs.toast");
                  if ((i.default(this._element).trigger(e), !e.isDefaultPrevented())) {
                      this._clearTimeout(), this._config.animation && this._element.classList.add("fade");
                      var n = function () {
                          t._element.classList.remove(En),
                              t._element.classList.add(yn),
                              i.default(t._element).trigger("shown.bs.toast"),
                              t._config.autohide &&
                                  (t._timeout = setTimeout(function () {
                                      t.hide();
                                  }, t._config.delay));
                      };
                      if ((this._element.classList.remove(bn), u.reflow(this._element), this._element.classList.add(En), this._config.animation)) {
                          var o = u.getTransitionDurationFromElement(this._element);
                          i.default(this._element).one(u.TRANSITION_END, n).emulateTransitionEnd(o);
                      } else n();
                  }
              }),
              (e.hide = function () {
                  if (this._element.classList.contains(yn)) {
                      var t = i.default.Event("hide.bs.toast");
                      i.default(this._element).trigger(t), t.isDefaultPrevented() || this._close();
                  }
              }),
              (e.dispose = function () {
                  this._clearTimeout(), this._element.classList.contains(yn) && this._element.classList.remove(yn), i.default(this._element).off(wn), i.default.removeData(this._element, _n), (this._element = null), (this._config = null);
              }),
              (e._getConfig = function (t) {
                  return (t = a({}, Tn, i.default(this._element).data(), "object" == typeof t && t ? t : {})), u.typeCheckConfig("toast", t, this.constructor.DefaultType), t;
              }),
              (e._setListeners = function () {
                  var t = this;
                  i.default(this._element).on(wn, '[data-dismiss="toast"]', function () {
                      return t.hide();
                  });
              }),
              (e._close = function () {
                  var t = this,
                      e = function () {
                          t._element.classList.add(bn), i.default(t._element).trigger("hidden.bs.toast");
                      };
                  if ((this._element.classList.remove(yn), this._config.animation)) {
                      var n = u.getTransitionDurationFromElement(this._element);
                      i.default(this._element).one(u.TRANSITION_END, e).emulateTransitionEnd(n);
                  } else e();
              }),
              (e._clearTimeout = function () {
                  clearTimeout(this._timeout), (this._timeout = null);
              }),
              (t._jQueryInterface = function (e) {
                  return this.each(function () {
                      var n = i.default(this),
                          o = n.data(_n);
                      if ((o || ((o = new t(this, "object" == typeof e && e)), n.data(_n, o)), "string" == typeof e)) {
                          if ("undefined" == typeof o[e]) throw new TypeError('No method named "' + e + '"');
                          o[e](this);
                      }
                  });
              }),
              r(t, null, [
                  {
                      key: "VERSION",
                      get: function () {
                          return "4.6.2";
                      },
                  },
                  {
                      key: "DefaultType",
                      get: function () {
                          return Cn;
                      },
                  },
                  {
                      key: "Default",
                      get: function () {
                          return Tn;
                      },
                  },
              ]),
              t
          );
      })();
  (i.default.fn.toast = Sn._jQueryInterface),
      (i.default.fn.toast.Constructor = Sn),
      (i.default.fn.toast.noConflict = function () {
          return (i.default.fn.toast = vn), Sn._jQueryInterface;
      }),
      (t.Alert = c),
      (t.Button = b),
      (t.Carousel = O),
      (t.Collapse = W),
      (t.Dropdown = le),
      (t.Modal = Se),
      (t.Popover = Je),
      (t.Scrollspy = ln),
      (t.Tab = gn),
      (t.Toast = Sn),
      (t.Tooltip = Ve),
      (t.Util = u),
      Object.defineProperty(t, "__esModule", { value: !0 });
});
//# sourceMappingURL=bootstrap.bundle.min.js.map

/*Owl Carousel v2.3.4 */
!(function (a, b, c, d) {
  function e(b, c) {
      (this.settings = null),
          (this.options = a.extend({}, e.Defaults, c)),
          (this.$element = a(b)),
          (this._handlers = {}),
          (this._plugins = {}),
          (this._supress = {}),
          (this._current = null),
          (this._speed = null),
          (this._coordinates = []),
          (this._breakpoint = null),
          (this._width = null),
          (this._items = []),
          (this._clones = []),
          (this._mergers = []),
          (this._widths = []),
          (this._invalidated = {}),
          (this._pipe = []),
          (this._drag = { time: null, target: null, pointer: null, stage: { start: null, current: null }, direction: null }),
          (this._states = { current: {}, tags: { initializing: ["busy"], animating: ["busy"], dragging: ["interacting"] } }),
          a.each(
              ["onResize", "onThrottledResize"],
              a.proxy(function (b, c) {
                  this._handlers[c] = a.proxy(this[c], this);
              }, this)
          ),
          a.each(
              e.Plugins,
              a.proxy(function (a, b) {
                  this._plugins[a.charAt(0).toLowerCase() + a.slice(1)] = new b(this);
              }, this)
          ),
          a.each(
              e.Workers,
              a.proxy(function (b, c) {
                  this._pipe.push({ filter: c.filter, run: a.proxy(c.run, this) });
              }, this)
          ),
          this.setup(),
          this.initialize();
  }
  (e.Defaults = {
      items: 3,
      loop: !1,
      center: !1,
      rewind: !1,
      checkVisibility: !0,
      mouseDrag: !0,
      touchDrag: !0,
      pullDrag: !0,
      freeDrag: !1,
      margin: 0,
      stagePadding: 0,
      merge: !1,
      mergeFit: !0,
      autoWidth: !1,
      startPosition: 0,
      rtl: !1,
      smartSpeed: 250,
      fluidSpeed: !1,
      dragEndSpeed: !1,
      responsive: {},
      responsiveRefreshRate: 200,
      responsiveBaseElement: b,
      fallbackEasing: "swing",
      slideTransition: "",
      info: !1,
      nestedItemSelector: !1,
      itemElement: "div",
      stageElement: "div",
      refreshClass: "owl-refresh",
      loadedClass: "owl-loaded",
      loadingClass: "owl-loading",
      rtlClass: "owl-rtl",
      responsiveClass: "owl-responsive",
      dragClass: "owl-drag",
      itemClass: "owl-item",
      stageClass: "owl-stage",
      stageOuterClass: "owl-stage-outer",
      grabClass: "owl-grab",
  }),
      (e.Width = { Default: "default", Inner: "inner", Outer: "outer" }),
      (e.Type = { Event: "event", State: "state" }),
      (e.Plugins = {}),
      (e.Workers = [
          {
              filter: ["width", "settings"],
              run: function () {
                  this._width = this.$element.width();
              },
          },
          {
              filter: ["width", "items", "settings"],
              run: function (a) {
                  a.current = this._items && this._items[this.relative(this._current)];
              },
          },
          {
              filter: ["items", "settings"],
              run: function () {
                  this.$stage.children(".cloned").remove();
              },
          },
          {
              filter: ["width", "items", "settings"],
              run: function (a) {
                  var b = this.settings.margin || "",
                      c = !this.settings.autoWidth,
                      d = this.settings.rtl,
                      e = { width: "auto", "margin-left": d ? b : "", "margin-right": d ? "" : b };
                  !c && this.$stage.children().css(e), (a.css = e);
              },
          },
          {
              filter: ["width", "items", "settings"],
              run: function (a) {
                  var b = (this.width() / this.settings.items).toFixed(3) - this.settings.margin,
                      c = null,
                      d = this._items.length,
                      e = !this.settings.autoWidth,
                      f = [];
                  for (a.items = { merge: !1, width: b }; d--; )
                      (c = this._mergers[d]), (c = (this.settings.mergeFit && Math.min(c, this.settings.items)) || c), (a.items.merge = c > 1 || a.items.merge), (f[d] = e ? b * c : this._items[d].width());
                  this._widths = f;
              },
          },
          {
              filter: ["items", "settings"],
              run: function () {
                  var b = [],
                      c = this._items,
                      d = this.settings,
                      e = Math.max(2 * d.items, 4),
                      f = 2 * Math.ceil(c.length / 2),
                      g = d.loop && c.length ? (d.rewind ? e : Math.max(e, f)) : 0,
                      h = "",
                      i = "";
                  for (g /= 2; g > 0; ) b.push(this.normalize(b.length / 2, !0)), (h += c[b[b.length - 1]][0].outerHTML), b.push(this.normalize(c.length - 1 - (b.length - 1) / 2, !0)), (i = c[b[b.length - 1]][0].outerHTML + i), (g -= 1);
                  (this._clones = b), a(h).addClass("cloned").appendTo(this.$stage), a(i).addClass("cloned").prependTo(this.$stage);
              },
          },
          {
              filter: ["width", "items", "settings"],
              run: function () {
                  for (var a = this.settings.rtl ? 1 : -1, b = this._clones.length + this._items.length, c = -1, d = 0, e = 0, f = []; ++c < b; )
                      (d = f[c - 1] || 0), (e = this._widths[this.relative(c)] + this.settings.margin), f.push(d + e * a);
                  this._coordinates = f;
              },
          },
          {
              filter: ["width", "items", "settings"],
              run: function () {
                  var a = this.settings.stagePadding,
                      b = this._coordinates,
                      c = { width: Math.ceil(Math.abs(b[b.length - 1])) + 2 * a, "padding-left": a || "", "padding-right": a || "" };
                  this.$stage.css(c);
              },
          },
          {
              filter: ["width", "items", "settings"],
              run: function (a) {
                  var b = this._coordinates.length,
                      c = !this.settings.autoWidth,
                      d = this.$stage.children();
                  if (c && a.items.merge) for (; b--; ) (a.css.width = this._widths[this.relative(b)]), d.eq(b).css(a.css);
                  else c && ((a.css.width = a.items.width), d.css(a.css));
              },
          },
          {
              filter: ["items"],
              run: function () {
                  this._coordinates.length < 1 && this.$stage.removeAttr("style");
              },
          },
          {
              filter: ["width", "items", "settings"],
              run: function (a) {
                  (a.current = a.current ? this.$stage.children().index(a.current) : 0), (a.current = Math.max(this.minimum(), Math.min(this.maximum(), a.current))), this.reset(a.current);
              },
          },
          {
              filter: ["position"],
              run: function () {
                  this.animate(this.coordinates(this._current));
              },
          },
          {
              filter: ["width", "position", "items", "settings"],
              run: function () {
                  var a,
                      b,
                      c,
                      d,
                      e = this.settings.rtl ? 1 : -1,
                      f = 2 * this.settings.stagePadding,
                      g = this.coordinates(this.current()) + f,
                      h = g + this.width() * e,
                      i = [];
                  for (c = 0, d = this._coordinates.length; c < d; c++)
                      (a = this._coordinates[c - 1] || 0), (b = Math.abs(this._coordinates[c]) + f * e), ((this.op(a, "<=", g) && this.op(a, ">", h)) || (this.op(b, "<", g) && this.op(b, ">", h))) && i.push(c);
                  this.$stage.children(".active").removeClass("active"),
                      this.$stage.children(":eq(" + i.join("), :eq(") + ")").addClass("active"),
                      this.$stage.children(".center").removeClass("center"),
                      this.settings.center && this.$stage.children().eq(this.current()).addClass("center");
              },
          },
      ]),
      (e.prototype.initializeStage = function () {
          (this.$stage = this.$element.find("." + this.settings.stageClass)),
              this.$stage.length ||
                  (this.$element.addClass(this.options.loadingClass),
                  (this.$stage = a("<" + this.settings.stageElement + ">", { class: this.settings.stageClass }).wrap(a("<div/>", { class: this.settings.stageOuterClass }))),
                  this.$element.append(this.$stage.parent()));
      }),
      (e.prototype.initializeItems = function () {
          var b = this.$element.find(".owl-item");
          if (b.length)
              return (
                  (this._items = b.get().map(function (b) {
                      return a(b);
                  })),
                  (this._mergers = this._items.map(function () {
                      return 1;
                  })),
                  void this.refresh()
              );
          this.replace(this.$element.children().not(this.$stage.parent())), this.isVisible() ? this.refresh() : this.invalidate("width"), this.$element.removeClass(this.options.loadingClass).addClass(this.options.loadedClass);
      }),
      (e.prototype.initialize = function () {
          if ((this.enter("initializing"), this.trigger("initialize"), this.$element.toggleClass(this.settings.rtlClass, this.settings.rtl), this.settings.autoWidth && !this.is("pre-loading"))) {
              var a, b, c;
              (a = this.$element.find("img")), (b = this.settings.nestedItemSelector ? "." + this.settings.nestedItemSelector : d), (c = this.$element.children(b).width()), a.length && c <= 0 && this.preloadAutoWidthImages(a);
          }
          this.initializeStage(), this.initializeItems(), this.registerEventHandlers(), this.leave("initializing"), this.trigger("initialized");
      }),
      (e.prototype.isVisible = function () {
          return !this.settings.checkVisibility || this.$element.is(":visible");
      }),
      (e.prototype.setup = function () {
          var b = this.viewport(),
              c = this.options.responsive,
              d = -1,
              e = null;
          c
              ? (a.each(c, function (a) {
                    a <= b && a > d && (d = Number(a));
                }),
                (e = a.extend({}, this.options, c[d])),
                "function" == typeof e.stagePadding && (e.stagePadding = e.stagePadding()),
                delete e.responsive,
                e.responsiveClass && this.$element.attr("class", this.$element.attr("class").replace(new RegExp("(" + this.options.responsiveClass + "-)\\S+\\s", "g"), "$1" + d)))
              : (e = a.extend({}, this.options)),
              this.trigger("change", { property: { name: "settings", value: e } }),
              (this._breakpoint = d),
              (this.settings = e),
              this.invalidate("settings"),
              this.trigger("changed", { property: { name: "settings", value: this.settings } });
      }),
      (e.prototype.optionsLogic = function () {
          this.settings.autoWidth && ((this.settings.stagePadding = !1), (this.settings.merge = !1));
      }),
      (e.prototype.prepare = function (b) {
          var c = this.trigger("prepare", { content: b });
          return (
              c.data ||
                  (c.data = a("<" + this.settings.itemElement + "/>")
                      .addClass(this.options.itemClass)
                      .append(b)),
              this.trigger("prepared", { content: c.data }),
              c.data
          );
      }),
      (e.prototype.update = function () {
          for (
              var b = 0,
                  c = this._pipe.length,
                  d = a.proxy(function (a) {
                      return this[a];
                  }, this._invalidated),
                  e = {};
              b < c;

          )
              (this._invalidated.all || a.grep(this._pipe[b].filter, d).length > 0) && this._pipe[b].run(e), b++;
          (this._invalidated = {}), !this.is("valid") && this.enter("valid");
      }),
      (e.prototype.width = function (a) {
          switch ((a = a || e.Width.Default)) {
              case e.Width.Inner:
              case e.Width.Outer:
                  return this._width;
              default:
                  return this._width - 2 * this.settings.stagePadding + this.settings.margin;
          }
      }),
      (e.prototype.refresh = function () {
          this.enter("refreshing"),
              this.trigger("refresh"),
              this.setup(),
              this.optionsLogic(),
              this.$element.addClass(this.options.refreshClass),
              this.update(),
              this.$element.removeClass(this.options.refreshClass),
              this.leave("refreshing"),
              this.trigger("refreshed");
      }),
      (e.prototype.onThrottledResize = function () {
          b.clearTimeout(this.resizeTimer), (this.resizeTimer = b.setTimeout(this._handlers.onResize, this.settings.responsiveRefreshRate));
      }),
      (e.prototype.onResize = function () {
          return (
              !!this._items.length &&
              this._width !== this.$element.width() &&
              !!this.isVisible() &&
              (this.enter("resizing"), this.trigger("resize").isDefaultPrevented() ? (this.leave("resizing"), !1) : (this.invalidate("width"), this.refresh(), this.leave("resizing"), void this.trigger("resized")))
          );
      }),
      (e.prototype.registerEventHandlers = function () {
          a.support.transition && this.$stage.on(a.support.transition.end + ".owl.core", a.proxy(this.onTransitionEnd, this)),
              !1 !== this.settings.responsive && this.on(b, "resize", this._handlers.onThrottledResize),
              this.settings.mouseDrag &&
                  (this.$element.addClass(this.options.dragClass),
                  this.$stage.on("mousedown.owl.core", a.proxy(this.onDragStart, this)),
                  this.$stage.on("dragstart.owl.core selectstart.owl.core", function () {
                      return !1;
                  })),
              this.settings.touchDrag && (this.$stage.on("touchstart.owl.core", a.proxy(this.onDragStart, this)), this.$stage.on("touchcancel.owl.core", a.proxy(this.onDragEnd, this)));
      }),
      (e.prototype.onDragStart = function (b) {
          var d = null;
          3 !== b.which &&
              (a.support.transform
                  ? ((d = this.$stage
                        .css("transform")
                        .replace(/.*\(|\)| /g, "")
                        .split(",")),
                    (d = { x: d[16 === d.length ? 12 : 4], y: d[16 === d.length ? 13 : 5] }))
                  : ((d = this.$stage.position()), (d = { x: this.settings.rtl ? d.left + this.$stage.width() - this.width() + this.settings.margin : d.left, y: d.top })),
              this.is("animating") && (a.support.transform ? this.animate(d.x) : this.$stage.stop(), this.invalidate("position")),
              this.$element.toggleClass(this.options.grabClass, "mousedown" === b.type),
              this.speed(0),
              (this._drag.time = new Date().getTime()),
              (this._drag.target = a(b.target)),
              (this._drag.stage.start = d),
              (this._drag.stage.current = d),
              (this._drag.pointer = this.pointer(b)),
              a(c).on("mouseup.owl.core touchend.owl.core", a.proxy(this.onDragEnd, this)),
              a(c).one(
                  "mousemove.owl.core touchmove.owl.core",
                  a.proxy(function (b) {
                      var d = this.difference(this._drag.pointer, this.pointer(b));
                      a(c).on("mousemove.owl.core touchmove.owl.core", a.proxy(this.onDragMove, this)), (Math.abs(d.x) < Math.abs(d.y) && this.is("valid")) || (b.preventDefault(), this.enter("dragging"), this.trigger("drag"));
                  }, this)
              ));
      }),
      (e.prototype.onDragMove = function (a) {
          var b = null,
              c = null,
              d = null,
              e = this.difference(this._drag.pointer, this.pointer(a)),
              f = this.difference(this._drag.stage.start, e);
          this.is("dragging") &&
              (a.preventDefault(),
              this.settings.loop
                  ? ((b = this.coordinates(this.minimum())), (c = this.coordinates(this.maximum() + 1) - b), (f.x = ((((f.x - b) % c) + c) % c) + b))
                  : ((b = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum())),
                    (c = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum())),
                    (d = this.settings.pullDrag ? (-1 * e.x) / 5 : 0),
                    (f.x = Math.max(Math.min(f.x, b + d), c + d))),
              (this._drag.stage.current = f),
              this.animate(f.x));
      }),
      (e.prototype.onDragEnd = function (b) {
          var d = this.difference(this._drag.pointer, this.pointer(b)),
              e = this._drag.stage.current,
              f = (d.x > 0) ^ this.settings.rtl ? "left" : "right";
          a(c).off(".owl.core"),
              this.$element.removeClass(this.options.grabClass),
              ((0 !== d.x && this.is("dragging")) || !this.is("valid")) &&
                  (this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed),
                  this.current(this.closest(e.x, 0 !== d.x ? f : this._drag.direction)),
                  this.invalidate("position"),
                  this.update(),
                  (this._drag.direction = f),
                  (Math.abs(d.x) > 3 || new Date().getTime() - this._drag.time > 300) &&
                      this._drag.target.one("click.owl.core", function () {
                          return !1;
                      })),
              this.is("dragging") && (this.leave("dragging"), this.trigger("dragged"));
      }),
      (e.prototype.closest = function (b, c) {
          var e = -1,
              f = 30,
              g = this.width(),
              h = this.coordinates();
          return (
              this.settings.freeDrag ||
                  a.each(
                      h,
                      a.proxy(function (a, i) {
                          return (
                              "left" === c && b > i - f && b < i + f
                                  ? (e = a)
                                  : "right" === c && b > i - g - f && b < i - g + f
                                  ? (e = a + 1)
                                  : this.op(b, "<", i) && this.op(b, ">", h[a + 1] !== d ? h[a + 1] : i - g) && (e = "left" === c ? a + 1 : a),
                              -1 === e
                          );
                      }, this)
                  ),
              this.settings.loop || (this.op(b, ">", h[this.minimum()]) ? (e = b = this.minimum()) : this.op(b, "<", h[this.maximum()]) && (e = b = this.maximum())),
              e
          );
      }),
      (e.prototype.animate = function (b) {
          var c = this.speed() > 0;
          this.is("animating") && this.onTransitionEnd(),
              c && (this.enter("animating"), this.trigger("translate")),
              a.support.transform3d && a.support.transition
                  ? this.$stage.css({ transform: "translate3d(" + b + "px,0px,0px)", transition: this.speed() / 1e3 + "s" + (this.settings.slideTransition ? " " + this.settings.slideTransition : "") })
                  : c
                  ? this.$stage.animate({ left: b + "px" }, this.speed(), this.settings.fallbackEasing, a.proxy(this.onTransitionEnd, this))
                  : this.$stage.css({ left: b + "px" });
      }),
      (e.prototype.is = function (a) {
          return this._states.current[a] && this._states.current[a] > 0;
      }),
      (e.prototype.current = function (a) {
          if (a === d) return this._current;
          if (0 === this._items.length) return d;
          if (((a = this.normalize(a)), this._current !== a)) {
              var b = this.trigger("change", { property: { name: "position", value: a } });
              b.data !== d && (a = this.normalize(b.data)), (this._current = a), this.invalidate("position"), this.trigger("changed", { property: { name: "position", value: this._current } });
          }
          return this._current;
      }),
      (e.prototype.invalidate = function (b) {
          return (
              "string" === a.type(b) && ((this._invalidated[b] = !0), this.is("valid") && this.leave("valid")),
              a.map(this._invalidated, function (a, b) {
                  return b;
              })
          );
      }),
      (e.prototype.reset = function (a) {
          (a = this.normalize(a)) !== d && ((this._speed = 0), (this._current = a), this.suppress(["translate", "translated"]), this.animate(this.coordinates(a)), this.release(["translate", "translated"]));
      }),
      (e.prototype.normalize = function (a, b) {
          var c = this._items.length,
              e = b ? 0 : this._clones.length;
          return !this.isNumeric(a) || c < 1 ? (a = d) : (a < 0 || a >= c + e) && (a = ((((a - e / 2) % c) + c) % c) + e / 2), a;
      }),
      (e.prototype.relative = function (a) {
          return (a -= this._clones.length / 2), this.normalize(a, !0);
      }),
      (e.prototype.maximum = function (a) {
          var b,
              c,
              d,
              e = this.settings,
              f = this._coordinates.length;
          if (e.loop) f = this._clones.length / 2 + this._items.length - 1;
          else if (e.autoWidth || e.merge) {
              if ((b = this._items.length)) for (c = this._items[--b].width(), d = this.$element.width(); b-- && !((c += this._items[b].width() + this.settings.margin) > d); );
              f = b + 1;
          } else f = e.center ? this._items.length - 1 : this._items.length - e.items;
          return a && (f -= this._clones.length / 2), Math.max(f, 0);
      }),
      (e.prototype.minimum = function (a) {
          return a ? 0 : this._clones.length / 2;
      }),
      (e.prototype.items = function (a) {
          return a === d ? this._items.slice() : ((a = this.normalize(a, !0)), this._items[a]);
      }),
      (e.prototype.mergers = function (a) {
          return a === d ? this._mergers.slice() : ((a = this.normalize(a, !0)), this._mergers[a]);
      }),
      (e.prototype.clones = function (b) {
          var c = this._clones.length / 2,
              e = c + this._items.length,
              f = function (a) {
                  return a % 2 == 0 ? e + a / 2 : c - (a + 1) / 2;
              };
          return b === d
              ? a.map(this._clones, function (a, b) {
                    return f(b);
                })
              : a.map(this._clones, function (a, c) {
                    return a === b ? f(c) : null;
                });
      }),
      (e.prototype.speed = function (a) {
          return a !== d && (this._speed = a), this._speed;
      }),
      (e.prototype.coordinates = function (b) {
          var c,
              e = 1,
              f = b - 1;
          return b === d
              ? a.map(
                    this._coordinates,
                    a.proxy(function (a, b) {
                        return this.coordinates(b);
                    }, this)
                )
              : (this.settings.center ? (this.settings.rtl && ((e = -1), (f = b + 1)), (c = this._coordinates[b]), (c += ((this.width() - c + (this._coordinates[f] || 0)) / 2) * e)) : (c = this._coordinates[f] || 0), (c = Math.ceil(c)));
      }),
      (e.prototype.duration = function (a, b, c) {
          return 0 === c ? 0 : Math.min(Math.max(Math.abs(b - a), 1), 6) * Math.abs(c || this.settings.smartSpeed);
      }),
      (e.prototype.to = function (a, b) {
          var c = this.current(),
              d = null,
              e = a - this.relative(c),
              f = (e > 0) - (e < 0),
              g = this._items.length,
              h = this.minimum(),
              i = this.maximum();
          this.settings.loop
              ? (!this.settings.rewind && Math.abs(e) > g / 2 && (e += -1 * f * g), (a = c + e), (d = ((((a - h) % g) + g) % g) + h) !== a && d - e <= i && d - e > 0 && ((c = d - e), (a = d), this.reset(c)))
              : this.settings.rewind
              ? ((i += 1), (a = ((a % i) + i) % i))
              : (a = Math.max(h, Math.min(i, a))),
              this.speed(this.duration(c, a, b)),
              this.current(a),
              this.isVisible() && this.update();
      }),
      (e.prototype.next = function (a) {
          (a = a || !1), this.to(this.relative(this.current()) + 1, a);
      }),
      (e.prototype.prev = function (a) {
          (a = a || !1), this.to(this.relative(this.current()) - 1, a);
      }),
      (e.prototype.onTransitionEnd = function (a) {
          if (a !== d && (a.stopPropagation(), (a.target || a.srcElement || a.originalTarget) !== this.$stage.get(0))) return !1;
          this.leave("animating"), this.trigger("translated");
      }),
      (e.prototype.viewport = function () {
          var d;
          return (
              this.options.responsiveBaseElement !== b
                  ? (d = a(this.options.responsiveBaseElement).width())
                  : b.innerWidth
                  ? (d = b.innerWidth)
                  : c.documentElement && c.documentElement.clientWidth
                  ? (d = c.documentElement.clientWidth)
                  : console.warn("Can not detect viewport width."),
              d
          );
      }),
      (e.prototype.replace = function (b) {
          this.$stage.empty(),
              (this._items = []),
              b && (b = b instanceof jQuery ? b : a(b)),
              this.settings.nestedItemSelector && (b = b.find("." + this.settings.nestedItemSelector)),
              b
                  .filter(function () {
                      return 1 === this.nodeType;
                  })
                  .each(
                      a.proxy(function (a, b) {
                          (b = this.prepare(b)), this.$stage.append(b), this._items.push(b), this._mergers.push(1 * b.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1);
                      }, this)
                  ),
              this.reset(this.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0),
              this.invalidate("items");
      }),
      (e.prototype.add = function (b, c) {
          var e = this.relative(this._current);
          (c = c === d ? this._items.length : this.normalize(c, !0)),
              (b = b instanceof jQuery ? b : a(b)),
              this.trigger("add", { content: b, position: c }),
              (b = this.prepare(b)),
              0 === this._items.length || c === this._items.length
                  ? (0 === this._items.length && this.$stage.append(b),
                    0 !== this._items.length && this._items[c - 1].after(b),
                    this._items.push(b),
                    this._mergers.push(1 * b.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1))
                  : (this._items[c].before(b), this._items.splice(c, 0, b), this._mergers.splice(c, 0, 1 * b.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)),
              this._items[e] && this.reset(this._items[e].index()),
              this.invalidate("items"),
              this.trigger("added", { content: b, position: c });
      }),
      (e.prototype.remove = function (a) {
          (a = this.normalize(a, !0)) !== d &&
              (this.trigger("remove", { content: this._items[a], position: a }),
              this._items[a].remove(),
              this._items.splice(a, 1),
              this._mergers.splice(a, 1),
              this.invalidate("items"),
              this.trigger("removed", { content: null, position: a }));
      }),
      (e.prototype.preloadAutoWidthImages = function (b) {
          b.each(
              a.proxy(function (b, c) {
                  this.enter("pre-loading"),
                      (c = a(c)),
                      a(new Image())
                          .one(
                              "load",
                              a.proxy(function (a) {
                                  c.attr("src", a.target.src), c.css("opacity", 1), this.leave("pre-loading"), !this.is("pre-loading") && !this.is("initializing") && this.refresh();
                              }, this)
                          )
                          .attr("src", c.attr("src") || c.attr("data-src") || c.attr("data-src-retina"));
              }, this)
          );
      }),
      (e.prototype.destroy = function () {
          this.$element.off(".owl.core"), this.$stage.off(".owl.core"), a(c).off(".owl.core"), !1 !== this.settings.responsive && (b.clearTimeout(this.resizeTimer), this.off(b, "resize", this._handlers.onThrottledResize));
          for (var d in this._plugins) this._plugins[d].destroy();
          this.$stage.children(".cloned").remove(),
              this.$stage.unwrap(),
              this.$stage.children().contents().unwrap(),
              this.$stage.children().unwrap(),
              this.$stage.remove(),
              this.$element
                  .removeClass(this.options.refreshClass)
                  .removeClass(this.options.loadingClass)
                  .removeClass(this.options.loadedClass)
                  .removeClass(this.options.rtlClass)
                  .removeClass(this.options.dragClass)
                  .removeClass(this.options.grabClass)
                  .attr("class", this.$element.attr("class").replace(new RegExp(this.options.responsiveClass + "-\\S+\\s", "g"), ""))
                  .removeData("owl.carousel");
      }),
      (e.prototype.op = function (a, b, c) {
          var d = this.settings.rtl;
          switch (b) {
              case "<":
                  return d ? a > c : a < c;
              case ">":
                  return d ? a < c : a > c;
              case ">=":
                  return d ? a <= c : a >= c;
              case "<=":
                  return d ? a >= c : a <= c;
          }
      }),
      (e.prototype.on = function (a, b, c, d) {
          a.addEventListener ? a.addEventListener(b, c, d) : a.attachEvent && a.attachEvent("on" + b, c);
      }),
      (e.prototype.off = function (a, b, c, d) {
          a.removeEventListener ? a.removeEventListener(b, c, d) : a.detachEvent && a.detachEvent("on" + b, c);
      }),
      (e.prototype.trigger = function (b, c, d, f, g) {
          var h = { item: { count: this._items.length, index: this.current() } },
              i = a.camelCase(
                  a
                      .grep(["on", b, d], function (a) {
                          return a;
                      })
                      .join("-")
                      .toLowerCase()
              ),
              j = a.Event([b, "owl", d || "carousel"].join(".").toLowerCase(), a.extend({ relatedTarget: this }, h, c));
          return (
              this._supress[b] ||
                  (a.each(this._plugins, function (a, b) {
                      b.onTrigger && b.onTrigger(j);
                  }),
                  this.register({ type: e.Type.Event, name: b }),
                  this.$element.trigger(j),
                  this.settings && "function" == typeof this.settings[i] && this.settings[i].call(this, j)),
              j
          );
      }),
      (e.prototype.enter = function (b) {
          a.each(
              [b].concat(this._states.tags[b] || []),
              a.proxy(function (a, b) {
                  this._states.current[b] === d && (this._states.current[b] = 0), this._states.current[b]++;
              }, this)
          );
      }),
      (e.prototype.leave = function (b) {
          a.each(
              [b].concat(this._states.tags[b] || []),
              a.proxy(function (a, b) {
                  this._states.current[b]--;
              }, this)
          );
      }),
      (e.prototype.register = function (b) {
          if (b.type === e.Type.Event) {
              if ((a.event.special[b.name] || (a.event.special[b.name] = {}), !a.event.special[b.name].owl)) {
                  var c = a.event.special[b.name]._default;
                  (a.event.special[b.name]._default = function (a) {
                      return !c || !c.apply || (a.namespace && -1 !== a.namespace.indexOf("owl")) ? a.namespace && a.namespace.indexOf("owl") > -1 : c.apply(this, arguments);
                  }),
                      (a.event.special[b.name].owl = !0);
              }
          } else
              b.type === e.Type.State &&
                  (this._states.tags[b.name] ? (this._states.tags[b.name] = this._states.tags[b.name].concat(b.tags)) : (this._states.tags[b.name] = b.tags),
                  (this._states.tags[b.name] = a.grep(
                      this._states.tags[b.name],
                      a.proxy(function (c, d) {
                          return a.inArray(c, this._states.tags[b.name]) === d;
                      }, this)
                  )));
      }),
      (e.prototype.suppress = function (b) {
          a.each(
              b,
              a.proxy(function (a, b) {
                  this._supress[b] = !0;
              }, this)
          );
      }),
      (e.prototype.release = function (b) {
          a.each(
              b,
              a.proxy(function (a, b) {
                  delete this._supress[b];
              }, this)
          );
      }),
      (e.prototype.pointer = function (a) {
          var c = { x: null, y: null };
          return (
              (a = a.originalEvent || a || b.event),
              (a = a.touches && a.touches.length ? a.touches[0] : a.changedTouches && a.changedTouches.length ? a.changedTouches[0] : a),
              a.pageX ? ((c.x = a.pageX), (c.y = a.pageY)) : ((c.x = a.clientX), (c.y = a.clientY)),
              c
          );
      }),
      (e.prototype.isNumeric = function (a) {
          return !isNaN(parseFloat(a));
      }),
      (e.prototype.difference = function (a, b) {
          return { x: a.x - b.x, y: a.y - b.y };
      }),
      (a.fn.owlCarousel = function (b) {
          var c = Array.prototype.slice.call(arguments, 1);
          return this.each(function () {
              var d = a(this),
                  f = d.data("owl.carousel");
              f ||
                  ((f = new e(this, "object" == typeof b && b)),
                  d.data("owl.carousel", f),
                  a.each(["next", "prev", "to", "destroy", "refresh", "replace", "add", "remove"], function (b, c) {
                      f.register({ type: e.Type.Event, name: c }),
                          f.$element.on(
                              c + ".owl.carousel.core",
                              a.proxy(function (a) {
                                  a.namespace && a.relatedTarget !== this && (this.suppress([c]), f[c].apply(this, [].slice.call(arguments, 1)), this.release([c]));
                              }, f)
                          );
                  })),
                  "string" == typeof b && "_" !== b.charAt(0) && f[b].apply(f, c);
          });
      }),
      (a.fn.owlCarousel.Constructor = e);
})(window.Zepto || window.jQuery, window, document),
  (function (a, b, c, d) {
      var e = function (b) {
          (this._core = b),
              (this._interval = null),
              (this._visible = null),
              (this._handlers = {
                  "initialized.owl.carousel": a.proxy(function (a) {
                      a.namespace && this._core.settings.autoRefresh && this.watch();
                  }, this),
              }),
              (this._core.options = a.extend({}, e.Defaults, this._core.options)),
              this._core.$element.on(this._handlers);
      };
      (e.Defaults = { autoRefresh: !0, autoRefreshInterval: 500 }),
          (e.prototype.watch = function () {
              this._interval || ((this._visible = this._core.isVisible()), (this._interval = b.setInterval(a.proxy(this.refresh, this), this._core.settings.autoRefreshInterval)));
          }),
          (e.prototype.refresh = function () {
              this._core.isVisible() !== this._visible && ((this._visible = !this._visible), this._core.$element.toggleClass("owl-hidden", !this._visible), this._visible && this._core.invalidate("width") && this._core.refresh());
          }),
          (e.prototype.destroy = function () {
              var a, c;
              b.clearInterval(this._interval);
              for (a in this._handlers) this._core.$element.off(a, this._handlers[a]);
              for (c in Object.getOwnPropertyNames(this)) "function" != typeof this[c] && (this[c] = null);
          }),
          (a.fn.owlCarousel.Constructor.Plugins.AutoRefresh = e);
  })(window.Zepto || window.jQuery, window, document),
  (function (a, b, c, d) {
      var e = function (b) {
          (this._core = b),
              (this._loaded = []),
              (this._handlers = {
                  "initialized.owl.carousel change.owl.carousel resized.owl.carousel": a.proxy(function (b) {
                      if (b.namespace && this._core.settings && this._core.settings.lazyLoad && ((b.property && "position" == b.property.name) || "initialized" == b.type)) {
                          var c = this._core.settings,
                              e = (c.center && Math.ceil(c.items / 2)) || c.items,
                              f = (c.center && -1 * e) || 0,
                              g = (b.property && b.property.value !== d ? b.property.value : this._core.current()) + f,
                              h = this._core.clones().length,
                              i = a.proxy(function (a, b) {
                                  this.load(b);
                              }, this);
                          for (c.lazyLoadEager > 0 && ((e += c.lazyLoadEager), c.loop && ((g -= c.lazyLoadEager), e++)); f++ < e; ) this.load(h / 2 + this._core.relative(g)), h && a.each(this._core.clones(this._core.relative(g)), i), g++;
                      }
                  }, this),
              }),
              (this._core.options = a.extend({}, e.Defaults, this._core.options)),
              this._core.$element.on(this._handlers);
      };
      (e.Defaults = { lazyLoad: !1, lazyLoadEager: 0 }),
          (e.prototype.load = function (c) {
              var d = this._core.$stage.children().eq(c),
                  e = d && d.find(".owl-lazy");
              !e ||
                  a.inArray(d.get(0), this._loaded) > -1 ||
                  (e.each(
                      a.proxy(function (c, d) {
                          var e,
                              f = a(d),
                              g = (b.devicePixelRatio > 1 && f.attr("data-src-retina")) || f.attr("data-src") || f.attr("data-srcset");
                          this._core.trigger("load", { element: f, url: g }, "lazy"),
                              f.is("img")
                                  ? f
                                        .one(
                                            "load.owl.lazy",
                                            a.proxy(function () {
                                                f.css("opacity", 1), this._core.trigger("loaded", { element: f, url: g }, "lazy");
                                            }, this)
                                        )
                                        .attr("src", g)
                                  : f.is("source")
                                  ? f
                                        .one(
                                            "load.owl.lazy",
                                            a.proxy(function () {
                                                this._core.trigger("loaded", { element: f, url: g }, "lazy");
                                            }, this)
                                        )
                                        .attr("srcset", g)
                                  : ((e = new Image()),
                                    (e.onload = a.proxy(function () {
                                        f.css({ "background-image": 'url("' + g + '")', opacity: "1" }), this._core.trigger("loaded", { element: f, url: g }, "lazy");
                                    }, this)),
                                    (e.src = g));
                      }, this)
                  ),
                  this._loaded.push(d.get(0)));
          }),
          (e.prototype.destroy = function () {
              var a, b;
              for (a in this.handlers) this._core.$element.off(a, this.handlers[a]);
              for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null);
          }),
          (a.fn.owlCarousel.Constructor.Plugins.Lazy = e);
  })(window.Zepto || window.jQuery, window, document),
  (function (a, b, c, d) {
      var e = function (c) {
          (this._core = c),
              (this._previousHeight = null),
              (this._handlers = {
                  "initialized.owl.carousel refreshed.owl.carousel": a.proxy(function (a) {
                      a.namespace && this._core.settings.autoHeight && this.update();
                  }, this),
                  "changed.owl.carousel": a.proxy(function (a) {
                      a.namespace && this._core.settings.autoHeight && "position" === a.property.name && this.update();
                  }, this),
                  "loaded.owl.lazy": a.proxy(function (a) {
                      a.namespace && this._core.settings.autoHeight && a.element.closest("." + this._core.settings.itemClass).index() === this._core.current() && this.update();
                  }, this),
              }),
              (this._core.options = a.extend({}, e.Defaults, this._core.options)),
              this._core.$element.on(this._handlers),
              (this._intervalId = null);
          var d = this;
          a(b).on("load", function () {
              d._core.settings.autoHeight && d.update();
          }),
              a(b).resize(function () {
                  d._core.settings.autoHeight &&
                      (null != d._intervalId && clearTimeout(d._intervalId),
                      (d._intervalId = setTimeout(function () {
                          d.update();
                      }, 250)));
              });
      };
      (e.Defaults = { autoHeight: !1, autoHeightClass: "owl-height" }),
          (e.prototype.update = function () {
              var b = this._core._current,
                  c = b + this._core.settings.items,
                  d = this._core.settings.lazyLoad,
                  e = this._core.$stage.children().toArray().slice(b, c),
                  f = [],
                  g = 0;
              a.each(e, function (b, c) {
                  f.push(a(c).height());
              }),
                  (g = Math.max.apply(null, f)),
                  g <= 1 && d && this._previousHeight && (g = this._previousHeight),
                  (this._previousHeight = g),
                  this._core.$stage.parent().height(g).addClass(this._core.settings.autoHeightClass);
          }),
          (e.prototype.destroy = function () {
              var a, b;
              for (a in this._handlers) this._core.$element.off(a, this._handlers[a]);
              for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null);
          }),
          (a.fn.owlCarousel.Constructor.Plugins.AutoHeight = e);
  })(window.Zepto || window.jQuery, window, document),
  (function (a, b, c, d) {
      var e = function (b) {
          (this._core = b),
              (this._videos = {}),
              (this._playing = null),
              (this._handlers = {
                  "initialized.owl.carousel": a.proxy(function (a) {
                      a.namespace && this._core.register({ type: "state", name: "playing", tags: ["interacting"] });
                  }, this),
                  "resize.owl.carousel": a.proxy(function (a) {
                      a.namespace && this._core.settings.video && this.isInFullScreen() && a.preventDefault();
                  }, this),
                  "refreshed.owl.carousel": a.proxy(function (a) {
                      a.namespace && this._core.is("resizing") && this._core.$stage.find(".cloned .owl-video-frame").remove();
                  }, this),
                  "changed.owl.carousel": a.proxy(function (a) {
                      a.namespace && "position" === a.property.name && this._playing && this.stop();
                  }, this),
                  "prepared.owl.carousel": a.proxy(function (b) {
                      if (b.namespace) {
                          var c = a(b.content).find(".owl-video");
                          c.length && (c.css("display", "none"), this.fetch(c, a(b.content)));
                      }
                  }, this),
              }),
              (this._core.options = a.extend({}, e.Defaults, this._core.options)),
              this._core.$element.on(this._handlers),
              this._core.$element.on(
                  "click.owl.video",
                  ".owl-video-play-icon",
                  a.proxy(function (a) {
                      this.play(a);
                  }, this)
              );
      };
      (e.Defaults = { video: !1, videoHeight: !1, videoWidth: !1 }),
          (e.prototype.fetch = function (a, b) {
              var c = (function () {
                      return a.attr("data-vimeo-id") ? "vimeo" : a.attr("data-vzaar-id") ? "vzaar" : "youtube";
                  })(),
                  d = a.attr("data-vimeo-id") || a.attr("data-youtube-id") || a.attr("data-vzaar-id"),
                  e = a.attr("data-width") || this._core.settings.videoWidth,
                  f = a.attr("data-height") || this._core.settings.videoHeight,
                  g = a.attr("href");
              if (!g) throw new Error("Missing video URL.");
              if (
                  ((d = g.match(
                      /(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com|be\-nocookie\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/
                  )),
                  d[3].indexOf("youtu") > -1)
              )
                  c = "youtube";
              else if (d[3].indexOf("vimeo") > -1) c = "vimeo";
              else {
                  if (!(d[3].indexOf("vzaar") > -1)) throw new Error("Video URL not supported.");
                  c = "vzaar";
              }
              (d = d[6]), (this._videos[g] = { type: c, id: d, width: e, height: f }), b.attr("data-video", g), this.thumbnail(a, this._videos[g]);
          }),
          (e.prototype.thumbnail = function (b, c) {
              var d,
                  e,
                  f,
                  g = c.width && c.height ? "width:" + c.width + "px;height:" + c.height + "px;" : "",
                  h = b.find("img"),
                  i = "src",
                  j = "",
                  k = this._core.settings,
                  l = function (c) {
                      (e = '<div class="owl-video-play-icon"></div>'),
                          (d = k.lazyLoad ? a("<div/>", { class: "owl-video-tn " + j, srcType: c }) : a("<div/>", { class: "owl-video-tn", style: "opacity:1;background-image:url(" + c + ")" })),
                          b.after(d),
                          b.after(e);
                  };
              if ((b.wrap(a("<div/>", { class: "owl-video-wrapper", style: g })), this._core.settings.lazyLoad && ((i = "data-src"), (j = "owl-lazy")), h.length)) return l(h.attr(i)), h.remove(), !1;
              "youtube" === c.type
                  ? ((f = "//img.youtube.com/vi/" + c.id + "/hqdefault.jpg"), l(f))
                  : "vimeo" === c.type
                  ? a.ajax({
                        type: "GET",
                        url: "//vimeo.com/api/v2/video/" + c.id + ".json",
                        jsonp: "callback",
                        dataType: "jsonp",
                        success: function (a) {
                            (f = a[0].thumbnail_large), l(f);
                        },
                    })
                  : "vzaar" === c.type &&
                    a.ajax({
                        type: "GET",
                        url: "//vzaar.com/api/videos/" + c.id + ".json",
                        jsonp: "callback",
                        dataType: "jsonp",
                        success: function (a) {
                            (f = a.framegrab_url), l(f);
                        },
                    });
          }),
          (e.prototype.stop = function () {
              this._core.trigger("stop", null, "video"),
                  this._playing.find(".owl-video-frame").remove(),
                  this._playing.removeClass("owl-video-playing"),
                  (this._playing = null),
                  this._core.leave("playing"),
                  this._core.trigger("stopped", null, "video");
          }),
          (e.prototype.play = function (b) {
              var c,
                  d = a(b.target),
                  e = d.closest("." + this._core.settings.itemClass),
                  f = this._videos[e.attr("data-video")],
                  g = f.width || "100%",
                  h = f.height || this._core.$stage.height();
              this._playing ||
                  (this._core.enter("playing"),
                  this._core.trigger("play", null, "video"),
                  (e = this._core.items(this._core.relative(e.index()))),
                  this._core.reset(e.index()),
                  (c = a('<iframe frameborder="0" allowfullscreen mozallowfullscreen webkitAllowFullScreen ></iframe>')),
                  c.attr("height", h),
                  c.attr("width", g),
                  "youtube" === f.type
                      ? c.attr("src", "//www.youtube.com/embed/" + f.id + "?autoplay=1&rel=0&v=" + f.id)
                      : "vimeo" === f.type
                      ? c.attr("src", "//player.vimeo.com/video/" + f.id + "?autoplay=1")
                      : "vzaar" === f.type && c.attr("src", "//view.vzaar.com/" + f.id + "/player?autoplay=true"),
                  a(c).wrap('<div class="owl-video-frame" />').insertAfter(e.find(".owl-video")),
                  (this._playing = e.addClass("owl-video-playing")));
          }),
          (e.prototype.isInFullScreen = function () {
              var b = c.fullscreenElement || c.mozFullScreenElement || c.webkitFullscreenElement;
              return b && a(b).parent().hasClass("owl-video-frame");
          }),
          (e.prototype.destroy = function () {
              var a, b;
              this._core.$element.off("click.owl.video");
              for (a in this._handlers) this._core.$element.off(a, this._handlers[a]);
              for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null);
          }),
          (a.fn.owlCarousel.Constructor.Plugins.Video = e);
  })(window.Zepto || window.jQuery, window, document),
  (function (a, b, c, d) {
      var e = function (b) {
          (this.core = b),
              (this.core.options = a.extend({}, e.Defaults, this.core.options)),
              (this.swapping = !0),
              (this.previous = d),
              (this.next = d),
              (this.handlers = {
                  "change.owl.carousel": a.proxy(function (a) {
                      a.namespace && "position" == a.property.name && ((this.previous = this.core.current()), (this.next = a.property.value));
                  }, this),
                  "drag.owl.carousel dragged.owl.carousel translated.owl.carousel": a.proxy(function (a) {
                      a.namespace && (this.swapping = "translated" == a.type);
                  }, this),
                  "translate.owl.carousel": a.proxy(function (a) {
                      a.namespace && this.swapping && (this.core.options.animateOut || this.core.options.animateIn) && this.swap();
                  }, this),
              }),
              this.core.$element.on(this.handlers);
      };
      (e.Defaults = { animateOut: !1, animateIn: !1 }),
          (e.prototype.swap = function () {
              if (1 === this.core.settings.items && a.support.animation && a.support.transition) {
                  this.core.speed(0);
                  var b,
                      c = a.proxy(this.clear, this),
                      d = this.core.$stage.children().eq(this.previous),
                      e = this.core.$stage.children().eq(this.next),
                      f = this.core.settings.animateIn,
                      g = this.core.settings.animateOut;
                  this.core.current() !== this.previous &&
                      (g &&
                          ((b = this.core.coordinates(this.previous) - this.core.coordinates(this.next)),
                          d
                              .one(a.support.animation.end, c)
                              .css({ left: b + "px" })
                              .addClass("animated owl-animated-out")
                              .addClass(g)),
                      f && e.one(a.support.animation.end, c).addClass("animated owl-animated-in").addClass(f));
              }
          }),
          (e.prototype.clear = function (b) {
              a(b.target).css({ left: "" }).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut), this.core.onTransitionEnd();
          }),
          (e.prototype.destroy = function () {
              var a, b;
              for (a in this.handlers) this.core.$element.off(a, this.handlers[a]);
              for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null);
          }),
          (a.fn.owlCarousel.Constructor.Plugins.Animate = e);
  })(window.Zepto || window.jQuery, window, document),
  (function (a, b, c, d) {
      var e = function (b) {
          (this._core = b),
              (this._call = null),
              (this._time = 0),
              (this._timeout = 0),
              (this._paused = !0),
              (this._handlers = {
                  "changed.owl.carousel": a.proxy(function (a) {
                      a.namespace && "settings" === a.property.name ? (this._core.settings.autoplay ? this.play() : this.stop()) : a.namespace && "position" === a.property.name && this._paused && (this._time = 0);
                  }, this),
                  "initialized.owl.carousel": a.proxy(function (a) {
                      a.namespace && this._core.settings.autoplay && this.play();
                  }, this),
                  "play.owl.autoplay": a.proxy(function (a, b, c) {
                      a.namespace && this.play(b, c);
                  }, this),
                  "stop.owl.autoplay": a.proxy(function (a) {
                      a.namespace && this.stop();
                  }, this),
                  "mouseover.owl.autoplay": a.proxy(function () {
                      this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause();
                  }, this),
                  "mouseleave.owl.autoplay": a.proxy(function () {
                      this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.play();
                  }, this),
                  "touchstart.owl.core": a.proxy(function () {
                      this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause();
                  }, this),
                  "touchend.owl.core": a.proxy(function () {
                      this._core.settings.autoplayHoverPause && this.play();
                  }, this),
              }),
              this._core.$element.on(this._handlers),
              (this._core.options = a.extend({}, e.Defaults, this._core.options));
      };
      (e.Defaults = { autoplay: !1, autoplayTimeout: 5e3, autoplayHoverPause: !1, autoplaySpeed: !1 }),
          (e.prototype._next = function (d) {
              (this._call = b.setTimeout(a.proxy(this._next, this, d), this._timeout * (Math.round(this.read() / this._timeout) + 1) - this.read())),
                  this._core.is("interacting") || c.hidden || this._core.next(d || this._core.settings.autoplaySpeed);
          }),
          (e.prototype.read = function () {
              return new Date().getTime() - this._time;
          }),
          (e.prototype.play = function (c, d) {
              var e;
              this._core.is("rotating") || this._core.enter("rotating"),
                  (c = c || this._core.settings.autoplayTimeout),
                  (e = Math.min(this._time % (this._timeout || c), c)),
                  this._paused ? ((this._time = this.read()), (this._paused = !1)) : b.clearTimeout(this._call),
                  (this._time += (this.read() % c) - e),
                  (this._timeout = c),
                  (this._call = b.setTimeout(a.proxy(this._next, this, d), c - e));
          }),
          (e.prototype.stop = function () {
              this._core.is("rotating") && ((this._time = 0), (this._paused = !0), b.clearTimeout(this._call), this._core.leave("rotating"));
          }),
          (e.prototype.pause = function () {
              this._core.is("rotating") && !this._paused && ((this._time = this.read()), (this._paused = !0), b.clearTimeout(this._call));
          }),
          (e.prototype.destroy = function () {
              var a, b;
              this.stop();
              for (a in this._handlers) this._core.$element.off(a, this._handlers[a]);
              for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null);
          }),
          (a.fn.owlCarousel.Constructor.Plugins.autoplay = e);
  })(window.Zepto || window.jQuery, window, document),
  (function (a, b, c, d) {
      "use strict";
      var e = function (b) {
          (this._core = b),
              (this._initialized = !1),
              (this._pages = []),
              (this._controls = {}),
              (this._templates = []),
              (this.$element = this._core.$element),
              (this._overrides = { next: this._core.next, prev: this._core.prev, to: this._core.to }),
              (this._handlers = {
                  "prepared.owl.carousel": a.proxy(function (b) {
                      b.namespace && this._core.settings.dotsData && this._templates.push('<div class="' + this._core.settings.dotClass + '">' + a(b.content).find("[data-dot]").addBack("[data-dot]").attr("data-dot") + "</div>");
                  }, this),
                  "added.owl.carousel": a.proxy(function (a) {
                      a.namespace && this._core.settings.dotsData && this._templates.splice(a.position, 0, this._templates.pop());
                  }, this),
                  "remove.owl.carousel": a.proxy(function (a) {
                      a.namespace && this._core.settings.dotsData && this._templates.splice(a.position, 1);
                  }, this),
                  "changed.owl.carousel": a.proxy(function (a) {
                      a.namespace && "position" == a.property.name && this.draw();
                  }, this),
                  "initialized.owl.carousel": a.proxy(function (a) {
                      a.namespace &&
                          !this._initialized &&
                          (this._core.trigger("initialize", null, "navigation"), this.initialize(), this.update(), this.draw(), (this._initialized = !0), this._core.trigger("initialized", null, "navigation"));
                  }, this),
                  "refreshed.owl.carousel": a.proxy(function (a) {
                      a.namespace && this._initialized && (this._core.trigger("refresh", null, "navigation"), this.update(), this.draw(), this._core.trigger("refreshed", null, "navigation"));
                  }, this),
              }),
              (this._core.options = a.extend({}, e.Defaults, this._core.options)),
              this.$element.on(this._handlers);
      };
      (e.Defaults = {
          nav: !1,
          navText: ['<span aria-label="Previous">&#x2039;</span>', '<span aria-label="Next">&#x203a;</span>'],
          navSpeed: !1,
          navElement: 'button type="button" role="presentation"',
          navContainer: !1,
          navContainerClass: "owl-nav",
          navClass: ["owl-prev", "owl-next"],
          slideBy: 1,
          dotClass: "owl-dot",
          dotsClass: "owl-dots",
          dots: !0,
          dotsEach: !1,
          dotsData: !1,
          dotsSpeed: !1,
          dotsContainer: !1,
      }),
          (e.prototype.initialize = function () {
              var b,
                  c = this._core.settings;
              (this._controls.$relative = (c.navContainer ? a(c.navContainer) : a("<div>").addClass(c.navContainerClass).appendTo(this.$element)).addClass("disabled")),
                  (this._controls.$previous = a("<" + c.navElement + ">")
                      .addClass(c.navClass[0])
                      .html(c.navText[0])
                      .prependTo(this._controls.$relative)
                      .on(
                          "click",
                          a.proxy(function (a) {
                              this.prev(c.navSpeed);
                          }, this)
                      )),
                  (this._controls.$next = a("<" + c.navElement + ">")
                      .addClass(c.navClass[1])
                      .html(c.navText[1])
                      .appendTo(this._controls.$relative)
                      .on(
                          "click",
                          a.proxy(function (a) {
                              this.next(c.navSpeed);
                          }, this)
                      )),
                  c.dotsData || (this._templates = [a('<button role="button">').addClass(c.dotClass).append(a("<span>")).prop("outerHTML")]),
                  (this._controls.$absolute = (c.dotsContainer ? a(c.dotsContainer) : a("<div>").addClass(c.dotsClass).appendTo(this.$element)).addClass("disabled")),
                  this._controls.$absolute.on(
                      "click",
                      "button",
                      a.proxy(function (b) {
                          var d = a(b.target).parent().is(this._controls.$absolute) ? a(b.target).index() : a(b.target).parent().index();
                          b.preventDefault(), this.to(d, c.dotsSpeed);
                      }, this)
                  );
              for (b in this._overrides) this._core[b] = a.proxy(this[b], this);
          }),
          (e.prototype.destroy = function () {
              var a, b, c, d, e;
              e = this._core.settings;
              for (a in this._handlers) this.$element.off(a, this._handlers[a]);
              for (b in this._controls) "$relative" === b && e.navContainer ? this._controls[b].html("") : this._controls[b].remove();
              for (d in this.overides) this._core[d] = this._overrides[d];
              for (c in Object.getOwnPropertyNames(this)) "function" != typeof this[c] && (this[c] = null);
          }),
          (e.prototype.update = function () {
              var a,
                  b,
                  c,
                  d = this._core.clones().length / 2,
                  e = d + this._core.items().length,
                  f = this._core.maximum(!0),
                  g = this._core.settings,
                  h = g.center || g.autoWidth || g.dotsData ? 1 : g.dotsEach || g.items;
              if (("page" !== g.slideBy && (g.slideBy = Math.min(g.slideBy, g.items)), g.dots || "page" == g.slideBy))
                  for (this._pages = [], a = d, b = 0, c = 0; a < e; a++) {
                      if (b >= h || 0 === b) {
                          if ((this._pages.push({ start: Math.min(f, a - d), end: a - d + h - 1 }), Math.min(f, a - d) === f)) break;
                          (b = 0), ++c;
                      }
                      b += this._core.mergers(this._core.relative(a));
                  }
          }),
          (e.prototype.draw = function () {
              var b,
                  c = this._core.settings,
                  d = this._core.items().length <= c.items,
                  e = this._core.relative(this._core.current()),
                  f = c.loop || c.rewind;
              this._controls.$relative.toggleClass("disabled", !c.nav || d),
                  c.nav && (this._controls.$previous.toggleClass("disabled", !f && e <= this._core.minimum(!0)), this._controls.$next.toggleClass("disabled", !f && e >= this._core.maximum(!0))),
                  this._controls.$absolute.toggleClass("disabled", !c.dots || d),
                  c.dots &&
                      ((b = this._pages.length - this._controls.$absolute.children().length),
                      c.dotsData && 0 !== b
                          ? this._controls.$absolute.html(this._templates.join(""))
                          : b > 0
                          ? this._controls.$absolute.append(new Array(b + 1).join(this._templates[0]))
                          : b < 0 && this._controls.$absolute.children().slice(b).remove(),
                      this._controls.$absolute.find(".active").removeClass("active"),
                      this._controls.$absolute.children().eq(a.inArray(this.current(), this._pages)).addClass("active"));
          }),
          (e.prototype.onTrigger = function (b) {
              var c = this._core.settings;
              b.page = { index: a.inArray(this.current(), this._pages), count: this._pages.length, size: c && (c.center || c.autoWidth || c.dotsData ? 1 : c.dotsEach || c.items) };
          }),
          (e.prototype.current = function () {
              var b = this._core.relative(this._core.current());
              return a
                  .grep(
                      this._pages,
                      a.proxy(function (a, c) {
                          return a.start <= b && a.end >= b;
                      }, this)
                  )
                  .pop();
          }),
          (e.prototype.getPosition = function (b) {
              var c,
                  d,
                  e = this._core.settings;
              return (
                  "page" == e.slideBy
                      ? ((c = a.inArray(this.current(), this._pages)), (d = this._pages.length), b ? ++c : --c, (c = this._pages[((c % d) + d) % d].start))
                      : ((c = this._core.relative(this._core.current())), (d = this._core.items().length), b ? (c += e.slideBy) : (c -= e.slideBy)),
                  c
              );
          }),
          (e.prototype.next = function (b) {
              a.proxy(this._overrides.to, this._core)(this.getPosition(!0), b);
          }),
          (e.prototype.prev = function (b) {
              a.proxy(this._overrides.to, this._core)(this.getPosition(!1), b);
          }),
          (e.prototype.to = function (b, c, d) {
              var e;
              !d && this._pages.length ? ((e = this._pages.length), a.proxy(this._overrides.to, this._core)(this._pages[((b % e) + e) % e].start, c)) : a.proxy(this._overrides.to, this._core)(b, c);
          }),
          (a.fn.owlCarousel.Constructor.Plugins.Navigation = e);
  })(window.Zepto || window.jQuery, window, document),
  (function (a, b, c, d) {
      "use strict";
      var e = function (c) {
          (this._core = c),
              (this._hashes = {}),
              (this.$element = this._core.$element),
              (this._handlers = {
                  "initialized.owl.carousel": a.proxy(function (c) {
                      c.namespace && "URLHash" === this._core.settings.startPosition && a(b).trigger("hashchange.owl.navigation");
                  }, this),
                  "prepared.owl.carousel": a.proxy(function (b) {
                      if (b.namespace) {
                          var c = a(b.content).find("[data-hash]").addBack("[data-hash]").attr("data-hash");
                          if (!c) return;
                          this._hashes[c] = b.content;
                      }
                  }, this),
                  "changed.owl.carousel": a.proxy(function (c) {
                      if (c.namespace && "position" === c.property.name) {
                          var d = this._core.items(this._core.relative(this._core.current())),
                              e = a
                                  .map(this._hashes, function (a, b) {
                                      return a === d ? b : null;
                                  })
                                  .join();
                          if (!e || b.location.hash.slice(1) === e) return;
                          b.location.hash = e;
                      }
                  }, this),
              }),
              (this._core.options = a.extend({}, e.Defaults, this._core.options)),
              this.$element.on(this._handlers),
              a(b).on(
                  "hashchange.owl.navigation",
                  a.proxy(function (a) {
                      var c = b.location.hash.substring(1),
                          e = this._core.$stage.children(),
                          f = this._hashes[c] && e.index(this._hashes[c]);
                      f !== d && f !== this._core.current() && this._core.to(this._core.relative(f), !1, !0);
                  }, this)
              );
      };
      (e.Defaults = { URLhashListener: !1 }),
          (e.prototype.destroy = function () {
              var c, d;
              a(b).off("hashchange.owl.navigation");
              for (c in this._handlers) this._core.$element.off(c, this._handlers[c]);
              for (d in Object.getOwnPropertyNames(this)) "function" != typeof this[d] && (this[d] = null);
          }),
          (a.fn.owlCarousel.Constructor.Plugins.Hash = e);
  })(window.Zepto || window.jQuery, window, document),
  (function (a, b, c, d) {
      function e(b, c) {
          var e = !1,
              f = b.charAt(0).toUpperCase() + b.slice(1);
          return (
              a.each((b + " " + h.join(f + " ") + f).split(" "), function (a, b) {
                  if (g[b] !== d) return (e = !c || b), !1;
              }),
              e
          );
      }
      function f(a) {
          return e(a, !0);
      }
      var g = a("<support>").get(0).style,
          h = "Webkit Moz O ms".split(" "),
          i = {
              transition: { end: { WebkitTransition: "webkitTransitionEnd", MozTransition: "transitionend", OTransition: "oTransitionEnd", transition: "transitionend" } },
              animation: { end: { WebkitAnimation: "webkitAnimationEnd", MozAnimation: "animationend", OAnimation: "oAnimationEnd", animation: "animationend" } },
          },
          j = {
              csstransforms: function () {
                  return !!e("transform");
              },
              csstransforms3d: function () {
                  return !!e("perspective");
              },
              csstransitions: function () {
                  return !!e("transition");
              },
              cssanimations: function () {
                  return !!e("animation");
              },
          };
      j.csstransitions() && ((a.support.transition = new String(f("transition"))), (a.support.transition.end = i.transition.end[a.support.transition])),
          j.cssanimations() && ((a.support.animation = new String(f("animation"))), (a.support.animation.end = i.animation.end[a.support.animation])),
          j.csstransforms() && ((a.support.transform = new String(f("transform"))), (a.support.transform3d = j.csstransforms3d()));
  })(window.Zepto || window.jQuery, window, document);

/* Magnific Popup - v1.1.0 - 2016-02-20*/
!(function (b) {
  "function" == typeof define && define.amd ? define(["jquery"], b) : b("object" == typeof exports ? require("jquery") : window.jQuery || window.Zepto);
})(function (aQ) {
  var aP,
      aO,
      aN,
      aM,
      aL,
      aK,
      aJ = "Close",
      aI = "BeforeClose",
      aH = "AfterClose",
      aG = "BeforeAppend",
      aF = "MarkupParse",
      aE = "Open",
      aD = "Change",
      aC = "mfp",
      aB = "." + aC,
      aA = "mfp-ready",
      az = "mfp-removing",
      ay = "mfp-prevent-close",
      ax = function () {},
      aw = !!window.jQuery,
      av = aQ(window),
      au = function (b, d) {
          aP.ev.on(aC + b + aB, d);
      },
      at = function (a, j, i, h) {
          var g = document.createElement("div");
          return (g.className = "mfp-" + a), i && (g.innerHTML = i), h ? j && j.appendChild(g) : ((g = aQ(g)), j && g.appendTo(j)), g;
      },
      ar = function (b, a) {
          aP.ev.triggerHandler(aC + b, a), aP.st.callbacks && ((b = b.charAt(0).toLowerCase() + b.slice(1)), aP.st.callbacks[b] && aP.st.callbacks[b].apply(aP, aQ.isArray(a) ? a : [a]));
      },
      aq = function (a) {
          return (a === aK && aP.currTemplate.closeBtn) || ((aP.currTemplate.closeBtn = aQ(aP.st.closeMarkup.replace("%title%", aP.st.tClose))), (aK = a)), aP.currTemplate.closeBtn;
      },
      ap = function () {
          aQ.magnificPopup.instance || ((aP = new ax()), aP.init(), (aQ.magnificPopup.instance = aP));
      },
      ao = function () {
          var d = document.createElement("p").style,
              c = ["ms", "O", "Moz", "Webkit"];
          if (void 0 !== d.transition) {
              return !0;
          }
          for (; c.length; ) {
              if (c.pop() + "Transition" in d) {
                  return !0;
              }
          }
          return !1;
      };
  (ax.prototype = {
      constructor: ax,
      init: function () {
          var a = navigator.appVersion;
          (aP.isLowIE = aP.isIE8 = document.all && !document.addEventListener),
              (aP.isAndroid = /android/gi.test(a)),
              (aP.isIOS = /iphone|ipad|ipod/gi.test(a)),
              (aP.supportsTransition = ao()),
              (aP.probablyMobile = aP.isAndroid || aP.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent)),
              (aN = aQ(document)),
              (aP.popupsCache = {});
      },
      open: function (t) {
          var s;
          if (t.isObj === !1) {
              (aP.items = t.items.toArray()), (aP.index = 0);
              var q,
                  p = t.items;
              for (s = 0; s < p.length; s++) {
                  if (((q = p[s]), q.parsed && (q = q.el[0]), q === t.el[0])) {
                      aP.index = s;
                      break;
                  }
              }
          } else {
              (aP.items = aQ.isArray(t.items) ? t.items : [t.items]), (aP.index = t.index || 0);
          }
          if (aP.isOpen) {
              return void aP.updateItemHTML();
          }
          (aP.types = []),
              (aL = ""),
              t.mainEl && t.mainEl.length ? (aP.ev = t.mainEl.eq(0)) : (aP.ev = aN),
              t.key ? (aP.popupsCache[t.key] || (aP.popupsCache[t.key] = {}), (aP.currTemplate = aP.popupsCache[t.key])) : (aP.currTemplate = {}),
              (aP.st = aQ.extend(!0, {}, aQ.magnificPopup.defaults, t)),
              (aP.fixedContentPos = "auto" === aP.st.fixedContentPos ? !aP.probablyMobile : aP.st.fixedContentPos),
              aP.st.modal && ((aP.st.closeOnContentClick = !1), (aP.st.closeOnBgClick = !1), (aP.st.showCloseBtn = !1), (aP.st.enableEscapeKey = !1)),
              aP.bgOverlay ||
                  ((aP.bgOverlay = at("bg").on("click" + aB, function () {
                      aP.close();
                  })),
                  (aP.wrap = at("wrap")
                      .attr("tabindex", -1)
                      .on("click" + aB, function (c) {
                          aP._checkIfClose(c.target) && aP.close();
                      })),
                  (aP.container = at("container", aP.wrap))),
              (aP.contentContainer = at("content")),
              aP.st.preloader && (aP.preloader = at("preloader", aP.container, aP.st.tLoading));
          var m = aQ.magnificPopup.modules;
          for (s = 0; s < m.length; s++) {
              var l = m[s];
              (l = l.charAt(0).toUpperCase() + l.slice(1)), aP["init" + l].call(aP);
          }
          ar("BeforeOpen"),
              aP.st.showCloseBtn &&
                  (aP.st.closeBtnInside
                      ? (au(aF, function (g, e, i, h) {
                            i.close_replaceWith = aq(h.type);
                        }),
                        (aL += " mfp-close-btn-in"))
                      : aP.wrap.append(aq())),
              aP.st.alignTop && (aL += " mfp-align-top"),
              aP.fixedContentPos ? aP.wrap.css({ overflow: aP.st.overflowY, overflowX: "hidden", overflowY: aP.st.overflowY }) : aP.wrap.css({ top: av.scrollTop(), position: "absolute" }),
              (aP.st.fixedBgPos === !1 || ("auto" === aP.st.fixedBgPos && !aP.fixedContentPos)) && aP.bgOverlay.css({ height: aN.height(), position: "absolute" }),
              aP.st.enableEscapeKey &&
                  aN.on("keyup" + aB, function (c) {
                      27 === c.keyCode && aP.close();
                  }),
              av.on("resize" + aB, function () {
                  aP.updateSize();
              }),
              aP.st.closeOnContentClick || (aL += " mfp-auto-cursor"),
              aL && aP.wrap.addClass(aL);
          var f = (aP.wH = av.height()),
              d = {};
          if (aP.fixedContentPos && aP._hasScrollBar(f)) {
              var b = aP._getScrollbarSize();
              b && (d.marginRight = b);
          }
          aP.fixedContentPos && (aP.isIE7 ? aQ("body, html").css("overflow", "hidden") : (d.overflow = "hidden"));
          var a = aP.st.mainClass;
          return (
              aP.isIE7 && (a += " mfp-ie7"),
              a && aP._addClassToMFP(a),
              aP.updateItemHTML(),
              ar("BuildControls"),
              aQ("html").css(d),
              aP.bgOverlay.add(aP.wrap).prependTo(aP.st.prependTo || aQ(document.body)),
              (aP._lastFocusedEl = document.activeElement),
              setTimeout(function () {
                  aP.content ? (aP._addClassToMFP(aA), aP._setFocus()) : aP.bgOverlay.addClass(aA), aN.on("focusin" + aB, aP._onFocusIn);
              }, 16),
              (aP.isOpen = !0),
              aP.updateSize(f),
              ar(aE),
              t
          );
      },
      close: function () {
          aP.isOpen &&
              (ar(aI),
              (aP.isOpen = !1),
              aP.st.removalDelay && !aP.isLowIE && aP.supportsTransition
                  ? (aP._addClassToMFP(az),
                    setTimeout(function () {
                        aP._close();
                    }, aP.st.removalDelay))
                  : aP._close());
      },
      _close: function () {
          ar(aJ);
          var b = az + " " + aA + " ";
          if ((aP.bgOverlay.detach(), aP.wrap.detach(), aP.container.empty(), aP.st.mainClass && (b += aP.st.mainClass + " "), aP._removeClassFromMFP(b), aP.fixedContentPos)) {
              var a = { marginRight: "" };
              aP.isIE7 ? aQ("body, html").css("overflow", "") : (a.overflow = ""), aQ("html").css(a);
          }
          aN.off("keyup" + aB + " focusin" + aB),
              aP.ev.off(aB),
              aP.wrap.attr("class", "mfp-wrap").removeAttr("style"),
              aP.bgOverlay.attr("class", "mfp-bg"),
              aP.container.attr("class", "mfp-container"),
              !aP.st.showCloseBtn || (aP.st.closeBtnInside && aP.currTemplate[aP.currItem.type] !== !0) || (aP.currTemplate.closeBtn && aP.currTemplate.closeBtn.detach()),
              aP.st.autoFocusLast && aP._lastFocusedEl && aQ(aP._lastFocusedEl).focus(),
              (aP.currItem = null),
              (aP.content = null),
              (aP.currTemplate = null),
              (aP.prevHeight = 0),
              ar(aH);
      },
      updateSize: function (b) {
          if (aP.isIOS) {
              var f = document.documentElement.clientWidth / window.innerWidth,
                  e = window.innerHeight * f;
              aP.wrap.css("height", e), (aP.wH = e);
          } else {
              aP.wH = b || av.height();
          }
          aP.fixedContentPos || aP.wrap.css("height", aP.wH), ar("Resize");
      },
      updateItemHTML: function () {
          var h = aP.items[aP.index];
          aP.contentContainer.detach(), aP.content && aP.content.detach(), h.parsed || (h = aP.parseEl(aP.index));
          var e = h.type;
          if ((ar("BeforeChange", [aP.currItem ? aP.currItem.type : "", e]), (aP.currItem = h), !aP.currTemplate[e])) {
              var b = aP.st[e] ? aP.st[e].markup : !1;
              ar("FirstMarkupParse", b), b ? (aP.currTemplate[e] = aQ(b)) : (aP.currTemplate[e] = !0);
          }
          aM && aM !== h.type && aP.container.removeClass("mfp-" + aM + "-holder");
          var a = aP["get" + e.charAt(0).toUpperCase() + e.slice(1)](h, aP.currTemplate[e]);
          aP.appendContent(a, e), (h.preloaded = !0), ar(aD, h), (aM = h.type), aP.container.prepend(aP.contentContainer), ar("AfterChange");
      },
      appendContent: function (b, d) {
          (aP.content = b),
              b ? (aP.st.showCloseBtn && aP.st.closeBtnInside && aP.currTemplate[d] === !0 ? aP.content.find(".mfp-close").length || aP.content.append(aq()) : (aP.content = b)) : (aP.content = ""),
              ar(aG),
              aP.container.addClass("mfp-" + d + "-holder"),
              aP.contentContainer.append(aP.content);
      },
      parseEl: function (j) {
          var i,
              h = aP.items[j];
          if ((h.tagName ? (h = { el: aQ(h) }) : ((i = h.type), (h = { data: h, src: h.src })), h.el)) {
              for (var b = aP.types, a = 0; a < b.length; a++) {
                  if (h.el.hasClass("mfp-" + b[a])) {
                      i = b[a];
                      break;
                  }
              }
              (h.src = h.el.attr("data-mfp-src")), h.src || (h.src = h.el.attr("href"));
          }
          return (h.type = i || aP.st.type || "inline"), (h.index = j), (h.parsed = !0), (aP.items[j] = h), ar("ElementParse", h), aP.items[j];
      },
      addGroup: function (b, h) {
          var g = function (a) {
              (a.mfpEl = this), aP._openClick(a, b, h);
          };
          h || (h = {});
          var f = "click.magnificPopup";
          (h.mainEl = b), h.items ? ((h.isObj = !0), b.off(f).on(f, g)) : ((h.isObj = !1), h.delegate ? b.off(f).on(f, h.delegate, g) : ((h.items = b), b.off(f).on(f, g)));
      },
      _openClick: function (j, i, h) {
          var b = void 0 !== h.midClick ? h.midClick : aQ.magnificPopup.defaults.midClick;
          if (b || !(2 === j.which || j.ctrlKey || j.metaKey || j.altKey || j.shiftKey)) {
              var a = void 0 !== h.disableOn ? h.disableOn : aQ.magnificPopup.defaults.disableOn;
              if (a) {
                  if (aQ.isFunction(a)) {
                      if (!a.call(aP)) {
                          return !0;
                      }
                  } else {
                      if (av.width() < a) {
                          return !0;
                      }
                  }
              }
              j.type && (j.preventDefault(), aP.isOpen && j.stopPropagation()), (h.el = aQ(j.mfpEl)), h.delegate && (h.items = i.find(h.delegate)), aP.open(h);
          }
      },
      updateStatus: function (b, f) {
          if (aP.preloader) {
              aO !== b && aP.container.removeClass("mfp-s-" + aO), f || "loading" !== b || (f = aP.st.tLoading);
              var c = { status: b, text: f };
              ar("UpdateStatus", c),
                  (b = c.status),
                  (f = c.text),
                  aP.preloader.html(f),
                  aP.preloader.find("a").on("click", function (d) {
                      d.stopImmediatePropagation();
                  }),
                  aP.container.addClass("mfp-s-" + b),
                  (aO = b);
          }
      },
      _checkIfClose: function (f) {
          if (!aQ(f).hasClass(ay)) {
              var b = aP.st.closeOnContentClick,
                  a = aP.st.closeOnBgClick;
              if (b && a) {
                  return !0;
              }
              if (!aP.content || aQ(f).hasClass("mfp-close") || (aP.preloader && f === aP.preloader[0])) {
                  return !0;
              }
              if (f === aP.content[0] || aQ.contains(aP.content[0], f)) {
                  if (b) {
                      return !0;
                  }
              } else {
                  if (a && aQ.contains(document, f)) {
                      return !0;
                  }
              }
              return !1;
          }
      },
      _addClassToMFP: function (b) {
          aP.bgOverlay.addClass(b), aP.wrap.addClass(b);
      },
      _removeClassFromMFP: function (b) {
          this.bgOverlay.removeClass(b), aP.wrap.removeClass(b);
      },
      _hasScrollBar: function (b) {
          return (aP.isIE7 ? aN.height() : document.body.scrollHeight) > (b || av.height());
      },
      _setFocus: function () {
          (aP.st.focus ? aP.content.find(aP.st.focus).eq(0) : aP.wrap).focus();
      },
      _onFocusIn: function (a) {
          return a.target === aP.wrap[0] || aQ.contains(aP.wrap[0], a.target) ? void 0 : (aP._setFocus(), !1);
      },
      _parseMarkup: function (a, h, g) {
          var f;
          g.data && (h = aQ.extend(g.data, h)),
              ar(aF, [a, h, g]),
              aQ.each(h, function (j, i) {
                  if (void 0 === i || i === !1) {
                      return !0;
                  }
                  if (((f = j.split("_")), f.length > 1)) {
                      var e = a.find(aB + "-" + f[0]);
                      if (e.length > 0) {
                          var b = f[1];
                          "replaceWith" === b ? e[0] !== i[0] && e.replaceWith(i) : "img" === b ? (e.is("img") ? e.attr("src", i) : e.replaceWith(aQ("<img>").attr("src", i).attr("class", e.attr("class")))) : e.attr(f[1], i);
                      }
                  } else {
                      a.find(aB + "-" + j).html(i);
                  }
              });
      },
      _getScrollbarSize: function () {
          if (void 0 === aP.scrollbarSize) {
              var b = document.createElement("div");
              (b.style.cssText = "width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;"), document.body.appendChild(b), (aP.scrollbarSize = b.offsetWidth - b.clientWidth), document.body.removeChild(b);
          }
          return aP.scrollbarSize;
      },
  }),
      (aQ.magnificPopup = {
          instance: null,
          proto: ax.prototype,
          modules: [],
          open: function (a, d) {
              return ap(), (a = a ? aQ.extend(!0, {}, a) : {}), (a.isObj = !0), (a.index = d || 0), this.instance.open(a);
          },
          close: function () {
              return aQ.magnificPopup.instance && aQ.magnificPopup.instance.close();
          },
          registerModule: function (a, d) {
              d.options && (aQ.magnificPopup.defaults[a] = d.options), aQ.extend(this.proto, d.proto), this.modules.push(a);
          },
          defaults: {
              disableOn: 0,
              key: null,
              midClick: !1,
              mainClass: "",
              preloader: !0,
              focus: "",
              closeOnContentClick: !1,
              closeOnBgClick: !0,
              closeBtnInside: !0,
              showCloseBtn: !0,
              enableEscapeKey: !0,
              modal: !1,
              alignTop: !1,
              removalDelay: 0,
              prependTo: null,
              fixedContentPos: "auto",
              fixedBgPos: "auto",
              overflowY: "auto",
              closeMarkup: '<button title="%title%" type="button" class="mfp-close">×</button>',
              tClose: "Close (Esc)",
              tLoading: "Loading...",
              autoFocusLast: !0,
          },
      }),
      (aQ.fn.magnificPopup = function (j) {
          ap();
          var i = aQ(this);
          if ("string" == typeof j) {
              if ("open" === j) {
                  var h,
                      b = aw ? i.data("magnificPopup") : i[0].magnificPopup,
                      a = parseInt(arguments[1], 10) || 0;
                  b.items ? (h = b.items[a]) : ((h = i), b.delegate && (h = h.find(b.delegate)), (h = h.eq(a))), aP._openClick({ mfpEl: h }, i, b);
              } else {
                  aP.isOpen && aP[j].apply(aP, Array.prototype.slice.call(arguments, 1));
              }
          } else {
              (j = aQ.extend(!0, {}, j)), aw ? i.data("magnificPopup", j) : (i[0].magnificPopup = j), aP.addGroup(i, j);
          }
          return i;
      });
  var an,
      am,
      al,
      ak = "inline",
      aj = function () {
          al && (am.after(al.addClass(an)).detach(), (al = null));
      };
  aQ.magnificPopup.registerModule(ak, {
      options: { hiddenClass: "hide", markup: "", tNotFound: "Content not found" },
      proto: {
          initInline: function () {
              aP.types.push(ak),
                  au(aJ + "." + ak, function () {
                      aj();
                  });
          },
          getInline: function (j, i) {
              if ((aj(), j.src)) {
                  var h = aP.st.inline,
                      b = aQ(j.src);
                  if (b.length) {
                      var a = b[0].parentNode;
                      a && a.tagName && (am || ((an = h.hiddenClass), (am = at(an)), (an = "mfp-" + an)), (al = b.after(am).detach().removeClass(an))), aP.updateStatus("ready");
                  } else {
                      aP.updateStatus("error", h.tNotFound), (b = aQ("<div>"));
                  }
                  return (j.inlineElement = b), b;
              }
              return aP.updateStatus("ready"), aP._parseMarkup(i, {}, j), i;
          },
      },
  });
  var ai,
      ah = "ajax",
      ag = function () {
          ai && aQ(document.body).removeClass(ai);
      },
      af = function () {
          ag(), aP.req && aP.req.abort();
      };
  aQ.magnificPopup.registerModule(ah, {
      options: { settings: null, cursor: "mfp-ajax-cur", tError: '<a href="%url%">The content</a> could not be loaded.' },
      proto: {
          initAjax: function () {
              aP.types.push(ah), (ai = aP.st.ajax.cursor), au(aJ + "." + ah, af), au("BeforeChange." + ah, af);
          },
          getAjax: function (b) {
              ai && aQ(document.body).addClass(ai), aP.updateStatus("loading");
              var a = aQ.extend(
                  {
                      url: b.src,
                      success: function (j, i, h) {
                          var c = { data: j, xhr: h };
                          ar("ParseAjax", c),
                              aP.appendContent(aQ(c.data), ah),
                              (b.finished = !0),
                              ag(),
                              aP._setFocus(),
                              setTimeout(function () {
                                  aP.wrap.addClass(aA);
                              }, 16),
                              aP.updateStatus("ready"),
                              ar("AjaxContentAdded");
                      },
                      error: function () {
                          ag(), (b.finished = b.loadError = !0), aP.updateStatus("error", aP.st.ajax.tError.replace("%url%", b.src));
                      },
                  },
                  aP.st.ajax.settings
              );
              return (aP.req = aQ.ajax(a)), "";
          },
      },
  });
  var ae,
      ad = function (b) {
          if (b.data && void 0 !== b.data.title) {
              return b.data.title;
          }
          var a = aP.st.image.titleSrc;
          if (a) {
              if (aQ.isFunction(a)) {
                  return a.call(aP, b);
              }
              if (b.el) {
                  return b.el.attr(a) || "";
              }
          }
          return "";
      };
  aQ.magnificPopup.registerModule("image", {
      options: {
          markup:
              '<div class="mfp-figure"><div class="mfp-close"></div><figure><div class="mfp-img"></div><figcaption><div class="mfp-bottom-bar"><div class="mfp-title"></div><div class="mfp-counter"></div></div></figcaption></figure></div>',
          cursor: "mfp-zoom-out-cur",
          titleSrc: "title",
          verticalFit: !0,
          tError: '<a href="%url%">The image</a> could not be loaded.',
      },
      proto: {
          initImage: function () {
              var b = aP.st.image,
                  a = ".image";
              aP.types.push("image"),
                  au(aE + a, function () {
                      "image" === aP.currItem.type && b.cursor && aQ(document.body).addClass(b.cursor);
                  }),
                  au(aJ + a, function () {
                      b.cursor && aQ(document.body).removeClass(b.cursor), av.off("resize" + aB);
                  }),
                  au("Resize" + a, aP.resizeImage),
                  aP.isLowIE && au("AfterChange", aP.resizeImage);
          },
          resizeImage: function () {
              var b = aP.currItem;
              if (b && b.img && aP.st.image.verticalFit) {
                  var d = 0;
                  aP.isLowIE && (d = parseInt(b.img.css("padding-top"), 10) + parseInt(b.img.css("padding-bottom"), 10)), b.img.css("max-height", aP.wH - d);
              }
          },
          _onImageHasSize: function (b) {
              b.img && ((b.hasSize = !0), ae && clearInterval(ae), (b.isCheckingImgSize = !1), ar("ImageHasSize", b), b.imgHidden && (aP.content && aP.content.removeClass("mfp-loading"), (b.imgHidden = !1)));
          },
          findImageSize: function (b) {
              var h = 0,
                  g = b.img[0],
                  f = function (a) {
                      ae && clearInterval(ae),
                          (ae = setInterval(function () {
                              return g.naturalWidth > 0 ? void aP._onImageHasSize(b) : (h > 200 && clearInterval(ae), h++, void (3 === h ? f(10) : 40 === h ? f(50) : 100 === h && f(500)));
                          }, a));
                  };
              f(1);
          },
          getImage: function (p, o) {
              var n = 0,
                  m = function () {
                      p &&
                          (p.img[0].complete
                              ? (p.img.off(".mfploader"), p === aP.currItem && (aP._onImageHasSize(p), aP.updateStatus("ready")), (p.hasSize = !0), (p.loaded = !0), ar("ImageLoadComplete"))
                              : (n++, 200 > n ? setTimeout(m, 100) : l()));
                  },
                  l = function () {
                      p && (p.img.off(".mfploader"), p === aP.currItem && (aP._onImageHasSize(p), aP.updateStatus("error", k.tError.replace("%url%", p.src))), (p.hasSize = !0), (p.loaded = !0), (p.loadError = !0));
                  },
                  k = aP.st.image,
                  b = o.find(".mfp-img");
              if (b.length) {
                  var a = document.createElement("img");
                  (a.className = "mfp-img"),
                      p.el && p.el.find("img").length && (a.alt = p.el.find("img").attr("alt")),
                      (p.img = aQ(a).on("load.mfploader", m).on("error.mfploader", l)),
                      (a.src = p.src),
                      b.is("img") && (p.img = p.img.clone()),
                      (a = p.img[0]),
                      a.naturalWidth > 0 ? (p.hasSize = !0) : a.width || (p.hasSize = !1);
              }
              return (
                  aP._parseMarkup(o, { title: ad(p), img_replaceWith: p.img }, p),
                  aP.resizeImage(),
                  p.hasSize
                      ? (ae && clearInterval(ae), p.loadError ? (o.addClass("mfp-loading"), aP.updateStatus("error", k.tError.replace("%url%", p.src))) : (o.removeClass("mfp-loading"), aP.updateStatus("ready")), o)
                      : (aP.updateStatus("loading"), (p.loading = !0), p.hasSize || ((p.imgHidden = !0), o.addClass("mfp-loading"), aP.findImageSize(p)), o)
              );
          },
      },
  });
  var ac,
      ab = function () {
          return void 0 === ac && (ac = void 0 !== document.createElement("p").style.MozTransform), ac;
      };
  aQ.magnificPopup.registerModule("zoom", {
      options: {
          enabled: !1,
          easing: "ease-in-out",
          duration: 300,
          opener: function (b) {
              return b.is("img") ? b : b.find("img");
          },
      },
      proto: {
          initZoom: function () {
              var b,
                  p = aP.st.zoom,
                  o = ".zoom";
              if (p.enabled && aP.supportsTransition) {
                  var n,
                      m,
                      l = p.duration,
                      i = function (g) {
                          var c = g.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),
                              q = "all " + p.duration / 1000 + "s " + p.easing,
                              k = { position: "fixed", zIndex: 9999, left: 0, top: 0, "-webkit-backface-visibility": "hidden" },
                              j = "transition";
                          return (k["-webkit-" + j] = k["-moz-" + j] = k["-o-" + j] = k[j] = q), c.css(k), c;
                      },
                      h = function () {
                          aP.content.css("visibility", "visible");
                      };
                  au("BuildControls" + o, function () {
                      if (aP._allowZoom()) {
                          if ((clearTimeout(n), aP.content.css("visibility", "hidden"), (b = aP._getItemToZoom()), !b)) {
                              return void h();
                          }
                          (m = i(b)),
                              m.css(aP._getOffset()),
                              aP.wrap.append(m),
                              (n = setTimeout(function () {
                                  m.css(aP._getOffset(!0)),
                                      (n = setTimeout(function () {
                                          h(),
                                              setTimeout(function () {
                                                  m.remove(), (b = m = null), ar("ZoomAnimationEnded");
                                              }, 16);
                                      }, l));
                              }, 16));
                      }
                  }),
                      au(aI + o, function () {
                          if (aP._allowZoom()) {
                              if ((clearTimeout(n), (aP.st.removalDelay = l), !b)) {
                                  if (((b = aP._getItemToZoom()), !b)) {
                                      return;
                                  }
                                  m = i(b);
                              }
                              m.css(aP._getOffset(!0)),
                                  aP.wrap.append(m),
                                  aP.content.css("visibility", "hidden"),
                                  setTimeout(function () {
                                      m.css(aP._getOffset());
                                  }, 16);
                          }
                      }),
                      au(aJ + o, function () {
                          aP._allowZoom() && (h(), m && m.remove(), (b = null));
                      });
              }
          },
          _allowZoom: function () {
              return "image" === aP.currItem.type;
          },
          _getItemToZoom: function () {
              return aP.currItem.hasSize ? aP.currItem.img : !1;
          },
          _getOffset: function (l) {
              var k;
              k = l ? aP.currItem.img : aP.st.zoom.opener(aP.currItem.el || aP.currItem);
              var j = k.offset(),
                  i = parseInt(k.css("padding-top"), 10),
                  b = parseInt(k.css("padding-bottom"), 10);
              j.top -= aQ(window).scrollTop() - i;
              var a = { width: k.width(), height: (aw ? k.innerHeight() : k[0].offsetHeight) - b - i };
              return ab() ? (a["-moz-transform"] = a.transform = "translate(" + j.left + "px," + j.top + "px)") : ((a.left = j.left), (a.top = j.top)), a;
          },
      },
  });
  var aa = "iframe",
      Z = "//about:blank",
      Y = function (b) {
          if (aP.currTemplate[aa]) {
              var d = aP.currTemplate[aa].find("iframe");
              d.length && (b || (d[0].src = Z), aP.isIE8 && d.css("display", b ? "block" : "none"));
          }
      };
  aQ.magnificPopup.registerModule(aa, {
      options: {
          markup: '<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>',
          srcAction: "iframe_src",
          patterns: {
              youtube: { index: "youtube.com", id: "v=", src: "//https://www.youtube.com/embed/%id%?autoplay=1" },
              vimeo: { index: "vimeo.com/", id: "/", src: "//player.vimeo.com/video/%id%?autoplay=1" },
              gmaps: { index: "//maps.google.", src: "%id%&output=embed" },
          },
      },
      proto: {
          initIframe: function () {
              aP.types.push(aa),
                  au("BeforeChange", function (e, d, f) {
                      d !== f && (d === aa ? Y() : f === aa && Y(!0));
                  }),
                  au(aJ + "." + aa, function () {
                      Y();
                  });
          },
          getIframe: function (j, i) {
              var h = j.src,
                  b = aP.st.iframe;
              aQ.each(b.patterns, function () {
                  return h.indexOf(this.index) > -1 ? (this.id && (h = "string" == typeof this.id ? h.substr(h.lastIndexOf(this.id) + this.id.length, h.length) : this.id.call(this, h)), (h = this.src.replace("%id%", h)), !1) : void 0;
              });
              var a = {};
              return b.srcAction && (a[b.srcAction] = h), aP._parseMarkup(i, a, j), aP.updateStatus("ready"), i;
          },
      },
  });
  var X = function (b) {
          var d = aP.items.length;
          return b > d - 1 ? b - d : 0 > b ? d + b : b;
      },
      W = function (e, d, f) {
          return e.replace(/%curr%/gi, d + 1).replace(/%total%/gi, f);
      };
  aQ.magnificPopup.registerModule("gallery", {
      options: {
          enabled: !1,
          arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
          preload: [0, 2],
          navigateByImgClick: !0,
          arrows: !0,
          tPrev: "Previous (Left arrow key)",
          tNext: "Next (Right arrow key)",
          tCounter: "%curr% of %total%",
      },
      proto: {
          initGallery: function () {
              var b = aP.st.gallery,
                  a = ".mfp-gallery";
              return (
                  (aP.direction = !0),
                  b && b.enabled
                      ? ((aL += " mfp-gallery"),
                        au(aE + a, function () {
                            b.navigateByImgClick &&
                                aP.wrap.on("click" + a, ".mfp-img", function () {
                                    return aP.items.length > 1 ? (aP.next(), !1) : void 0;
                                }),
                                aN.on("keydown" + a, function (c) {
                                    37 === c.keyCode ? aP.prev() : 39 === c.keyCode && aP.next();
                                });
                        }),
                        au("UpdateStatus" + a, function (d, e) {
                            e.text && (e.text = W(e.text, aP.currItem.index, aP.items.length));
                        }),
                        au(aF + a, function (c, k, j, i) {
                            var h = aP.items.length;
                            j.counter = h > 1 ? W(b.tCounter, i.index, h) : "";
                        }),
                        au("BuildControls" + a, function () {
                            if (aP.items.length > 1 && b.arrows && !aP.arrowLeft) {
                                var h = b.arrowMarkup,
                                    g = (aP.arrowLeft = aQ(h.replace(/%title%/gi, b.tPrev).replace(/%dir%/gi, "left")).addClass(ay)),
                                    c = (aP.arrowRight = aQ(h.replace(/%title%/gi, b.tNext).replace(/%dir%/gi, "right")).addClass(ay));
                                g.click(function () {
                                    aP.prev();
                                }),
                                    c.click(function () {
                                        aP.next();
                                    }),
                                    aP.container.append(g.add(c));
                            }
                        }),
                        au(aD + a, function () {
                            aP._preloadTimeout && clearTimeout(aP._preloadTimeout),
                                (aP._preloadTimeout = setTimeout(function () {
                                    aP.preloadNearbyImages(), (aP._preloadTimeout = null);
                                }, 16));
                        }),
                        void au(aJ + a, function () {
                            aN.off(a), aP.wrap.off("click" + a), (aP.arrowRight = aP.arrowLeft = null);
                        }))
                      : !1
              );
          },
          next: function () {
              (aP.direction = !0), (aP.index = X(aP.index + 1)), aP.updateItemHTML();
          },
          prev: function () {
              (aP.direction = !1), (aP.index = X(aP.index - 1)), aP.updateItemHTML();
          },
          goTo: function (b) {
              (aP.direction = b >= aP.index), (aP.index = b), aP.updateItemHTML();
          },
          preloadNearbyImages: function () {
              var b,
                  h = aP.st.gallery.preload,
                  g = Math.min(h[0], aP.items.length),
                  f = Math.min(h[1], aP.items.length);
              for (b = 1; b <= (aP.direction ? f : g); b++) {
                  aP._preloadItem(aP.index + b);
              }
              for (b = 1; b <= (aP.direction ? g : f); b++) {
                  aP._preloadItem(aP.index - b);
              }
          },
          _preloadItem: function (b) {
              if (((b = X(b)), !aP.items[b].preloaded)) {
                  var a = aP.items[b];
                  a.parsed || (a = aP.parseEl(b)),
                      ar("LazyLoad", a),
                      "image" === a.type &&
                          (a.img = aQ('<img class="mfp-img" />')
                              .on("load.mfploader", function () {
                                  a.hasSize = !0;
                              })
                              .on("error.mfploader", function () {
                                  (a.hasSize = !0), (a.loadError = !0), ar("LazyLoadError", a);
                              })
                              .attr("src", a.src)),
                      (a.preloaded = !0);
              }
          },
      },
  });
  var V = "retina";
  aQ.magnificPopup.registerModule(V, {
      options: {
          replaceSrc: function (b) {
              return b.src.replace(/\.\w+$/, function (c) {
                  return "@2x" + c;
              });
          },
          ratio: 1,
      },
      proto: {
          initRetina: function () {
              if (window.devicePixelRatio > 1) {
                  var b = aP.st.retina,
                      d = b.ratio;
                  (d = isNaN(d) ? d() : d),
                      d > 1 &&
                          (au("ImageHasSize." + V, function (e, c) {
                              c.img.css({ "max-width": c.img[0].naturalWidth / d, width: "100%" });
                          }),
                          au("ElementParse." + V, function (a, c) {
                              c.src = b.replaceSrc(c, d);
                          }));
              }
          },
      },
  }),
      ap();
});

// nice_select
!(function (e) {
  e.fn.niceSelect = function (t) {
      function s(t) {
          t.after(
              e("<div></div>")
                  .addClass("nice-select")
                  .addClass(t.attr("class") || "")
                  .addClass(t.attr("disabled") ? "disabled" : "")
                  .attr("tabindex", t.attr("disabled") ? null : "0")
                  .html('<span class="current"></span><ul class="list"></ul>')
          );
          var s = t.next(),
              n = t.find("option"),
              i = t.find("option:selected");
          s.find(".current").html(i.data("display") || i.text()),
              n.each(function (t) {
                  var n = e(this),
                      i = n.data("display");
                  s.find("ul").append(
                      e("<li></li>")
                          .attr("data-value", n.val())
                          .attr("data-display", i || null)
                          .addClass("option" + (n.is(":selected") ? " selected" : "") + (n.is(":disabled") ? " disabled" : ""))
                          .html(n.text())
                  );
              });
      }
      if ("string" == typeof t)
          return (
              "update" == t
                  ? this.each(function () {
                        var t = e(this),
                            n = e(this).next(".nice-select"),
                            i = n.hasClass("open");
                        n.length && (n.remove(), s(t), i && t.next().trigger("click"));
                    })
                  : "destroy" == t
                  ? (this.each(function () {
                        var t = e(this),
                            s = e(this).next(".nice-select");
                        s.length && (s.remove(), t.css("display", ""));
                    }),
                    0 == e(".nice-select").length && e(document).off(".nice_select"))
                  : console.log('Method "' + t + '" does not exist.'),
              this
          );
      this.hide(),
          this.each(function () {
              var t = e(this);
              t.next().hasClass("nice-select") || s(t);
          }),
          e(document).off(".nice_select"),
          e(document).on("click.nice_select", ".nice-select", function (t) {
              var s = e(this);
              e(".nice-select").not(s).removeClass("open"), s.toggleClass("open"), s.hasClass("open") ? (s.find(".option"), s.find(".focus").removeClass("focus"), s.find(".selected").addClass("focus")) : s.focus();
          }),
          e(document).on("click.nice_select", function (t) {
              0 === e(t.target).closest(".nice-select").length && e(".nice-select").removeClass("open").find(".option");
          }),
          e(document).on("click.nice_select", ".nice-select .option:not(.disabled)", function (t) {
              var s = e(this),
                  n = s.closest(".nice-select");
              n.find(".selected").removeClass("selected"), s.addClass("selected");
              var i = s.data("display") || s.text();
              n.find(".current").text(i), n.prev("select").val(s.data("value")).trigger("change");
          }),
          e(document).on("keydown.nice_select", ".nice-select", function (t) {
              var s = e(this),
                  n = e(s.find(".focus") || s.find(".list .option.selected"));
              if (32 == t.keyCode || 13 == t.keyCode) return s.hasClass("open") ? n.trigger("click") : s.trigger("click"), !1;
              if (40 == t.keyCode) {
                  if (s.hasClass("open")) {
                      var i = n.nextAll(".option:not(.disabled)").first();
                      i.length > 0 && (s.find(".focus").removeClass("focus"), i.addClass("focus"));
                  } else s.trigger("click");
                  return !1;
              }
              if (38 == t.keyCode) {
                  if (s.hasClass("open")) {
                      var l = n.prevAll(".option:not(.disabled)").first();
                      l.length > 0 && (s.find(".focus").removeClass("focus"), l.addClass("focus"));
                  } else s.trigger("click");
                  return !1;
              }
              if (27 == t.keyCode) s.hasClass("open") && s.trigger("click");
              else if (9 == t.keyCode && s.hasClass("open")) return !1;
          });
      var n = document.createElement("a").style;
      return (n.cssText = "pointer-events:auto"), "auto" !== n.pointerEvents && e("html").addClass("no-csspointerevents"), this;
  };
})(jQuery);

/*
* International Telephone Input v17.0.13
* https://github.com/jackocnr/intl-tel-input.git
* Licensed under the MIT license
*/

!(function (a) {
  "object" == typeof module && module.exports
      ? (module.exports = a(require("jquery")))
      : "function" == typeof define && define.amd
      ? define(["jquery"], function (b) {
            a(b);
        })
      : a(jQuery);
})(function (a, b) {
  "use strict";
  function c(a, b) {
      if (!(a instanceof b)) throw new TypeError("Cannot call a class as a function");
  }
  function d(a, b) {
      for (var c = 0; c < b.length; c++) {
          var d = b[c];
          (d.enumerable = d.enumerable || !1), (d.configurable = !0), "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d);
      }
  }
  function e(a, b, c) {
      return b && d(a.prototype, b), c && d(a, c), a;
  }
  for (
      var f = [
              ["Afghanistan (‫افغانستان‬‎)", "af", "93"],
              ["Albania (Shqipëri)", "al", "355"],
              ["Algeria (‫الجزائر‬‎)", "dz", "213"],
              ["American Samoa", "as", "1", 5, ["684"]],
              ["Andorra", "ad", "376"],
              ["Angola", "ao", "244"],
              ["Anguilla", "ai", "1", 6, ["264"]],
              ["Antigua and Barbuda", "ag", "1", 7, ["268"]],
              ["Argentina", "ar", "54"],
              ["Armenia (Հայաստան)", "am", "374"],
              ["Aruba", "aw", "297"],
              ["Ascension Island", "ac", "247"],
              ["Australia", "au", "61", 0],
              ["Austria (Österreich)", "at", "43"],
              ["Azerbaijan (Azərbaycan)", "az", "994"],
              ["Bahamas", "bs", "1", 8, ["242"]],
              ["Bahrain (‫البحرين‬‎)", "bh", "973"],
              ["Bangladesh (বাংলাদেশ)", "bd", "880"],
              ["Barbados", "bb", "1", 9, ["246"]],
              ["Belarus (Беларусь)", "by", "375"],
              ["Belgium (België)", "be", "32"],
              ["Belize", "bz", "501"],
              ["Benin (Bénin)", "bj", "229"],
              ["Bermuda", "bm", "1", 10, ["441"]],
              ["Bhutan (འབྲུག)", "bt", "975"],
              ["Bolivia", "bo", "591"],
              ["Bosnia and Herzegovina (Босна и Херцеговина)", "ba", "387"],
              ["Botswana", "bw", "267"],
              ["Brazil (Brasil)", "br", "55"],
              ["British Indian Ocean Territory", "io", "246"],
              ["British Virgin Islands", "vg", "1", 11, ["284"]],
              ["Brunei", "bn", "673"],
              ["Bulgaria (България)", "bg", "359"],
              ["Burkina Faso", "bf", "226"],
              ["Burundi (Uburundi)", "bi", "257"],
              ["Cambodia (កម្ពុជា)", "kh", "855"],
              ["Cameroon (Cameroun)", "cm", "237"],
              [
                  "Canada",
                  "ca",
                  "1",
                  1,
                  [
                      "204",
                      "226",
                      "236",
                      "249",
                      "250",
                      "289",
                      "306",
                      "343",
                      "365",
                      "387",
                      "403",
                      "416",
                      "418",
                      "431",
                      "437",
                      "438",
                      "450",
                      "506",
                      "514",
                      "519",
                      "548",
                      "579",
                      "581",
                      "587",
                      "604",
                      "613",
                      "639",
                      "647",
                      "672",
                      "705",
                      "709",
                      "742",
                      "778",
                      "780",
                      "782",
                      "807",
                      "819",
                      "825",
                      "867",
                      "873",
                      "902",
                      "905",
                  ],
              ],
              ["Cape Verde (Kabu Verdi)", "cv", "238"],
              ["Caribbean Netherlands", "bq", "599", 1, ["3", "4", "7"]],
              ["Cayman Islands", "ky", "1", 12, ["345"]],
              ["Central African Republic (République centrafricaine)", "cf", "236"],
              ["Chad (Tchad)", "td", "235"],
              ["Chile", "cl", "56"],
              ["China (中国)", "cn", "86"],
              ["Christmas Island", "cx", "61", 2, ["89164"]],
              ["Cocos (Keeling) Islands", "cc", "61", 1, ["89162"]],
              ["Colombia", "co", "57"],
              ["Comoros (‫جزر القمر‬‎)", "km", "269"],
              ["Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)", "cd", "243"],
              ["Congo (Republic) (Congo-Brazzaville)", "cg", "242"],
              ["Cook Islands", "ck", "682"],
              ["Costa Rica", "cr", "506"],
              ["Côte d’Ivoire", "ci", "225"],
              ["Croatia (Hrvatska)", "hr", "385"],
              ["Cuba", "cu", "53"],
              ["Curaçao", "cw", "599", 0],
              ["Cyprus (Κύπρος)", "cy", "357"],
              ["Czech Republic (Česká republika)", "cz", "420"],
              ["Denmark (Danmark)", "dk", "45"],
              ["Djibouti", "dj", "253"],
              ["Dominica", "dm", "1", 13, ["767"]],
              ["Dominican Republic (República Dominicana)", "do", "1", 2, ["809", "829", "849"]],
              ["Ecuador", "ec", "593"],
              ["Egypt (‫مصر‬‎)", "eg", "20"],
              ["El Salvador", "sv", "503"],
              ["Equatorial Guinea (Guinea Ecuatorial)", "gq", "240"],
              ["Eritrea", "er", "291"],
              ["Estonia (Eesti)", "ee", "372"],
              ["Eswatini", "sz", "268"],
              ["Ethiopia", "et", "251"],
              ["Falkland Islands (Islas Malvinas)", "fk", "500"],
              ["Faroe Islands (Føroyar)", "fo", "298"],
              ["Fiji", "fj", "679"],
              ["Finland (Suomi)", "fi", "358", 0],
              ["France", "fr", "33"],
              ["French Guiana (Guyane française)", "gf", "594"],
              ["French Polynesia (Polynésie française)", "pf", "689"],
              ["Gabon", "ga", "241"],
              ["Gambia", "gm", "220"],
              ["Georgia (საქართველო)", "ge", "995"],
              ["Germany (Deutschland)", "de", "49"],
              ["Ghana (Gaana)", "gh", "233"],
              ["Gibraltar", "gi", "350"],
              ["Greece (Ελλάδα)", "gr", "30"],
              ["Greenland (Kalaallit Nunaat)", "gl", "299"],
              ["Grenada", "gd", "1", 14, ["473"]],
              ["Guadeloupe", "gp", "590", 0],
              ["Guam", "gu", "1", 15, ["671"]],
              ["Guatemala", "gt", "502"],
              ["Guernsey", "gg", "44", 1, ["1481", "7781", "7839", "7911"]],
              ["Guinea (Guinée)", "gn", "224"],
              ["Guinea-Bissau (Guiné Bissau)", "gw", "245"],
              ["Guyana", "gy", "592"],
              ["Haiti", "ht", "509"],
              ["Honduras", "hn", "504"],
              ["Hong Kong (香港)", "hk", "852"],
              ["Hungary (Magyarország)", "hu", "36"],
              ["Iceland (Ísland)", "is", "354"],
              ["India (भारत)", "in", "91"],
              ["Indonesia", "id", "62"],
              ["Iran (‫ایران‬‎)", "ir", "98"],
              ["Iraq (‫العراق‬‎)", "iq", "964"],
              ["Ireland", "ie", "353"],
              ["Isle of Man", "im", "44", 2, ["1624", "74576", "7524", "7924", "7624"]],
              ["Israel (‫ישראל‬‎)", "il", "972"],
              ["Italy (Italia)", "it", "39", 0],
              ["Jamaica", "jm", "1", 4, ["876", "658"]],
              ["Japan (日本)", "jp", "81"],
              ["Jersey", "je", "44", 3, ["1534", "7509", "7700", "7797", "7829", "7937"]],
              ["Jordan (‫الأردن‬‎)", "jo", "962"],
              ["Kazakhstan (Казахстан)", "kz", "7", 1, ["33", "7"]],
              ["Kenya", "ke", "254"],
              ["Kiribati", "ki", "686"],
              ["Kosovo", "xk", "383"],
              ["Kuwait (‫الكويت‬‎)", "kw", "965"],
              ["Kyrgyzstan (Кыргызстан)", "kg", "996"],
              ["Laos (ລາວ)", "la", "856"],
              ["Latvia (Latvija)", "lv", "371"],
              ["Lebanon (‫لبنان‬‎)", "lb", "961"],
              ["Lesotho", "ls", "266"],
              ["Liberia", "lr", "231"],
              ["Libya (‫ليبيا‬‎)", "ly", "218"],
              ["Liechtenstein", "li", "423"],
              ["Lithuania (Lietuva)", "lt", "370"],
              ["Luxembourg", "lu", "352"],
              ["Macau (澳門)", "mo", "853"],
              ["Macedonia (FYROM) (Македонија)", "mk", "389"],
              ["Madagascar (Madagasikara)", "mg", "261"],
              ["Malawi", "mw", "265"],
              ["Malaysia", "my", "60"],
              ["Maldives", "mv", "960"],
              ["Mali", "ml", "223"],
              ["Malta", "mt", "356"],
              ["Marshall Islands", "mh", "692"],
              ["Martinique", "mq", "596"],
              ["Mauritania (‫موريتانيا‬‎)", "mr", "222"],
              ["Mauritius (Moris)", "mu", "230"],
              ["Mayotte", "yt", "262", 1, ["269", "639"]],
              ["Mexico (México)", "mx", "52"],
              ["Micronesia", "fm", "691"],
              ["Moldova (Republica Moldova)", "md", "373"],
              ["Monaco", "mc", "377"],
              ["Mongolia (Монгол)", "mn", "976"],
              ["Montenegro (Crna Gora)", "me", "382"],
              ["Montserrat", "ms", "1", 16, ["664"]],
              ["Morocco (‫المغرب‬‎)", "ma", "212", 0],
              ["Mozambique (Moçambique)", "mz", "258"],
              ["Myanmar (Burma) (မြန်မာ)", "mm", "95"],
              ["Namibia (Namibië)", "na", "264"],
              ["Nauru", "nr", "674"],
              ["Nepal (नेपाल)", "np", "977"],
              ["Netherlands (Nederland)", "nl", "31"],
              ["New Caledonia (Nouvelle-Calédonie)", "nc", "687"],
              ["New Zealand", "nz", "64"],
              ["Nicaragua", "ni", "505"],
              ["Niger (Nijar)", "ne", "227"],
              ["Nigeria", "ng", "234"],
              ["Niue", "nu", "683"],
              ["Norfolk Island", "nf", "672"],
              ["North Korea (조선 민주주의 인민 공화국)", "kp", "850"],
              ["Northern Mariana Islands", "mp", "1", 17, ["670"]],
              ["Norway (Norge)", "no", "47", 0],
              ["Oman (‫عُمان‬‎)", "om", "968"],
              ["Pakistan (‫پاکستان‬‎)", "pk", "92"],
              ["Palau", "pw", "680"],
              ["Palestine (‫فلسطين‬‎)", "ps", "970"],
              ["Panama (Panamá)", "pa", "507"],
              ["Papua New Guinea", "pg", "675"],
              ["Paraguay", "py", "595"],
              ["Peru (Perú)", "pe", "51"],
              ["Philippines", "ph", "63"],
              ["Poland (Polska)", "pl", "48"],
              ["Portugal", "pt", "351"],
              ["Puerto Rico", "pr", "1", 3, ["787", "939"]],
              ["Qatar (‫قطر‬‎)", "qa", "974"],
              ["Réunion (La Réunion)", "re", "262", 0],
              ["Romania (România)", "ro", "40"],
              ["Russia (Россия)", "ru", "7", 0],
              ["Rwanda", "rw", "250"],
              ["Saint Barthélemy", "bl", "590", 1],
              ["Saint Helena", "sh", "290"],
              ["Saint Kitts and Nevis", "kn", "1", 18, ["869"]],
              ["Saint Lucia", "lc", "1", 19, ["758"]],
              ["Saint Martin (Saint-Martin (partie française))", "mf", "590", 2],
              ["Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)", "pm", "508"],
              ["Saint Vincent and the Grenadines", "vc", "1", 20, ["784"]],
              ["Samoa", "ws", "685"],
              ["San Marino", "sm", "378"],
              ["São Tomé and Príncipe (São Tomé e Príncipe)", "st", "239"],
              ["Saudi Arabia (‫المملكة العربية السعودية‬‎)", "sa", "966"],
              ["Senegal (Sénégal)", "sn", "221"],
              ["Serbia (Србија)", "rs", "381"],
              ["Seychelles", "sc", "248"],
              ["Sierra Leone", "sl", "232"],
              ["Singapore", "sg", "65"],
              ["Sint Maarten", "sx", "1", 21, ["721"]],
              ["Slovakia (Slovensko)", "sk", "421"],
              ["Slovenia (Slovenija)", "si", "386"],
              ["Solomon Islands", "sb", "677"],
              ["Somalia (Soomaaliya)", "so", "252"],
              ["South Africa", "za", "27"],
              ["South Korea (대한민국)", "kr", "82"],
              ["South Sudan (‫جنوب السودان‬‎)", "ss", "211"],
              ["Spain (España)", "es", "34"],
              ["Sri Lanka (ශ්‍රී ලංකාව)", "lk", "94"],
              ["Sudan (‫السودان‬‎)", "sd", "249"],
              ["Suriname", "sr", "597"],
              ["Svalbard and Jan Mayen", "sj", "47", 1, ["79"]],
              ["Sweden (Sverige)", "se", "46"],
              ["Switzerland (Schweiz)", "ch", "41"],
              ["Syria (‫سوريا‬‎)", "sy", "963"],
              ["Taiwan (台灣)", "tw", "886"],
              ["Tajikistan", "tj", "992"],
              ["Tanzania", "tz", "255"],
              ["Thailand (ไทย)", "th", "66"],
              ["Timor-Leste", "tl", "670"],
              ["Togo", "tg", "228"],
              ["Tokelau", "tk", "690"],
              ["Tonga", "to", "676"],
              ["Trinidad and Tobago", "tt", "1", 22, ["868"]],
              ["Tunisia (‫تونس‬‎)", "tn", "216"],
              ["Turkey (Türkiye)", "tr", "90"],
              ["Turkmenistan", "tm", "993"],
              ["Turks and Caicos Islands", "tc", "1", 23, ["649"]],
              ["Tuvalu", "tv", "688"],
              ["U.S. Virgin Islands", "vi", "1", 24, ["340"]],
              ["Uganda", "ug", "256"],
              ["Ukraine (Україна)", "ua", "380"],
              ["United Arab Emirates (‫الإمارات العربية المتحدة‬‎)", "ae", "971"],
              ["United Kingdom", "gb", "44", 0],
              ["United States", "us", "1", 0],
              ["Uruguay", "uy", "598"],
              ["Uzbekistan (Oʻzbekiston)", "uz", "998"],
              ["Vanuatu", "vu", "678"],
              ["Vatican City (Città del Vaticano)", "va", "39", 1, ["06698"]],
              ["Venezuela", "ve", "58"],
              ["Vietnam (Việt Nam)", "vn", "84"],
              ["Wallis and Futuna (Wallis-et-Futuna)", "wf", "681"],
              ["Western Sahara (‫الصحراء الغربية‬‎)", "eh", "212", 1, ["5288", "5289"]],
              ["Yemen (‫اليمن‬‎)", "ye", "967"],
              ["Zambia", "zm", "260"],
              ["Zimbabwe", "zw", "263"],
              ["Åland Islands", "ax", "358", 1, ["18"]],
          ],
          g = 0;
      g < f.length;
      g++
  ) {
      var h = f[g];
      f[g] = { name: h[0], iso2: h[1], dialCode: h[2], priority: h[3] || 0, areaCodes: h[4] || null };
  }
  var i = {
      getInstance: function (a) {
          var b = a.getAttribute("data-intl-tel-input-id");
          return window.intlTelInputGlobals.instances[b];
      },
      instances: {},
      documentReady: function () {
          return "complete" === document.readyState;
      },
  };
  "object" == typeof window && (window.intlTelInputGlobals = i);
  var j = 0,
      k = {
          allowDropdown: !0,
          autoHideDialCode: !0,
          autoPlaceholder: "polite",
          customContainer: "",
          customPlaceholder: null,
          dropdownContainer: null,
          excludeCountries: [],
          formatOnDisplay: !0,
          geoIpLookup: null,
          hiddenInput: "",
          initialCountry: "",
          localizedCountries: null,
          nationalMode: !0,
          onlyCountries: [],
          placeholderNumberType: "MOBILE",
          preferredCountries: ["us", "gb"],
          separateDialCode: !1,
          utilsScript: "",
      },
      l = ["800", "822", "833", "844", "855", "866", "877", "880", "881", "882", "883", "884", "885", "886", "887", "888", "889"],
      m = function (a, b) {
          for (var c = Object.keys(a), d = 0; d < c.length; d++) b(c[d], a[c[d]]);
      },
      n = function (a) {
          m(window.intlTelInputGlobals.instances, function (b) {
              window.intlTelInputGlobals.instances[b][a]();
          });
      },
      o = (function () {
          function a(b, d) {
              var e = this;
              c(this, a), (this.id = j++), (this.a = b), (this.b = null), (this.c = null);
              var f = d || {};
              (this.d = {}),
                  m(k, function (a, b) {
                      e.d[a] = f.hasOwnProperty(a) ? f[a] : b;
                  }),
                  (this.e = Boolean(b.getAttribute("placeholder")));
          }
          return (
              e(a, [
                  {
                      key: "_init",
                      value: function () {
                          var a = this;
                          if (
                              (this.d.nationalMode && (this.d.autoHideDialCode = !1),
                              this.d.separateDialCode && (this.d.autoHideDialCode = this.d.nationalMode = !1),
                              (this.g = /Android.+Mobile|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)),
                              this.g && (document.body.classList.add("iti-mobile"), this.d.dropdownContainer || (this.d.dropdownContainer = document.body)),
                              "undefined" != typeof Promise)
                          ) {
                              var b = new Promise(function (b, c) {
                                      (a.h = b), (a.i = c);
                                  }),
                                  c = new Promise(function (b, c) {
                                      (a.i0 = b), (a.i1 = c);
                                  });
                              this.promise = Promise.all([b, c]);
                          } else (this.h = this.i = function () {}), (this.i0 = this.i1 = function () {});
                          (this.s = {}), this._b(), this._f(), this._h(), this._i(), this._i3();
                      },
                  },
                  {
                      key: "_b",
                      value: function () {
                          this._d(), this._d2(), this._e(), this.d.localizedCountries && this._d0(), (this.d.onlyCountries.length || this.d.localizedCountries) && this.p.sort(this._d1);
                      },
                  },
                  {
                      key: "_c",
                      value: function (a, c, d) {
                          c.length > this.countryCodeMaxLen && (this.countryCodeMaxLen = c.length), this.q.hasOwnProperty(c) || (this.q[c] = []);
                          for (var e = 0; e < this.q[c].length; e++) if (this.q[c][e] === a) return;
                          var f = d !== b ? d : this.q[c].length;
                          this.q[c][f] = a;
                      },
                  },
                  {
                      key: "_d",
                      value: function () {
                          if (this.d.onlyCountries.length) {
                              var a = this.d.onlyCountries.map(function (a) {
                                  return a.toLowerCase();
                              });
                              this.p = f.filter(function (b) {
                                  return a.indexOf(b.iso2) > -1;
                              });
                          } else if (this.d.excludeCountries.length) {
                              var b = this.d.excludeCountries.map(function (a) {
                                  return a.toLowerCase();
                              });
                              this.p = f.filter(function (a) {
                                  return -1 === b.indexOf(a.iso2);
                              });
                          } else this.p = f;
                      },
                  },
                  {
                      key: "_d0",
                      value: function () {
                          for (var a = 0; a < this.p.length; a++) {
                              var b = this.p[a].iso2.toLowerCase();
                              this.d.localizedCountries.hasOwnProperty(b) && (this.p[a].name = this.d.localizedCountries[b]);
                          }
                      },
                  },
                  {
                      key: "_d1",
                      value: function (a, b) {
                          return a.name.localeCompare(b.name);
                      },
                  },
                  {
                      key: "_d2",
                      value: function () {
                          (this.countryCodeMaxLen = 0), (this.dialCodes = {}), (this.q = {});
                          for (var a = 0; a < this.p.length; a++) {
                              var b = this.p[a];
                              this.dialCodes[b.dialCode] || (this.dialCodes[b.dialCode] = !0), this._c(b.iso2, b.dialCode, b.priority);
                          }
                          for (var c = 0; c < this.p.length; c++) {
                              var d = this.p[c];
                              if (d.areaCodes)
                                  for (var e = this.q[d.dialCode][0], f = 0; f < d.areaCodes.length; f++) {
                                      for (var g = d.areaCodes[f], h = 1; h < g.length; h++) {
                                          var i = d.dialCode + g.substr(0, h);
                                          this._c(e, i), this._c(d.iso2, i);
                                      }
                                      this._c(d.iso2, d.dialCode + g);
                                  }
                          }
                      },
                  },
                  {
                      key: "_e",
                      value: function () {
                          this.preferredCountries = [];
                          for (var a = 0; a < this.d.preferredCountries.length; a++) {
                              var b = this.d.preferredCountries[a].toLowerCase(),
                                  c = this._y(b, !1, !0);
                              c && this.preferredCountries.push(c);
                          }
                      },
                  },
                  {
                      key: "_e2",
                      value: function (a, b, c) {
                          var d = document.createElement(a);
                          return (
                              b &&
                                  m(b, function (a, b) {
                                      return d.setAttribute(a, b);
                                  }),
                              c && c.appendChild(d),
                              d
                          );
                      },
                  },
                  {
                      key: "_f",
                      value: function () {
                          this.a.hasAttribute("autocomplete") || (this.a.form && this.a.form.hasAttribute("autocomplete")) || this.a.setAttribute("autocomplete", "off");
                          var a = "iti";
                          this.d.allowDropdown && (a += " iti--allow-dropdown"), this.d.separateDialCode && (a += " iti--separate-dial-code"), this.d.customContainer && ((a += " "), (a += this.d.customContainer));
                          var b = this._e2("div", { class: a });
                          if (
                              (this.a.parentNode.insertBefore(b, this.a),
                              (this.k = this._e2("div", { class: "iti__flag-container" }, b)),
                              b.appendChild(this.a),
                              (this.selectedFlag = this._e2(
                                  "div",
                                  { class: "iti__selected-flag", role: "combobox", "aria-controls": "iti-".concat(this.id, "__country-listbox"), "aria-owns": "iti-".concat(this.id, "__country-listbox"), "aria-expanded": "false" },
                                  this.k
                              )),
                              (this.l = this._e2("div", { class: "iti__flag" }, this.selectedFlag)),
                              this.d.separateDialCode && (this.t = this._e2("div", { class: "iti__selected-dial-code" }, this.selectedFlag)),
                              this.d.allowDropdown &&
                                  (this.selectedFlag.setAttribute("tabindex", "0"),
                                  (this.u = this._e2("div", { class: "iti__arrow" }, this.selectedFlag)),
                                  (this.m = this._e2("ul", { class: "iti__country-list iti__hide", id: "iti-".concat(this.id, "__country-listbox"), role: "listbox", "aria-label": "List of countries" })),
                                  this.preferredCountries.length && (this._g(this.preferredCountries, "iti__preferred", !0), this._e2("li", { class: "iti__divider", role: "separator", "aria-disabled": "true" }, this.m)),
                                  this._g(this.p, "iti__standard"),
                                  this.d.dropdownContainer ? ((this.dropdown = this._e2("div", { class: "iti iti--container" })), this.dropdown.appendChild(this.m)) : this.k.appendChild(this.m)),
                              this.d.hiddenInput)
                          ) {
                              var c = this.d.hiddenInput,
                                  d = this.a.getAttribute("name");
                              if (d) {
                                  var e = d.lastIndexOf("[");
                                  -1 !== e && (c = "".concat(d.substr(0, e), "[").concat(c, "]"));
                              }
                              (this.hiddenInput = this._e2("input", { type: "hidden", name: c })), b.appendChild(this.hiddenInput);
                          }
                      },
                  },
                  {
                      key: "_g",
                      value: function (a, b, c) {
                          for (var d = "", e = 0; e < a.length; e++) {
                              var f = a[e],
                                  g = c ? "-preferred" : "";
                              (d += "<li class='iti__country "
                                  .concat(b, "' tabIndex='-1' id='iti-")
                                  .concat(this.id, "__item-")
                                  .concat(f.iso2)
                                  .concat(g, "' role='option' data-dial-code='")
                                  .concat(f.dialCode, "' data-country-code='")
                                  .concat(f.iso2, "' aria-selected='false'>")),
                                  (d += "<div class='iti__flag-box'><div class='iti__flag iti__".concat(f.iso2, "'></div></div>")),
                                  (d += "<span class='iti__country-name'>".concat(f.name, "</span>")),
                                  (d += "<span class='iti__dial-code'>+".concat(f.dialCode, "</span>")),
                                  (d += "</li>");
                          }
                          this.m.insertAdjacentHTML("beforeend", d);
                      },
                  },
                  {
                      key: "_h",
                      value: function () {
                          var a = this.a.getAttribute("value"),
                              b = this.a.value,
                              c = a && "+" === a.charAt(0) && (!b || "+" !== b.charAt(0)),
                              d = c ? a : b,
                              e = this._5(d),
                              f = this._w(d),
                              g = this.d,
                              h = g.initialCountry,
                              i = g.nationalMode,
                              j = g.autoHideDialCode,
                              k = g.separateDialCode;
                          e && !f
                              ? this._v(d)
                              : "auto" !== h &&
                                (h ? this._z(h.toLowerCase()) : e && f ? this._z("us") : ((this.j = this.preferredCountries.length ? this.preferredCountries[0].iso2 : this.p[0].iso2), d || this._z(this.j)),
                                d || i || j || k || (this.a.value = "+".concat(this.s.dialCode))),
                              d && this._u(d);
                      },
                  },
                  {
                      key: "_i",
                      value: function () {
                          this._j(), this.d.autoHideDialCode && this._l(), this.d.allowDropdown && this._i2(), this.hiddenInput && this._i0();
                      },
                  },
                  {
                      key: "_i0",
                      value: function () {
                          var a = this;
                          (this._a14 = function () {
                              a.hiddenInput.value = a.getNumber();
                          }),
                              this.a.form && this.a.form.addEventListener("submit", this._a14);
                      },
                  },
                  {
                      key: "_i1",
                      value: function () {
                          for (var a = this.a; a && "LABEL" !== a.tagName; ) a = a.parentNode;
                          return a;
                      },
                  },
                  {
                      key: "_i2",
                      value: function () {
                          var a = this;
                          this._a9 = function (b) {
                              a.m.classList.contains("iti__hide") ? a.a.focus() : b.preventDefault();
                          };
                          var b = this._i1();
                          b && b.addEventListener("click", this._a9),
                              (this._a10 = function () {
                                  !a.m.classList.contains("iti__hide") || a.a.disabled || a.a.readOnly || a._n();
                              }),
                              this.selectedFlag.addEventListener("click", this._a10),
                              (this._a11 = function (b) {
                                  a.m.classList.contains("iti__hide") && -1 !== ["ArrowUp", "Up", "ArrowDown", "Down", " ", "Enter"].indexOf(b.key) && (b.preventDefault(), b.stopPropagation(), a._n()), "Tab" === b.key && a._2();
                              }),
                              this.k.addEventListener("keydown", this._a11);
                      },
                  },
                  {
                      key: "_i3",
                      value: function () {
                          var a = this;
                          this.d.utilsScript && !window.intlTelInputUtils
                              ? window.intlTelInputGlobals.documentReady()
                                  ? window.intlTelInputGlobals.loadUtils(this.d.utilsScript)
                                  : window.addEventListener("load", function () {
                                        window.intlTelInputGlobals.loadUtils(a.d.utilsScript);
                                    })
                              : this.i0(),
                              "auto" === this.d.initialCountry ? this._i4() : this.h();
                      },
                  },
                  {
                      key: "_i4",
                      value: function () {
                          window.intlTelInputGlobals.autoCountry
                              ? this.handleAutoCountry()
                              : window.intlTelInputGlobals.startedLoadingAutoCountry ||
                                ((window.intlTelInputGlobals.startedLoadingAutoCountry = !0),
                                "function" == typeof this.d.geoIpLookup &&
                                    this.d.geoIpLookup(
                                        function (a) {
                                            (window.intlTelInputGlobals.autoCountry = a.toLowerCase()),
                                                setTimeout(function () {
                                                    return n("handleAutoCountry");
                                                });
                                        },
                                        function () {
                                            return n("rejectAutoCountryPromise");
                                        }
                                    ));
                      },
                  },
                  {
                      key: "_j",
                      value: function () {
                          var a = this;
                          (this._a12 = function () {
                              a._v(a.a.value) && a._m2CountryChange();
                          }),
                              this.a.addEventListener("keyup", this._a12),
                              (this._a13 = function () {
                                  setTimeout(a._a12);
                              }),
                              this.a.addEventListener("cut", this._a13),
                              this.a.addEventListener("paste", this._a13);
                      },
                  },
                  {
                      key: "_j2",
                      value: function (a) {
                          var b = this.a.getAttribute("maxlength");
                          return b && a.length > b ? a.substr(0, b) : a;
                      },
                  },
                  {
                      key: "_l",
                      value: function () {
                          var a = this;
                          (this._a8 = function () {
                              a._l2();
                          }),
                              this.a.form && this.a.form.addEventListener("submit", this._a8),
                              this.a.addEventListener("blur", this._a8);
                      },
                  },
                  {
                      key: "_l2",
                      value: function () {
                          if ("+" === this.a.value.charAt(0)) {
                              var a = this._m(this.a.value);
                              (a && this.s.dialCode !== a) || (this.a.value = "");
                          }
                      },
                  },
                  {
                      key: "_m",
                      value: function (a) {
                          return a.replace(/\D/g, "");
                      },
                  },
                  {
                      key: "_m2",
                      value: function (a) {
                          var b = document.createEvent("Event");
                          b.initEvent(a, !0, !0), this.a.dispatchEvent(b);
                      },
                  },
                  {
                      key: "_n",
                      value: function () {
                          this.m.classList.remove("iti__hide"),
                              this.selectedFlag.setAttribute("aria-expanded", "true"),
                              this._o(),
                              this.b && (this._x(this.b, !1), this._3(this.b, !0)),
                              this._p(),
                              this.u.classList.add("iti__arrow--up"),
                              this._m2("open:countrydropdown");
                      },
                  },
                  {
                      key: "_n2",
                      value: function (a, b, c) {
                          c && !a.classList.contains(b) ? a.classList.add(b) : !c && a.classList.contains(b) && a.classList.remove(b);
                      },
                  },
                  {
                      key: "_o",
                      value: function () {
                          var a = this;
                          if ((this.d.dropdownContainer && this.d.dropdownContainer.appendChild(this.dropdown), !this.g)) {
                              var b = this.a.getBoundingClientRect(),
                                  c = window.pageYOffset || document.documentElement.scrollTop,
                                  d = b.top + c,
                                  e = this.m.offsetHeight,
                                  f = d + this.a.offsetHeight + e < c + window.innerHeight,
                                  g = d - e > c;
                              if ((this._n2(this.m, "iti__country-list--dropup", !f && g), this.d.dropdownContainer)) {
                                  var h = !f && g ? 0 : this.a.offsetHeight;
                                  (this.dropdown.style.top = "".concat(d + h, "px")),
                                      (this.dropdown.style.left = "".concat(b.left + document.body.scrollLeft, "px")),
                                      (this._a4 = function () {
                                          return a._2();
                                      }),
                                      window.addEventListener("scroll", this._a4);
                              }
                          }
                      },
                  },
                  {
                      key: "_o2",
                      value: function (a) {
                          for (var b = a; b && b !== this.m && !b.classList.contains("iti__country"); ) b = b.parentNode;
                          return b === this.m ? null : b;
                      },
                  },
                  {
                      key: "_p",
                      value: function () {
                          var a = this;
                          (this._a0 = function (b) {
                              var c = a._o2(b.target);
                              c && a._x(c, !1);
                          }),
                              this.m.addEventListener("mouseover", this._a0),
                              (this._a1 = function (b) {
                                  var c = a._o2(b.target);
                                  c && a._1(c);
                              }),
                              this.m.addEventListener("click", this._a1);
                          var b = !0;
                          (this._a2 = function () {
                              b || a._2(), (b = !1);
                          }),
                              document.documentElement.addEventListener("click", this._a2);
                          var c = "",
                              d = null;
                          (this._a3 = function (b) {
                              b.preventDefault(),
                                  "ArrowUp" === b.key || "Up" === b.key || "ArrowDown" === b.key || "Down" === b.key
                                      ? a._q(b.key)
                                      : "Enter" === b.key
                                      ? a._r()
                                      : "Escape" === b.key
                                      ? a._2()
                                      : /^[a-zA-ZÀ-ÿа-яА-Я ]$/.test(b.key) &&
                                        (d && clearTimeout(d),
                                        (c += b.key.toLowerCase()),
                                        a._s(c),
                                        (d = setTimeout(function () {
                                            c = "";
                                        }, 1e3)));
                          }),
                              document.addEventListener("keydown", this._a3);
                      },
                  },
                  {
                      key: "_q",
                      value: function (a) {
                          var b = "ArrowUp" === a || "Up" === a ? this.c.previousElementSibling : this.c.nextElementSibling;
                          b && (b.classList.contains("iti__divider") && (b = "ArrowUp" === a || "Up" === a ? b.previousElementSibling : b.nextElementSibling), this._x(b, !0));
                      },
                  },
                  {
                      key: "_r",
                      value: function () {
                          this.c && this._1(this.c);
                      },
                  },
                  {
                      key: "_s",
                      value: function (a) {
                          for (var b = 0; b < this.p.length; b++)
                              if (this._t(this.p[b].name, a)) {
                                  var c = this.m.querySelector("#iti-".concat(this.id, "__item-").concat(this.p[b].iso2));
                                  this._x(c, !1), this._3(c, !0);
                                  break;
                              }
                      },
                  },
                  {
                      key: "_t",
                      value: function (a, b) {
                          return a.substr(0, b.length).toLowerCase() === b;
                      },
                  },
                  {
                      key: "_u",
                      value: function (a) {
                          var b = a;
                          if (this.d.formatOnDisplay && window.intlTelInputUtils && this.s) {
                              var c = !this.d.separateDialCode && (this.d.nationalMode || "+" !== b.charAt(0)),
                                  d = intlTelInputUtils.numberFormat,
                                  e = d.NATIONAL,
                                  f = d.INTERNATIONAL,
                                  g = c ? e : f;
                              b = intlTelInputUtils.formatNumber(b, this.s.iso2, g);
                          }
                          (b = this._7(b)), (this.a.value = b);
                      },
                  },
                  {
                      key: "_v",
                      value: function (a) {
                          var b = a,
                              c = this.s.dialCode,
                              d = "1" === c;
                          b && this.d.nationalMode && d && "+" !== b.charAt(0) && ("1" !== b.charAt(0) && (b = "1".concat(b)), (b = "+".concat(b))), this.d.separateDialCode && c && "+" !== b.charAt(0) && (b = "+".concat(c).concat(b));
                          var e = this._5(b, !0),
                              f = this._m(b),
                              g = null;
                          if (e) {
                              var h = this.q[this._m(e)],
                                  i = -1 !== h.indexOf(this.s.iso2) && f.length <= e.length - 1;
                              if (!("1" === c && this._w(f)) && !i)
                                  for (var j = 0; j < h.length; j++)
                                      if (h[j]) {
                                          g = h[j];
                                          break;
                                      }
                          } else "+" === b.charAt(0) && f.length ? (g = "") : (b && "+" !== b) || (g = this.j);
                          return null !== g && this._z(g);
                      },
                  },
                  {
                      key: "_w",
                      value: function (a) {
                          var b = this._m(a);
                          if ("1" === b.charAt(0)) {
                              var c = b.substr(1, 3);
                              return -1 !== l.indexOf(c);
                          }
                          return !1;
                      },
                  },
                  {
                      key: "_x",
                      value: function (a, b) {
                          var c = this.c;
                          c && c.classList.remove("iti__highlight"), (this.c = a), this.c.classList.add("iti__highlight"), b && this.c.focus();
                      },
                  },
                  {
                      key: "_y",
                      value: function (a, b, c) {
                          for (var d = b ? f : this.p, e = 0; e < d.length; e++) if (d[e].iso2 === a) return d[e];
                          if (c) return null;
                          throw new Error("No country data for '".concat(a, "'"));
                      },
                  },
                  {
                      key: "_z",
                      value: function (a) {
                          var b = this.s.iso2 ? this.s : {};
                          (this.s = a ? this._y(a, !1, !1) : {}), this.s.iso2 && (this.j = this.s.iso2), this.l.setAttribute("class", "iti__flag iti__".concat(a));
                          var c = a ? "".concat(this.s.name, ": +").concat(this.s.dialCode) : "Unknown";
                          if ((this.selectedFlag.setAttribute("title", c), this.d.separateDialCode)) {
                              var d = this.s.dialCode ? "+".concat(this.s.dialCode) : "";
                              this.t.innerHTML = d;
                              var e = this.selectedFlag.offsetWidth || this._z2();
                              this.a.style.paddingLeft = "".concat(e + 6, "px");
                          }
                          if ((this._0(), this.d.allowDropdown)) {
                              var f = this.b;
                              if ((f && (f.classList.remove("iti__active"), f.setAttribute("aria-selected", "false")), a)) {
                                  var g = this.m.querySelector("#iti-".concat(this.id, "__item-").concat(a, "-preferred")) || this.m.querySelector("#iti-".concat(this.id, "__item-").concat(a));
                                  g.setAttribute("aria-selected", "true"), g.classList.add("iti__active"), (this.b = g), this.selectedFlag.setAttribute("aria-activedescendant", g.getAttribute("id"));
                              }
                          }
                          return b.iso2 !== a;
                      },
                  },
                  {
                      key: "_z2",
                      value: function () {
                          var a = this.a.parentNode.cloneNode();
                          (a.style.visibility = "hidden"), document.body.appendChild(a);
                          var b = this.k.cloneNode();
                          a.appendChild(b);
                          var c = this.selectedFlag.cloneNode(!0);
                          b.appendChild(c);
                          var d = c.offsetWidth;
                          return a.parentNode.removeChild(a), d;
                      },
                  },
                  {
                      key: "_0",
                      value: function () {
                          var a = "aggressive" === this.d.autoPlaceholder || (!this.e && "polite" === this.d.autoPlaceholder);
                          if (window.intlTelInputUtils && a) {
                              var b = intlTelInputUtils.numberType[this.d.placeholderNumberType],
                                  c = this.s.iso2 ? intlTelInputUtils.getExampleNumber(this.s.iso2, this.d.nationalMode, b) : "";
                              (c = this._7(c)), "function" == typeof this.d.customPlaceholder && (c = this.d.customPlaceholder(c, this.s)), this.a.setAttribute("placeholder", c);
                          }
                      },
                  },
                  {
                      key: "_1",
                      value: function (a) {
                          var b = this._z(a.getAttribute("data-country-code"));
                          this._2(), this._4(a.getAttribute("data-dial-code"), !0), this.a.focus();
                          var c = this.a.value.length;
                          this.a.setSelectionRange(c, c), b && this._m2CountryChange();
                      },
                  },
                  {
                      key: "_2",
                      value: function () {
                          this.m.classList.add("iti__hide"),
                              this.selectedFlag.setAttribute("aria-expanded", "false"),
                              this.u.classList.remove("iti__arrow--up"),
                              document.removeEventListener("keydown", this._a3),
                              document.documentElement.removeEventListener("click", this._a2),
                              this.m.removeEventListener("mouseover", this._a0),
                              this.m.removeEventListener("click", this._a1),
                              this.d.dropdownContainer && (this.g || window.removeEventListener("scroll", this._a4), this.dropdown.parentNode && this.dropdown.parentNode.removeChild(this.dropdown)),
                              this._m2("close:countrydropdown");
                      },
                  },
                  {
                      key: "_3",
                      value: function (a, b) {
                          var c = this.m,
                              d = window.pageYOffset || document.documentElement.scrollTop,
                              e = c.offsetHeight,
                              f = c.getBoundingClientRect().top + d,
                              g = f + e,
                              h = a.offsetHeight,
                              i = a.getBoundingClientRect().top + d,
                              j = i + h,
                              k = i - f + c.scrollTop,
                              l = e / 2 - h / 2;
                          if (i < f) b && (k -= l), (c.scrollTop = k);
                          else if (j > g) {
                              b && (k += l);
                              var m = e - h;
                              c.scrollTop = k - m;
                          }
                      },
                  },
                  {
                      key: "_4",
                      value: function (a, b) {
                          var c,
                              d = this.a.value,
                              e = "+".concat(a);
                          if ("+" === d.charAt(0)) {
                              var f = this._5(d);
                              c = f ? d.replace(f, e) : e;
                          } else {
                              if (this.d.nationalMode || this.d.separateDialCode) return;
                              if (d) c = e + d;
                              else {
                                  if (!b && this.d.autoHideDialCode) return;
                                  c = e;
                              }
                          }
                          this.a.value = c;
                      },
                  },
                  {
                      key: "_5",
                      value: function (a, b) {
                          var c = "";
                          if ("+" === a.charAt(0))
                              for (var d = "", e = 0; e < a.length; e++) {
                                  var f = a.charAt(e);
                                  if (!isNaN(parseInt(f, 10))) {
                                      if (((d += f), b)) this.q[d] && (c = a.substr(0, e + 1));
                                      else if (this.dialCodes[d]) {
                                          c = a.substr(0, e + 1);
                                          break;
                                      }
                                      if (d.length === this.countryCodeMaxLen) break;
                                  }
                              }
                          return c;
                      },
                  },
                  {
                      key: "_6",
                      value: function () {
                          var a = this.a.value.trim(),
                              b = this.s.dialCode,
                              c = this._m(a);
                          return (this.d.separateDialCode && "+" !== a.charAt(0) && b && c ? "+".concat(b) : "") + a;
                      },
                  },
                  {
                      key: "_7",
                      value: function (a) {
                          var b = a;
                          if (this.d.separateDialCode) {
                              var c = this._5(b);
                              if (c) {
                                  c = "+".concat(this.s.dialCode);
                                  var d = " " === b[c.length] || "-" === b[c.length] ? c.length + 1 : c.length;
                                  b = b.substr(d);
                              }
                          }
                          return this._j2(b);
                      },
                  },
                  {
                      key: "_m2CountryChange",
                      value: function () {
                          this._m2("countrychange");
                      },
                  },
                  {
                      key: "handleAutoCountry",
                      value: function () {
                          "auto" === this.d.initialCountry && ((this.j = window.intlTelInputGlobals.autoCountry), this.a.value || this.setCountry(this.j), this.h());
                      },
                  },
                  {
                      key: "handleUtils",
                      value: function () {
                          window.intlTelInputUtils && (this.a.value && this._u(this.a.value), this._0()), this.i0();
                      },
                  },
                  {
                      key: "destroy",
                      value: function () {
                          var a = this.a.form;
                          if (this.d.allowDropdown) {
                              this._2(), this.selectedFlag.removeEventListener("click", this._a10), this.k.removeEventListener("keydown", this._a11);
                              var b = this._i1();
                              b && b.removeEventListener("click", this._a9);
                          }
                          this.hiddenInput && a && a.removeEventListener("submit", this._a14),
                              this.d.autoHideDialCode && (a && a.removeEventListener("submit", this._a8), this.a.removeEventListener("blur", this._a8)),
                              this.a.removeEventListener("keyup", this._a12),
                              this.a.removeEventListener("cut", this._a13),
                              this.a.removeEventListener("paste", this._a13),
                              this.a.removeAttribute("data-intl-tel-input-id");
                          var c = this.a.parentNode;
                          c.parentNode.insertBefore(this.a, c), c.parentNode.removeChild(c), delete window.intlTelInputGlobals.instances[this.id];
                      },
                  },
                  {
                      key: "getExtension",
                      value: function () {
                          return window.intlTelInputUtils ? intlTelInputUtils.getExtension(this._6(), this.s.iso2) : "";
                      },
                  },
                  {
                      key: "getNumber",
                      value: function (a) {
                          if (window.intlTelInputUtils) {
                              var b = this.s.iso2;
                              return intlTelInputUtils.formatNumber(this._6(), b, a);
                          }
                          return "";
                      },
                  },
                  {
                      key: "getNumberType",
                      value: function () {
                          return window.intlTelInputUtils ? intlTelInputUtils.getNumberType(this._6(), this.s.iso2) : -99;
                      },
                  },
                  {
                      key: "getSelectedCountryData",
                      value: function () {
                          return this.s;
                      },
                  },
                  {
                      key: "getValidationError",
                      value: function () {
                          if (window.intlTelInputUtils) {
                              var a = this.s.iso2;
                              return intlTelInputUtils.getValidationError(this._6(), a);
                          }
                          return -99;
                      },
                  },
                  {
                      key: "isValidNumber",
                      value: function () {
                          var a = this._6().trim(),
                              b = this.d.nationalMode ? this.s.iso2 : "";
                          return window.intlTelInputUtils ? intlTelInputUtils.isValidNumber(a, b) : null;
                      },
                  },
                  {
                      key: "setCountry",
                      value: function (a) {
                          var b = a.toLowerCase();
                          this.l.classList.contains("iti__".concat(b)) || (this._z(b), this._4(this.s.dialCode, !1), this._m2CountryChange());
                      },
                  },
                  {
                      key: "setNumber",
                      value: function (a) {
                          var b = this._v(a);
                          this._u(a), b && this._m2CountryChange();
                      },
                  },
                  {
                      key: "setPlaceholderNumberType",
                      value: function (a) {
                          (this.d.placeholderNumberType = a), this._0();
                      },
                  },
              ]),
              a
          );
      })();
  i.getCountryData = function () {
      return f;
  };
  var p = function (a, b, c) {
      var d = document.createElement("script");
      (d.onload = function () {
          n("handleUtils"), b && b();
      }),
          (d.onerror = function () {
              n("rejectUtilsScriptPromise"), c && c();
          }),
          (d.className = "iti-load-utils"),
          (d.async = !0),
          (d.src = a),
          document.body.appendChild(d);
  };
  (i.loadUtils = function (a) {
      if (!window.intlTelInputUtils && !window.intlTelInputGlobals.startedLoadingUtilsScript) {
          if (((window.intlTelInputGlobals.startedLoadingUtilsScript = !0), "undefined" != typeof Promise))
              return new Promise(function (b, c) {
                  return p(a, b, c);
              });
          p(a);
      }
      return null;
  }),
      (i.defaults = k),
      (i.version = "17.0.13");
  a.fn.intlTelInput = function (c) {
      var d = arguments;
      if (c === b || "object" == typeof c)
          return this.each(function () {
              if (!a.data(this, "plugin_intlTelInput")) {
                  var b = new o(this, c);
                  b._init(), (window.intlTelInputGlobals.instances[b.id] = b), a.data(this, "plugin_intlTelInput", b);
              }
          });
      if ("string" == typeof c && "_" !== c[0]) {
          var e;
          return (
              this.each(function () {
                  var b = a.data(this, "plugin_intlTelInput");
                  b instanceof o && "function" == typeof b[c] && (e = b[c].apply(b, Array.prototype.slice.call(d, 1))), "destroy" === c && a.data(this, "plugin_intlTelInput", null);
              }),
              e !== b ? e : this
          );
      }
  };
});

/**
* Language dropdown flags for Materialize and Bootstrap framework.
*
* @author     Josantonius - hello@josantonius.com
* @copyright  Copyright (c) 2017
* @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
* @link       https://github.com/josantonius/js-language-dropdown
* @since      1.0.0
*/
class JLang {
  constructor(o) {
      if (typeof o.id === "undefined") {
          o.id = "languages";
      }
      if (typeof o.framework === "undefined") {
          o.framework = "materialize";
      }
      if (typeof o.cookieExp === "undefined") {
          o.cookieExp = 30;
      }
      if (typeof o.cookieLangCode === "undefined") {
          o.cookieLangCode = "lcode";
      }
      if (typeof o.cookieLangName === "undefined") {
          o.cookieLangName = "lname";
      }
      if (typeof o.abbreviation === "undefined") {
          o.cookieLangName = !0;
      }
      if (typeof o.reload === "undefined") {
          o.reload = !0;
      }
      if (typeof o.alignment === "undefined") {
          o.alignment = "left";
      }
      if (typeof o.hover === "undefined") {
          o.hover = !0;
      }
      this.dropdownID = o.id;
      this.framework = o.framework;
      this.cookieExp = o.cookieExp;
      this.cookieLangCode = o.cookieLangCode;
      this.cookieLangName = o.cookieLangName;
      this.abbreviation = o.abbreviation;
      this.reloadPage = o.reload;
      this.alignment = o.alignment;
      this.hover = o.hover;
      this.init();
  }
  setCookie(cname, cvalue) {
      var d = new Date();
      d.setTime(d.getTime() + this.cookieExp * 24 * 60 * 60 * 1000);
      var expires = "expires=" + d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  getCookie(cname) {
      var name = cname + "=";
      var ca = document.cookie.split(";");
      for (var i = 0; i < ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == " ") {
              c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
              return c.substring(name.length, c.length);
          }
      }
      return "";
  }
  checkCookie(cname, cvalue) {
      var exists = this.getCookie(cname);
      if (exists === "") {
          this.setCookie(cname, cvalue, this.cookieExp);
          return cvalue;
      }
      return exists;
  }
  init() {
      if (this.getLanguages()) {
          this.loadLanguages();
          if (this.framework === "materialize") {
              this.dropdownInitialization();
          }
      }
  }
  getLanguages() { 
      this.codes = [];
      this.languages = [];
      this.labels = [];
      var jlang = document.getElementById("JLang");
      var elems = jlang.querySelectorAll("[data-lang-code]");
      var count = elems.length;
      if (count) {
          for (var i = 0; i < count; i++) {
              if (typeof elems[i] === "undefined") {
                  break;
              }
              var languageLebel = elems[i].innerHTML;
              var languageName = elems[i].getAttribute("data-lang-name");
              var languageImage = elems[i].getAttribute("data-src");
              var languageCode = elems[i].getAttribute("data-lang-code");
              if (i == 0) {
                  this.defaultLang = languageName
                  this.defaultCode = languageCode;
              }
              
              this.languages[languageName] = languageImage;
              this.codes[languageName] = languageCode;
              this.labels[languageName] =languageLebel;
              elems[i].remove;
          }
          return count;
      }
      return !1;
  }
  loadLanguages() {
      this.actualLanguage = this.getActualLanguage();
      this.setContent();
      this.appendLanguagesList();
      this.setNewLanguage();
  }
  getActualLanguage() {
      this.checkCookie(this.cookieLangCode, this.defaultCode, this.cookieExp);
      return this.checkCookie(this.cookieLangName, this.defaultLang, this.cookieExp);
  }
  setContent() {
      if (this.framework === "bootstrap3") {
          var abbreviation = '<span id="lanNavSel"></span>' + '<span class="caret"></span>';
          var content = '<ul class="nav navbar-nav navbar-right">' + '<li class="dropdown">';
          var data = 'class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"';
          var openTag = "<li>";
          var closeTag = "</li>";
          var startContent = '<ul id="languages-list" class="dropdown-menu">';
          var endContent = "</ul></li></ul>";
      } else if (this.framework === "bootstrap4") {
          var abbreviation = '<span id="lanNavSel"></span>' + '<span class="caret"></span>';
          var content = '<ul class="navbar-nav">' + '<li class="nav-item dropdown">';
          var data = 'class="nav-link dropdown-toggle" href="#!" id="languages-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"';
          var openTag = "";
          var closeTag = "";
          var startContent = '<div id="languages-list" class="dropdown-menu" aria-labelledby="dropdown-list">';
          var endContent = "</div></li></ul>";
      } else if (this.framework === "materialize") {
          var abbreviation = '<span id="lanNavSel" class="white-text"></span>' + '<i class="material-icons white-text right">arrow_drop_down</i>';
          var content = "";
          var data = 'class="dropdown-button btn-flat" data-activates="languages-list"';
          var openTag = "<li>";
          var closeTag = "</li>";
          var startContent = '<ul id="languages-list" class="dropdown-content">';
          var endContent = "</ul>";
      }
      abbreviation = this.abbreviation ? abbreviation : "";
      this.content = content + '<a href="#" id="' + this.dropdownID + '"' + data + ">" + '<img id="imgNavSel" src="" alt="" class="flag-icon">' + abbreviation + "</a>" + startContent;
      var key;
      var languages = this.languages;
      var labels = this.labels;
      var languagesList = "";
      for (key in languages) {
          if (languages.hasOwnProperty(key)) {
              var image = languages[key];
              var label = labels[key];
              languagesList +=
                  openTag +
                  '<a id="nav' +
                  key +
                  '" href="#" class="language dropdown-item">' +
                  '<img id="imgNav' +
                  key +
                  '" src="' +
                  image +
                  '" alt="' +
                  key +
                  '" class="flag-icon">' +
                  '<span id="lanNav' +
                  key +
                  '"> ' +
                  label +
                  "</span>" +
                  "</a>" +
                  closeTag;
          }
      }
      this.languagesList = languagesList + endContent;
  }
  appendLanguagesList() {
      var JLang = document.getElementById("JLang");
      JLang.innerHTML = this.content;
      var languagesList = document.getElementById("languages-list");
      languagesList.innerHTML = this.languagesList;
      var language = this.actualLanguage.toUpperCase();
      if (this.abbreviation) {
          var lanNavSel = document.getElementById("lanNavSel");
          lanNavSel.innerHTML = " " + language.substring(0, 20);
      }
      var imgNavSel = document.getElementById("imgNavSel");
      var image = this.languages[this.actualLanguage];
      imgNavSel.setAttribute("src", image);
  }
  setNewLanguage() {
      var elems = document.getElementsByClassName("language");
      var count = elems.length;
      var obj = this;
      for (var i = count; i--; ) {
          elems[i].addEventListener(
              "click",
              function () {
                  var currentId = this.getAttribute("id");
                  if (~currentId.indexOf("nav")) {
                      var type = "Nav";
                      var language = currentId.replace("nav", "");
                  }
                  var img = document.getElementById("img" + type + "Sel");
                  var imgLink = this.childNodes[0];
                  var imgLink = imgLink.getAttribute("src");
                  img.setAttribute("src", imgLink);
                  var upperLang = language.toUpperCase();
                  if (obj.abbreviation) {
                      var lanNavSel = document.getElementById("lanNavSel");
                      lanNavSel.innerHTML = " " + upperLang.substring(0, 20);
                      lanNavSel.setAttribute("alt", language);
                  }
                  obj.setCookie(obj.cookieLangName, language, obj.cookieExp);
                  obj.setCookie(obj.cookieLangCode, obj.codes[language], obj.cookieExp);
                  if (obj.reloadPage) {
                      location.reload();
                  }
              },
              !1
          );
      }
  }
  dropdownInitialization() {
      $("#" + this.dropdownID).dropdown({ inDuration: 300, outDuration: 225, constrainWidth: !1, hover: this.hover, gutter: 0, belowOrigin: !1, alignment: this.alignment, stopPropagation: !1 });
  }
}

/**
* simplebar - v6.2.5
* Scrollbars, simpler.
* https://grsmto.github.io/simplebar/
*
* Made by Adrien Denat from a fork by Jonathan Nicol
* Under MIT License
*/

var SimpleBar = (function () {
  "use strict";
  var e = function (t, i) {
      return (
          (e =
              Object.setPrototypeOf ||
              ({ __proto__: [] } instanceof Array &&
                  function (e, t) {
                      e.__proto__ = t;
                  }) ||
              function (e, t) {
                  for (var i in t) Object.prototype.hasOwnProperty.call(t, i) && (e[i] = t[i]);
              }),
          e(t, i)
      );
  };
  var t = !("undefined" == typeof window || !window.document || !window.document.createElement),
      i = "object" == typeof global && global && global.Object === Object && global,
      s = "object" == typeof self && self && self.Object === Object && self,
      r = i || s || Function("return this")(),
      l = r.Symbol,
      o = Object.prototype,
      n = o.hasOwnProperty,
      a = o.toString,
      c = l ? l.toStringTag : void 0;
  var h = Object.prototype.toString;
  var u = l ? l.toStringTag : void 0;
  function d(e) {
      return null == e
          ? void 0 === e
              ? "[object Undefined]"
              : "[object Null]"
          : u && u in Object(e)
          ? (function (e) {
                var t = n.call(e, c),
                    i = e[c];
                try {
                    e[c] = void 0;
                    var s = !0;
                } catch (e) {}
                var r = a.call(e);
                return s && (t ? (e[c] = i) : delete e[c]), r;
            })(e)
          : (function (e) {
                return h.call(e);
            })(e);
  }
  var p = /\s/;
  var v = /^\s+/;
  function f(e) {
      return e
          ? e
                .slice(
                    0,
                    (function (e) {
                        for (var t = e.length; t-- && p.test(e.charAt(t)); );
                        return t;
                    })(e) + 1
                )
                .replace(v, "")
          : e;
  }
  function m(e) {
      var t = typeof e;
      return null != e && ("object" == t || "function" == t);
  }
  var b = /^[-+]0x[0-9a-f]+$/i,
      g = /^0b[01]+$/i,
      x = /^0o[0-7]+$/i,
      y = parseInt;
  function E(e) {
      if ("number" == typeof e) return e;
      if (
          (function (e) {
              return (
                  "symbol" == typeof e ||
                  ((function (e) {
                      return null != e && "object" == typeof e;
                  })(e) &&
                      "[object Symbol]" == d(e))
              );
          })(e)
      )
          return NaN;
      if (m(e)) {
          var t = "function" == typeof e.valueOf ? e.valueOf() : e;
          e = m(t) ? t + "" : t;
      }
      if ("string" != typeof e) return 0 === e ? e : +e;
      e = f(e);
      var i = g.test(e);
      return i || x.test(e) ? y(e.slice(2), i ? 2 : 8) : b.test(e) ? NaN : +e;
  }
  var O = function () {
          return r.Date.now();
      },
      w = Math.max,
      S = Math.min;
  function A(e, t, i) {
      var s,
          r,
          l,
          o,
          n,
          a,
          c = 0,
          h = !1,
          u = !1,
          d = !0;
      if ("function" != typeof e) throw new TypeError("Expected a function");
      function p(t) {
          var i = s,
              l = r;
          return (s = r = void 0), (c = t), (o = e.apply(l, i));
      }
      function v(e) {
          return (c = e), (n = setTimeout(b, t)), h ? p(e) : o;
      }
      function f(e) {
          var i = e - a;
          return void 0 === a || i >= t || i < 0 || (u && e - c >= l);
      }
      function b() {
          var e = O();
          if (f(e)) return g(e);
          n = setTimeout(
              b,
              (function (e) {
                  var i = t - (e - a);
                  return u ? S(i, l - (e - c)) : i;
              })(e)
          );
      }
      function g(e) {
          return (n = void 0), d && s ? p(e) : ((s = r = void 0), o);
      }
      function x() {
          var e = O(),
              i = f(e);
          if (((s = arguments), (r = this), (a = e), i)) {
              if (void 0 === n) return v(a);
              if (u) return clearTimeout(n), (n = setTimeout(b, t)), p(a);
          }
          return void 0 === n && (n = setTimeout(b, t)), o;
      }
      return (
          (t = E(t) || 0),
          m(i) && ((h = !!i.leading), (l = (u = "maxWait" in i) ? w(E(i.maxWait) || 0, t) : l), (d = "trailing" in i ? !!i.trailing : d)),
          (x.cancel = function () {
              void 0 !== n && clearTimeout(n), (c = 0), (s = a = r = n = void 0);
          }),
          (x.flush = function () {
              return void 0 === n ? o : g(O());
          }),
          x
      );
  }
  var k = function () {
          return (
              (k =
                  Object.assign ||
                  function (e) {
                      for (var t, i = 1, s = arguments.length; i < s; i++) for (var r in (t = arguments[i])) Object.prototype.hasOwnProperty.call(t, r) && (e[r] = t[r]);
                      return e;
                  }),
              k.apply(this, arguments)
          );
      },
      W = null,
      M = null;
  function N() {
      if (null === W) {
          if ("undefined" == typeof document) return (W = 0);
          var e = document.body,
              t = document.createElement("div");
          t.classList.add("simplebar-hide-scrollbar"), e.appendChild(t);
          var i = t.getBoundingClientRect().right;
          e.removeChild(t), (W = i);
      }
      return W;
  }
  function L(e) {
      return e && e.ownerDocument && e.ownerDocument.defaultView ? e.ownerDocument.defaultView : window;
  }
  function z(e) {
      return e && e.ownerDocument ? e.ownerDocument : document;
  }
  t &&
      window.addEventListener("resize", function () {
          M !== window.devicePixelRatio && ((M = window.devicePixelRatio), (W = null));
      });
  var C = function (e) {
      return Array.prototype.reduce.call(
          e,
          function (e, t) {
              var i = t.name.match(/data-simplebar-(.+)/);
              if (i) {
                  var s = i[1].replace(/\W+(.)/g, function (e, t) {
                      return t.toUpperCase();
                  });
                  switch (t.value) {
                      case "true":
                          e[s] = !0;
                          break;
                      case "false":
                          e[s] = !1;
                          break;
                      case void 0:
                          e[s] = !0;
                          break;
                      default:
                          e[s] = t.value;
                  }
              }
              return e;
          },
          {}
      );
  };
  function T(e, t) {
      var i;
      e && (i = e.classList).add.apply(i, t.split(" "));
  }
  function R(e, t) {
      e &&
          t.split(" ").forEach(function (t) {
              e.classList.remove(t);
          });
  }
  function D(e) {
      return ".".concat(e.split(" ").join("."));
  }
  var V = Object.freeze({ __proto__: null, getElementWindow: L, getElementDocument: z, getOptions: C, addClasses: T, removeClasses: R, classNamesToQuery: D }),
      H = L,
      j = z,
      B = C,
      _ = T,
      q = R,
      P = D,
      X = (function () {
          function e(t, i) {
              void 0 === i && (i = {});
              var s = this;
              if (
                  ((this.removePreventClickId = null),
                  (this.minScrollbarWidth = 20),
                  (this.stopScrollDelay = 175),
                  (this.isScrolling = !1),
                  (this.isMouseEntering = !1),
                  (this.scrollXTicking = !1),
                  (this.scrollYTicking = !1),
                  (this.wrapperEl = null),
                  (this.contentWrapperEl = null),
                  (this.contentEl = null),
                  (this.offsetEl = null),
                  (this.maskEl = null),
                  (this.placeholderEl = null),
                  (this.heightAutoObserverWrapperEl = null),
                  (this.heightAutoObserverEl = null),
                  (this.rtlHelpers = null),
                  (this.scrollbarWidth = 0),
                  (this.resizeObserver = null),
                  (this.mutationObserver = null),
                  (this.elStyles = null),
                  (this.isRtl = null),
                  (this.mouseX = 0),
                  (this.mouseY = 0),
                  (this.onMouseMove = function () {}),
                  (this.onWindowResize = function () {}),
                  (this.onStopScrolling = function () {}),
                  (this.onMouseEntered = function () {}),
                  (this.onScroll = function () {
                      var e = H(s.el);
                      s.scrollXTicking || (e.requestAnimationFrame(s.scrollX), (s.scrollXTicking = !0)),
                          s.scrollYTicking || (e.requestAnimationFrame(s.scrollY), (s.scrollYTicking = !0)),
                          s.isScrolling || ((s.isScrolling = !0), _(s.el, s.classNames.scrolling)),
                          s.showScrollbar("x"),
                          s.showScrollbar("y"),
                          s.onStopScrolling();
                  }),
                  (this.scrollX = function () {
                      s.axis.x.isOverflowing && s.positionScrollbar("x"), (s.scrollXTicking = !1);
                  }),
                  (this.scrollY = function () {
                      s.axis.y.isOverflowing && s.positionScrollbar("y"), (s.scrollYTicking = !1);
                  }),
                  (this._onStopScrolling = function () {
                      q(s.el, s.classNames.scrolling), s.options.autoHide && (s.hideScrollbar("x"), s.hideScrollbar("y")), (s.isScrolling = !1);
                  }),
                  (this.onMouseEnter = function () {
                      s.isMouseEntering || (_(s.el, s.classNames.mouseEntered), s.showScrollbar("x"), s.showScrollbar("y"), (s.isMouseEntering = !0)), s.onMouseEntered();
                  }),
                  (this._onMouseEntered = function () {
                      q(s.el, s.classNames.mouseEntered), s.options.autoHide && (s.hideScrollbar("x"), s.hideScrollbar("y")), (s.isMouseEntering = !1);
                  }),
                  (this._onMouseMove = function (e) {
                      (s.mouseX = e.clientX), (s.mouseY = e.clientY), (s.axis.x.isOverflowing || s.axis.x.forceVisible) && s.onMouseMoveForAxis("x"), (s.axis.y.isOverflowing || s.axis.y.forceVisible) && s.onMouseMoveForAxis("y");
                  }),
                  (this.onMouseLeave = function () {
                      s.onMouseMove.cancel(),
                          (s.axis.x.isOverflowing || s.axis.x.forceVisible) && s.onMouseLeaveForAxis("x"),
                          (s.axis.y.isOverflowing || s.axis.y.forceVisible) && s.onMouseLeaveForAxis("y"),
                          (s.mouseX = -1),
                          (s.mouseY = -1);
                  }),
                  (this._onWindowResize = function () {
                      (s.scrollbarWidth = s.getScrollbarWidth()), s.hideNativeScrollbar();
                  }),
                  (this.onPointerEvent = function (e) {
                      var t, i;
                      s.axis.x.track.el &&
                          s.axis.y.track.el &&
                          s.axis.x.scrollbar.el &&
                          s.axis.y.scrollbar.el &&
                          ((s.axis.x.track.rect = s.axis.x.track.el.getBoundingClientRect()),
                          (s.axis.y.track.rect = s.axis.y.track.el.getBoundingClientRect()),
                          (s.axis.x.isOverflowing || s.axis.x.forceVisible) && (t = s.isWithinBounds(s.axis.x.track.rect)),
                          (s.axis.y.isOverflowing || s.axis.y.forceVisible) && (i = s.isWithinBounds(s.axis.y.track.rect)),
                          (t || i) &&
                              (e.stopPropagation(),
                              "pointerdown" === e.type &&
                                  "touch" !== e.pointerType &&
                                  (t && ((s.axis.x.scrollbar.rect = s.axis.x.scrollbar.el.getBoundingClientRect()), s.isWithinBounds(s.axis.x.scrollbar.rect) ? s.onDragStart(e, "x") : s.onTrackClick(e, "x")),
                                  i && ((s.axis.y.scrollbar.rect = s.axis.y.scrollbar.el.getBoundingClientRect()), s.isWithinBounds(s.axis.y.scrollbar.rect) ? s.onDragStart(e, "y") : s.onTrackClick(e, "y")))));
                  }),
                  (this.drag = function (t) {
                      var i, r, l, o, n, a, c, h, u, d, p;
                      if (s.draggedAxis && s.contentWrapperEl) {
                          var v = s.axis[s.draggedAxis].track,
                              f = null !== (r = null === (i = v.rect) || void 0 === i ? void 0 : i[s.axis[s.draggedAxis].sizeAttr]) && void 0 !== r ? r : 0,
                              m = s.axis[s.draggedAxis].scrollbar,
                              b = null !== (o = null === (l = s.contentWrapperEl) || void 0 === l ? void 0 : l[s.axis[s.draggedAxis].scrollSizeAttr]) && void 0 !== o ? o : 0,
                              g = parseInt(null !== (a = null === (n = s.elStyles) || void 0 === n ? void 0 : n[s.axis[s.draggedAxis].sizeAttr]) && void 0 !== a ? a : "0px", 10);
                          t.preventDefault(), t.stopPropagation();
                          var x =
                                  ("y" === s.draggedAxis ? t.pageY : t.pageX) -
                                  (null !== (h = null === (c = v.rect) || void 0 === c ? void 0 : c[s.axis[s.draggedAxis].offsetAttr]) && void 0 !== h ? h : 0) -
                                  s.axis[s.draggedAxis].dragOffset,
                              y =
                                  ((x = "x" === s.draggedAxis && s.isRtl ? (null !== (d = null === (u = v.rect) || void 0 === u ? void 0 : u[s.axis[s.draggedAxis].sizeAttr]) && void 0 !== d ? d : 0) - m.size - x : x) / (f - m.size)) *
                                  (b - g);
                          "x" === s.draggedAxis && s.isRtl && (y = (null === (p = e.getRtlHelpers()) || void 0 === p ? void 0 : p.isScrollingToNegative) ? -y : y), (s.contentWrapperEl[s.axis[s.draggedAxis].scrollOffsetAttr] = y);
                      }
                  }),
                  (this.onEndDrag = function (e) {
                      var t = j(s.el),
                          i = H(s.el);
                      e.preventDefault(),
                          e.stopPropagation(),
                          q(s.el, s.classNames.dragging),
                          t.removeEventListener("mousemove", s.drag, !0),
                          t.removeEventListener("mouseup", s.onEndDrag, !0),
                          (s.removePreventClickId = i.setTimeout(function () {
                              t.removeEventListener("click", s.preventClick, !0), t.removeEventListener("dblclick", s.preventClick, !0), (s.removePreventClickId = null);
                          }));
                  }),
                  (this.preventClick = function (e) {
                      e.preventDefault(), e.stopPropagation();
                  }),
                  (this.el = t),
                  (this.options = k(k({}, e.defaultOptions), i)),
                  (this.classNames = k(k({}, e.defaultOptions.classNames), i.classNames)),
                  (this.axis = {
                      x: {
                          scrollOffsetAttr: "scrollLeft",
                          sizeAttr: "width",
                          scrollSizeAttr: "scrollWidth",
                          offsetSizeAttr: "offsetWidth",
                          offsetAttr: "left",
                          overflowAttr: "overflowX",
                          dragOffset: 0,
                          isOverflowing: !0,
                          forceVisible: !1,
                          track: { size: null, el: null, rect: null, isVisible: !1 },
                          scrollbar: { size: null, el: null, rect: null, isVisible: !1 },
                      },
                      y: {
                          scrollOffsetAttr: "scrollTop",
                          sizeAttr: "height",
                          scrollSizeAttr: "scrollHeight",
                          offsetSizeAttr: "offsetHeight",
                          offsetAttr: "top",
                          overflowAttr: "overflowY",
                          dragOffset: 0,
                          isOverflowing: !0,
                          forceVisible: !1,
                          track: { size: null, el: null, rect: null, isVisible: !1 },
                          scrollbar: { size: null, el: null, rect: null, isVisible: !1 },
                      },
                  }),
                  "object" != typeof this.el || !this.el.nodeName)
              )
                  throw new Error("Argument passed to SimpleBar must be an HTML element instead of ".concat(this.el));
              (this.onMouseMove = (function (e, t, i) {
                  var s = !0,
                      r = !0;
                  if ("function" != typeof e) throw new TypeError("Expected a function");
                  return m(i) && ((s = "leading" in i ? !!i.leading : s), (r = "trailing" in i ? !!i.trailing : r)), A(e, t, { leading: s, maxWait: t, trailing: r });
              })(this._onMouseMove, 64)),
                  (this.onWindowResize = A(this._onWindowResize, 64, { leading: !0 })),
                  (this.onStopScrolling = A(this._onStopScrolling, this.stopScrollDelay)),
                  (this.onMouseEntered = A(this._onMouseEntered, this.stopScrollDelay)),
                  this.init();
          }
          return (
              (e.getRtlHelpers = function () {
                  if (e.rtlHelpers) return e.rtlHelpers;
                  var t = document.createElement("div");
                  t.innerHTML = '<div class="simplebar-dummy-scrollbar-size"><div></div></div>';
                  var i = t.firstElementChild,
                      s = null == i ? void 0 : i.firstElementChild;
                  if (!s) return null;
                  document.body.appendChild(i), (i.scrollLeft = 0);
                  var r = e.getOffset(i),
                      l = e.getOffset(s);
                  i.scrollLeft = -999;
                  var o = e.getOffset(s);
                  return document.body.removeChild(i), (e.rtlHelpers = { isScrollOriginAtZero: r.left !== l.left, isScrollingToNegative: l.left !== o.left }), e.rtlHelpers;
              }),
              (e.prototype.getScrollbarWidth = function () {
                  try {
                      return (this.contentWrapperEl && "none" === getComputedStyle(this.contentWrapperEl, "::-webkit-scrollbar").display) ||
                          "scrollbarWidth" in document.documentElement.style ||
                          "-ms-overflow-style" in document.documentElement.style
                          ? 0
                          : N();
                  } catch (e) {
                      return N();
                  }
              }),
              (e.getOffset = function (e) {
                  var t = e.getBoundingClientRect(),
                      i = j(e),
                      s = H(e);
                  return { top: t.top + (s.pageYOffset || i.documentElement.scrollTop), left: t.left + (s.pageXOffset || i.documentElement.scrollLeft) };
              }),
              (e.prototype.init = function () {
                  t && (this.initDOM(), (this.rtlHelpers = e.getRtlHelpers()), (this.scrollbarWidth = this.getScrollbarWidth()), this.recalculate(), this.initListeners());
              }),
              (e.prototype.initDOM = function () {
                  var e, t;
                  (this.wrapperEl = this.el.querySelector(P(this.classNames.wrapper))),
                      (this.contentWrapperEl = this.options.scrollableNode || this.el.querySelector(P(this.classNames.contentWrapper))),
                      (this.contentEl = this.options.contentNode || this.el.querySelector(P(this.classNames.contentEl))),
                      (this.offsetEl = this.el.querySelector(P(this.classNames.offset))),
                      (this.maskEl = this.el.querySelector(P(this.classNames.mask))),
                      (this.placeholderEl = this.findChild(this.wrapperEl, P(this.classNames.placeholder))),
                      (this.heightAutoObserverWrapperEl = this.el.querySelector(P(this.classNames.heightAutoObserverWrapperEl))),
                      (this.heightAutoObserverEl = this.el.querySelector(P(this.classNames.heightAutoObserverEl))),
                      (this.axis.x.track.el = this.findChild(this.el, "".concat(P(this.classNames.track)).concat(P(this.classNames.horizontal)))),
                      (this.axis.y.track.el = this.findChild(this.el, "".concat(P(this.classNames.track)).concat(P(this.classNames.vertical)))),
                      (this.axis.x.scrollbar.el = (null === (e = this.axis.x.track.el) || void 0 === e ? void 0 : e.querySelector(P(this.classNames.scrollbar))) || null),
                      (this.axis.y.scrollbar.el = (null === (t = this.axis.y.track.el) || void 0 === t ? void 0 : t.querySelector(P(this.classNames.scrollbar))) || null),
                      this.options.autoHide || (_(this.axis.x.scrollbar.el, this.classNames.visible), _(this.axis.y.scrollbar.el, this.classNames.visible));
              }),
              (e.prototype.initListeners = function () {
                  var e,
                      t = this,
                      i = H(this.el);
                  if (
                      (this.el.addEventListener("mouseenter", this.onMouseEnter),
                      this.el.addEventListener("pointerdown", this.onPointerEvent, !0),
                      this.el.addEventListener("mousemove", this.onMouseMove),
                      this.el.addEventListener("mouseleave", this.onMouseLeave),
                      null === (e = this.contentWrapperEl) || void 0 === e || e.addEventListener("scroll", this.onScroll),
                      i.addEventListener("resize", this.onWindowResize),
                      this.contentEl)
                  ) {
                      if (window.ResizeObserver) {
                          var s = !1,
                              r = i.ResizeObserver || ResizeObserver;
                          (this.resizeObserver = new r(function () {
                              s &&
                                  i.requestAnimationFrame(function () {
                                      t.recalculate();
                                  });
                          })),
                              this.resizeObserver.observe(this.el),
                              this.resizeObserver.observe(this.contentEl),
                              i.requestAnimationFrame(function () {
                                  s = !0;
                              });
                      }
                      (this.mutationObserver = new i.MutationObserver(function () {
                          i.requestAnimationFrame(function () {
                              t.recalculate();
                          });
                      })),
                          this.mutationObserver.observe(this.contentEl, { childList: !0, subtree: !0, characterData: !0 });
                  }
              }),
              (e.prototype.recalculate = function () {
                  if (this.heightAutoObserverEl && this.contentEl && this.contentWrapperEl && this.wrapperEl && this.placeholderEl) {
                      var e = H(this.el);
                      (this.elStyles = e.getComputedStyle(this.el)), (this.isRtl = "rtl" === this.elStyles.direction);
                      var t = this.contentEl.offsetWidth,
                          i = this.heightAutoObserverEl.offsetHeight <= 1,
                          s = this.heightAutoObserverEl.offsetWidth <= 1 || t > 0,
                          r = this.contentWrapperEl.offsetWidth,
                          l = this.elStyles.overflowX,
                          o = this.elStyles.overflowY;
                      (this.contentEl.style.padding = "".concat(this.elStyles.paddingTop, " ").concat(this.elStyles.paddingRight, " ").concat(this.elStyles.paddingBottom, " ").concat(this.elStyles.paddingLeft)),
                          (this.wrapperEl.style.margin = "-".concat(this.elStyles.paddingTop, " -").concat(this.elStyles.paddingRight, " -").concat(this.elStyles.paddingBottom, " -").concat(this.elStyles.paddingLeft));
                      var n = this.contentEl.scrollHeight,
                          a = this.contentEl.scrollWidth;
                      (this.contentWrapperEl.style.height = i ? "auto" : "100%"), (this.placeholderEl.style.width = s ? "".concat(t || a, "px") : "auto"), (this.placeholderEl.style.height = "".concat(n, "px"));
                      var c = this.contentWrapperEl.offsetHeight;
                      (this.axis.x.isOverflowing = 0 !== t && a > t),
                          (this.axis.y.isOverflowing = n > c),
                          (this.axis.x.isOverflowing = "hidden" !== l && this.axis.x.isOverflowing),
                          (this.axis.y.isOverflowing = "hidden" !== o && this.axis.y.isOverflowing),
                          (this.axis.x.forceVisible = "x" === this.options.forceVisible || !0 === this.options.forceVisible),
                          (this.axis.y.forceVisible = "y" === this.options.forceVisible || !0 === this.options.forceVisible),
                          this.hideNativeScrollbar();
                      var h = this.axis.x.isOverflowing ? this.scrollbarWidth : 0,
                          u = this.axis.y.isOverflowing ? this.scrollbarWidth : 0;
                      (this.axis.x.isOverflowing = this.axis.x.isOverflowing && a > r - u),
                          (this.axis.y.isOverflowing = this.axis.y.isOverflowing && n > c - h),
                          (this.axis.x.scrollbar.size = this.getScrollbarSize("x")),
                          (this.axis.y.scrollbar.size = this.getScrollbarSize("y")),
                          this.axis.x.scrollbar.el && (this.axis.x.scrollbar.el.style.width = "".concat(this.axis.x.scrollbar.size, "px")),
                          this.axis.y.scrollbar.el && (this.axis.y.scrollbar.el.style.height = "".concat(this.axis.y.scrollbar.size, "px")),
                          this.positionScrollbar("x"),
                          this.positionScrollbar("y"),
                          this.toggleTrackVisibility("x"),
                          this.toggleTrackVisibility("y");
                  }
              }),
              (e.prototype.getScrollbarSize = function (e) {
                  var t, i;
                  if ((void 0 === e && (e = "y"), !this.axis[e].isOverflowing || !this.contentEl)) return 0;
                  var s,
                      r = this.contentEl[this.axis[e].scrollSizeAttr],
                      l = null !== (i = null === (t = this.axis[e].track.el) || void 0 === t ? void 0 : t[this.axis[e].offsetSizeAttr]) && void 0 !== i ? i : 0,
                      o = l / r;
                  return (s = Math.max(~~(o * l), this.options.scrollbarMinSize)), this.options.scrollbarMaxSize && (s = Math.min(s, this.options.scrollbarMaxSize)), s;
              }),
              (e.prototype.positionScrollbar = function (t) {
                  var i, s, r;
                  void 0 === t && (t = "y");
                  var l = this.axis[t].scrollbar;
                  if (this.axis[t].isOverflowing && this.contentWrapperEl && l.el && this.elStyles) {
                      var o = this.contentWrapperEl[this.axis[t].scrollSizeAttr],
                          n = (null === (i = this.axis[t].track.el) || void 0 === i ? void 0 : i[this.axis[t].offsetSizeAttr]) || 0,
                          a = parseInt(this.elStyles[this.axis[t].sizeAttr], 10),
                          c = this.contentWrapperEl[this.axis[t].scrollOffsetAttr];
                      (c = "x" === t && this.isRtl && (null === (s = e.getRtlHelpers()) || void 0 === s ? void 0 : s.isScrollOriginAtZero) ? -c : c),
                          "x" === t && this.isRtl && (c = (null === (r = e.getRtlHelpers()) || void 0 === r ? void 0 : r.isScrollingToNegative) ? c : -c);
                      var h = c / (o - a),
                          u = ~~((n - l.size) * h);
                      (u = "x" === t && this.isRtl ? -u + (n - l.size) : u), (l.el.style.transform = "x" === t ? "translate3d(".concat(u, "px, 0, 0)") : "translate3d(0, ".concat(u, "px, 0)"));
                  }
              }),
              (e.prototype.toggleTrackVisibility = function (e) {
                  void 0 === e && (e = "y");
                  var t = this.axis[e].track.el,
                      i = this.axis[e].scrollbar.el;
                  t &&
                      i &&
                      this.contentWrapperEl &&
                      (this.axis[e].isOverflowing || this.axis[e].forceVisible
                          ? ((t.style.visibility = "visible"), (this.contentWrapperEl.style[this.axis[e].overflowAttr] = "scroll"), this.el.classList.add("".concat(this.classNames.scrollable, "-").concat(e)))
                          : ((t.style.visibility = "hidden"), (this.contentWrapperEl.style[this.axis[e].overflowAttr] = "hidden"), this.el.classList.remove("".concat(this.classNames.scrollable, "-").concat(e))),
                      this.axis[e].isOverflowing ? (i.style.display = "block") : (i.style.display = "none"));
              }),
              (e.prototype.showScrollbar = function (e) {
                  void 0 === e && (e = "y"), this.axis[e].isOverflowing && !this.axis[e].scrollbar.isVisible && (_(this.axis[e].scrollbar.el, this.classNames.visible), (this.axis[e].scrollbar.isVisible = !0));
              }),
              (e.prototype.hideScrollbar = function (e) {
                  void 0 === e && (e = "y"), this.axis[e].isOverflowing && this.axis[e].scrollbar.isVisible && (q(this.axis[e].scrollbar.el, this.classNames.visible), (this.axis[e].scrollbar.isVisible = !1));
              }),
              (e.prototype.hideNativeScrollbar = function () {
                  this.offsetEl &&
                      ((this.offsetEl.style[this.isRtl ? "left" : "right"] = this.axis.y.isOverflowing || this.axis.y.forceVisible ? "-".concat(this.scrollbarWidth, "px") : "0px"),
                      (this.offsetEl.style.bottom = this.axis.x.isOverflowing || this.axis.x.forceVisible ? "-".concat(this.scrollbarWidth, "px") : "0px"));
              }),
              (e.prototype.onMouseMoveForAxis = function (e) {
                  void 0 === e && (e = "y");
                  var t = this.axis[e];
                  t.track.el &&
                      t.scrollbar.el &&
                      ((t.track.rect = t.track.el.getBoundingClientRect()),
                      (t.scrollbar.rect = t.scrollbar.el.getBoundingClientRect()),
                      this.isWithinBounds(t.track.rect)
                          ? (this.showScrollbar(e), _(t.track.el, this.classNames.hover), this.isWithinBounds(t.scrollbar.rect) ? _(t.scrollbar.el, this.classNames.hover) : q(t.scrollbar.el, this.classNames.hover))
                          : (q(t.track.el, this.classNames.hover), this.options.autoHide && this.hideScrollbar(e)));
              }),
              (e.prototype.onMouseLeaveForAxis = function (e) {
                  void 0 === e && (e = "y"), q(this.axis[e].track.el, this.classNames.hover), q(this.axis[e].scrollbar.el, this.classNames.hover), this.options.autoHide && this.hideScrollbar(e);
              }),
              (e.prototype.onDragStart = function (e, t) {
                  var i;
                  void 0 === t && (t = "y");
                  var s = j(this.el),
                      r = H(this.el),
                      l = this.axis[t].scrollbar,
                      o = "y" === t ? e.pageY : e.pageX;
                  (this.axis[t].dragOffset = o - ((null === (i = l.rect) || void 0 === i ? void 0 : i[this.axis[t].offsetAttr]) || 0)),
                      (this.draggedAxis = t),
                      _(this.el, this.classNames.dragging),
                      s.addEventListener("mousemove", this.drag, !0),
                      s.addEventListener("mouseup", this.onEndDrag, !0),
                      null === this.removePreventClickId
                          ? (s.addEventListener("click", this.preventClick, !0), s.addEventListener("dblclick", this.preventClick, !0))
                          : (r.clearTimeout(this.removePreventClickId), (this.removePreventClickId = null));
              }),
              (e.prototype.onTrackClick = function (e, t) {
                  var i,
                      s,
                      r,
                      l,
                      o = this;
                  void 0 === t && (t = "y");
                  var n = this.axis[t];
                  if (this.options.clickOnTrack && n.scrollbar.el && this.contentWrapperEl) {
                      e.preventDefault();
                      var a = H(this.el);
                      this.axis[t].scrollbar.rect = n.scrollbar.el.getBoundingClientRect();
                      var c = null !== (s = null === (i = this.axis[t].scrollbar.rect) || void 0 === i ? void 0 : i[this.axis[t].offsetAttr]) && void 0 !== s ? s : 0,
                          h = parseInt(null !== (l = null === (r = this.elStyles) || void 0 === r ? void 0 : r[this.axis[t].sizeAttr]) && void 0 !== l ? l : "0px", 10),
                          u = this.contentWrapperEl[this.axis[t].scrollOffsetAttr],
                          d = ("y" === t ? this.mouseY - c : this.mouseX - c) < 0 ? -1 : 1,
                          p = -1 === d ? u - h : u + h,
                          v = function () {
                              o.contentWrapperEl &&
                                  (-1 === d
                                      ? u > p && ((u -= 40), (o.contentWrapperEl[o.axis[t].scrollOffsetAttr] = u), a.requestAnimationFrame(v))
                                      : u < p && ((u += 40), (o.contentWrapperEl[o.axis[t].scrollOffsetAttr] = u), a.requestAnimationFrame(v)));
                          };
                      v();
                  }
              }),
              (e.prototype.getContentElement = function () {
                  return this.contentEl;
              }),
              (e.prototype.getScrollElement = function () {
                  return this.contentWrapperEl;
              }),
              (e.prototype.removeListeners = function () {
                  var e = H(this.el);
                  this.el.removeEventListener("mouseenter", this.onMouseEnter),
                      this.el.removeEventListener("pointerdown", this.onPointerEvent, !0),
                      this.el.removeEventListener("mousemove", this.onMouseMove),
                      this.el.removeEventListener("mouseleave", this.onMouseLeave),
                      this.contentWrapperEl && this.contentWrapperEl.removeEventListener("scroll", this.onScroll),
                      e.removeEventListener("resize", this.onWindowResize),
                      this.mutationObserver && this.mutationObserver.disconnect(),
                      this.resizeObserver && this.resizeObserver.disconnect(),
                      this.onMouseMove.cancel(),
                      this.onWindowResize.cancel(),
                      this.onStopScrolling.cancel(),
                      this.onMouseEntered.cancel();
              }),
              (e.prototype.unMount = function () {
                  this.removeListeners();
              }),
              (e.prototype.isWithinBounds = function (e) {
                  return this.mouseX >= e.left && this.mouseX <= e.left + e.width && this.mouseY >= e.top && this.mouseY <= e.top + e.height;
              }),
              (e.prototype.findChild = function (e, t) {
                  var i = e.matches || e.webkitMatchesSelector || e.mozMatchesSelector || e.msMatchesSelector;
                  return Array.prototype.filter.call(e.children, function (e) {
                      return i.call(e, t);
                  })[0];
              }),
              (e.rtlHelpers = null),
              (e.defaultOptions = {
                  forceVisible: !1,
                  clickOnTrack: !0,
                  scrollbarMinSize: 25,
                  scrollbarMaxSize: 0,
                  ariaLabel: "scrollable content",
                  classNames: {
                      contentEl: "simplebar-content",
                      contentWrapper: "simplebar-content-wrapper",
                      offset: "simplebar-offset",
                      mask: "simplebar-mask",
                      wrapper: "simplebar-wrapper",
                      placeholder: "simplebar-placeholder",
                      scrollbar: "simplebar-scrollbar",
                      track: "simplebar-track",
                      heightAutoObserverWrapperEl: "simplebar-height-auto-observer-wrapper",
                      heightAutoObserverEl: "simplebar-height-auto-observer",
                      visible: "simplebar-visible",
                      horizontal: "simplebar-horizontal",
                      vertical: "simplebar-vertical",
                      hover: "simplebar-hover",
                      dragging: "simplebar-dragging",
                      scrolling: "simplebar-scrolling",
                      scrollable: "simplebar-scrollable",
                      mouseEntered: "simplebar-mouse-entered",
                  },
                  scrollableNode: null,
                  contentNode: null,
                  autoHide: !0,
              }),
              (e.getOptions = B),
              (e.helpers = V),
              e
          );
      })(),
      Y = X.helpers,
      F = Y.getOptions,
      I = Y.addClasses,
      $ = (function (t) {
          function i() {
              for (var e = [], s = 0; s < arguments.length; s++) e[s] = arguments[s];
              var r = t.apply(this, e) || this;
              return i.instances.set(e[0], r), r;
          }
          return (
              (function (t, i) {
                  if ("function" != typeof i && null !== i) throw new TypeError("Class extends value " + String(i) + " is not a constructor or null");
                  function s() {
                      this.constructor = t;
                  }
                  e(t, i), (t.prototype = null === i ? Object.create(i) : ((s.prototype = i.prototype), new s()));
              })(i, t),
              (i.initDOMLoadedElements = function () {
                  document.removeEventListener("DOMContentLoaded", this.initDOMLoadedElements),
                      window.removeEventListener("load", this.initDOMLoadedElements),
                      Array.prototype.forEach.call(document.querySelectorAll("[data-simplebar]"), function (e) {
                          "init" === e.getAttribute("data-simplebar") || i.instances.has(e) || new i(e, F(e.attributes));
                      });
              }),
              (i.removeObserver = function () {
                  var e;
                  null === (e = i.globalObserver) || void 0 === e || e.disconnect();
              }),
              (i.prototype.initDOM = function () {
                  var e,
                      t,
                      i,
                      s = this;
                  if (
                      !Array.prototype.filter.call(this.el.children, function (e) {
                          return e.classList.contains(s.classNames.wrapper);
                      }).length
                  ) {
                      for (
                          this.wrapperEl = document.createElement("div"),
                              this.contentWrapperEl = document.createElement("div"),
                              this.offsetEl = document.createElement("div"),
                              this.maskEl = document.createElement("div"),
                              this.contentEl = document.createElement("div"),
                              this.placeholderEl = document.createElement("div"),
                              this.heightAutoObserverWrapperEl = document.createElement("div"),
                              this.heightAutoObserverEl = document.createElement("div"),
                              I(this.wrapperEl, this.classNames.wrapper),
                              I(this.contentWrapperEl, this.classNames.contentWrapper),
                              I(this.offsetEl, this.classNames.offset),
                              I(this.maskEl, this.classNames.mask),
                              I(this.contentEl, this.classNames.contentEl),
                              I(this.placeholderEl, this.classNames.placeholder),
                              I(this.heightAutoObserverWrapperEl, this.classNames.heightAutoObserverWrapperEl),
                              I(this.heightAutoObserverEl, this.classNames.heightAutoObserverEl);
                          this.el.firstChild;

                      )
                          this.contentEl.appendChild(this.el.firstChild);
                      this.contentWrapperEl.appendChild(this.contentEl),
                          this.offsetEl.appendChild(this.contentWrapperEl),
                          this.maskEl.appendChild(this.offsetEl),
                          this.heightAutoObserverWrapperEl.appendChild(this.heightAutoObserverEl),
                          this.wrapperEl.appendChild(this.heightAutoObserverWrapperEl),
                          this.wrapperEl.appendChild(this.maskEl),
                          this.wrapperEl.appendChild(this.placeholderEl),
                          this.el.appendChild(this.wrapperEl),
                          null === (e = this.contentWrapperEl) || void 0 === e || e.setAttribute("tabindex", "0"),
                          null === (t = this.contentWrapperEl) || void 0 === t || t.setAttribute("role", "region"),
                          null === (i = this.contentWrapperEl) || void 0 === i || i.setAttribute("aria-label", this.options.ariaLabel);
                  }
                  if (!this.axis.x.track.el || !this.axis.y.track.el) {
                      var r = document.createElement("div"),
                          l = document.createElement("div");
                      I(r, this.classNames.track),
                          I(l, this.classNames.scrollbar),
                          r.appendChild(l),
                          (this.axis.x.track.el = r.cloneNode(!0)),
                          I(this.axis.x.track.el, this.classNames.horizontal),
                          (this.axis.y.track.el = r.cloneNode(!0)),
                          I(this.axis.y.track.el, this.classNames.vertical),
                          this.el.appendChild(this.axis.x.track.el),
                          this.el.appendChild(this.axis.y.track.el);
                  }
                  X.prototype.initDOM.call(this), this.el.setAttribute("data-simplebar", "init");
              }),
              (i.prototype.unMount = function () {
                  X.prototype.unMount.call(this), i.instances.delete(this.el);
              }),
              (i.initHtmlApi = function () {
                  (this.initDOMLoadedElements = this.initDOMLoadedElements.bind(this)),
                      "undefined" != typeof MutationObserver && ((this.globalObserver = new MutationObserver(i.handleMutations)), this.globalObserver.observe(document, { childList: !0, subtree: !0 })),
                      "complete" === document.readyState || ("loading" !== document.readyState && !document.documentElement.doScroll)
                          ? window.setTimeout(this.initDOMLoadedElements)
                          : (document.addEventListener("DOMContentLoaded", this.initDOMLoadedElements), window.addEventListener("load", this.initDOMLoadedElements));
              }),
              (i.handleMutations = function (e) {
                  e.forEach(function (e) {
                      e.addedNodes.forEach(function (e) {
                          1 === e.nodeType &&
                              (e.hasAttribute("data-simplebar")
                                  ? !i.instances.has(e) && document.documentElement.contains(e) && new i(e, F(e.attributes))
                                  : e.querySelectorAll("[data-simplebar]").forEach(function (e) {
                                        "init" !== e.getAttribute("data-simplebar") && !i.instances.has(e) && document.documentElement.contains(e) && new i(e, F(e.attributes));
                                    }));
                      }),
                          e.removedNodes.forEach(function (e) {
                              1 === e.nodeType &&
                                  ("init" === e.getAttribute("data-simplebar")
                                      ? i.instances.has(e) && !document.documentElement.contains(e) && i.instances.get(e).unMount()
                                      : Array.prototype.forEach.call(e.querySelectorAll('[data-simplebar="init"]'), function (e) {
                                            i.instances.has(e) && !document.documentElement.contains(e) && i.instances.get(e).unMount();
                                        }));
                          });
                  });
              }),
              (i.instances = new WeakMap()),
              i
          );
      })(X);
  return t && $.initHtmlApi(), $;
})();
// niceNumber
(function ($) {
  $.fn.niceNumber = function (options) {
      var defaults = {
          autoSize: true,
          autoSizeBuffer: 1,
          buttonDecrement: "-",
          buttonIncrement: "+",
          buttonPosition: "around",

          /**
      callbackFunction
      @param {$input} currentInput - the input running the callback
      @param {number} amount - the amount after increase/decrease
      @param {object} settings - the passed niceNumber settings
    **/
          onDecrement: false,
          onIncrement: false,
      };
      var settings = $.extend(defaults, options);

      return this.each(function () {
          var currentInput = this,
              $currentInput = $(currentInput),
              maxValue = $currentInput.attr("max"),
              minValue = $currentInput.attr("min"),
              attrMax = null,
              attrMin = null;

          // Skip already initialized input
          if ($currentInput.attr("data-nice-number-initialized")) return;

          // Handle max and min values
          if (maxValue !== undefined && maxValue !== false) {
              attrMax = parseFloat(maxValue);
          }

          if (minValue !== undefined && minValue !== false) {
              attrMin = parseFloat(minValue);
          }

          // Fix issue with initial value being < min
          if (attrMin && !currentInput.value) {
              $currentInput.val(attrMin);
          }

          // Generate container
          var $inputContainer = $("<div/>", {
              class: "nice-number",
          }).insertAfter(currentInput);

          // Generate interval (object so it is passed by reference)
          var interval = {};

          // Generate buttons
          var $minusButton = $("<button/>")
              .attr("type", "button")
              .html(settings.buttonDecrement)
              .on("mousedown mouseup mouseleave", function (event) {
                  changeInterval(event.type, interval, function () {
                      var currentValue = parseFloat($currentInput.val() || 0);
                      if (attrMin == null || attrMin < currentValue) {
                          var newValue = currentValue - 1;
                          $currentInput.val(newValue);
                          if (settings.onDecrement) {
                              settings.onDecrement($currentInput, newValue, settings);
                          }
                      }
                  });

                  // Trigger the input event here to avoid event spam
                  if (event.type == "mouseup" || event.type == "mouseleave") {
                      $currentInput.trigger("input");
                  }
              });

          var $plusButton = $("<button/>")
              .attr("type", "button")
              .html(settings.buttonIncrement)
              .on("mousedown mouseup mouseleave", function (event) {
                  changeInterval(event.type, interval, function () {
                      var currentValue = parseFloat($currentInput.val() || 0);
                      if (attrMax == null || attrMax > currentValue) {
                          var newValue = currentValue + 1;
                          $currentInput.val(newValue);
                          if (settings.onIncrement) {
                              settings.onIncrement($currentInput, newValue, settings);
                          }
                      }
                  });

                  // Trigger the input event here to avoid event spam
                  if (event.type == "mouseup" || event.type == "mouseleave") {
                      $currentInput.trigger("input");
                  }
              });

          // Remember that we have initialized this input
          $currentInput.attr("data-nice-number-initialized", true);

          // Append elements
          switch (settings.buttonPosition) {
              case "left":
                  $minusButton.appendTo($inputContainer);
                  $plusButton.appendTo($inputContainer);
                  $currentInput.appendTo($inputContainer);
                  break;
              case "right":
                  $currentInput.appendTo($inputContainer);
                  $minusButton.appendTo($inputContainer);
                  $plusButton.appendTo($inputContainer);
                  break;
              case "around":
              default:
                  $minusButton.appendTo($inputContainer);
                  $currentInput.appendTo($inputContainer);
                  $plusButton.appendTo($inputContainer);
                  break;
          }

          // Nicely size input
          if (settings.autoSize) {
              $currentInput.width($currentInput.val().length + settings.autoSizeBuffer + "ch");
              $currentInput.on("keyup input", function () {
                  $currentInput.animate(
                      {
                          width: $currentInput.val().length + settings.autoSizeBuffer + "ch",
                      },
                      200
                  );
              });
          }
      });
  };

  function changeInterval(eventType, interval, callback) {
      if (eventType == "mousedown") {
          interval.timeout = setTimeout(function () {
              interval.actualInterval = setInterval(function () {
                  callback();
              }, 100);
          }, 200);
          callback();
      } else {
          if (interval.timeout) {
              clearTimeout(interval.timeout);
          }
          if (interval.actualInterval) {
              clearInterval(interval.actualInterval);
          }
      }
  }
})(jQuery);

/*! Select2 4.1.0-rc.0 | https://github.com/select2/select2/blob/master/LICENSE.md */
!(function (n) {
  "function" == typeof define && define.amd
      ? define(["jquery"], n)
      : "object" == typeof module && module.exports
      ? (module.exports = function (e, t) {
            return void 0 === t && (t = "undefined" != typeof window ? require("jquery") : require("jquery")(e)), n(t), t;
        })
      : n(jQuery);
})(function (t) {
  var e,
      n,
      s,
      p,
      r,
      o,
      h,
      f,
      g,
      m,
      y,
      v,
      i,
      a,
      _,
      s =
          (((u = t && t.fn && t.fn.select2 && t.fn.select2.amd ? t.fn.select2.amd : u) && u.requirejs) ||
              (u ? (n = u) : (u = {}),
              (g = {}),
              (m = {}),
              (y = {}),
              (v = {}),
              (i = Object.prototype.hasOwnProperty),
              (a = [].slice),
              (_ = /\.js$/),
              (h = function (e, t) {
                  var n,
                      s,
                      i = c(e),
                      r = i[0],
                      t = t[1];
                  return (
                      (e = i[1]),
                      r && (n = x((r = l(r, t)))),
                      r
                          ? (e =
                                n && n.normalize
                                    ? n.normalize(
                                          e,
                                          ((s = t),
                                          function (e) {
                                              return l(e, s);
                                          })
                                      )
                                    : l(e, t))
                          : ((r = (i = c((e = l(e, t))))[0]), (e = i[1]), r && (n = x(r))),
                      { f: r ? r + "!" + e : e, n: e, pr: r, p: n }
                  );
              }),
              (f = {
                  require: function (e) {
                      return w(e);
                  },
                  exports: function (e) {
                      var t = g[e];
                      return void 0 !== t ? t : (g[e] = {});
                  },
                  module: function (e) {
                      return {
                          id: e,
                          uri: "",
                          exports: g[e],
                          config:
                              ((t = e),
                              function () {
                                  return (y && y.config && y.config[t]) || {};
                              }),
                      };
                      var t;
                  },
              }),
              (r = function (e, t, n, s) {
                  var i,
                      r,
                      o,
                      a,
                      l,
                      c = [],
                      u = typeof n,
                      d = A((s = s || e));
                  if ("undefined" == u || "function" == u) {
                      for (t = !t.length && n.length ? ["require", "exports", "module"] : t, a = 0; a < t.length; a += 1)
                          if ("require" === (r = (o = h(t[a], d)).f)) c[a] = f.require(e);
                          else if ("exports" === r) (c[a] = f.exports(e)), (l = !0);
                          else if ("module" === r) i = c[a] = f.module(e);
                          else if (b(g, r) || b(m, r) || b(v, r)) c[a] = x(r);
                          else {
                              if (!o.p) throw new Error(e + " missing " + r);
                              o.p.load(
                                  o.n,
                                  w(s, !0),
                                  (function (t) {
                                      return function (e) {
                                          g[t] = e;
                                      };
                                  })(r),
                                  {}
                              ),
                                  (c[a] = g[r]);
                          }
                      (u = n ? n.apply(g[e], c) : void 0), e && (i && i.exports !== p && i.exports !== g[e] ? (g[e] = i.exports) : (u === p && l) || (g[e] = u));
                  } else e && (g[e] = n);
              }),
              (e = n = o = function (e, t, n, s, i) {
                  if ("string" == typeof e) return f[e] ? f[e](t) : x(h(e, A(t)).f);
                  if (!e.splice) {
                      if (((y = e).deps && o(y.deps, y.callback), !t)) return;
                      t.splice ? ((e = t), (t = n), (n = null)) : (e = p);
                  }
                  return (
                      (t = t || function () {}),
                      "function" == typeof n && ((n = s), (s = i)),
                      s
                          ? r(p, e, t, n)
                          : setTimeout(function () {
                                r(p, e, t, n);
                            }, 4),
                      o
                  );
              }),
              (o.config = function (e) {
                  return o(e);
              }),
              (e._defined = g),
              ((s = function (e, t, n) {
                  if ("string" != typeof e) throw new Error("See almond README: incorrect module build, no module name");
                  t.splice || ((n = t), (t = [])), b(g, e) || b(m, e) || (m[e] = [e, t, n]);
              }).amd = { jQuery: !0 }),
              (u.requirejs = e),
              (u.require = n),
              (u.define = s)),
          u.define("almond", function () {}),
          u.define("jquery", [], function () {
              var e = t || $;
              return null == e && console && console.error && console.error("Select2: An instance of jQuery or a jQuery-compatible library was not found. Make sure that you are including jQuery before Select2 on your web page."), e;
          }),
          u.define("select2/utils", ["jquery"], function (r) {
              var s = {};
              function c(e) {
                  var t,
                      n = e.prototype,
                      s = [];
                  for (t in n) "function" == typeof n[t] && "constructor" !== t && s.push(t);
                  return s;
              }
              (s.Extend = function (e, t) {
                  var n,
                      s = {}.hasOwnProperty;
                  function i() {
                      this.constructor = e;
                  }
                  for (n in t) s.call(t, n) && (e[n] = t[n]);
                  return (i.prototype = t.prototype), (e.prototype = new i()), (e.__super__ = t.prototype), e;
              }),
                  (s.Decorate = function (s, i) {
                      var e = c(i),
                          t = c(s);
                      function r() {
                          var e = Array.prototype.unshift,
                              t = i.prototype.constructor.length,
                              n = s.prototype.constructor;
                          0 < t && (e.call(arguments, s.prototype.constructor), (n = i.prototype.constructor)), n.apply(this, arguments);
                      }
                      (i.displayName = s.displayName),
                          (r.prototype = new (function () {
                              this.constructor = r;
                          })());
                      for (var n = 0; n < t.length; n++) {
                          var o = t[n];
                          r.prototype[o] = s.prototype[o];
                      }
                      for (var a = 0; a < e.length; a++) {
                          var l = e[a];
                          r.prototype[l] = (function (e) {
                              var t = function () {};
                              e in r.prototype && (t = r.prototype[e]);
                              var n = i.prototype[e];
                              return function () {
                                  return Array.prototype.unshift.call(arguments, t), n.apply(this, arguments);
                              };
                          })(l);
                      }
                      return r;
                  });
              function e() {
                  this.listeners = {};
              }
              (e.prototype.on = function (e, t) {
                  (this.listeners = this.listeners || {}), e in this.listeners ? this.listeners[e].push(t) : (this.listeners[e] = [t]);
              }),
                  (e.prototype.trigger = function (e) {
                      var t = Array.prototype.slice,
                          n = t.call(arguments, 1);
                      (this.listeners = this.listeners || {}),
                          0 === (n = null == n ? [] : n).length && n.push({}),
                          (n[0]._type = e) in this.listeners && this.invoke(this.listeners[e], t.call(arguments, 1)),
                          "*" in this.listeners && this.invoke(this.listeners["*"], arguments);
                  }),
                  (e.prototype.invoke = function (e, t) {
                      for (var n = 0, s = e.length; n < s; n++) e[n].apply(this, t);
                  }),
                  (s.Observable = e),
                  (s.generateChars = function (e) {
                      for (var t = "", n = 0; n < e; n++) t += Math.floor(36 * Math.random()).toString(36);
                      return t;
                  }),
                  (s.bind = function (e, t) {
                      return function () {
                          e.apply(t, arguments);
                      };
                  }),
                  (s._convertData = function (e) {
                      for (var t in e) {
                          var n = t.split("-"),
                              s = e;
                          if (1 !== n.length) {
                              for (var i = 0; i < n.length; i++) {
                                  var r = n[i];
                                  (r = r.substring(0, 1).toLowerCase() + r.substring(1)) in s || (s[r] = {}), i == n.length - 1 && (s[r] = e[t]), (s = s[r]);
                              }
                              delete e[t];
                          }
                      }
                      return e;
                  }),
                  (s.hasScroll = function (e, t) {
                      var n = r(t),
                          s = t.style.overflowX,
                          i = t.style.overflowY;
                      return (s !== i || ("hidden" !== i && "visible" !== i)) && ("scroll" === s || "scroll" === i || n.innerHeight() < t.scrollHeight || n.innerWidth() < t.scrollWidth);
                  }),
                  (s.escapeMarkup = function (e) {
                      var t = { "\\": "&#92;", "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;", "/": "&#47;" };
                      return "string" != typeof e
                          ? e
                          : String(e).replace(/[&<>"'\/\\]/g, function (e) {
                                return t[e];
                            });
                  }),
                  (s.__cache = {});
              var n = 0;
              return (
                  (s.GetUniqueElementId = function (e) {
                      var t = e.getAttribute("data-select2-id");
                      return null != t || ((t = e.id ? "select2-data-" + e.id : "select2-data-" + (++n).toString() + "-" + s.generateChars(4)), e.setAttribute("data-select2-id", t)), t;
                  }),
                  (s.StoreData = function (e, t, n) {
                      e = s.GetUniqueElementId(e);
                      s.__cache[e] || (s.__cache[e] = {}), (s.__cache[e][t] = n);
                  }),
                  (s.GetData = function (e, t) {
                      var n = s.GetUniqueElementId(e);
                      return t ? (s.__cache[n] && null != s.__cache[n][t] ? s.__cache[n][t] : r(e).data(t)) : s.__cache[n];
                  }),
                  (s.RemoveData = function (e) {
                      var t = s.GetUniqueElementId(e);
                      null != s.__cache[t] && delete s.__cache[t], e.removeAttribute("data-select2-id");
                  }),
                  (s.copyNonInternalCssClasses = function (e, t) {
                      var n = (n = e.getAttribute("class").trim().split(/\s+/)).filter(function (e) {
                              return 0 === e.indexOf("select2-");
                          }),
                          t = (t = t.getAttribute("class").trim().split(/\s+/)).filter(function (e) {
                              return 0 !== e.indexOf("select2-");
                          }),
                          t = n.concat(t);
                      e.setAttribute("class", t.join(" "));
                  }),
                  s
              );
          }),
          u.define("select2/results", ["jquery", "./utils"], function (d, p) {
              function s(e, t, n) {
                  (this.$element = e), (this.data = n), (this.options = t), s.__super__.constructor.call(this);
              }
              return (
                  p.Extend(s, p.Observable),
                  (s.prototype.render = function () {
                      var e = d('<ul class="select2-results__options" role="listbox"></ul>');
                      return this.options.get("multiple") && e.attr("aria-multiselectable", "true"), (this.$results = e);
                  }),
                  (s.prototype.clear = function () {
                      this.$results.empty();
                  }),
                  (s.prototype.displayMessage = function (e) {
                      var t = this.options.get("escapeMarkup");
                      this.clear(), this.hideLoading();
                      var n = d('<li role="alert" aria-live="assertive" class="select2-results__option"></li>'),
                          s = this.options.get("translations").get(e.message);
                      n.append(t(s(e.args))), (n[0].className += " select2-results__message"), this.$results.append(n);
                  }),
                  (s.prototype.hideMessages = function () {
                      this.$results.find(".select2-results__message").remove();
                  }),
                  (s.prototype.append = function (e) {
                      this.hideLoading();
                      var t = [];
                      if (null != e.results && 0 !== e.results.length) {
                          e.results = this.sort(e.results);
                          for (var n = 0; n < e.results.length; n++) {
                              var s = e.results[n],
                                  s = this.option(s);
                              t.push(s);
                          }
                          this.$results.append(t);
                      } else 0 === this.$results.children().length && this.trigger("results:message", { message: "noResults" });
                  }),
                  (s.prototype.position = function (e, t) {
                      t.find(".select2-results").append(e);
                  }),
                  (s.prototype.sort = function (e) {
                      return this.options.get("sorter")(e);
                  }),
                  (s.prototype.highlightFirstItem = function () {
                      var e = this.$results.find(".select2-results__option--selectable"),
                          t = e.filter(".select2-results__option--selected");
                      (0 < t.length ? t : e).first().trigger("mouseenter"), this.ensureHighlightVisible();
                  }),
                  (s.prototype.setClasses = function () {
                      var t = this;
                      this.data.current(function (e) {
                          var s = e.map(function (e) {
                              return e.id.toString();
                          });
                          t.$results.find(".select2-results__option--selectable").each(function () {
                              var e = d(this),
                                  t = p.GetData(this, "data"),
                                  n = "" + t.id;
                              (null != t.element && t.element.selected) || (null == t.element && -1 < s.indexOf(n))
                                  ? (this.classList.add("select2-results__option--selected"), e.attr("aria-selected", "true"))
                                  : (this.classList.remove("select2-results__option--selected"), e.attr("aria-selected", "false"));
                          });
                      });
                  }),
                  (s.prototype.showLoading = function (e) {
                      this.hideLoading();
                      (e = { disabled: !0, loading: !0, text: this.options.get("translations").get("searching")(e) }), (e = this.option(e));
                      (e.className += " loading-results"), this.$results.prepend(e);
                  }),
                  (s.prototype.hideLoading = function () {
                      this.$results.find(".loading-results").remove();
                  }),
                  (s.prototype.option = function (e) {
                      var t = document.createElement("li");
                      t.classList.add("select2-results__option"), t.classList.add("select2-results__option--selectable");
                      var n,
                          s = { role: "option" },
                          i = window.Element.prototype.matches || window.Element.prototype.msMatchesSelector || window.Element.prototype.webkitMatchesSelector;
                      for (n in (((null != e.element && i.call(e.element, ":disabled")) || (null == e.element && e.disabled)) &&
                          ((s["aria-disabled"] = "true"), t.classList.remove("select2-results__option--selectable"), t.classList.add("select2-results__option--disabled")),
                      null == e.id && t.classList.remove("select2-results__option--selectable"),
                      null != e._resultId && (t.id = e._resultId),
                      e.title && (t.title = e.title),
                      e.children && ((s.role = "group"), (s["aria-label"] = e.text), t.classList.remove("select2-results__option--selectable"), t.classList.add("select2-results__option--group")),
                      s)) {
                          var r = s[n];
                          t.setAttribute(n, r);
                      }
                      if (e.children) {
                          var o = d(t),
                              a = document.createElement("strong");
                          (a.className = "select2-results__group"), this.template(e, a);
                          for (var l = [], c = 0; c < e.children.length; c++) {
                              var u = e.children[c],
                                  u = this.option(u);
                              l.push(u);
                          }
                          i = d("<ul></ul>", { class: "select2-results__options select2-results__options--nested", role: "none" });
                          i.append(l), o.append(a), o.append(i);
                      } else this.template(e, t);
                      return p.StoreData(t, "data", e), t;
                  }),
                  (s.prototype.bind = function (t, e) {
                      var i = this,
                          n = t.id + "-results";
                      this.$results.attr("id", n),
                          t.on("results:all", function (e) {
                              i.clear(), i.append(e.data), t.isOpen() && (i.setClasses(), i.highlightFirstItem());
                          }),
                          t.on("results:append", function (e) {
                              i.append(e.data), t.isOpen() && i.setClasses();
                          }),
                          t.on("query", function (e) {
                              i.hideMessages(), i.showLoading(e);
                          }),
                          t.on("select", function () {
                              t.isOpen() && (i.setClasses(), i.options.get("scrollAfterSelect") && i.highlightFirstItem());
                          }),
                          t.on("unselect", function () {
                              t.isOpen() && (i.setClasses(), i.options.get("scrollAfterSelect") && i.highlightFirstItem());
                          }),
                          t.on("open", function () {
                              i.$results.attr("aria-expanded", "true"), i.$results.attr("aria-hidden", "false"), i.setClasses(), i.ensureHighlightVisible();
                          }),
                          t.on("close", function () {
                              i.$results.attr("aria-expanded", "false"), i.$results.attr("aria-hidden", "true"), i.$results.removeAttr("aria-activedescendant");
                          }),
                          t.on("results:toggle", function () {
                              var e = i.getHighlightedResults();
                              0 !== e.length && e.trigger("mouseup");
                          }),
                          t.on("results:select", function () {
                              var e,
                                  t = i.getHighlightedResults();
                              0 !== t.length && ((e = p.GetData(t[0], "data")), t.hasClass("select2-results__option--selected") ? i.trigger("close", {}) : i.trigger("select", { data: e }));
                          }),
                          t.on("results:previous", function () {
                              var e,
                                  t = i.getHighlightedResults(),
                                  n = i.$results.find(".select2-results__option--selectable"),
                                  s = n.index(t);
                              s <= 0 ||
                                  ((e = s - 1),
                                  0 === t.length && (e = 0),
                                  (s = n.eq(e)).trigger("mouseenter"),
                                  (t = i.$results.offset().top),
                                  (n = s.offset().top),
                                  (s = i.$results.scrollTop() + (n - t)),
                                  0 === e ? i.$results.scrollTop(0) : n - t < 0 && i.$results.scrollTop(s));
                          }),
                          t.on("results:next", function () {
                              var e,
                                  t = i.getHighlightedResults(),
                                  n = i.$results.find(".select2-results__option--selectable"),
                                  s = n.index(t) + 1;
                              s >= n.length ||
                                  ((e = n.eq(s)).trigger("mouseenter"),
                                  (t = i.$results.offset().top + i.$results.outerHeight(!1)),
                                  (n = e.offset().top + e.outerHeight(!1)),
                                  (e = i.$results.scrollTop() + n - t),
                                  0 === s ? i.$results.scrollTop(0) : t < n && i.$results.scrollTop(e));
                          }),
                          t.on("results:focus", function (e) {
                              e.element[0].classList.add("select2-results__option--highlighted"), e.element[0].setAttribute("aria-selected", "true");
                          }),
                          t.on("results:message", function (e) {
                              i.displayMessage(e);
                          }),
                          d.fn.mousewheel &&
                              this.$results.on("mousewheel", function (e) {
                                  var t = i.$results.scrollTop(),
                                      n = i.$results.get(0).scrollHeight - t + e.deltaY,
                                      t = 0 < e.deltaY && t - e.deltaY <= 0,
                                      n = e.deltaY < 0 && n <= i.$results.height();
                                  t ? (i.$results.scrollTop(0), e.preventDefault(), e.stopPropagation()) : n && (i.$results.scrollTop(i.$results.get(0).scrollHeight - i.$results.height()), e.preventDefault(), e.stopPropagation());
                              }),
                          this.$results.on("mouseup", ".select2-results__option--selectable", function (e) {
                              var t = d(this),
                                  n = p.GetData(this, "data");
                              t.hasClass("select2-results__option--selected")
                                  ? i.options.get("multiple")
                                      ? i.trigger("unselect", { originalEvent: e, data: n })
                                      : i.trigger("close", {})
                                  : i.trigger("select", { originalEvent: e, data: n });
                          }),
                          this.$results.on("mouseenter", ".select2-results__option--selectable", function (e) {
                              var t = p.GetData(this, "data");
                              i.getHighlightedResults().removeClass("select2-results__option--highlighted").attr("aria-selected", "false"), i.trigger("results:focus", { data: t, element: d(this) });
                          });
                  }),
                  (s.prototype.getHighlightedResults = function () {
                      return this.$results.find(".select2-results__option--highlighted");
                  }),
                  (s.prototype.destroy = function () {
                      this.$results.remove();
                  }),
                  (s.prototype.ensureHighlightVisible = function () {
                      var e,
                          t,
                          n,
                          s,
                          i = this.getHighlightedResults();
                      0 !== i.length &&
                          ((e = this.$results.find(".select2-results__option--selectable").index(i)),
                          (s = this.$results.offset().top),
                          (t = i.offset().top),
                          (n = this.$results.scrollTop() + (t - s)),
                          (s = t - s),
                          (n -= 2 * i.outerHeight(!1)),
                          e <= 2 ? this.$results.scrollTop(0) : (s > this.$results.outerHeight() || s < 0) && this.$results.scrollTop(n));
                  }),
                  (s.prototype.template = function (e, t) {
                      var n = this.options.get("templateResult"),
                          s = this.options.get("escapeMarkup"),
                          e = n(e, t);
                      null == e ? (t.style.display = "none") : "string" == typeof e ? (t.innerHTML = s(e)) : d(t).append(e);
                  }),
                  s
              );
          }),
          u.define("select2/keys", [], function () {
              return { BACKSPACE: 8, TAB: 9, ENTER: 13, SHIFT: 16, CTRL: 17, ALT: 18, ESC: 27, SPACE: 32, PAGE_UP: 33, PAGE_DOWN: 34, END: 35, HOME: 36, LEFT: 37, UP: 38, RIGHT: 39, DOWN: 40, DELETE: 46 };
          }),
          u.define("select2/selection/base", ["jquery", "../utils", "../keys"], function (n, s, i) {
              function r(e, t) {
                  (this.$element = e), (this.options = t), r.__super__.constructor.call(this);
              }
              return (
                  s.Extend(r, s.Observable),
                  (r.prototype.render = function () {
                      var e = n('<span class="select2-selection" role="combobox"  aria-haspopup="true" aria-expanded="false"></span>');
                      return (
                          (this._tabindex = 0),
                          null != s.GetData(this.$element[0], "old-tabindex") ? (this._tabindex = s.GetData(this.$element[0], "old-tabindex")) : null != this.$element.attr("tabindex") && (this._tabindex = this.$element.attr("tabindex")),
                          e.attr("title", this.$element.attr("title")),
                          e.attr("tabindex", this._tabindex),
                          e.attr("aria-disabled", "false"),
                          (this.$selection = e)
                      );
                  }),
                  (r.prototype.bind = function (e, t) {
                      var n = this,
                          s = e.id + "-results";
                      (this.container = e),
                          this.$selection.on("focus", function (e) {
                              n.trigger("focus", e);
                          }),
                          this.$selection.on("blur", function (e) {
                              n._handleBlur(e);
                          }),
                          this.$selection.on("keydown", function (e) {
                              n.trigger("keypress", e), e.which === i.SPACE && e.preventDefault();
                          }),
                          e.on("results:focus", function (e) {
                              n.$selection.attr("aria-activedescendant", e.data._resultId);
                          }),
                          e.on("selection:update", function (e) {
                              n.update(e.data);
                          }),
                          e.on("open", function () {
                              n.$selection.attr("aria-expanded", "true"), n.$selection.attr("aria-owns", s), n._attachCloseHandler(e);
                          }),
                          e.on("close", function () {
                              n.$selection.attr("aria-expanded", "false"), n.$selection.removeAttr("aria-activedescendant"), n.$selection.removeAttr("aria-owns"), n.$selection.trigger("focus"), n._detachCloseHandler(e);
                          }),
                          e.on("enable", function () {
                              n.$selection.attr("tabindex", n._tabindex), n.$selection.attr("aria-disabled", "false");
                          }),
                          e.on("disable", function () {
                              n.$selection.attr("tabindex", "-1"), n.$selection.attr("aria-disabled", "true");
                          });
                  }),
                  (r.prototype._handleBlur = function (e) {
                      var t = this;
                      window.setTimeout(function () {
                          document.activeElement == t.$selection[0] || n.contains(t.$selection[0], document.activeElement) || t.trigger("blur", e);
                      }, 1);
                  }),
                  (r.prototype._attachCloseHandler = function (e) {
                      n(document.body).on("mousedown.select2." + e.id, function (e) {
                          var t = n(e.target).closest(".select2");
                          n(".select2.select2-container--open").each(function () {
                              this != t[0] && s.GetData(this, "element").select2("close");
                          });
                      });
                  }),
                  (r.prototype._detachCloseHandler = function (e) {
                      n(document.body).off("mousedown.select2." + e.id);
                  }),
                  (r.prototype.position = function (e, t) {
                      t.find(".selection").append(e);
                  }),
                  (r.prototype.destroy = function () {
                      this._detachCloseHandler(this.container);
                  }),
                  (r.prototype.update = function (e) {
                      throw new Error("The `update` method must be defined in child classes.");
                  }),
                  (r.prototype.isEnabled = function () {
                      return !this.isDisabled();
                  }),
                  (r.prototype.isDisabled = function () {
                      return this.options.get("disabled");
                  }),
                  r
              );
          }),
          u.define("select2/selection/single", ["jquery", "./base", "../utils", "../keys"], function (e, t, n, s) {
              function i() {
                  i.__super__.constructor.apply(this, arguments);
              }
              return (
                  n.Extend(i, t),
                  (i.prototype.render = function () {
                      var e = i.__super__.render.call(this);
                      return e[0].classList.add("select2-selection--single"), e.html('<span class="select2-selection__rendered"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>'), e;
                  }),
                  (i.prototype.bind = function (t, e) {
                      var n = this;
                      i.__super__.bind.apply(this, arguments);
                      var s = t.id + "-container";
                      this.$selection.find(".select2-selection__rendered").attr("id", s).attr("role", "textbox").attr("aria-readonly", "true"),
                          this.$selection.attr("aria-labelledby", s),
                          this.$selection.attr("aria-controls", s),
                          this.$selection.on("mousedown", function (e) {
                              1 === e.which && n.trigger("toggle", { originalEvent: e });
                          }),
                          this.$selection.on("focus", function (e) {}),
                          this.$selection.on("blur", function (e) {}),
                          t.on("focus", function (e) {
                              t.isOpen() || n.$selection.trigger("focus");
                          });
                  }),
                  (i.prototype.clear = function () {
                      var e = this.$selection.find(".select2-selection__rendered");
                      e.empty(), e.removeAttr("title");
                  }),
                  (i.prototype.display = function (e, t) {
                      var n = this.options.get("templateSelection");
                      return this.options.get("escapeMarkup")(n(e, t));
                  }),
                  (i.prototype.selectionContainer = function () {
                      return e("<span></span>");
                  }),
                  (i.prototype.update = function (e) {
                      var t, n;
                      0 !== e.length
                          ? ((n = e[0]), (t = this.$selection.find(".select2-selection__rendered")), (e = this.display(n, t)), t.empty().append(e), (n = n.title || n.text) ? t.attr("title", n) : t.removeAttr("title"))
                          : this.clear();
                  }),
                  i
              );
          }),
          u.define("select2/selection/multiple", ["jquery", "./base", "../utils"], function (i, e, c) {
              function r(e, t) {
                  r.__super__.constructor.apply(this, arguments);
              }
              return (
                  c.Extend(r, e),
                  (r.prototype.render = function () {
                      var e = r.__super__.render.call(this);
                      return e[0].classList.add("select2-selection--multiple"), e.html('<ul class="select2-selection__rendered"></ul>'), e;
                  }),
                  (r.prototype.bind = function (e, t) {
                      var n = this;
                      r.__super__.bind.apply(this, arguments);
                      var s = e.id + "-container";
                      this.$selection.find(".select2-selection__rendered").attr("id", s),
                          this.$selection.on("click", function (e) {
                              n.trigger("toggle", { originalEvent: e });
                          }),
                          this.$selection.on("click", ".select2-selection__choice__remove", function (e) {
                              var t;
                              n.isDisabled() || ((t = i(this).parent()), (t = c.GetData(t[0], "data")), n.trigger("unselect", { originalEvent: e, data: t }));
                          }),
                          this.$selection.on("keydown", ".select2-selection__choice__remove", function (e) {
                              n.isDisabled() || e.stopPropagation();
                          });
                  }),
                  (r.prototype.clear = function () {
                      var e = this.$selection.find(".select2-selection__rendered");
                      e.empty(), e.removeAttr("title");
                  }),
                  (r.prototype.display = function (e, t) {
                      var n = this.options.get("templateSelection");
                      return this.options.get("escapeMarkup")(n(e, t));
                  }),
                  (r.prototype.selectionContainer = function () {
                      return i(
                          '<li class="select2-selection__choice"><button type="button" class="select2-selection__choice__remove" tabindex="-1"><span aria-hidden="true">&times;</span></button><span class="select2-selection__choice__display"></span></li>'
                      );
                  }),
                  (r.prototype.update = function (e) {
                      if ((this.clear(), 0 !== e.length)) {
                          for (var t = [], n = this.$selection.find(".select2-selection__rendered").attr("id") + "-choice-", s = 0; s < e.length; s++) {
                              var i = e[s],
                                  r = this.selectionContainer(),
                                  o = this.display(i, r),
                                  a = n + c.generateChars(4) + "-";
                              i.id ? (a += i.id) : (a += c.generateChars(4)), r.find(".select2-selection__choice__display").append(o).attr("id", a);
                              var l = i.title || i.text;
                              l && r.attr("title", l);
                              (o = this.options.get("translations").get("removeItem")), (l = r.find(".select2-selection__choice__remove"));
                              l.attr("title", o()), l.attr("aria-label", o()), l.attr("aria-describedby", a), c.StoreData(r[0], "data", i), t.push(r);
                          }
                          this.$selection.find(".select2-selection__rendered").append(t);
                      }
                  }),
                  r
              );
          }),
          u.define("select2/selection/placeholder", [], function () {
              function e(e, t, n) {
                  (this.placeholder = this.normalizePlaceholder(n.get("placeholder"))), e.call(this, t, n);
              }
              return (
                  (e.prototype.normalizePlaceholder = function (e, t) {
                      return (t = "string" == typeof t ? { id: "", text: t } : t);
                  }),
                  (e.prototype.createPlaceholder = function (e, t) {
                      var n = this.selectionContainer();
                      n.html(this.display(t)), n[0].classList.add("select2-selection__placeholder"), n[0].classList.remove("select2-selection__choice");
                      t = t.title || t.text || n.text();
                      return this.$selection.find(".select2-selection__rendered").attr("title", t), n;
                  }),
                  (e.prototype.update = function (e, t) {
                      var n = 1 == t.length && t[0].id != this.placeholder.id;
                      if (1 < t.length || n) return e.call(this, t);
                      this.clear();
                      t = this.createPlaceholder(this.placeholder);
                      this.$selection.find(".select2-selection__rendered").append(t);
                  }),
                  e
              );
          }),
          u.define("select2/selection/allowClear", ["jquery", "../keys", "../utils"], function (i, s, a) {
              function e() {}
              return (
                  (e.prototype.bind = function (e, t, n) {
                      var s = this;
                      e.call(this, t, n),
                          null == this.placeholder && this.options.get("debug") && window.console && console.error && console.error("Select2: The `allowClear` option should be used in combination with the `placeholder` option."),
                          this.$selection.on("mousedown", ".select2-selection__clear", function (e) {
                              s._handleClear(e);
                          }),
                          t.on("keypress", function (e) {
                              s._handleKeyboardClear(e, t);
                          });
                  }),
                  (e.prototype._handleClear = function (e, t) {
                      if (!this.isDisabled()) {
                          var n = this.$selection.find(".select2-selection__clear");
                          if (0 !== n.length) {
                              t.stopPropagation();
                              var s = a.GetData(n[0], "data"),
                                  i = this.$element.val();
                              this.$element.val(this.placeholder.id);
                              var r = { data: s };
                              if ((this.trigger("clear", r), r.prevented)) this.$element.val(i);
                              else {
                                  for (var o = 0; o < s.length; o++) if (((r = { data: s[o] }), this.trigger("unselect", r), r.prevented)) return void this.$element.val(i);
                                  this.$element.trigger("input").trigger("change"), this.trigger("toggle", {});
                              }
                          }
                      }
                  }),
                  (e.prototype._handleKeyboardClear = function (e, t, n) {
                      n.isOpen() || (t.which != s.DELETE && t.which != s.BACKSPACE) || this._handleClear(t);
                  }),
                  (e.prototype.update = function (e, t) {
                      var n, s;
                      e.call(this, t),
                          this.$selection.find(".select2-selection__clear").remove(),
                          this.$selection[0].classList.remove("select2-selection--clearable"),
                          0 < this.$selection.find(".select2-selection__placeholder").length ||
                              0 === t.length ||
                              ((n = this.$selection.find(".select2-selection__rendered").attr("id")),
                              (s = this.options.get("translations").get("removeAllItems")),
                              (e = i('<button type="button" class="select2-selection__clear" tabindex="-1"><span aria-hidden="true">&times;</span></button>')).attr("title", s()),
                              e.attr("aria-label", s()),
                              e.attr("aria-describedby", n),
                              a.StoreData(e[0], "data", t),
                              this.$selection.prepend(e),
                              this.$selection[0].classList.add("select2-selection--clearable"));
                  }),
                  e
              );
          }),
          u.define("select2/selection/search", ["jquery", "../utils", "../keys"], function (s, a, l) {
              function e(e, t, n) {
                  e.call(this, t, n);
              }
              return (
                  (e.prototype.render = function (e) {
                      var t = this.options.get("translations").get("search"),
                          n = s(
                              '<span class="select2-search select2-search--inline"><textarea class="select2-search__field" type="search" tabindex="-1" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" ></textarea></span>'
                          );
                      (this.$searchContainer = n), (this.$search = n.find("textarea")), this.$search.prop("autocomplete", this.options.get("autocomplete")), this.$search.attr("aria-label", t());
                      e = e.call(this);
                      return this._transferTabIndex(), e.append(this.$searchContainer), e;
                  }),
                  (e.prototype.bind = function (e, t, n) {
                      var s = this,
                          i = t.id + "-results",
                          r = t.id + "-container";
                      e.call(this, t, n),
                          s.$search.attr("aria-describedby", r),
                          t.on("open", function () {
                              s.$search.attr("aria-controls", i), s.$search.trigger("focus");
                          }),
                          t.on("close", function () {
                              s.$search.val(""), s.resizeSearch(), s.$search.removeAttr("aria-controls"), s.$search.removeAttr("aria-activedescendant"), s.$search.trigger("focus");
                          }),
                          t.on("enable", function () {
                              s.$search.prop("disabled", !1), s._transferTabIndex();
                          }),
                          t.on("disable", function () {
                              s.$search.prop("disabled", !0);
                          }),
                          t.on("focus", function (e) {
                              s.$search.trigger("focus");
                          }),
                          t.on("results:focus", function (e) {
                              e.data._resultId ? s.$search.attr("aria-activedescendant", e.data._resultId) : s.$search.removeAttr("aria-activedescendant");
                          }),
                          this.$selection.on("focusin", ".select2-search--inline", function (e) {
                              s.trigger("focus", e);
                          }),
                          this.$selection.on("focusout", ".select2-search--inline", function (e) {
                              s._handleBlur(e);
                          }),
                          this.$selection.on("keydown", ".select2-search--inline", function (e) {
                              var t;
                              e.stopPropagation(),
                                  s.trigger("keypress", e),
                                  (s._keyUpPrevented = e.isDefaultPrevented()),
                                  e.which !== l.BACKSPACE ||
                                      "" !== s.$search.val() ||
                                      (0 < (t = s.$selection.find(".select2-selection__choice").last()).length && ((t = a.GetData(t[0], "data")), s.searchRemoveChoice(t), e.preventDefault()));
                          }),
                          this.$selection.on("click", ".select2-search--inline", function (e) {
                              s.$search.val() && e.stopPropagation();
                          });
                      var t = document.documentMode,
                          o = t && t <= 11;
                      this.$selection.on("input.searchcheck", ".select2-search--inline", function (e) {
                          o ? s.$selection.off("input.search input.searchcheck") : s.$selection.off("keyup.search");
                      }),
                          this.$selection.on("keyup.search input.search", ".select2-search--inline", function (e) {
                              var t;
                              o && "input" === e.type ? s.$selection.off("input.search input.searchcheck") : (t = e.which) != l.SHIFT && t != l.CTRL && t != l.ALT && t != l.TAB && s.handleSearch(e);
                          });
                  }),
                  (e.prototype._transferTabIndex = function (e) {
                      this.$search.attr("tabindex", this.$selection.attr("tabindex")), this.$selection.attr("tabindex", "-1");
                  }),
                  (e.prototype.createPlaceholder = function (e, t) {
                      this.$search.attr("placeholder", t.text);
                  }),
                  (e.prototype.update = function (e, t) {
                      var n = this.$search[0] == document.activeElement;
                      this.$search.attr("placeholder", ""), e.call(this, t), this.resizeSearch(), n && this.$search.trigger("focus");
                  }),
                  (e.prototype.handleSearch = function () {
                      var e;
                      this.resizeSearch(), this._keyUpPrevented || ((e = this.$search.val()), this.trigger("query", { term: e })), (this._keyUpPrevented = !1);
                  }),
                  (e.prototype.searchRemoveChoice = function (e, t) {
                      this.trigger("unselect", { data: t }), this.$search.val(t.text), this.handleSearch();
                  }),
                  (e.prototype.resizeSearch = function () {
                      this.$search.css("width", "25px");
                      var e = "100%";
                      "" === this.$search.attr("placeholder") && (e = 0.75 * (this.$search.val().length + 1) + "em"), this.$search.css("width", e);
                  }),
                  e
              );
          }),
          u.define("select2/selection/selectionCss", ["../utils"], function (n) {
              function e() {}
              return (
                  (e.prototype.render = function (e) {
                      var t = e.call(this),
                          e = this.options.get("selectionCssClass") || "";
                      return -1 !== e.indexOf(":all:") && ((e = e.replace(":all:", "")), n.copyNonInternalCssClasses(t[0], this.$element[0])), t.addClass(e), t;
                  }),
                  e
              );
          }),
          u.define("select2/selection/eventRelay", ["jquery"], function (o) {
              function e() {}
              return (
                  (e.prototype.bind = function (e, t, n) {
                      var s = this,
                          i = ["open", "opening", "close", "closing", "select", "selecting", "unselect", "unselecting", "clear", "clearing"],
                          r = ["opening", "closing", "selecting", "unselecting", "clearing"];
                      e.call(this, t, n),
                          t.on("*", function (e, t) {
                              var n;
                              -1 !== i.indexOf(e) && ((t = t || {}), (n = o.Event("select2:" + e, { params: t })), s.$element.trigger(n), -1 !== r.indexOf(e) && (t.prevented = n.isDefaultPrevented()));
                          });
                  }),
                  e
              );
          }),
          u.define("select2/translation", ["jquery", "require"], function (t, n) {
              function s(e) {
                  this.dict = e || {};
              }
              return (
                  (s.prototype.all = function () {
                      return this.dict;
                  }),
                  (s.prototype.get = function (e) {
                      return this.dict[e];
                  }),
                  (s.prototype.extend = function (e) {
                      this.dict = t.extend({}, e.all(), this.dict);
                  }),
                  (s._cache = {}),
                  (s.loadPath = function (e) {
                      var t;
                      return e in s._cache || ((t = n(e)), (s._cache[e] = t)), new s(s._cache[e]);
                  }),
                  s
              );
          }),
          u.define("select2/diacritics", [], function () {
              return {
                  "Ⓐ": "A",
                  Ａ: "A",
                  À: "A",
                  Á: "A",
                  Â: "A",
                  Ầ: "A",
                  Ấ: "A",
                  Ẫ: "A",
                  Ẩ: "A",
                  Ã: "A",
                  Ā: "A",
                  Ă: "A",
                  Ằ: "A",
                  Ắ: "A",
                  Ẵ: "A",
                  Ẳ: "A",
                  Ȧ: "A",
                  Ǡ: "A",
                  Ä: "A",
                  Ǟ: "A",
                  Ả: "A",
                  Å: "A",
                  Ǻ: "A",
                  Ǎ: "A",
                  Ȁ: "A",
                  Ȃ: "A",
                  Ạ: "A",
                  Ậ: "A",
                  Ặ: "A",
                  Ḁ: "A",
                  Ą: "A",
                  Ⱥ: "A",
                  Ɐ: "A",
                  Ꜳ: "AA",
                  Æ: "AE",
                  Ǽ: "AE",
                  Ǣ: "AE",
                  Ꜵ: "AO",
                  Ꜷ: "AU",
                  Ꜹ: "AV",
                  Ꜻ: "AV",
                  Ꜽ: "AY",
                  "Ⓑ": "B",
                  Ｂ: "B",
                  Ḃ: "B",
                  Ḅ: "B",
                  Ḇ: "B",
                  Ƀ: "B",
                  Ƃ: "B",
                  Ɓ: "B",
                  "Ⓒ": "C",
                  Ｃ: "C",
                  Ć: "C",
                  Ĉ: "C",
                  Ċ: "C",
                  Č: "C",
                  Ç: "C",
                  Ḉ: "C",
                  Ƈ: "C",
                  Ȼ: "C",
                  Ꜿ: "C",
                  "Ⓓ": "D",
                  Ｄ: "D",
                  Ḋ: "D",
                  Ď: "D",
                  Ḍ: "D",
                  Ḑ: "D",
                  Ḓ: "D",
                  Ḏ: "D",
                  Đ: "D",
                  Ƌ: "D",
                  Ɗ: "D",
                  Ɖ: "D",
                  Ꝺ: "D",
                  Ǳ: "DZ",
                  Ǆ: "DZ",
                  ǲ: "Dz",
                  ǅ: "Dz",
                  "Ⓔ": "E",
                  Ｅ: "E",
                  È: "E",
                  É: "E",
                  Ê: "E",
                  Ề: "E",
                  Ế: "E",
                  Ễ: "E",
                  Ể: "E",
                  Ẽ: "E",
                  Ē: "E",
                  Ḕ: "E",
                  Ḗ: "E",
                  Ĕ: "E",
                  Ė: "E",
                  Ë: "E",
                  Ẻ: "E",
                  Ě: "E",
                  Ȅ: "E",
                  Ȇ: "E",
                  Ẹ: "E",
                  Ệ: "E",
                  Ȩ: "E",
                  Ḝ: "E",
                  Ę: "E",
                  Ḙ: "E",
                  Ḛ: "E",
                  Ɛ: "E",
                  Ǝ: "E",
                  "Ⓕ": "F",
                  Ｆ: "F",
                  Ḟ: "F",
                  Ƒ: "F",
                  Ꝼ: "F",
                  "Ⓖ": "G",
                  Ｇ: "G",
                  Ǵ: "G",
                  Ĝ: "G",
                  Ḡ: "G",
                  Ğ: "G",
                  Ġ: "G",
                  Ǧ: "G",
                  Ģ: "G",
                  Ǥ: "G",
                  Ɠ: "G",
                  Ꞡ: "G",
                  Ᵹ: "G",
                  Ꝿ: "G",
                  "Ⓗ": "H",
                  Ｈ: "H",
                  Ĥ: "H",
                  Ḣ: "H",
                  Ḧ: "H",
                  Ȟ: "H",
                  Ḥ: "H",
                  Ḩ: "H",
                  Ḫ: "H",
                  Ħ: "H",
                  Ⱨ: "H",
                  Ⱶ: "H",
                  Ɥ: "H",
                  "Ⓘ": "I",
                  Ｉ: "I",
                  Ì: "I",
                  Í: "I",
                  Î: "I",
                  Ĩ: "I",
                  Ī: "I",
                  Ĭ: "I",
                  İ: "I",
                  Ï: "I",
                  Ḯ: "I",
                  Ỉ: "I",
                  Ǐ: "I",
                  Ȉ: "I",
                  Ȋ: "I",
                  Ị: "I",
                  Į: "I",
                  Ḭ: "I",
                  Ɨ: "I",
                  "Ⓙ": "J",
                  Ｊ: "J",
                  Ĵ: "J",
                  Ɉ: "J",
                  "Ⓚ": "K",
                  Ｋ: "K",
                  Ḱ: "K",
                  Ǩ: "K",
                  Ḳ: "K",
                  Ķ: "K",
                  Ḵ: "K",
                  Ƙ: "K",
                  Ⱪ: "K",
                  Ꝁ: "K",
                  Ꝃ: "K",
                  Ꝅ: "K",
                  Ꞣ: "K",
                  "Ⓛ": "L",
                  Ｌ: "L",
                  Ŀ: "L",
                  Ĺ: "L",
                  Ľ: "L",
                  Ḷ: "L",
                  Ḹ: "L",
                  Ļ: "L",
                  Ḽ: "L",
                  Ḻ: "L",
                  Ł: "L",
                  Ƚ: "L",
                  Ɫ: "L",
                  Ⱡ: "L",
                  Ꝉ: "L",
                  Ꝇ: "L",
                  Ꞁ: "L",
                  Ǉ: "LJ",
                  ǈ: "Lj",
                  "Ⓜ": "M",
                  Ｍ: "M",
                  Ḿ: "M",
                  Ṁ: "M",
                  Ṃ: "M",
                  Ɱ: "M",
                  Ɯ: "M",
                  "Ⓝ": "N",
                  Ｎ: "N",
                  Ǹ: "N",
                  Ń: "N",
                  Ñ: "N",
                  Ṅ: "N",
                  Ň: "N",
                  Ṇ: "N",
                  Ņ: "N",
                  Ṋ: "N",
                  Ṉ: "N",
                  Ƞ: "N",
                  Ɲ: "N",
                  Ꞑ: "N",
                  Ꞥ: "N",
                  Ǌ: "NJ",
                  ǋ: "Nj",
                  "Ⓞ": "O",
                  Ｏ: "O",
                  Ò: "O",
                  Ó: "O",
                  Ô: "O",
                  Ồ: "O",
                  Ố: "O",
                  Ỗ: "O",
                  Ổ: "O",
                  Õ: "O",
                  Ṍ: "O",
                  Ȭ: "O",
                  Ṏ: "O",
                  Ō: "O",
                  Ṑ: "O",
                  Ṓ: "O",
                  Ŏ: "O",
                  Ȯ: "O",
                  Ȱ: "O",
                  Ö: "O",
                  Ȫ: "O",
                  Ỏ: "O",
                  Ő: "O",
                  Ǒ: "O",
                  Ȍ: "O",
                  Ȏ: "O",
                  Ơ: "O",
                  Ờ: "O",
                  Ớ: "O",
                  Ỡ: "O",
                  Ở: "O",
                  Ợ: "O",
                  Ọ: "O",
                  Ộ: "O",
                  Ǫ: "O",
                  Ǭ: "O",
                  Ø: "O",
                  Ǿ: "O",
                  Ɔ: "O",
                  Ɵ: "O",
                  Ꝋ: "O",
                  Ꝍ: "O",
                  Œ: "OE",
                  Ƣ: "OI",
                  Ꝏ: "OO",
                  Ȣ: "OU",
                  "Ⓟ": "P",
                  Ｐ: "P",
                  Ṕ: "P",
                  Ṗ: "P",
                  Ƥ: "P",
                  Ᵽ: "P",
                  Ꝑ: "P",
                  Ꝓ: "P",
                  Ꝕ: "P",
                  "Ⓠ": "Q",
                  Ｑ: "Q",
                  Ꝗ: "Q",
                  Ꝙ: "Q",
                  Ɋ: "Q",
                  "Ⓡ": "R",
                  Ｒ: "R",
                  Ŕ: "R",
                  Ṙ: "R",
                  Ř: "R",
                  Ȑ: "R",
                  Ȓ: "R",
                  Ṛ: "R",
                  Ṝ: "R",
                  Ŗ: "R",
                  Ṟ: "R",
                  Ɍ: "R",
                  Ɽ: "R",
                  Ꝛ: "R",
                  Ꞧ: "R",
                  Ꞃ: "R",
                  "Ⓢ": "S",
                  Ｓ: "S",
                  ẞ: "S",
                  Ś: "S",
                  Ṥ: "S",
                  Ŝ: "S",
                  Ṡ: "S",
                  Š: "S",
                  Ṧ: "S",
                  Ṣ: "S",
                  Ṩ: "S",
                  Ș: "S",
                  Ş: "S",
                  Ȿ: "S",
                  Ꞩ: "S",
                  Ꞅ: "S",
                  "Ⓣ": "T",
                  Ｔ: "T",
                  Ṫ: "T",
                  Ť: "T",
                  Ṭ: "T",
                  Ț: "T",
                  Ţ: "T",
                  Ṱ: "T",
                  Ṯ: "T",
                  Ŧ: "T",
                  Ƭ: "T",
                  Ʈ: "T",
                  Ⱦ: "T",
                  Ꞇ: "T",
                  Ꜩ: "TZ",
                  "Ⓤ": "U",
                  Ｕ: "U",
                  Ù: "U",
                  Ú: "U",
                  Û: "U",
                  Ũ: "U",
                  Ṹ: "U",
                  Ū: "U",
                  Ṻ: "U",
                  Ŭ: "U",
                  Ü: "U",
                  Ǜ: "U",
                  Ǘ: "U",
                  Ǖ: "U",
                  Ǚ: "U",
                  Ủ: "U",
                  Ů: "U",
                  Ű: "U",
                  Ǔ: "U",
                  Ȕ: "U",
                  Ȗ: "U",
                  Ư: "U",
                  Ừ: "U",
                  Ứ: "U",
                  Ữ: "U",
                  Ử: "U",
                  Ự: "U",
                  Ụ: "U",
                  Ṳ: "U",
                  Ų: "U",
                  Ṷ: "U",
                  Ṵ: "U",
                  Ʉ: "U",
                  "Ⓥ": "V",
                  Ｖ: "V",
                  Ṽ: "V",
                  Ṿ: "V",
                  Ʋ: "V",
                  Ꝟ: "V",
                  Ʌ: "V",
                  Ꝡ: "VY",
                  "Ⓦ": "W",
                  Ｗ: "W",
                  Ẁ: "W",
                  Ẃ: "W",
                  Ŵ: "W",
                  Ẇ: "W",
                  Ẅ: "W",
                  Ẉ: "W",
                  Ⱳ: "W",
                  "Ⓧ": "X",
                  Ｘ: "X",
                  Ẋ: "X",
                  Ẍ: "X",
                  "Ⓨ": "Y",
                  Ｙ: "Y",
                  Ỳ: "Y",
                  Ý: "Y",
                  Ŷ: "Y",
                  Ỹ: "Y",
                  Ȳ: "Y",
                  Ẏ: "Y",
                  Ÿ: "Y",
                  Ỷ: "Y",
                  Ỵ: "Y",
                  Ƴ: "Y",
                  Ɏ: "Y",
                  Ỿ: "Y",
                  "Ⓩ": "Z",
                  Ｚ: "Z",
                  Ź: "Z",
                  Ẑ: "Z",
                  Ż: "Z",
                  Ž: "Z",
                  Ẓ: "Z",
                  Ẕ: "Z",
                  Ƶ: "Z",
                  Ȥ: "Z",
                  Ɀ: "Z",
                  Ⱬ: "Z",
                  Ꝣ: "Z",
                  "ⓐ": "a",
                  ａ: "a",
                  ẚ: "a",
                  à: "a",
                  á: "a",
                  â: "a",
                  ầ: "a",
                  ấ: "a",
                  ẫ: "a",
                  ẩ: "a",
                  ã: "a",
                  ā: "a",
                  ă: "a",
                  ằ: "a",
                  ắ: "a",
                  ẵ: "a",
                  ẳ: "a",
                  ȧ: "a",
                  ǡ: "a",
                  ä: "a",
                  ǟ: "a",
                  ả: "a",
                  å: "a",
                  ǻ: "a",
                  ǎ: "a",
                  ȁ: "a",
                  ȃ: "a",
                  ạ: "a",
                  ậ: "a",
                  ặ: "a",
                  ḁ: "a",
                  ą: "a",
                  ⱥ: "a",
                  ɐ: "a",
                  ꜳ: "aa",
                  æ: "ae",
                  ǽ: "ae",
                  ǣ: "ae",
                  ꜵ: "ao",
                  ꜷ: "au",
                  ꜹ: "av",
                  ꜻ: "av",
                  ꜽ: "ay",
                  "ⓑ": "b",
                  ｂ: "b",
                  ḃ: "b",
                  ḅ: "b",
                  ḇ: "b",
                  ƀ: "b",
                  ƃ: "b",
                  ɓ: "b",
                  "ⓒ": "c",
                  ｃ: "c",
                  ć: "c",
                  ĉ: "c",
                  ċ: "c",
                  č: "c",
                  ç: "c",
                  ḉ: "c",
                  ƈ: "c",
                  ȼ: "c",
                  ꜿ: "c",
                  ↄ: "c",
                  "ⓓ": "d",
                  ｄ: "d",
                  ḋ: "d",
                  ď: "d",
                  ḍ: "d",
                  ḑ: "d",
                  ḓ: "d",
                  ḏ: "d",
                  đ: "d",
                  ƌ: "d",
                  ɖ: "d",
                  ɗ: "d",
                  ꝺ: "d",
                  ǳ: "dz",
                  ǆ: "dz",
                  "ⓔ": "e",
                  ｅ: "e",
                  è: "e",
                  é: "e",
                  ê: "e",
                  ề: "e",
                  ế: "e",
                  ễ: "e",
                  ể: "e",
                  ẽ: "e",
                  ē: "e",
                  ḕ: "e",
                  ḗ: "e",
                  ĕ: "e",
                  ė: "e",
                  ë: "e",
                  ẻ: "e",
                  ě: "e",
                  ȅ: "e",
                  ȇ: "e",
                  ẹ: "e",
                  ệ: "e",
                  ȩ: "e",
                  ḝ: "e",
                  ę: "e",
                  ḙ: "e",
                  ḛ: "e",
                  ɇ: "e",
                  ɛ: "e",
                  ǝ: "e",
                  "ⓕ": "f",
                  ｆ: "f",
                  ḟ: "f",
                  ƒ: "f",
                  ꝼ: "f",
                  "ⓖ": "g",
                  ｇ: "g",
                  ǵ: "g",
                  ĝ: "g",
                  ḡ: "g",
                  ğ: "g",
                  ġ: "g",
                  ǧ: "g",
                  ģ: "g",
                  ǥ: "g",
                  ɠ: "g",
                  ꞡ: "g",
                  ᵹ: "g",
                  ꝿ: "g",
                  "ⓗ": "h",
                  ｈ: "h",
                  ĥ: "h",
                  ḣ: "h",
                  ḧ: "h",
                  ȟ: "h",
                  ḥ: "h",
                  ḩ: "h",
                  ḫ: "h",
                  ẖ: "h",
                  ħ: "h",
                  ⱨ: "h",
                  ⱶ: "h",
                  ɥ: "h",
                  ƕ: "hv",
                  "ⓘ": "i",
                  ｉ: "i",
                  ì: "i",
                  í: "i",
                  î: "i",
                  ĩ: "i",
                  ī: "i",
                  ĭ: "i",
                  ï: "i",
                  ḯ: "i",
                  ỉ: "i",
                  ǐ: "i",
                  ȉ: "i",
                  ȋ: "i",
                  ị: "i",
                  į: "i",
                  ḭ: "i",
                  ɨ: "i",
                  ı: "i",
                  "ⓙ": "j",
                  ｊ: "j",
                  ĵ: "j",
                  ǰ: "j",
                  ɉ: "j",
                  "ⓚ": "k",
                  ｋ: "k",
                  ḱ: "k",
                  ǩ: "k",
                  ḳ: "k",
                  ķ: "k",
                  ḵ: "k",
                  ƙ: "k",
                  ⱪ: "k",
                  ꝁ: "k",
                  ꝃ: "k",
                  ꝅ: "k",
                  ꞣ: "k",
                  "ⓛ": "l",
                  ｌ: "l",
                  ŀ: "l",
                  ĺ: "l",
                  ľ: "l",
                  ḷ: "l",
                  ḹ: "l",
                  ļ: "l",
                  ḽ: "l",
                  ḻ: "l",
                  ſ: "l",
                  ł: "l",
                  ƚ: "l",
                  ɫ: "l",
                  ⱡ: "l",
                  ꝉ: "l",
                  ꞁ: "l",
                  ꝇ: "l",
                  ǉ: "lj",
                  "ⓜ": "m",
                  ｍ: "m",
                  ḿ: "m",
                  ṁ: "m",
                  ṃ: "m",
                  ɱ: "m",
                  ɯ: "m",
                  "ⓝ": "n",
                  ｎ: "n",
                  ǹ: "n",
                  ń: "n",
                  ñ: "n",
                  ṅ: "n",
                  ň: "n",
                  ṇ: "n",
                  ņ: "n",
                  ṋ: "n",
                  ṉ: "n",
                  ƞ: "n",
                  ɲ: "n",
                  ŉ: "n",
                  ꞑ: "n",
                  ꞥ: "n",
                  ǌ: "nj",
                  "ⓞ": "o",
                  ｏ: "o",
                  ò: "o",
                  ó: "o",
                  ô: "o",
                  ồ: "o",
                  ố: "o",
                  ỗ: "o",
                  ổ: "o",
                  õ: "o",
                  ṍ: "o",
                  ȭ: "o",
                  ṏ: "o",
                  ō: "o",
                  ṑ: "o",
                  ṓ: "o",
                  ŏ: "o",
                  ȯ: "o",
                  ȱ: "o",
                  ö: "o",
                  ȫ: "o",
                  ỏ: "o",
                  ő: "o",
                  ǒ: "o",
                  ȍ: "o",
                  ȏ: "o",
                  ơ: "o",
                  ờ: "o",
                  ớ: "o",
                  ỡ: "o",
                  ở: "o",
                  ợ: "o",
                  ọ: "o",
                  ộ: "o",
                  ǫ: "o",
                  ǭ: "o",
                  ø: "o",
                  ǿ: "o",
                  ɔ: "o",
                  ꝋ: "o",
                  ꝍ: "o",
                  ɵ: "o",
                  œ: "oe",
                  ƣ: "oi",
                  ȣ: "ou",
                  ꝏ: "oo",
                  "ⓟ": "p",
                  ｐ: "p",
                  ṕ: "p",
                  ṗ: "p",
                  ƥ: "p",
                  ᵽ: "p",
                  ꝑ: "p",
                  ꝓ: "p",
                  ꝕ: "p",
                  "ⓠ": "q",
                  ｑ: "q",
                  ɋ: "q",
                  ꝗ: "q",
                  ꝙ: "q",
                  "ⓡ": "r",
                  ｒ: "r",
                  ŕ: "r",
                  ṙ: "r",
                  ř: "r",
                  ȑ: "r",
                  ȓ: "r",
                  ṛ: "r",
                  ṝ: "r",
                  ŗ: "r",
                  ṟ: "r",
                  ɍ: "r",
                  ɽ: "r",
                  ꝛ: "r",
                  ꞧ: "r",
                  ꞃ: "r",
                  "ⓢ": "s",
                  ｓ: "s",
                  ß: "s",
                  ś: "s",
                  ṥ: "s",
                  ŝ: "s",
                  ṡ: "s",
                  š: "s",
                  ṧ: "s",
                  ṣ: "s",
                  ṩ: "s",
                  ș: "s",
                  ş: "s",
                  ȿ: "s",
                  ꞩ: "s",
                  ꞅ: "s",
                  ẛ: "s",
                  "ⓣ": "t",
                  ｔ: "t",
                  ṫ: "t",
                  ẗ: "t",
                  ť: "t",
                  ṭ: "t",
                  ț: "t",
                  ţ: "t",
                  ṱ: "t",
                  ṯ: "t",
                  ŧ: "t",
                  ƭ: "t",
                  ʈ: "t",
                  ⱦ: "t",
                  ꞇ: "t",
                  ꜩ: "tz",
                  "ⓤ": "u",
                  ｕ: "u",
                  ù: "u",
                  ú: "u",
                  û: "u",
                  ũ: "u",
                  ṹ: "u",
                  ū: "u",
                  ṻ: "u",
                  ŭ: "u",
                  ü: "u",
                  ǜ: "u",
                  ǘ: "u",
                  ǖ: "u",
                  ǚ: "u",
                  ủ: "u",
                  ů: "u",
                  ű: "u",
                  ǔ: "u",
                  ȕ: "u",
                  ȗ: "u",
                  ư: "u",
                  ừ: "u",
                  ứ: "u",
                  ữ: "u",
                  ử: "u",
                  ự: "u",
                  ụ: "u",
                  ṳ: "u",
                  ų: "u",
                  ṷ: "u",
                  ṵ: "u",
                  ʉ: "u",
                  "ⓥ": "v",
                  ｖ: "v",
                  ṽ: "v",
                  ṿ: "v",
                  ʋ: "v",
                  ꝟ: "v",
                  ʌ: "v",
                  ꝡ: "vy",
                  "ⓦ": "w",
                  ｗ: "w",
                  ẁ: "w",
                  ẃ: "w",
                  ŵ: "w",
                  ẇ: "w",
                  ẅ: "w",
                  ẘ: "w",
                  ẉ: "w",
                  ⱳ: "w",
                  "ⓧ": "x",
                  ｘ: "x",
                  ẋ: "x",
                  ẍ: "x",
                  "ⓨ": "y",
                  ｙ: "y",
                  ỳ: "y",
                  ý: "y",
                  ŷ: "y",
                  ỹ: "y",
                  ȳ: "y",
                  ẏ: "y",
                  ÿ: "y",
                  ỷ: "y",
                  ẙ: "y",
                  ỵ: "y",
                  ƴ: "y",
                  ɏ: "y",
                  ỿ: "y",
                  "ⓩ": "z",
                  ｚ: "z",
                  ź: "z",
                  ẑ: "z",
                  ż: "z",
                  ž: "z",
                  ẓ: "z",
                  ẕ: "z",
                  ƶ: "z",
                  ȥ: "z",
                  ɀ: "z",
                  ⱬ: "z",
                  ꝣ: "z",
                  Ά: "Α",
                  Έ: "Ε",
                  Ή: "Η",
                  Ί: "Ι",
                  Ϊ: "Ι",
                  Ό: "Ο",
                  Ύ: "Υ",
                  Ϋ: "Υ",
                  Ώ: "Ω",
                  ά: "α",
                  έ: "ε",
                  ή: "η",
                  ί: "ι",
                  ϊ: "ι",
                  ΐ: "ι",
                  ό: "ο",
                  ύ: "υ",
                  ϋ: "υ",
                  ΰ: "υ",
                  ώ: "ω",
                  ς: "σ",
                  "’": "'",
              };
          }),
          u.define("select2/data/base", ["../utils"], function (n) {
              function s(e, t) {
                  s.__super__.constructor.call(this);
              }
              return (
                  n.Extend(s, n.Observable),
                  (s.prototype.current = function (e) {
                      throw new Error("The `current` method must be defined in child classes.");
                  }),
                  (s.prototype.query = function (e, t) {
                      throw new Error("The `query` method must be defined in child classes.");
                  }),
                  (s.prototype.bind = function (e, t) {}),
                  (s.prototype.destroy = function () {}),
                  (s.prototype.generateResultId = function (e, t) {
                      e = e.id + "-result-";
                      return (e += n.generateChars(4)), null != t.id ? (e += "-" + t.id.toString()) : (e += "-" + n.generateChars(4)), e;
                  }),
                  s
              );
          }),
          u.define("select2/data/select", ["./base", "../utils", "jquery"], function (e, a, l) {
              function n(e, t) {
                  (this.$element = e), (this.options = t), n.__super__.constructor.call(this);
              }
              return (
                  a.Extend(n, e),
                  (n.prototype.current = function (e) {
                      var t = this;
                      e(
                          Array.prototype.map.call(this.$element[0].querySelectorAll(":checked"), function (e) {
                              return t.item(l(e));
                          })
                      );
                  }),
                  (n.prototype.select = function (i) {
                      var e,
                          r = this;
                      if (((i.selected = !0), null != i.element && "option" === i.element.tagName.toLowerCase())) return (i.element.selected = !0), void this.$element.trigger("input").trigger("change");
                      this.$element.prop("multiple")
                          ? this.current(function (e) {
                                var t = [];
                                (i = [i]).push.apply(i, e);
                                for (var n = 0; n < i.length; n++) {
                                    var s = i[n].id;
                                    -1 === t.indexOf(s) && t.push(s);
                                }
                                r.$element.val(t), r.$element.trigger("input").trigger("change");
                            })
                          : ((e = i.id), this.$element.val(e), this.$element.trigger("input").trigger("change"));
                  }),
                  (n.prototype.unselect = function (i) {
                      var r = this;
                      if (this.$element.prop("multiple")) {
                          if (((i.selected = !1), null != i.element && "option" === i.element.tagName.toLowerCase())) return (i.element.selected = !1), void this.$element.trigger("input").trigger("change");
                          this.current(function (e) {
                              for (var t = [], n = 0; n < e.length; n++) {
                                  var s = e[n].id;
                                  s !== i.id && -1 === t.indexOf(s) && t.push(s);
                              }
                              r.$element.val(t), r.$element.trigger("input").trigger("change");
                          });
                      }
                  }),
                  (n.prototype.bind = function (e, t) {
                      var n = this;
                      (this.container = e).on("select", function (e) {
                          n.select(e.data);
                      }),
                          e.on("unselect", function (e) {
                              n.unselect(e.data);
                          });
                  }),
                  (n.prototype.destroy = function () {
                      this.$element.find("*").each(function () {
                          a.RemoveData(this);
                      });
                  }),
                  (n.prototype.query = function (t, e) {
                      var n = [],
                          s = this;
                      this.$element.children().each(function () {
                          var e;
                          ("option" !== this.tagName.toLowerCase() && "optgroup" !== this.tagName.toLowerCase()) || ((e = l(this)), (e = s.item(e)), null !== (e = s.matches(t, e)) && n.push(e));
                      }),
                          e({ results: n });
                  }),
                  (n.prototype.addOptions = function (e) {
                      this.$element.append(e);
                  }),
                  (n.prototype.option = function (e) {
                      var t;
                      e.children ? ((t = document.createElement("optgroup")).label = e.text) : void 0 !== (t = document.createElement("option")).textContent ? (t.textContent = e.text) : (t.innerText = e.text),
                          void 0 !== e.id && (t.value = e.id),
                          e.disabled && (t.disabled = !0),
                          e.selected && (t.selected = !0),
                          e.title && (t.title = e.title);
                      e = this._normalizeItem(e);
                      return (e.element = t), a.StoreData(t, "data", e), l(t);
                  }),
                  (n.prototype.item = function (e) {
                      var t = {};
                      if (null != (t = a.GetData(e[0], "data"))) return t;
                      var n = e[0];
                      if ("option" === n.tagName.toLowerCase()) t = { id: e.val(), text: e.text(), disabled: e.prop("disabled"), selected: e.prop("selected"), title: e.prop("title") };
                      else if ("optgroup" === n.tagName.toLowerCase()) {
                          t = { text: e.prop("label"), children: [], title: e.prop("title") };
                          for (var s = e.children("option"), i = [], r = 0; r < s.length; r++) {
                              var o = l(s[r]),
                                  o = this.item(o);
                              i.push(o);
                          }
                          t.children = i;
                      }
                      return ((t = this._normalizeItem(t)).element = e[0]), a.StoreData(e[0], "data", t), t;
                  }),
                  (n.prototype._normalizeItem = function (e) {
                      e !== Object(e) && (e = { id: e, text: e });
                      return (
                          null != (e = l.extend({}, { text: "" }, e)).id && (e.id = e.id.toString()),
                          null != e.text && (e.text = e.text.toString()),
                          null == e._resultId && e.id && null != this.container && (e._resultId = this.generateResultId(this.container, e)),
                          l.extend({}, { selected: !1, disabled: !1 }, e)
                      );
                  }),
                  (n.prototype.matches = function (e, t) {
                      return this.options.get("matcher")(e, t);
                  }),
                  n
              );
          }),
          u.define("select2/data/array", ["./select", "../utils", "jquery"], function (e, t, c) {
              function s(e, t) {
                  (this._dataToConvert = t.get("data") || []), s.__super__.constructor.call(this, e, t);
              }
              return (
                  t.Extend(s, e),
                  (s.prototype.bind = function (e, t) {
                      s.__super__.bind.call(this, e, t), this.addOptions(this.convertToOptions(this._dataToConvert));
                  }),
                  (s.prototype.select = function (n) {
                      var e = this.$element.find("option").filter(function (e, t) {
                          return t.value == n.id.toString();
                      });
                      0 === e.length && ((e = this.option(n)), this.addOptions(e)), s.__super__.select.call(this, n);
                  }),
                  (s.prototype.convertToOptions = function (e) {
                      var t = this,
                          n = this.$element.find("option"),
                          s = n
                              .map(function () {
                                  return t.item(c(this)).id;
                              })
                              .get(),
                          i = [];
                      for (var r = 0; r < e.length; r++) {
                          var o,
                              a,
                              l = this._normalizeItem(e[r]);
                          0 <= s.indexOf(l.id)
                              ? ((o = n.filter(
                                    (function (e) {
                                        return function () {
                                            return c(this).val() == e.id;
                                        };
                                    })(l)
                                )),
                                (a = this.item(o)),
                                (a = c.extend(!0, {}, l, a)),
                                (a = this.option(a)),
                                o.replaceWith(a))
                              : ((a = this.option(l)), l.children && ((l = this.convertToOptions(l.children)), a.append(l)), i.push(a));
                      }
                      return i;
                  }),
                  s
              );
          }),
          u.define("select2/data/ajax", ["./array", "../utils", "jquery"], function (e, t, r) {
              function n(e, t) {
                  (this.ajaxOptions = this._applyDefaults(t.get("ajax"))), null != this.ajaxOptions.processResults && (this.processResults = this.ajaxOptions.processResults), n.__super__.constructor.call(this, e, t);
              }
              return (
                  t.Extend(n, e),
                  (n.prototype._applyDefaults = function (e) {
                      var t = {
                          data: function (e) {
                              return r.extend({}, e, { q: e.term });
                          },
                          transport: function (e, t, n) {
                              e = r.ajax(e);
                              return e.then(t), e.fail(n), e;
                          },
                      };
                      return r.extend({}, t, e, !0);
                  }),
                  (n.prototype.processResults = function (e) {
                      return e;
                  }),
                  (n.prototype.query = function (t, n) {
                      var s = this;
                      null != this._request && ("function" == typeof this._request.abort && this._request.abort(), (this._request = null));
                      var i = r.extend({ type: "GET" }, this.ajaxOptions);
                      function e() {
                          var e = i.transport(
                              i,
                              function (e) {
                                  e = s.processResults(e, t);
                                  s.options.get("debug") &&
                                      window.console &&
                                      console.error &&
                                      ((e && e.results && Array.isArray(e.results)) || console.error("Select2: The AJAX results did not return an array in the `results` key of the response.")),
                                      n(e);
                              },
                              function () {
                                  ("status" in e && (0 === e.status || "0" === e.status)) || s.trigger("results:message", { message: "errorLoading" });
                              }
                          );
                          s._request = e;
                      }
                      "function" == typeof i.url && (i.url = i.url.call(this.$element, t)),
                          "function" == typeof i.data && (i.data = i.data.call(this.$element, t)),
                          this.ajaxOptions.delay && null != t.term ? (this._queryTimeout && window.clearTimeout(this._queryTimeout), (this._queryTimeout = window.setTimeout(e, this.ajaxOptions.delay))) : e();
                  }),
                  n
              );
          }),
          u.define("select2/data/tags", ["jquery"], function (t) {
              function e(e, t, n) {
                  var s = n.get("tags"),
                      i = n.get("createTag");
                  void 0 !== i && (this.createTag = i);
                  i = n.get("insertTag");
                  if ((void 0 !== i && (this.insertTag = i), e.call(this, t, n), Array.isArray(s)))
                      for (var r = 0; r < s.length; r++) {
                          var o = s[r],
                              o = this._normalizeItem(o),
                              o = this.option(o);
                          this.$element.append(o);
                      }
              }
              return (
                  (e.prototype.query = function (e, c, u) {
                      var d = this;
                      this._removeOldTags(),
                          null != c.term && null == c.page
                              ? e.call(this, c, function e(t, n) {
                                    for (var s = t.results, i = 0; i < s.length; i++) {
                                        var r = s[i],
                                            o = null != r.children && !e({ results: r.children }, !0);
                                        if ((r.text || "").toUpperCase() === (c.term || "").toUpperCase() || o) return !n && ((t.data = s), void u(t));
                                    }
                                    if (n) return !0;
                                    var a,
                                        l = d.createTag(c);
                                    null != l && ((a = d.option(l)).attr("data-select2-tag", "true"), d.addOptions([a]), d.insertTag(s, l)), (t.results = s), u(t);
                                })
                              : e.call(this, c, u);
                  }),
                  (e.prototype.createTag = function (e, t) {
                      if (null == t.term) return null;
                      t = t.term.trim();
                      return "" === t ? null : { id: t, text: t };
                  }),
                  (e.prototype.insertTag = function (e, t, n) {
                      t.unshift(n);
                  }),
                  (e.prototype._removeOldTags = function (e) {
                      this.$element.find("option[data-select2-tag]").each(function () {
                          this.selected || t(this).remove();
                      });
                  }),
                  e
              );
          }),
          u.define("select2/data/tokenizer", ["jquery"], function (c) {
              function e(e, t, n) {
                  var s = n.get("tokenizer");
                  void 0 !== s && (this.tokenizer = s), e.call(this, t, n);
              }
              return (
                  (e.prototype.bind = function (e, t, n) {
                      e.call(this, t, n), (this.$search = t.dropdown.$search || t.selection.$search || n.find(".select2-search__field"));
                  }),
                  (e.prototype.query = function (e, t, n) {
                      var s = this;
                      t.term = t.term || "";
                      var i = this.tokenizer(t, this.options, function (e) {
                          var t,
                              n = s._normalizeItem(e);
                          s.$element.find("option").filter(function () {
                              return c(this).val() === n.id;
                          }).length || ((t = s.option(n)).attr("data-select2-tag", !0), s._removeOldTags(), s.addOptions([t])),
                              (t = n),
                              s.trigger("select", { data: t });
                      });
                      i.term !== t.term && (this.$search.length && (this.$search.val(i.term), this.$search.trigger("focus")), (t.term = i.term)), e.call(this, t, n);
                  }),
                  (e.prototype.tokenizer = function (e, t, n, s) {
                      for (
                          var i = n.get("tokenSeparators") || [],
                              r = t.term,
                              o = 0,
                              a =
                                  this.createTag ||
                                  function (e) {
                                      return { id: e.term, text: e.term };
                                  };
                          o < r.length;

                      ) {
                          var l = r[o];
                          -1 !== i.indexOf(l) ? ((l = r.substr(0, o)), null != (l = a(c.extend({}, t, { term: l }))) ? (s(l), (r = r.substr(o + 1) || ""), (o = 0)) : o++) : o++;
                      }
                      return { term: r };
                  }),
                  e
              );
          }),
          u.define("select2/data/minimumInputLength", [], function () {
              function e(e, t, n) {
                  (this.minimumInputLength = n.get("minimumInputLength")), e.call(this, t, n);
              }
              return (
                  (e.prototype.query = function (e, t, n) {
                      (t.term = t.term || ""),
                          t.term.length < this.minimumInputLength ? this.trigger("results:message", { message: "inputTooShort", args: { minimum: this.minimumInputLength, input: t.term, params: t } }) : e.call(this, t, n);
                  }),
                  e
              );
          }),
          u.define("select2/data/maximumInputLength", [], function () {
              function e(e, t, n) {
                  (this.maximumInputLength = n.get("maximumInputLength")), e.call(this, t, n);
              }
              return (
                  (e.prototype.query = function (e, t, n) {
                      (t.term = t.term || ""),
                          0 < this.maximumInputLength && t.term.length > this.maximumInputLength
                              ? this.trigger("results:message", { message: "inputTooLong", args: { maximum: this.maximumInputLength, input: t.term, params: t } })
                              : e.call(this, t, n);
                  }),
                  e
              );
          }),
          u.define("select2/data/maximumSelectionLength", [], function () {
              function e(e, t, n) {
                  (this.maximumSelectionLength = n.get("maximumSelectionLength")), e.call(this, t, n);
              }
              return (
                  (e.prototype.bind = function (e, t, n) {
                      var s = this;
                      e.call(this, t, n),
                          t.on("select", function () {
                              s._checkIfMaximumSelected();
                          });
                  }),
                  (e.prototype.query = function (e, t, n) {
                      var s = this;
                      this._checkIfMaximumSelected(function () {
                          e.call(s, t, n);
                      });
                  }),
                  (e.prototype._checkIfMaximumSelected = function (e, t) {
                      var n = this;
                      this.current(function (e) {
                          e = null != e ? e.length : 0;
                          0 < n.maximumSelectionLength && e >= n.maximumSelectionLength ? n.trigger("results:message", { message: "maximumSelected", args: { maximum: n.maximumSelectionLength } }) : t && t();
                      });
                  }),
                  e
              );
          }),
          u.define("select2/dropdown", ["jquery", "./utils"], function (t, e) {
              function n(e, t) {
                  (this.$element = e), (this.options = t), n.__super__.constructor.call(this);
              }
              return (
                  e.Extend(n, e.Observable),
                  (n.prototype.render = function () {
                      var e = t('<span class="select2-dropdown"><span class="select2-results"></span></span>');
                      return e.attr("dir", this.options.get("dir")), (this.$dropdown = e);
                  }),
                  (n.prototype.bind = function () {}),
                  (n.prototype.position = function (e, t) {}),
                  (n.prototype.destroy = function () {
                      this.$dropdown.remove();
                  }),
                  n
              );
          }),
          u.define("select2/dropdown/search", ["jquery"], function (r) {
              function e() {}
              return (
                  (e.prototype.render = function (e) {
                      var t = e.call(this),
                          n = this.options.get("translations").get("search"),
                          e = r(
                              '<span class="select2-search select2-search--dropdown"><input class="select2-search__field" type="search" tabindex="-1" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" /></span>'
                          );
                      return (this.$searchContainer = e), (this.$search = e.find("input")), this.$search.prop("autocomplete", this.options.get("autocomplete")), this.$search.attr("aria-label", n()), t.prepend(e), t;
                  }),
                  (e.prototype.bind = function (e, t, n) {
                      var s = this,
                          i = t.id + "-results";
                      e.call(this, t, n),
                          this.$search.on("keydown", function (e) {
                              s.trigger("keypress", e), (s._keyUpPrevented = e.isDefaultPrevented());
                          }),
                          this.$search.on("input", function (e) {
                              r(this).off("keyup");
                          }),
                          this.$search.on("keyup input", function (e) {
                              s.handleSearch(e);
                          }),
                          t.on("open", function () {
                              s.$search.attr("tabindex", 0),
                                  s.$search.attr("aria-controls", i),
                                  s.$search.trigger("focus"),
                                  window.setTimeout(function () {
                                      s.$search.trigger("focus");
                                  }, 0);
                          }),
                          t.on("close", function () {
                              s.$search.attr("tabindex", -1), s.$search.removeAttr("aria-controls"), s.$search.removeAttr("aria-activedescendant"), s.$search.val(""), s.$search.trigger("blur");
                          }),
                          t.on("focus", function () {
                              t.isOpen() || s.$search.trigger("focus");
                          }),
                          t.on("results:all", function (e) {
                              (null != e.query.term && "" !== e.query.term) || (s.showSearch(e) ? s.$searchContainer[0].classList.remove("select2-search--hide") : s.$searchContainer[0].classList.add("select2-search--hide"));
                          }),
                          t.on("results:focus", function (e) {
                              e.data._resultId ? s.$search.attr("aria-activedescendant", e.data._resultId) : s.$search.removeAttr("aria-activedescendant");
                          });
                  }),
                  (e.prototype.handleSearch = function (e) {
                      var t;
                      this._keyUpPrevented || ((t = this.$search.val()), this.trigger("query", { term: t })), (this._keyUpPrevented = !1);
                  }),
                  (e.prototype.showSearch = function (e, t) {
                      return !0;
                  }),
                  e
              );
          }),
          u.define("select2/dropdown/hidePlaceholder", [], function () {
              function e(e, t, n, s) {
                  (this.placeholder = this.normalizePlaceholder(n.get("placeholder"))), e.call(this, t, n, s);
              }
              return (
                  (e.prototype.append = function (e, t) {
                      (t.results = this.removePlaceholder(t.results)), e.call(this, t);
                  }),
                  (e.prototype.normalizePlaceholder = function (e, t) {
                      return (t = "string" == typeof t ? { id: "", text: t } : t);
                  }),
                  (e.prototype.removePlaceholder = function (e, t) {
                      for (var n = t.slice(0), s = t.length - 1; 0 <= s; s--) {
                          var i = t[s];
                          this.placeholder.id === i.id && n.splice(s, 1);
                      }
                      return n;
                  }),
                  e
              );
          }),
          u.define("select2/dropdown/infiniteScroll", ["jquery"], function (n) {
              function e(e, t, n, s) {
                  (this.lastParams = {}), e.call(this, t, n, s), (this.$loadingMore = this.createLoadingMore()), (this.loading = !1);
              }
              return (
                  (e.prototype.append = function (e, t) {
                      this.$loadingMore.remove(), (this.loading = !1), e.call(this, t), this.showLoadingMore(t) && (this.$results.append(this.$loadingMore), this.loadMoreIfNeeded());
                  }),
                  (e.prototype.bind = function (e, t, n) {
                      var s = this;
                      e.call(this, t, n),
                          t.on("query", function (e) {
                              (s.lastParams = e), (s.loading = !0);
                          }),
                          t.on("query:append", function (e) {
                              (s.lastParams = e), (s.loading = !0);
                          }),
                          this.$results.on("scroll", this.loadMoreIfNeeded.bind(this));
                  }),
                  (e.prototype.loadMoreIfNeeded = function () {
                      var e = n.contains(document.documentElement, this.$loadingMore[0]);
                      !this.loading && e && ((e = this.$results.offset().top + this.$results.outerHeight(!1)), this.$loadingMore.offset().top + this.$loadingMore.outerHeight(!1) <= e + 50 && this.loadMore());
                  }),
                  (e.prototype.loadMore = function () {
                      this.loading = !0;
                      var e = n.extend({}, { page: 1 }, this.lastParams);
                      e.page++, this.trigger("query:append", e);
                  }),
                  (e.prototype.showLoadingMore = function (e, t) {
                      return t.pagination && t.pagination.more;
                  }),
                  (e.prototype.createLoadingMore = function () {
                      var e = n('<li class="select2-results__option select2-results__option--load-more"role="option" aria-disabled="true"></li>'),
                          t = this.options.get("translations").get("loadingMore");
                      return e.html(t(this.lastParams)), e;
                  }),
                  e
              );
          }),
          u.define("select2/dropdown/attachBody", ["jquery", "../utils"], function (u, o) {
              function e(e, t, n) {
                  (this.$dropdownParent = u(n.get("dropdownParent") || document.body)), e.call(this, t, n);
              }
              return (
                  (e.prototype.bind = function (e, t, n) {
                      var s = this;
                      e.call(this, t, n),
                          t.on("open", function () {
                              s._showDropdown(), s._attachPositioningHandler(t), s._bindContainerResultHandlers(t);
                          }),
                          t.on("close", function () {
                              s._hideDropdown(), s._detachPositioningHandler(t);
                          }),
                          this.$dropdownContainer.on("mousedown", function (e) {
                              e.stopPropagation();
                          });
                  }),
                  (e.prototype.destroy = function (e) {
                      e.call(this), this.$dropdownContainer.remove();
                  }),
                  (e.prototype.position = function (e, t, n) {
                      t.attr("class", n.attr("class")), t[0].classList.remove("select2"), t[0].classList.add("select2-container--open"), t.css({ position: "absolute", top: -999999 }), (this.$container = n);
                  }),
                  (e.prototype.render = function (e) {
                      var t = u("<span></span>"),
                          e = e.call(this);
                      return t.append(e), (this.$dropdownContainer = t);
                  }),
                  (e.prototype._hideDropdown = function (e) {
                      this.$dropdownContainer.detach();
                  }),
                  (e.prototype._bindContainerResultHandlers = function (e, t) {
                      var n;
                      this._containerResultsHandlersBound ||
                          ((n = this),
                          t.on("results:all", function () {
                              n._positionDropdown(), n._resizeDropdown();
                          }),
                          t.on("results:append", function () {
                              n._positionDropdown(), n._resizeDropdown();
                          }),
                          t.on("results:message", function () {
                              n._positionDropdown(), n._resizeDropdown();
                          }),
                          t.on("select", function () {
                              n._positionDropdown(), n._resizeDropdown();
                          }),
                          t.on("unselect", function () {
                              n._positionDropdown(), n._resizeDropdown();
                          }),
                          (this._containerResultsHandlersBound = !0));
                  }),
                  (e.prototype._attachPositioningHandler = function (e, t) {
                      var n = this,
                          s = "scroll.select2." + t.id,
                          i = "resize.select2." + t.id,
                          r = "orientationchange.select2." + t.id,
                          t = this.$container.parents().filter(o.hasScroll);
                      t.each(function () {
                          o.StoreData(this, "select2-scroll-position", { x: u(this).scrollLeft(), y: u(this).scrollTop() });
                      }),
                          t.on(s, function (e) {
                              var t = o.GetData(this, "select2-scroll-position");
                              u(this).scrollTop(t.y);
                          }),
                          u(window).on(s + " " + i + " " + r, function (e) {
                              n._positionDropdown(), n._resizeDropdown();
                          });
                  }),
                  (e.prototype._detachPositioningHandler = function (e, t) {
                      var n = "scroll.select2." + t.id,
                          s = "resize.select2." + t.id,
                          t = "orientationchange.select2." + t.id;
                      this.$container.parents().filter(o.hasScroll).off(n), u(window).off(n + " " + s + " " + t);
                  }),
                  (e.prototype._positionDropdown = function () {
                      var e = u(window),
                          t = this.$dropdown[0].classList.contains("select2-dropdown--above"),
                          n = this.$dropdown[0].classList.contains("select2-dropdown--below"),
                          s = null,
                          i = this.$container.offset();
                      i.bottom = i.top + this.$container.outerHeight(!1);
                      var r = { height: this.$container.outerHeight(!1) };
                      (r.top = i.top), (r.bottom = i.top + r.height);
                      var o = this.$dropdown.outerHeight(!1),
                          a = e.scrollTop(),
                          l = e.scrollTop() + e.height(),
                          c = a < i.top - o,
                          e = l > i.bottom + o,
                          a = { left: i.left, top: r.bottom },
                          l = this.$dropdownParent;
                      "static" === l.css("position") && (l = l.offsetParent());
                      i = { top: 0, left: 0 };
                      (u.contains(document.body, l[0]) || l[0].isConnected) && (i = l.offset()),
                          (a.top -= i.top),
                          (a.left -= i.left),
                          t || n || (s = "below"),
                          e || !c || t ? !c && e && t && (s = "below") : (s = "above"),
                          ("above" == s || (t && "below" !== s)) && (a.top = r.top - i.top - o),
                          null != s &&
                              (this.$dropdown[0].classList.remove("select2-dropdown--below"),
                              this.$dropdown[0].classList.remove("select2-dropdown--above"),
                              this.$dropdown[0].classList.add("select2-dropdown--" + s),
                              this.$container[0].classList.remove("select2-container--below"),
                              this.$container[0].classList.remove("select2-container--above"),
                              this.$container[0].classList.add("select2-container--" + s)),
                          this.$dropdownContainer.css(a);
                  }),
                  (e.prototype._resizeDropdown = function () {
                      var e = { width: this.$container.outerWidth(!1) + "px" };
                      this.options.get("dropdownAutoWidth") && ((e.minWidth = e.width), (e.position = "relative"), (e.width = "auto")), this.$dropdown.css(e);
                  }),
                  (e.prototype._showDropdown = function (e) {
                      this.$dropdownContainer.appendTo(this.$dropdownParent), this._positionDropdown(), this._resizeDropdown();
                  }),
                  e
              );
          }),
          u.define("select2/dropdown/minimumResultsForSearch", [], function () {
              function e(e, t, n, s) {
                  (this.minimumResultsForSearch = n.get("minimumResultsForSearch")), this.minimumResultsForSearch < 0 && (this.minimumResultsForSearch = 1 / 0), e.call(this, t, n, s);
              }
              return (
                  (e.prototype.showSearch = function (e, t) {
                      return (
                          !(
                              (function e(t) {
                                  for (var n = 0, s = 0; s < t.length; s++) {
                                      var i = t[s];
                                      i.children ? (n += e(i.children)) : n++;
                                  }
                                  return n;
                              })(t.data.results) < this.minimumResultsForSearch
                          ) && e.call(this, t)
                      );
                  }),
                  e
              );
          }),
          u.define("select2/dropdown/selectOnClose", ["../utils"], function (s) {
              function e() {}
              return (
                  (e.prototype.bind = function (e, t, n) {
                      var s = this;
                      e.call(this, t, n),
                          t.on("close", function (e) {
                              s._handleSelectOnClose(e);
                          });
                  }),
                  (e.prototype._handleSelectOnClose = function (e, t) {
                      if (t && null != t.originalSelect2Event) {
                          var n = t.originalSelect2Event;
                          if ("select" === n._type || "unselect" === n._type) return;
                      }
                      n = this.getHighlightedResults();
                      n.length < 1 || (null != (n = s.GetData(n[0], "data")).element && n.element.selected) || (null == n.element && n.selected) || this.trigger("select", { data: n });
                  }),
                  e
              );
          }),
          u.define("select2/dropdown/closeOnSelect", [], function () {
              function e() {}
              return (
                  (e.prototype.bind = function (e, t, n) {
                      var s = this;
                      e.call(this, t, n),
                          t.on("select", function (e) {
                              s._selectTriggered(e);
                          }),
                          t.on("unselect", function (e) {
                              s._selectTriggered(e);
                          });
                  }),
                  (e.prototype._selectTriggered = function (e, t) {
                      var n = t.originalEvent;
                      (n && (n.ctrlKey || n.metaKey)) || this.trigger("close", { originalEvent: n, originalSelect2Event: t });
                  }),
                  e
              );
          }),
          u.define("select2/dropdown/dropdownCss", ["../utils"], function (n) {
              function e() {}
              return (
                  (e.prototype.render = function (e) {
                      var t = e.call(this),
                          e = this.options.get("dropdownCssClass") || "";
                      return -1 !== e.indexOf(":all:") && ((e = e.replace(":all:", "")), n.copyNonInternalCssClasses(t[0], this.$element[0])), t.addClass(e), t;
                  }),
                  e
              );
          }),
          u.define("select2/dropdown/tagsSearchHighlight", ["../utils"], function (s) {
              function e() {}
              return (
                  (e.prototype.highlightFirstItem = function (e) {
                      var t = this.$results.find(".select2-results__option--selectable:not(.select2-results__option--selected)");
                      if (0 < t.length) {
                          var n = t.first(),
                              t = s.GetData(n[0], "data").element;
                          if (t && t.getAttribute && "true" === t.getAttribute("data-select2-tag")) return void n.trigger("mouseenter");
                      }
                      e.call(this);
                  }),
                  e
              );
          }),
          u.define("select2/i18n/en", [], function () {
              return {
                  errorLoading: function () {
                      return "The results could not be loaded.";
                  },
                  inputTooLong: function (e) {
                      var t = e.input.length - e.maximum,
                          e = "Please delete " + t + " character";
                      return 1 != t && (e += "s"), e;
                  },
                  inputTooShort: function (e) {
                      return "Please enter " + (e.minimum - e.input.length) + " or more characters";
                  },
                  loadingMore: function () {
                      return "Loading more results…";
                  },
                  maximumSelected: function (e) {
                      var t = "You can only select " + e.maximum + " item";
                      return 1 != e.maximum && (t += "s"), t;
                  },
                  noResults: function () {
                      return "No results found";
                  },
                  searching: function () {
                      return "Searching…";
                  },
                  removeAllItems: function () {
                      return "Remove all items";
                  },
                  removeItem: function () {
                      return "Remove item";
                  },
                  search: function () {
                      return "Search";
                  },
              };
          }),
          u.define(
              "select2/defaults",
              [
                  "jquery",
                  "./results",
                  "./selection/single",
                  "./selection/multiple",
                  "./selection/placeholder",
                  "./selection/allowClear",
                  "./selection/search",
                  "./selection/selectionCss",
                  "./selection/eventRelay",
                  "./utils",
                  "./translation",
                  "./diacritics",
                  "./data/select",
                  "./data/array",
                  "./data/ajax",
                  "./data/tags",
                  "./data/tokenizer",
                  "./data/minimumInputLength",
                  "./data/maximumInputLength",
                  "./data/maximumSelectionLength",
                  "./dropdown",
                  "./dropdown/search",
                  "./dropdown/hidePlaceholder",
                  "./dropdown/infiniteScroll",
                  "./dropdown/attachBody",
                  "./dropdown/minimumResultsForSearch",
                  "./dropdown/selectOnClose",
                  "./dropdown/closeOnSelect",
                  "./dropdown/dropdownCss",
                  "./dropdown/tagsSearchHighlight",
                  "./i18n/en",
              ],
              function (l, r, o, a, c, u, d, p, h, f, g, t, m, y, v, _, b, $, w, x, A, D, S, E, O, C, L, T, q, I, e) {
                  function n() {
                      this.reset();
                  }
                  return (
                      (n.prototype.apply = function (e) {
                          var t;
                          null == (e = l.extend(!0, {}, this.defaults, e)).dataAdapter &&
                              (null != e.ajax ? (e.dataAdapter = v) : null != e.data ? (e.dataAdapter = y) : (e.dataAdapter = m),
                              0 < e.minimumInputLength && (e.dataAdapter = f.Decorate(e.dataAdapter, $)),
                              0 < e.maximumInputLength && (e.dataAdapter = f.Decorate(e.dataAdapter, w)),
                              0 < e.maximumSelectionLength && (e.dataAdapter = f.Decorate(e.dataAdapter, x)),
                              e.tags && (e.dataAdapter = f.Decorate(e.dataAdapter, _)),
                              (null == e.tokenSeparators && null == e.tokenizer) || (e.dataAdapter = f.Decorate(e.dataAdapter, b))),
                              null == e.resultsAdapter &&
                                  ((e.resultsAdapter = r),
                                  null != e.ajax && (e.resultsAdapter = f.Decorate(e.resultsAdapter, E)),
                                  null != e.placeholder && (e.resultsAdapter = f.Decorate(e.resultsAdapter, S)),
                                  e.selectOnClose && (e.resultsAdapter = f.Decorate(e.resultsAdapter, L)),
                                  e.tags && (e.resultsAdapter = f.Decorate(e.resultsAdapter, I))),
                              null == e.dropdownAdapter &&
                                  (e.multiple ? (e.dropdownAdapter = A) : ((t = f.Decorate(A, D)), (e.dropdownAdapter = t)),
                                  0 !== e.minimumResultsForSearch && (e.dropdownAdapter = f.Decorate(e.dropdownAdapter, C)),
                                  e.closeOnSelect && (e.dropdownAdapter = f.Decorate(e.dropdownAdapter, T)),
                                  null != e.dropdownCssClass && (e.dropdownAdapter = f.Decorate(e.dropdownAdapter, q)),
                                  (e.dropdownAdapter = f.Decorate(e.dropdownAdapter, O))),
                              null == e.selectionAdapter &&
                                  (e.multiple ? (e.selectionAdapter = a) : (e.selectionAdapter = o),
                                  null != e.placeholder && (e.selectionAdapter = f.Decorate(e.selectionAdapter, c)),
                                  e.allowClear && (e.selectionAdapter = f.Decorate(e.selectionAdapter, u)),
                                  e.multiple && (e.selectionAdapter = f.Decorate(e.selectionAdapter, d)),
                                  null != e.selectionCssClass && (e.selectionAdapter = f.Decorate(e.selectionAdapter, p)),
                                  (e.selectionAdapter = f.Decorate(e.selectionAdapter, h))),
                              (e.language = this._resolveLanguage(e.language)),
                              e.language.push("en");
                          for (var n = [], s = 0; s < e.language.length; s++) {
                              var i = e.language[s];
                              -1 === n.indexOf(i) && n.push(i);
                          }
                          return (e.language = n), (e.translations = this._processTranslations(e.language, e.debug)), e;
                      }),
                      (n.prototype.reset = function () {
                          function a(e) {
                              return e.replace(/[^\u0000-\u007E]/g, function (e) {
                                  return t[e] || e;
                              });
                          }
                          this.defaults = {
                              amdLanguageBase: "./i18n/",
                              autocomplete: "off",
                              closeOnSelect: !0,
                              debug: !1,
                              dropdownAutoWidth: !1,
                              escapeMarkup: f.escapeMarkup,
                              language: {},
                              matcher: function e(t, n) {
                                  if (null == t.term || "" === t.term.trim()) return n;
                                  if (n.children && 0 < n.children.length) {
                                      for (var s = l.extend(!0, {}, n), i = n.children.length - 1; 0 <= i; i--) null == e(t, n.children[i]) && s.children.splice(i, 1);
                                      return 0 < s.children.length ? s : e(t, s);
                                  }
                                  var r = a(n.text).toUpperCase(),
                                      o = a(t.term).toUpperCase();
                                  return -1 < r.indexOf(o) ? n : null;
                              },
                              minimumInputLength: 0,
                              maximumInputLength: 0,
                              maximumSelectionLength: 0,
                              minimumResultsForSearch: 0,
                              selectOnClose: !1,
                              scrollAfterSelect: !1,
                              sorter: function (e) {
                                  return e;
                              },
                              templateResult: function (e) {
                                  return e.text;
                              },
                              templateSelection: function (e) {
                                  return e.text;
                              },
                              theme: "default",
                              width: "resolve",
                          };
                      }),
                      (n.prototype.applyFromElement = function (e, t) {
                          var n = e.language,
                              s = this.defaults.language,
                              i = t.prop("lang"),
                              t = t.closest("[lang]").prop("lang"),
                              t = Array.prototype.concat.call(this._resolveLanguage(i), this._resolveLanguage(n), this._resolveLanguage(s), this._resolveLanguage(t));
                          return (e.language = t), e;
                      }),
                      (n.prototype._resolveLanguage = function (e) {
                          if (!e) return [];
                          if (l.isEmptyObject(e)) return [];
                          if (l.isPlainObject(e)) return [e];
                          for (var t, n = Array.isArray(e) ? e : [e], s = [], i = 0; i < n.length; i++) s.push(n[i]), "string" == typeof n[i] && 0 < n[i].indexOf("-") && ((t = n[i].split("-")[0]), s.push(t));
                          return s;
                      }),
                      (n.prototype._processTranslations = function (e, t) {
                          for (var n = new g(), s = 0; s < e.length; s++) {
                              var i = new g(),
                                  r = e[s];
                              if ("string" == typeof r)
                                  try {
                                      i = g.loadPath(r);
                                  } catch (e) {
                                      try {
                                          (r = this.defaults.amdLanguageBase + r), (i = g.loadPath(r));
                                      } catch (e) {
                                          t && window.console && console.warn && console.warn('Select2: The language file for "' + r + '" could not be automatically loaded. A fallback will be used instead.');
                                      }
                                  }
                              else i = l.isPlainObject(r) ? new g(r) : r;
                              n.extend(i);
                          }
                          return n;
                      }),
                      (n.prototype.set = function (e, t) {
                          var n = {};
                          n[l.camelCase(e)] = t;
                          n = f._convertData(n);
                          l.extend(!0, this.defaults, n);
                      }),
                      new n()
                  );
              }
          ),
          u.define("select2/options", ["jquery", "./defaults", "./utils"], function (c, n, u) {
              function e(e, t) {
                  (this.options = e), null != t && this.fromElement(t), null != t && (this.options = n.applyFromElement(this.options, t)), (this.options = n.apply(this.options));
              }
              return (
                  (e.prototype.fromElement = function (e) {
                      var t = ["select2"];
                      null == this.options.multiple && (this.options.multiple = e.prop("multiple")),
                          null == this.options.disabled && (this.options.disabled = e.prop("disabled")),
                          null == this.options.autocomplete && e.prop("autocomplete") && (this.options.autocomplete = e.prop("autocomplete")),
                          null == this.options.dir && (e.prop("dir") ? (this.options.dir = e.prop("dir")) : e.closest("[dir]").prop("dir") ? (this.options.dir = e.closest("[dir]").prop("dir")) : (this.options.dir = "ltr")),
                          e.prop("disabled", this.options.disabled),
                          e.prop("multiple", this.options.multiple),
                          u.GetData(e[0], "select2Tags") &&
                              (this.options.debug &&
                                  window.console &&
                                  console.warn &&
                                  console.warn('Select2: The `data-select2-tags` attribute has been changed to use the `data-data` and `data-tags="true"` attributes and will be removed in future versions of Select2.'),
                              u.StoreData(e[0], "data", u.GetData(e[0], "select2Tags")),
                              u.StoreData(e[0], "tags", !0)),
                          u.GetData(e[0], "ajaxUrl") &&
                              (this.options.debug &&
                                  window.console &&
                                  console.warn &&
                                  console.warn("Select2: The `data-ajax-url` attribute has been changed to `data-ajax--url` and support for the old attribute will be removed in future versions of Select2."),
                              e.attr("ajax--url", u.GetData(e[0], "ajaxUrl")),
                              u.StoreData(e[0], "ajax-Url", u.GetData(e[0], "ajaxUrl")));
                      var n = {};
                      function s(e, t) {
                          return t.toUpperCase();
                      }
                      for (var i = 0; i < e[0].attributes.length; i++) {
                          var r = e[0].attributes[i].name,
                              o = "data-";
                          r.substr(0, o.length) == o && ((r = r.substring(o.length)), (o = u.GetData(e[0], r)), (n[r.replace(/-([a-z])/g, s)] = o));
                      }
                      c.fn.jquery && "1." == c.fn.jquery.substr(0, 2) && e[0].dataset && (n = c.extend(!0, {}, e[0].dataset, n));
                      var a,
                          l = c.extend(!0, {}, u.GetData(e[0]), n);
                      for (a in (l = u._convertData(l))) -1 < t.indexOf(a) || (c.isPlainObject(this.options[a]) ? c.extend(this.options[a], l[a]) : (this.options[a] = l[a]));
                      return this;
                  }),
                  (e.prototype.get = function (e) {
                      return this.options[e];
                  }),
                  (e.prototype.set = function (e, t) {
                      this.options[e] = t;
                  }),
                  e
              );
          }),
          u.define("select2/core", ["jquery", "./options", "./utils", "./keys"], function (t, i, r, s) {
              var o = function (e, t) {
                  null != r.GetData(e[0], "select2") && r.GetData(e[0], "select2").destroy(), (this.$element = e), (this.id = this._generateId(e)), (t = t || {}), (this.options = new i(t, e)), o.__super__.constructor.call(this);
                  var n = e.attr("tabindex") || 0;
                  r.StoreData(e[0], "old-tabindex", n), e.attr("tabindex", "-1");
                  t = this.options.get("dataAdapter");
                  this.dataAdapter = new t(e, this.options);
                  n = this.render();
                  this._placeContainer(n);
                  t = this.options.get("selectionAdapter");
                  (this.selection = new t(e, this.options)), (this.$selection = this.selection.render()), this.selection.position(this.$selection, n);
                  t = this.options.get("dropdownAdapter");
                  (this.dropdown = new t(e, this.options)), (this.$dropdown = this.dropdown.render()), this.dropdown.position(this.$dropdown, n);
                  n = this.options.get("resultsAdapter");
                  (this.results = new n(e, this.options, this.dataAdapter)), (this.$results = this.results.render()), this.results.position(this.$results, this.$dropdown);
                  var s = this;
                  this._bindAdapters(),
                      this._registerDomEvents(),
                      this._registerDataEvents(),
                      this._registerSelectionEvents(),
                      this._registerDropdownEvents(),
                      this._registerResultsEvents(),
                      this._registerEvents(),
                      this.dataAdapter.current(function (e) {
                          s.trigger("selection:update", { data: e });
                      }),
                      e[0].classList.add("select2-hidden-accessible"),
                      e.attr("aria-hidden", "true"),
                      this._syncAttributes(),
                      r.StoreData(e[0], "select2", this),
                      e.data("select2", this);
              };
              return (
                  r.Extend(o, r.Observable),
                  (o.prototype._generateId = function (e) {
                      return "select2-" + (null != e.attr("id") ? e.attr("id") : null != e.attr("name") ? e.attr("name") + "-" + r.generateChars(2) : r.generateChars(4)).replace(/(:|\.|\[|\]|,)/g, "");
                  }),
                  (o.prototype._placeContainer = function (e) {
                      e.insertAfter(this.$element);
                      var t = this._resolveWidth(this.$element, this.options.get("width"));
                      null != t && e.css("width", t);
                  }),
                  (o.prototype._resolveWidth = function (e, t) {
                      var n = /^width:(([-+]?([0-9]*\.)?[0-9]+)(px|em|ex|%|in|cm|mm|pt|pc))/i;
                      if ("resolve" == t) {
                          var s = this._resolveWidth(e, "style");
                          return null != s ? s : this._resolveWidth(e, "element");
                      }
                      if ("element" == t) {
                          s = e.outerWidth(!1);
                          return s <= 0 ? "auto" : s + "px";
                      }
                      if ("style" != t) return "computedstyle" != t ? t : window.getComputedStyle(e[0]).width;
                      e = e.attr("style");
                      if ("string" != typeof e) return null;
                      for (var i = e.split(";"), r = 0, o = i.length; r < o; r += 1) {
                          var a = i[r].replace(/\s/g, "").match(n);
                          if (null !== a && 1 <= a.length) return a[1];
                      }
                      return null;
                  }),
                  (o.prototype._bindAdapters = function () {
                      this.dataAdapter.bind(this, this.$container), this.selection.bind(this, this.$container), this.dropdown.bind(this, this.$container), this.results.bind(this, this.$container);
                  }),
                  (o.prototype._registerDomEvents = function () {
                      var t = this;
                      this.$element.on("change.select2", function () {
                          t.dataAdapter.current(function (e) {
                              t.trigger("selection:update", { data: e });
                          });
                      }),
                          this.$element.on("focus.select2", function (e) {
                              t.trigger("focus", e);
                          }),
                          (this._syncA = r.bind(this._syncAttributes, this)),
                          (this._syncS = r.bind(this._syncSubtree, this)),
                          (this._observer = new window.MutationObserver(function (e) {
                              t._syncA(), t._syncS(e);
                          })),
                          this._observer.observe(this.$element[0], { attributes: !0, childList: !0, subtree: !1 });
                  }),
                  (o.prototype._registerDataEvents = function () {
                      var n = this;
                      this.dataAdapter.on("*", function (e, t) {
                          n.trigger(e, t);
                      });
                  }),
                  (o.prototype._registerSelectionEvents = function () {
                      var n = this,
                          s = ["toggle", "focus"];
                      this.selection.on("toggle", function () {
                          n.toggleDropdown();
                      }),
                          this.selection.on("focus", function (e) {
                              n.focus(e);
                          }),
                          this.selection.on("*", function (e, t) {
                              -1 === s.indexOf(e) && n.trigger(e, t);
                          });
                  }),
                  (o.prototype._registerDropdownEvents = function () {
                      var n = this;
                      this.dropdown.on("*", function (e, t) {
                          n.trigger(e, t);
                      });
                  }),
                  (o.prototype._registerResultsEvents = function () {
                      var n = this;
                      this.results.on("*", function (e, t) {
                          n.trigger(e, t);
                      });
                  }),
                  (o.prototype._registerEvents = function () {
                      var n = this;
                      this.on("open", function () {
                          n.$container[0].classList.add("select2-container--open");
                      }),
                          this.on("close", function () {
                              n.$container[0].classList.remove("select2-container--open");
                          }),
                          this.on("enable", function () {
                              n.$container[0].classList.remove("select2-container--disabled");
                          }),
                          this.on("disable", function () {
                              n.$container[0].classList.add("select2-container--disabled");
                          }),
                          this.on("blur", function () {
                              n.$container[0].classList.remove("select2-container--focus");
                          }),
                          this.on("query", function (t) {
                              n.isOpen() || n.trigger("open", {}),
                                  this.dataAdapter.query(t, function (e) {
                                      n.trigger("results:all", { data: e, query: t });
                                  });
                          }),
                          this.on("query:append", function (t) {
                              this.dataAdapter.query(t, function (e) {
                                  n.trigger("results:append", { data: e, query: t });
                              });
                          }),
                          this.on("keypress", function (e) {
                              var t = e.which;
                              n.isOpen()
                                  ? t === s.ESC || (t === s.UP && e.altKey)
                                      ? (n.close(e), e.preventDefault())
                                      : t === s.ENTER || t === s.TAB
                                      ? (n.trigger("results:select", {}), e.preventDefault())
                                      : t === s.SPACE && e.ctrlKey
                                      ? (n.trigger("results:toggle", {}), e.preventDefault())
                                      : t === s.UP
                                      ? (n.trigger("results:previous", {}), e.preventDefault())
                                      : t === s.DOWN && (n.trigger("results:next", {}), e.preventDefault())
                                  : (t === s.ENTER || t === s.SPACE || (t === s.DOWN && e.altKey)) && (n.open(), e.preventDefault());
                          });
                  }),
                  (o.prototype._syncAttributes = function () {
                      this.options.set("disabled", this.$element.prop("disabled")), this.isDisabled() ? (this.isOpen() && this.close(), this.trigger("disable", {})) : this.trigger("enable", {});
                  }),
                  (o.prototype._isChangeMutation = function (e) {
                      var t = this;
                      if (e.addedNodes && 0 < e.addedNodes.length) {
                          for (var n = 0; n < e.addedNodes.length; n++) if (e.addedNodes[n].selected) return !0;
                      } else {
                          if (e.removedNodes && 0 < e.removedNodes.length) return !0;
                          if (Array.isArray(e))
                              return e.some(function (e) {
                                  return t._isChangeMutation(e);
                              });
                      }
                      return !1;
                  }),
                  (o.prototype._syncSubtree = function (e) {
                      var e = this._isChangeMutation(e),
                          t = this;
                      e &&
                          this.dataAdapter.current(function (e) {
                              t.trigger("selection:update", { data: e });
                          });
                  }),
                  (o.prototype.trigger = function (e, t) {
                      var n = o.__super__.trigger,
                          s = { open: "opening", close: "closing", select: "selecting", unselect: "unselecting", clear: "clearing" };
                      if ((void 0 === t && (t = {}), e in s)) {
                          var i = s[e],
                              s = { prevented: !1, name: e, args: t };
                          if ((n.call(this, i, s), s.prevented)) return void (t.prevented = !0);
                      }
                      n.call(this, e, t);
                  }),
                  (o.prototype.toggleDropdown = function () {
                      this.isDisabled() || (this.isOpen() ? this.close() : this.open());
                  }),
                  (o.prototype.open = function () {
                      this.isOpen() || this.isDisabled() || this.trigger("query", {});
                  }),
                  (o.prototype.close = function (e) {
                      this.isOpen() && this.trigger("close", { originalEvent: e });
                  }),
                  (o.prototype.isEnabled = function () {
                      return !this.isDisabled();
                  }),
                  (o.prototype.isDisabled = function () {
                      return this.options.get("disabled");
                  }),
                  (o.prototype.isOpen = function () {
                      return this.$container[0].classList.contains("select2-container--open");
                  }),
                  (o.prototype.hasFocus = function () {
                      return this.$container[0].classList.contains("select2-container--focus");
                  }),
                  (o.prototype.focus = function (e) {
                      this.hasFocus() || (this.$container[0].classList.add("select2-container--focus"), this.trigger("focus", {}));
                  }),
                  (o.prototype.enable = function (e) {
                      this.options.get("debug") &&
                          window.console &&
                          console.warn &&
                          console.warn('Select2: The `select2("enable")` method has been deprecated and will be removed in later Select2 versions. Use $element.prop("disabled") instead.');
                      e = !(e = null == e || 0 === e.length ? [!0] : e)[0];
                      this.$element.prop("disabled", e);
                  }),
                  (o.prototype.data = function () {
                      this.options.get("debug") &&
                          0 < arguments.length &&
                          window.console &&
                          console.warn &&
                          console.warn('Select2: Data can no longer be set using `select2("data")`. You should consider setting the value instead using `$element.val()`.');
                      var t = [];
                      return (
                          this.dataAdapter.current(function (e) {
                              t = e;
                          }),
                          t
                      );
                  }),
                  (o.prototype.val = function (e) {
                      if (
                          (this.options.get("debug") && window.console && console.warn && console.warn('Select2: The `select2("val")` method has been deprecated and will be removed in later Select2 versions. Use $element.val() instead.'),
                          null == e || 0 === e.length)
                      )
                          return this.$element.val();
                      e = e[0];
                      Array.isArray(e) &&
                          (e = e.map(function (e) {
                              return e.toString();
                          })),
                          this.$element.val(e).trigger("input").trigger("change");
                  }),
                  (o.prototype.destroy = function () {
                      r.RemoveData(this.$container[0]),
                          this.$container.remove(),
                          this._observer.disconnect(),
                          (this._observer = null),
                          (this._syncA = null),
                          (this._syncS = null),
                          this.$element.off(".select2"),
                          this.$element.attr("tabindex", r.GetData(this.$element[0], "old-tabindex")),
                          this.$element[0].classList.remove("select2-hidden-accessible"),
                          this.$element.attr("aria-hidden", "false"),
                          r.RemoveData(this.$element[0]),
                          this.$element.removeData("select2"),
                          this.dataAdapter.destroy(),
                          this.selection.destroy(),
                          this.dropdown.destroy(),
                          this.results.destroy(),
                          (this.dataAdapter = null),
                          (this.selection = null),
                          (this.dropdown = null),
                          (this.results = null);
                  }),
                  (o.prototype.render = function () {
                      var e = t('<span class="select2 select2-container"><span class="selection"></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>');
                      return e.attr("dir", this.options.get("dir")), (this.$container = e), this.$container[0].classList.add("select2-container--" + this.options.get("theme")), r.StoreData(e[0], "element", this.$element), e;
                  }),
                  o
              );
          }),
          u.define("jquery-mousewheel", ["jquery"], function (e) {
              return e;
          }),
          u.define("jquery.select2", ["jquery", "jquery-mousewheel", "./select2/core", "./select2/defaults", "./select2/utils"], function (i, e, r, t, o) {
              var a;
              return (
                  null == i.fn.select2 &&
                      ((a = ["open", "close", "destroy"]),
                      (i.fn.select2 = function (t) {
                          if ("object" == typeof (t = t || {}))
                              return (
                                  this.each(function () {
                                      var e = i.extend(!0, {}, t);
                                      new r(i(this), e);
                                  }),
                                  this
                              );
                          if ("string" != typeof t) throw new Error("Invalid arguments for Select2: " + t);
                          var n,
                              s = Array.prototype.slice.call(arguments, 1);
                          return (
                              this.each(function () {
                                  var e = o.GetData(this, "select2");
                                  null == e && window.console && console.error && console.error("The select2('" + t + "') method was called on an element that is not using Select2."), (n = e[t].apply(e, s));
                              }),
                              -1 < a.indexOf(t) ? this : n
                          );
                      })),
                  null == i.fn.select2.defaults && (i.fn.select2.defaults = t),
                  r
              );
          }),
          { define: u.define, require: u.require });
  function b(e, t) {
      return i.call(e, t);
  }
  function l(e, t) {
      var n,
          s,
          i,
          r,
          o,
          a,
          l,
          c,
          u,
          d,
          p = t && t.split("/"),
          h = y.map,
          f = (h && h["*"]) || {};
      if (e) {
          for (t = (e = e.split("/")).length - 1, y.nodeIdCompat && _.test(e[t]) && (e[t] = e[t].replace(_, "")), "." === e[0].charAt(0) && p && (e = p.slice(0, p.length - 1).concat(e)), c = 0; c < e.length; c++)
              "." === (d = e[c]) ? (e.splice(c, 1), --c) : ".." === d && (0 === c || (1 === c && ".." === e[2]) || ".." === e[c - 1] || (0 < c && (e.splice(c - 1, 2), (c -= 2))));
          e = e.join("/");
      }
      if ((p || f) && h) {
          for (c = (n = e.split("/")).length; 0 < c; --c) {
              if (((s = n.slice(0, c).join("/")), p))
                  for (u = p.length; 0 < u; --u)
                      if (((i = h[p.slice(0, u).join("/")]), (i = i && i[s]))) {
                          (r = i), (o = c);
                          break;
                      }
              if (r) break;
              !a && f && f[s] && ((a = f[s]), (l = c));
          }
          !r && a && ((r = a), (o = l)), r && (n.splice(0, o, r), (e = n.join("/")));
      }
      return e;
  }
  function w(t, n) {
      return function () {
          var e = a.call(arguments, 0);
          return "string" != typeof e[0] && 1 === e.length && e.push(null), o.apply(p, e.concat([t, n]));
      };
  }
  function x(e) {
      var t;
      if ((b(m, e) && ((t = m[e]), delete m[e], (v[e] = !0), r.apply(p, t)), !b(g, e) && !b(v, e))) throw new Error("No " + e);
      return g[e];
  }
  function c(e) {
      var t,
          n = e ? e.indexOf("!") : -1;
      return -1 < n && ((t = e.substring(0, n)), (e = e.substring(n + 1, e.length))), [t, e];
  }
  function A(e) {
      return e ? c(e) : [];
  }
  var u = s.require("jquery.select2");
  return (t.fn.select2.amd = s), u;
});
