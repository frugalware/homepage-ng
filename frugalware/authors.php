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
 * Frugalware Linux Homepage - Authors' page
 *
 * @author Krisztian VASAS <iron@frugalware.org>
 * @copyright Copyright (c) 2006. Krisztian VASAS
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

function sort_people($a, $b)
{
	return(strcmp($a->name[0]->tagData, $b->name[0]->tagData));
}

$who = ($_GET['who'] != "") ? $_GET['who'] : "";
$xmlfile = $docs_path."/xml/authors.xml";
$xml = file_get_contents($xmlfile);
$parser = new XMLParser($xml);
$parser->Parse();
$authors = "";
for ( $i=0; $i<count($parser->document->author); $i++)
{
	$people[] = $parser->document->author[$i];
}
usort($people, "sort_people");
for($i=0;$i<count($people);$i++)
{
	if($people[$i]->status[0]->tagData === $who or !strlen($who))
	{
		$email = str_replace("@", " at ", $people[$i]->email[0]->tagData);
		$email = str_replace(".", " dot ", $email);
		$authors .= $people[$i]->name[0]->tagData." (".$people[$i]->nick[0]->tagData.") &lt;".$email."&gt;<br />\n<ul>\n";
		for ( $j=0; $j<count($people[$i]->role); $j++ )
		{
			$authors.= "<li>".$people[$i]->role[$j]->tagData."</li>\n";
		}
		$authors .= "</ul>\n";
	}
}
$authors .= "<br />\n";
$title = gettext("Authors");
$desc = gettext("This page should list all people who contributed to Frugalware Linux in some way. However, we are aware that the contributor list is incomplete. Please contact us if your name is missing from here!<br />");
$desc .= sprintf(gettext("Available filters: <a href=\"%s\">No filter</a> &middot; "), $fwng_root . "authors");
$desc .= sprintf(gettext("<a href=\"%s\">Active developers</a> &middot; "), $fwng_root . "authors/active");
$desc .= sprintf(gettext("<a href=\"%s\">Former developers</a> &middot; "), $fwng_root . "authors/former");
$desc .= sprintf(gettext("<a href=\"%s\">Contributors</a><br />"), $fwng_root . "authors/contributor");
fwmiddlebox(gettext("Frugalware Linux Author list"), $desc);
fwmiddlebox($title, $authors);

include("footer.php");
?>
