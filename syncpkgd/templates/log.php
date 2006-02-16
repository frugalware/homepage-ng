<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head>
		<title>Buildlog</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body style="background-color: black; color: white">
		<pre>
<?
$search = array(
	'|\[1;1m(.*)\[1;0m|',
	'|\[1;31m(.*)\[1;0m|',
	'|\[1;32m(.*)\[1;0m|',
	'|\[1;33m(.*)\[1;0m|',
	'|\[1;34m(.*)\[1;0m|',
	'|\[1;36m(.*)\[1;0m|',
	'|&|');

$replace = array(
	'<b>\1</b>',
	'<span style="color: red">\1</span>',
	'<span style="color: green">\1</span>',
	'<span style="color: yellow">\1</span>',
	'<span style="color: blue">\1</span>',
	'<span style="color: cyan">\1</span>',
	'&amp;');

	$fp = fopen($log, "r");
	if($fp)
	{
		while (!feof($fp))
		{
			print(preg_replace($search, $replace, fgets($fp)));
		}
		fclose($fp);
	}
?>
		</pre>
	</body>
</html>
