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
include("header.php");

$fwchlfile=$top_path."/ChangeLog.txt";
$fwchangelogentries=100;
$opennew=true;
$content="";
$j=0;

if (file_exists("$fwchlfile.$lang"))
	$changelogf=file("$fwchlfile.$lang");
else
	$changelogf=file($fwchlfile);

foreach($changelogf as $i)
{
	if ($j <= $fwchangelogentries)
	{
		if ($i != "\n")
		{
			$i = str_replace(array("<", ">", "@", "\n", "\r", " "), array("&lt;", "&gt;", "_at_", "", "", "&nbsp;"), $i);
			if ($opennew)
			{
				$j++;
				$opennew=false;
				$title=$i;
			}
			else
			{
				$content .= $i."<br />\n";
			}
		}
		else
		{
			fwmiddlebox($title, $content);
			$opennew=true;
			$content="";
		}
	}
}
print "<div align=\"center\">".gettext("Read full current changelog")." <a href=\"http://ftp.frugalware.org/pub/frugalware/frugalware-current/ChangeLog.txt\">".gettext("here")."</a>.</div>&nbsp;";

include("footer.php");
?>
