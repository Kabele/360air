<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Air360<?php if(isset($title)) echo ' - ' . $title; ?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="Air360 is a test airline web application" /> 
<?php if(isset($nocache)) echo '<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">';?>
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />

<!-- Style Sheets -->
<link rel="stylesheet" type="text/css" href="<?=base_url('css/main.css')?>">
<link rel="stylesheet" type="text/css" href="<?=base_url('css/jquery-ui-1.9.0.custom.css')?>">
<link rel="stylesheet" type="text/css" href="<?=base_url('css/jquery-ui-timepicker-addon.css')?>">

<?php if(isset($css)) echo '<style>'.$css.'</style>'; ?>

<!-- standard jquery, jquery plugins, and universal javascript -->
<script src="<?=base_url('js/jquery-1.8.2.js')?>"></script>
<script src="<?=base_url('js/jquery-ui-1.9.0.custom.js')?>"></script>
<script src="<?=base_url('js/jquery-ui-timepicker-addon.js')?>"></script>
<script src="<?=base_url('js/jquery.tablesorter.js')?>"></script>

<?php if(isset($js)) echo $js;?>

</head>
<body>

<div id="container">

<div id="header">
	<img src="<?=base_url('images/airplane_silo_inverted.png')?>"></img><br />
	<h1>360-air.com</h1>
	  
	<div id="navlinks" align="right">
		<?=anchor('', 'Home')?>
		<?=anchor('flights', 'Flights')?>
		<?=anchor('accounts', 'Accounts')?>
		<?=mailto('rkant@asu.edu?subject=360-air.com Support', 'Contact')?>
	</div>
</div>

<div id="wrapper">
<div id="content">
<?php
if($this->session->flashdata('status_message') || isset($status_message)) {
	$msg = '';
	if($this->session->flashdata('status_message'))
		$msg = $this->session->flashdata('status_message');
	else
		$msg = $status_message;
	echo '<div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>'.$msg.'</p></div></div><br />';
}

if($this->session->flashdata('error_message') || isset($error_message)) {
	$msg = '';
	if($this->session->flashdata('error_message'))
		$msg = $this->session->flashdata('error_message');
	else
		$msg = $error_message;
	echo '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error:</strong> '.$msg.'</p></div></div><br />';
}

if(isset($content)) echo $content;
?>

</div>
</div>

<div id="rightpane">
<!-- Widgets to appear on the right side of the page goes here -->
<?php if(isset($widgets)) echo $widgets ?>
</div>

<div id="footer"><p><center>(C) 2012 - Chance Cooper, Keilan Jackson & Ramsey Kant. Live Demo of <a href="https://github.com/RamseyK/360air">Github project.</a></center></p></div>

</div> <!-- end container -->
</body>
</html>

