<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Air360<?php if(isset($title)) echo ' - ' . $title; ?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="Air360 is a test airline web application" /> 
<?php if(isset($nocache)) echo '<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">';?>

<!-- Style Sheets -->
<link rel="stylesheet" type="text/css" href="<?=base_url('css/main.css')?>">
<link rel="stylesheet" type="text/css" href="<?=base_url('css/jquery-ui-1.9.0.custom.css')?>">

<?php if(isset($css)) echo '<style'.$css.'</style>'; ?>

<!-- standard jquery, jquery plugins, and universal javascript -->
<script src="<?=base_url('js/jquery-1.8.2.js')?>"></script>
<script src="<?=base_url('js/jquery-ui-1.9.0.custom.js')?>"></script>

<?php if(isset($js)) echo $js;?>

</head>
<body>
<div id="container">
<img src="<?=base_url('images/airplane_new.jpeg')?>"></img><br />
<font color="red" size="6"><b>360-air.com</b></font>
  
<div id="navlinks" align="right">
	<a href="Main Page.html">Home</a>
	<a href="Flights.html">Flights</a>
	<a href="News.html">News</a>
	<a href="Account.html">Account</a>
	<a href="Contact.html">Contact</a>
</div>

<div id="wrapper">
<div id="content">

<?php if(isset($content)) echo $content ?>

</div>
</div>

<div id="rightpane">
<!-- Widgets to appear on the right side of the page goes here -->
<?php if(isset($widgets)) echo $widgets ?>
</div>

<div id="footer"><p><center>(C) 2012, 360-air.com.</center></p></div>

</div> <!-- end container -->
</body>
</html>

