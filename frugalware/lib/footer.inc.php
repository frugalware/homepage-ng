<?php

include("xml.inc.php");
include("config.inc.php");
include("db.inc.php");

$usegettext = '';

$statf = file($upfile);
list($uptime, $junk) = explode(" ", $statf[0]);
$secuptime=floor($uptime);

// Seconds
$minuptime=60*floor($uptime/60);
$sec= $secuptime - $minuptime;

// Minutes
$houruptime=3600*floor($minuptime/3600);
$min= $minuptime - $houruptime;

// Hours
$dayuptime=86400*floor($houruptime/86400);
$hour= $houruptime - $dayuptime;

// Final uptime
if ($usegettext)
    $uptime = sprintf(gettext("Uptime: %d day(s) %d h %d m %d s"), $dayuptime/86400, $hour/3600, $min/60, $sec);
else
    $uptime = sprintf("Uptime: %d day(s) %d h %d m %d s", $dayuptime/86400, $hour/3600, $min/60, $sec);

?>
