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
 * @copyright Copyright (C) 2006 Alex Smith
 */

// Include some useful functions and the config
include('lib/functions.inc.php');

$lang = getlang();
$llang = getllang($lang);

// Set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

// Let's start the page
include('lib/config.inc.php');
include('header.php');

// This includes the XML parser
include('lib/xml.inc.php');

// Let's see whether the security file exist or not
$flang = ( $lang == 'en' ) ? "" : "_$lang";
if (file_exists('xml/security.xml'))
    $xmlfile = 'xml/security.xml';
else
    $xmlfile = $docs_path.'xml/security.xml';
if (!file_exists($xmlfile)) {

    echo(gettext('Sorry, a security file has not been written yet.'));
    include('footer.php');
    die();

}

if ( isset($_GET['id']) != "" )
    $id = $_GET['id'];
else
    $id = false;

if ( !$id )
fwemptybox(gettext('Frugalware Security Announcements (FSAs)'),
    gettext('This is a list of security announcments that have been released for the current stable version of Frugalware'));

$xml = file_get_contents($xmlfile);
$parser = new XMLParser($xml);
$parser->Parse();
$security = $parser->document->fsa;

// The parser creates too long and unuseful object hierarchy, so create a better-readable one.
for ( $i = 0; $i < count($security); $i++) {

    $fsas[$i]['id'] = $security[$i]->id[0]->tagData;
    $fsas[$i]['date'] = $security[$i]->date[0]->tagData;
    $fsas[$i]['author'] = $security[$i]->author[0]->tagData;
    $fsas[$i]['package'] = $security[$i]->package[0]->tagData;
    $fsas[$i]['vulnerable'] = $security[$i]->vulnerable[0]->tagData;
    $fsas[$i]['unaffected'] = $security[$i]->unaffected[0]->tagData;
    $fsas[$i]['bts'] = $security[$i]->bts[0]->tagData;
    $fsas[$i]['cve'] = $security[$i]->cve[0]->tagData;
    $fsas[$i]['desc'] = $security[$i]->desc[0]->tagData;

}

// Let's write out details of each FSA in a separate box
for( $i = 0; $i < count($fsas); $i++ ) {
    if(!$id or $fsas[$i][id]==$id)
    {
    fwmiddlebox("<a href=\"".$fwng_root."security/".$fsas[$i]['id']."\">FSA" . $fsas[$i]['id'] . ' - ' . $fsas[$i]['package']."</a>",
        '<table width="100%">
        <tr><td width="180px"><b>' . gettext('Package') . '</b>:</td><td>' . $fsas[$i]['package'] . '</td></tr>
        <tr><td><b>' . gettext('Date') . '</b>:</td><td>' . $fsas[$i]['date'] . '</td></tr>
        '.(strlen($fsas[$i]['author']) ? '<tr><td><b>' . gettext('Posted by') . '</b>:</td><td>' . $fsas[$i]['author'] . '</td></tr>':'').'
        <tr><td><b>' . gettext('Vulnerable version') . '</b>:</td><td>' . $fsas[$i]['vulnerable'] . '</td></tr>
        <tr><td><b>' . gettext('Unaffected version') . '</b>:</td><td>' . $fsas[$i]['unaffected'] . '</td></tr>
        <tr><td><b>' . gettext('Bug tracker entry') . '</b>:</td><td><a href="' . $fsas[$i]['bts'] . '">' . $fsas[$i]['bts'] . '</a></td></tr>
        <tr><td><b>' . gettext('CVEs') . '</b>:</td><td>' . $fsas[$i]['cve'] . '</td></tr>
        <tr><td><b>' . gettext('Description') . '</b>:</td><td>' . $fsas[$i]['desc'] . '</td></tr></table>');
    }

}

include("footer.php");
?>
