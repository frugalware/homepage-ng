<?
	foreach($packages as $i)
	{
		print($i["date"] . ": <a href=\"" . $i["url"] . "\">" . $i["fullname"] . "</a> " .
			($pkg["exitcode"] ? "built" : "failed") . "<br>\n");
	}
?>
