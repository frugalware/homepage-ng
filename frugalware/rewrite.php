<?
/*
 *  rewrite.php for homepage
 * 
 *  Copyright (c) 2006 by Miklos Vajna <vmiklos@frugalware.org>
 * 
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, 
 *  USA.
 */

include("functions.inc.php");
include("config.inc.php");

$pages = array('about', 'donations', 'irc', 'screenshots', 'authors',
	'download', 'media', 'roadmap', 'changelog', 'docs', 'news',
	'packages', 'rss', 'security', 'newsletter');

// anti-slash for kiddies
$params = explode("/", trim(addslashes(stripslashes($_SERVER["PATH_INFO"])), "/"));

// a /$lang at the end of the url is allowed anytime
if(getllang($params[count($params)-1])!="")
{
	$lang = $params[count($params)-1];
	unset($params[count($params)-1]);
}

// see if there is a page or we should default to news
if((count($params)==0) or (!in_array($params[0], $pages)))
	$page="index";
else
{
	if($params[0]!="news")
		$page = $params[0];
	else
		$page = "index";
	array_shift($params);
}

// do we have any parameter?
if(count($params)>0)
{
	if($page=="authors")
	{
		if(($params[0]=="devel") or ($params[0]=="contrib"))
			$urlsuffix="?who=".$params[0];
	}
	else if($page=="download")
		// don't use $params[0] since the path can contain slashes
		$urlsuffix="?url=".substr(trim(addslashes(stripslashes($_SERVER["PATH_INFO"])), "/"), 9);
	else if($page=="index")
	{
		$urlsuffix="?id=".$params[0];
	}
	else if($page=="newsletter")
	{
		$urlsuffix="?id=".$params[0];
	}
	else if($page=="rss")
	{
		$urlsuffix="?type=".$params[0];
	}
	else if($page=="docs")
	{
		$urlsuffix="?doc=".str_replace(".html", "", $params[0]);
	}
	else if($page=="packages" and is_numeric($params[0]))
	{
		$urlsuffix="?id=".$params[0];
		if(count($params)>1 and $params[1]=="files")
			$urlsuffix.="&s=f";
	}
}

if($_SERVER["QUERY_STRING"]!="")
{
	if($page="packages")
		$urlsuffix="?".$_SERVER["QUERY_STRING"];
}

// build the url
$url="http://" . $_SERVER["SERVER_NAME"] . "$fwng_root$page.php$urlsuffix";

if($page=="rss" and isset($urlsuffix))
{
	// special header + those page can have <?xml..
	header('Content-Type: application/xml; charset=utf-8');
	readfile($url);
}
else
{
	if(isset($lang))
		$lang = getlang($lang);
	else
		$lang = getlang();
	if(!isset($urlsuffix))
		$url.="?lang=$lang";
	else
		$url.="&lang=$lang";
	header("Content-type: text/html; charset=UTF-8");
	include($url);
}
?>
