<?php
#config.inc

## Settings ##

#sql settings
$sqltype = "mysql";
$sqlhost = "localhost";
$sqluser = "homepage";
$sqlpass = "85Tdjf{Od";
$sqldb = "homepage";

#site settings
$fwng_root = "/";
$adodb_path = "/usr/lib/php";

#not translated changing vars
$title = "Homepage - Reloaded";
$copydate = "2006";

## Main page ##

# box contents
$validcontent = "<div align=\"center\">
	<a href=\"http://www2.frugalware.org/\"><img src=\"".$fwng_root."images/frugalware80x15.png\" alt=\"Go Frugalware, Go\" border=\"0\" title=\"Go Frugalware, Go\" /></a><br />
	<a href=\"http://validator.w3.org/check/referer\"><img src=\"".$fwng_root."images/xhtml10.png\" alt=\"Valid XHTML 1.0!\" border=\"0\" title=\"Valid XHTML 1.0!\" /></a><br />
	<a href=\"http://jigsaw.w3.org/css-validator/check/referer\"><img src=\"".$fwng_root."images/css.png\" alt=\"Valid CSS!\" title=\"Valid CSS!\" border=\"0\" /></a><!--br />
<a href=\"http://feedvalidator.org/check.cgi?url=http://frugalware.org/rss2.php?lang=en\"><img src=\"".$fwng_root."images/valid-rss.png\" border=\"0\" alt=\"Valid RSS!\" title=\"Valid RSS!\" /></a-->
</div>\n";

$menucontent = "<a class=\"menu\" href=\"index.php\">".gettext("news")."</a> &middot; \n";
$menucontent .= "<a class=\"menu\" href=\"\" onClick=\"return clickreturnvalue()\" onMouseover=\"dropdownmenu(this, event, 'aboutmenu')\">".gettext("about")."</a> &middot; \n";
$menucontent .= "<div id=\"aboutmenu\" class=\"menulinkcss\" align=\"left\">\n";
$menucontent .= "	<a href=\"index.php\">".gettext("summary")."</a>\n";
$menucontent .= "	<a href=\"index.php\">".gettext("docs")."</a>\n";
$menucontent .= "</div>\n";
$menucontent .= "<a class=\"menu\" href=\"\" onClick=\"return clickreturnvalue()\" onMouseover=\"dropdownmenu(this, event, 'commmenu')\">".gettext("community")."</a> &middot; \n";
$menucontent .= "<div id=\"commmenu\" class=\"menulinkcss\" align=\"left\">\n";
$menucontent .= "	<a href=\"http://frugalware.org/mailman/listinfo\">".gettext("mailing lists")."</a>\n";
$menucontent .= "	<a href=\"http://forums.frugalware.org/\">".gettext("discusison forums")."</a>\n";
$menucontent .= "	<a href=\"http://wiki.frugalware.org/\">".gettext("wiki")."</a>\n";
$menucontent .= "	<a href=\"index.php\">".gettext("irc")."</a>\n";
$menucontent .= "	<a href=\"index.php\">".gettext("screenshots")."</a>\n";
$menucontent .= "	<a href=\"http://www.frappr.com/frugalware\">".gettext("map")."</a>\n";
$menucontent .= "</div>\n";
$menucontent .= "<a class=\"menu\" href=\"\" onClick=\"return clickreturnvalue()\" onMouseover=\"dropdownmenu(this, event, 'dlmenu')\">".gettext("download")."</a> &middot; \n";
$menucontent .= "<div id=\"dlmenu\" class=\"menulinkcss\" align=\"left\">\n";
$menucontent .= "	<a href=\"index.php\">".gettext("iso images")."</a>\n";
$menucontent .= "	<a href=\"index.php\">".gettext("packages")."</a>\n";
$menucontent .= "</div>\n";
$menucontent .= "<a class=\"menu\" href=\"\" onClick=\"return clickreturnvalue()\" onMouseover=\"dropdownmenu(this, event, 'develmenu')\">".gettext("development")."</a> &middot; \n";
$menucontent .= "<div id=\"develmenu\" class=\"menulinkcss\" align=\"left\">\n";
$menucontent .= "	<a href=\"http://darcs.frugalware.org/\">".gettext("darcs")."</a>\n";
$menucontent .= "	<a href=\"http://bugs.frugalware.org/\">".gettext("bugs")."</a>\n";
$menucontent .= "	<a href=\"index.php\">".gettext("changelog")."</a></li>\n";
$menucontent .= "	<a href=\"http://blogs.frugalware.org/\">".gettext("blogs")."</a>\n";
$menucontent .= "	<a href=\"index.php\">".gettext("donations")."</a></li>\n";
$menucontent .= "	<a href=\"authors.php?who=devel\">".gettext("developers")."</a>\n";
$menucontent .= "	<a href=\"authors.php?who=contrib\">".gettext("contributors")."</a>\n";
$menucontent .= "</div>\n";

$langcontent = "<div class=\"imgcontent\"><a href=\"?lang=en\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"".$fwng_root."images/english.gif\" border=\"0\" /></a> | <a href=\"?lang=hu\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"".$fwng_root."images/hungarian.gif\" border=\"0\" /></a></div>";
/*
| <a href=\"?lang=es\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/spanish.gif\" border=\"0"\ /></a> | <a href=\"?lang=fr\"><img alt=\"".gettext("Change language")."\" title=\"".gettext("Change language")."\" src=\"images/french.gif\" border=\"0\" /></a>";
*/

?>
