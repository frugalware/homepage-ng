<?php
header("Content-type: text/html; charset=UTF-8");

include("xml.inc.php");
if (file_exists('xml/roadmap.xml'))
	$xmlfl = 'xml/roadmap.xml';
else
	$xmlfl = $docs_path.'xml/roadmap.xml';
$xml = file_get_contents($xmlfl);
$parser = new XMLParser($xml);
$parser->Parse();
$roadmap = $parser->document->release;
$j = 0;
for ( $i = 0; $i < count($roadmap); $i++)
{
	if ($roadmap[$i]->status[0]->tagData == 1)
	{
		$stable[$j][name] = $roadmap[$i]->name[0]->tagData;
		$stable[$j][version] = $roadmap[$i]->version[0]->tagData;
		$stable[$j][date] = $roadmap[$i]->date[0]->tagData;
		$stable[$j][newsid] = $roadmap[$i]->newsid[0]->tagData;
		$j++;
	}
}
$rels = "";
for ( $i=0; $i<count($stable); $i++ )
{
	$rels .= "<p><a href=\"".$fwng_root."news/".$stable[$i][newsid]."\">frugalware-".$stable[$i][version]." (".$stable[$i][name].")</a><br />".$stable[$i][date]."</p>\n";
}
$rels .= "<p align=\"center\">\n<a href=\"${fwng_root}rss/releases\">RSS</a>\n</p>\n";

include("db.inc.php");
if(file_exists($pkgcache))
	        $info = stat($pkgcache);
if(!(isset($info) && ((time() - $info["mtime"])<$pkgcachetimeout)))
{
	$db = new FwDB();
	$db->doConnect($sqlhost, $sqluser, $sqlpass, $sqldb);
	$query = "select packages.pkgname, groups.name, packages.id, 
		packages.pkgver, packages.arch, packages.`desc`, 
		unix_timestamp(packages.builddate) from packages, groups, 
		ct_groups where packages.id = ct_groups.pkg_id and 
		ct_groups.group_id = groups.id group by 
		concat(packages.pkgname, packages.arch) order by 
		packages.builddate desc limit 10";
	$result = $db->doQuery($query);
	while($i = $db->doFetchRow($result))
		$pkgs[] = $i;
	$db->doClose();
	$fp = fopen($pkgcache, "w");
	fwrite($fp, "<div align=\"left\">\n");
	foreach($pkgs as $i)
	{
		$writeout = $i['name'] . "/${i['pkgname']}";
		if (strlen($writeout) > 20)
			$writeout = $i['name'] . "/<br />&nbsp;${i['pkgname']}";
		fwrite($fp, $writeout."<br />\n" .
			"<a href=\"${fwng_root}packages/${i['id']}\">${i['pkgver']}-${i['arch']}</a><br />\n");
	}
	fwrite($fp, "</div>");
	fwrite($fp, "<br />\n<div align=\"center\"><a href=\"${fwng_root}rss/packages\">RSS</a></div>");
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
fwsidebox(gettext("Releases"), $rels);
fwsidebox(gettext("Recent updates"), $recupd);
fwsidebox(gettext("Languages"), $langcontent);
fwsidebox(gettext("Information"), $validcontent);
fwsidebox(gettext("Server information"), $uptime);
?>
</div>
<div id="centercolumn">
