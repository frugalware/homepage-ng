<?
	printf("Welcome to $host, the $arch".
	" buildserver of <a href=\"http://frugalware.org\">Frugalware Linux</a>.<br>\n" .
	"The following buildlogs are available:<br><ul>\n");
	foreach($days as $i)
	{
		print("<li><a href=\"$i\">$i</a></li>\n");
	}
	print("</ul>\n");
	print("General statistics:<br>\n");
	if($syncd)
		print("The package builder daemon is running, started on " .
		$syncddate . ".<br>\n");
	else
		print("The package builder daemon is not running.<br>\n");
	if($sync)
		print("The package builder is running, started on " .
		$syncdate . ".<br>\n");
	else
		print("The package builder is sleeping, will be started again on " .
		$syncdate . ".<br>\n");
	print("Current avarage for the past one minute: " . $loadstat . "<br>\n");
?>
