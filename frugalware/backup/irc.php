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
include("functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

// include the config and let's start page
include("config.inc.php");
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

fwmiddlebox(gettext("General information"), gettext("Our irc channel is on the freenode network (server: irc.freenode.net), at #frugalware. This is the official Frugalware Linux irc help station. See the <a href=\"/docs/irc-rules#_irc_channels\">documentation</a> about non-English channels."));

$ircont = "
<!-- This is part of CGI:IRC 0.5
  == http://cgiirc.sourceforge.net/
  == Copyright (C) 2000-2005 David Leadbeater <cgiirc@dgl.cx>
  == Released under the GNU GPL
-->

<script language=\"JavaScript\" type=\"text/javascript\">
<!--
function setjs() {
	if (navigator.product == 'Gecko')
	{
		document.loginform[\"interface\"].value = 'mozilla';
	}
	else
		if (window.opera && document.childNodes)
		{
			document.loginform[\"interface\"].value = 'opera7';
	 	}
		else
			if (navigator.appName == 'Microsoft Internet Explorer' && navigator.userAgent.indexOf(\"Mac_PowerPC\") > 0)
			{
				document.loginform[\"interface\"].value = 'konqueror';
 			}
			else
				if (navigator.appName == 'Microsoft Internet Explorer' && document.getElementById && document.getElementById('ietest').innerHTML)
				{
					document.loginform[\"interface\"].value = 'ie';
				}
				else
					if (navigator.appName == 'Konqueror')
					{
						document.loginform[\"interface\"].value = 'konqueror';
 					}
					else
						if (window.opera)
						{
							document.loginform[\"interface\"].value = 'opera';
						}
}
function nickvalid() {
	var nick = document.loginform.Nickname.value;
	if (nick.match(/^[A-Za-z0-9\[\]\{\}^\\\|\_\-`]{1,32}$/))
		return true;
	alert('".gettext("Please enter a valid nickname")."');
	document.loginform.Nickname.value = nick.replace(/[^A-Za-z0-9\[\]\{\}^\\\|\_\-`]/g, '');
	return false;
}
function setcharset() {
	if(document.charset && document.loginform[\"Character set\"])
		document.loginform['Character set'].value = document.charset
}
setcharset();
-->
</script>
<form method=\"post\" action=\"http://frugalware.org/cgiirc/irc.cgi\" name=\"loginform\" onsubmit=\"setjs();return nickvalid()\">
<input type=\"hidden\" name=\"interface\" value=\"nonjs\" />
<div align=\"center\">
<table border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
  <tr>
    <td align=\"right\">".gettext("Nickname:")."</td>
    <td align=\"left\"><input type=\"text\" name=\"Nickname\" value=\"\" /></td>
  </tr>
  <tr>
    <td align=\"right\">".gettext("Server:")."</td>
    <td align=\"left\"><input type=\"text\" name=\"Server\" value=\"irc.freenode.net\" disabled=\"disabled\" /></td>
  </tr>
  <tr>
    <td align=\"right\">".gettext("Channel:")."</td>
    <td align=\"left\"><input type=\"text\" name=\"Channel\" value=\"#frugalware\" disabled=\"disabled\" /></td>
  </tr>
  <tr>
    <td align=\"left\"><small><a href=\"http://frugalware.org/cgiirc/irc.cgi?adv=1\">".gettext("Advanced...")."</a></small></td>
    <td align=\"right\"><input type=\"submit\" value=\"".gettext("Login")."\" /></td>
  </tr>
</table>
</div>
</form>\n";

fwmiddlebox(gettext("Login via web"), $ircont);

fwmiddlebox(gettext("Support channel logs"), sprintf(gettext("Our support channels are logged and the logs are available <a href=\"%s\">here</a>."), "http://ftp.frugalware.org/pub/other/irclogs"));

include("footer.php");
?>
