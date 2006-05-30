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
 * @author Krisztian VASAS <iron@frugalware.org>
 * @copyright Copyright (c) 2006. Krisztian VASAS
 */

// include some useful functions
include("functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
putenv("LANG=".$llang);
setlocale(LC_ALL,$llang);
$domain = 'messages';
bindtextdomain($domain, "locale");
textdomain($domain);

// include the config and let's start page
include("config.inc.php");
include("includes/shots.".$lang.".php");
include("header.php");

$maincont = "<div class=\"screenshots\">\n";
$maincont .= "<form>\n<fieldset class=\"fieldset\" id=\"installer\">\n<legend>Installer</legend>\n";
for ($i=0; $i<count($shots[inst]); $i++)
{
	$maincont .= "<div><a href=\"http://www2.frugalware.org/images/screenshots/installer/".$shots[inst][$i][name]."\">".
	"<img src=\"http://www2.frugalware.org/images/screenshots/installer/thumbnails/".$shots[inst][$i][name]."\"></a>".
	"<br />".$shots[inst][$i][title]."</div>\n";
}
$maincont .= "</fieldset>\n<fieldset class=\"fieldset\" id=\"default\">\n";
$maincont .= "<legend>Default Desktop</legend>\n";
for ($i=0; $i<count($shots[defdesk]); $i++)
{
	$maincont .= "<div><a href=\"http://www2.frugalware.org/images/screenshots/default/".$shots[defdesk][$i][name]."\">".
	"<img src=\"http://www2.frugalware.org/images/screenshots/default/thumbnails/".$shots[defdesk][$i][name]."\"></a>".
	"<br />".$shots[defdesk][$i][title]."</div>\n";
}
$maincont .= "</form>\n</div>\n";

#fwmiddlebox("", $maincont);
print $maincont;

include("footer.php");
?>
