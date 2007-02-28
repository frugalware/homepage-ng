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
 * Frugalware Linux Homepage - About (summary) page
 *
 * @author Krisztian VASAS <iron@frugalware.org>
 *
 * @copyright Copyright (c) 2006. Krisztian VASAS
 * @copyright Copyright (c) 2005-2006. Miklos Vajna
 */

// include some useful functions and the config
include("functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

// let's start page
include("config.inc.php");

$langd = ( $lang == "en" ) ? "" : "/$lang/";
if(isset($_GET['doc']))
{
	$doc = $_GET['doc'];
	if(strpos($doc, ".html") === false and strpos($doc, ".pdf") === false and strpos($doc, ".text") === false)
		$doc .= ".html";
	$path = $docs_path."/".$doc;
	if(file_exists($path))
	{
		if (file_exists($docs_path."/".$langd.$doc))
			$path=$docs_path."/".$langd.$doc;
		$fp = fopen($path, "r");
		fpassthru($fp);
		die();
	}
}

include("header.php");
$langs = array();
$txtdir = $docs_path."/txt";
$htmldir = $docs_path."/html";
$txtdir_stable = $docs_path_stable."/txt";
$htmldir_stable = $docs_path_stable."/html";

$content = "";
for ( $i=0; $i<count($langs); $i++ )
{
	$foo = $langs[$i];
	if ($htmllangs[$foo] == 1)
	{
		$content .= "<li>".gettext($htmlnlangs[$foo]).": <a href=\"http://ftp.frugalware.org/pub/frugalware/frugalware-current/docs/html/".$foo."/\">HTML</a>";
		if ($txtlangs[$foo] == 1)
		{
			$content .= gettext(" or ")."<a href=\"http://ftp.frugalware.org/pub/frugalware/frugalware-current/docs/txt/".$foo."/frugalware.txt\">".gettext("Plain text")."</a></li>\n";
		}
		else
		{
			$content .= "</li>\n";
		}
	}
	else
	{
		if ($txtlangs[$foo] == 1)
		{
			$content .= "<li>".gettext($txtnlangs[$foo]).": <a href=\"http://ftp.frugalware.org/pub/frugalware/frugalware-current/docs/txt/".$foo."/\">".gettext("Plain text")."</a></li>\n";
		}
	}
}

if ($content != "")
	$cont = "<ul>\n".$content."</ul>\n";
else
	$cont = gettext("The following categories are available:")."<br />
	<ul>
	<li><a href=\"/docs/index\">".gettext("Full manual")."</a></li>
	<li><a href=\"/docs/index-user\">".gettext("User documentation")."</a></li>
	<li><a href=\"/docs/index-devel\">".gettext("Developer documentation")."</a></li>
	</ul>");

// Stable
if ($dir = @opendir($txtdir_stable))
{
	while($what = readdir($dir))
	{
		if ($what != "." && $what != ".." && is_dir($txtdir_stable."/".$what))
		{
			if (!in_array($what, $langs))
				$langs[] = $what;
			$txtlangs[$what] = 1;
			$txtnlangs[$what] = getnlang($what);
		}
	}
}
closedir($dir);

if ($dir = @opendir($htmldir_stable))
{
	while($what = readdir($dir))
	{
		if ($what != "." && $what != ".." && is_dir($htmldir_stable."/".$what))
		{
			if (!in_array($what, $langs))
				$langs[] = $what;
			$htmllangs[$what] = 1;
			$htmlnlangs[$what] = getnlang($what);
		}
	}
}
closedir($dir);

$content_stable = "";
for ( $i=0; $i<count($langs); $i++ )
{
	$foo = $langs[$i];
	if ($htmllangs[$foo] == 1)
	{
		$content_stable .= "<li>".gettext($htmlnlangs[$foo]).": <a href=\"http://ftp.frugalware.org/pub/frugalware/frugalware-stable/docs/html/".$foo."/\">HTML</a>";
		if ($txtlangs[$foo] == 1)
		{
			$content_stable .= gettext(" or ")."<a href=\"http://ftp.frugalware.org/pub/frugalware/frugalware-stable/docs/txt/".$foo."/frugalware.txt\">".gettext("Plain text")."</a></li>\n";
		}
		else
		{
			$content_stable .= "</li>\n";
		}
	}
	else
	{
		if ($txtlangs[$foo] == 1)
		{
			$content_stable .= "<li>".gettext($txtnlangs[$foo]).": <a href=\"http://ftp.frugalware.org/pub/frugalware/frugalware-stable/docs/txt/".$foo."/\">".gettext("Plain text")."</a></li>\n";
		}
	}
}

if ($content_stable != "")
	$cont_stable = "<ul>\n".$content_stable."</ul>\n";
else
	$cont_stable = gettext("Sorry, no documentation available currently");


fwmiddlebox(gettext("View online documentation (stable release)"), $cont_stable);
fwmiddlebox(gettext("View online documentation (development version)"), $cont);

include("footer.php");
?>
