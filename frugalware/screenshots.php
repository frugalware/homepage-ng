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
$shots[inst][0][title]=gettext("Splash screen");
$shots[inst][1][name]="02_lang.png";
$shots[inst][1][title]=gettext("Language selection");
$shots[inst][2][name]="03_welcome.png";
$shots[inst][2][title]=gettext("Welcome Screen");
$shots[inst][3][name]="04_key.png";
$shots[inst][3][title]=gettext("Keyboard map");
$shots[inst][4][name]="05_raid.png";
$shots[inst][4][title]=gettext("RAID Selection");
$shots[inst][5][name]="06_part.png";
$shots[inst][5][title]=gettext("Selecting Hard Disk");
$shots[inst][6][name]="07_part.png";
$shots[inst][6][title]=gettext("Partitioning");
$shots[inst][7][name]="08_part.png";
$shots[inst][7][title]=gettext("Partitioning using cfdisk");
$shots[inst][8][name]="09_part.png";
$shots[inst][8][title]=gettext("Setting up swap space");
$shots[inst][9][name]="10_part.png";
$shots[inst][9][title]=gettext("Setting up swap space");
$shots[inst][10][name]="11_part.png";
$shots[inst][10][title]=gettext("Root partition selection");
$shots[inst][11][name]="12_part.png";
$shots[inst][11][title]=gettext("Formatting root partition");
$shots[inst][12][name]="13_part.png";
$shots[inst][12][title]=gettext("Creating filesystem");
$shots[inst][13][name]="14_part.png";
$shots[inst][13][title]=gettext("Other partitions");
$shots[inst][14][name]="15_pack.png";
$shots[inst][14][title]=gettext("Package selection");
$shots[inst][15][name]="16_pack.png";
$shots[inst][15][title]=gettext("Selecting package categories");
$shots[inst][16][name]="17_pack.png";
$shots[inst][16][title]=gettext("Selecting package categories");
$shots[inst][17][name]="18_pack.png";
$shots[inst][17][title]=gettext("Beginning installation");
$shots[inst][18][name]="19_pack.png";
$shots[inst][18][title]=gettext("Installing packages");
$shots[inst][19][name]="20_grub.png";
$shots[inst][19][title]=gettext("Setup MBR");
$shots[inst][20][name]="21_grub.png";
$shots[inst][20][title]=gettext("Installing MBR");
$shots[inst][21][name]="22_modules.png";
$shots[inst][21][title]=gettext("Installing modules");
$shots[inst][22][name]="23_root.png";
$shots[inst][22][title]=gettext("Setting a root password");
$shots[inst][23][name]="24_root.png";
$shots[inst][23][title]=gettext("Setting a root password");
$shots[inst][24][name]="25_user.png";
$shots[inst][24][title]=gettext("Creating user");
$shots[inst][25][name]="26_user.png";
$shots[inst][25][title]=gettext("Choosing a user name");
$shots[inst][26][name]="27_user.png";
$shots[inst][26][title]=gettext("Choosing a user password");
$shots[inst][27][name]="28_hostname.png";
$shots[inst][27][title]=gettext("Setup system hostname");
$shots[inst][28][name]="29_network.png";
$shots[inst][28][title]=gettext("Network configuration");
$shots[inst][29][name]="30_network.png";
$shots[inst][29][title]=gettext("Network configuration - DHCP");
$shots[inst][30][name]="31_config.png";
$shots[inst][30][title]=gettext("Applying settings");
$shots[inst][31][name]="32_localtime.png";
$shots[inst][31][title]=gettext("Setting up system time");
$shots[inst][32][name]="33_timezone.png";
$shots[inst][32][title]=gettext("Selecting Timezone");
$shots[inst][33][name]="34_mouse.png";
$shots[inst][33][title]=gettext("Mouse configuration");
$shots[inst][34][name]="35_success.png";
$shots[inst][34][title]=gettext("Installation success");

$shots[startup][0][name]="01_grub.png";
$shots[startup][0][title]=gettext("Bootloader (GRUB)");
$shots[startup][1][name]="02_boot.png";
$shots[startup][1][title]=gettext("Startup (Splash)");
$shots[startup][2][name]="03_boot.png";
$shots[startup][2][title]=gettext("Startup (Console)");
$shots[startup][3][name]="04_boot.png";
$shots[startup][3][title]=gettext("Startup (Console)");
$shots[startup][4][name]="05_console.png";
$shots[startup][4][title]=gettext("Console Login");
$shots[startup][5][name]="06_console.png";
$shots[startup][5][title]=gettext("Console");

$shots[kde][0][name]="07_kdm.png";
$shots[kde][0][title]=gettext("KDM Login Screen");
$shots[kde][1][name]="08_kde_login.png";
$shots[kde][1][title]=gettext("Ksplash");
$shots[kde][2][name]="09_kde.png";
$shots[kde][2][title]=gettext("Default KDE Desktop");
$shots[kde][3][name]="10_kde_menu.png";
$shots[kde][3][title]=gettext("KDE Menu");
$shots[kde][4][name]="11_kde_konqueror.png";
$shots[kde][4][title]=gettext("KDE Desktop with Konqueror");
$shots[kde][5][name]="12_kde_cube.png";
$shots[kde][5][title]=gettext("KDE with Cube");

$shots[gnome][0][name]="01_gdm.png";
$shots[gnome][0][title]=gettext("GDM Login Screen");
$shots[gnome][1][name]="02_gnome_desktop.png";
$shots[gnome][1][title]=gettext("Default Gnome Desktop");
$shots[gnome][2][name]="03_gnome_desktop.png";
$shots[gnome][2][title]=gettext("Gnome Menu");
$shots[gnome][3][name]="04_gnome_desktop.png";
$shots[gnome][3][title]=gettext("Web Browser");
$shots[gnome][4][name]="05_gnome_desktop.png";
$shots[gnome][4][title]=gettext("Gnome Apps");

$shots[xfce][0][name]="01_slim.png";
$shots[xfce][0][title]=gettext("Login Screen (SliM)");
$shots[xfce][1][name]="02_xfce_desktop.png";
$shots[xfce][1][title]=gettext("Default XFCE Desktop");
$shots[xfce][2][name]="03_xfce_desktop.png";
$shots[xfce][2][title]=gettext("XFCE in Action");
$shots[xfce][3][name]="04_xfce_desktop.png";
$shots[xfce][3][title]=gettext("XFCE Menu");
$shots[xfce][4][name]="05_xfce_desktop.png";
$shots[xfce][4][title]=gettext("XFCE Terminal");

$shots[gfpm][0][name]="01_gfpm.png";
$shots[gfpm][0][title]=gettext("Gfpm");
$shots[gfpm][1][name]="02_gfpm.png";
$shots[gfpm][1][title]=gettext("Gfpm Synchronizing");
$shots[gfpm][2][name]="03_gfpm.png";
$shots[gfpm][2][title]=gettext("Repository Manager");
$shots[gfpm][3][name]="04_gfpm.png";
$shots[gfpm][3][title]=gettext("Preferences Window");
$shots[gfpm][4][name]="05_gfpm.png";
$shots[gfpm][4][title]=gettext("Optimizing Package Database");
$shots[gfpm][5][name]="06_gfpm.png";
$shots[gfpm][5][title]=gettext("Log Viewer");

$shots[fun][0][name]="01_fun.png";
$shots[fun][0][title]=gettext("Update Notification");
$shots[fun][1][name]="02_fun.png";
$shots[fun][1][title]=gettext("FUN Main Window");
$shots[fun][2][name]="03_fun.png";
$shots[fun][2][title]=gettext("Preferences Window");

$shots[gnetconfig][0][name]="01_gnetconfig.png";
$shots[gnetconfig][0][title]=gettext("GNetconfig");
$shots[gnetconfig][1][name]="02_gnetconfig.png";
$shots[gnetconfig][1][title]=gettext("GNetconfig - Interface Management");
$shots[gnetconfig][2][name]="03_gnetconfig.png";
$shots[gnetconfig][2][title]=gettext("GNetconfig - DNS Settings");

$shots[gservice][0][name]="01_gservice.png";
$shots[gservice][0][title]=gettext("gService - Main Window");
$shots[gservice][1][name]="02_gservice.png";
$shots[gservice][1][title]=gettext("gService - Editing Runlevel Information");
$shots[gservice][2][name]="03_gservice.png";
$shots[gservice][2][title]=gettext("gService - Minimal Interface");

$shots[users][0][name]="01_users_lenezir.png";
$shots[users][0][title]=gettext("Openbox - by Lenezir");
$shots[users][1][name]="02_users_pingax.png";
$shots[users][1][title]=gettext("GNOME - by Pingax");
$shots[users][2][name]="03_users_devil505.png";
$shots[users][2][title]=gettext("XFCE - by Devil505");
$shots[users][3][name]="04_users_slown.png";
$shots[users][3][title]=gettext("GNOME - by Slown");
$shots[users][4][name]="05_users_botchchikii.png";
$shots[users][4][title]=gettext("Openbox - by Botchchikii");

// include the config and let's start page
include("config.inc.php");
include("header.php");

$maincont = "<div class=\"screenshots\">\n";
$maincont .= "<form action=\"screenshots\" method=\"get\">\n<fieldset class=\"fieldset\" id=\"installer\">\n<legend>".gettext("Screenshots from users")."</legend>\n";

for ($i=0; $i<count($shots[users]); $i++)
{
	$maincont .= "<div><a id=\"imagebox\"  href=\"".$fwng_root."images/screenshots/users/".$shots[users][$i][name]."\">".
	"<img src=\"".$fwng_root."images/screenshots/users/thumbnails/".$shots[users][$i][name]."\" alt=\"screenshot\" /></a>".
	"<br />".$shots[users][$i][title]."</div>\n";
}

$maincont .= "</fieldset>\n<fieldset class=\"fieldset\" id=\"default\">\n";
$maincont .= "<legend>".gettext("Installer")."</legend>\n";
for ($i=0; $i<count($shots[inst]); $i++)
{
	$maincont .= "<div><a id=\"imagebox\"  href=\"".$fwng_root."images/screenshots/installer/".$shots[inst][$i][name]."\">".
	"<img src=\"".$fwng_root."images/screenshots/installer/thumbnails/".$shots[inst][$i][name]."\" alt=\"screenshot\" /></a>".
	"<br />".$shots[inst][$i][title]."</div>\n";
}
$maincont .= "</fieldset>\n<fieldset class=\"fieldset\" id=\"default\">\n";
$maincont .= "<legend>".gettext("Startup")."</legend>\n";
for ($i=0; $i<count($shots[startup]); $i++)
{
	$maincont .= "<div><a id=\"imagebox\"  href=\"".$fwng_root."images/screenshots/default/".$shots[startup][$i][name]."\">".
	"<img src=\"".$fwng_root."images/screenshots/default/thumbnails/".$shots[startup][$i][name]."\" alt=\"screenshot\" /></a>".
	"<br />".$shots[startup][$i][title]."</div>\n";
}
$maincont .= "</fieldset>\n<fieldset class=\"fieldset\" id=\"default\">\n";
$maincont .= "<legend>".gettext("KDE Desktop")."</legend>\n";
for ($i=0; $i<count($shots[kde]); $i++)
{
	$maincont .= "<div><a id=\"imagebox\"  href=\"".$fwng_root."images/screenshots/default-old/".$shots[kde][$i][name]."\">".
	"<img src=\"".$fwng_root."images/screenshots/default-old/thumbnails/".$shots[kde][$i][name]."\" alt=\"screenshot\" /></a>".
	"<br />".$shots[kde][$i][title]."</div>\n";
}
$maincont .= "</fieldset>\n<fieldset class=\"fieldset\" id=\"default\">\n";
$maincont .= "<legend>".gettext("GNOME Desktop")."</legend>\n";
for ($i=0; $i<count($shots[gnome]); $i++)
{
	$maincont .= "<div><a id=\"imagebox\"  href=\"".$fwng_root."images/screenshots/default/".$shots[gnome][$i][name]."\">".
	"<img src=\"".$fwng_root."images/screenshots/default/thumbnails/".$shots[gnome][$i][name]."\" alt=\"screenshot\" /></a>".
	"<br />".$shots[gnome][$i][title]."</div>\n";
}
$maincont .= "</fieldset>\n<fieldset class=\"fieldset\" id=\"default\">\n";
$maincont .= "<legend>".gettext("XFCE Desktop")."</legend>\n";
for ($i=0; $i<count($shots[xfce]); $i++)
{
	$maincont .= "<div><a id=\"imagebox\"  href=\"".$fwng_root."images/screenshots/default/".$shots[xfce][$i][name]."\">".
	"<img src=\"".$fwng_root."images/screenshots/default/thumbnails/".$shots[xfce][$i][name]."\" alt=\"screenshot\" /></a>".
	"<br />".$shots[xfce][$i][title]."</div>\n";
}
$maincont .= "</fieldset>\n<fieldset class=\"fieldset\" id=\"default\">\n";
$maincont .= "<legend>".gettext("GFpm (Package Manager)")."</legend>\n";
for ($i=0; $i<count($shots[gfpm]); $i++)
{
	$maincont .= "<div><a id=\"imagebox\"  href=\"".$fwng_root."images/screenshots/default/".$shots[gfpm][$i][name]."\">".
	"<img src=\"".$fwng_root."images/screenshots/default/thumbnails/".$shots[gfpm][$i][name]."\" alt=\"screenshot\" /></a>".
	"<br />".$shots[gfpm][$i][title]."</div>\n";
}
$maincont .= "</fieldset>\n<fieldset class=\"fieldset\" id=\"default\">\n";
$maincont .= "<legend>".gettext("FUN (Update Notifier)")."</legend>\n";
for ($i=0; $i<count($shots[fun]); $i++)
{
	$maincont .= "<div><a id=\"imagebox\"  href=\"".$fwng_root."images/screenshots/default/".$shots[fun][$i][name]."\">".
	"<img src=\"".$fwng_root."images/screenshots/default/thumbnails/".$shots[fun][$i][name]."\" alt=\"screenshot\" /></a>".
	"<br />".$shots[fun][$i][title]."</div>\n";
}
$maincont .= "</fieldset>\n<fieldset class=\"fieldset\" id=\"default\">\n";
$maincont .= "<legend>".gettext("GNetconfig (Network Configuration Tool)")."</legend>\n";
for ($i=0; $i<count($shots[gnetconfig]); $i++)
{
	$maincont .= "<div><a id=\"imagebox\"  href=\"".$fwng_root."images/screenshots/default/".$shots[gnetconfig][$i][name]."\">".
	"<img src=\"".$fwng_root."images/screenshots/default/thumbnails/".$shots[gnetconfig][$i][name]."\" alt=\"screenshot\" /></a>".
	"<br />".$shots[gnetconfig][$i][title]."</div>\n";
}
$maincont .= "</fieldset>\n<fieldset class=\"fieldset\" id=\"default\">\n";
$maincont .= "<legend>".gettext("gService (GUI Runlevel Editor)")."</legend>\n";
for ($i=0; $i<count($shots[gservice]); $i++)
{
	$maincont .= "<div><a id=\"imagebox\"  href=\"".$fwng_root."images/screenshots/default/".$shots[gservice][$i][name]."\">".
	"<img src=\"".$fwng_root."images/screenshots/default/thumbnails/".$shots[gservice][$i][name]."\" alt=\"screenshot\" /></a>".
	"<br />".$shots[gservice][$i][title]."</div>\n";
}

$maincont .= "</fieldset></form>\n</div>\n";

print $maincont;

include("footer.php");
?>
