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
 * Frugalware Linux Homepage - Development roadmap page
 *
 * @author Krisztian VASAS <iron@frugalware.org>
 * @author Miklos Vajna <vmiklos@frugalware.org>
 * @author Alex Smith <alex.extreme2@gmail.com>
 *
 * @copyright Copyright (c) 2006. Krisztian VASAS
 * @copyright Copyright (c) 2005-2006. Miklos Vajna
 * @copyright Copyright (c) 2006. Alex Smith
 */

// Include some useful functions and the config
include('functions.inc.php');
include('config.inc.php');

// Some definitions
$lang = getlang();
$llang = getllang($lang);
if (file_exists('xml/roadmap.xml'))
	$xmlfile = 'xml/roadmap.xml';
else
	$xmlfile = $docs_path.'xml/roadmap.xml';

// Set the locale settings for gettext
putenv("LANG=" . $llang);
setlocale(LC_ALL, $llang);
bindtextdomain($domain, 'locale');
textdomain($domain);

// Let's start the page
include('header.php');

// This includes the XML parser
include('xml.inc.php');

// Let's see whether the roadmap file exists or not
if (!file_exists($xmlfile)) {
	
	echo(gettext('Sorry, a roadmap has not been written yet.'));
	include('footer.php');
	die();
	
}

$xml = file_get_contents($xmlfile);
$parser = new XMLParser($xml);
$parser->Parse();
$roadmap = $parser->document->release;

// The parser creates a too long and unuseful object hierarchy so create a better-readable one.
for ( $i = 0; $i < count($roadmap); $i++) {
	
	$releases[$i][name] = $roadmap[$i]->name[0]->tagData;
	$releases[$i][definition] = $roadmap[$i]->definition[0]->tagData;
	$releases[$i][version] = $roadmap[$i]->version[0]->tagData;
	$releases[$i][date] = $roadmap[$i]->date[0]->tagData;
	if ($roadmap[$i]->status[0]->tagData == 1)
		$releases[$i][status] = gettext('done');
	else
		$releases[$i][status] = gettext('pending');
	
	for ( $j=0; $j < count($roadmap[$i]->prerelease); $j++ ) {
		
		$releases[$i][prerelease][$j][preversion] = $roadmap[$i]->prerelease[$j]->preversion[0]->tagData;
		$releases[$i][prerelease][$j][predate] = $roadmap[$i]->prerelease[$j]->predate[0]->tagData;
		if ($roadmap[$i]->prerelease[$j]->prestatus[0]->tagData == 1)
			$releases[$i][prerelease][$j][prestatus] = gettext('done');
		else
			$releases[$i][prerelease][$j][prestatus] = gettext('pending');
		
	}
	
}

for( $i=0; $i < count($releases); $i++ ) {
	
	$content = '<table width="100%">
		<tr><td width="30%">' . $releases[$i][date] . '</td><td width="30%">' . $releases[$i][version] . '</td><td width="30%"><i>' . $releases[$i][status] . '</i></td></tr>';
	
	for ( $j=0; $j < count($releases[$i][prerelease]); $j++ ) {
		
		$content .= '<tr><td>' . $releases[$i][prerelease][$j][predate] . '</td><td>' . $releases[$i][version] . $releases[$i][prerelease][$j][preversion] . '</td><td><i>' . $releases[$i][prerelease][$j][prestatus] . '</i></td></tr>';
		
	}
	
	$content .= '</table>';
	fwmiddlebox($releases[$i][version] . ' (<acronym title="' . $releases[$i][definition] . '">' . $releases[$i][name] . '</acronym>)',
		$content);
	
}

include("footer.php");
?>
