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
 * Frugalware Linux Homepage - I18n pages
 *
 * @copyright Copyright (c) 2007. Miklos Vajna
 */

// include some useful functions and the config
include("functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

include("header.php");
fwmiddlebox("Frugalware Local Community Team Directory",'<ul>
<img class="face" src="/images/icons/i18n.png" width="85" height="85" alt="" /><br />
	<li><a href="http://www.frugalware.hostend.eu/">' . gettext('Czech') . '</a></li>
	<li><a href="http://frugalware.dk/">' . gettext('Danish') . '</a></li>
	<li><a href="http://www.frugalware.fr/">' . gettext('French') . '</a></li>
	</ul>'
);
include("footer.php");
?>
