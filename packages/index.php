<?php

$fwversions = array('0.1', '0.2', '0.3', '0.4');
$fwarchs = array('x86_64');

function bar($baz) {
	return preg_replace('|/([a-z0-9_+-]+).*|','$1',urlencode($baz));
}

function foo() {
	global $fwversions, $fwarchs;
	$url = 'http://frugalware.org/packages/?op=';
	if(isset($_GET['search'])) {
		$_SERVER['PATH_INFO'] = $_GET['search'];
	}
	$req = ltrim($_SERVER['PATH_INFO'],'/');
	if(substr($req,0,5) == 'file:') {
		$op = 'file';
		$req = substr($req, 5);
	}
	else {
		$op = 'pkg';
	}
	$url .= $op;
	if(($op == 'pkg') && (substr($req,0,4) == 'sub:')) {
		$url .= '&amp;sub=on';
		$req = substr($req, 4);
	}
	if(($op == 'pkg') && (substr($req,0,5) == 'desc:')) {
		$url .= '&amp;desc=on';
		$req = substr($req, 5);
	}
	$url .= '&amp;arch=';
	$arr = explode(':', $req);
	if(in_array($arr[0], $fwarchs)) {
		$arch = $arr[0];
		$req = substr($req, strlen($arch)+1);
	}
	else {
		$arch .= 'i686';
	}
	$url .= $arch . '&amp;ver=';
	if(in_array(substr($req,0,3), $fwversions)) {
		$ver .= substr($req,0,3);
		$req = substr($req, 4);
	}
	else {
		$ver .= 'current';
	}
	$url .= $ver . '&amp;srch=';
	// not limiting length in any way (packages.php's job)
	return $url . bar($req);
}
?><html>
<META HTTP-EQUIV="Refresh" CONTENT="0; URL=<?php echo foo(); ?>">
</html>
