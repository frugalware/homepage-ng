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

// include some useful functions and the config
include("functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

include("config.inc.php");

$flang = ( $lang == "en" ) ? "" : "_$lang";
if (file_exists("xml/news".$flang.".xml"))
	$xmlfile = "xml/news".$flang.".xml";
else
	$xmlfile = $docs_path."/xml/news".$flang.".xml";

// let's start page
include("header.php");

// This includes the news.xml XML parser
include("xml.inc.php");

// Let's see whether the news file exist or not
$nolang = 0;
if (!file_exists($xmlfile))
{
	$nolang = 1;
	if (file_exists("xml/news.xml"))
		$xmlfile = "xml/news.xml";
	else
		$xmlfile = $docs_path."/xml/news.xml";
}

$id = ( $_GET['id'] != "" ) ? $_GET['id'] : -1;
$xml = file_get_contents($xmlfile);
$parser = new XMLParser($xml);
$parser->Parse();
$news = $parser->document->post;

if ( $id != -1 )
	$news_limit = count($news);

// I hate writing a lot. And also the parser creates too long and unuseful object hierarchy,
// so create a better-readable one.
for ( $i=0; $i<$news_limit; $i++)
{
	$posts[$i][id] = $news[$i]->id[0]->tagData;
	$posts[$i][title] = "<a class=\"boxheader\" href=\"".$fwng_root."news/".$posts[$i]['id']."\">".$news[$i]->title[0]->tagData."</a>";
	$posts[$i][date] = $news[$i]->date[0]->tagData;
	$posts[$i][author] = $news[$i]->author[0]->tagData;
	$posts[$i][hidden] = $news[$i]->hidden[0]->tagData;
	$posts[$i][content] = $news[$i]->content[0]->tagData;
	for ( $j=0; $j<count($news[$i]->editedby); $j++ )
	{
		$posts[$i][editedby][$j][name] = $news[$i]->editedby[$j]->name[0]->tagData;
		$posts[$i][editedby][$j][date] = $news[$i]->editedby[$j]->date[0]->tagData;
	}
	if (count($news[$i]->icon) > 0)
		$posts[$i][icon] = $news[$i]->icon[0]->tagData;
	else
		$posts[$i][icon] = $fwng_root . "images/frugalware.png";
}
// Let's write out the news in separate boxes.
if ( $id != -1 )
{
	if ( $nolang == 1 )
		print gettext("Sorry, no news on your language, using English instead.");
	for( $i=0; $i<count($posts); $i++ )
	{
		if ( $id == $posts[$i]['id'] )
		{
			$edited = "";
			for ( $j=0; $j<count($posts[$i][editedby]); $j++ )
			{
				$edited .= $posts[$i][editedby][$j][name]." ".gettext(" edited this news on ").$posts[$i][editedby][$j][date]."<br />";
			}
			fwmiddlebox($posts[$i][title], "<img class=\"face\" src=\"" . $posts[$i][icon] . "\" width=\"85\" height=\"85\" alt=\"\" /><br />\n<div align=\"justify\">\n".$posts[$i][content]."\n</div><p class=\"date\">".gettext("Posted by")." ".$posts[$i][author]." - ".$posts[$i][date]."</p>");
			if ( $edited != "" ) fwmiddlebox(gettext("News history"), $edited);
			print "<hr /><br />";
		}
	}
}
else
{
	if ( $nolang == 1 )
		print gettext("Sorry, no news on your language, using English instead.");
	for( $i=0; $i<count($posts); $i++ )
	{
		if ( $posts[$i][hidden] == 0 )
			fwmiddlebox($posts[$i][title], "<img class=\"face\" src=\"" . $posts[$i][icon] . "\" width=\"85\" height=\"85\" alt=\"\" /><br />\n<div align=\"justify\">\n".$posts[$i][content]."\n</div><p class=\"date\">".gettext("Posted by")." ".$posts[$i][author]." - ".$posts[$i][date]."</p>");
	}
}

include("footer.php");
?>
