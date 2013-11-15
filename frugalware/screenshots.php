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
include("lib/functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

$shots['users'][0]['name']="01_users_lenezir.png";
$shots['users'][0]['title']=gettext("Openbox by Lenezir");
$shots['users'][1]['name']="02_users_pingax.png";
$shots['users'][1]['title']=gettext("GNOME by Pingax");
$shots['users'][2]['name']="03_users_devil505.png";
$shots['users'][2]['title']=gettext("XFCE by Devil505");
$shots['users'][3]['name']="04_users_slown.png";
$shots['users'][3]['title']=gettext("GNOME by Slown");
$shots['users'][4]['name']="05_users_botchchikii.png";
$shots['users'][4]['title']=gettext("Openbox by Botchchikii");
$shots['users'][5]['name']="06_users_centuri0.png";
$shots['users'][5]['title']=gettext("KDE by Centuri0");

// include the config and let's start page
include("lib/config.inc.php");
include("header.php");


$screenTitle = "<img src=\"" . $fwng_root . "images/icons/screenshots.png\" />" . gettext("Screenshots from users");
$screenContent = "";
if ($screenshot_dir = opendir("" . $fwng_root."images/users_screenshots/"))
{
    $screenContent .= "<ul>";
    while (false !== ($file = readdir($screenshot_dir)))
    {
        if ($file != '.' && $file != '..' && $file != 'thumbnails' && $file != 'README') {
            $screenContent .= "<li>
                <h1>".NiceName($file)."</h1>
                <a id=\"imagebox\"  href=\"" . $fwng_root."images/users_screenshots/".$file."\">
                    <img src=\"" . $fwng_root . 'images/users_screenshots/thumbnails/'.$file."\" alt=\"".NiceName($file)."\" title=\"".NiceName($file)."\" />
                </a>
            </li>\n";
        }
    }
    $screenContent .= "</ul>";

    fwscreenbox($screenTitle, $screenContent);
}

$screenTitle = "<img src=\"" . $fwng_root . "images/icons/screenshots.png\" />" . gettext("Old screenshots");
$screenContent = "<ul>";

//$fwng_root = "https://frugalware.org/";
for ($i=0; $i<count($shots['users']); $i++)
{
    $screenContent .= "<li>
        <h1>".$shots['users'][$i]['title']."</h1>
        <a id=\"imagebox\"  href=\"" . $fwng_root."images/screenshots/users/".$shots['users'][$i]['name']."\">
            <img src=\"" . $fwng_root."images/screenshots/users/thumbnails/".$shots['users'][$i]['name']."\" alt=\"screenshot\" />
        </a>
    </li>\n";
}
$screenContent .= "</ul>";
fwscreenbox($screenTitle, $screenContent);

include("footer.php");
?>
