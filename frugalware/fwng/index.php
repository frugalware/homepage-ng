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
include("lib/functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

include("lib/config.inc.php");

// let's start page
include("header.php");

// This includes the news.xml XML parser
include("lib/xml.inc.php");

// There is some translations
$flang = ( $lang == "en" ) ? "" : "_$lang";
if (file_exists("xml/news".$flang.".xml"))
    $translatefile = "xml/news".$flang.".xml";
else
    $translatefile = "xml/news.xml";

// Official news in english
if (file_exists("xml/news.xml"))
    $xmlfile = "xml/news.xml";
else
    $xmlfile = $docs_path."/xml/news.xml";

$xml = file_get_contents($xmlfile);
$parser = new XMLParser($xml);
$parser->Parse();
$news = $parser->document->post;

if (isset($translatefile) and !empty($translatefile)) {
    $translatexml = file_get_contents($translatefile);
    $parser = new XMLParser($translatexml);
    $parser->Parse();
    $translatenews = $parser->document->post;
}

// I hate writing a lot. And also the parser creates too long and unuseful object hierarchy,
// so create a better-readable one.
for ( $i=0; $i<$news_limit; $i++)
{
    $indextrad = 0;

    for ($j=(count($translatenews)-1); $j>-1; $j--)
    {
        if ($translatenews[$j]->id[0]->tagData == $news[$i]->id[0]->tagData)
        {
            $indextrad = $j;
            $found = true;
            break;
        }
        else
            $found = false;
    }

    if ($found)
        $newpost = $translatenews[$indextrad];
    else
        $newpost = $news[$i];

    // We use icon from icon tag
    if (isset($news[$i]->icon[0]->tagData) and !empty($news[$i]->icon[0]->tagData))
        $posts[$i]['icon'] = $fwng_root . "images/categories/" . $news[$i]->icon[0]->tagData . ".png";
    else
        $posts[$i]['icon'] = $fwng_root . "images/categories/frugalware.png";

    if ($i > 0)
        $show = "<a class=\"news\" onclick=\"toggle_div(this,'new" . $i ."', 1);\"><img src=\"".$fwng_root."images/icons/more.png\" class=\"moreandless\" /></a>";
    else
        $show = "";

    $posts[$i]['id'] = $newpost->id[0]->tagData;
    $posts[$i]['title'] = "<a class=\"boxheader\" href=\"" . $fwng_root . "news/" . $newpost->id[0]->tagData . "\"><img class=\"face\" src=\"" . $posts[$i]['icon'] . "\" width=\"16\" alt=\"\" /> " . $newpost->title[0]->tagData."</a> " . $show;

    date_default_timezone_set('America/New_York');
    $date = new DateTime($newpost->date[0]->tagData);
    $posts[$i]['date'] = $date->format('Y-m-d');

    $posts[$i]['author'] = $newpost->author[0]->tagData;
    $posts[$i]['hidden'] = $newpost->hidden[0]->tagData;
    $posts[$i]['content'] = $newpost->content[0]->tagData;
}

// About dialog
$about = "
                <p>
                    " . gettext("Frugalware is a general purpose linux distribution, designed for intermediate users (who are not afraid of text mode).") . "<br /><br />
                    " . gettext("We try to make Frugalware as simple as possible while not forgetting to keep it comfortable for the user. We try to ship fresh and stable software, as close to the original source as possible, because in our opinion most software is the best as is, and doesn't need patching.") . "<br /><br />
                    " . gettext("More informations in the <a href=\"http://wiki.frugalware.org/index.php/FAQ\">FAQ</a>.") . "
                </p>";

showAbout ($about);

// Latest new
print "\n\n<h2><img src=\"" . $fwng_root . "images/icons/lastnew.png\" />".gettext("Latest new")."</h2>\n";
print "<section id=\"new\">";

showNew ($posts[0], $i);

print "</section>";

// Older news
print "\n\n<h2><img src=\"" . $fwng_root . "images/icons/news.png\" />".gettext("Other news")."</h2>\n";
print "<section id=\"new\">";

for( $i=1; $i<count($posts); $i++ )
{
    showNew ($posts[$i], $i, true);
}

print "</section>";

// Link to news list
print "<div class=\"link\">
    <a href=\"" . $fwng_root . "news\">» " .gettext("Read older news") . "</a>
</div>";

include("footer.php");
?>
