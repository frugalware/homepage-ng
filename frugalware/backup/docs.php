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
 *
 * @copyright Copyright (c) 2006. Krisztian VASAS
 * @copyright Copyright (c) 2005-2006. Miklos Vajna
 */

// include some useful functions and the config
include("functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

// let's start page
include("config.inc.php");

$langd = ( $lang == "en" ) ? "" : "/$lang/";
if(isset($_GET['doc']))
{
	$doc = $_GET['doc'];
	$stable = $_GET['stable'];
	if(!$stable)
		$my_path = $docs_path;
	else
		$my_path = $docs_path_stable;
	if(strpos($doc, ".html") === false and strpos($doc, ".pdf") === false and strpos($doc, ".text") === false)
		$doc .= ".html";
	$path = $my_path."/".$doc;
	if(file_exists($path))
	{
		if (file_exists($my_path."/".$langd.$doc))
			$path=$my_path."/".$langd.$doc;
		$fp = fopen($path, "r");
		fpassthru($fp);
		die();
	}
}

include("header.php");

$cont = gettext("The following categories are available:")."<br />
<ul>
<li><a href=\"/docs/index\">".gettext("Full manual")."</a></li>
<li><a href=\"/docs/index-user\">".gettext("User documentation")."</a></li>
<li><a href=\"/docs/index-devel\">".gettext("Developer documentation")."</a></li>
</ul>";

$cont_stable = gettext("The following categories are available:")."<br />
<ul>
<li><a href=\"/docs/stable/index\">".gettext("Full manual")."</a></li>
<li><a href=\"/docs/stable/index-user\">".gettext("User documentation")."</a></li>
<li><a href=\"/docs/stable/index-devel\">".gettext("Developer documentation")."</a></li>
</ul>";

fwmiddlebox(gettext("View online documentation (stable release)"), $cont_stable);
fwmiddlebox(gettext("View online documentation (development version)"), $cont);

include("footer.php");
?>
