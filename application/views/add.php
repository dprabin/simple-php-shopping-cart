<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>

<?php echo form_open_multipart(base_url().'products/add'); ?>
<!--form method="post" action="?php echo base_url(); ?>products/add" enctype="multipart/form-data" -->
<?php echo $this->config->item('upload_path')."<br>".$this->config->item('upload_url'); ?>

	<div class="form-group">
		<label>Product Title</label>
		<input type="text" name="title" value="<?php echo set_value('title'); ?>" class="form-control" />
	</div>
	<div class="form-group">
		<label>Product Category</label>
		<select name="category_id">
			<?php foreach(get_categories_h() as $category) : ?>
				<option value="<?php echo $category->id; ?>" <?php echo set_value('category_id') == $category->id ? 'selected="selected"' : ''; ?> ><?php echo $category->name; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="form-group">
		<label>Product Image</label>
		<input type="file" name="userfile" value="<?php echo set_value('userfile'); ?>" class="form-control" />
	</div>
	<div class="form-group">
		<label>Product Price</label>
		<input type="number" name="price" value="<?php echo set_value('price'); ?>" class="form-control" />
	</div>
	<div class="form-group">
		<label>Unit of product</label>
		<input type="text" name="unit" value="<?php echo set_value('unit','Packet'); ?>" class="form-control" />
	</div>
	<div class="form-group">
		<label>Description</label>
		<textarea name="description" rows="5" class="form-control"><?php echo set_value('description'); ?> </textarea> 
	</div>
	<div class="form-group">
		<label>Nutritional Value</label>
		<textarea name="nutritional_value" rows="5" class="form-control"><?php echo set_value('nutritional_value'); ?></textarea>
	</div>
	<button type="submit" class="btn btn-primary" name="submit">Add New Product</button>
</form>