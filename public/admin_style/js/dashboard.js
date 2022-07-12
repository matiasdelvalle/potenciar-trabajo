function toggleMenu(marginLeft, marginMain) {
    var emailList = ($(window).width() <= 768 && $(window).width() > 640)? 320 : 360;
    if($('.mainpanel').css('position') === 'relative') {
        $('.logopanel, .leftpanel').animate({left: marginLeft}, 'fast');
        $('.headerbar, .mainpanel').animate({left: marginMain}, 'fast');
        $('.emailcontent, .email-options').animate({left: marginMain}, 'fast');
        $('.emailpanel').animate({left: marginMain + emailList}, 'fast');
        if($('body').css('overflow') == 'hidden') {
            $('body').css({overflow: ''});
        } else {
            $('body').css({overflow: 'hidden'});
        }
    } else {
        $('.logopanel, .leftpanel').animate({marginLeft: marginLeft}, 'fast');
        $('.headerbar, .mainpanel').animate({marginLeft: marginMain}, 'fast');
        $('.emailcontent, .email-options').animate({left: marginMain}, 'fast');
        $('.emailpanel').animate({left: marginMain + emailList}, 'fast');
    }
}


$(document).ready(function() {
    'use strict';
    /***** SHOW / HIDE LEFT MENU *****/
    $('#menuToggle').click(function() {
        var collapsedMargin = $('.mainpanel').css('margin-left');
        var collapsedLeft = $('.mainpanel').css('left');
        if(collapsedMargin === '220px' || collapsedLeft === '220px') {
            toggleMenu(-220,0);
        } else {
            toggleMenu(0,220);
        }
    });

    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

    /****** Perfect Scroll *****/
    var leftpanelinner = $('.leftpanel');
    if(!detectmob()){
        leftpanelinner.perfectScrollbar({ wheelSpeed: 50, minScrollbarLength: 20, suppressScrollX: true });
    }else{
        leftpanelinner.css({'overflow':'scroll'});
    }
    /****** Perfect Scroll *****/

    /****** PULSE A QUICK ACCESS PANEL ******/
    $('.panel-quick-page .panel').hover(function() {
        $(this).addClass('flip animated');
    }, function() {
        $(this).removeClass('flip animated');
    });

    function closeVisibleSubMenu() {
        $('.leftpanel .nav-parent').each(function() {
            var t = jQuery(this);
            if(t.hasClass('nav-active')) {
                t.find('> ul').slideUp(200, function(){
                    t.removeClass('nav-active');
                });
            }
        });
    }

    // Toggle Left Menu
    $('.nav-parent > a').on('click', function() {
        var gran = $(this).closest('.nav');
        var parent = $(this).parent();
        var sub = parent.find('> ul');

        if(sub.is(':visible')) {
            sub.slideUp(200);
            if(parent.hasClass('nav-active')) { parent.removeClass('nav-active'); }
        } else {

            $(gran).find('.children').each(function() {
                $(this).slideUp();
            });

            sub.slideDown(200);
            if(!parent.hasClass('active')) { parent.addClass('nav-active'); }
        }
        return false;
    });

    function closeVisibleSubMenu() {
        $('.leftpanel .nav-parent').each(function() {
            var t = jQuery(this);
            if(t.hasClass('nav-active')) {
                t.find('> ul').slideUp(200, function(){
                    t.removeClass('nav-active');
                });
            }
        });
    }

    function setStorage(key, value){
        if (typeof(Storage) !== "undefined") {
            localStorage.setItem(key, value );
        }
    };
    function getStorage(key){
        key;
    };
    function removeStorage(key){
        if (typeof(Storage) !== "undefined") {
            localStorage.removeItem(key);
        }
    };

    // getStorage('config-style');

    // Left Panel Toggles
    $('.leftpanel-toggle').toggles({
        on: getStorage('config-style') == 'dark' ? true : false,
        height: 20
    });
    $('.leftpanel-toggle-off').toggles({ height: 20 });
    $('.leftpanel-toggle').on('toggle', function(e, active) {
        if (active) {
            setStorage('config-style', 'dark');
            $('head').append('<link rel="stylesheet" href="'+css+'/dark.css" type="text/css" />');
            setTimeout(function(){
                $('.btn-logged').click();
            }, 50)
        } else {
            setStorage('config-style', 'white');
            $('head').append('<link rel="stylesheet" href="'+css+'/white.css" type="text/css" />');
            setTimeout(function(){
                $('.btn-logged').click();
            }, 50)
        }
    });
});

$('.navbar-brand').css({'width': $('.headerpanel').width() - $('.header-right').width() - $('.logopanel').width() - $('.menutoggle').width() - 100 + 'px'});
    $( window ).resize(function() {
        $('.navbar-brand').css({'width': $('.headerpanel').width() - $('.header-right').width() - $('.logopanel').width() - $('.menutoggle').width() - 100 + 'px'});
    });

$('a.animate').click(function(){
    $('.contentpanel').fadeOut();
})

$(function(){
  $('.contentpanel').eq(0).animate({'top':'0px','opacity':'1'}, '500').css({'position':'relative'});
})


function detectmob() {
 if( navigator.userAgent.match(/Android/i)
 || navigator.userAgent.match(/webOS/i)
 || navigator.userAgent.match(/iPhone/i)
 || navigator.userAgent.match(/iPad/i)
 || navigator.userAgent.match(/iPod/i)
 || navigator.userAgent.match(/BlackBerry/i)
 || navigator.userAgent.match(/Windows Phone/i)
 ){
    return true;
  }
 else {
    return false;
  }
}
