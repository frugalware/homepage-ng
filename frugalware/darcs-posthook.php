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

$latestid = file_get_contents('_darcs/third_party/latest');

require('frugalware/xml.inc.php');

$xml = file_get_contents('frugalware/xml/news.xml');
$parser = new XMLParser($xml);
$parser->Parse();
$news = $parser->document->post;

$xmllatestid = $news[0]->id[0]->tagData;

if ($xmllatestid > $latestid) {
	
	$title = $news[0]->title[0]->tagData;
	$author = $news[0]->author[0]->tagData;
	$content = strip_tags(preg_replace("#<br />#", "\n", $news[0]->content[0]->tagData));
	
	mail("alex.extreme2@gmail.com", $title, $content, 'From: ' . $author . ' <noreply@frugalware.org>' . "\r\n");
	
	$handle = fopen('_darcs/third_party/latest', 'w');
	fwrite($handle, $xmllatestid);
	fclose($handle);
	
}
?>
