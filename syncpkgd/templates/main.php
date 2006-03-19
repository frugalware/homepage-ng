<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head>
		<title><? print("Welcome to $host!"); ?></title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body>
		<div>Welcome to <? print("$host, the $arch"); ?> buildserver of
		<a href="http://frugalware.org">Frugalware Linux</a>.<br />
		The following buildlogs are available:<br /></div>
		<ul>
		<? foreach($days as $i)
		{
			print("<li><a href=\"$i\">$i</a></li>\n");
		} ?>
		</ul>
		<div>General statistics:<br />
		<? if($syncd)
			print("The package builder daemon is running, started on " .
				$syncddate . ".<br />\n");
		else
			print("The package builder daemon is not running.<br />\n");
		if($sync)
			print("The package builder is running, started on " .
				$syncdate . ".<br />\n");
		else
			print("The package builder is sleeping, will be started again on " .
				$syncdate . ".<br />\n");
		print("Avarage load for the past one minute: " . $loadstat . "<br />\n");
		print("<a href=\"/hardware\">Hardware informations</a>.<br />\n"); ?>
		</div>
	</body>
</html>
