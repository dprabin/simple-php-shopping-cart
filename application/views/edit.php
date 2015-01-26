<?php if ($this->session->flashdata('action_unsuccessful')) : ?>
  <div class="alert alert-danger"><?php echo $this->session->flashdata('action_unsuccessful');   ?></div>
<?php endif; ?>
<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>

<form method="post" action="products/edit">
	<div class="form-group">
		<label>Product Title</label>
		<input type="text" name="title" value="<?php echo $product->title; ?>" class="form-control" />
	</div>
	<div class="form-group">
		<label>Product Category</label>
		<select name="category_id">
			<?php foreach(get_categories_h() as $category) : ?>
				<option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="form-group">
		<label>Product Image</label>
		<!--img class="food-image-img" src="<?php echo base_url(); ?>assets/images/products/<?php echo $product->image; ?>" width="150px" /-->
		<input type="text" name="image" value="<?php echo $product->image; ?>" class="form-control" />
	</div>
	<div class="form-group">
		<label>Product Price</label>
		<input type="number" name="price" value="<?php echo $product->price; ?>" class="form-control" />
	</div>
	<div class="form-group">
		<label>Unit of product</label>
		<input type="text" name="unit" value="<?php echo $product->unit; ?>" class="form-control" />
	</div>
	<div class="form-group">
		<label>Description</label>
		<textarea name="description" rows="5" class="form-control"><?php echo $product->description; ?> </textarea> 
	</div>
	<div class="form-group">
		<label>Nutritional Value</label>
		<textarea name="nutritional_value" rows="5" class="form-control"><?php echo $product->nutritional_value; ?></textarea>
	</div>
	<button type="submit" class="btn btn-primary" name="submit">Update</button>
</form>