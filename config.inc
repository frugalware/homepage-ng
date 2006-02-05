<?php
#config.inc

$title="Homepage - Reloaded";

$sqlhost="localhost";
$sqluser="root";
$sqlpass="";
$sqldb="fwng";

$copydate="2006";

$rightcontent = "<div align=\"center\">
	<a href=\"http://www2.frugalware.org/\"><img src=\"images/frugalware80x15.png\" alt=\"Go Frugalware, Go\" border=\"0\" title=\"Go Frugalware, Go\" /></a><br />
	<a href=\"http://validator.w3.org/check/referer\"><img src=\"images/xhtml10.png\" alt=\"Valid XHTML 1.0!\" border=\"0\" title=\"Valid XHTML 1.0!\" /></a><br />
	<a href=\"http://jigsaw.w3.org/css-validator/check/referer\"><img src=\"images/css.png\" alt=\"Valid CSS!\" title=\"Valid CSS!\" border=\"0\" /></a><!--br />
<a href=\"http://feedvalidator.org/check.cgi?url=http://frugalware.org/rss2.php?lang=en\"><img src=\"images/valid-rss.png\" border=\"0\" alt=\"Valid RSS!\" title=\"Valid RSS!\" /></a-->
</div>\n";

$mainmenu="";
$langmenu="<div class=\"imgcontent\"><a href=\"?lang=en\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/english.gif\" border=\"0\" /></a> | <a href=\"?lang=hu\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/hungarian.gif\" border=\"0\" /></a></div>";
/*
| <a href=\"?lang=es\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/spanish.gif\" border=\"0"\ /></a> | <a href=\"?lang=fr\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/french.gif\" border=\"0\" /></a>";
*/

?>