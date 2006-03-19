<?php

function bar($baz) {
	return preg_replace('|/([a-z0-9_+-]+).*|','$1',$baz);
}

function foo() {
	$url = 'http://frugalware.org/packages.php?op=';
	$req = ltrim($_SERVER['PATH_INFO'],'/');
	if(substr($req,0,5) == 'file:') {
		return $url . 'file&amp;srch=' . bar(substr($req, 5)) . '&amp;repo=all';
	}
	$url .= 'pkg';
	if(substr($req,0,4) == 'sub:') {
		$url .= '&amp;sub=on';
		$req = substr($req, 4);
	}
	if(substr($req,0,5) == 'desc:') {
		$url .= '&amp;desc=on';
		$req = substr($req, 5);
	}
	$url .= '&amp;arch=';
	if(substr($req,0,7) == 'x86_64:') {
		$url .= 'x86_64';
		$req = substr($req, 7);
	}
	elseif(substr($req,0,5) == 'i686:') {
		$url .= 'i686';
		$req = substr($req, 5);
	}
	else {
		$url .= 'i686';
	}
	$url .= '&amp;repo=all&amp;fwver=current&amp;srch=';
	return $url . bar($req);
}
?><html>
<META HTTP-EQUIV="Refresh" CONTENT="0; URL=<?php echo foo(); ?>">
</html>
