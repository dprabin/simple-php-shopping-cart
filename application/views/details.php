<div class="row details">
	<div class="col-md-12"><div class="details-food-title"><h3><?php echo $product->title; ?></h3></div></div>
	<div class="col-md-8">
		<div class="food-image-details"><img class="food-image-img" src="<?php echo base_url(); ?>assets/images/products/<?php echo $product->image; ?>" /></div>
		<div class="details-food-price">Price: Rs.<?php echo $product->price; ?> per <?php echo $product->unit; ?></div>
		<div class="details-buy">
			<form method="post" action="<php echo base_url(); ?>cart/add">
				Quantity: <input type="text" class="qty" name="qty" value="1" /> 
				<input type="hidden" name="item_number" value="<?php echo $product->id; ?>" />
				<input type="hidden" name="price" value="<?php echo $product->price; ?>" />
				<input type="hidden" name="title" value="<?php echo $product->title; ?>" />
				<button class="btn btn-primary" type="submit">Add To Cart</button>
			</form>
		</div>
		<div class="details-description"><p><?php echo $product->description; ?></p></div>
	</div>
	<div class="col-md-4">

		<div class="details-description">
		  <h4>Nutritional value</h4>
		  <p><?php echo $product->nutritional_value; ?></p>
		</div>
	</div>
</div>