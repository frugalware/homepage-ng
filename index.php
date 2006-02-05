<?php

#homepage-ng: startpage

include("config.inc");

if (isset($_COOKIE["fwcurrlang"])) {
	$lang=$_COOKIE["fwcurrlang"];
}

if (isset($lang) && $lang != "" ) {
	if (isset($_GET["lang"]) && $_GET["lang"] != "") {
		$nlang = $_GET["lang"];
		if ($nlang != $lang) {
			$lang = $nlang;
			setcookie("fwcurrlang", $lang, time()+3*365*24*3600);
		}
	}
}
else {
	if (isset($_GET["lang"]) && $_GET["lang"] != "") {
		$lang=$_GET["lang"];
		setcookie("fwcurrlang", $lang, time()+3*365*24*3600);
	}
	else {
		$lang=preg_replace( "/^([a-z]*)-.*/", "$1",
		preg_replace("/^([a-z\-]*),.*/", "$1", $_SERVER['HTTP_ACCEPT_LANGUAGE']));
	}
}
if ( $lang == "" ) {
	$lang="en";
}

putenv("LANG=".$langs[$lang]);
setlocale(LC_ALL,$langs[$lang]);
$domain = 'messages';
bindtextdomain($domain, "locale");
textdomain($domain);

include("functions.inc");
include("header.php");

$rightcontent = "<div align=\"center\">
<a href=\"http://www.frugalware.org/\"><img src=\"images/frugalware80x15.png\" alt=\"Go Frugalware, Go\" border=\"0\" title=\"Go Frugalware, Go\" /></a><br />
<a href=\"http://validator.w3.org/check/referer\"><img src=\"images/xhtml10.png\" alt=\"Valid XHTML 1.0!\" border=\"0\" title=\"Valid XHTML 1.0!\" /></a><br />
<a href=\"http://jigsaw.w3.org/css-validator/check/referer\"><img src=\"images/css.png\" alt=\"Valid CSS!\" title=\"Valid CSS!\" border=\"0\" /></a><!--br />
<a href=\"http://feedvalidator.org/check.cgi?url=http://frugalware.org/rss2.php?lang=en\"><img src=\"images/valid-rss.png\" border=\"0\" alt=\"Valid RSS!\" title=\"Valid RSS!\" /></a-->
</div>\n";

$mainmenu="";
$langmenu="<div class=\"imgcontent\"><a href=\"?lang=en\"><img alt=\"".gettext("Change lanugage")."\" title=\"".gettext("Change lanugage")."\" src=\"images/english.gif\" border=\"0\"></a> | <a href=\"?lang=hu\"><img alt=\"".gettext("Change lanugage")."\" title=\"".gettext("Change lanugage")."\" src=\"images/hungarian.gif\" border=\"0\"></a></div>";
/*
| <a href="?lang=es"><img alt="Váltson nyelvet" title="Váltson nyelvet" src="images/spanish.gif" border="0"></a>
<a href="?lang=fr"><img alt="Váltson nyelvet" title="Váltson nyelvet" src="images/french.gif" border="0"></a>";
*/
?>

<!-- main content start -->
<div id="main">
	<div id="leftbox">
<?php
fwnewbox(gettext("Menu"), "content1");
fwnewbox(gettext("Languages"), $langmenu);
?>
	</div>

	<div id="rightbox">
<?php
fwnewbox(gettext("Information"), $rightcontent);
?>
	</div>

	<div id="middlebox">
<?php
fwnewbox("middlebox1", "content1");
fwnewbox("middlebox2", "content2");
?>
	</div>
</div>
<!-- main content end -->

<?php
include("footer.php");
?>