<?php

#homepage-ng: startpage

include("functions.inc.php");
$lang = getlang();

putenv("LANG=".$lang);
setlocale(LC_ALL,$lang);
$domain = 'messages';
bindtextdomain($domain, "locale");
textdomain($domain);

include("config.inc.php");
include("header.php");

?>

<!-- main content start -->
<div id="columns">
	<div id="leftcolumn">
<?php
fwsidebox(gettext("Menu"), $menucontent);
fwsidebox(gettext("Languages"), $langcontent);
?>
	</div>

	<div id="rightcolumn">
<?php
fwsidebox(gettext("Information"), $validcontent);
?>
	</div>

	<div id="centercolumn">
<?php
fwmiddlebox("Webpage Reloaded", "<div align=\"justify\">This will be the new webpage of Frugalware Linux, with many new things. This site is totally table-free, uses only css. Please write me your comment to the frugalware-devel or the frugalware-users mailing list.<br />Thanks:<br />IroNiQ</div>");
fwmiddlebox("Translations", "The translation will be ready only after the whole site is complete. Please be patient.<br />A tov�bbi ford�t�sok csak az oldal teljes elk�sz�lte ut�n lesznek k�szen");
?>
	</div>

	<div class="clear">&nbsp;</div>
</div>
<!-- main content end -->

<?php
include("footer.php");
?>
