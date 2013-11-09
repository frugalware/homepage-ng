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
 * Frugalware Linux Homepage - CGI:IRC start page
 *
 * @author Krisztian VASAS <iron@frugalware.org>
 * @author Miklos Vajna <vmiklos@frugalware.org>
 *
 * @copyright Copyright (c) 2006. Krisztian VASAS
 * @copyright Copyright (c) 2005-2006. Miklos Vajna
 */

// include some useful functions
include("lib/functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

// include the config and let's start page
include("lib/config.inc.php");
include("header.php");

function dcmp($a, $b)
{
    $a = preg_replace("/3-0-([0-9]*)-([0-9]*)-([0-9]*)\.html/", "$2", $a);
    $b = preg_replace("/3-0-([0-9]*)-([0-9]*)-([0-9]*)\.html/", "$2", $b);
    return ($a < $b) ? -1 : 1;
}

function mcmp($a, $b)
{
    $ayear = preg_replace("/(.*)-.*/", "$1", $a);
    $byear = preg_replace("/(.*)-.*/", "$1", $b);
    if($ayear==$byear)
    {
        $amonth = preg_replace("/.*-(.*)/", "$1", $a);
        $bmonth = preg_replace("/.*-(.*)/", "$1", $b);
        return ($amonth < $bmonth) ? 1 : -1;
    }
    else
        return ($ayear < $byear) ? 1 : -1;
}

print "<h2><img src=\"" . $fwng_root . "images/icons/irc.png\" />" . gettext("Join us on IRC") . "</h2>";

$content = gettext("Our irc channel is on the freenode network (server: irc.freenode.net), at #frugalware. This is the official Frugalware Linux irc help station.") . "<br />
<br/>
<b>Network server</b>:
<ul>
<li>irc.freenode.net</li>
</ul>
<b>Channel list</b>:
<ul>
<li><span style=\"color: #004D99\">#frugalware</span> (English channel)</li>
<li><span style=\"color: #004D99\">#frugalware.fr</span> (French channel)</li>
<li><span style=\"color: #004D99\">#frugalware.hu</span> (Hungarian channel)</li>
</ul>
See the <a href=\"/docs/irc-rules#_irc_channels\">documentation</a> for more informations.";

fwmiddlebox(gettext("General information"), "<p>" . $content . "</p>");

$content = gettext("To join a channel, you must use a client.") . "<br/><br/>
<b>Web client</b>:
<ul>
<li><a href=\"http://webchat.freenode.net\">http://webchat.freenode.net</a></li>
</ul>
<b>Desktop client</b>:
<ul>
<li>Hexchat (<a href=\"http://hexchat.github.io\">http://hexchat.github.io</a>)</li>
<li>Irssi (<a href=\"http://www.irssi.org\">http://www.irssi.org</a>)</li>
<li>Konversation (<a href=\"http://konversation.kde.org\">http://konversation.kde.org</a>)</li>
<li>Quassel (<a href=\"http://www.quassel-irc.org\">http://www.quassel-irc.org</a>)</li>
<li>Weechat (<a href=\"http://www.weechat.org\">http://www.weechat.org</a>)</li>
</ul>";

fwmiddlebox(gettext("Join a channel"), "<p>" . $content . "</p>");

fwemptybox("<img src=\"" . $fwng_root . "images/icons/log.png\" />" . gettext("Support channel logs"), sprintf(gettext("Our support channels are logged and the logs are available <a href=\"%s\">here</a>."), "http://ftp.frugalware.org/pub/other/irclogs"));

include("footer.php");
?>
