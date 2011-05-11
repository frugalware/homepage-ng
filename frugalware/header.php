<?php
header("Content-type: text/html; charset=UTF-8");

include("header.inc.php");

$data = genHeader();



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
<head>
  <title>Frugalware Linux - Let's make things Frugal!</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="description" content="Frugalware Linux, a general purpose linux distribution, designed for intermediate users."/>
  <link rel="icon" href="<?php echo $fwng_root; ?>images/favicon.ico" />
    <!-- CSS -->
  
  <link rel="stylesheet" type="text/css" href="<?php echo $fwng_root; ?>static/fwng.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $fwng_root; ?>static/_proform.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $fwng_root; ?>static/common.css" />
  <link rel="stylesheet" href="<?php echo $fwng_root; ?>static/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
  
  <!-- JavaScript -->

  <script type="text/javascript" src="<?php echo $fwng_root; ?>static/menu.js">
  /* AnyLink CSS Menu script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
   * This notice MUST stay intact for legal use
   * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code */
  </script>
  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo $fwng_root; ?>static/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
  
  <script type="text/javascript">
		$(document).ready(function() {
			$("a#imagebox").fancybox();
	    });
  </script>

<script type="text/javascript">
/* <![CDATA[ */
    (function() {
        var s = document.createElement('script'), t = document.getElementsByTagName('script')[0];
        s.type = 'text/javascript';
        s.async = true;
        s.src = 'http://api.flattr.com/js/0.6/load.js?mode=auto';
        t.parentNode.insertBefore(s, t);
    })();
/* ]]> */
</script>

<?
if($_SERVER['PHP_SELF']=="/index.php")
	print('<link rel="alternate" type="application/rss+xml" title="RSS" href="http://'
		. $_SERVER["SERVER_NAME"] . "${fwng_root}rss/news\" />\n");
else if($_SERVER['PHP_SELF']=="/packages.php")
	print('<link rel="alternate" type="application/rss+xml" title="RSS" href="http://'
		. $_SERVER["SERVER_NAME"] . "${fwng_root}rss/packages\" />\n");
?>
</head>
<body>

<!-- header start -->
<div id="header">
	<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>"><object width="66" height="66" type="image/svg" data="<?php echo $fwng_root; ?>images/header.svg"><img alt="Frugalware Linux - Let's make things Frugal!" src="<?php echo $fwng_root; ?>images/header.png"></object><span id="title">FRUGALWARE LINUX</span><span id="slogan">Let’s make things frugal!</span></a>
</div>
<!-- header end -->

<!-- nav start -->
<div id="nav">
        &ensp;<?php echo $menucontent; ?>
</div>
<!-- nav end -->
<div id='bigwrap'>
<!-- main content start -->

<div id="rightcolumn">
<?php
fwsidebox(gettext("Languages"), $langcontent);
fwsidebox(gettext("Recent updates"), $data['packages']);
fwsidebox(gettext("Releases"), $data['releases']);
if ($data['paypal'] != '')
	fwsidebox(gettext("Donations"), $data['paypal']);
fwsidebox(gettext("Information"), $validcontent);
fwsidebox(gettext("Server information"), $data['uptime']);
?>
</div>
<div id="centercolumn">
