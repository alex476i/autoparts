$(document).ready(function(){
	if($(window).width()>1600)
		$('.catalog-cat.cat1').click();
});


$(function () {
	pageY=0;
	$('.arrow-top').click(function(){
		pageY=window.pageYOffset;
		$('body,html').animate({scrollTop: 0}, 200);
		$('.arrow-top').hide();
		$('.arrow-down').addClass('to-click');
	});
	
	$('.arrow-down').click(function(){
		$('.arrow-down').removeClass('show-arr');
		$('.arrow-down').removeClass('to-click');
		$('body,html').animate({scrollTop: pageY}, 200);
	});
});

$(function () {
	$(window).scroll(function () {
		if ($(this).scrollTop() <= 50&&$('.arrow-down').hasClass('to-click')) {
			$('.arrow-down').addClass('show-arr');
		} 
		if ($(this).scrollTop() > 50) {
			$('nav').addClass('fix');
			$('.arrow-top').show();
			$('.arrow-down').removeClass('show-arr');
		} else {
			$('nav').removeClass('fix');
			$('.arrow-top').hide();
		}
/*		if ($(this).scrollTop() > 145) {
			$('aside.catalog').addClass('fix');
		} else {
			$('aside.catalog').removeClass('fix');
		}*/
	});
});


$(function () {
	$('.vetrin_item_cart.button').click(function(){
			// $.cookie('the_cookie'); // получить значение cookie
			
			// $.cookie('item_id', $(this).data('item-id')); //установить значение cookie


			var cart = $.cookie('cart');
			if (cart == undefined) {
				cart = {}
			} else {
				cart = JSON.parse(cart);
			}

			if ($(this).data('item-id') in cart) {
				cart[$(this).data('item-id')] ++;
			} else {
				cart[$(this).data('item-id')] = 1;
			}

			console.log(cart);
			$.cookie('cart', JSON.stringify(cart),{ expires: 7, path:'/' });


			// $.cookie('the_cookie', 'the_value', { expires: 7 }); //установить куки с временем жизни 7 дней 
			// $.cookie('the_cookie', '', { expires: -1 }); // удалить cookie
			// $.cookie('the_cookie', null); 

			$('.count').text(Object.keys(cart).length);
			$('.count').show(500);
	});
});

$(function () {
	$(document).on('click', '.count', function(){

		$.ajax({
			url: '/products/get_cart',
			dataType: 'text',
			success: function (data) {
				$('.cart').html(data);

				if($('.cart-act').hasClass('active')) {
					$('.cart-act').removeClass('active');
					$('.w').fadeOut(300);
					$('.window').fadeOut(300);
					$('.header.cart').css('background','url(/images/shop-cart.png) no-repeat');
				}
				else {
					if($('.cart_list_item').size()>3) {
						$(".cart_list_item").each(function(i) {
							if(i>2)
							$(this).hide();
						});
						if($(".window").find('.arrow-down-load').size()==0)
						$('<span class="arrow-down-load" style="margin-top:10px;margin-bottom:10px;width:100%;background-position:center;height:30px;cursor:pointer"></span>').insertAfter('.cart_list');
					}			
					$('.cart-act').addClass('active');
					$('.w').fadeIn().show(100);
					$('.window').fadeIn().show(100);
					$('.header.cart').css('background','url(/images/shop-cart-active.png) no-repeat');
				}	
			}
		});
	
	});
	
	$(document).on('click','.w,.cart_footer_buy',function(){
		$('.w').fadeOut().hide(300);
		$('.window').fadeOut().hide(300);
		$('.header.cart').css('background','url(/images/shop-cart.png) no-repeat');
		if($('.cart-act').hasClass('active')) {
			$('.cart-act').removeClass('active');
		}
		
	});

	$(document).on('click','.cart_footer_clear',function(){
		$('.w').fadeOut().hide(300);
		$('.window').fadeOut().hide(300);
		$('.header.cart').css('background','url(/images/shop-cart.png) no-repeat');
		$('.count').fadeOut(400);
		$.cookie('cart','',{expires: -1,path:'/'});
	});

	$(document).on('click', '.cart_list_item_remove', function() {
		$(this).parent('.cart_list_item').fadeOut('400', function(){ 
			
			$(this).remove();

			$('.cart_list_item').each(function() {
				if($('.cart_list_item').size()<=3)
					$('.arrow-down-load').fadeOut().hide(100, function(){ $(this).remove(); });

				if($(this).css('display')=='none') {
					$(this).fadeIn(300,function(){$(this).css('display','table')});
					return false;
				}
			});

			if($('.cart_list_item').size()==0){
				$('.w').fadeOut().hide(300);
				$('.window').fadeOut().hide(300);
				$('.header.cart').css('background','url(/images/shop-cart.png) no-repeat');
				$('.count').fadeOut().hide(500);
			}
		});
	});
});
/*catalog*/


var carrent_tab;

$(function () {

	$('.catalog-cat-item a').click (function(){
		$.cookie('cat-tab',$(this).parents('.catalog-cat-item').attr('tab'),{path:'/'});
		$.cookie('cat-tab-sub',$('a').index(this),{path:'/'});
	});
	
	$('.catalog-cat-items-list>ul>li ul>li').each(function() {
		if ($(this).children('ul').children().length > 0)  {
			var after=$(this).children('a');
			$('<span class="arrow-li"></span>').insertAfter(after);
			//$(this).addClass('parent');
			//$(this).children('a').addClass('parent');
		}
	});


	$('.arrow-li').on('click', function(){
		var toggle_ul=$(this).next('ul');
		$(this).toggleClass('open');
		$(toggle_ul).toggleClass('sub');
		toggle_ul.toggle(500);
		// $('li.parent').find('a.parent').not(toggle_img).removeClass('open');
		// $('li.parent').find('ul').not(toggle_ul).hide(500);		
	});
	
	$(document).ready(function(){
		if($(window).width()>1800) {
			$('.catalog-cat').each(function() {
				if($(this).attr('tab')==$.cookie('cat-tab'))
					$(this).click();
			});
			$('a:eq('+$.cookie('cat-tab-sub')+')').css('color','red');

			$('a:eq('+$.cookie('cat-tab-sub')+')').parents('li').children('.arrow-li').click();
			// $('a:eq('+$.cookie('cat-tab-sub')+')').parent('li').parent().prev().click();

			// $('a:eq('+$.cookie('cat-tab-sub')+')').parent('li').parent().parent('li').parent().prev().click();

		}
	});
	
	$('.catalog-cat').on('click', function(){
		var tab=$(this).attr('tab');
		$('.catalog-cat').not(this).removeClass('active');
		
		if($('aside.catalog').width()!=400) {
			$(this).addClass('active');
			$('.catalog-cat-items-list').css('border-left','1px solid #e8e8e8');
			$('aside.catalog').animate({
						width:400,
						height:600
			},500);
			
			// $('.catalog-cat-item').each(function() {
			// 	if($(this).attr('tab')==tab) {
			// 		$(this).delay(400).fadeIn();
			// 		carrent_tab=$(this);
			// 	}
			// });

			$('.catalog-cat-items-list>ul>li').each(function() {
				if($(this).attr('tab')==tab) {
					$(this).delay(400).fadeIn();
					carrent_tab=$(this);
				}
			});
		}
		else {
			if($(this).hasClass('active')) {
				$(carrent_tab).hide();
				$(this).removeClass('active');
				$('aside.catalog').animate({width:60,height:300},500);
				$('.catalog-cat-list').css('border-right','none');
			}
			else {
				$(this).addClass('active');
				$('.catalog-cat-items-list>ul>li').hide();
				$('.catalog-cat-items-list>ul>li').each(function() {
					if($(this).attr('tab')==tab) {
						$(this).delay(400).fadeIn();
						carrent_tab=$(this);
					}
				});	
			}
		}
	});
});
	
/*Блоки*/
$(function () {
	var s = 0;
	var j = 1;
	var n=1;
	var heighttmp=0;
	var maxheight=0;
	arr=[];
	if($('.vetrin_item').size()>4) {

		$('.vetrin_item').each(function(i,element)
			{	
				if(i!=0&&i%4==0)
				{s=0;j++}
				arr.push($(this).height()+10);
				var height=0;
				
				if (i-4<0) {
					$(this).css({
						position : "absolute",
						weight: "239px",
						left: s*246+'px',
						top: '0px',
					});
				}
				else {
					for (n=1;n<j;n++)
					{
						height+=arr[i-4*n];
					}
					console.log(heighttmp=height+arr[i]+10);
					heighttmp=height+arr[i]+10;
					if(maxheight<heighttmp){maxheight=heighttmp;}
					$(this).css({
						position : "absolute",
						weight: "239px",
						left: s*246+'px',
						top: height+'px',
					});
				}
				s++;
			});
		console.log(arr);
		$('.vetrin').css('height',maxheight);
	}
});
$(function () {
	var s = 0;
	var j = 1;
	var n;
	var heighttmp=0;
	var maxheight=0;
	arr=[];
	$('.news_item').each(function(i,element)
		{	
			if(i!=0&&i%4==0)
			{s=0;j++}
			arr.push($(this).height()+20);
			var height=0;
			
			if (i-4<0) {
				$(this).css({
					position : "absolute",
					weight: "208px",
					left: s*246+'px',
					top: '0px',
				});
			}
			else {
				for (n=1;n<j;n++)
				{
					height+=arr[i-4*n];
				}
				heighttmp=height+arr[i]+10;
				if(maxheight<heighttmp){maxheight=heighttmp;}
				$(this).css({
					position : "absolute",
					weight: "239px",
					left: s*246+'px',
					top: height+'px',
				});
			}
			s++;
		});
	$('.news').css('height',maxheight);
});		