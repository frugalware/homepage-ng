<?php

#admin site

include("../functions.inc.php");
$lang = getlang();

putenv("LANG=".$lang);
setlocale(LC_ALL,$lang);
$domain = 'homepage';
bindtextdomain($domain, "locale");
textdomain($domain);

include("../config.inc.php");
include("../db.inc.php");
include("login.inc.php");

$login = new Login();
$login->doLogin();

require("admin.inc.php");

function main()
{
	global $fwng_root, $langcontent, $validcontent;
	include("../header.php");
?>
<div id="columns">
	<div id="leftcolumn">
		<?php
			fwsidebox(gettext("Menu"), get_admin_menu($_SESSION[level]));
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
			fwmiddlebox(gettext("Main"), "<div align=\"center\">You are now logged in.</div>");
		?>
	</div>
</div>
<?php
	include("../footer.php");
}

function addnews()
{
	global $fwng_root, $langcontent, $validcontent;
	include("../header.php");
?>
<div id="columns">
	<div id="leftcolumn">
		<?php
			fwsidebox(gettext("Menu"), get_admin_menu($_SESSION[level], true));
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
			fwmiddlebox(gettext("Add news"), "<div align=\"center\">Add news</div>");
		?>
	</div>
</div>
<?php
	include("../footer.php");
}

function editnews()
{
	print "editnews";
}

function editusers()
{
	print "editusers";
}

switch($_GET["do"])
{
	case "addnews":
		addnews();
	break;

	case "editnews":
		editnews();
	break;

	case "editusers":
		editusers();
	break;

	default:
		main();
	break;
}
?>
