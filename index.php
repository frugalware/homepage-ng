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
include("header.php");
include("functions.inc");

?>

<!-- main content start -->
<div id="main">
	<div id="leftbox">
<?php
fwnewbox(gettext("Menu"), $menucontent);
//fwnewbox(gettext("Languages"), $langcontent);
?>
	</div>

	<div id="rightbox">
<?php
fwnewbox(gettext("Information"), $validcontent);
?>
	</div>

	<div id="middlebox">
<?php
fwnewbox("Translations", "The translation will be ready only after the whole site is complete. Please be patient.<br />A további fordítások csak az oldal teljes elkészülte után lesznek készen");
?>
	</div>

	<div class="clear">&nbsp;</div>
</div>
<!-- main content end -->

<?php
include("footer.php");
?>