<?php

# functions.inc

function fwnewbox($boxhead="", $content)
{
	if ($boxhead != "")
	{
		print "		<div class=\"header\">
			$boxhead
		</div>
		<div class=\"content\">
			$content
		</div>
		<div class=\"freespace\">
			&nbsp;
		</div>\n";
	}
	else
	{
		print "		<div class=\"content\">
			$content
		</div>
		<div class=\"freespace\">
			&nbsp;
		</div>\n";
	}
}

?>