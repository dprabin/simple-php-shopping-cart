<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
<form method="post" action="<?php echo base_url(); ?>users/edit_user/<?php echo $user->id; ?>">
  <h3><?php echo $user->first_name." ".$user->last_name; ?></h3>
  <ul><li>Username: <?php echo $user->username; ?></li>
  <li>Join date: <?php echo $user->join_date; ?></li>
  <li>Last IP: <?php echo $user->last_logon_ip; ?></li>
  <li>Geolocation: <?php echo $user->geolocation; ?></li>
  <li>last_active: <?php echo $user->last_active; ?></li>
  </ul>
  <hr>
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
  <div class="form-group">
    <label>Email Address*</label>
    <input type="email" class="form-control" name="email" placeholder="Your email address" value="<?php echo $user->email; ?>"  />
    <input type="hidden" name="old_email" value="<?php echo $user->email; ?>" />
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
  <?php if($this->session->userdata('previllege') == 'admin') : ?>
    <div class="form-group">
      <label>Previllege</label>
      <select name="previllege">
        <?php foreach($previlleges as $previllege) : ?>
          <option value="<?php echo $previllege->previllege; ?>" <?php echo ($user->previllege) == $previllege->previllege ? 'selected="selected"' : ''; ?> ><?php echo $previllege->previllege; ?></option>
      <? endforeach; ?>
      </select>
    </div>
  <?php endif; ?>
  <button type="submit" class="btn btn-primary" name="submit">Update</button>
</form>
