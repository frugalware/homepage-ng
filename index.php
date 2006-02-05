<?php

#homepage-ng: startpage

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

$langs = array(
	"en" => "en",
	"hu" => "hu_HU"
);

putenv("LANG=".$langs[$lang]);
setlocale(LC_ALL,$langs[$lang]);
$domain = 'messages';
bindtextdomain($domain, "locale");
textdomain($domain);

include("config.inc");
include("functions.inc");
include("header.php");

?>

<!-- main content start -->
<div id="main">
	<div id="leftbox">
<?php
fwnewbox(gettext("Menu"), "Menu content");
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