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
 * @copyright Copyright (c) 2006. Alex Smith
 */

include("xml.inc.php");
include("config.inc.php");
include("db.inc.php");

function genHeader($usegettext = true) {

    global $fwng_root;
    global $sqltype;
    global $sqlhost;
    global $sqluser;
    global $sqlpass;
    global $sqldb;
    global $pkgcache;
    global $pkgcachetimeout;
    global $upfile;
    global $docs_path;
    global $uptime;
    global $defaultMirror;

    // Find where the XML roadmap file is
    if (file_exists('xml/roadmap.xml'))
        $xmlfl = 'xml/roadmap.xml';
    else
        $xmlfl = $docs_path.'xml/roadmap.xml';

    // And read it in
    $xml = file_get_contents($xmlfl);
    $parser = new XMLParser($xml);
    $parser->Parse();
    $roadmap = $parser->document->release;

    $currentavailable = false;
    // The latest version is always in development
    if ($roadmap[0]->status[0]->tagData == 0) {
        for ($i = 0; $i < count($roadmap[0]->prerelease); $i++) {
            if ($roadmap[0]->prerelease[$i]->prestatus[0]->tagData == 1) {
                $currentnumber = $roadmap[0]->version[0]->tagData . $roadmap[0]->prerelease[$i]->preversion[0]->tagData;
                $currentdate = $roadmap[0]->prerelease[$i]->predate[0]->tagData;
                $currentname = $roadmap[0]->name[0]->tagData;
                $currentavailable = true;
                break;
            }
        }

        $stablenumber = $roadmap[1]->version[0]->tagData;
        $stablename = $roadmap[1]->name[0]->tagData;
        $stabledate = $roadmap[1]->date[0]->tagData;
    }
    // The lastest version is the stable one
    else {
        $stablenumber = $roadmap[0]->version[0]->tagData;
        $stablename = $roadmap[0]->name[0]->tagData;
        $stabledate = $roadmap[0]->date[0]->tagData;
        $currentavailable = false;
    }

    // Produce a better readable structure
    $j = 0;
    for ( $i = 0; $i < count($roadmap); $i++) {

        if ($roadmap[$i]->status[0]->tagData == 1) {

            $stable[$j]["name"] = $roadmap[$i]->name[0]->tagData;
            $stable[$j]["version"] = $roadmap[$i]->version[0]->tagData;
            $stable[$j]["date"] = $roadmap[$i]->date[0]->tagData;
            $stable[$j]["newsid"] = $roadmap[$i]->newsid[0]->tagData;
            $j++;

        }

    }

    // Create the info
    $rels = "";
    for ( $i=0; $i<count($stable); $i++ ) {

        $rels .= "<p><a href=\"".$fwng_root."news/".$stable[$i]['newsid']."\">frugalware-".$stable[$i]['version']." (".$stable[$i]['name'].")</a><br />".$stable[$i]['date']."</p>\n";

    }

    $rels .= "<p align=\"center\">\n<a href=\"${fwng_root}rss/releases\">RSS</a>\n</p>\n";

    if(file_exists($pkgcache))
        $info = stat($pkgcache);

    if(!(isset($info) && ((time() - $info["mtime"])<$pkgcachetimeout))) {

        $db = new FwDB();
        $db->doConnect($sqlhost, $sqluser, $sqlpass, $sqldb);

        $query = "select packages.pkgname, groups.name, packages.id,
            packages.pkgver, packages.arch, packages.`desc`,
            unix_timestamp(packages.builddate) from packages, groups,
            ct_groups where packages.id = ct_groups.pkg_id and
            ct_groups.group_id = groups.id group by
            concat(packages.pkgname, packages.arch, fwver) order by
            packages.builddate desc limit 10";
        $result = $db->doQuery($query);

        //~ $pkgs = [];
        while($i = $db->doFetchRow($result))
            $pkgs[] = $i;

        $db->doClose();

        $fp = fopen($pkgcache, "w");
        fwrite($fp, "<div align=\"left\">\n");

        if (!empty($pkgs)) {
            foreach($pkgs as $i) {

                fwrite($fp, "<a href=\"${fwng_root}packages/${i['id']}\">${i['pkgname']} <span style=\"float: right;\">${i['pkgver']}-${i['arch']}</span></a><br />\n");

            }
        }
        else {
            fwrite($fp, "\t\t\t\t\t\t<b>Can't access to database</b>\n");
        }

        fwrite($fp, "\t\t\t\t\t</div>");
        fclose($fp);
    }

    $recupd = file_get_contents($pkgcache);
    $data = array("releases" => $rels, "packages" => $recupd, "uptime" => $uptime);

    // Get Frugalware
    $stableversion = $stablenumber . " " . $stablename;
    $currentversion = $currentnumber . " " . $currentname;

    // Find where the XML roadmap file is
    if (file_exists('xml/mirrors2.xml'))
        $xmlfl = 'xml/mirrors2.xml';
    else
        $xmlfl = $docs_path.'xml/mirrors2.xml';

    // And read it in
    $xml = file_get_contents($xmlfl);
    $parser = new XMLParser($xml);
    $parser->Parse();
    $mirrorLangs = $parser->document->mirror;

    $lang = getlang();

    // We search if there is a mirror which corresponding to current language
    for ( $i = 0; $i < count($mirrorLangs); $i++)
    {
        if ($mirrorLangs[$i]->country_code[0]->tagData == $lang || ($mirrorLangs[$i]->country_code[0]->tagData == "us" && $lang == "en"))
        {
            $dlid = $i;
            $dlnbr = $mirrorLangs[$i]->id[0]->tagData;
        }
        // Default mirror
        else if ($mirrorLangs[$i]->country_code[0]->tagData == $defaultMirror)
        {
            $defaultid = $i;
            $defaultnbr = $mirrorLangs[$i]->id[0]->tagData;
        }
    }

    // We use default id if there is no mirror for current language
    if (!isset($dlnbr))
    {
        $dlid = $defaultid;
        $dlnbr = $defaultnbr;
    }

    for($j = 0; $j < count($mirrorLangs[$dlid]->type); $j++)
        $mirrorType['types'][] = $mirrorLangs[$dlid]->type[$j]->tagData;

    $data["download"] = showGetWidget ("stable", $stableversion, $stablenumber, $stabledate, $dlnbr, $mirrorLangs[$dlid]);

    if ($currentavailable)
        $data["download"] .= showGetWidget ("current", $currentversion, $currentnumber, $currentdate, $dlnbr, $mirrorLangs[$dlid]);

    $data["download"] .= "
                    <div align=\"right\"><a href=\"" . $fwng_root . "docs\">" . gettext("See documentation") . "</a> - <a href=\"" . $fwng_root . "download\">" . gettext("Other mirrors") . "</a></div>";

    // IRC
    if (file_exists('./static/irc.inc.html')) {
        $irc = file_get_contents('./static/irc.inc.html');
        $data["irc"] = $irc;
        $data["irc"] .= "<div align=\"right\"><a href=\"" . $fwng_root . "irc\">" . gettext("More informations") . "</a></div>";
    } else
        $data["irc"] = "";

    // Social Networks
    if (file_exists('./static/socialnetworks.inc.html')) {
        $socialnetworks = "<p>" . gettext("Share Frugalware with your friends.") . "</p>\n";
        $socialnetworks .= file_get_contents('./static/socialnetworks.inc.html');
        $data["socialnetworks"] = $socialnetworks;
    } else
        $data["socialnetworks"] = "";

    // PayPal donate
    if (file_exists('./static/donation.inc.html')) {
        $paypal = "<p>" . gettext("Donate to support our development efforts.") . "</p>\n";
        $paypal .= file_get_contents('./static/donation.inc.html');
        $data["paypal"] = $paypal;
    } else
        $data["paypal"] = "";

    // Give the array back.
    return $data;
}
?>
