<h2>Update product <span style="color:rgb(200,90,20);"><?php echo $category->name, ' / ', $product->name ?></span></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('products/edit/'.$product->id) ?>

	<label for="name">Name</label> 
	<input type="input" name="name" value="<?php echo $product->name ?>" /><br />

	<label for="article">Article</label>
	<input type="input" name="article" value="<?php echo $product->article ?>" /><br />

	<label for="cost">Cost</label>
	<input type="input" name="cost" value="<?php echo $product->cost ?>" /><br />

	<input type="submit" name="submit" value="Update a product" /> 

</form>