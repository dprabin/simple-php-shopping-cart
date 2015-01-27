<div class="row">
<?php foreach($all_orders as $order) : ?>
	<div class="col-md-4 food">
		<div class="food-price">Rs.<div class="food-price-per-unit"><?php echo $order->price; ?></div><br />per <?php echo $order->unit; ?></div>
		<div class="food-title"><?php echo $order->title; ?></div>
	</div>
<?php endforeach; ?>
</div>