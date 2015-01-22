<div class="row"><!-- Food items here -->
<?php foreach($products as $product) : ?>
	<div class="col-md-4 food">
		<div class="food-price">Rs.<?php echo $product->price; ?></div>
		<div class="food-image"><a href="<?php echo base_url(); ?>products/details/<?php echo $product->id; ?>"><img class="food-image-img" src="<?php echo base_url(); ?>assets/images/products/<?php echo $product->image; ?>" /></a></div>
		<div class="food-title"><?php echo $product->title; ?></div>
		<div class="food-add"><button class="btn btn-primary" type="submit">Add To Cart</button></div>
	</div>
<?php endforeach; ?>
</div><!-- /Food items -->


                
