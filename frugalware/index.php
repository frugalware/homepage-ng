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


$loopIndex = 0;     // Using to feed the loop
$visibleNews = 0;   // Using to put a new in $posts array

while ($visibleNews < $news_limit) {

    $translationIndex = NULL;

    for ($j=(count($translatenews)-1); $j>-1; $j--) {

        // Check if there is a translation for current new
        if ($translatenews[$j]->id[0]->tagData == $news[$loopIndex]->id[0]->tagData) {
            $translationIndex = $j;
            break;
        }
    }

    // Get the translation new data
    $postData = ($translationIndex != NULL ? $translatenews[$translationIndex] : $news[$loopIndex]);

    // Get only visible data
    if ($postData->hidden[0]->tagData == 0) {

        // We use icon from icon tag
        if (isset($news[$loopIndex]->icon[0]->tagData) and !empty($news[$loopIndex]->icon[0]->tagData))
            $posts[$visibleNews]['icon'] = $fwng_root . "images/categories/" . $news[$loopIndex]->icon[0]->tagData . ".png";
        else
            $posts[$visibleNews]['icon'] = $fwng_root . "images/categories/frugalware.png";

        // Show an arrow next to new title
        $show = ($visibleNews > 0 ? "<a class=\"news\" onclick=\"toggle_div(this,'new" . $visibleNews ."', 1);\"><img src=\"".$fwng_root."images/icons/more.png\" class=\"moreandless\" /></a>" : "");

        $posts[$visibleNews]['id'] = $postData->id[0]->tagData;

        $posts[$visibleNews]['title'] = "<a class=\"boxheader\" href=\"" . $fwng_root . "news/" . $postData->id[0]->tagData . "\"><img class=\"face\" src=\"" . $posts[$visibleNews]['icon'] . "\" width=\"16\" alt=\"\" /> " . $postData->title[0]->tagData."</a> " . $show;

        date_default_timezone_set('America/New_York');
        $date = new DateTime($postData->date[0]->tagData);
        $posts[$visibleNews]['date'] = $date->format('Y-m-d');

        $posts[$visibleNews]['author'] = $postData->author[0]->tagData;
        $posts[$visibleNews]['hidden'] = $postData->hidden[0]->tagData;
        $posts[$visibleNews]['content'] = $postData->content[0]->tagData;

        $visibleNews += 1;
    }

    $loopIndex += 1;
}


// About dialog
$about = "
                <p>
                    " . gettext("Frugalware is a general purpose linux distribution, designed for intermediate users (who are not afraid of text mode).") . "<br /><br />
                    " . gettext("We try to make Frugalware as simple as possible while not forgetting to keep it comfortable for the user. We try to ship fresh and stable software, as close to the original source as possible, because in our opinion most software is the best as is, and doesn't need patching.") . "<br /><br />
                    " . gettext("More informations in the <a href=\"http://github.com/frugalware/frugalware-current/wiki/index.php/FAQ\">FAQ</a>.") . "
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
    <a href=\"" . $fwng_root . "news.php\">» " .gettext("Read older news") . "</a>
</div>";

include("footer.php");
?>
