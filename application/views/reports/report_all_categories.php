<div class="row">
	<h3><?php echo $report_title; ?></h3>
	<table class="table table-striped">
		<tr><th>id</th><th>Category</th><th>Number of Products</th></tr>
		<?php foreach($categories as $category) : ?>
			<tr>
				<td><?php echo $category->id; ?></td>
				<td><a href="<?php echo base_url(); ?>products/<?php echo $category->id; ?>"><?php echo $category->name; ?></a></td>
				<td><?php echo $category->product_count; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<br />
</div>