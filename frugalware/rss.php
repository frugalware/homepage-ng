<?php

/**
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License v2 as published by
 the Free Software Foundation

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 GNU General Public License for more details.
 */

/**
 * Frugalware Linux Homepage - RSS feed
 *
 * @author Miklos Vajna <vmiklos@frugalware.org>
 * @author Krisztian VASAS <iron@frugalware.org>
 * @copyright Copyright (c) 2006. Krisztian VASAS
 */

// include some useful functions and the config
include("functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

include("config.inc.php");
include("db.inc.php");

switch($_GET['type'])
{
	case "releases":
		include("xml.inc.php");
		if (file_exists("xml/roadmap.xml"))
			$xmlfile = "xml/roadmap.xml";
		else
			$xmlfile = $docs_path."/xml/roadmap.xml";
		$xml = file_get_contents($xmlfile);
		$parser = new XMLParser($xml);
		$parser->Parse();
		$releases = $parser->document->release;
		$handle['title']="Frugalware Linux ";
		$handle['desc']="Frugalware Linux is general purpose Linux distribution designed for intermediate users. Some of its elements were borrowed from Slackware Linux and Arch Linux.";
		$handle['link']="http://frugalware.org/";
		for ( $i=0; $i < count($releases); $i++)
		{
			if ($releases[$i]->status[0]->tagData == '1') {
				
				$handle['items'][] = array(
					"title" => 'frugalware-' . $releases[$i]->version[0]->tagData,
					"link" => 'http://www2.frugalware.org/news/' . $releases[$i]->newsid[0]->tagData,
					"desc" => '',
					"pubDate" => date(DATE_RFC2822, strtotime($releases[$i]->date[0]->tagData)),
				);
				
			}
		}
		break;

	case "packages":
		$db  = new FwDB();
		$db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware");

		$handle['title']="Frugalware Linux Packages";
		$handle['desc']="Latest updates to the Frugalware Linux package repositories.";
		$handle['link']="http://frugalware.org/packages.php";
		$query="select groups, pkgname, id, pkgver, pkgrel, arch, `desc`, unix_timestamp(updated), uploader from packages order by updated desc limit 10";
		$result = $db->doQuery($query);
		while ($i = $db->doFetchRow($result))
		{
			$handle['items'][] = array(
				"title" => preg_replace("/^([^ ]*) .*/", "$1", $i['groups']) . "/${i['pkgname']}-${i['pkgver']}-${i['pkgrel']}-${i['arch']}",
				"desc" => $i['desc'],
				"author" => $i['uploader']."@nospam.frugalware.org",
				"pubDate" => date(DATE_RFC2822, $i['unix_timestamp(updated)']),
				"link" => "http://frugalware.org/packages/${i['id']}"
			);
		}
		$db->doClose();
		break;

	case "news";
		include("xml.inc.php");
		if (file_exists("xml/news.xml"))
			$xmlfile = "xml/news.xml";
		else
			$xmlfile = $docs_path."/xml/news.xml";
		$xml = file_get_contents($xmlfile);
		$parser = new XMLParser($xml);
		$parser->Parse();
		$news = $parser->document->post;
		$handle['title']="Frugalware Linux News";
		$handle['desc']="Latest news of Frugalware Linux.";
		$handle['link']="http://frugalware.org/";
		for ( $i=0; $i<$news_limit; $i++)
		{
			$handle['items'][] = array(
				"title" => $news[$i]->title[0]->tagData,
				"link" => "http://www2.frugalware.org/news/".$news[$i]->id[0]->tagData,
				"pubDate" => date(DATE_RFC2822, strtotime($news[$i]->date[0]->tagData)),
				"desc" => preg_replace('/(<a href=.*>|<\/a>)/', '', $news[$i]->content[0]->tagData),
			);
		}
		break;

	case "darcs":
		header('Content-Type: application/xml; charset=utf-8');
		print(file_get_contents("http://darcs.frugalware.org/genesis.darcsweb/darcsweb.cgi?r=frugalware-current;a=rss"));
		die();
	case "bugs":
		header('Content-Type: application/xml; charset=utf-8');
		print(file_get_contents("http://bugs.frugalware.org/feed.php?feed_type=rss2&project=0"));
		die();
	case "blogs":
		header('Content-Type: application/xml; charset=utf-8');
		print(file_get_contents("http://blogs.frugalware.org/xmlsrv/rss2.php?blog=1"));
		die();
	default:
		include("header.php");
		fwmiddlebox("RSS",'<ul>
			<li><a href="/rss/news">' . gettext('News') . '</a></li>
			<li><a href="/rss/releases">' . gettext('Stable releases') . '</a></li>
			<li><a href="/rss/darcs">' . gettext('Darcs commits') . '</a></li>
			<li><a href="/rss/bugs">' . gettext('BTS entries') . '</a></li>
			<li><a href="/rss/packages">' . gettext('Package updates') . '</a></li>
			<li><a href="/rss/blogs">' . gettext('Blog posts') . '</a></li>
			</ul>'
		);
		include("footer.php");
		die();
}

header('Content-Type: application/xml; charset=utf-8');
print("<?xml version=\"1.0\" encoding=\"utf-8\"?>
<rss version=\"2.0\">
<channel>
	<title>".$handle['title']."</title>
	<description>".$handle['desc']."</description>
	<link>".$handle['link']."</link>\n");
foreach( $handle['items'] as $i )
{
	print("<item>\n<title>".$i['title']."</title>\n<link>".$i['link']."</link>\n<guid>".$i['link']."#top</guid>\n");
	if(isset($i['desc']))
	{
		print "<description>".htmlspecialchars($i['desc'])."</description>\n";
	}
	if(isset($i['author']))
	{
		print("<author>".$i['author']."</author>\n");
	}
	if(isset($i['pubDate']))
	{
		print("<pubDate>".$i['pubDate']."</pubDate>\n");
	}
	print("</item>\n");
}
print("</channel>\n</rss>");
?>
