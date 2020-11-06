<?php

require_once 'includes/main.inc.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script src='vendor/components/jquery/jquery.min.js' type='text/javascript'></script>
<script src='vendor/components/jqueryui/jquery-ui.min.js' type='text/javascript'></script>
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

<link rel='stylesheet' href='vendor/components/jqueryui/themes/base/jquery-ui.css'>
<link rel="stylesheet" type="text/css" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="vendor/fortawesome/font-awesome/css/all.min.css">

<title><?php echo settings::get_title(); ?></title>

</head>

<body style='padding-top: 70px; padding-bottom: 60px;'>
<nav class='navbar fixed-top navbar-dark bg-dark'>
	<a class='navbar-brand' href='#'><?php echo settings::get_title(); ?></a>
	<span class='navbar-text'>
	<a class='btn btn-primary' href='index.php'>Downloads</a>
	<a class='btn btn-success' href='uploads.php'>Uploads</a>
	<a class='btn btn-secondary' href='about.php'>About</a>
	</span>
</nav>
<p>
<div class='container-fluid'>
	<div class='row'>
	</div>

<div class='col-md-12 col-lg-12 col-xl-12'>
