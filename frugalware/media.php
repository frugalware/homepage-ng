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
 * @author Alex Smith <alex.extreme2@gmail.com>
 * @copyright Copyright (C) 2006 Alex Smith
 */

// Include some useful functions and the config
include('functions.inc.php');
include('config.inc.php');

$lang = getlang();
$llang = getllang($lang);
$flang = ( $lang == 'en' ) ? "" : "_$lang";
if (file_exists('xml/media.xml'))
	$xmlfile = 'xml/media.xml';
else
	$xmlfile = $docs_path.'xml/media.xml';

// Set the locale settings for gettext
putenv("LANG=".$llang);
setlocale(LC_ALL,$llang);
$domain = 'messages';
bindtextdomain($domain, 'locale');
textdomain($domain);

// Let's start the page
include('header.php');

// This includes the XML parser
include('xml.inc.php');

// Let's see whether the media file exist or not
if (!file_exists($xmlfile)) {
	
	echo(gettext('Sorry, a media file has not been written yet.'));
	include('footer.php');
	die();
	
}

fwmiddlebox(gettext('Frugalware in the press'),
	gettext('This page contains details about some of the articles that have been posted on the Internet about Frugalware. If you find an article not listed here, please tell us about it!'));

$xml = file_get_contents($xmlfile);
$parser = new XMLParser($xml);
$parser->Parse();
$media = $parser->document->article;

// The parser creates too long and unuseful object hierarchy, so create a better-readable one.
for ( $i = 0; $i < count($media); $i++) {
	
	$articles[$i][date] = $media[$i]->date[0]->tagData;
	$articles[$i][language] = $media[$i]->language[0]->tagData;
	$articles[$i][where] = $media[$i]->where[0]->tagData;
	$articles[$i][title] = $media[$i]->title[0]->tagData;
	$articles[$i][link] = $media[$i]->link[0]->tagData;
	
}

// Let's write out details of each article in a separate box
for( $i = 0; $i < count($articles); $i++ ) {
	
	fwmiddlebox($articles[$i][where] . ' - ' . $articles[$i][title],
		'<table width="100%">
		<tr><td width="30%">' . gettext('Title') . ':</td><td width="70%">' . $articles[$i][title] . '</td></tr>
		<tr><td>' . gettext('Where') . ':</td><td>' . $articles[$i][where] . '</td></tr>
		<tr><td>' . gettext('Date') . ':</td><td>' . $articles[$i][date] . '</td></tr>
		<tr><td>' . gettext('Language') . ':</td><td>' . $articles[$i][language] . '</td></tr>
		<tr><td>' . gettext('Link') . ':</td><td><a href="' . $articles[$i][link] . '">' . $articles[$i][link] . '</a></td></tr></table>');
	
}

include("footer.php");
?>
