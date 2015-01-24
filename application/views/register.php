<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
<form method="post" action="<?php echo base_url(); ?>users/register">
  <div class="form-group">
    <label>First Name*</label>
    <input type="text" class="form-control" name="first_name" placeholder="Your first name" />
  </div>
  <div class="form-group">
    <label>Last Name*</label>
    <input type="text" class="form-control" name="last_name" placeholder="Last Name" />
  </div>
  <div class="form-group">
    <label>Email*</label>
    <input type="email" class="form-control" name="email" placeholder="Emali address" />
  </div>
  <div class="form-group">
    <label>Username*</label>
    <input type="text" class="form-control" name="username" placeholder="Username" />
  </div>
  <div class="form-group">
    <label>Password*</label>
    <input type="password" class="form-control" name="password" placeholder="Enter your password" />
  </div>
  <div class="form-group">
    <label>Confirm Password*</label>
    <input type="password" class="form-control" name="password2" placeholder="Confirm your password" />
  </div>
  <hr>
  <div class="form-group">
    <label>Address*</label>
    <input type="text" class="form-control" name="address" placeholder="Locality, Street, House Number" />
  </div>
  <div class="form-group">
    <label>Address2*</label>
    <input type="text" class="form-control" name="address2" placeholder="Directions and placemarks" />
  </div>
  <div class="form-group">
    <label>Phone Number*</label>
    <input type="number" class="form-control" name="phone" placeholder="Mobile number or fixed phone number" />
  </div>
  <div class="form-group">
    <label>City*</label>
    <input type="text" class="form-control" name="address" placeholder="Your City" />
  </div>
  <div class="form-group">
    <label>State*</label>
    <input type="text" class="form-control" name="address" placeholder="Current country and state" />
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Register</button>
</form>
