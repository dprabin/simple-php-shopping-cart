<?php if($this->cart->contents()): ?>
	<form method="post" action="cart/process">
		<table class="table table-striped">
			<tr>
				<th>Quantity</th>
				<th>Item Title</th>
				<th style="text-align:right">Item Price</th>
			</tr>
			<?php $i = 0; ?>
			<?php foreach($this->cart->contents() as $items): ?>
				<tr>
					<td><?php echo $items['qty'] ?></td>
					<td><?php echo $items['name'] ?></td>
					<td style="text-align:right"><?php echo $this->cart->format_number($items['price']) ?></td>
				</tr>
				<input type="hidden" name="<?php echo 'item_name['.$i.']'; ?>" value="<?php echo $items['name'] ?>" />
				<input type="hidden" name="<?php echo 'item_code['.$i.']'; ?>" value="<?php echo $items['id'] ?>" />
				<input type="hidden" name="<?php echo 'item_qty['.$i.']'; ?>" value="<?php echo $items['qty'] ?>" />
			<?php endforeach; ?>
			<tr>
				<td></td>
				<td class="right"><strong>Shipping</strong></td>
				<td class="right" style="text-align:right"><?php echo $this->config->item('shipping'); ?></td>
			</tr>
			<tr>
				<td></td>
				<td class="right"><strong>Tax</strong></td>
				<td class="right" style="text-align:right"><?php echo $this->config->item('tax'); ?></td>
			</tr>
			<tr>
				<td></td>
				<td class="right"><strong>Total</strong></td>
				<td class="right" style="text-align:right">Rs. <?php echo $this->cart->format_number($this->cart->total());//add shipping and tax ?></td>
			</tr>
		</table>
		<br />
		<?php if(!$this->session->userdata('logged_in')) : ?>
			<p><a href="<?php echo base_url(); ?>users/register" class="btn btn-primary">Register</a></p>
			<p><em>You must log in to make purchases.</em></p>
		<?php else : ?>
			<h3>Goods Delivery Info</h3>
			<div class="form-group">
				<label>Address</label>
				<input type="text" class="form-control" name="address" value="<?php echo $user->address; ?>" />
			</div>
			<div class="form-group">
				<label>Address 2</label>
				<input type="text" class="form-control" name="address2" value="<?php echo $user->address2; ?>" />
			</div>
			<div class="form-group">
				<label>Phone</label>
				<input type="text" class="form-control" name="phone" value="<?php echo $user->phone; ?>" />
			</div>
			<div class="form-group">
				<label>City</label>
				<input type="text" class="form-control" name="city" value="<?php echo $user->city; ?>" />
			</div>
			<div class="form-group">
				<label>State</label>
				<input type="text" class="form-control" name="state" value="<?php echo $user->state; ?>" />
			</div>
			<button class="btn btn-primary" type="submit" name="submit">Checkout</button>
		<?php endif; ?>
	</form>
<?php else: ?>
	<p>There are no items in your cart</p>
<?php endif; ?>