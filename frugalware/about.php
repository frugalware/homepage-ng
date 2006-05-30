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
$aboutfile = "includes/about.".$lang.".php";

// set the locale settings for gettext
putenv("LANG=".$llang);
setlocale(LC_ALL,$llang);
$domain = 'messages';
bindtextdomain($domain, "locale");
textdomain($domain);

// include the config and let's start page
include("config.inc.php");
include("header.php");

?>

<!-- main content start -->
<div id="columns">
	<div id="leftcolumn">
<?php
fwsidebox(gettext("Menu"), $menucontent);
fwsidebox(gettext("Languages"), $langcontent);
?>
	</div>

	<div id="rightcolumn">
<?php
fwsidebox(gettext("Information"), $validcontent);
?>
	</div>

	<div id="centercolumn">
<?php

include($aboutfile);
fwmiddlebox(gettext("Short"), $fwshortabout);
$cont = "";
for ( $i=0; $i<count($fwabout); $i++ )
{
	$cont .= "<p><b><img src=\"images/arrow.gif\" alt=\"\" border=\"0\" /> ".gettext("Question").":&nbsp;&nbsp;".$fwabout[$i][0]."</b></p>\n";
	$cont .= "<p align=\"justify\">".gettext("Answer").":&nbsp;&nbsp;".$fwabout[$i][1]."</p>\n";
}
fwmiddlebox(gettext("Long"), $cont);
?>
	</div>
</div>
<!-- main content end -->

<?php
include("footer.php");
?>
