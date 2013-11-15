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
 * Frugalware Linux Homepage - Authors' page
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

// let's start page
include("lib/config.inc.php");
include("header.php");

include("lib/xml.inc.php");

include("lib/libravatar.php");

function sort_people($a, $b)
{
    return(strcmp($a->name[0]->tagData, $b->name[0]->tagData));
}

$desc = gettext("This page should list all people who contributed to Frugalware Linux in some way. However, we are aware that the contributor list is incomplete. Please contact us if your name is missing from here!<br /><br />");
$desc .= gettext("Available filters: ");
$desc .= "<a href=\"" . $fwng_root . "authors\">" . gettext("Active developers") . "</a> &middot; ";
$desc .= "<a href=\"" . $fwng_root . "authors/former\">" . gettext("Former developers") . "</a> &middot; ";
$desc .= "<a href=\"" . $fwng_root . "authors/contributor\">" . gettext("Contributors") . "</a> &middot; ";
$desc .= "<a href=\"" . $fwng_root . "authors/nofilter\">" . gettext("Everybody") . "</a>";
fwemptybox("<img src=\"" . $fwng_root . "images/icons/magnify.png\" />" . gettext("Filters"), $desc);

//~  Show only active dev on startup is fastly than show everybody
if (isset($_GET['who']))
    if ($_GET['who'] == "")
        $who = "active";
    elseif ($_GET['who'] == "nofilter")
        $who = "";
    else
        $who = $_GET['who'];
else
    $who = "active";

$xmlfile = $docs_path."/xml/authors.xml";
$xml = file_get_contents($xmlfile);
$parser = new XMLParser($xml);
$parser->Parse();
$authors = "";

for ( $i=0; $i<count($parser->document->author); $i++)
{
    $people[] = $parser->document->author[$i];
}
usort($people, "sort_people");

print "<h2><img src=\"" . $fwng_root . "images/icons/authors.png\" />" . gettext("Authors") . "</h2>";

for($i=0;$i<count($people);$i++)
{
    if($people[$i]->status[0]->tagData === $who or !strlen($who))
    {
        $libravatar = new Services_Libravatar();

        $avatar_url = $libravatar->getUrl($people[$i]->email[0]->tagData);

        $emailhash = md5($people[$i]->email[0]->tagData);

        $email = str_replace("@", " " . gettext("at") . " ", $people[$i]->email[0]->tagData);
        $email = str_replace(".", " " . gettext("dot") . " ", $email);

        $author = "<img class=\"avatar\" src=\"".htmlspecialchars($avatar_url)."\"/><div class=\"info\">\n";
        $author .= "<b>" . $people[$i]->name[0]->tagData."</b> (".$people[$i]->nick[0]->tagData.") &lt;".$email."&gt;<br />\n";

        if (isset($people[$i]->website) and count($people[$i]->website))
            $author .= "» <a href=\"" . $people[$i]->website[0]->tagData . "\" />" . $people[$i]->website[0]->tagData . "</a><br />\n";

        $author .= "<br /><b>" . gettext("Roles") . "</b>:<ul>\n";
        for ( $j=0; $j<count($people[$i]->role); $j++ )
        {
            $author.= "<li>".$people[$i]->role[$j]->tagData."</li>\n";
        }
        $author .= "</ul>\n";

        if (isset($people[$i]->yearofbirth) and count($people[$i]->yearofbirth))
            $author .= "<b>" . gettext("Year of birth") . "</b>: " . $people[$i]->yearofbirth[0]->tagData . "<br />\n";

        if (isset($people[$i]->dayjob) and count($people[$i]->dayjob))
            $author .= "<b>" . gettext("Day job") . "</b>: " . $people[$i]->dayjob[0]->tagData . "\n";

        $author .= "</div>";

        fwauthorbox($author);
    }
}

include("footer.php");
?>
