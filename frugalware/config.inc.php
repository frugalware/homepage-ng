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
$validcontent = '<div align="center">
	<a href="http://www2.frugalware.org/"><img src="' . $fwng_root . 'images/frugalware80x15.png" alt="Go Frugalware, Go" border="0" title="Go Frugalware, Go" /></a><br />
	<a href="http://validator.w3.org/check/referer"><img src="' . $fwng_root . 'images/xhtml10.png" alt="Valid XHTML 1.0!" border="0" title="Valid XHTML 1.0!" /></a><br />
	<a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="' . $fwng_root . 'images/css.png" alt="Valid CSS!" title="Valid CSS!" border="0" /></a><!--br /><a href="http://feedvalidator.org/check.cgi?url=http://frugalware.org/rss2.php?lang=en"><img src="' . $fwng_root . 'images/valid-rss.png" border="0" alt="Valid RSS!" title="Valid RSS!" /></a--></div>' . "\n";

$menucontent = '<a class="menu" href="index.php">' . gettext('News') . "</a> &middot; \n";
$menucontent .= '<a class="menu" href="" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, \'aboutmenu\')">' . gettext('About') . "</a> &middot; \n";
$menucontent .= '<div id="aboutmenu" class="menulinkcss" align="left">' . "\n";
$menucontent .= '	<a href="about.php">' . gettext('Summary') . "</a>\n";
$menucontent .= '	<a href="index.php">' . gettext('Documentation') . "</a>\n";
$menucontent .= "</div>\n";
$menucontent .= '<a class="menu" href="" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, \'commmenu\')">' . gettext('Community') . "</a> &middot; \n";
$menucontent .= '<div id="commmenu" class="menulinkcss" align="left">' . "\n";
$menucontent .= '	<a href="http://frugalware.org/mailman/listinfo">' . gettext('Mailing Lists') . "</a>\n";
$menucontent .= '	<a href="http://forums.frugalware.org/">' . gettext('Discussion Forums') . "</a>\n";
$menucontent .= '	<a href="http://wiki.frugalware.org/">' . gettext('Wiki') . "</a>\n";
$menucontent .= '	<a href="index.php">' . gettext('IRC') . "</a>\n";
$menucontent .= '	<a href="screenshot.php">' . gettext('Screenshots') . "</a>\n";
$menucontent .= '	<a href="http://www.frappr.com/frugalware">' . gettext('Map') . "</a>\n";
$menucontent .= "</div>\n";
$menucontent .= '<a class="menu" href="" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, \'dlmenu\')">' . gettext('Download') . "</a> &middot; \n";
$menucontent .= '<div id="dlmenu" class="menulinkcss" align="left">' . "\n";
$menucontent .= '	<a href="index.php">' . gettext('ISO images') . "</a>\n";
$menucontent .= '	<a href="packages.php">' . gettext('Packages') . "</a>\n";
$menucontent .= "</div>\n";
$menucontent .= '<a class="menu" href="" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, \'develmenu\')">' . gettext('Development') . "</a>\n";
$menucontent .= '<div id="develmenu" class="menulinkcss" align="left">' . "\n";
$menucontent .= '	<a href="roadmap.php">' . gettext('Roadmap') . "</a>\n";
$menucontent .= '	<a href="http://darcs.frugalware.org/">' . gettext('Darcs repository') . "</a>\n";
$menucontent .= '	<a href="http://bugs.frugalware.org/">' . gettext('Bug Tracker') . "</a>\n";
$menucontent .= '	<a href="index.php">' . gettext('ChangeLog') . "</a>\n";
$menucontent .= '	<a href="http://blogs.frugalware.org/">' . gettext('Blogs') . "</a>\n";
$menucontent .= '	<a href="index.php">' . gettext('Donations') . "</a>\n";
$menucontent .= '	<a href="authors.php?who=devel">' . gettext('Developers') . "</a>\n";
$menucontent .= '	<a href="authors.php?who=contrib">' . gettext('Contributors') . "</a>\n";
$menucontent .= "</div>\n";

$langcontent = '<div class="imgcontent"><a href="?lang=en"><img alt="' . gettext('Change language') . '" title="' . gettext('Change language') . '" src="' . $fwng_root . 'images/english.gif" border="0" /></a> | <a href="?lang=hu"><img alt="' . gettext('Change language') . '" title="' . gettext('Change language') . '" src="' . $fwng_root . 'images/hungarian.gif" border="0" /></a></div>';
/*
| <a href="?lang=es"><img alt="' . gettext('Change language') . '" title="' . gettext('Change language') . '" src="images/spanish.gif" border="0" /></a> | <a href="?lang=fr"><img alt="' . gettext('Change language') . '" title="' . gettext('Change language') . '" src="images/french.gif" border="0" /></a>';
*/

?>
