<?php
header("Content-type: text/html; charset=UTF-8");

include("header.inc.php");

$data = genHeader();



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
<head>
  <title>Frugalware Linux - Let's make things Frugal!</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
  <link rel="stylesheet" type="text/css" href="<?php echo $fwng_root; ?>static/fwng.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $fwng_root; ?>static/_proform.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $fwng_root; ?>static/common.css" />
  <link rel="icon" href="<?php echo $fwng_root; ?>images/favicon.ico" />
  <script type="text/javascript" src="<?php echo $fwng_root; ?>static/menu.js">
  /* AnyLink CSS Menu script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
   * This notice MUST stay intact for legal use
   * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code */
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
	<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>"><img src="<?php echo $fwng_root; ?>images/header.png" alt="Frugalware Linux - Let's make things Frugal!" /></a>
</div>
<!-- header end -->

<!-- nav start -->
<div id="nav">
        &ensp;<?php echo $menucontent; ?>
</div>
<!-- nav end -->

<!-- main content start -->
<div id="leftcolumn">
<?php
fwsidebox(gettext("Releases"), $data['releases']);
fwsidebox(gettext("Recent updates"), $data['packages']);
fwsidebox(gettext("Languages"), $langcontent);
fwsidebox(gettext("Information"), $validcontent);
fwsidebox(gettext("Server information"), $data['uptime']);
?>
</div>
<div id="centercolumn">
