<?
$repo = substr($_SERVER["PATH_INFO"], 1);
if (strpos($_SERVER["PATH_INFO"], "/") !== false)
	$repo = preg_replace('|^([^/]*)/.*|', '$1', $repo);

$patch = preg_replace('|^[^/]*/([^/]*)|', '$1',
	substr($_SERVER["PATH_INFO"], 1));
if($patch==$repo)
	$patch=null;

if ($repo == "")
	die("usage: http://darcs.frugalware.org/patches/project/hash-without-dot-gz.patch");
$patch = substr($patch, 0, strlen($patch)-6);
header('Content-Type: text/plain; charset=utf8');
include("http://darcs.frugalware.org/darcsweb/darcsweb.cgi?r=$repo;a=plain_commitdiff;h=$patch.gz;");
?>
