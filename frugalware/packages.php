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
 * Frugalware Linux Homepage - Package and file search page
 *
 * @author Krisztian VASAS <iron@frugalware.org>
 * @author Miklos Vajna <vmiklos@frugalware.org>
 *
 * @copyright Copyright (c) 2006. Krisztian VASAS
 * @copyright Copyright (c) 2005-2006. Miklos Vajna
 */

// include some useful functions
include("functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

// include the config and let's start page
include("config.inc.php");
include("db.inc.php");
include("header.php");

function main()
{
	global $sqlhost, $sqluser, $sqlpass;
	if ( is_numeric($_GET[id]) )
	{
		if ($_GET['s'] == "f")
			file_from_id($_GET['id']);
		else
			pkg_from_id($_GET['id']);
	}
	else
	{
		$db = new FwDB();
		$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware");
		$res = $db->doQuery("select version from releases where type='stable' order by version desc");
		while ( $row = $db->doFetchRow($res) )
		{
			$arr[] = "\t\t\t<option value=\"".$row[0]."\">".$row[0]."</option>\n";
		}
		$db->doClose();
		$content = "<form name=\"pkgsrch\" action=\"/packages/\" method=\"get\">
	<fieldset class=\"pkg\"><legend>".gettext("Package search")."</legend>
		<input type=\"hidden\" name=\"op\" value=\"pkg\" />
		<label for=\"pkgsrc\">".gettext("Search for a package:")."</label><input class=\"required\" type=\"text\" id=\"pkgsrc\" name=\"srch\" size=\"40\" />
		<br />
		<input class=\"required\" type=\"checkbox\" name=\"sub\" id=\"substr\" /><label for=\"substr\" class=\"pkg-phrasing\">".gettext("Search for substring")."</label>
		<br />
		<input class=\"required\" type=\"checkbox\" name=\"desc\" id=\"descr\" /><label for=\"descr\" class=\"pkg-phrasing\">".gettext("Search in description")."</label>
		<br />
		<label for=\"repos\">".gettext("Repository:")."</label>
		<select name=\"repo\" id=\"repos\" class=\"required\">
			<option value=\"all\" selected=\"selected\">all</option>
			<option value=\"frugalware\">frugalware</option>
			<option value=\"extra\">extra</option>
		</select>
		<br />
		<label for=\"archs\">".gettext("Architecture:")."</label>
		<select name=\"arch\" id=\"archs\" class=\"required\">
			<option value=\"i686\" selected=\"selected\" class=\"required\">i686</option>
			<option value=\"x86_64\">x86_64</option>
		</select>
		<br />
		<label for=\"fwver\">".gettext("Version:")."</label>
		<select name=\"ver\" id=\"fwver\" class=\"required\">
			<option value=\"current\" selected=\"selected\">current</option>\n";
		foreach ( $arr as $i )
		{
			$content .= $i;
		}
		$content .= "
		</select>
		<br />
		<input type=\"submit\" value=\"".gettext("Search")."\" /> <input type=\"reset\" value=\"".gettext("Reset")."\" />
	</fieldset>
</form>
<form name=\"filesrch\" action=\"/packages/\" method=\"get\">
	<fieldset class=\"pkg\"><legend>".gettext("File search")."</legend>
		<input type=\"hidden\" name=\"op\" value=\"file\" />
		<label for=\"filesrc\">".gettext("Search for a file:")."</label><input class=\"required\" type=\"text\" id=\"filesrc\" name=\"srch\" size=\"40\" />
		<br />
		<label for=\"frepos\">".gettext("Repository:")."</label><select name=\"repo\" id=\"frepos\" class=\"required\">
			<option value=\"all\" selected=\"selected\">all</option>
			<option value=\"frugalware\">frugalware</option>
			<option value=\"extra\">extra</option>
		</select>
		<br />
		<label for=\"archs\">".gettext("Architecture:")."</label>
		<select name=\"arch\" id=\"archs\" class=\"required\">
			<option value=\"all\">all</option>
			<option value=\"i686\" selected=\"selected\">i686</option>
			<option value=\"x86_64\">x86_64</option>
		</select>
		<br />
		<label for=\"fwver\">".gettext("Version:")."</label>
		<select name=\"ver\" id=\"fwver\" class=\"required\">
			<option value=\"all\">all</option>
			<option value=\"current\" selected=\"selected\">current</option>\n";
		foreach ( $arr as $i )
		{
			$content .= $i;
		}
		$content .= "
		</select>
		<br />
		<input type=\"submit\" value=\"".gettext("Search")."\" /> <input type=\"reset\" value=\"".gettext("Reset")."\" />
	</fieldset>
</form>
<script type=\"text/javascript\">
function addEngine()
{
	if ((typeof window.sidebar == \"object\") && (typeof window.sidebar.addSearchEngine == \"function\"))
	{
		window.sidebar.addSearchEngine(
		\"http://frugalware.org/static/search/Frugalware_Packages.src\",
		\"http://frugalware.org/static/search/Frugalware_Packages.png\",
		\"Frugalware_Packages\", \"Programming\" );
	}
	else
	{
		alert(\"" . gettext("You will need a Mozilla based browser to install a search plugin.") . "\");
	}
}
</script>
<div align=\"center\">" . gettext("Click <a href=\"javascript:addEngine()\">here</a> to install the Firefox search plugin.") . "</div>&nbsp;\n";
		print $content;
	}
}

function search_pkg()
{
	global $sqlhost, $sqluser, $sqlpass;
	$res_set = array();

	$search = $_GET['srch'];
	$repo = $_GET['repo'];
	$arch = $_GET['arch'];
	$fwver = $_GET['ver'];
	$sub = ($_GET['sub'] == "on") ? 1 : 0; # whether the search is for a substring or exact match

	$query = "select id, pkgname, pkgver, pkgrel, fwver, repo, arch from packages where ";
	# if the 'desc' is set (searching in description, too) I have to put
	# the restrictions between brackets, because of the 'repo' below...
	if ($sub == 0)
	{
		($_GET['desc'] == "on" || $_GET['desc'] == 1) ? $query .= "(pkgname='$search' or `desc`='$search')" : $query .= "(pkgname='$search')"; # if the desc is set, the search is for description, too
	}
	else
	{
		($_GET['desc'] == "on" || $_GET['desc'] == 1) ? $query .= "(pkgname like '%$search%' or `desc` like '%$search%')" : $query .= "(pkgname like '%$search%')";
	}
	if ($repo != "" && $repo != "all") # if repo is set to frugalware or extra
	{
		$query .= " and repo='$repo'";
	}
	if ($arch != "")
	{
		$query .= " and arch='$arch'";
	}
	if ($fwver != "")
	{
		$query .= " and fwver='$fwver'";
	}
	$query .= " order by fwver desc";
	$db = new FwDB();
	$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware");
	$res = $db->doQuery($query);
	if ($db->doCountRows($res) > 0)
	{
		while ($i = $db->doFetchRow($res))
		{
			$res_set[] = $i;
		}
		$db->doClose();
		res_show($res_set, 'p', $search);
	}
	else
	{
		print "<h3>".gettext("No package found")."</h3>";
		$db->doClose();
		main();
	}
}

function search_file()
{
	global $sqlhost, $sqluser, $sqlpass;
	$res_set = array();
	$search = (substr($_GET['srch'], 0, 1) == '/') ? substr($_GET['srch'], 1) : $_GET['srch'];
	$repo = $_GET['repo'];
	$arch = $_GET['arch'];
	$fwver = $_GET['ver'];
	$query = "select id, pkgname, pkgver, pkgrel, fwver, repo, arch from packages where files like '%$search%' ";
	if ($repo != "" && $repo != "all")
	{
		$query .= "and repo='$repo'";
	}
	if ($arch != "" && $arch != "all")
	{
		$query .= " and arch='$arch'";
	}
	if ($fwver != "" && $fwver != "all")
	{
		$query .= " and fwver='$fwver'";
	}
	$query .= " order by fwver desc";
	$db = new FwDB();
	$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware");
	$res = $db->doQuery($query);
	if ($db->doCountRows($res) > 0) {
		while ($i = $db->doFetchRow($res)) {
			$res_set[] = $i;
		}
		$db->doClose();
		res_show($res_set, 'f', $search);
	}
	else {
		print "<h3>".gettext("No such file or directory")."</h3>";
		$db->doClose();
		main();
	}
}

function res_show($res_set, $what, $search) {
	switch ($what) {
		case 'p':
			$title = gettext("Search result for:")." ".$search;
			$content = "<div align=\"left\">\n";
			for ($i=0,$j=1;$i<count($res_set);$i++,$j++) {
				$content .= "<p>".$j.". <a href=\"/packages/".$res_set[$i]['id']."\">".$res_set[$i]['pkgname']."</a> ".$res_set[$i]['pkgver']."-".$res_set[$i]['pkgrel']."<br />".gettext("Version:")." ".$res_set[$i]['fwver']."; ".gettext("Repository:")." ".$res_set[$i]['repo']."; ".gettext("Architecture:")." ".$res_set[$i]['arch']."</p>\n";
			}
			$content .= "</div>\n";
			fwmiddlebox($title, $content);
			break;
		case 'f':
			$title = gettext("Search result for:")." ".$search;
			$content = "<div align=\"left\">\n";
			for ($i=0,$j=1;$i<count($res_set);$i++,$j++) {
				$content .= "<p>".$j.". <a href=\"/packages/".$res_set[$i]['id']."/files\">".$res_set[$i]['pkgname']."</a> ".$res_set[$i]['pkgver']."-".$res_set[$i]['pkgrel']."<br />".gettext("Version:")." ".$res_set[$i]['fwver']."; ".gettext("Repository:")." ".$res_set[$i]['repo']."; ".gettext("Architecture:")." ".$res_set[$i]['arch']."</p>\n";
			}
			$content .= "</div>\n";
			fwmiddlebox($title, $content);
			break;
	}
}

function pkg_from_id($id)
{
	global $sqlhost, $sqluser, $sqlpass;
	$db = new FwDB();
	$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware");
	$res = $db->doQuery("select pkgname, parent, pkgver, pkgrel, groups, provides, depends, conflicts, replaces, csize, arch, `desc`, maintainer, uploader, md5, sha1, fwver, repo, updated from packages where id=$id");
	$arr = $db->doFetchRow($res);
	// query dep ids
	$query="select id, pkgname from packages where ( ";
	$arrstr = explode(" ", strtr($arr['depends'], "\n", " "));
	if ($arr['parent'] != NULL and $arr['parent'] != 'NULL')
		$arrstr[] = $arr['parent'];
	foreach($arrstr as $i)

		$query .= " or pkgname='" . preg_replace('/(<>|>=|<=|=).*/', '', $i) . "'";

	$query = preg_replace("/or /", "", $query, 1) . " ) and " .
		"fwver='" . $arr['fwver'] . "' and " .
		"arch='" . $arr['arch'] . "'";
	$res2 = $db->doQuery($query);
	while ( $i = $db->doFetchRow($res2) )
	{
		$id_set[$i['pkgname']]=$i['id'];
	}

	$title = gettext("Package information:")." ".$arr['pkgname'];
	$content = "<table border=0 width=100%>\n";
	$content .= "<tr><td>" . gettext("Name:") . "</td><td><a href=\"/packages/".$id."/files\">".$arr['pkgname']."</a></td></tr>\n";
	if ($arr['parent'] != NULL and $arr['parent'] != 'NULL')

		$content .= "<tr><td>" . gettext("Parent:") . "</td><td><a href=\"/packages/" . $id_set[preg_replace('/(<>|>=|<=|=).*/', '', $arr['parent'])] . "\">".$arr['parent']."</a></td></tr>\n";
	$content .= "<tr><td>" . gettext("Version:") . "</td><td>".$arr['pkgver']."-".$arr['pkgrel']."</td></tr>\n";
	if ($arr['repo']=="extra")
	{
		$repodir="/" . $arr['repo'];
		$pkgpath = $arr['repo'] . "/frugalware-" . $arr['arch'];
	}
	else
		$pkgpath = "/frugalware-" . $arr['arch'];
	$groupdir=preg_replace("/-extra/", "", $arr['groups']);

	$content .= "<tr><td>" . gettext("Changelog:") . "</td><td><a href=\"http://ftp.frugalware.org/pub/frugalware/frugalware-" . $arr['fwver'] . "$repodir/source/" . preg_replace("/^([^ ]*) .*/", "$1", $groupdir) . "/" . (($arr['parent'] != NULL and $arr['parent'] != 'NULL') ? $arr['parent'] : $arr['pkgname']) . "/Changelog\">Changelog</a></td></tr>\n";
	$content .= "<tr><td>" . gettext("Darcs:") . "</td><td><a href=\"http://darcs.frugalware.org/darcsweb/darcsweb.cgi?r=frugalware-" . $arr['fwver'] . ";a=tree;f=$repodir/source/" . preg_replace("/^([^ ]*) .*/", "$1", $groupdir) . "/" . (($arr['parent'] != NULL and $arr['parent'] != 'NULL') ? $arr['parent'] : $arr['pkgname']) . "\">View entry</a></td></tr>\n";
	if ($arr['groups'] != 'NULL') $content .= "<tr><td>" . gettext("Groups:") . "</td><td>".$arr['groups']."</td></tr>\n";
	if ($arr['provides'] != 'NULL') $content .= "<tr><td>" . gettext("Provides:") . "</td><td>".$arr['provides']."</td></tr>\n";
	if ($arr['depends'] != 'NULL')
	{
		$content .= "<tr><td>" . gettext("Depends:") . "</td><td>";
		foreach(explode(" ", strtr($arr['depends'], "\n", " ")) as $i)
			$content .= "<a href=\"/packages/" . $id_set[preg_replace('/(<>|>=|<=|=).*/', '', $i)] . "\">$i</a> ";
		$content .= "</td></tr>\n";
	}
	# this %PROVID stuff is just a workaround for an fdb2db bug
	if ($arr['conflicts'] != ('NULL' || '%PROVID')) $content .= "<tr><td>" . gettext("Conflicts:") . "</td><td>".$arr['conflicts']."</td></tr>\n";
	if ($arr['replaces'] != 'NULL') $content .= "<tr><td>" . gettext("Replaces:") . "</td><td>".$arr['replaces']."</td></tr>\n";
	if ($arr['csize'] != 'NULL') $content .= sprintf("%s%.2f%s", "<tr><td>" . gettext("Compressed size:") . "</td><td>", $arr['csize']/1048576, "MiB</td></tr>\n");
	if ($arr['arch'] != 'NULL') $content .= "<tr><td>" . gettext("Arch:") . "</td><td>".$arr['arch']."</td></tr>\n";
	if ($arr['desc'] != 'NULL') $content .= "<tr><td>" . gettext("Description:") . "</td><td>".$arr['desc']."</td></tr>\n";
	if ($arr['maintainer'] != 'NULL') $content .= "<tr><td>" . gettext("Maintainer:") . "</td><td>".$arr['maintainer']."</td></tr>\n";
	if ($arr['uploader'] != 'NULL') $content .= "<tr><td>" . gettext("Uploaded by:") . "</td><td>".$arr['uploader']."</td></tr>\n";
	$content .= "<tr><td>" . gettext("Download:") . " </td><td><a href=\"/download/frugalware-" . $arr['fwver'] . "/" . $pkgpath . "/" . $arr['pkgname'] . "-" . $arr['pkgver'] . "-" . $arr['pkgrel'] . "-" . $arr['arch'] . ".fpm\">" . $arr['pkgname'] . "-" . $arr['pkgver'] . "-" . $arr['pkgrel'] . "-" . $arr['arch'] . ".fpm</a></td></tr>";
	$content .= "<tr><td>" . gettext("Forums:") . "</td><td><a href=\"http://forums.frugalware.org/index.php?t=search&srch=".$arr['pkgname']."\">forums.frugalware.org</a></td></tr>\n";
	$content .= "<tr><td>" . gettext("Wiki:") . "</td><td><a href=\"http://wiki.frugalware.org/Special:Search?search=".$arr['pkgname']."\">wiki.frugalware.org</a></td></tr>\n";
	$content .= "<tr><td>" . gettext("Bug Tracking System:") . "</td><td><a href=\"http://bugs.frugalware.org/index.php?string=".$arr['pkgname']."\">" . gettext("related open bugs") . "</a>; " . gettext("file a feature request, bug report or mark outdated <a href=\"http://bugs.frugalware.org/?do=newtask&project=1\">here") . "</td></tr>\n";
	if ($arr['md5'] != 'NULL') $content .= "<tr><td>" . gettext("MD5 Sum:") . "</td><td>".$arr['md5']."</td></tr>\n";
	if ($arr['sha1'] != '') $content .= "<tr><td>" . gettext("SHA1 Sum:") . "</td><td>".$arr['sha1']."</td></tr>\n";
	if ($arr['fwver'] != 'NULL') $content .= "<tr><td>" . gettext("Frugalware version:") . "</td><td>".$arr['fwver']."</td></tr>\n";
	if ($arr['repo'] != 'NULL') $content .= "<tr><td>" . gettext("Repository:") . "</td><td>".$arr['repo']."</td></tr>\n";
	if ($arr['updated'] != 'NULL') $content .= "<tr><td>" . gettext("Updated:") . "</td><td>".$arr['updated']."</td></tr>\n";
	$content .= "</table>\n";
	$db->doClose();
	fwmiddlebox($title, $content);
}


function file_from_id($id)
{
	global $sqlhost, $sqluser, $sqlpass;
	$db = new FwDB();
	$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware");
	$res = $db->doQuery("select pkgname, pkgver, pkgrel, files from packages where id=$id");
	$arr = $db->doFetchRow($res);
	$db->doClose();
	$title = gettext("File list for")." ".$arr['pkgname'];
	$content .= "<table border=0 width=100%>\n";
	$content .= "<tr><td>Name:</td><td><a href=\"/packages/".$id."\">".$arr['pkgname']."</a></td></tr>\n";
	$content .= "<tr><td>Version:</td><td>".$arr['pkgver']."-".$arr['pkgrel']."</td></tr>\n";
	$content .= "<tr><td colspan=2>Files:</td></tr>\n";
	$files = explode("\n", substr($arr['files'], 0, -1));
	for($i=0;$i<count($files);$i++) {
		$content .= "<tr><td colspan=2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/".$files[$i]."</td></tr>\n";
	}
	$content .= "</table>\n";
	fwmiddlebox($title, $content);
}

switch($_GET['op'])
{
	case "pkg":
		search_pkg();
		break;

	case "file":
		search_file();
		break;

	default:
		main();
		break;
}

include("footer.php");
?>
