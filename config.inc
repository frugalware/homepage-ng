<?php
#config.inc

#sql settings
$sqlhost = "localhost";
$sqluser = "root";
$sqlpass = "";
$sqldb = "fwng";

#not translated changing vars
$title = "Homepage - Reloaded";
$copydate = "2006";

# box contents
$validcontent = "<div align=\"center\">
	<a href=\"http://www2.frugalware.org/\"><img src=\"images/frugalware80x15.png\" alt=\"Go Frugalware, Go\" border=\"0\" title=\"Go Frugalware, Go\" /></a><br />
	<a href=\"http://validator.w3.org/check/referer\"><img src=\"images/xhtml10.png\" alt=\"Valid XHTML 1.0!\" border=\"0\" title=\"Valid XHTML 1.0!\" /></a><br />
	<a href=\"http://jigsaw.w3.org/css-validator/check/referer\"><img src=\"images/css.png\" alt=\"Valid CSS!\" title=\"Valid CSS!\" border=\"0\" /></a><!--br />
<a href=\"http://feedvalidator.org/check.cgi?url=http://frugalware.org/rss2.php?lang=en\"><img src=\"images/valid-rss.png\" border=\"0\" alt=\"Valid RSS!\" title=\"Valid RSS!\" /></a-->
</div>\n";

$menucontent = "<div id=\"mainmenu\">";
$menucontent .= "/\n";
$menucontent .= "<ul>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu1', 'visible');return true\" onmouseout=\"chgclass('menu1', 'hidden');return true\"><a href=\"index.php\">".gettext("news")."</a><span id=\"menu1\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "</ul>\n";
$menucontent .= "/".gettext("about")."\n";;
$menucontent .= "<ul>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu2', 'visible');return true\" onmouseout=\"chgclass('menu2', 'hidden');return true\"><a href=\"index.php\">".gettext("summary")."</a><span id=\"menu2\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu3', 'visible');return true\" onmouseout=\"chgclass('menu3', 'hidden');return true\"><a href=\"index.php\">".gettext("docs")."</a><span id=\"menu3\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "</ul>\n";
$menucontent .= "/".gettext("community")."\n";;
$menucontent .= "<ul>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu4', 'visible');return true\" onmouseout=\"chgclass('menu4', 'hidden');return true\"><a href=\"index.php\">".gettext("mailing lists")."</a><span id=\"menu4\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu5', 'visible');return true\" onmouseout=\"chgclass('menu5', 'hidden');return true\"><a href=\"index.php\">".gettext("discusison forums")."</a><span id=\"menu5\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu6', 'visible');return true\" onmouseout=\"chgclass('menu6', 'hidden');return true\"><a href=\"index.php\">".gettext("wiki")."</a><span id=\"menu6\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu7', 'visible');return true\" onmouseout=\"chgclass('menu7', 'hidden');return true\"><a href=\"index.php\">".gettext("irc")."</a><span id=\"menu7\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu8', 'visible');return true\" onmouseout=\"chgclass('menu8', 'hidden');return true\"><a href=\"index.php\">".gettext("screenshots")."</a><span id=\"menu8\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu9', 'visible');return true\" onmouseout=\"chgclass('menu9', 'hidden');return true\"><a href=\"index.php\">".gettext("map")."</a><span id=\"menu9\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "</ul>\n";
$menucontent .= "/".gettext("download")."\n";;
$menucontent .= "<ul>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu10', 'visible');return true\" onmouseout=\"chgclass('menu10', 'hidden');return true\"><a href=\"index.php\">".gettext("iso images")."</a><span id=\"menu10\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu11', 'visible');return true\" onmouseout=\"chgclass('menu11', 'hidden');return true\"><a href=\"index.php\">".gettext("packages")."</a><span id=\"menu11\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "</ul>\n";
$menucontent .= "/".gettext("development")."\n";;
$menucontent .= "<ul>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu12', 'visible');return true\" onmouseout=\"chgclass('menu12', 'hidden');return true\"><a href=\"index.php\">".gettext("darcs")."</a><span id=\"menu12\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu13', 'visible');return true\" onmouseout=\"chgclass('menu13', 'hidden');return true\"><a href=\"index.php\">".gettext("bugs")."</a><span id=\"menu13\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu14', 'visible');return true\" onmouseout=\"chgclass('menu14', 'hidden');return true\"><a href=\"index.php\">".gettext("changelog")."</a><span id=\"menu14\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu15', 'visible');return true\" onmouseout=\"chgclass('menu15', 'hidden');return true\"><a href=\"index.php\">".gettext("blogs")."</a><span id=\"menu15\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "	<li onmouseover=\"chgclass('menu16', 'visible');return true\" onmouseout=\"chgclass('menu16', 'hidden');return true\"><a href=\"index.php\">".gettext("donations")."</a><span id=\"menu16\" class=\"blinkmenu\">_</span></li>\n";
$menucontent .= "</ul>\n";
$menucontent .= "</div>\n";

$langcontent = "<div class=\"imgcontent\"><a href=\"?lang=en\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/english.gif\" border=\"0\" /></a> | <a href=\"?lang=hu\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/hungarian.gif\" border=\"0\" /></a></div>";
/*
| <a href=\"?lang=es\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/spanish.gif\" border=\"0"\ /></a> | <a href=\"?lang=fr\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/french.gif\" border=\"0\" /></a>";
*/

?>