<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
<h3>New Category</h3>
<form method="post" action="<?php echo base_url(); ?>admin/edit_category">
	<input type="hidden" name="category_id" value="<?php echo $category->id; ?>">
	<div class="form-group">
		<label>Category Name*</label>
		<input type="text" class="form-control" name="category_name" placeholder="Category name" value="<?php echo $category->name; ?>" />
	</div>
	<button type="submit" class="btn btn-primary" name="submit">Register</button>
</form>