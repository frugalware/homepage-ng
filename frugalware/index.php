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
include("config.inc.php");

$lang = getlang();
$llang = getllang($lang);
$flang = ( $lang == "en" ) ? "" : "_$lang";
if (file_exists("xml/news".$flang.".xml"))
	$xmlfile = "xml/news".$flang.".xml";
else
	$xmlfile = $docs_path."/xml/news".$flang.".xml";

// set the locale settings for gettext
putenv("LANG=".$llang);
setlocale(LC_ALL,$llang);
bindtextdomain($domain, "locale");
textdomain($domain);

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
// I hate writing a lot. And also the parser creates too long and unuseful object hierarchy,
// so create a better-readable one.
// TODO: handle the editedby fields
for ( $i=0; $i<count($news); $i++)
{
	$posts[$i][id] = $news[$i]->id[0]->tagData;
	$posts[$i][title] = "<a class=\"menu\" href=\"".$fwng_root."news/".$posts[$i]['id']."\">".$news[$i]->title[0]->tagData."</a>";
	$posts[$i][date] = $news[$i]->date[0]->tagData;
	$posts[$i][author] = $news[$i]->author[0]->tagData;
	$posts[$i][content] = $news[$i]->content[0]->tagData;
	for ( $j=0; $j<count($news[$i]->editedby); $j++ )
	{
		$posts[$i][editedby][$j][name] = $news[$i]->editedby[$j]->name[0]->tagData;
		$posts[$i][editedby][$j][date] = $news[$i]->editedby[$j]->date[0]->tagData;
	}
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
			$edited = "";
			for ( $j=0; $j<count($posts[$i][editedby]); $j++ )
			{
				$edited .= $posts[$i][editedby][$j][name]." ".gettext(" edited this news on ").$posts[$i][editedby][$j][date]."<br />";
			}
			fwmiddlebox($posts[$i][title], "<div align=\"right\"><small>".$posts[$i][date]."<br />".gettext("posted by")." ".$posts[$i][author]."</small></div>\n<div align=\"justify\">\n".$posts[$i][content]."\n</div>");
			if ( $edited != "" ) fwmiddlebox(gettext("News history"), $edited);
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
