<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">	
	<title><?php echo $html_title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>/favicon.ico">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css?v=2">

	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
<div id="loading-overlay">
  <img src="<?php echo base_url(); ?>assets/images/loading.gif" 
    id="img-load" />
</div>
<div class="msg-overlay"></div>
	<div class="container">
		<header>
			<div class="logo"><a href="<?php echo base_url(); ?>">Home</a></div>
			<nav>
				<ul class="unstyled">
					<li><a href="<?php echo site_url('generate/book'); ?>">Reference Generator</a></li>
					<li><div class="sep"></div></li>
					<li><a href="<?php echo site_url('mybib'); ?>">My Bibliography</a></li>
				</ul>
			</nav>
		</header>