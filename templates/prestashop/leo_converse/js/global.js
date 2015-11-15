/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
//global variables
var responsiveflag = false;
var comparedProductsIds = [];
$(document).ready(function(){
	highdpiInit();
	responsiveResize();      
	floatHeader();      
	$(window).resize(responsiveResize);
    backtotop();
	$('.verticalmenu .dropdown-toggle').prop('disabled', true);
        $('.verticalmenu .dropdown-toggle').data('toggle', '');
        $(".verticalmenu .caret").click(function(){
            var $parent  = $(this).parent();
            $parent.toggleClass('open')
            return false;
        });
        if ($(document).width() >990) $('.verticalmenu').addClass('active-hover');
        else $('.verticalmenu').removeClass('active-hover');
        $(window).resize(menuleftResize);
        
	//scrollSliderBarMenu();
	if (navigator.userAgent.match(/Android/i))
	{
		var viewport = document.querySelector('meta[name="viewport"]');
		viewport.setAttribute('content', 'initial-scale=1.0,maximum-scale=1.0,user-scalable=0,width=device-width,height=device-height');
		window.scrollTo(0, 1);
	}
	if (typeof quickView !== 'undefined' && quickView)
		quick_view();
	dropDown();

	if (typeof page_name != 'undefined' && !in_array(page_name, ['index', 'product']))
	{
		bindGrid();

		$(document).on('change', '.selectProductSort', function(e){
			if (typeof request != 'undefined' && request)
				var requestSortProducts = request;
			var splitData = $(this).val().split(':');
			var url = '';
			if (typeof requestSortProducts != 'undefined' && requestSortProducts)
			{
				url += requestSortProducts ;
				if (typeof splitData[0] !== 'undefined' && splitData[0])
				{
					url += ( requestSortProducts.indexOf('?') < 0 ? '?' : '&') + 'orderby=' + splitData[0] + (splitData[1] ? '&orderway=' + splitData[1] : '');
					if (typeof splitData[1] !== 'undefined' && splitData[1])
						url += '&orderway=' + splitData[1];
				}
				document.location.href = url;
			}
		});

		$(document).on('change', 'select[name="n"]', function(){
			$(this.form).submit();
		});

		$(document).on('change', 'select[name="currency_payment"]', function(){
			setCurrency($(this).val());
		});
	}

	$(document).on('change', 'select[name="manufacturer_list"], select[name="supplier_list"]', function(){
		if (this.value != '')
			location.href = this.value;
	});

	$(document).on('click', '.back', function(e){
		e.preventDefault();
		history.back();
	});

	jQuery.curCSS = jQuery.css;
	if (!!$.prototype.cluetip)
		$('a.cluetip').cluetip({
			local:true,
			cursor: 'pointer',
			dropShadow: false,
			dropShadowSteps: 0,
			showTitle: false,
			tracking: true,
			sticky: false,
			mouseOutClose: true,
			fx: {
				open:       'fadeIn',
				openSpeed:  'fast'
			}
		}).css('opacity', 0.8);

	if (!!$.prototype.fancybox)
		$.extend($.fancybox.defaults.tpl, {
			closeBtn : '<a title="' + window.FancyboxI18nClose + '" class="fancybox-item fancybox-close" href="javascript:;"></a>',
			next     : '<a title="' + window.FancyboxI18nNext + '" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
			prev     : '<a title="' + window.FancyboxI18nPrev + '" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
		});

	// Close Alert messages
	$(".alert.alert-danger").on('click', this, function(e){
		if (e.offsetX >= 16 && e.offsetX <= 39 && e.offsetY >= 16 && e.offsetY <= 34)
			$(this).fadeOut();
	});
	
	$('.slide').on('slide.bs.carousel', function() {
		$(this).css('overflow','hidden');
	});
	$('.slide').on('slid.bs.carousel', function() {
		$(this).css('overflow','visible');
	});
});

function menuleftResize(removeOpen){
    if ($(document).width() >990)
    {
        $('.verticalmenu .dropdown').removeClass('open');
        $('.verticalmenu').addClass('active-hover');
    }else{
    	$('.verticalmenu').removeClass('active-hover');
    }
}

function scrollSliderBarMenu(){
    var menuElement = $(".float-vertical");
    var columnElement = null;
    var maxWindowSize = 990;
    
    if($(menuElement).hasClass('float-vertical-right'))
        columnElement = $("#right_column");
    else if($(menuElement).hasClass('float-vertical-left'))
        columnElement = $("#left_column");
    //auto display slider bar menu when have left or right column
    if($(columnElement).length && $(window).width()>=maxWindowSize) showOrHideSliderBarMenu(columnElement, menuElement, 1);
    $(".float-vertical-button").click(function(){
        if($(menuElement).hasClass('active')) showOrHideSliderBarMenu(columnElement, menuElement, 0);
        else showOrHideSliderBarMenu(columnElement, menuElement, 1);
    });

    var lastWidth = $(window).width();
    $(window).resize(function() {
    	if($(window).width()!=lastWidth){
	        if($(window).width()<maxWindowSize) {
	            if($(menuElement).hasClass('active')) showOrHideSliderBarMenu(columnElement, menuElement, 0);
	        }else{
	            if($(columnElement).length && !$(menuElement).hasClass('active')) showOrHideSliderBarMenu(columnElement, menuElement, 1);
	        }
	        lastWidth = $(window).width();
    	}
    });
}

function showOrHideSliderBarMenu(columnElement, menuElement, active){
    if(active){
        $(menuElement).addClass('active');
        if($(columnElement).length && $(window).width()>=990) 
            columnElement.css('padding-top',($('.block_content',$(menuElement)).height())+'px');
    }else{
        $(menuElement).removeClass('active');
        if($(columnElement).length) columnElement.css('padding-top','');
    }
}

function highdpiInit()
{
	if($('.replace-2x').css('font-size') == "1px")
	{
		var els = $("img.replace-2x").get();
		for(var i = 0; i < els.length; i++)
		{
			src = els[i].src;
			extension = src.substr( (src.lastIndexOf('.') +1) );
			src = src.replace("." + extension, "2x." + extension);

			var img = new Image();
			img.src = src;
			img.height != 0 ? els[i].src = src : els[i].src = els[i].src;
		}
	}
}


// Used to compensante Chrome/Safari bug (they don't care about scroll bar for width)
function scrollCompensate()
{
	var inner = document.createElement('p');
	inner.style.width = "100%";
	inner.style.height = "200px";

	var outer = document.createElement('div');
	outer.style.position = "absolute";
	outer.style.top = "0px";
	outer.style.left = "0px";
	outer.style.visibility = "hidden";
	outer.style.width = "200px";
	outer.style.height = "150px";
	outer.style.overflow = "hidden";
	outer.appendChild(inner);

	document.body.appendChild(outer);
	var w1 = inner.offsetWidth;
	outer.style.overflow = 'scroll';
	var w2 = inner.offsetWidth;
	if (w1 == w2) w2 = outer.clientWidth;

	document.body.removeChild(outer);

	return (w1 - w2);
}

function responsiveResize()
{
	compensante = scrollCompensate();
	if (($(window).width()+scrollCompensate()) <= 767 && responsiveflag == false)
	{
		accordion('enable');
		accordionFooter('enable');
		responsiveflag = true;
	}
	else if (($(window).width()+scrollCompensate()) >= 768)
	{
		accordion('disable');
		accordionFooter('disable');
		responsiveflag = false;
		if (typeof bindUniform !=='undefined')
			bindUniform();
	}
	// blockHover();
}
/*
function blockHover(status)
{
	var screenLg = $('body').find('.container').width() == 1170;

	if ($('.product_list').is('.grid'))
		if (screenLg)
			$('.product_list .button-container').hide();
		else
			$('.product_list .button-container').show();

	$(document).off('mouseenter').on('mouseenter', '.product_list.grid li.ajax_block_product .product-container', function(e){
		if (screenLg)
		{
			var pcHeight = $(this).parent().outerHeight();
			var pcPHeight = $(this).parent().find('.button-container').outerHeight() + $(this).parent().find('.comments_note').outerHeight() + $(this).parent().find('.functional-buttons').outerHeight();
			$(this).parent().addClass('hovered').css({'height':pcHeight + pcPHeight, 'margin-bottom':pcPHeight * (-1)});
			$(this).find('.button-container').show();
		}
	});

	$(document).off('mouseleave').on('mouseleave', '.product_list.grid li.ajax_block_product .product-container', function(e){
		if (screenLg)
		{
			$(this).parent().removeClass('hovered').css({'height':'auto', 'margin-bottom':'0'});
			$(this).find('.button-container').hide();
		}
	});
}
*/
function quick_view()
{
	$(document).on('click', '.quick-view:visible, .quick-view-mobile:visible', function(e){
		e.preventDefault();
		if (this.rel)
			var url = this.rel;
		else
			var url = $(this).data('link');
		var anchor = '';

		if (url.indexOf('#') != -1)
		{
			anchor = url.substring(url.indexOf('#'), url.length);
			url = url.substring(0, url.indexOf('#'));
		}

		if (url.indexOf('?') != -1)
			url += '&';
		else
			url += '?';

		if (!!$.prototype.fancybox)
			$.fancybox({
				'padding':  0,
				'width':    1087,
				'height':   610,
				'type':     'iframe',
				'href':     url + 'content_only=1' + anchor
			});
	});
}

function bindGrid()
{
	var view = $.totalStorage('display');

	if (!view && (typeof displayList != 'undefined') && displayList)
		view = 'list';

        gridType = "grid";
        if($("#page").data("type") != 'undefined') gridType = $("#page").data("type");
        if(view && view != gridType) display(view);
        else display(gridType);
	$(document).on('click', '#grid', function(e){
		e.preventDefault();
		
		display('grid');
		$.totalStorage('display', 'grid');
	});

	$(document).on('click', '#list', function(e){
		e.preventDefault();
		
		display('list');
		$.totalStorage('display', 'list');
	});
}

function display(view)
{

		$('.display').find('div').removeClass('selected');
		$('.display').find('div#'+view).addClass('selected');
        classGrid = "col-xs-12 col-sm-6 col-md-4";
        if($("#page").data("column") != 'undefined') classGrid = $("#page").data("column");
	if (view == 'list')
	{
		$('.product_list').removeClass('grid').addClass('list');
		$('.product_list > div').removeClass(classGrid).addClass('col-xs-12');
		$('.product_list > div').each(function(index, element) {
			html = '';
			html = '<div class="product-container product-block text-center"><div class="row">';
				html += '<div class="left-block col-md-4 col-sm-4">' + $(element).find('.left-block').html() + '</div>';
				html += '<div class="right-block col-md-8 col-sm-8">' + $(element).find('.right-block').html() + '</div>';	
			html += '</div></div>';
		$(element).html(html);
		});		
		$('.display').find('li#list').addClass('selected');
		$('.display').find('li#grid').removeAttr('class');
		//$.totalStorage('display', 'list');
	}
	else 
	{
		$('div.product_list').removeClass('list').addClass('grid');
		$('.product_list > div').removeClass('col-xs-12').addClass(classGrid);
		$('.product_list > div').each(function(index, element) {
		html = '';
		html += '<div class="product-container product-block text-center">';
			html += '<div class="left-block">' + $(element).find('.left-block').html() + '</div>';
			html += '<div class="right-block">' + $(element).find('.right-block').html() + '</div>';
		html += '</div>';		
		$(element).html(html);
		});
		$('.display').find('li#grid').addClass('selected');
		$('.display').find('li#list').removeAttr('class');
		//$.totalStorage('display', 'grid');
	}
	if (typeof addEffectProducts == 'function') { 
		addEffectProducts();
	}
}

function dropDown()
{
	elementClick = '#header .current';
	elementSlide =  'ul.toogle_content';
	activeClass = 'active';

	$(elementClick).on('click', function(e){
		e.stopPropagation();
		var subUl = $(this).next(elementSlide);
		if(subUl.is(':hidden'))
		{
			subUl.slideDown();
			$(this).addClass(activeClass);
		}
		else
		{
			subUl.slideUp();
			$(this).removeClass(activeClass);
		}
		$(elementClick).not(this).next(elementSlide).slideUp();
		$(elementClick).not(this).removeClass(activeClass);
		e.preventDefault();
	});

	$(elementSlide).on('click', function(e){
		e.stopPropagation();
	});

	$(document).on('click', function(e){
		e.stopPropagation();
		var elementHide = $(elementClick).next(elementSlide);
		$(elementHide).slideUp();
		$(elementClick).removeClass('active');
	});
}

function accordionFooter(status)
{
	if(status == 'enable')
	{
		$('#footer .footer-block h4').on('click', function(){
			$(this).toggleClass('active').parent().find('.toggle-footer').stop().slideToggle('medium');
		})
		$('#footer').addClass('accordion').find('.toggle-footer').slideUp('fast');
	}
	else
	{
		$('.footer-block h4').removeClass('active').off().parent().find('.toggle-footer').removeAttr('style').slideDown('fast');
		$('#footer').removeClass('accordion');
	}
}

function accordion(status)
{
	if(status == 'enable')
	{
		var accordion_selector = '#right_column .block .title_block, #left_column .block .title_block, #left_column #newsletter_block_left h4,' +
								'#left_column .shopping_cart > a:first-child, #right_column .shopping_cart > a:first-child';

		$(accordion_selector).on('click', function(e){
			$(this).toggleClass('active').parent().find('.block_content').stop().slideToggle('medium');
		});
		$('#right_column, #left_column').addClass('accordion').find('.block .block_content').slideUp('fast');
		if (typeof(ajaxCart) !== 'undefined')
			ajaxCart.collapse();
	}
	else
	{
		$('#right_column .block .title_block, #left_column .block .title_block, #left_column #newsletter_block_left h4').removeClass('active').off().parent().find('.block_content').removeAttr('style').slideDown('fast');
		$('#left_column, #right_column').removeClass('accordion');
	}
}
function bindUniform()
{
	if (!!$.prototype.uniform)
		$("select.form-control,input[type='radio'],input[type='checkbox']").not(".not_unifrom").uniform();
}

function processFloatHeader(headerAdd, scroolAction){
	if(headerAdd){
		$("#header").addClass( "navbar-fixed-top" );
		var hideheight =  $("#header").height()+120;
		$("#page").css( "padding-top", $("#header").height() );
		setTimeout(function(){
			$("#page").css( "padding-top", $("#header").height() );
		},200);
	}else{
		$("#header").removeClass( "navbar-fixed-top" );
		$("#page").css( "padding-top", '');
	}

	var pos = $(window).scrollTop();
    if( scroolAction && pos >= hideheight ){
        $("#topbar").addClass('hide-bar');
        $(".hide-bar").css( "margin-top", - $("#topbar").height() );
        $("#header-main").addClass("mini-navbar");
    }else {
        $("#topbar").removeClass('hide-bar');
        $("#topbar").css( "margin-top", 0 );
        $("#header-main").removeClass("mini-navbar");
    }
}

//Float Menu
function floatHeader(){
	if (!$("body").hasClass("keep-header") || $(window).width() <= 990){
		return;
	}
	
	$(window).resize(function(){
		if ($(window).width() <= 990)
		{
			processFloatHeader(0,0);
		}
		else if ($(window).width() > 990)
		{
			if ($("body").hasClass("keep-header"))
				processFloatHeader(1,1);
		}
	});
	var headerScrollTimer;

    $(window).scroll(function() {
    	if(headerScrollTimer) {
	        window.clearTimeout(headerScrollTimer);
	    }

    	headerScrollTimer = window.setTimeout(function() {
	        if (!$("body").hasClass("keep-header")) return;
	        if($(window).width() > 990){
	        	processFloatHeader(1,1);
    		}
	    }, 100);
    });
}

// Back to top
function backtotop(){
	// hide #back-top first
	$("#back-top").hide();

	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
}
