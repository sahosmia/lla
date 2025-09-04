"use strict";
jQuery(document).ready(function() {

    collapseMenu();

    /* PRELOADER*/
    jQuery(window).on('load', function() {
        jQuery(".preloader").delay(1500).fadeOut();
        jQuery(".preloader__bar").delay(1000).fadeOut("slow");
    });

    //Tippy Notify
    let tb_tippy = document.querySelector(".tippy");
    if (tb_tippy !== null) {
        tippy(".tippy", {
            content: "Ad to compare",
            animation: "scale",
        });
    }


    // Left Sidebar Animation
    if(jQuery(window).width() >= 320){
        jQuery('.tb-btnmenutoggle a').on('click', function() {
            var _this = jQuery(this);
            setTimeout(function(){
                _this.parents('body').toggleClass("et-offsidebar");
            },270)
        });
    }
    /* MOBILE MENU*/
	function headerCollapseMenu(){
		jQuery('.tb-navbar ul li.menu-item-has-children').prepend('<span class="tk-dropdowarrow"><i class="icon-chevron-right"></i></span>');
		jQuery('.tb-navbar ul li.menu-item-has-children span').on('click', function() {
			jQuery(this).parent('li').toggleClass('tk-open');
			jQuery(this).next().next().slideToggle(300);
		});
	}
	headerCollapseMenu();


    //collapse Menu
    function collapseMenu() {
        jQuery('.menu-item-has-children.active').children('.sidebar-sub-menu').css('display', 'block')
        jQuery('.tb-navdashboard ul li.menu-item-has-children').prepend('<span class="tb-dropdowarrow"><i class="ti-angle-down"></i></span>');
        jQuery('.tb-navdashboard .menu-item-has-children').on('click', function(e) {
            jQuery(this).toggleClass('tb-open');
            jQuery(this).children('.sidebar-sub-menu').slideDown(300);
            e.stopPropagation();
        });
    }

    jQuery(document).on("click",".menu-has-children",function(e){

        let _this = jQuery(this)
        if(!_this.hasClass('tb-openmenu')){

            jQuery('.menu-has-children').removeClass('tb-openmenu');
            jQuery('.sidebar-sub-menu').slideUp();
            _this.toggleClass('tb-openmenu')
            _this.children("ul").slideToggle(300)
        }
    }).on('click', '.menu-has-children li', function(e) {
        e.stopPropagation();
    });

    jQuery(window).on('load',function(){
        jQuery('.sidebar-sub-menu li.active').parents(".sidebar-sub-menu").css('display','block')
        jQuery('.sidebar-sub-menu li.active').parents(".menu-has-children").addClass('tb-openmenu')
    })
    // Select mCustomscrollbar
    jQuery('select').on('select2:open', function(e) {
        jQuery('.select2-results__options').mCustomScrollbar('destroy');
        setTimeout(function() {
            jQuery('.select2-results__options').mCustomScrollbar();
        }, 0);
    });

    jQuery('#filter_sort, #filter_per_page').select2(
        { allowClear: true,
            minimumResultsForSearch: Infinity,
            dropdownAutoWidth : true,
        }
    );


    jQuery(document).on("click",".tb-sidebartop > a",function(){
        jQuery("body").toggleClass("et-offsidebar")
    })



});

jQuery(document).on("click", function(event){
    var $trigger = jQuery(".tb-categorytree-dropdown");

    if($trigger !== event.target && !$trigger.has(event.target).length){
        jQuery(".tb-categorytree-dropdown").hide();
    }
});
