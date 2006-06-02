<?php
include("functions.inc.php");
include("config.inc.php");
include("header.php");

$fwchlfile=$top_path."/ChangeLog.txt";
$fwchangelogentries=100;
$opennew=true;
$content="";
$j=0;

if (file_exists("$fwchlfile.$lang"))
	$changelogf=file("$fwchlfile.$lang");
else
	$changelogf=file($fwchlfile);

foreach($changelogf as $i)
{
	if ($j <= $fwchangelogentries)
	{
		if ($i != "\n")
		{
			$i = str_replace(array("<", ">", "@", "\n", "\r", " "), array("&lt;", "&gt;", "_at_", "", "", "&nbsp;"), $i);
			if ($opennew)
			{
				$j++;
				$opennew=false;
				$title=$i;
			}
			else
			{
				$content .= $i."<br />";
			}
		}
		else
		{
			fwmiddlebox($title, $content);
			$opennew=true;
			$content="";
		}
	}
}
print "<div align=\"center\">".gettext("Read full current changelog")." <a href=\"http://ftp.frugalware.org/pub/frugalware/frugalware-current/ChangeLog.txt\">".gettext("here")."</a>.</div>&nbsp;";

include("footer.php");
?>
