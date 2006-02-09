<?php
#config.inc

#sql settings
$sqltype = "mysql";
$sqlhost = "localhost";
$sqluser = "homepage";
$sqlpass = "tA1r.5Sll";
$sqldb = "homepage";

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
$menucontent .= "	<li><a href=\"index.php\">".gettext("news")."</a></li>\n";
$menucontent .= "</ul>\n";
$menucontent .= "/".gettext("about")."\n";;
$menucontent .= "<ul>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("summary")."</a></li>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("docs")."</a></li>\n";
$menucontent .= "</ul>\n";
$menucontent .= "/".gettext("community")."\n";;
$menucontent .= "<ul>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("mailing lists")."</a></li>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("discusison forums")."</a></li>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("wiki")."</a></li>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("irc")."</a></li>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("screenshots")."</a></li>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("map")."</a></li>\n";
$menucontent .= "</ul>\n";
$menucontent .= "/".gettext("download")."\n";;
$menucontent .= "<ul>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("iso images")."</a></li>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("packages")."</a></li>\n";
$menucontent .= "</ul>\n";
$menucontent .= "/".gettext("development")."\n";;
$menucontent .= "<ul>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("darcs")."</a></li>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("bugs")."</a></li>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("changelog")."</a></li>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("blogs")."</a></li>\n";
$menucontent .= "	<li><a href=\"index.php\">".gettext("donations")."</a></li>\n";
$menucontent .= "</ul>\n";
$menucontent .= "</div>\n";

$langcontent = "<div class=\"imgcontent\"><a href=\"?lang=en\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/english.gif\" border=\"0\" /></a> | <a href=\"?lang=hu\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/hungarian.gif\" border=\"0\" /></a></div>";
/*
| <a href=\"?lang=es\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/spanish.gif\" border=\"0"\ /></a> | <a href=\"?lang=fr\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/french.gif\" border=\"0\" /></a>";
*/

?>
