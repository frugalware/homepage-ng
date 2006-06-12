<?php
header("Content-type: text/html; charset=UTF-8");

include("db.inc.php");
if(file_exists($pkgcache))
	        $info = stat($pkgcache);
if(!(isset($info) && ((time() - $info["mtime"])<$pkgcachetimeout)))
{
	$db = new FwDB();
	$db->doConnect($sqlhost, $sqluser, $sqlpass, $sqldb);
	$query = "select groups, pkgname, id, pkgver, pkgrel, arch from packages order by updated desc limit 10";
	$result = $db->doQuery($query);
	while($i = $db->doFetchRow($result))
		$pkgs[] = $i;
	$db->doClose();
	$fp = fopen($pkgcache, "w");
	fwrite($fp, "<div align=\"left\">\n");
	foreach($pkgs as $i)
		fwrite($fp, preg_replace("/^([^ ]*) .*/", "$1", $i['groups']) . "/${i['pkgname']}<br>" .
		"<a href=\"packages.php?id=${i['id']}\">${i['pkgver']}-${i['pkgrel']}-${i['arch']}</a><br>");
	fwrite($fp, "</div><p>");
	fwrite($fp, "<a href=\"/rss.php?type=packages\">RSS</a>");
	fclose($fp);
}
$recupd = file_get_contents($pkgcache);

$statf=file($upfile);
list($uptime, $junk) = split(" ", $statf[0]);
$secuptime=floor($uptime);
// sec
$minuptime=60*floor($uptime/60);
$sec= $secuptime - $minuptime;
// min
$houruptime=3600*floor($minuptime/3600);
$min= $minuptime - $houruptime;
// hour
$dayuptime=86400*floor($houruptime/86400);
$hour= $houruptime - $dayuptime;
$uptime = sprintf(gettext("Uptime:<br /> %d day(s) %d h %d m %d s"), $dayuptime/86400, $hour/3600, $min/60, $sec);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
<head>
  <title>Frugalware Linux - Let's make things Frugal!</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="<?php echo $fwng_root; ?>static/fwng.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $fwng_root; ?>static/_proform.css" />
  <link rel="icon" href="<?php echo $fwng_root; ?>images/favicon.ico" />
  <script type="text/javascript" src="<?php echo $fwng_root; ?>static/menu.js">
  /* AnyLink CSS Menu script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
   * This notice MUST stay intact for legal use
   * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code */
  </script>
  <!--script language="javascript" type="text/javascript">
  <!- Don't know why is this here, have to test whether it's used or not...
    function chgclass(divid, vis)
    {
      document.getElementById(divid).style.visibility=vis;
    }
  ->
</script-->
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

<!-- wrapper start -->
<div id="wrapper">

<!-- header start -->
<div id="header">
  <!--<div id="search">
    <p>
      <a href="http://www.google.com/"><img src="<?php echo $fwng_root; ?>images/google.gif" alt="Google" width="75" height="32" align="middle" border="0" title="Google" /></a>
    </p>
    <form action="http://www.google.com/custom" method="get" enctype="multipart/form-data">
      <input type="text" name="q" size="15" maxlength="150" />
      <input type="submit" name="sa" value="<?php echo gettext("Search"); ?>" />
      <input type="hidden" name="domains" value="frugalware.org" />
      <input type="hidden" name="sitesearch" value="frugalware.org" />
    </form>
  </div>-->
  <img src="<?php echo $fwng_root; ?>images/header.png" alt="Frugalware Linux - Let's make things Frugal!" />
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
fwsidebox(gettext("Recent updates"), $recupd);
fwsidebox(gettext("Languages"), $langcontent);
fwsidebox(gettext("Information"), $validcontent);
fwsidebox(gettext("Server informations"), $uptime);
?>
</div>
<div id="centercolumn">
