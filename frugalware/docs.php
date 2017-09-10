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
include("lib/functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

// let's start page
include("lib/config.inc.php");

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

$cont = "<ul>
    <li><a href=\"/docs/index\">".gettext("Full manual")."</a></li>
    <hr />
    <li><a href=\"/docs/install.html\">".gettext("How to install Frugalware")."</a></li>
    <li><a href=\"https://bugs.frugalware.org/frugalware/frugalware-current/wikis/Post-Installation\">".gettext("Post-installation tutoriel (Wiki)")."</a></li>
    <li><a href=\"/docs/upgrade.html\">".gettext("How to upgrade Frugalware")."</a></li>
    <li><a href=\"/docs/pacman-g2.html\">".gettext("How to use pacman-g2")."</a></li>
    <hr />
    <li><a href=\"/docs/mobile.html\">".gettext("Laptop generality")."</a></li>
</ul>";

$cont_dev = "<ul>
    <li><a href=\"https://bugs.frugalware.org/frugalware/frugalware-current/wikis/Devel_intro\">".gettext("Developper introduction (Wiki)")."</a></li>
    <hr />
    <li><a href=\"/docs/getting-involved.html\">".gettext("How to contribute")."</a></li>
    <li><a href=\"/docs/repos.html\">".gettext("Handling git repositories")."</a></li>
    <hr />
    <li><a href=\"https://bugs.frugalware.org/frugalware/frugalware-current/wikis/Category:D%C3%A9velopper\">".gettext("Developper informations (Wiki - French)")."</a></li>
</ul>";

$cont = "<ul>
    <li><a href=\"/docs/stable/index\">".gettext("Full manual")."</a>&nbsp;-&nbsp;(<a href=\"/docs/index\">".gettext("development version")."</a>)</li>
    <hr />
    <li><a href=\"/docs/stable/install.html\">".gettext("How to install Frugalware")."</a>&nbsp;-&nbsp;(<a href=\"/docs/install.html\">".gettext("development version")."</a>)</li>
    <li><a href=\"/docs/stable/upgrade.html\">".gettext("How to upgrade Frugalware")."</a>&nbsp;-&nbsp;(<a href=\"/docs/upgrade.html\">".gettext("development version")."</a>)</li>
    <li><a href=\"/docs/stable/pacman-g2.html\">".gettext("How to use pacman-g2")."</a>&nbsp;-&nbsp;(<a href=\"/docs/pacman-g2.html\">".gettext("development version")."</a>)</li>
    <hr />
    <li><a href=\"/docs/stable/mobile.html\">".gettext("Laptop generality")."</a>&nbsp;-&nbsp;(<a href=\"/docs/mobile.html\">".gettext("development version")."</a>)</li>
</ul>";

$cont_dev = "<ul>
    <li><a href=\"https://bugs.frugalware.org/frugalware/frugalware-current/wikis/Devel_intro\">".gettext("Developper introduction (Wiki)")."</a></li>
    <hr />
    <li><a href=\"/docs/stable/getting-involved.html\">".gettext("How to contribute")."</a>&nbsp;-&nbsp;(<a href=\"/docs/getting-involved.html\">".gettext("development version")."</a>)</li>
    <li><a href=\"/docs/stable/repos.html\">".gettext("Handling git repositories")."</a>&nbsp;-&nbsp;(<a href=\"/docs/repos.html\">".gettext("development version")."</a>)</li>
    <hr />
    <li><a href=\"https://bugs.frugalware.org/frugalware/frugalware-current/wikis/Category:D%C3%A9velopper\">".gettext("Developper informations (Wiki - French)")."</a></li>
</ul>";

print "<h2><img src=\"" . $fwng_root . "images/icons/docs.png\" />" . gettext("Online documentation") . "</h2>";
fwmiddlebox(gettext("User documentation"), $cont);
fwmiddlebox(gettext("Developer documentation"), $cont_dev);

include("footer.php");
?>
