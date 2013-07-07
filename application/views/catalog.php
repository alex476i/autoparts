<!DOCTYPE html>
<html lang="ru">
<head>
<title>Автомагаз</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script src="/js/jquery.min.js?v1.10.1"></script>
<!--расскомментить на хостинге, или где есть интернет
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"><\/script>')</script>-->
<!-- <script src="/js/bjqs-1.3.js"></script> -->
<script src="/js/script.js"></script>
<script src="/js/jquery.cookie.js"></script>
<link rel="stylesheet" href="/css/reset.css" />
<link rel="stylesheet" href="/css/style.css" />
<link rel="stylesheet" href="/css/bjqs.css" />
</head>
<body>
	<div class="win-height">
	<?php $this->load->view('share/header'); ?>

	<?php $this->load->view('catalog_menu'); ?>
	
<!-- 	<section class="slider" style="display: none">
		<div id="banner-slide">
	        
	        <ul class="bjqs">
	          <li><img src="/upload/images/1.jpg"></li>
	          <li><img src="/upload/images/1.jpg"></li>
	          <li><img src="/upload/images/1.jpg"></li>
	        </ul>
	        end Basic jQuery Slider
		</div>
		<script>
	        $(document).ready(function($) {
	          
	          $('#banner-slide').bjqs({
	            animtype      : 'slide',
	            width         : 980,
	            responsive    : true,
	            randomstart   : true
	          });
	          
	        });
		</script>
	</section> -->


	<style>
		.catalog-cat-items-list>ul>li>ul>li ul {
			display: none;
		}		

	</style>
	
	<section class="vetrin catalog">
		<aside class="catalog">
			<?php 

				$arr = $catalog_menuitems;

				echo '<div class="catalog-cat-list">';
				foreach ($arr as $item) {
					if ($item->parent_id == 0) {
						echo "<div class=\"catalog-cat cat".$item->ico_class."\" tab=\"".$item->id."\"></div>";
					}
				};
				echo '</div>';

				function load_menu($parent_id, $items) {
					echo '<ul>';
					foreach ($items as $item) {
						if ($item->parent_id == $parent_id) {
							if ($item->parent_id == 0) {
								echo "<li class='catalog-cat-item' tab='".$item->id."'>";
							}
							else {
								echo "<li>";
							}		
							echo "<a href='/products/show/".$item->id."'>", $item->name, "<br><span>", $item->description, "</span></a>";
							// echo "<a href='/products/show/".$item->id."'>", $item->name, "</a>";
							load_menu($item->id, $items);
							echo "</li>";
							
						}
					};
					echo "</ul>";
				};

				
				echo '<div class="catalog-cat-items-list">';
				load_menu(0, $arr);
				echo '</div>';
			?>	

			</aside>
	
			<?php foreach ($products as $item) { ?>

				<article class="vetrin_item">
					<div class="vetrin_item_img">
						<img src="/upload/images/01.jpg">
					</div>
					<div class="cf"></div>
					<div class="vetrin_item_text">
						<h2><?php echo $item->name ?></h2>
						<h3>Марка: <b>Лада</b></h3>
						<h3>Модель автомобиля: <b>ВАЗ 2108 2109</b></h3>
						
						<p><?php echo $item->description ?></p>
						
						<div class="vetrin_item_cost">
							<?php echo number_format($item->cost, 2) ?> руб
						</div>
						<div class="vetrin_item_cart button" data-item-id="<?php echo $item->id ?>">
							В корзину
						</div>
						
						<div class="cf"></div>
					</div>
				</article>
			<?php } ?>
			
	</section>
	<?php if(sizeof($products)>8){?>
	<section class="show-all">
		Посмотреть весь каталог
		<span class="arrow-down-load"></span>
	</section>
	<?}?>
	<div class="footer-fix"></div>
</div>
	<?php $this->load->view('share/footer'); ?>

</body>
</html>