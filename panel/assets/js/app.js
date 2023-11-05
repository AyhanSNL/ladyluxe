
!function($) {



    "use strict";

    var MainApp = function() {};

    MainApp.prototype.initNavbar = function () {

        $('.navbar-toggle').on('click', function (event) {
            $(this).toggleClass('open');
            $('#navigation').slideToggle(400);
        });

        $('.navigation-menu>li').slice(-1).addClass('last-elements');

        $('.navigation-menu li.has-submenu a[href="#"]').on('click', function (e) {
            if ($(window).width() < 992) {
                e.preventDefault();
                $(this).parent('li').toggleClass('open').find('.submenu:first').toggleClass('open');
            }
        });
    },
    MainApp.prototype.initLoader = function () {
        $(window).on('load', function() {
            $('#status').fadeOut();
            $('#preloader').delay(350).fadeOut('slow');
            $('body').delay(350).css({
                'overflow': 'visible'
            });
        });
    },
    MainApp.prototype.initScrollbar = function () {
        $('.slimscroll-noti').slimScroll({
            height: '350px',
            position: 'right',
            size: "5px",
            color: '#98a6ad',
            wheelStep: 10
        });
    }
    // === fo,llowing js will activate the menu in left side bar based on url ====
    MainApp.prototype.initMenuItem = function () {
        $(".navigation-menu a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).parent().addClass("active"); // add active to li of the current link
                $(this).parent().parent().parent().addClass("active"); // add active class to an anchor
                $(this).parent().parent().parent().parent().parent().addClass("active"); // add active class to an anchor
            }
        });
    },
    MainApp.prototype.initComponents = function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
    },
    MainApp.prototype.initToggleSearch = function () {
        $('.toggle-search').on('click', function () {
            var targetId = $(this).data('target');
            var $searchBar;
            if (targetId) {
                $searchBar = $(targetId);
                $searchBar.toggleClass('open');
            }
        });
    },

    MainApp.prototype.init = function () {
        this.initNavbar();
        this.initLoader();
        this.initScrollbar();
        this.initMenuItem();
        this.initComponents();
        this.initToggleSearch();
    },

    //init
    $.MainApp = new MainApp, $.MainApp.Constructor = MainApp
}(window.jQuery),

//initializing
function ($) {
    "use strict";
    $.MainApp.init();
}(window.jQuery);







<!-- Fixed Header Codes !-->
$(window).stop().scroll(function() {
    var top = $(window).scrollTop();
    var durum = $("#fixed-header-main").css("display");

    if(top > 30){
        if(durum != "block"){
            $("#fixed-header-main").slideDown(150);
        }
    }else{
        if(durum != "none"){
            $("#fixed-header-main").slideUp(0);
        }
    }
});
<!-- Fixed Header Codes SON !-->


<!-- Home Header Counter !-->
function getPage(id) {
    $('#count-noti').html('<div class="skeleton " style="min-width:400px; height: 4px"></div>');
    jQuery.ajax({
        url: "header-counters",
        success:function(data){$('#count-noti').html(data);}
    });
}
getPage(1);
<!--  <========SON=========>>> Home Header Counter SON !-->


<!-- Anasayfa Ziyaretçiler !-->
function getVisitorsTotal(id) {
    $('#visitors-analytics-home').html('<div class=" list-inline widget-chart m-t-20 m-b-15 text-center"><li class="skeleton_visitors list-inline-item" style="border: 1px solid #fff; height: 100px"></li><li class="skeleton_visitors list-inline-item" style="border: 1px solid #fff; height: 100px"></li><li class="skeleton_visitors list-inline-item" style="border: 1px solid #fff; height: 100px"></li><li class="skeleton_visitors list-inline-item" style="border: 1px solid #fff; height: 10px"></li><li class="skeleton_visitors list-inline-item" style="border: 1px solid #fff; height: 10px"></li><li class="skeleton_visitors list-inline-item" style="border: 1px solid #fff; height: 10px"></li></div>');
    jQuery.ajax({
        url: "home-visitors",
        success:function(data){$('#visitors-analytics-home').html(data);}
    });
}
getVisitorsTotal(1);
<!--  <========SON=========>>> Anasayfa Ziyaretçiler SON !-->


<!-- Anasayfa Ziyaretçiler !-->
function modulSayilariVerileri(id) {
    $('#home-veriler-java').html('<div style="width: 90%; margin: 0 auto;"><div class="col-md-12 mb-3  skeleton_visitors " style="height: 10px"  ></div><div class="col-md-12 mb-3  skeleton_visitors " style="height: 10px" ></div><div class="col-md-12 mb-3  skeleton_visitors "style="height: 10px"  ></div><div class="col-md-12 mb-3  skeleton_visitors " style="height: 10px" ></div></div>');
    jQuery.ajax({
        url: "home-data-counters",
        success:function(data){$('#home-veriler-java').html(data);}
    });
}
modulSayilariVerileri(1);
<!--  <========SON=========>>> Anasayfa Ziyaretçiler SON !-->

<!-- Anasayfa Sipariş İstatistik !-->
function homeOrderData(id) {
    $('#home-order-data').html('<div style="margin: 0 auto; margin-bottom: 30px; width: 95%; display: flex; flex-wrap: wrap"><div class="col-md-4  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-primary"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div><div class="col-md-4  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-primary"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div><div class="col-md-4  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-primary"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div></div>');
    jQuery.ajax({
        url: "home-order-statistic",
        success:function(data){$('#home-order-data').html(data);}
    });
}
homeOrderData(1);
<!--  <========SON=========>>> Anasayfa Sipariş İstatistik SON !-->


<!-- Anasayfa Satış İstatistik !-->
function homeSaleData(id) {
    $('#home-sale-data').html('<div style="margin: 0 auto; margin-bottom: 30px; width: 95%; display: flex; flex-wrap: wrap"><div class="col-md-4  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div><div class="col-md-4  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div><div class="col-md-4  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div></div>');
    jQuery.ajax({
        url: "home-sale-statistic",
        success:function(data){$('#home-sale-data').html(data);}
    });
}
homeSaleData(1);
<!--  <========SON=========>>> Anasayfa Satış İstatistik SON !-->


<!-- Bekleyen İşler !-->
function bekleyenIsler(id) {
    $('#bekleyen-isler').html('<div class="col-md-12 " style="height: 90px;  display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div>');
    jQuery.ajax({
        url: "bekleyen-isler-dynamic",
        success:function(data){$('#bekleyen-isler').html(data);}
    });
}
bekleyenIsler(1);
<!--  <========SON=========>>> Bekleyen İşler SON !-->

<!-- Bekleyen İşler !-->
function bekleyenIsler2(id) {
    $('#bekleyen-isler-2').html('<div class="col-md-12  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div>');
    jQuery.ajax({
        url: "bekleyen-isler-dynamic",
        success:function(data){$('#bekleyen-isler-2').html(data);}
    });
}
bekleyenIsler2(1);
<!--  <========SON=========>>> Bekleyen İşler SON !-->


<!--  Home ödeme türü pastası !-->
function homeOrderTypePie(id) {
    $('#order-type-pie').html('<div class="col-md-12  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div>');
    jQuery.ajax({
        url: "order-type-pie",
        success:function(data){$('#order-type-pie').html(data);}
    });
}
homeOrderTypePie(1);
<!--  <========SON=========>>> Home ödeme türü pastası SON !-->




<!-- Yapılacaklar listesi onay !-->
$(function(){
    $('.gorev-tamamlandi').click(function(){
        var elem = $(this);
        $.ajax({
            type: "GET",
            url: "inc/modules/todo/todo_active.php",
            data: "gorev_id="+elem.attr('data-code'),
            dataType:"json",
            success: function(data) {
                setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 0);

            }
        });
        return false;
    });
});
<!--  <========SON=========>>> Yapılacaklar listesi onay SON !-->

<!-- ModüL Sıralama Aktif-Pasif !-->
$(function(){
    $('.islemyap').click(function(){
        var elem = $(this);
        $.ajax({
            type: "GET",
            url: "inc/modules/modules/modules_sort_process.php",
            data: "islem_id="+elem.attr('data-code'),
            dataType:"json",
            success: function(data) {
                setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 0);

            }
        });
        return false;
    });
});
<!--  <========SON=========>>> ModüL Sıralama Aktif-Pasif SON !-->

<!-- Dil Değişimi !-->
$(function(){
    $('.language-change').click(function(){
        var elem = $(this);
        $.ajax({
            type: "GET",
            url: "../includes/config/admin_language.php",
            data: "language="+elem.attr('data-code'),
            dataType:"json",
            success: function(data) {
                setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 0);

            }
        });
        return false;
    });
});
<!--  <========SON=========>>> Dil Değişimi SON !-->



$('.colorpicker-default').colorpicker({
    format: 'hex'
});


/* Dil seçimi ve flag Ayrıca select2 gereklidir */
function format(item, state) {
    if (!item.id) {
        return item.text;
    }
    var countryUrl = "../assets/css/flag/flags/4x3/";
    var url = state ? stateUrl : countryUrl;
    var img = $("<img>", {
        class: "img-flag",
        width: 26,
        src: url + item.element.value.toLowerCase() + ".svg" });

    var span = $("<span>", {
        text: " " + item.text });

    span.prepend(img);
    return span;
}

$(document).ready(function () {
    $("#countries").select2({
        templateResult: function (item) {
            return format(item, false);
        } });

    $("#us-states").select2({
        templateResult: function (item) {
            return format(item, true);
        } });

});
/*  <========SON=========>>> Dil seçimi ve flag SON */



/* Left bar active buttonlar */
$("#sidebar .btn-group[role='group'] button").on('click', function(){
    $(this).siblings().removeClass('active')
    $(this).addClass('active');
})
/*  <========SON=========>>> Left bar active buttonlar SON */



/* Popover */
$(function () {
    $('[data-toggle="popover"]').popover()
})
$('body').on('click', function (e) {
    //only buttons
    if ($(e.target).data('toggle') !== 'popover'
        && $(e.target).parents('.popover.in').length === 0) {
        $('[data-toggle="popover"]').popover('hide');
    }
    //buttons and icons within buttons
    /*
    if ($(e.target).data('toggle') !== 'popover'
        && $(e.target).parents('[data-toggle="popover"]').length === 0
        && $(e.target).parents('.popover.in').length === 0) {
        $('[data-toggle="popover"]').popover('hide');
    }
    */
});
/*  <========SON=========>>> Popover SON */

/* Bekletme Loader Ekranı */
jQuery(function ($) {

    $('#waitButton').click(function () {
        $(document).ajaxSend(function () {
            $("#waitProcessOverlay").fadeIn(300);
        });
        $.ajax({
            type: 'GET',
            success: function (data) {
                console.log(data);
            } }).
        done(function () {
            setTimeout(function () {
                $("#waitProcessOverlay").fadeOut(300);
            }, 100000);
        });
    });
});
jQuery(function ($) {

    $('#waitButton2').click(function () {
        $(document).ajaxSend(function () {
            $("#waitProcessOverlay").fadeIn(300);
        });
        $.ajax({
            type: 'GET',
            success: function (data) {
                console.log(data);
            } }).
        done(function () {
            setTimeout(function () {
                $("#waitProcessOverlay").fadeOut(300);
            }, 15000);
        });
    });
});
/*  <========SON=========>>> Bekletme Loader Ekranı SON */




/* Ziyaretçiler */
function dailyVs(id) {
    $('#daily_visitor_detail').html('<div class="col-md-12  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div>');    jQuery.ajax({
        url: "masterpiece.php?page=daily_visitor_for_detail",
        success:function(data){$('#daily_visitor_detail').html(data);}
    });
}
dailyVs(1);
function weekVs(id) {
    $('#weekly_visitor_detail').html('<div class="col-md-12  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div>');    jQuery.ajax({
        url: "masterpiece.php?page=weekly_visitor_for_detail",
        success:function(data){$('#weekly_visitor_detail').html(data);}
    });
}
weekVs(1);
function monthVs(id) {
    $('#monthly_visitor_detail').html('<div class="col-md-12  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div>');    jQuery.ajax({
        url: "masterpiece.php?page=monthly_visitor_for_detail",
        success:function(data){$('#monthly_visitor_detail').html(data);}
    });
}
monthVs(1);
function yearVs(id) {
    $('#year_visitor_detail').html('<div class="col-md-12  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div>');    jQuery.ajax({
        url: "masterpiece.php?page=year_visitor_for_detail",
        success:function(data){$('#year_visitor_detail').html(data);}
    });
}
yearVs(1);
/*  <========SON=========>>> Ziyaretçiler SON */


/* Sipariş Verileri Detay */
function dailyOrderDetail(id) {
    $('#daily_order_detail').html('<div class="col-md-12  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div>');    jQuery.ajax({
        url: "masterpiece.php?page=daily_order_for_detail",
        success:function(data){$('#daily_order_detail').html(data);}
    });
}
dailyOrderDetail(1);

function weekOrderDetail(id) {
    $('#week_order_detail').html('<div class="col-md-12  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div>');    jQuery.ajax({
        url: "masterpiece.php?page=week_order_for_detail",
        success:function(data){$('#week_order_detail').html(data);}
    });
}
weekOrderDetail(1);

function monthOrderDetail(id) {
    $('#month_order_detail').html('<div class="col-md-12  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div>');    jQuery.ajax({
        url: "masterpiece.php?page=month_order_for_detail",
        success:function(data){$('#month_order_detail').html(data);}
    });
}
monthOrderDetail(1);

function yearOrderDetail(id) {
    $('#year_order_detail').html('<div class="col-md-12  " style="height: 90px; display: flex; align-items : center; justify-content: center" ><div class="spinner-border text-success"  style="width:35px; height: 35px; " role="status"><span class="sr-only">Loading...</span></div></div>');    jQuery.ajax({
        url: "masterpiece.php?page=year_order_for_detail",
        success:function(data){$('#year_order_detail').html(data);}
    });
}
yearOrderDetail(1);
/*  <========SON=========>>> Sipariş Verileri Detay SON */

/* Respoınsive Table - Dropdown Fix */
$('.table-responsive').on('show.bs.dropdown', function () {
    $('.table-responsive').css( "overflow", "inherit" );
});

$('.table-responsive').on('hide.bs.dropdown', function () {
    $('.table-responsive').css( "overflow", "auto" );
})
/*  <========SON=========>>> Respoınsive Table - Dropdown Fix SON */