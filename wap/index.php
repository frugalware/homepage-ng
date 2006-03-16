<?
include("functions.php");

$feed = substr($_SERVER["PATH_INFO"], 1);
if (strpos($_SERVER["PATH_INFO"], "/") !== false)
	$feed = preg_replace('|^([^/]*)/.*|', '$1', $feed);

$param = preg_replace('|^[^/]*/([^/]*)|', '$1',
	substr($_SERVER["PATH_INFO"], 1));
if($param==$feed)
	$param=null;

if ($feed == "")
	include("templates/main.php");
else
	display_feed($feed, $param);
?>
