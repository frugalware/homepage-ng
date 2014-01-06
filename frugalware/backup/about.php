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
 * Frugalware Linux Homepage - About (summary) page
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

// FIXME: use docs/about.txt as a source instead of this one

$fwshortabout = gettext("Frugalware is a general purpose linux distribution, designed for intermediate users (who are not afraid of text mode).");
$fwlongabout = gettext("Please read the dedicated <a href=\"http://wiki.frugalware.org/index.php/FAQ\">FAQ page on the wiki</a>.");

// include the config and let's start page
include("config.inc.php");
include("header.php");

fwmiddlebox(gettext("Short"), $fwshortabout);
fwmiddlebox(gettext("Long"), $fwlongabout);

include("footer.php");
?>
