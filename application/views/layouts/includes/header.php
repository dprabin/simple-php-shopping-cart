<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>The Sasto Ramro Food Place</title>

<!-- Bootstrap core CSS -->
<link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
<!-- script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script-->
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>


</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url(); ?>">The Sasto Ramro Food Place  </a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?php echo base_url(); ?>">Home</a></li>
        <?php if(!$this->session->userdata('logged_in')) : ?>
          <li><a href="<?php echo base_url(); ?>users/register">Create Account</a></li>
        <?php else : ?>
          <li><a href="<?php echo base_url(); ?>users">Logged in as <?php echo $this->session->userdata('username'); ?></a></li>
        <?php endif; ?>
      </ul>
      <?php if(!$this->session->userdata('logged_in')) : ?>
        <form method="post" action="<?php echo base_url(); ?>users/login" class="navbar-form navbar-right">
          <div class="form-group">
            <input name="username" type="text" class="form-control" placeholder="Username">
          </div>
          <div class="form-group">
            <input name="password" type="password" class="form-control" placeholder="Password">
          </div>
          <button name="submit" type="submit" class="btn btn-default">Login</button>
        </form>
      <?php else : ?>
        <form method="post" action="<?php echo base_url(); ?>users/logout" class="navbar-form navbar-right">
          <button name="submit" type="submit" class="btn btn-default">Logout</button>
        </form>
      <?php endif; ?>
    </div><!--/.nav-collapse -->
  </div>
</nav>

<div class="container">

  <div class="starter-template">
    <div class="row">

      <div class="col-md-3"><!-- Left sidebar -->
          <?php $this->load->view('layouts/includes/sidebar'); ?>
      </div><!--/Left sidebar -->

      <!-- Right sidebar -->
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading panel-heading-green">
            <h3 class="panel-title">The Sasto Ramro Food Place</h3>
          </div>
          <div class="panel-body">