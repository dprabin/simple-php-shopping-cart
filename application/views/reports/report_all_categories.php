<div class="row">
	<h3><?php echo $report_title; ?></h3>
	<table class="table table-striped">
		<tr><th>id</th><th>Category</th><th>Number of Products</th><th></th><th></th></tr>
		<?php foreach($categories as $category) : ?>
			<tr>
				<td><?php echo $category->id; ?></td>
				<td><a href="<?php echo base_url(); ?>admin/products_by_category/<?php echo $category->name; ?>"><?php echo $category->name; ?></a></td>
				<td><?php echo $category->product_count; ?></td>
				<td><a href="<?php echo base_url(); ?>admin/edit_category/<?php echo $category->id; ?>">Edit</a></td>
				<td><a href="<?php echo base_url(); ?>admin/delete_category/<?php echo $category->id; ?>">Delete</a></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<br />
	<p><a href="<?php echo base_url(); ?>admin/add_category">+ Add Category</a></p>
</div>