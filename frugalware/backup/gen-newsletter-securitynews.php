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
 * @author Alex Smith <alex@alex-smith.me.uk>
 * @copyright Copyright (C) 2007 Alex Smith
 */

if (isset($argv[1]))
        $from = $argv[1];
else
	die("Need an argument stating which FSA to start on\n");

// This includes the XML parser
include('xml.inc.php');

// Let's see whether the security file exist or not
if (file_exists('xml/security.xml'))
	$xmlfile = 'xml/security.xml';
else
	die("Sorry, a security file has not been written yet.\n");

print "Check the description output by this script, it may not always be reliable.\n\n";

$xml = file_get_contents($xmlfile);
$parser = new XMLParser($xml);
$parser->Parse();
$security = $parser->document->fsa;

// The parser creates too long and unuseful object hierarchy, so create a better-readable one.
for ( $i = 0; $i < count($security); $i++) {

	$fsas[$i][id] = $security[$i]->id[0]->tagData;
	$fsas[$i][date] = $security[$i]->date[0]->tagData;
	$fsas[$i][author] = $security[$i]->author[0]->tagData;
	$fsas[$i][package] = $security[$i]->package[0]->tagData;
	$fsas[$i][vulnerable] = $security[$i]->vulnerable[0]->tagData;
	$fsas[$i][unaffected] = $security[$i]->unaffected[0]->tagData;
	$fsas[$i][bts] = $security[$i]->bts[0]->tagData;
	$fsas[$i][cve] = $security[$i]->cve[0]->tagData;
	$fsas[$i][desc] = $security[$i]->desc[0]->tagData;
	$fsas[$i][shortdesc] = explode(". ", $security[$i]->desc[0]->tagData);
	$fsas[$i][shortdesc] = explode(".\n", $fsas[$i][shortdesc][0]);
	$fsas[$i][shortdesc] = $fsas[$i][shortdesc][0];
}

// Write out table header
	print"<table border=1 cellpadding=5 cellspacing=0><tr></tr><th>FSA</th><th>Package</th><th>FSA Description</th><th>Upgrade To</th></tr>";

// Let's write out details of each FSA in a separate box
for( $i = 0; $i < count($fsas); $i++ ) {

	if ($fsas[$i][id] >= $from)
		print "<tr><td>FSA" . $fsas[$i][id] . "</td><td>" . $fsas[$i][package] . "</td><td>" . $fsas[$i][shortdesc] . "</td><td>" . $fsas[$i][package] . "-" . $fsas[$i][unaffected] . "</td></tr>\n";

}

print "</table>\n";
?>
