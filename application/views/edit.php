<form method="post" action="products/edit">
	<label>Product Title</label><input type="text" name="title" />
	<select name="category_id">
		<?php foreach(get_categories_h() as $category) : ?>
			<option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
		<?php endforeach; ?>
	</select>
	<input type="text" name="image" />
	<input type="number" name="price" />
	<input type="text" name="unit" />
	<input type="textarea" name="description" /> 
	<input type="textarea" name="nutritional_value" /> 
</form>