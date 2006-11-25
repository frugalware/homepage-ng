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
 * Frugalware Linux Homepage - Download page
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
include("header.php");
include("xml.inc.php");

if (file_exists("xml/mirrors.xml"))
	$mirrorsfile = "xml/mirrors.xml";
else
	$mirrorsfile = $docs_path."/xml/mirrors.xml";
$mirr = file_get_contents($mirrorsfile);
$parser = new XMLParser($mirr);
$parser->Parse();
for ( $i=0; $i<count($parser->document->mirror); $i++)
{
	$mirrors[$i][name] = $parser->document->mirror[$i]->name[0]->tagData;
	$mirrors[$i][type] = $parser->document->mirror[$i]->type[0]->tagData;
	$mirrors[$i][path] = $parser->document->mirror[$i]->path[0]->tagData;
	$mirrors[$i][desc] = $parser->document->mirror[$i]->description[0]->tagData;
}

$ftpcont = $httpcont = $rsynccont = "<table width=\"100%\" border=\"0\">\n";
$buycdcont = gettext("You can buy Frugalware CDs at the following sites:")."<ul>\n";
$url = addslashes(stripslashes($_GET[url]));
#$url = $_GET[url];

for ( $i=0; $i<count($mirrors); $i++ )
{
	if ( $mirrors[$i][type] == "ftp" )
	{
		$ftpcont .= "<tr><td width=\"50%\"><a href=\"ftp://".$mirrors[$i][name]."/".$mirrors[$i][path]."/$url\">".$mirrors[$i][name]."</a></td><td>".$mirrors[$i][desc]."</td></tr>\n";
	}
	if ( $mirrors[$i][type] == "http" )
	{
		$httpcont .= "<tr><td width=\"50%\"><a href=\"http://".$mirrors[$i][name]."/".$mirrors[$i][path]."/$url\">".$mirrors[$i][name]."</a></td><td>".$mirrors[$i][desc]."</td></tr>\n";
	}
	if ( $mirrors[$i][type] == "rsync" )
	{
		$rsynccont .= "<tr><td width=\"50%\"><a href=\"rsync://".$mirrors[$i][name]."/".$mirrors[$i][path]."/$url\">".$mirrors[$i][name]."</a></td><td>".$mirrors[$i][desc]."</td></tr>\n";
	}
	if ( $mirrors[$i][type] == "buycd" )
	{
		$buycdcont .= "<li><a href=\"" . htmlentities($mirrors[$i][path]). "\">".$mirrors[$i][name]."</a></li>\n";
	}
}
$ftpcont .= "</table>\n";
$httpcont .= "</table>\n";
$rsynccont .= "</table>\n";
$buycdcont .= "</ul>\n";

$howto = "<div align=\"left\"><ul>
	<li>".gettext("Full mirroring (~27GB)").":<br />
	<br /><tt>rsync -avP --delete-after <i>server</i> /download/directory</tt><br />&nbsp;</li>
	<li>".gettext("Only a specified tree (~5GB, for example -current)").":<br />
	<br /><tt>rsync -avP --delete-after <i>server</i>/frugalware-current/ /download/directory/location </tt><br />&nbsp;</li>
</ul></div>";
if ( $url != "" )
{
	fwmiddlebox(gettext("Download file (via ftp)"), $ftpcont);
	fwmiddlebox(gettext("Download file (via http)"), $httpcont);
	fwmiddlebox(gettext("Download file (via rsync)"), $rsynccont);
}
else
{
	fwmiddlebox(gettext("Via FTP"), $ftpcont);
	fwmiddlebox(gettext("Via HTTP"), $httpcont);
	fwmiddlebox(gettext("Via Rsync"), $rsynccont);
	fwmiddlebox(gettext("Rsync mini-howto"), $howto);
	fwmiddlebox(gettext("Get a CD"), $buycdcont);
}

include("footer.php");
?>
