<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head>
		<title>Logs for <? print($day); ?></title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body>
	<div>The following logs are available for <? print($day); ?>:<br />
		<? foreach($packages as $i)
		{
			print($i["date"] . ": <a href=\"" . $i["url"] . "\">" . $i["fullname"] . "</a> " .
			($i["exitcode"] ? "built" : "failed") . "<br />\n");
		} ?>
		</div>
	</body>
</html>
