<?php

# administrative functions

function get_admin_menu($level)
{
	$menu = "\n<div id=\"mainmenu\">\n\t<ul>\n";
	switch($level)
	{
		case "1":
			$menu .= "\t\t<li><a href=\"?do=addnews\">".gettext("add news")."</a></li>\n";
		break;

		case "5":
			$menu .= "\t\t<li><a href=\"?do=addnews\">".gettext("add news")."</a></li>
		<li><a href=\"?do=editnews\">".gettext("edit news")."</a></li>\n";
		break;

		case "10":
			$menu .= "\t\t<li><a href=\"?do=addnews\">".gettext("add news")."</a></li>
		<li><a href=\"?do=editnews\">".gettext("edit news")."</a></li>
		<li><a href=\"?do=editusers\">".gettext("edit users")."</a></li>\n";
		break;
	}
	$menu .= "\t\t<li><a href=\"?logout=\">".gettext("logout")."</a></li>\n";
	$menu .= "\t</ul>\n</div>";
	return $menu;
}

?>
