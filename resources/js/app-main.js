$(document).ready(function () {
    /* Menu fixed */
    $(window).scroll(function () {
        var scrollToTop = $(window).scrollTop();
        var heaigt_header = $(".menu").height();
        if (scrollToTop >= heaigt_header) {
            if (
                !$(".menu,.menu-res").hasClass(
                    "fix_head animate__animated animate__fadeIn"
                )
            ) {
                $(".menu,.menu-res").addClass(
                    "fix_head animate__animated animate__fadeIn"
                );
            }
        } else {
            $(".menu,.menu-res").removeClass(
                "fix_head animate__animated animate__fadeIn"
            );
        }
    });

    /* Aos */
    function AosAnimation() {
        AOS.init({
            duration: 1000,
            offset: 50,
        });
        $(window).load(function () {
            AOS.refresh;
        });
        $(window).scroll(function () {
            AOS.refresh;
        });
    }

    /* Slick */
    if ($(".slick-v-3").length) {
        $(".slick-v-3").slick({
            infinite: true,
            autoplaySpeed: 3000,
            slidesToShow: 2,
            slidesToScroll: 1,
            adaptiveHeight: true,
            vertical: true,
            autoplay: true,
            arrows: false,
            dots: false,
            responsive: [
                {
                    breakpoint: 481,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
            ],
        });
    }

    /* Owl carousel */
    function OwlData(obj) {
        if (!obj.length) return false;
        var xsm_items = obj.attr("data-xsm-items");
        var sm_items = obj.attr("data-sm-items");
        var md_items = obj.attr("data-md-items");
        var lg_items = obj.attr("data-lg-items");
        var xlg_items = obj.attr("data-xlg-items");
        var rewind = obj.attr("data-rewind");
        var autoplay = obj.attr("data-autoplay");
        var loop = obj.attr("data-loop");
        var lazyLoad = obj.attr("data-lazyload");
        var mouseDrag = obj.attr("data-mousedrag");
        var touchDrag = obj.attr("data-touchdrag");
        var animations = obj.attr("data-animations");
        var smartSpeed = obj.attr("data-smartspeed");
        var autoplaySpeed = obj.attr("data-autoplayspeed");
        var autoplayTimeout = obj.attr("data-autoplaytimeout");
        var dots = obj.attr("data-dots");
        var nav = obj.attr("data-nav");
        var navText = false;
        var navContainer = false;
        var responsive = {};
        var responsiveClass = true;
        var responsiveRefreshRate = 200;

        if (xsm_items != "") {
            xsm_items = xsm_items.split(":");
        }
        if (sm_items != "") {
            sm_items = sm_items.split(":");
        }
        if (md_items != "") {
            md_items = md_items.split(":");
        }
        if (lg_items != "") {
            lg_items = lg_items.split(":");
        }
        if (xlg_items != "") {
            xlg_items = xlg_items.split(":");
        }
        if (rewind == 1) {
            rewind = true;
        } else {
            rewind = false;
        }
        if (autoplay == 1) {
            autoplay = true;
        } else {
            autoplay = false;
        }
        if (loop == 1) {
            loop = true;
        } else {
            loop = false;
        }
        if (lazyLoad == 1) {
            lazyLoad = true;
        } else {
            lazyLoad = false;
        }
        if (mouseDrag == 1) {
            mouseDrag = true;
        } else {
            mouseDrag = false;
        }
        if (animations != "") {
            animations = animations;
        } else {
            animations = false;
        }
        if (smartSpeed > 0) {
            smartSpeed = Number(smartSpeed);
        } else {
            smartSpeed = 800;
        }
        if (autoplaySpeed > 0) {
            autoplaySpeed = Number(autoplaySpeed);
        } else {
            autoplaySpeed = 800;
        }
        if (autoplayTimeout > 0) {
            autoplayTimeout = Number(autoplayTimeout);
        } else {
            autoplayTimeout = 5000;
        }
        if (dots == 1) {
            dots = true;
        } else {
            dots = false;
        }
        if (nav == 1) {
            nav = true;
            navText = obj.attr("data-navtext");
            navContainer = obj.attr("data-navcontainer");

            if (navText != "") {
                navText =
                    navText.indexOf("|") > 0
                        ? navText.split("|")
                        : navText.split(":");
                navText = [navText[0], navText[1]];
            }

            if (navContainer != "") {
                navContainer = navContainer;
            }
        } else {
            nav = false;
        }

        responsive = {
            0: {
                items: Number(xsm_items[0]),
                margin: Number(xsm_items[1]),
            },
            481: {
                items: Number(sm_items[0]),
                margin: Number(sm_items[1]),
            },
            769: {
                items: Number(md_items[0]),
                margin: Number(md_items[1]),
            },
            1025: {
                items: Number(lg_items[0]),
                margin: Number(lg_items[1]),
            },
            1200: {
                items: Number(xlg_items[0]),
                margin: Number(xlg_items[1]),
            },
        };

        obj.owlCarousel({
            rewind: rewind,
            autoplay: autoplay,
            loop: loop,
            lazyLoad: lazyLoad,
            mouseDrag: mouseDrag,
            touchDrag: touchDrag,
            smartSpeed: smartSpeed,
            autoplaySpeed: autoplaySpeed,
            autoplayTimeout: autoplayTimeout,
            dots: dots,
            nav: nav,
            navText: navText,
            navContainer: navContainer,
            responsiveClass: responsiveClass,
            responsiveRefreshRate: responsiveRefreshRate,
            responsive: responsive,
        });

        if (autoplay) {
            obj.on("translate.owl.carousel", function (event) {
                obj.trigger("stop.owl.autoplay");
            });

            obj.on("translated.owl.carousel", function (event) {
                obj.trigger("play.owl.autoplay", [autoplayTimeout]);
            });
        }

        if (animations && obj.find("[owl-item-animation]").length) {
            var animation_now = "";
            var animation_count = 0;
            var animations_excuted = [];
            var animations_list = animations.indexOf(",")
                ? animations.split(",")
                : animations;

            obj.on("changed.owl.carousel", function (event) {
                $(this)
                    .find(".owl-item.active")
                    .find("[owl-item-animation]")
                    .removeClass(animation_now);
            });

            obj.on("translate.owl.carousel", function (event) {
                var item = event.item.index;

                if (Array.isArray(animations_list)) {
                    var animation_trim =
                        animations_list[animation_count].trim();

                    if (!animations_excuted.includes(animation_trim)) {
                        animation_now = "animate__animated " + animation_trim;
                        animations_excuted.push(animation_trim);
                        animation_count++;
                    }

                    if (animations_excuted.length == animations_list.length) {
                        animation_count = 0;
                        animations_excuted = [];
                    }
                } else {
                    animation_now =
                        "animate__animated " + animations_list.trim();
                }
                $(this)
                    .find(".owl-item")
                    .eq(item)
                    .find("[owl-item-animation]")
                    .addClass(animation_now);
            });
        }
    }

    if ($(".owl-page").length) {
        $(".owl-page").each(function () {
            OwlData($(this));
        });
    }

    /* Mmenu */
    if ($("nav#menu").length) {
        $("nav#menu").mmenu({
            extensions: [
                "border-full",
                "position-left",
                "position-front",
                "theme-white",
            ],
            navbar: {
                title: "MENU",
            },
            navbars: [
                {
                    position: "top",
                    content: ["prev", "title", "close"],
                },
            ],
            // "slidingSubmenus": false,
            // "pageScroll": {
            //     "scroll": true,
            //     "update": true
            // }
        });
    }

    /* Search responsive */
    if ($(".icon-search-cus").length) {
        $(".icon-search-cus").click(function () {
            if ($(this).hasClass("active")) {
                $(this).removeClass("active");
                $(".search-grid")
                    .stop(true, true)
                    .animate({ opacity: "0", width: "0px" }, 200);
            } else {
                $(this).addClass("active");
                $(".search-grid")
                    .stop(true, true)
                    .animate({ opacity: "1", width: "230px" }, 200);
            }
            document
                .getElementById($(this).next().find("input").attr("id"))
                .focus();
            $(".icon-search i").toggleClass("bi bi-x");
        });
    }

    if ($(".prdtab-item").length) {
        $(".prdtab-item:eq(0)").addClass("active");
        const firstId = $(".prdtab-item:eq(0)").data("id");
        const firstUrl = $(".prdtab-item:eq(0)").data("url");
        $.ajax({
            url: firstUrl,
            method: "GET",
            dataType: "html",
            data: {
                id: firstId,
            },
            success: function (res) {
                $(".load-api-prd").html(res);
                return false;
            },
        });

        $(".prdtab-item").click(function (e) {
            e.preventDefault();
            const id = $(this).data("id");
            const url = $(this).data("url");
            const prdApi = $(this).parents(".prdtab-list").next();
            $.ajax({
                url: url,
                method: "GET",
                dataType: "html",
                data: {
                    id: id,
                },
                success: function (res) {
                    prdApi.html(res);
                    return false;
                },
            });
        });
    }

    // Noti
    function notifyDialog(
        content = "",
        title = "Thông báo",
        icon = "fas fa-exclamation-triangle",
        type = "blue"
    ) {
        $.alert({
            title: title,
            icon: icon, // font awesome
            type: type, // red, green, orange, blue, purple, dark
            content: content, // html, text
            backgroundDismiss: true,
            animationSpeed: 600,
            animation: "zoom",
            closeAnimation: "scale",
            typeAnimated: true,
            animateFromElement: false,
            autoClose: "accept|3000",
            escapeKey: "accept",
            buttons: {
                accept: {
                    text: "Đồng ý",
                    btnClass: "btn-sm btn-primary",
                },
            },
        });
    }

    // Search client
    if ($(".icon-seach-res").length) {
        $(".icon-seach-res").click(function () {
            const url = $(this).data("url");
            onSearch("keyword-res", url);
        });
    }
    if ($("#keyword-res").length) {
        $("#keyword-res").keypress(function (e) {
            const url = $(this).data("url");
            if (e.keyCode == 13 || e.which == 13)
                onSearch($(this).attr("id"), url);
        });
    }
    if ($(".icon-seach").length) {
        $(".icon-seach").click(function () {
            const url = $(this).data("url");
            onSearch("keyword", url);
        });
    }
    if ($("#keyword").length) {
        $("#keyword").keypress(function (e) {
            const url = $(this).data("url");
            if (e.keyCode == 13 || e.which == 13)
                onSearch($(this).attr("id"), url);
        });
    }

    function onSearch(obj, url) {
        var keyword = $("#" + obj).val();

        if (keyword == "") {
            notifyDialog("Bạn chưa nhập từ khóa tìm kiếm");
            return false;
        } else {
            location.href = url + "?keyword=" + encodeURI(keyword);
        }
    }

    // back to top
    $(window).scroll(function () {
        if ($(window).scrollTop() > 300) {
            $("#button_back_to_top").addClass("show");
        } else {
            $("#button_back_to_top").removeClass("show");
        }
    });
    $("#button_back_to_top").on("click", function (e) {
        e.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, "300");
    });

    // Ajax pagging
    function fect_paginate(page) {
        $.ajax({
            url: urlBase + "ajax_paginate?prdh=" + page,
            success: function (res) {
                $(".prdhot-list").html(res);
            },
        });
    }
    $(document).on("click", ".pagg .pagination a", function (e) {
        e.preventDefault();
        var page = 1;
        if ($(this).attr("href")) {
            page = $(this).attr("href").split("prdh=")[1];
        } else {
            page = 1;
        }
        $(".pagg .pagination a").each(function () {
            $(this).parent().removeClass("active");
        });
        if ($(this).parent().hasClass("active")) {
            $(this).parent().removeClass("active");
        } else {
            $(this).parent().addClass("active");
        }
        fect_paginate(page);
    });

    /* Toc */
    if ($(".toc-list").length) {
        $(".toc-list").toc({
            content: "div#toc-content",
            headings: "h2,h3,h4",
        });

        if (!$(".toc-list li").length) $(".meta-toc").hide();
        if (!$(".toc-list li").length)
            $(".meta-toc .mucluc-dropdown-list_button").hide();

        $(".toc-list")
            .find("a")
            .click(function () {
                var x = $(this).attr("data-rel");
                goToByScroll(x);
            });

        $("body").on("click", ".mucluc-dropdown-list_button", function () {
            $(".box-readmore").slideToggle(200);
        });

        $(document).scroll(function () {
            var y = $(this).scrollTop();
            if (y > 300) {
                $(".meta-toc").addClass("fiedx");
            } else {
                $(".meta-toc").removeClass("fiedx");
            }
        });
    }

    /* Payments */
    if ($(".payments-label").length) {
        $(".payments-label").click(function () {
            var payments = $(this).data("payments");
            $(".payments-cart .payments-label, .payments-info").removeClass(
                "active"
            );
            $(this).addClass("active");
            $(".payments-info-" + payments).addClass("active");
        });
    }

    /* Update cart ajax */
    if ($(".qty__cart").length) {
        $(".qty__cart").change(function () {
            const id = $(this).data("id");
            const price = parseInt($(this).data("price"));
            const qty = $(this).val();
            const rowId = $(this).attr("rowID");
            $.ajax({
                url: urlBase + "gio-hang/update_ajax",
                data: {
                    rowId: rowId,
                    price: price,
                    qty: qty,
                    _token: $(this).data("token"),
                },
                dataType: "JSON",
                method: "POST",
                success: function (data) {
                    $(".subtotal-" + id).text(data["subTotal"]);
                    $(".total-price").text(data["total"]);
                    return false;
                },
            });
        });
    }

    /* Delete cart static */
    if ($(".remove__cart").length) {
        $(document).on("click", ".remove__cart", function () {
            const rowId = $(this).data("rowid");
            $.ajax({
                url: `${urlBase}gio-hang/delete/${rowId}`,
                data: { rowId: rowId, _token: $("input[name='_token']").val() },
                method: "DELETE",
                success: function (data) {
                    $(".cart__main-" + rowId).html(data);
                    $(".total-price").html(data);
                    return false;
                },
            });
        });
    }

    if ($(".select2").length) {
        $(".select2").select2();
    }

    // $("body").on("click", ".add-cart", function () {
    //   // $("#popup-cart").modal("show");
    // });

    /* Call function */
    AosAnimation();
});
