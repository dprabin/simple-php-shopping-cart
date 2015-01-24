<div class="row"><!-- Food items here -->
<?php foreach($category_items as $category) : ?>
	<div class="col-md-4 food">
		<div class="food-price">Rs.<?php echo $category->price; ?></div>
		<div class="food-image"><a href="<?php echo base_url(); ?>products/details/<?php echo $category->id; ?>"><img class="food-image-img" src="<?php echo base_url(); ?>assets/images/products/<?php echo $category->image; ?>" /></a></div>
		<div class="food-title"><?php echo $category->title; ?></div>
		<div class="food-add">
			<form method="post" action="<?php echo base_url(); ?>cart/add">
				QTY: <input type="text" class="qty" name="qty" value="1" /> 
				<input type="hidden" name="item_number" value="<?php echo $category->id; ?>" />
				<input type="hidden" name="price" value="<?php echo $category->price; ?>" />
				<input type="hidden" name="title" value="<?php echo $category->title; ?>" />
				<button class="btn btn-primary" type="submit">Add To Cart</button>
			</form>
		</div>
	</div>
<?php endforeach; ?>
</div><!-- /Food items -->