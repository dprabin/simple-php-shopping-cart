<div class="row">
	<table class="table table-striped">
		<tr><th>id</th><th>Order By</th><th>Phone</th><th>Address</th><th>Order item</th><th>Qty</th><th>Price</th><th>Time</th></tr>
		<?php foreach($pending_orders as $order) : ?>
			<tr>
				<td><?php echo order->id; ?></td>
				<td><?php echo order->fullname; ?></td>
				<td><?php echo order->phone; ?></td>
				<td><?php echo order->fulladdress; ?></td>
				<td><?php echo order->title; ?></td>
				<td><?php echo order->qty; ?></td>
				<td><?php echo order->price; ?></td>
				<td><?php echo order->timestamp; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>