<?
$package = substr($_SERVER["PATH_INFO"], 1);
if (strpos($_SERVER["PATH_INFO"], "/") !== false)
	$package = preg_replace('|^([^/]*)/.*|', '$1', $package);

$tarball = preg_replace('|^[^/]*/([^/]*)|', '$1',
	substr($_SERVER["PATH_INFO"], 1));
if($tarball==$package)
	$tarball=null;

if ($package == "")
	die("usage: http://git.frugalware.org/tarballs/package/foo.tar.bz2");
if ($package != "openoffice.org")
	die("currently supported packages: openoffice.org");
header('Content-Type: application/x-bzip2; charset=UTF-8');
$arr = explode(".", $tarball);
$subpkg = explode("-", $arr[0]);
readfile("http://cgit.freedesktop.org/ooo-build/". $subpkg[2] . "/snapshot/ooo/" . strtoupper($subpkg[0]) . "_" . $subpkg[1] . ".tar.bz2");
?>
