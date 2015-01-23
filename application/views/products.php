<?php if ($this->session->flashdata('registered')) : ?>
	<div class="alert alert-success"><?php echo $this->session->flashdata('registered'); ?></div>
<?php endif; ?>
<div class="row"><!-- Food items here -->
<?php foreach($products as $product) : ?>
	<div class="col-md-4 food">
		<div class="food-price">Rs.<?php echo $product->price; ?></div>
		<div class="food-image"><a href="<?php echo base_url(); ?>products/details/<?php echo $product->id; ?>"><img class="food-image-img" src="<?php echo base_url(); ?>assets/images/products/<?php echo $product->image; ?>" /></a></div>
		<div class="food-title"><?php echo $product->title; ?></div>
		<div class="food-add">
			<form method="post" action="<?php echo base_url(); ?>cart/add">
				QTY: <input type="text" class="qty" name="qty" value="1" /> 
				<input type="hidden" name="item_number" value="<?php echo $product->id; ?>" />
				<input type="hidden" name="price" value="<?php echo $product->price; ?>" />
				<input type="hidden" name="title" value="<?php echo $product->title; ?>" />
				<button class="btn btn-primary" type="submit">Add To Cart</button>
			</form>
		</div>
	</div>
<?php endforeach; ?>
</div><!-- /Food items -->


                
