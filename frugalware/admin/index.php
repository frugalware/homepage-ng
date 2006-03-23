<?php

#admin site

include("../functions.inc.php");
$lang = getlang();

putenv("LANG=".$lang);
setlocale(LC_ALL,$lang);
$domain = 'messages';
bindtextdomain($domain, "locale");
textdomain($domain);

include("../config.inc.php");
include("../db.inc.php");
include("login.inc.php");

$login = new Login();
$login->doLogin();

require("admin.inc.php")

include("../header.php");
?>
<div id="columns">
	<div id="leftcolumn">
		<?php
			fwsidebox(gettext("Menu"), "<p>content</p>");
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
			fwmiddlebox(gettext("Main"), "<div align=\"center\">You are now logged in. If you want to log out, click <a href=\"?logout=\">here</a></div>");
		?>
	</div>
</div>
<?php
include("../footer.php");

?>
