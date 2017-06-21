/*
* @description: 框架公用js
* @author: will
* @update: will (2016-12-05 16:28)
* @version: v1.0
*/
$(function(){
    $('.sidebar-collapse').slimscroll({
        height: "100%",
		ailOpacity: .9,
		alwaysVisible: !1
    });
});
function NavToggle() {
	$(".navbar-minimalize").trigger("click")
}

function SmoothlyMenu() {
	$("body").hasClass("mini-navbar") ? $("body").hasClass("fixed-sidebar") ? ($("#side-menu, .logo-element").hide(), setTimeout(function() {
		$("#side-menu").fadeIn(500)
		$(".logo-element").fadeIn(500)
	},
	300)) : $("#side-menu, .logo").removeAttr("style") : ($("#side-menu, .logo-element").hide(), setTimeout(function() {
		$("#side-menu").fadeIn(500)
	},
	100))
}
function localStorageSupport() {
	return "localStorage" in window && null !== window.localStorage
}
$(document).ready(function() {
	function e() {
		var e = $("body > #wrapper").height() - 61;
		$(".sidebard-panel").css("min-height", e + "px")
	}
	$("#side-menu").metisMenu(),
	$(".navbar-minimalize").click(function() {
		$("body").toggleClass("mini-navbar"),
		SmoothlyMenu()
	}),
	e(),
	$(window).bind("load resize click scroll",
	function() {
		$("body").hasClass("body-small") || e()
	}),
	$(window).scroll(function() {
		$(window).scrollTop() > 0 && !$("body").hasClass("fixed-nav") ? $("#right-sidebar").addClass("sidebar-top") : $("#right-sidebar").removeClass("sidebar-top")
	}),
	$("#side-menu>li").click(function() {
		$("body").hasClass("mini-navbar") && NavToggle()
	}),
	$("#side-menu>li li a").click(function() {
		$(window).width() < 960 && NavToggle()
	}),
	$(".nav-close").click(NavToggle),
	/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent) && $("#main").css("overflow-y", "auto")
}),
$(window).bind("load resize",
function() {
	$(this).width() < 960 && ($("body").addClass("mini-navbar"), $(".navbar-static-side").fadeIn())
}),
$(function() {
	if ($("#fixednavbar").click(function() {
		$("#fixednavbar").is(":checked") ? ($(".navbar-static-top").removeClass("navbar-static-top").addClass("navbar-fixed-top"), $("body").removeClass("boxed-layout"), $("body").addClass("fixed-nav"), $("#boxedlayout").prop("checked", !1), localStorageSupport && localStorage.setItem("boxedlayout", "off"), localStorageSupport && localStorage.setItem("fixednavbar", "on")) : ($(".navbar-fixed-top").removeClass("navbar-fixed-top").addClass("navbar-static-top"), $("body").removeClass("fixed-nav"), localStorageSupport && localStorage.setItem("fixednavbar", "off"))
	}), $("#collapsemenu").click(function() {
		$("#collapsemenu").is(":checked") ? ($("body").addClass("mini-navbar"), SmoothlyMenu(), localStorageSupport && localStorage.setItem("collapse_menu", "on")) : ($("body").removeClass("mini-navbar"), SmoothlyMenu(), localStorageSupport && localStorage.setItem("collapse_menu", "off"))
	}), $("#boxedlayout").click(function() {
		$("#boxedlayout").is(":checked") ? ($("body").addClass("boxed-layout"), $("#fixednavbar").prop("checked", !1), $(".navbar-fixed-top").removeClass("navbar-fixed-top").addClass("navbar-static-top"), $("body").removeClass("fixed-nav"), localStorageSupport && localStorage.setItem("fixednavbar", "off"), localStorageSupport && localStorage.setItem("boxedlayout", "on")) : ($("body").removeClass("boxed-layout"), localStorageSupport && localStorage.setItem("boxedlayout", "off"))
	}), localStorageSupport) {
		var e = localStorage.getItem("collapse_menu"),
		a = localStorage.getItem("fixednavbar"),
		o = localStorage.getItem("boxedlayout");
		"on" == e && $("#collapsemenu").prop("checked", "checked"),
		"on" == a && $("#fixednavbar").prop("checked", "checked"),
		"on" == o && $("#boxedlayout").prop("checked", "checked")
	}
	if (localStorageSupport) {
		var e = localStorage.getItem("collapse_menu"),
		a = localStorage.getItem("fixednavbar"),
		o = localStorage.getItem("boxedlayout"),
		l = $("body");
		"on" == e && (l.hasClass("body-small") || l.addClass("mini-navbar")),
		"on" == a && ($(".navbar-static-top").removeClass("navbar-static-top").addClass("navbar-fixed-top"), l.addClass("fixed-nav")),
		"on" == o && l.addClass("boxed-layout")
	}
});