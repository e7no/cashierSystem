$(function() {
	function t(t) {
		var e = 0;
		return $(t).each(function() {
			e += $(this).outerWidth(!0)
		}), e
	}

	function e(e) {
		var a = t($(e).prevAll()),
			i = t($(e).nextAll()),
			n = t($(".content-tabs").children().not(".will-menuTabs")),
			s = $(".content-tabs").outerWidth(!0) - n,
			r = 0;
		if($(".page-tabs-content").outerWidth() < s) r = 0;
		else if(i <= s - $(e).outerWidth(!0) - $(e).next().outerWidth(!0)) {
			if(s - $(e).next().outerWidth(!0) > i) {
				r = a;
				for(var o = e; r - $(o).outerWidth() > $(".page-tabs-content").outerWidth() - s;) r -= $(o).prev().outerWidth(), o = $(o).prev()
			}
		} else a > s - $(e).outerWidth(!0) - $(e).prev().outerWidth(!0) && (r = a - $(e).prev().outerWidth(!0));
		$(".page-tabs-content").animate({
			marginLeft: 0 - r + "px"
		}, "fast")
	}

	function a() {
		var e = Math.abs(parseInt($(".page-tabs-content").css("margin-left"))),
			a = t($(".content-tabs").children().not(".will-menuTabs")),
			i = $(".content-tabs").outerWidth(!0) - a,
			n = 0;
		if($(".page-tabs-content").width() < i) return !1;
		for(var s = $(".will-menuTab:first"), r = 0; r + $(s).outerWidth(!0) <= e;) r += $(s).outerWidth(!0), s = $(s).next();
		if(r = 0, t($(s).prevAll()) > i) {
			for(; r + $(s).outerWidth(!0) < i && s.length > 0;) r += $(s).outerWidth(!0), s = $(s).prev();
			n = t($(s).prevAll())
		}
		$(".page-tabs-content").animate({
			marginLeft: 0 - n + "px"
		}, "fast")
	}

	function i() {
		var e = Math.abs(parseInt($(".page-tabs-content").css("margin-left"))),
			a = t($(".content-tabs").children().not(".will-menuTabs")),
			i = $(".content-tabs").outerWidth(!0) - a,
			n = 0;
		if($(".page-tabs-content").width() < i) return !1;
		for(var s = $(".will-menuTab:first"), r = 0; r + $(s).outerWidth(!0) <= e;) r += $(s).outerWidth(!0), s = $(s).next();
		for(r = 0; r + $(s).outerWidth(!0) < i && s.length > 0;) r += $(s).outerWidth(!0), s = $(s).next();
		n = t($(s).prevAll()), n > 0 && $(".page-tabs-content").animate({
			marginLeft: 0 - n + "px"
		}, "fast")
	}

	function n() {
		var t = $(this).attr("href"),
			a = $(this).data("index"),
			i = $.trim($(this).text()),
			n = !0;
		if(void 0 == t || 0 == $.trim(t).length) return !1;
		if($(".will-menuTab").each(function() {
				return $(this).data("id") == t ? ($(this).hasClass("active") || ($(this).addClass("active").siblings(".will-menuTab").removeClass("active"), e(this), $(".willContent .will-iframe").each(function() {
					return $(this).data("id") == t ? ($(this).show().siblings(".will-iframe").hide(), !1) : void 0
				})), n = !1, !1) : void 0
			}), n) {
			var s = '<a href="javascript:;" class="active will-menuTab" data-id="' + t + '">' + i + ' <i class="iconfont will-guanbi"></i></a>';
			$(".will-menuTab").removeClass("active");
			var r = '<iframe class="will-iframe" id="iframe' + a + '" name="iframe' + a + '" width="100%" height="100%" src="' + t + '?v=1.0" frameborder="0" data-id="' + t + '" seamless></iframe>';
			$(".willContent").find("iframe.will-iframe").hide().parents(".willContent").append(r);
			var o = layer.load();
			$(".willContent iframe:visible").load(function() {
				layer.close(o)
			}), $(".will-menuTabs .page-tabs-content").append(s), e($(".will-menuTab.active"))
		}
		return !1
	}

	function s() {
		var t = $(this).parents(".will-menuTab").data("id"),
			a = $(this).parents(".will-menuTab").width();
		if($(this).parents(".will-menuTab").hasClass("active")) {
			if($(this).parents(".will-menuTab").next(".will-menuTab").size()) {
				var i = $(this).parents(".will-menuTab").next(".will-menuTab:eq(0)").data("id");
				$(this).parents(".will-menuTab").next(".will-menuTab:eq(0)").addClass("active"), $(".willContent .will-iframe").each(function() {
					return $(this).data("id") == i ? ($(this).show().siblings(".will-iframe").hide(), !1) : void 0
				});
				var n = parseInt($(".page-tabs-content").css("margin-left"));
				0 > n && $(".page-tabs-content").animate({
					marginLeft: n + a + "px"
				}, "fast"), $(this).parents(".will-menuTab").remove(), $(".willContent .will-iframe").each(function() {
					return $(this).data("id") == t ? ($(this).remove(), !1) : void 0
				})
			}
			if($(this).parents(".will-menuTab").prev(".will-menuTab").size()) {
				var i = $(this).parents(".will-menuTab").prev(".will-menuTab:last").data("id");
				$(this).parents(".will-menuTab").prev(".will-menuTab:last").addClass("active"), $(".willContent .will-iframe").each(function() {
					return $(this).data("id") == i ? ($(this).show().siblings(".will-iframe").hide(), !1) : void 0
				}), $(this).parents(".will-menuTab").remove(), $(".willContent .will-iframe").each(function() {
					return $(this).data("id") == t ? ($(this).remove(), !1) : void 0
				})
			}
		} else $(this).parents(".will-menuTab").remove(), $(".willContent .will-iframe").each(function() {
			return $(this).data("id") == t ? ($(this).remove(), !1) : void 0
		}), e($(".will-menuTab.active"));
		return !1
	}

	function r() {
		$(".page-tabs-content").children("[data-id]").not(":first").not(".active").each(function() {
			$('.will-iframe[data-id="' + $(this).data("id") + '"]').remove(), $(this).remove()
		}), $(".page-tabs-content").css("margin-left", "0")
	}

	function o() {
		e($(".will-menuTab.active"))
	}

	function d() {
		if(!$(this).hasClass("active")) {
			var t = $(this).data("id");
			$(".willContent .will-iframe").each(function() {
				return $(this).data("id") == t ? ($(this).show().siblings(".will-iframe").hide(), !1) : void 0
			}), $(this).addClass("active").siblings(".will-menuTab").removeClass("active"), e(this)
		}
	}

	function c() {
		var t = $('.will-iframe[data-id="' + $(this).data("id") + '"]'),
			e = t.attr("src"),
			a = layer.load();
		t.attr("src", e).load(function() {
			layer.close(a)
		})
	}
	$(".will-menuItem").each(function(t) {
		$(this).click(function(){
            var link = $(this).attr('href');
            $('#iframe' + t).attr('src', link);
            var href = window.location.href;
            window.location.href = href.substr(0, href.indexOf('#')) + '#' + link;
            return false;
        });
		$(this).attr("data-index") || $(this).attr("data-index", t)
	}), $(".will-menuItem").on("click", n), $(".will-menuTabs").on("click", ".will-menuTab i", s), $(".will-tabCloseOther").on("click", r), $(".will-menuTabs").on("click", ".will-menuTab", d), $(".will-menuTabs").on("dblclick", ".will-menuTab", c), $(".J_tabLeft").on("click", a), $(".will-tabRight").on("click", i), $(".will-tabCloseAll").on("click", function() {
		$(".page-tabs-content").children("[data-id]").not(":first").each(function() {
			$('.will-iframe[data-id="' + $(this).data("id") + '"]').remove(), $(this).remove()
		}), $(".page-tabs-content").children("[data-id]:first").each(function() {
			$('.will-iframe[data-id="' + $(this).data("id") + '"]').show(), $(this).addClass("active")
		}), $(".page-tabs-content").css("margin-left", "0")
	})
});