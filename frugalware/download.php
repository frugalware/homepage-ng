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
 * Frugalware Linux Homepage - Download page
 *
 * @author Krisztian VASAS <iron@frugalware.org>
 *
 * @copyright Copyright (c) 2006. Krisztian VASAS
 * @copyright Copyright (c) 2005-2006. Miklos Vajna
 */

// include some useful functions and the config
include("lib/functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

// let's start page
include("lib/config.inc.php");
include("header.php");
include("lib/xml.inc.php");

if (file_exists("xml/mirrors2.xml"))
    $mirrorsfile = "xml/mirrors2.xml";
else
    $mirrorsfile = $docs_path."/xml/mirrors2.xml";
$xml = file_get_contents($mirrorsfile);
$parser = new XMLParser($xml);
$parser->Parse();
$mirrors = array();
for ( $i=0; $i<count($parser->document->mirror); $i++)
{
    $mirror = array();
    $mirror['id'] = $parser->document->mirror[$i]->id[0]->tagData;
    for($j=0; $j<count($parser->document->mirror[$i]->type);$j++)
        $mirror['types'][] = $parser->document->mirror[$i]->type[$j]->tagData;

    // There is some mirros without ftp/http/rsync so we must check if there
    // are any of them
    if (!empty($parser->document->mirror[$i]->path[0]->tagData))
        $mirror['path'] = $parser->document->mirror[$i]->path[0]->tagData;
    else
        $mirror['path'] = "";

    if (!empty($parser->document->mirror[$i]->ftp_path[0]->tagData))
        $mirror['ftp_path'] = $parser->document->mirror[$i]->ftp_path[0]->tagData;
    else
        $mirror['ftp_path'] = "";

    if (!empty($parser->document->mirror[$i]->http_path[0]->tagData))
        $mirror['http_path'] = $parser->document->mirror[$i]->http_path[0]->tagData;
    else
        $mirror['http_path'] = "";

    if (!empty($parser->document->mirror[$i]->rsync_path[0]->tagData))
        $mirror['rsync_path'] = $parser->document->mirror[$i]->rsync_path[0]->tagData;
    else
        $mirror['rsync_path'] = "";

    $mirror['link'] = $parser->document->mirror[$i]->link[0]->tagData;
    $mirror['country'] = $parser->document->mirror[$i]->country[0]->tagData;
    $mirror['supplier'] = $parser->document->mirror[$i]->supplier[0]->tagData;
    $mirror['bandwidth'] = $parser->document->mirror[$i]->bandwidth[0]->tagData;
    $mirrors[$mirror['country']][] = $mirror;
}
ksort($mirrors);

if (isset($_GET['url']))
    $url = addslashes(stripslashes($_GET['url']));
else
    $url = "";

$isoDescription = gettext("An installation guide is available in the Frugalware docs : ") . "<a href=\"" . $fwng_root . "docs/stable/install.html\">Installation guide</a>";

fwemptybox("<img src=\"" . $fwng_root . "images/icons/download.png\" />". gettext("Informations"), $isoDescription);

print "<h2><img src=\"" . $fwng_root . "images/icons/download.png\" />". gettext("Mirror list") . "</h2>";

foreach($mirrors as $k => $v)
{
    $str = "<ul>\n";
    if($k == "")
        continue;
    foreach($v as $i)
    {
        foreach($i['types'] as $j)
        {
            if (!empty($j)) {
                $j=="http" ? $domain = "www" : $domain = $j;
                if($i[$j."_path"] == "")
                    $i[$j.'_path'] = $i['path'];
                if (strlen($i[$j.'_path']))
                    $i[$j.'_path'] .= "/";
                $str .= "<li><a href=\"".$j."://".$domain.$i['id']."." . $i['link'] . "/".$i[$j.'_path']."$url\">".
                    $i['supplier']." (".$j."/".$i['bandwidth'].")</a></li>\n";
            }
        }
    }
    $str .= "</ul>\n";
    print '<a name="'.strtolower($k).'" />';
    fwmiddlebox('<a href="#'.strtolower($k).'">'.$k.'</a>', $str);

}

// fwemptybox( "<img src=\"" . $fwng_root . "images/icons/log.png\" />" . gettext( 'Archive' ), gettext( 'Unfortunately due our limited resources we cannot store our old stable versions, they are being removed shortly after a new official stable release. But if you are interested in our old stable versions, ask IroNiQ on #frugalware @freenode or ask in email on one of our lists.' ) );

include("footer.php");
?>
