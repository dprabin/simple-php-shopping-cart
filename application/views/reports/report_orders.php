<div class="row">
	<h3><?php echo $report_title; ?></h3>
	<table class="table table-striped">
		<tr><th>id</th><th>Order By</th><th>Phone</th><th>Address</th><th>Order item</th><th>Qty</th><th>Price</th><th>Time</th><th>Status</th></tr>
		<?php foreach($orders as $order) : ?>
			<tr>
				<td><?php echo $order->id; ?></td>
				<td><a href="<?php echo base_url(); ?>reports/orders_by_user/<?php echo $order->user_id; ?>"><?php echo $order->fullname; ?></a></td>
				<td><?php echo $order->phone; ?></td>
				<td><?php echo $order->fulladdress; ?></td>
				<td><a href="<?php echo base_url(); ?>reports/orders_by_product/<?php echo $order->product_id; ?>"><?php echo $order->title; ?></a></td>
				<td><?php echo $order->qty; ?></td>
				<td><?php echo $order->price; ?></td>
				<td><?php echo $order->timestamp; ?></td>
				<td><a href="<?php echo base_url(); ?>reports/orders_by_status/<?php echo $order->status; ?>"><?php echo ucwords($order->status); ?></a></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<br />
	<ul>
		<li><a href="<?php echo base_url(); ?>reports/all_orders">All Orders list</a></li>
		<li><a href="<?php echo base_url(); ?>reports/orders_by_status/pending">Pending Orders</a></li>
		<li><a href="<?php echo base_url(); ?>reports/orders_by_status/Settled">Settled Orders</a></li>
		<li><a href="<?php echo base_url(); ?>reports/orders_by_status/delivered">Delivered Orders</a></li>
		<li><a href="<?php echo base_url(); ?>reports/orders_by_status/canceled">Canceled Orders</a></li>
	</ul>
</div>