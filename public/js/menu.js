function viewport() {
    var e = window,
        i = "inner";
    return "innerWidth" in window || (i = "client", e = document.documentElement || document.body), {
        width: e[i + "Width"],
        height: e[i + "Height"]
    }
}
function initialise_main_menu_horizontal_functionality() {
    var e = $("#main-menu");
    e.hasClass("main_menu_horizontal_functionality") || (e.addClass("main_menu_horizontal_functionality")
        .removeClass("main_menu_mobile_functionality"), $("#main-menu li.menu-item")
        .removeClass("active"), $("#main-menu li.menu-item .sub-menu:visible")
        .hide(), $("#main-menu")
        .show(), $("#main-menu li.menu-item > a")
        .off(), $("#main-menu > li.menu-item")
        .hover(function () {           
        $(this)
            .addClass("active"), $(this)
            .children(".sub-menu")
            .fadeIn()
    }, function () {
        $(this)
            .removeClass("active"), $(this)
            .children(".sub-menu")
            .fadeOut("fast")
    }), $("#main-menu li.menu-item .sub-menu")
        .hover(function () {
        var e = viewport()
            .width;
        $(this)
            .show(), $(this)
            .parent(".menu-item")
            .addClass("active"), $(this)
            .children(".menu-item")
            .hover(function () {
            var i = $(this)
                .offset()
                .left + $(this)
                .width() + $(this)
                .width();
            i > e ? $(this)
                .children(".sub-menu")
                .removeClass("menu_on_the_right")
                .addClass("menu_on_the_left") : $(this)
                .children(".sub-menu")
                .removeClass("menu_on_the_left")
                .addClass("menu_on_the_right"), $(this)
                .addClass("active"), $(this)
                .children(".sub-menu")
                .fadeIn()
                .css({
                "z-index": "105"
            }), $(this)
                .parents(".sub-menu")
                .css({
                "z-index": "100"
            })
        }, function () {
            $(this)
                .removeClass("active"), $(this)
                .children(".sub-menu")
                .fadeOut("fast")
        })
    }, function () {
        $(this)
            .parent(".menu-item")
            .hover(function () {
            $(this)
                .addClass("active"), $(this)
                .children(".sub-menu")
                .fadeIn()
        }, function () {
            $(this)
                .removeClass("active"), $(this)
                .children(".sub-menu")
                .fadeOut("fast")
        })
    }))
}

function initialise_tablet_mainmenu_submenu_fix() {
    $("#main-menu li.menu-item > a")
        .click(function (e) {
        if (jQuery.browser.mobile && viewport()
            .width > window.xs_screen_max) {
            var i = $(this)
                .parent(".menu-item")
                .find(".sub-menu");
            if (i.length > 0 && !i.hasClass("active")) return e.preventDefault(), !1
        }
    })
}

function initialise_main_menu_mobile_functionality() {
    var e = $("#main-menu");
    e.hasClass("main_menu_mobile_functionality") || (e.addClass("main_menu_mobile_functionality")
        .removeClass("main_menu_horizontal_functionality"), $("#main-menu li.menu-item")
        .removeClass("active"), $("#main-menu li.menu-item .sub-menu")
        .hide(), $("#main-menu")
        .hide(), $("#mobile-menu-icon")
        .removeClass("active"), $("#mobile-menu-icon span")
        .removeClass("glyphicon-remove")
        .addClass("glyphicon-th"), $("#main-menu li.menu-item")
        .off(), $("#main-menu li.menu-item .sub-menu")
        .off(), $("#mobile-menu-icon")
        .off(), $("#mobile-menu-icon")
        .click(function (e) {
        return $("#main-menu")
            .is(":visible") && $(this)
            .hasClass("active") ? ($("#main-menu")
            .slideUp("fast"), $("#main-menu .sub-menu")
            .slideUp("fast"), $("#main-menu li.menu-item")
            .removeClass("active"), $(this)
            .removeClass("active"), $(this)
            .removeClass("active")
            .children("span")
            .removeClass("glyphicon-remove")
            .addClass("glyphicon-th"), e.preventDefault(), !1) : ($(this)
            .addClass("active")
            .children("span")
            .removeClass("glyphicon-th")
            .addClass("glyphicon-remove"), $("#main-menu")
            .slideDown(), e.preventDefault(), !1)
    }), $("#main-menu li.menu-item > a")
        .click(function (e) {
        var i = $(this)
            .parent("li.menu-item");
        if (i.children(".sub-menu")
            .length > 0) {
            if (!i.children(".sub-menu")
                .is(":visible")) return i.children(".sub-menu")
                .slideDown("", function () {
                return i.addClass("active"), e.preventDefault(), !1
            }), e.preventDefault(), !1;
            if ("#" == $(this)
                .attr("href")) return i.find(".sub-menu:visible")
                .slideUp("fast", function () {
                return i.removeClass("active"), i.find(".sub-menu li.menu-item")
                    .removeClass("active"), e.preventDefault(), !1
            }), e.preventDefault(), !1
        }
    }))
}

function initialise_submenu_functionality() {
    $(".sidebar-menu li.menu-item > a")
        .click(function (e) {
        var i = $(this)
            .parent("li.menu-item");
        if (i.children(".sub-menu")
            .length > 0) {
            if (!i.children(".sub-menu")
                .is(":visible")) return i.children(".sub-menu")
                .slideDown("", function () {
                return i.addClass("active"), $(this)
                    .parent(".menu-item")
                    .siblings()
                    .find(".sub-menu:visible")
                    .slideUp("fast", function () {
                    return $(this)
                        .parent(".menu-item")
                        .removeClass("active"), e.preventDefault(), !1
                }), e.preventDefault(), !1
            }), e.preventDefault(), !1;
            if ("#" == $(this)
                .attr("href")) return i.find(".sub-menu:visible")
                .slideUp("fast", function () {
                return i.removeClass("active"), i.find(".sub-menu li.menu-item")
                    .removeClass("active"), e.preventDefault(), !1
            }), e.preventDefault(), !1
        }
    })
}

function main_menu_fixed_at_top_on_scroll(e) {
    var i = $("header:first-of-type");
    if (0 == i.length) return !1;
    var n = i.attr("data-menu-fixed-at-top-on-scroll"),
        t = $("header #main-menu-container");
    if (0 == t.length) return !1;
    var a = $(document)
        .scrollTop(),
        s = i.attr("data-original-top-offset"),
        r = i.attr("data-original-header-height");
    (void 0 === s || isNaN(s) || void 0 === r || isNaN(r) || 1 == e) && (i.removeClass("fixed-at-top"), $(".outer-container")
        .css({
        "padding-top": ""
    }), s = t.offset()
        .top, r = i.innerHeight(), i.attr("data-original-top-offset", s), i.attr("data-original-header-height", r)), "true" == n && a > s || viewport()
        .width < window.xs_screen_max ? (i.addClass("fixed-at-top"), $(".outer-container")
        .css({
       /* "padding-top": r + "px"*/        
    }), viewport()
        .width < window.xs_screen_max ? toggle_scroll_to_mobile_main_menu("enable") : toggle_scroll_to_mobile_main_menu("disable")) : (i.removeClass("fixed-at-top"), $(".outer-container")
        .css({
        "padding-top": ""
    }), toggle_scroll_to_mobile_main_menu("disable"))
}

function toggle_scroll_to_mobile_main_menu(e) {
    var i = $("#main-menu");
    if (i.css({
        "overflow-y": "visible",
        height: "auto"
    }), "enable" == e) {
        var n = $(document).scrollTop(),
            t = $("#main-menu").offset().top,
            a = t - n;
        (0 > a || isNaN(a)) && (a = 60);
        var s = viewport().height - (a + 10);
        i.css({
            "overflow-y": "auto",
            "max-height": s + "px"
        })
    }
}


function set_equal_heights_to_section_columns() {
    var e = $(".horizontal-section-container");
    e.each(function() {
        $(this).find(".row").first().children("*[class*='col-']").not("*[class*='-12']").css({
            "min-height": "1px"
        })
    }), $("body").hasClass("isolated-sections") && viewport().width > window.xs_screen_max && e.each(function() {
        var e = $(this).find(".row").first().children("*[class*='col-']").not("*[class*='-12']");
        if (e.length > 1) {
            var i = [];
            e.each(function() {
                i.push($(this).height())
            });
            var n = Math.max.apply(Math, i);
            e.each(function() {
                $(this).css({
                    "min-height": n + "px"
                })
            })
        }
    })
}

$( document ).ready(function() {
  window.xs_screen_max = 768, window.sm_screen_max = 992; 
 // Initialise Main Menu  
    // on page load, initialise menu functionality depending on window width
    if (viewport().width >= window.xs_screen_max)
    {          
        initialise_main_menu_horizontal_functionality(); 
    }
    else 
    { 
        initialise_main_menu_mobile_functionality(); 
    }

    // Main menu - tablet viewport fix - allow opening of submenus when menu items clicked
    initialise_tablet_mainmenu_submenu_fix();

    // initialise subpages sidebar menu functionality
    initialise_submenu_functionality();
    
  /* 
     * ----------------------------------------------------------
     * ON WINDOW RESIZE
     * ----------------------------------------------------------
     */
    $(window).resize(function()
    { 
        // on window resize, initialise menu functionality depending on window width
        if (viewport().width >= window.xs_screen_max)
        { 
            initialise_main_menu_horizontal_functionality(); 
        }
        else 
        { 
            initialise_main_menu_mobile_functionality(); 
        }

        // Main Menu Fixed at top on scroll
        // (the parameter 'true' is set to re-calculate the top menu original top offset)
        main_menu_fixed_at_top_on_scroll(true);

        // set equal heights to horizontal section columns (if isolated-sections enabled)
        set_equal_heights_to_section_columns();

    });
    // end: on window resize    
});
 