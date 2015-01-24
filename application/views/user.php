<?php if ($this->session->flashdata('invalid_login')) : ?>
  <div class="alert alert-danger"><?php echo $this->session->flashdata('invalid_login');   ?></div>
<?php endif; ?>
<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
<form method="post" action="<?php echo base_url(); ?>users">
  <h3><?php echo $user->first_name." ".$user->last_name; ?></h3>
  <ul><li>Username: <?php echo $user->username; ?></li>
  <li>Email: <?php echo $user->email; ?></li>
  <li>Join date: <?php echo $user->join_date; ?></li>
  <li>Last IP: <?php echo $user->last_logon_ip; ?></li>
  <li>Geolocation: <?php echo $user->geolocation; ?></li>
  <li>last_active: <?php echo $user->last_active; ?></li>
  </ul>
  <hr>
  <input type="hidden" name="id" value="<?php echo $user->id; ?>">
  <div class="form-group">
    <label>Old Password*</label>
    <input type="password" class="form-control" name="old_password" placeholder="Enter your current password" />
  </div>
  <div class="form-group">
    <label>New Password*</label>
    <input type="password" class="form-control" name="password" placeholder="Enter your new password" />
  </div>
  <div class="form-group">
    <label>Confirm New Password*</label>
    <input type="password" class="form-control" name="password2" placeholder="Confirm your new password"  />
  </div>
  <hr>
  <div class="form-group">
    <label>Address*</label>
    <input type="text" class="form-control" name="address" placeholder="Locality, Street, House Number" value="<?php echo $user->address; ?>" />
  </div>
  <div class="form-group">
    <label>Address2*</label>
    <input type="text" class="form-control" name="address2" placeholder="Directions and placemarks" value="<?php echo $user->address2; ?>" />
  </div>
  <div class="form-group">
    <label>Phone Number*</label>
    <input type="number" class="form-control" name="phone" placeholder="Mobile number or fixed phone number" value="<?php echo $user->phone; ?>" />
  </div>
  <div class="form-group">
    <label>District/City*</label>
    <input type="text" class="form-control" name="city" placeholder="Your District, City" value="<?php echo $user->city; ?>" />
  </div>
  <div class="form-group">
    <label>Country/State*</label>
    <input type="text" class="form-control" name="state" placeholder="Current country and state" value="<?php echo $user->state; ?>" />
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Update</button>
</form>
