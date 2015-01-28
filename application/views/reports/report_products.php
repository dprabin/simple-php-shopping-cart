<div class="row">
	<h3><?php echo $report_title; ?></h3>
	<table class="table table-striped">
		<tr><th>id</th><th>Product Name</th><th>Category</th><th>Price</th><th>Unit</th><th>Image</th><th>Description</th><th>Nutritional value</th><th></th></tr>
		<?php foreach($products as $product) : ?>
			<tr>
				<td><?php echo $product->id; ?></td>
				<td><a href="<?php echo base_url(); ?>products/edit/<?php echo $product->id; ?>"><?php echo $product->title; ?></a></td>
				<td><a href="<?php echo base_url(); ?>admin/products_by_category/<?php echo $product->name; ?>"><?php echo $product->name; ?></a></td>
				<td><?php echo $product->price; ?></td>
				<td><?php echo $product->unit; ?></td>
				<td><?php echo $product->image; ?></td>
				<td><?php echo mb_substr($product->description, 0, strpos($product->description, ' ', 20)); ?> <a href="<?php echo base_url(); ?>products/details/<?php echo $product->id; ?>" >read more</a></td>
				<td><?php echo mb_substr($product->nutritional_value, 0, strpos($product->nutritional_value, ' ', 40)); ?> <a href="<?php echo base_url(); ?>products/details/<?php echo $product->id; ?>" >read more</a></td>
				<td><?=anchor("products/delete/".$product->id,"Delete",array('onclick' => "return confirm('Do you want delete this product?')"))?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<br />
</div>