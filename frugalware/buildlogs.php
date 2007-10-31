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
 * Frugalware Linux Homepage - Build logs
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
$logdir="/var/log/syncpkgd/clientlogs";
if(!isset($_GET['client']))
{
	$clients = array();
	if ($dir = @opendir($logdir))
	{
		while ($file = readdir($dir))
			if ($file != "." and $file != ".." and is_dir($logdir . "/" . $file))
				$clients[] = $file;
		sort($clients);
	}
	$cstr = "<ul>";
	foreach($clients as $i)
		$cstr .= "<li><a href=\"/buildlogs/$i\">$i</a></li>";
	$cstr .= "</ul><br />";
	$cstr .= "<p>NOTE: These are only the failed build logs. Use the <a href=\"/packages\">package search page</a> to see the logs of successful builds.</p>";
	fwmiddlebox("Syncpkg daemon failed build logs","$cstr");
}
else if(isset($_GET['client']) and !isset($_GET['log']))
{
	if(preg_match("/[a-zA-Z0-9]/", $_GET['client']))
		$client = $_GET['client'];
	else
		die("invalid client name");

	$logs = array();
	if ($dir = @opendir("$logdir/$client"))
	{
		while ($file = readdir($dir))
			if ($file != "." and $file != ".." and is_file("$logdir/$client/$file"))
			{
				$buf = stat("$logdir/$client/$file");
				$logs[] = array($file, date("r",$buf["mtime"]));
			}
		sort($logs);
	}
	$lstr = "";
	foreach($logs as $i)
		$lstr .= "<li><a href=\"/buildlogs/$client/".$i[0]."\">".$i[0]."</a> (".$i[1].")</li>";
	fwmiddlebox("Syncpkg daemon failed build logs","<ul>$lstr</ul>");
}
else if(isset($_GET['client']) and isset($_GET['log']))
{
	if(preg_match("/\//", $_GET['log']))
		die("invalid log name");
	$client = $_GET['client'];
	$log = $_GET['log'];
	$logfile = "$logdir/$client/$log";

	print("<fieldset class=\"pkg\"><legend>".sprintf(gettext("Build log for %s"), basename($logfile, ".log"))."</legend>");
	if(file_exists($logfile))
	{
		print("<pre class=\"buildlog\">");
		$fp = fopen($logfile, "r");
		while ($buffer = fread($fp, 4096))
			print($buffer);
		fclose($fp);
		print("</pre>\n</fieldset>\n");
	}
	else
		print(gettext("Sorry, currently no log available."));
}
include("footer.php");
?>
