<?
include("config.php");
include("functions.php");

$day = substr($_SERVER["PATH_INFO"], 1);
if (strpos($_SERVER["PATH_INFO"], "/") !== false)
	$day = preg_replace('|^([^/]*)/.*|', '$1', $day);

$param = preg_replace('|^[^/]*/([^/]*)|', '$1',
	substr($_SERVER["PATH_INFO"], 1));
if($param==$day)
	$param=null;

if ($day == "")
	list_days();
else
	display_day($day, $param);
?>
