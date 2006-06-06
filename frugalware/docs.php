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
include("config.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
putenv("LANG=".$llang);
setlocale(LC_ALL,$llang);
bindtextdomain($domain, "locale");
textdomain($domain);

// let's start page
include("header.php");
$langs = array();
$txtdir = $docs_path."/txt";
$htmldir = $docs_path."/html";

if ($dir = @opendir($txtdir))
{
	while($what = readdir($dir))
	{
		if ($what != "." && $what != ".." && is_dir($txtdir."/".$what))
		{
			if (!in_array($what, $langs))
				$langs[] = $what;
			$txtlangs[$what] = 1;
			$txtnlangs[$what] = getnlang($what);
		}
	}
}
closedir($dir);

if ($dir = @opendir($htmldir))
{
	while($what = readdir($dir))
	{
		if ($what != "." && $what != ".." && is_dir($htmldir."/".$what))
		{
			if (!in_array($what, $langs))
				$langs[] = $what;
			$htmllangs[$what] = 1;
			$htmlnlangs[$what] = getnlang($what);
		}
	}
}
closedir($dir);

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
	$cont = gettext("Sorry, no documentation available currently");

fwmiddlebox(gettext("View online documentation"), $cont);

include("footer.php");
?>
