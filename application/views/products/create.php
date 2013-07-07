<h2>Create a new product into <span style="color:rgb(200,90,20);"><?php echo $selected_category->name?></span></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('products/create/'.$selected_category->id) ?>

	<label for="name">Name</label> 
	<input type="input" name="name" /><br />

	<label for="article">Article</label>
	<input type="input" name="article" /><br />

	<label for="cost">Cost</label>
	<input type="input" name="cost" /><br />

	<input type="submit" name="submit" value="Create new product" /> 

</form>