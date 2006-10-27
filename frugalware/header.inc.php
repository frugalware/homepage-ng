<?php
/**
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License v2 as published by
 the Free Software Foundation

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 GNU General Public License for more details.
 */

/**
 * Frugalware Linux Homepage - New Generation
 *
 * @author Alex Smith <alex@alex-smith.me.uk>
 * @copyright Copyright (c) 2006. Alex Smith
 */

include("xml.inc.php");
include("config.inc.php");
include("db.inc.php");

function genHeader($usegettext = true) {
	
	global $fwng_root;
	global $sqltype;
	global $sqlhost;
	global $sqluser;
	global $sqlpass;
	global $sqldb;
	global $pkgcache;
	global $pkgcachetimeout;
	global $upfile;
	global $docs_path;
	
	// Find where the XML roadmap file is
	if (file_exists('xml/roadmap.xml'))
		$xmlfl = 'xml/roadmap.xml';
	else
		$xmlfl = $docs_path.'xml/roadmap.xml';
	
	// And read it in
	$xml = file_get_contents($xmlfl);
	$parser = new XMLParser($xml);
	$parser->Parse();
	$roadmap = $parser->document->release;
	
	// Produce a better readable structure
	$j = 0;
	for ( $i = 0; $i < count($roadmap); $i++) {
		
		if ($roadmap[$i]->status[0]->tagData == 1) {
			
			$stable[$j][name] = $roadmap[$i]->name[0]->tagData;
			$stable[$j][version] = $roadmap[$i]->version[0]->tagData;
			$stable[$j][date] = $roadmap[$i]->date[0]->tagData;
			$stable[$j][newsid] = $roadmap[$i]->newsid[0]->tagData;
			$j++;
			
		}
		
	}
	
	// Create the info
	$rels = "";
	for ( $i=0; $i<count($stable); $i++ ) {
		
		$rels .= "<p><a href=\"".$fwng_root."news/".$stable[$i][newsid]."\">frugalware-".$stable[$i][version]." (".$stable[$i][name].")</a><br />".$stable[$i][date]."</p>\n";
		
	}
	
	$rels .= "<p align=\"center\">\n<a href=\"${fwng_root}rss/releases\">RSS</a>\n</p>\n";
	
	if(file_exists($pkgcache))
		$info = stat($pkgcache);
	
	if(!(isset($info) && ((time() - $info["mtime"])<$pkgcachetimeout))) {
		
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
		
		foreach($pkgs as $i) {
			
			$writeout = $i['name'] . "/${i['pkgname']}";
			if (strlen($writeout) > 20)
				$writeout = $i['name'] . "/<br />&nbsp;${i['pkgname']}";
			fwrite($fp, $writeout."<br />\n" .
				"<a href=\"${fwng_root_pre}packages/${i['id']}\">${i['pkgver']}-${i['arch']}</a><br />\n");
			
		}
		
		fwrite($fp, "</div>");
		fwrite($fp, "<br />\n<div align=\"center\"><a href=\"${fwng_root}rss/packages\">RSS</a></div>");
		fclose($fp);
		
	}
	
	$recupd = file_get_contents($pkgcache);
	
	$statf = file($upfile);
	list($uptime, $junk) = split(" ", $statf[0]);
	$secuptime=floor($uptime);
	
	// Seconds
	$minuptime=60*floor($uptime/60);
	$sec= $secuptime - $minuptime;
	
	// Minutes
	$houruptime=3600*floor($minuptime/3600);
	$min= $minuptime - $houruptime;
	
	// Hours
	$dayuptime=86400*floor($houruptime/86400);
	$hour= $houruptime - $dayuptime;
	
	// Final uptime
	if ($usegettext)
		$uptime = sprintf(gettext("Uptime:<br /> %d day(s) %d h %d m %d s"), $dayuptime/86400, $hour/3600, $min/60, $sec);
	else
		$uptime = sprintf("Uptime:<br /> %d day(s) %d h %d m %d s", $dayuptime/86400, $hour/3600, $min/60, $sec);
	
	// Generate the array and give it back.
	$data = array("releases" => $rels, "packages" => $recupd, "uptime" => $uptime);
	return $data;
}
?>
