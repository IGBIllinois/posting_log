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

<body style='padding-top: 60px; padding-bottom: 60px;'>
<nav class='navbar fixed-top navbar-dark bg-dark py-0'>
	<a class='navbar-brand' href='#'><?php echo settings::get_title(); ?></a>
	<span class='navbar-text'>
	<a class='btn btn-sm btn-primary' href='index.php'><i class='fas fa-download'></i> Downloads</a>
	<a class='btn btn-sm btn-success' href='uploads.php'><i class='fas fa-upload'></i> Uploads</a>
	<a class='btn btn-sm btn-secondary' href='about.php'><i class='fas fa-info-circle'></i> About</a>
	</span>
</nav>
<p>
<div class='container-fluid'>
	<div class='row'>
	</div>

<div class='col-md-12 col-lg-12 col-xl-12'>
