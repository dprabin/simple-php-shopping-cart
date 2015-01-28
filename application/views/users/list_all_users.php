<div class="row">
	<h3>All users of the system</h3>
	<table class="table table-striped">
		<tr><th>id</th><th>Username</th><th>Full Name</th><th>Phone</th><th>Address</th><th>Previllege</th><th>Last active</th><th></th></tr>
		<?php foreach($users as $user) : ?>
			<tr>
				<td><?php echo $user->id; ?></td>
				<td><a href="<?php echo base_url(); ?>users/edit_user/<?php echo $user->id; ?>"><?php echo $user->username; ?></a><br ><a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a></td>
				<td><?php echo $user->first_name; ?> <?php echo $user->last_name; ?></td>
				<td><?php echo $user->phone; ?></td>
				<td><?php echo $user->address; ?>, <?php echo $user->address2; ?>, <?php echo $user->city; ?>, <?php echo $user->state; ?></td>
				<td><a href="<?php echo base_url(); ?>admin/users_by_previllege/<?php echo $user->previllege; ?>"><?php echo $user->previllege; ?></a></td>
				<td><?php echo $user->last_active; ?><br><?php echo $user->last_logon_ip; ?><br><?php echo $user->geolocation; ?></td>
				<td><?=anchor("admin/delete_user/".$user->id,"Delete",array('onclick' => "return confirm('Do you want delete this user?')"))?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<br />
	<p><a href="<?php echo base_url(); ?>users/register">+ Add User</a></p>
</div>