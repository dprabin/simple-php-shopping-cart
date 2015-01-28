<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
<h3>New Category</h3>
<form method="post" action="<?php echo base_url(); ?>admin/add_category">
	<div class="form-group">
		<label>Category Name*</label>
		<input type="text" class="form-control" name="category_name" placeholder="Category name" value="<?php echo set_value('category_name'); ?>" />
	</div>
	<button type="submit" class="btn btn-primary" name="submit">Register</button>
</form>