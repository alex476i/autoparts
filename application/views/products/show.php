<div id="products-container" style="float:left; width:600px;">
	<h2><?php echo $selected_category->name?></h2>
	<h4>[ move here ]</h4>
	<?php 
		echo "<div id='subcats' style='float:left; width:600px;'>";
		if (count($subcats) > 0) {
			echo "<h2>sub-categories</h2>";
			foreach ($subcats as $key => $value) {
				$subcat = unserialize($key);
				echo 
					"<div style='width: 280px; float:left; border-top:1px solid; margin-right:10px;'>", 
						"<span class='select-category' data-id='", $subcat->id, "'>", $subcat->selected == 1 ? "unselect " : "select ", " </span><a href='/products/show/".$subcat->id."'>", $subcat->name, "</a>";
				foreach ($value as $item) {
					echo "<p>", $item->name, "</p>";
				};
				echo 
					"</div>";
			};
		};
		echo "</div>";

		echo "<div id='products' style='float:left; width:600px;'>";
		echo "<h2>products</h2>";
		if (count($products) > 0) {			
			foreach ($products as $item) {
				echo 
					"<div style='width: 280px; float:left; border-top:1px solid; margin-right:10px;'>", 
						"<p><span class='select-product' data-id='", $item->id, "'>", $item->selected == 1 ? "unselect " : "select ", " </span><a href='/products/edit/", $item->id, "'>", $item->name, "</a></p>",
						"<p>", $item->cost, "</p>",
						"<p>", $item->article, "</p>",
					"</div>";
			};
		};
		echo "</div>";
		echo "<h3>Click <a href='/products/create/".$selected_category->id."' style='color:rgb(200,90,20);'>this</a> button to add new product into the <span style='color:rgb(200,90,20);'>", $selected_category->name, " </span>category</h3>";
		echo "<h3>Click <a href='' style='color:rgb(200,90,20);'>this</a> button to add new sub-category into the <span style='color:rgb(200,90,20);'>", $selected_category->name, " </span>category</h3>";
		echo "<h3>Click <a href='' style='color:rgb(200,90,20);'>this</a> button to drop all selected items</h3>";
	?>
</div>

<script>
	$(document).on('ready', function() {
		$('.select-product').on('click', function() {
			var self = $(this);
			$.ajax({
				url: '/products/select/',
				dataType: 'json',
				data: {
					id: $(self).data('id')
				},
				success: function(data) {
					$('#selected-items').children().remove();
					$.each(data, function() {
						$('#selected-items').append('<p>' + this.name + '</p>');
					});
				}
			});
		});
	});
</script>