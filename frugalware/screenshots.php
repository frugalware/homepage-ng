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
$domain = "homepage";
set_locale($llang, $domain);

$shots[inst][0][name]="01_splash.png";
$shots[inst][0][title]=gettext("01_splash.png");
$shots[inst][1][name]="02_lang.png";
$shots[inst][1][title]=gettext("02_lang.png");
$shots[inst][2][name]="03_welcome.png";
$shots[inst][2][title]=gettext("03_welcome.png");
$shots[inst][3][name]="04_key.png";
$shots[inst][3][title]=gettext("04_key.png");
$shots[inst][4][name]="05_raid.png";
$shots[inst][4][title]=gettext("05_raid.png");
$shots[inst][5][name]="06_part.png";
$shots[inst][5][title]=gettext("06_part.png");
$shots[inst][6][name]="07_part.png";
$shots[inst][6][title]=gettext("07_part.png");
$shots[inst][7][name]="08_part.png";
$shots[inst][7][title]=gettext("08_part.png");
$shots[inst][8][name]="09_part.png";
$shots[inst][8][title]=gettext("09_part.png");
$shots[inst][9][name]="10_part.png";
$shots[inst][9][title]=gettext("10_part.png");
$shots[inst][10][name]="11_part.png";
$shots[inst][10][title]=gettext("11_part.png");
$shots[inst][11][name]="12_part.png";
$shots[inst][11][title]=gettext("12_part.png");
$shots[inst][12][name]="13_part.png";
$shots[inst][12][title]=gettext("13_part.png");
$shots[inst][13][name]="14_part.png";
$shots[inst][13][title]=gettext("14_part.png");
$shots[inst][14][name]="15_pack.png";
$shots[inst][14][title]=gettext("15_pack.png");
$shots[inst][15][name]="16_pack.png";
$shots[inst][15][title]=gettext("16_pack.png");
$shots[inst][16][name]="17_pack.png";
$shots[inst][16][title]=gettext("17_pack.png");
$shots[inst][17][name]="18_pack.png";
$shots[inst][17][title]=gettext("18_pack.png");
$shots[inst][18][name]="19_pack.png";
$shots[inst][18][title]=gettext("19_pack.png");
$shots[inst][19][name]="20_grub.png";
$shots[inst][19][title]=gettext("20_grub.png");
$shots[inst][20][name]="21_grub.png";
$shots[inst][20][title]=gettext("21_grub.png");
$shots[inst][21][name]="22_modules.png";
$shots[inst][21][title]=gettext("22_modules.png");
$shots[inst][22][name]="23_root.png";
$shots[inst][22][title]=gettext("23_root.png");
$shots[inst][23][name]="24_root.png";
$shots[inst][23][title]=gettext("24_root.png");
$shots[inst][24][name]="25_user.png";
$shots[inst][24][title]=gettext("25_user.png");
$shots[inst][25][name]="26_user.png";
$shots[inst][25][title]=gettext("26_user.png");
$shots[inst][26][name]="27_user.png";
$shots[inst][26][title]=gettext("27_user.png");
$shots[inst][27][name]="28_hostname.png";
$shots[inst][27][title]=gettext("28_hostname.png");
$shots[inst][28][name]="29_network.png";
$shots[inst][28][title]=gettext("29_network.png");
$shots[inst][29][name]="30_network.png";
$shots[inst][29][title]=gettext("30_network.png");
$shots[inst][30][name]="31_config.png";
$shots[inst][30][title]=gettext("31_config.png");
$shots[inst][31][name]="32_localtime.png";
$shots[inst][31][title]=gettext("32_localtime.png");
$shots[inst][32][name]="33_timezone.png";
$shots[inst][32][title]=gettext("33_timezone.png");
$shots[inst][33][name]="34_mouse.png";
$shots[inst][33][title]=gettext("34_mouse.png");
$shots[inst][34][name]="35_success.png";
$shots[inst][34][title]=gettext("35_success.png");
$shots[defdesk][0][name]="01_grub.png";
$shots[defdesk][0][title]=gettext("01_grub.png");
$shots[defdesk][1][name]="02_boot.png";
$shots[defdesk][1][title]=gettext("02_boot.png");
$shots[defdesk][2][name]="03_boot.png";
$shots[defdesk][2][title]=gettext("03_boot.png");
$shots[defdesk][3][name]="04_boot.png";
$shots[defdesk][3][title]=gettext("04_boot.png");
$shots[defdesk][4][name]="05_console.png";
$shots[defdesk][4][title]=gettext("05_console.png");
$shots[defdesk][5][name]="06_console.png";
$shots[defdesk][5][title]=gettext("06_console.png");
$shots[defdesk][6][name]="08_kde_login.png";
$shots[defdesk][6][title]=gettext("08_kde_login.png");
$shots[defdesk][7][name]="09_kde.png";
$shots[defdesk][7][title]=gettext("09_kde.png");
$shots[defdesk][8][name]="10_kde_menu.png";
$shots[defdesk][8][title]=gettext("10_kde_menu.png");
$shots[defdesk][9][name]="11_gdm.png";
$shots[defdesk][9][title]=gettext("11_gdm.png");
$shots[defdesk][10][name]="13_gnome.png";
$shots[defdesk][10][title]=gettext("13_gnome.png");
$shots[defdesk][11][name]="14_gnome_menu.png";
$shots[defdesk][11][title]=gettext("14_gnome_menu.png");
$shots[defdesk][12][name]="15_gnome_menu.png";
$shots[defdesk][12][title]=gettext("15_gnome_menu.png");
$shots[defdesk][13][name]="16_gnome_menu.png";
$shots[defdesk][13][title]=gettext("16_gnome_menu.png");
$shots[defdesk][14][name]="17_package_manager.png";
$shots[defdesk][14][title]=gettext("17_package_manager.png");
$shots[defdesk][15][name]="18_runlevel_editor.png";
$shots[defdesk][15][title]=gettext("18_runlevel_editor.png");

// include the config and let's start page
include("config.inc.php");
include("header.php");

$maincont = "<div class=\"screenshots\">\n";
$maincont .= "<form action=\"screenshots\" method=\"get\">\n<fieldset class=\"fieldset\" id=\"installer\">\n<legend>".gettext("Installer")."</legend>\n";
for ($i=0; $i<count($shots[inst]); $i++)
{
	$maincont .= "<div><a href=\"".$fwng_root."images/screenshots/installer/".$shots[inst][$i][name]."\">".
	"<img src=\"".$fwng_root."images/screenshots/installer/thumbnails/".$shots[inst][$i][name]."\"></a>".
	"<br />".$shots[inst][$i][title]."</div>\n";
}
$maincont .= "</fieldset>\n<fieldset class=\"fieldset\" id=\"default\">\n";
$maincont .= "<legend>".gettext("Default Desktop")."</legend>\n";
for ($i=0; $i<count($shots[defdesk]); $i++)
{
	$maincont .= "<div><a href=\"".$fwng_root."images/screenshots/default/".$shots[defdesk][$i][name]."\">".
	"<img src=\"".$fwng_root."images/screenshots/default/thumbnails/".$shots[defdesk][$i][name]."\"></a>".
	"<br />".$shots[defdesk][$i][title]."</div>\n";
}
$maincont .= "</fieldset></form>\n</div>\n";

print $maincont;

include("footer.php");
?>
