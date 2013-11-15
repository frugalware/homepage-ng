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

$page = ( isset($_GET['page']) != "" ) ? $_GET['page'] : 1;
$id = ( isset($_GET['id']) != "" ) ? $_GET['id'] : -1;

// There is some translations
$flang = ( $lang == "en" ) ? "" : "_$lang";


// News translation
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


// Show all the news
if ($id == -1) {
    $nbrPages = ceil(count($news)/$news_list_limit);

    if ($page > $nbrPages || $page < 1)
        $page = 1;

    if (isset($page) && $page != -1)
        $nbrInit = ($page - 1) * $news_list_limit;
    else
        $nbrInit = 0;


    // I hate writing a lot. And also the parser creates too long and unuseful object hierarchy,
    // so create a better-readable one.

    $index = 0;
    for ( $i=$nbrInit; $i<$nbrInit + $news_list_limit; $i++)
    {
        if (!empty($news[$i]))
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
                $posts[$index]['icon'] = $fwng_root . "images/categories/" . $news[$i]->icon[0]->tagData . ".png";
            else
                $posts[$index]['icon'] = $fwng_root . "images/categories/frugalware.png";


            $posts[$index]['id'] = $news[$i]->id[0]->tagData;
            $posts[$index]['title'] = $newpost->title[0]->tagData;

            date_default_timezone_set('America/New_York');
            $formatdate = new DateTime($news[$i]->date[0]->tagData);
            $posts[$index]['date'] = $formatdate->format('Y-m-d');
            //~ $posts[$index]['date'] = $news[$i]->date[0]->tagData;

            $posts[$index]['author'] = $news[$i]->author[0]->tagData;
            $posts[$index]['hidden'] = $news[$i]->hidden[0]->tagData;
        }

        $index ++;

    }

    print "<h2><img src=\"" . $fwng_root . "images/icons/news.png\" />" . gettext("Frugalware news list") . "</h2>";

    print "<table id=\"newsList\">
        <tr><th></th><th>Title</th><th>Date</th><th>Authors</th></tr>";
    for( $i=0; $i<count($posts); $i++ )
    {
        if ( $posts[$i]['hidden'] == 0 )
            showListNews ($posts[$i]);

    }
    print "</table>";

    print "<div class=\"pagination\">";

    // First and previous
    if ($page > 1)
        print "<a href=\"" . $fwng_root . "news\">« " . gettext("First") . "</a>";
    if ($page > 2)
        print "<a href=\"" . $fwng_root . "news?page=" . ($page - 1) . "\">" . gettext("Previous") . "</a>";

    // Page
    for ($i=1; $i<=$nbrPages; $i++) {
        if ($i == $page)
            print "<b>" . ($i) . "</b>";
        else
            print "<a href=\"" . $fwng_root . "news?page=" . ($i) . "\">" . ($i) . "</a>";
    }

    // Next and last
    if ($page < $nbrPages - 1)
        print "<a href=\"" . $fwng_root . "news?page=" . ($page + 1) . "\">" . gettext("Next") . "</a>";
    if ($page < $nbrPages)
        print "<a href=\"" . $fwng_root . "news?page=" . $nbrPages . "\">" . gettext("Last") . " »</a>";

    print "</div>";
}


// Show the news specify by id
else
{
    $nbrPages = ceil(count($news)/$news_list_limit);
    $page = $nbrPages - floor(($id * $nbrPages) / count($news));
    if ($page == 0)
        $page = 1;

    print "<div class=\"link\"><a href=\"" . $fwng_root . "news?page=" . $page . "\">&lt; " . gettext("Back to the news list") . "</a></div>";

    $indextrad = 0;

    $id = count($news) - $id;

    for ($j=(count($translatenews)-1); $j>-1; $j--)
    {
        if ($translatenews[$j]->id[0]->tagData == $news[$id]->id[0]->tagData)
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
        $newpost = $news[$id];

    // We use icon from icon tag
    if (isset($news[$id]->icon[0]->tagData) and !empty($news[$id]->icon[0]->tagData))
        $post['icon'] = $fwng_root . "images/categories/" . $news[$id]->icon[0]->tagData . ".png";
    else
        $post['icon'] = $fwng_root . "images/categories/frugalware.png";


    $post['id'] = $news[$id]->id[0]->tagData;

    date_default_timezone_set('America/New_York');
    $formatdate = new DateTime($news[$id]->date[0]->tagData);
    $post['date'] = $formatdate->format('Y-m-d');
    $post['author'] = $news[$id]->author[0]->tagData;
    $post['hidden'] = $news[$id]->hidden[0]->tagData;
    $post['content'] = $newpost->content[0]->tagData;

    print "<h2><img class=\"face\" src=\"" . $post['icon'] . "\" width=\"20\" alt=\"\" /> " . $newpost->title[0]->tagData."</h2>
        <section id=\"new\">";

    showNew ($post, 0);

    print "</section>";
}

include("footer.php");
?>
