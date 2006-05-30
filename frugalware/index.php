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
 * @author Krisztian VASAS <iron@frugalware.org>
 * @copyright Copyright (c) 2006. Krisztian VASAS
 */

// include some useful functions
include("functions.inc.php");

$lang = getlang();
$llang = getllang($lang);
$flang = ( $lang == "en" ) ? "" : "_$lang";
$xmlfile = "xml/news".$flang.".xml";

// set the locale settings for gettext
putenv("LANG=".$llang);
setlocale(LC_ALL,$llang);
$domain = 'messages';
bindtextdomain($domain, "locale");
textdomain($domain);

// include the config and let's start page
include("config.inc.php");
include("header.php");

// This includes the news.xml XML parser
include("xml.inc.php");

// Let's see whether the news file exist or not
$nolang = 0;
if (!file_exists($xmlfile))
{
	$nolang = 1;
	$xmlfile = "xml/news.xml";
}
$id = ( $_GET['id'] != "" ) ? $_GET['id'] : -1;
$xml = file_get_contents($xmlfile);
$parser = new XMLParser($xml);
$parser->Parse();
$news = $parser->document->post;
// I hata writing a lot. And also the parser creates too long and unuseful object hierarchy
// so create a better-readable one.
// TODO: handle the editedby fields
for ( $i=0; $i<count($news); $i++)
{
	$posts[$i][id] = $news[$i]->id[0]->tagData;
	$posts[$i][title] = "<a class=\"menu\" href=\"".$SERVER[PHP_SELF]."?id=".$posts[$i]['id']."\">".$news[$i]->title[0]->tagData."</a>";
	$posts[$i][date] = $news[$i]->date[0]->tagData;
	$posts[$i][author] = $news[$i]->author[0]->tagData;
	$posts[$i][content] = trim($news[$i]->content[0]->tagData);
}
// Let's write out the news in separate boxes.
// TODO: clicking on the title the page shows the history of the news (editedby)
if ( $id != -1 )
{
	if ( $nolang == 1 )
		print gettext("Sorry, no news on your language, using English instead.");
	for( $i=0; $i<count($posts); $i++ )
	{
		if ( $id == $posts[$i]['id'] )
		{
			fwmiddlebox($posts[$i][title], "<div align=\"right\"><small>".$posts[$i][date]."<br />".gettext("posted by")." ".$posts[$i][author]."</small></div>\n<div align=\"justify\">\n".$posts[$i][content]."\n</div>");
		}
	}
}
else
{
	if ( $nolang == 1 )
		print gettext("Sorry, no news on your language, using English instead.");
	for( $i=0; $i<count($posts); $i++ )
	{
		fwmiddlebox($posts[$i][title], "<div align=\"right\"><small>".$posts[$i][date]."<br />".gettext("posted by")." ".$posts[$i][author]."</small></div>\n<div align=\"justify\">\n".$posts[$i][content]."\n</div>");
	}
}

include("footer.php");
?>
