<div class="row">
	<h3>All users of the system</h3>
	<table class="table table-striped">
		<tr><th>id</th><th>Username</th><th>Full Name</th><th>Previllege</th><th></th></tr>
		<?php foreach($users as $user) : ?>
			<tr>
				<td><?php echo $user->id; ?></td>
				<td><a href="<?php echo base_url(); ?>users/edit_user/<?php echo $user->username; ?>"><?php echo $user->name; ?></a></td>
				<td><?php echo $user->full_name; ?></td>
				<td><a href="<?php echo base_url(); ?>admin/users_by_previllege/<?php echo $user->previllege; ?>"><?php echo $user->previllege; ?></a></td>
				<td><?=anchor("admin/delete_user/".$user->id,"Delete",array('onclick' => "return confirm('Do you want delete this record?')"))?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<br />
	<p><a href="<?php echo base_url(); ?>admin/add_category">+ Add Category</a></p>
</div>