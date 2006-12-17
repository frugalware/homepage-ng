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

// include some useful functions and the config
include("functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

include("config.inc.php");

// let's start page
include("header.php");

$id = ( $_GET['id'] != "" ) ? $_GET['id'] : 1;
$content = file_get_contents('weeklynews/issue' . $id . '.html');

fwmiddlebox(gettext("Frugalware Newsletter Issue $id"), $content);

include("footer.php");
?>
