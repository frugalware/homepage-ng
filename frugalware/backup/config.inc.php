<?php
#config.inc

## Settings ##

#sql settings
$sqltype = "mysql";
$sqlhost = "localhost";
$sqluser = "homepage";
$sqlpass = "85Tdjf{Od";
$sqldb = "frugalware2";

#site settings
$fwng_root = $myurl."/";
$adodb_path = "/usr/share/php";
$trans_path="/home/ftp/pub/other/translations/";
$top_path = "/home/ftp/pub/frugalware/frugalware-current";
$cache_path = "/var/cache/homepage";
$docs_path = $top_path."/docs";
$top_path_stable = "/home/ftp/pub/frugalware/frugalware-stable";
$docs_path_stable = $top_path_stable."/docs";
$news_limit = 10;
$pkgcache = "/tmp/pkgcache.info";
$pkgcachetimeout = 180;
$rsscachetimeout = 900;
$upfile = "/proc/uptime";

#not translated changing vars
$title = "Homepage - Reloaded";
$copydate = "2003-2011";
$domain = 'homepage';

## Main page ##

# box contents
$validcontent = '<div align="left">
	  <a href="http://' . $_SERVER["SERVER_NAME"] . '/"><img src="' . $fwng_root . 'images/frugalware80x15.png" alt="Go Frugalware, Go" border="0" title="Go Frugalware, Go" /></a><br />
	  <a href="http://validator.w3.org/check/referer"><img src="' . $fwng_root . 'images/xhtml10.png" alt="Valid XHTML 1.0!" border="0" title="Valid XHTML 1.0!" /></a><br />
	  <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="' . $fwng_root . 'images/css.png" alt="Valid CSS!" title="Valid CSS!" border="0" /></a><br />
	  <a href="http://feedvalidator.org/check.cgi?url=http://' . $_SERVER["SERVER_NAME"] . $fwng_root . 'rss/releases"><img src="' . $fwng_root . 'images/valid-rss.png" border="0" alt="Valid RSS!" title="Valid RSS!" /></a>
	</div>';

#$menucontent = '<a class="menu" href="' . $fwng_root . '">' . gettext('News') . "</a> | \n";
$menucontent = '<a class="menu" href="" onclick="return clickreturnvalue()" onmouseover="dropdownmenu(this, event, \'newsmenu\')">' . gettext('News') . "</a> | \n";
$menucontent .= '<div id="newsmenu" class="menulinkcss" align="left">' . "\n";
$menucontent .= '	<a href="' . $fwng_root . '">' . gettext('Announcements') . "</a>\n";
$menucontent .= '	<a href="' . $fwng_root . 'security">' . gettext('Security announcements') . "</a>\n";
$menucontent .= '	<a href="' . $fwng_root . 'rss">' . gettext('News feeds') . "</a>\n";
$menucontent .= "</div>\n";
$menucontent .= '<a class="menu" href="" onclick="return clickreturnvalue()" onmouseover="dropdownmenu(this, event, \'aboutmenu\')">' . gettext('About') . "</a> | \n";
$menucontent .= '<div id="aboutmenu" class="menulinkcss" align="left">' . "\n";
$menucontent .= '	<a href="' . $fwng_root . 'about">' . gettext('Summary') . "</a>\n";
$menucontent .= '	<a href="' . $fwng_root . 'media">' . gettext('Frugalware in the Press') . "</a>\n";
$menucontent .= '	<a href="' . $fwng_root . 'screenshots">' . gettext('Screenshots') . "</a>\n";
$menucontent .= "</div>\n";

$menucontent .= '<a class="menu" href="' . $fwng_root . 'download">' . gettext('Get Frugalware') . "</a> | \n";
$menucontent .= '<a class="menu" href="' . $fwng_root . 'packages">' . gettext('Packages') . "</a> | \n";
$menucontent .= '<a class="menu" href="' . $fwng_root . 'docs">' . gettext('Documentation') . "</a> | \n";
$menucontent .= '<a class="menu" href="http://forums.frugalware.org/">' . gettext('Discussion Forums') . "</a> | \n";
$menucontent .= '<a class="menu" href="http://bugs.frugalware.org/">' . gettext('Bug Tracker') . "</a> | \n";
$menucontent .= '<a class="menu" href="https://bugs.frugalware.org/frugalware/frugalware-current/wikis/home">' . gettext('Wiki') . "</a> | \n";

$menucontent .= '<a class="menu" href="" onclick="return clickreturnvalue()" onmouseover="dropdownmenu(this, event, \'commmenu\')">' . gettext('Community') . "</a> | \n";
$menucontent .= '<div id="commmenu" class="menulinkcss" align="left">' . "\n";
$menucontent .= '	<a href="http://frugalware.org/mailman/listinfo">' . gettext('Mailing Lists') . "</a>\n";
$menucontent .= '	<a href="' . $fwng_root . 'irc">' . gettext('IRC') . "</a>\n";
$menucontent .= '	<a href="' . $fwng_root . 'paste">' . gettext('Pastebin') . "</a>\n";
$menucontent .= '	<a href="http://planet.frugalware.org/">' . gettext('Blogs') . "</a>\n";
$menucontent .= '	<a href="' . $fwng_root . 'i18n">' . gettext('Local Communities') . "</a>\n";
$menucontent .= '	<a href="http://www.frugalware-art.org/">' . gettext('Artwork') . "</a>\n";
$menucontent .= '	<a href="http://identi.ca/group/frugalware">' . gettext('Identi.ca group') . "</a>\n";
$menucontent .= '	<a href="http://twitter.com/frugalware">' . gettext('Twitter') . "</a>\n";
$menucontent .= "</div>\n";

$menucontent .= '<a class="menu" href="" onclick="return clickreturnvalue()" onmouseover="dropdownmenu(this, event, \'develmenu\')">' . gettext('Development') . "</a>\n";
$menucontent .= '<div id="develmenu" class="menulinkcss" align="left">' . "\n";
$menucontent .= '	<a href="' . $fwng_root . 'roadmap">' . gettext('Roadmap') . "</a>\n";
$menucontent .= '	<a href="http://git.frugalware.org/">' . gettext('Git repository') . "</a>\n";
$menucontent .= '	<a href="http://pootle.frugalware.org/">' . gettext('Translation portal') . "</a>\n";

$menucontent .= '	<a href="' . $fwng_root . 'donations">' . gettext('Donations') . "</a>\n";
$menucontent .= '	<a href="' . $fwng_root . 'authors">' . gettext('Authors') . "</a>\n";
$menucontent .= "</div>\n";

if($_SERVER["PHP_SELF"]=="/index.php")
	$langpage=$fwng_root;
else
{
	$arr = explode(".", substr($_SERVER["PHP_SELF"], 1));
	$langpage=$fwng_root . $arr[0] . "/";
}
$langcontent = '<div class="imgcontent">
	  <a href="' . $langpage . 'en"><img alt="' . gettext( 'Change language' ) . '" title="' . gettext( 'Change language' ) . '" src="' . $fwng_root . 'images/english.gif" border="0" /></a>
	  |
	  <a href="' . $langpage . 'hu"><img alt="' . gettext( 'Change language' ) . '" title="' . gettext( 'Change language' ) . '" src="' . $fwng_root . 'images/hungarian.gif" border="0" /></a>
	  |
	  <a href="' . $langpage . 'fr"><img alt="' . gettext( 'Change language' ) . '" title="' . gettext( 'Change language' ) . '" src="' . $fwng_root . 'images/french.gif" border="0" /></a>
	  |
	  <a href="' . $langpage . 'sk"><img alt="' . gettext( 'Change language' ) . '" title="' . gettext( 'Change language' ) . '" src="' . $fwng_root . 'images/slovak.gif" border="0" /></a>
	  |
	  <a href="' . $langpage . 'ru"><img alt="' . gettext( 'Change language' ) . '" title="' . gettext( 'Change language' ) . '" src="' . $fwng_root . 'images/russian.gif" border="0" /></a>
	  |
	  <a href="' . $langpage . 'da"><img alt="' . gettext( 'Change language' ) . '" title="' . gettext( 'Change language' ) . '" src="' . $fwng_root . 'images/danish.gif" border="0" /></a>
	  |
	  <a href="' . $langpage . 'cs"><img alt="' . gettext( 'Change language' ) . '" title="' . gettext( 'Change language' ) . '" src="' . $fwng_root . 'images/czech.gif" border="0" /></a>
	  |
	  <a href="' . $langpage . 'es"><img alt="' . gettext( 'Change language' ) . '" title="' . gettext( 'Change language' ) . '" src="' . $fwng_root . 'images/spanish.gif" border="0" /></a>
	  |
	  <a href="' . $langpage . 'it"><img alt="' . gettext( 'Change language' ) . '" title="' . gettext( 'Change language' ) . '" src="' . $fwng_root . 'images/italian.gif" border="0" /></a>
	  |
	  <a href="' . $langpage . 'de"><img alt="' . gettext( 'Change language' ) . '" title="' . gettext( 'Change language' ) . '" src="' . $fwng_root . 'images/german.gif" border="0" /></a>
	<!--
	  |
	  <a href="' . $langpage . 'nl"><img alt="' . gettext( 'Change language' ) . '" title="' . gettext( 'Change language' ) . '" src="' . $fwng_root . 'images/dutch.gif" border="0" /></a>
	-->
	<!--
	  |
	  <a href="' . $langpage . 'tr"><img alt="' . gettext( 'Change language' ) . '" title="' . gettext( 'Change language' ) . '" src="' . $fwng_root . 'images/turkish.gif" border="0" /></a>
	-->
	</div>';
/*
| <a href="?lang=es"><img alt="' . gettext('Change language') . '" title="' . gettext('Change language') . '" src="images/spanish.gif" border="0" /></a> | <a href="?lang=fr"><img alt="' . gettext('Change language') . '" title="' . gettext('Change language') . '" src="images/french.gif" border="0" /></a>';
*/

?>
