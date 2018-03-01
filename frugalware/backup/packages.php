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
ob_start();
$titleprefix = null;
include("header.php");

function main()
{
	global $sqlhost, $sqluser, $sqlpass;
	if ( is_numeric($_GET[id]) )
	{
		if ($_GET['s'] == "f")
			file_from_id($_GET['id']);
		else if ($_GET['s'] == "buildlog")
			buildlog_from_id($_GET['id']);
		else if ($_GET['s'] == "changelog")
			changelog_from_id($_GET['id']);
		else if ($_GET['s'] == "documentation")
			documentation_from_id($_GET['id']);
		else if (!strlen($_GET['op']))
			pkg_from_id($_GET['id']);
	}
	else
	{
		include("xml.inc.php");
		if (file_exists("xml/roadmap.xml"))
			$xmlfile = "xml/roadmap.xml";
		else
			$xmlfile = $docs_path."/xml/roadmap.xml";
		$xml = file_get_contents($xmlfile);
		$parser = new XMLParser($xml);
		$parser->Parse();
		$releases = $parser->document->release;
		$first = true;
		for ( $i=0; $i < count($releases); $i++)
		{
			if ($releases[$i]->status[0]->tagData == '1') {
				if($first)
				{
					$first = false;
					if ($_GET['ver'] != "current")
						$selstr = " selected=\"selected\"";
					$db = new FwDB();
					$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware2");
					$query = "SELECT COUNT(id)  FROM `packages` WHERE `arch` LIKE 'i686' AND `size` != 0 AND `fwver` LIKE '".$releases[$i]->version[0]->tagData."'";
					$res = $db->doQuery($query);
					$arr = $db->doFetchRow($res);
					$binnum = $arr['COUNT(id)'];
					$query = "SELECT COUNT(id)  FROM `packages` WHERE `arch` LIKE 'i686' AND `size` = 0 AND `fwver` LIKE '".$releases[$i]->version[0]->tagData."'";
					$res = $db->doQuery($query);
					$arr = $db->doFetchRow($res);
					$srcnum = $arr['COUNT(id)'];
				}
				else
					unset($selstr);
				$arr[] = "\t\t\t<option value=\"".$releases[$i]->version[0]->tagData."\"$selstr>".$releases[$i]->version[0]->tagData."</option>\n";
				break;
			}
		}
		$content = "<form name=\"pkgsrch\" action=\"/packages/\" method=\"get\">
		<fieldset class=\"pkg\"><legend>".gettext("Package search")."</legend>
		".gettext("Search for:")."<br />
		<input type=\"radio\" name=\"op\" value=\"pkg\" " . (!in_array($_GET['op'], array("file", "groups")) ? "checked=\"checked\" " : "") . "/>".gettext("packages")."<br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"required\" type=\"checkbox\" name=\"desc\" id=\"descr\" " . ($_GET['desc'] == "on" ? "checked=\"checked\" " : "") . "/><label for=\"descr\" class=\"pkg-phrasing\">".gettext("Search in description")."</label><br />
		<input type=\"radio\" name=\"op\" value=\"file\" " . ($_GET['op'] == "file" ? "checked=\"checked\" " : "") . "/>".gettext("files")."<br />
		<input type=\"radio\" name=\"op\" value=\"groups\" " . ($_GET['op'] == "groups" ? "checked=\"checked\" " : "") . "/>".gettext("groups")."<br />
		<input class=\"required\" type=\"text\" id=\"pkgsrc\" name=\"srch\" size=\"40\" title=\"".gettext("Regular expression")."\" value=\"" . htmlentities($_GET['srch']) . "\"/> " . gettext( '(regular expression)' ) . "
		<br />
		<br />
		".gettext("Architecture:")."<br />
		<select name=\"arch\" id=\"archs\" class=\"required\">
			<option value=\"all\">all</option>
			<option value=\"i686\" " . ( !in_array($_GET['arch'], array("x86_64", "ppc")) ? "selected=\"selected\" " : "") . "class=\"required\">i686</option>
			<option value=\"x86_64\" " . ( $_GET['arch'] == "x86_64" ? "selected=\"selected\" " : "") . ">x86_64</option>
			<option value=\"ppc\">" . ( $_GET['arch'] == "ppc" ? "selected=\"selected\" " : "") . "</option>
		</select>
		<br />
		".gettext("Version:")."<br />
		<select name=\"ver\" id=\"fwver\" class=\"required\">
			<option value=\"all\">all</option>
			<option value=\"current\" " . ( $_GET['ver'] == "current" ? "selected=\"selected\" " : "") . ">current</option>\n";
		foreach ( $arr as $i )
		{
			$content .= $i;
		}
		$content .= "
		</select>
    <br />
    <br />
		<input type=\"submit\" value=\"".gettext("Search")."\" /> <input type=\"reset\" value=\"".gettext("Reset")."\" />
		<p>".sprintf(gettext("Searching in %d binary and %d source-only packages."), $binnum, $srcnum)."</p>
		<p>".sprintf(gettext("Check <a href=\"%s\">outdated</a> packages we are aware of."), "http://frugalware.org/~repo/stats/chkworld.html")."</p>
	</fieldset></form>
<script type=\"text/javascript\">
function addEngine()
{
	if ((typeof window.sidebar == \"object\") && (typeof window.sidebar.addSearchEngine == \"function\"))
	{
		window.sidebar.addSearchEngine(
		\"http://frugalware.org/static/Frugalware_Packages.src\",
		\"http://frugalware.org/static/Frugalware_Packages.png\",
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

	if(strlen($_GET['srch'])==0)
	{
		return;
	}
	$search = addslashes($_GET['srch']);
	//$srch = str_replace( '+', '\+', addcslashes( $search, '+' ) );
	$arch = addslashes($_GET['arch']);
	$fwver = addslashes($_GET['ver']);
	$sub = ($_GET['sub'] == "on") ? 1 : 0; # whether the search is for a substring or exact match

	$query = "select id, pkgname, pkgver, fwver, arch from packages where ";
	# if the 'desc' is set (searching in description, too) I have to put
	# the restrictions between brackets, because of the 'arch' below...
	($_GET['desc'] == "on" || $_GET['desc'] == 1) ? $query .= "(pkgname rlike '$search' or `desc` rlike '$search')" : $query .= "(pkgname rlike '$search')";
	if ($arch != "" and $arch != "all")
	{
		$query .= " and arch='$arch'";
	}
	if ($fwver != "" and $fwver != "all")
	{
		$query .= " and fwver='$fwver'";
	}
	$query .= " order by fwver desc";
	$db = new FwDB();
	$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware2");
	$res = $db->doQuery($query);
	// users usually can't read
	if($res == -1 and strpos($query, '+') !== false)
	{
		$res = $db->doQuery(str_replace('+', '\\\\+', $query));
	}
	if ($res != -1 && $db->doCountRows($res) > 0)
	{
		while ($i = $db->doFetchRow($res))
		{
			$res_set[] = $i;
		}
		$db->doClose();
		res_show($res_set, 'p', $search);
	}
	elseif ( $res == -1 )
	{
		print '<h3>' . gettext( 'Error in the query, please change the searching conditions' ) . '</h3>';
		$db->doClose();
	}
	else
	{
		print "<h3>".gettext("No package found")."</h3>";
		$db->doClose();
	}
}

function search_file()
{
	global $sqlhost, $sqluser, $sqlpass;
	$res_set = array();
	$search = addslashes($_GET['srch']);
	$arch = addslashes($_GET['arch']);
	$fwver = addslashes($_GET['ver']);
	// XXX: exact search here
	$query = "select packages.id, packages.pkgname, packages.pkgver,
		packages.fwver, packages.arch from packages, files where
		packages.id = files.pkg_id and files.file = '$search'";
	if ($arch != "" && $arch != "all")
	{
		$query .= " and packages.arch='$arch'";
	}
	if ($fwver != "" && $fwver != "all")
	{
		$query .= " and packages.fwver='$fwver'";
	}
	$query .= " group by concat(packages.pkgname, packages.arch, packages.fwver) order by packages.fwver desc";
	$db = new FwDB();
	$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware2");
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
	}
}

function search_groups()
{
	global $sqlhost, $sqluser, $sqlpass, $sqldb;
	$res_set = array();
	$arch = addslashes($_GET['arch']);
	$fwver = addslashes($_GET['ver']);
	$search = addslashes(( $_GET['srch'] != '' ) ? $_GET['srch'] : '.*');
	if( is_numeric( $_GET['id'] ) )
		$group = $_GET['id'];
	else
	{
		$query = "SELECT Count(packages.pkgname) as numpkgs, groups.id, groups.name
			    FROM packages, ct_groups, groups
			   WHERE ct_groups.group_id = groups.id
			     AND packages.id = ct_groups.pkg_id
			     AND groups.name RLIKE '$search'";
		if ($arch != "" && $arch != "all")
		{
			$query .= " AND packages.arch='$arch'";
		}
		if ($fwver != "" && $fwver != "all")
		{
			$query .= " AND packages.fwver='$fwver'";
		}
		$query .= ' GROUP BY groups.name';
		$db = new FwDB();
		$db->doConnect( $sqlhost, $sqluser, $sqlpass, $sqldb );
		$res = $db->doQuery( $query );
		if ( $db->doCountRows( $res ) > 0 )
		{
			while ( $i = $db->doFetchRow( $res ) )
				$res_set[] = $i;
		}
		else
		{
			print '<h3>' . gettext( 'No such group' ) . '</h3>';
			$db->doClose();
			return;
		}
		$db->doClose();
		res_show( $res_set, 'l' );
		return;
	}
	$query = "SELECT packages.id, packages.pkgname, packages.pkgver, packages.fwver, packages.arch, groups.name
		    FROM packages, ct_groups, groups
		   WHERE groups.id = $group
		     AND ct_groups.group_id = groups.id
		     AND packages.id = ct_groups.pkg_id";
	if ($arch != "" && $arch != "all")
	{
		$query .= " AND packages.arch='$arch'";
	}
	if ($fwver != '' && $fwver != 'all')
	{
		$query .= " AND packages.fwver='$fwver'";
	}
	$query .= ' ORDER BY packages.fwver DESC';
	$db = new FwDB();
	$db->doConnect( $sqlhost, $sqluser, $sqlpass, $sqldb );
	$res = $db->doQuery( $query );
	if ( $db->doCountRows( $res ) > 0)
	{
		while ( $i = $db->doFetchRow( $res ) )
		{
			$res_set[] = $i;
		}
		$db->doClose();
		res_show( $res_set, 'g', $res_set[0]['name'] );
	}
	else
	{
		print '<h3>' . gettext('No such group' ) . '</h3>';
		$db->doClose();
	}
}

function res_show( $res_set, $what, $search=null )
{
	global $titleprefix;
	switch ($what)
	{
		case 'l':
			$title = gettext( 'Listing groups' );
			$total = 0;
			$content = "<div align=\"left\">\n";
			for ( $i = 0, $j = 1; $i < count( $res_set ); $i++, $j++ )
			{
				$content .= '<p>' . $j . '. <a href="/packages/?op=groups&id=' . $res_set[$i]['id'] . '&arch=' . $_GET['arch'] . '&ver=' . $_GET['ver'] .'">' . $res_set[$i]['name'] . '</a> (' . $res_set[$i]['numpkgs'] . ")</p>\n";
				$total += $res_set[$i]['numpkgs'];
			}
			$content .= "</div>\n";
			fwmiddlebox($title, $content);
			break;
		case 'g':
			$title = gettext( 'Listing contents of group:' ). " " . $search;
		case 'p':
			if(!isset($title)) $title = gettext("Search result for:")." ".$search;
			$titleprefix = "Search  results for $search - ";
			$content = "<div align=\"left\">\n";
			for ($i=0,$j=1;$i<count($res_set);$i++,$j++) {
				$content .= "<p>".$j.". <a href=\"/packages/".$res_set[$i]['id']."\">".$res_set[$i]['pkgname']."</a> ".$res_set[$i]['pkgver']."<br />".gettext("Version:")." ".$res_set[$i]['fwver']."; ".gettext("Architecture:")." ".$res_set[$i]['arch']."</p>\n";
			}
			$content .= "</div>\n";
			fwmiddlebox($title, $content);
			break;
		case 'f':
			$title = gettext("Search result for:")." ".$search;
			$content = "<div align=\"left\">\n";
			for ($i=0,$j=1;$i<count($res_set);$i++,$j++) {
				$content .= "<p>".$j.". <a href=\"/packages/".$res_set[$i]['id']."/files\">".$res_set[$i]['pkgname']."</a> ".$res_set[$i]['pkgver']."<br />".gettext("Version:")." ".$res_set[$i]['fwver']."; ".gettext("Architecture:")." ".$res_set[$i]['arch']."</p>\n";
			}
			$content .= "</div>\n";
			fwmiddlebox($title, $content);
			break;
	}
}

function pkg_from_id($id)
{
	global $sqlhost, $sqluser, $sqlpass, $top_path;
	$db = new FwDB();
	$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware2");
	$res = $db->doQuery("select uploaders.login, packages.pkgname, packages.pkgver, packages.size, packages.usize, packages.arch, packages.`desc`, packages.maintainer, packages.sha1sum, packages.fwver, packages.builddate, packages.parent_id, packages.url from packages, uploaders where packages.id=$id and packages.uploader_id = uploaders.id group by concat(packages.fwver, packages.pkgname, packages.arch)");
	if ( $db->doCountRows( $res ) > 0 )
	{
		$arr = $db->doFetchRow($res);
		if($arr['parent_id']!=0)
		{
			$res = $db->doQuery("select pkgname from packages where id=" . $arr['parent_id']);
			$parent = $db->doFetchRow($res);
		}
		else
			$parent['pkgname']=$arr['pkgname'];
		// query dep ids
		$query = "select packages.pkgname, depends.depend_id, depends.version from packages, depends where depends.pkg_id=$id and packages.id = depends.depend_id";
		$res = $db->doQuery($query);
		while ( $i = $db->doFetchRow($res) )
			$deps[]=$i;
		// conflicts
		$query = "select packages.pkgname, conflicts.conflict_id from packages, conflicts where conflicts.pkg_id=$id and packages.id = conflicts.conflict_id";
		$res = $db->doQuery($query);
		while ( $i = $db->doFetchRow($res) )
			$conflicts[]=$i;
		// provides
		$query = "select packages.pkgname, provides.provide_id from packages, provides where provides.pkg_id=$id and packages.id = provides.provide_id";
		$res = $db->doQuery($query);
		while ( $i = $db->doFetchRow($res) )
			$provides[]=$i;
		// exact revdeps
		$query = "select packages.pkgname, depends.pkg_id, depends.version from packages, depends where depends.depend_id=$id and packages.id = depends.pkg_id and depends.version like '=%'";
		$res = $db->doQuery($query);
		while ( $i = $db->doFetchRow($res) )
			$exrevdeps[]=$i;
		// other revdeps
		$query = "select packages.pkgname, depends.pkg_id, depends.version from packages, depends where depends.depend_id=$id and packages.id = depends.pkg_id and depends.version not like '=%'";
		$res = $db->doQuery($query);
		while ( $i = $db->doFetchRow($res) )
			$orevdeps[]=$i;
		// groups
		$query = "select ct_groups.pkg_id, groups.id, groups.name from groups, ct_groups where (ct_groups.pkg_id=$id or ct_groups.pkg_id=".$arr['parent_id'].") and ct_groups.group_id = groups.id order by groups.id";
		$res = $db->doQuery($query);
		while($i=$db->doFetchRow($res))
			if($i['pkg_id']==$id)
				$groups[]=$i;
			else if(!isset($parent['group']))
				$parent['group']=$i['name'];
		if(!isset($parent['group']))
			$parent['group']=$groups[0]['name'];

		$title = gettext("Package information:")." ".$arr['pkgname'];
		$content = "<table border=\"0\" width=\"100%\">\n";
		$content .= "<tr><td>" . gettext("Name:") . "</td><td><a href=\"/packages/".$id."/files\">".$arr['pkgname']."</a></td></tr>\n";
		if ($arr['parent_id'] != 0 and $arr['parent_id'] != $id) $content .= "<tr><td>" . gettext("Parent:") . "</td><td><a href=\"/packages/" . $arr['parent_id']. "\">".$parent['pkgname']."</a></td></tr>\n";
		$content .= "<tr><td>" . gettext("Version:") . "</td><td>".$arr['pkgver']."</td></tr>\n";
		if(file_exists($top_path."/source/".$parent['group']."/".$parent['pkgname']."/".$parent['pkgname'].".html"))
			$content .= "<tr><td>" . gettext("Documentation:") . "</td><td><a href=\"/packages/".$id."/documentation\">".$arr['pkgname'].".html</a></td></tr>\n";
		if(file_exists($top_path."/source/".$parent['group']."/".$parent['pkgname']."/".$parent['pkgname']."-".$arr['pkgver']."-".$arr['arch'].".log.bz2"))
			$content .= "<tr><td>" . gettext("Buildlog:") . "</td><td><a href=\"/packages/".$id."/buildlog\">".$arr['pkgname']."-".$arr['pkgver']."-".$arr['arch'].".log.bz2</a></td></tr>\n";
		$content .= "<tr><td>" . gettext("Changelog:") . "</td><td><a href=\"/packages/".$id."/changelog\">Changelog</a></td></tr>\n";
		$content .= "<tr><td>Git:</td><td><a href=\"http://git.frugalware.org/gitweb/gitweb.cgi?p=frugalware-".($arr['fwver'] == "current" ? $arr['fwver'] : "stable").".git;a=tree;f=source/" . $parent['group']."/".str_replace("+", "%2b", $parent['pkgname']). "\">View entry</a></td></tr>\n";
		if(count($groups))
		{
			$content .= "<tr><td>" . gettext("Groups:") . "</td><td>";
			foreach($groups as $i)
				$content .= "<a href=\"/packages/?op=groups&amp;id=" . $i['id'] . "&amp;arch=".$arr['arch']."&amp;ver=".$arr['fwver']."\">".$i['name']."</a> ";
			$content .= "</td></tr>\n";
		}
		if ($arr['url'] != "") $content .= "<tr><td>" . gettext("URL:") . "</td><td><a href=\"" . $arr['url']. "\">".$arr['url']."</a></td></tr>\n";
		if (count($deps))
		{
			$content .= "<tr><td>" . gettext("Depends:") . "</td><td>";
			foreach($deps as $i)
				$content .= "<a href=\"/packages/" . $i['depend_id'] . "\">".$i['pkgname'].$i['version']."</a> ";
			$content .= "</td></tr>\n";
		}
		if (count($exrevdeps))
		{
			$content .= "<tr><td>" . gettext("Exact reverse depends:") . "</td><td>";
			foreach($exrevdeps as $i)
				$content .= "<a href=\"/packages/" . $i['pkg_id'] . "\">".$i['pkgname']."</a> ";
			$content .= "</td></tr>\n";
		}
		if (count($orevdeps))
		{
			$content .= "<tr><td>" . gettext("Other reverse depends:") . "</td><td>";
			foreach($orevdeps as $i)
				$content .= "<a href=\"/packages/" . $i['pkg_id'] . "\">".$i['pkgname']."</a> ";
			$content .= "</td></tr>\n";
		}
		if (count($conflicts))
		{
			$content .= "<tr><td>" . gettext("Conflicts:") . "</td><td>";
			foreach($conflicts as $i)
				$content .= "<a href=\"/packages/" . $i['conflict_id'] . "\">".$i['pkgname']."</a> ";
			$content .= "</td></tr>\n";
		}
		if (count($provides))
		{
			$content .= "<tr><td>" . gettext("Provides:") . "</td><td>";
			foreach($provides as $i)
				$content .= "<a href=\"/packages/" . $i['provide_id'] . "\">".$i['pkgname']."</a> ";
			$content .= "</td></tr>\n";
		}
		if ($arr['size'] > 0) $content .= sprintf("%s%.2f%s", "<tr><td>" . gettext("Compressed size:") . "</td><td>", $arr['size']/1048576, "MiB</td></tr>\n");
		if ($arr['usize'] > 0) $content .= sprintf("%s%.2f%s", "<tr><td>" . gettext("Uncompressed size:") . "</td><td>", $arr['usize']/1048576, "MiB</td></tr>\n");
		if ($arr['arch'] != 'NULL') $content .= "<tr><td>" . gettext("Arch:") . "</td><td>".$arr['arch']."</td></tr>\n";
		if ($arr['desc'] != 'NULL') $content .= "<tr><td>" . gettext("Description:") . "</td><td>".$arr['desc']."</td></tr>\n";
		// FIXME: latin -> utf8 conversion hardwired
		if ($arr['maintainer'] != 'NULL') $content .= "<tr><td>" . gettext("Maintainer:") . "</td><td>".iconv("ISO-8859-1", "UTF-8",str_replace("@", " at ", htmlspecialchars($arr['maintainer'])))."</td></tr>\n";
		$content .= "<tr><td>" . gettext("Uploaded by:") . "</td><td>".$arr['login']."</td></tr>\n";
		$content .= "<tr><td>" . gettext("Download:") . " </td>";
		if ($arr['size'] > 0)
			$content .= "<td><a href=\"/download/frugalware-" . $arr['fwver'] . "/frugalware-" . $arr['arch'] . "/" . $arr['pkgname'] . "-" . $arr['pkgver'] . "-" . $arr['arch'] . ".fpm\">" . $arr['pkgname'] . "-" . $arr['pkgver'] . "-" . $arr['arch'] . ".fpm</a></td></tr>";
		else
			$content .= "<td><a href=\"/download/frugalware-" . $arr['fwver'] . "/source/" . $parent['group']."/".$parent['pkgname']. "/FrugalBuild\">FrugalBuild</a></td></tr>";
		$content .= "<tr><td>" . gettext("Wiki:") . "</td><td><a href=\"http://wiki.frugalware.org/index.php/Special:Search?search=".$arr['pkgname']."\">".gettext("Related pages")."</a></td></tr>\n";
		$content .= "<tr><td>" . gettext("Bug Tracking System:") . "</td><td><a href=\"http://bugs.frugalware.org/search?q=".$arr['pkgname']."\">" . gettext("Related open bugs") . "</a></td></tr>\n";
		$content .= "<tr><td>" . gettext("Syndicate:") . "</td><td><a href=\"/rss/packages/".($arr['fwver'] == "current" ? $arr['fwver'] : "stable")."/".$arr['arch']."/".$arr['pkgname']."\">" . gettext("RSS") . "</a></td></tr>\n";
		if ($arr['sha1sum'] != '') $content .= "<tr><td>" . gettext("SHA1 Sum:") . "</td><td>".$arr['sha1sum']."</td></tr>\n";
		if ($arr['fwver'] != 'NULL') $content .= "<tr><td>" . gettext("Frugalware version:") . "</td><td>".$arr['fwver']."</td></tr>\n";
		if ($arr['builddate'] != 'NULL') $content .= "<tr><td>" . gettext("Updated:") . "</td><td>".$arr['builddate']."</td></tr>\n";
		$content .= "</table>\n";
	}
	else
	{
		$content = gettext("No such package!");
		$title = '';
	}
	$db->doClose();
	fwmiddlebox($title, $content);
}

function changelog_from_id($id)
{
	global $sqlhost, $sqluser, $sqlpass, $top_path;

	$db = new FwDB();
	$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware2");
	$res = $db->doQuery("select pkgname, pkgver, arch, parent_id, fwver from packages where id=$id");
	if ( $db->doCountRows( $res ) > 0 )
	{
		$arr = $db->doFetchRow($res);
		if($arr['parent_id']!=0)
		{
			$res = $db->doQuery("select pkgname from packages where id=" . $arr['parent_id']);
			$parent = $db->doFetchRow($res);
		}
		else
			$parent['pkgname']=$arr['pkgname'];
		$query = "select ct_groups.pkg_id, groups.id, groups.name from groups, ct_groups where (ct_groups.pkg_id=$id or ct_groups.pkg_id=".$arr['parent_id'].") and ct_groups.group_id = groups.id order by groups.id";
		$res = $db->doQuery($query);
		while($i=$db->doFetchRow($res))
			if($i['pkg_id']==$id)
				$groups[]=$i;
			else if(!isset($parent['group']))
				$parent['group']=$i['name'];
		if(!isset($parent['group']))
			$parent['group']=$groups[0]['name'];

		$slog = $parent['pkgname']."-".$arr['pkgver']."-".$arr['arch'];
		$log = str_replace("current", $arr['fwver'], $top_path)."/source/".$parent['group']."/".$parent['pkgname']."/Changelog";
		print("<fieldset class=\"pkg\"><legend>".sprintf(gettext("Changelog for %s"), $slog)."</legend>");
		if(file_exists($log))
		{
			print("<pre class=\"changelog\">");
			$fp = fopen($log, "r");
			while ($buffer = fread ($fp, 4096))
				print($buffer);
			fclose ($fp);
			print("</pre>\n</fieldset>\n");
		}
		else
			print(gettext("Sorry, currently no log available."));
	}
	else
	{
		fwmiddlebox( '', gettext("No such package!") );
	}
	$db->doClose();
}

function buildlog_from_id($id)
{
	global $sqlhost, $sqluser, $sqlpass, $top_path;

	$db = new FwDB();
	$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware2");
	$res = $db->doQuery("select pkgname, pkgver, arch, parent_id, fwver from packages where id=$id");
	if ( $db->doCountRows( $res ) > 0 )
	{
		$arr = $db->doFetchRow($res);
		if($arr['parent_id']!=0)
		{
			$res = $db->doQuery("select pkgname from packages where id=" . $arr['parent_id']);
			$parent = $db->doFetchRow($res);
		}
		else
			$parent['pkgname']=$arr['pkgname'];
		$query = "select ct_groups.pkg_id, groups.id, groups.name from groups, ct_groups where (ct_groups.pkg_id=$id or ct_groups.pkg_id=".$arr['parent_id'].") and ct_groups.group_id = groups.id order by groups.id";
		$res = $db->doQuery($query);
		while($i=$db->doFetchRow($res))
			if($i['pkg_id']==$id)
				$groups[]=$i;
			else if(!isset($parent['group']))
				$parent['group']=$i['name'];
		if(!isset($parent['group']))
			$parent['group']=$groups[0]['name'];

		$slog = $parent['pkgname']."-".$arr['pkgver']."-".$arr['arch'];
		$log = str_replace("current", $arr['fwver'], $top_path)."/source/".$parent['group']."/".$parent['pkgname']."/".$slog.".log.bz2";
		print("<fieldset class=\"pkg\"><legend>".sprintf(gettext("Build log for %s"), $slog)."</legend>");
		if(file_exists($log))
		{
			print("<pre class=\"buildlog\">");
			$fp = bzopen($log, "r");
			while ($buffer = bzread ($fp, 4096))
				print($buffer);
			bzclose ($fp);
			print("</pre>\n</fieldset>\n");
		}
		else
			print(gettext("Sorry, currently no log available."));
	}
	else
	{
		fwmiddlebox( '', gettext("No such package!") );
	}
	$db->doClose();
}

function documentation_from_id($id)
{
	global $sqlhost, $sqluser, $sqlpass, $top_path;

	$db = new FwDB();
	$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware2");
	$res = $db->doQuery("select pkgname, pkgver, arch, parent_id, fwver from packages where id=$id");
	if ( $db->doCountRows( $res ) > 0 )
	{
		$arr = $db->doFetchRow($res);
		if($arr['parent_id']!=0)
		{
			$res = $db->doQuery("select pkgname from packages where id=" . $arr['parent_id']);
			$parent = $db->doFetchRow($res);
		}
		else
			$parent['pkgname']=$arr['pkgname'];
		$query = "select ct_groups.pkg_id, groups.id, groups.name from groups, ct_groups where (ct_groups.pkg_id=$id or ct_groups.pkg_id=".$arr['parent_id'].") and ct_groups.group_id = groups.id order by groups.id";
		$res = $db->doQuery($query);
		while($i=$db->doFetchRow($res))
			if($i['pkg_id']==$id)
				$groups[]=$i;
			else if(!isset($parent['group']))
				$parent['group']=$i['name'];
		if(!isset($parent['group']))
			$parent['group']=$groups[0]['name'];

		$slog = $parent['pkgname']."-".$arr['pkgver']."-".$arr['arch'];
		$doc = str_replace("current", $arr['fwver'], $top_path)."/source/".$parent['group']."/".$parent['pkgname']."/".$parent['pkgname'].".html";
		print("<fieldset class=\"pkg\"><legend>".sprintf(gettext("Documentation for %s"), $slog)."</legend>");
		if(file_exists($doc))
		{
			print("<div class=\"documentation\">");
			$lines = explode("\n", file_get_contents($doc));
			$display = false;
			foreach($lines as $i)
			{
				if(substr(trim($i), -7, 7) == "</body>")
					$display = false;
				if($display)
					print($i);
				if(substr(trim($i), -5, 5) == "</h2>")
					$display = true;
				/*else
					print("DEBUG: '" . substr($i, -6, 6) . "' != '</h2>\n'\n");*/
			}
			print("</div>\n</fieldset>\n");
		}
		else
			print(gettext("Sorry, currently no documentation available."));
	}
	else
	{
		fwmiddlebox( '', gettext("No such package!") );
	}
	$db->doClose();
}

function file_from_id($id)
{
	global $sqlhost, $sqluser, $sqlpass;
	$db = new FwDB();
	$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware2");
	$res = $db->doQuery("select pkgname, pkgver from packages where id=$id");
	if ( $db->doCountRows( $res ) > 0 )
	{
		$arr = $db->doFetchRow($res);
		$res = $db->doQuery("select file from files where pkg_id=$id");
		$title = gettext("File list for")." ".$arr['pkgname'];
		$content .= "<table border=0 width=100%>\n";
		$content .= "<tr><td>Name:</td><td><a href=\"/packages/".$id."\">".$arr['pkgname']."</a></td></tr>\n";
		$content .= "<tr><td>Version:</td><td>".$arr['pkgver']."</td></tr>\n";
		$content .= "<tr><td colspan=2>Files:</td></tr>\n";
		$files = explode("\n", substr($arr['files'], 0, -1));
		while($i = $db->doFetchRow($res))
		{
			$content .= "<tr><td colspan=2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/".$i['file']."</td></tr>\n";
		}
		$content .= "</table>\n";
	}
	else
	{
		$title = '';
		$content = gettext("No such package!");
	}
	$db->doClose();
	fwmiddlebox($title, $content);
}

main();
switch($_GET['op'])
{
	case "pkg":
		search_pkg();
		break;

	case "file":
		search_file();
		break;

	case "groups":
		search_groups();
		break;

	default:
		break;
}

include("footer.php");

$buf = ob_get_contents();
if ($titleprefix)
	$buf = str_replace('<title>', '<title>' . $titleprefix, $buf);
ob_end_clean();
echo $buf;
?>
