<?
$repo = substr($_SERVER["PATH_INFO"], 1);
if (strpos($_SERVER["PATH_INFO"], "/") !== false)
	$repo = preg_replace('|^([^/]*)/.*|', '$1', $repo);

$patch = preg_replace('|^[^/]*/([^/]*)|', '$1',
	substr($_SERVER["PATH_INFO"], 1));
if($patch==$repo)
	$patch=null;

if ($repo == "")
	die("usage: http://git.frugalware.org/patches/project/hash.patch");
$patch = substr($patch, 0, strlen($patch)-6);
header('Content-Type: text/plain; charset=utf8');
include("http://git.frugalware.org/gitweb/gitweb.cgi?p=$repo.git;a=commitdiff_plain;h=$patch");
?>
