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
include("lib/functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

$encoded = "";
include("lib/config.inc.php");
include("lib/db.inc.php");

$path = $cache_path . "/" . sha1(str_replace('&cache=no', '', $_SERVER['REQUEST_URI']));

if(file_exists($path))
    $info = stat($path);

date_default_timezone_set('America/New_York');

if((isset($_GET['cache']) and $_GET['cache'] != "no") and isset($info) and ((time() - $info["mtime"])<$rsscachetimeout))
    print(file_get_contents($path));
else
{
    switch($_GET['type'])
    {
        case "releases":
            include("lib/xml.inc.php");
            if (file_exists("xml/roadmap.xml"))
                $xmlfile = "xml/roadmap.xml";
            else
                $xmlfile = $docs_path."/xml/roadmap.xml";
            $xml = file_get_contents($xmlfile);
            $parser = new XMLParser($xml);
            $parser->Parse();
            $releases = $parser->document->release;
            $handle['title']="Frugalware Linux Releases";
            $handle['desc']="Frugalware Linux is general purpose Linux distribution designed for intermediate users.";
            $handle['link']="http://frugalware.org/";
            for ( $i=0; $i < count($releases); $i++)
            {
                if ($releases[$i]->status[0]->tagData == '1') {

                    $handle['items'][] = array(
                        "title" => 'frugalware-' . $releases[$i]->version[0]->tagData,
                        "link" => 'http://www.frugalware.org/news/' . $releases[$i]->newsid[0]->tagData,
                        "desc" => '',
                        "pubDate" => date(DATE_RFC2822, strtotime($releases[$i]->date[0]->tagData)),
                    );

                }
            }
            break;

        case "packages":
            $db  = new FwDB();
            $db->doConnect($sqlhost, $sqluser, $sqlpass, "frugalware2");

            $handle['title']="Frugalware Linux Packages";
            $handle['desc']="Latest updates to the Frugalware Linux package repositories.";
            $handle['link']="http://frugalware.org/packages.php";
            $query = 'select packages.pkgname, uploaders.login,
                groups.name, packages.id, packages.pkgver,
                packages.arch, packages.`desc`,
                unix_timestamp(packages.builddate) from packages, groups,
                ct_groups, uploaders where packages.id =
                ct_groups.pkg_id and ct_groups.group_id = groups.id and'.
                ($_GET['filter'] == 'current' ? ' fwver = \'current\' and' : '').
                ($_GET['filter'] == 'stable' ? ' fwver != \'current\' and' : '').
                ($_GET['arch'] == 'i686' ? ' packages.arch = \'i686\' and' : '').
                ($_GET['arch'] == 'x86_64' ? ' packages.arch = \'x86_64\' and' : '').
                (empty($_GET['pkg']) ? '' : ' packages.pkgname = \'' . $_GET['pkg'] . '\' and').
                    // sql-inj attack is defended by rewrite.php:31
                ' packages.uploader_id = uploaders.id group by
                concat(packages.pkgname, packages.arch, fwver) order by
                packages.builddate desc limit
                15';
            $result = $db->doQuery($query);
            while ($i = $db->doFetchRow($result))
            {
                $handle['items'][] = array(
                    "title" => preg_replace("/^([^ ]*) .*/", "$1", $i['name']) . "/${i['pkgname']}-${i['pkgver']}-${i['arch']}",
                    "desc" => $i['desc'],
                    "author" => $i['login']."@nospam.frugalware.org",
                    "pubDate" => date(DATE_RFC2822, $i['unix_timestamp(packages.builddate)']),
                    "guid" => $i['id'] . date(DATE_RFC2822, $i['unix_timestamp(packages.builddate)']),
                    "link" => "http://frugalware.org/packages/${i['id']}"
                );
            }
            $db->doClose();
            break;

        case "news";
            include("xml.inc.php");
            $flang = ( $lang == "en" ) ? "" : "_$lang";
            if (file_exists("xml/news".$flang.".xml"))
                $xmlfile = "xml/news".$flang.".xml";
            else
                $xmlfile = $docs_path."/xml/news".$flang.".xml";
            $xml = file_get_contents($xmlfile);
            $parser = new XMLParser($xml);
            $parser->Parse();
            $encoded = " xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:admin=\"http://webns.net/mvcb/\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"";
            $news = $parser->document->post;
            $handle['title']="Frugalware Linux News";
            $handle['desc']="Latest news of Frugalware Linux.";
            $handle['link']="http://frugalware.org/";
            for ( $i=0; $i<$news_limit; $i++)
            {
                if ( $news[$i]->hidden[0]->tagData == 0 )
                {
                    $handle['items'][] = array(
                        "title"   => $news[$i]->title[0]->tagData,
                        "link"    => "http://www.frugalware.org/news/".$news[$i]->id[0]->tagData,
                        "pubDate" => date(DATE_RFC2822, strtotime($news[$i]->date[0]->tagData)),
                        "desc"    => strip_tags(stripslashes($news[$i]->content[0]->tagData)),
                        "encoded" => str_replace("href=\"/", "href=\"http://frugalware.org/", stripslashes($news[$i]->content[0]->tagData)),
                    );
                }
            }
            break;

        case "security";
            include("xml.inc.php");
            if (file_exists("xml/security.xml"))
                $xmlfile = "xml/security.xml";
            else
                $xmlfile = $docs_path."/xml/security.xml";
            $xml = file_get_contents($xmlfile);
            $parser = new XMLParser($xml);
            $parser->Parse();
            $fsas = $parser->document->fsa;
            $handle['title']="Frugalware Linux Security";
            $handle['desc']="Security announcements for Frugalware stable releases";
            $handle['link']="http://frugalware.org/security";
            for ( $i=0; $i<$news_limit; $i++)
            {
                $handle['items'][] = array(
                    "title" => 'FSA' . $fsas[$i]->id[0]->tagData . ' - ' . $fsas[$i]->package[0]->tagData,
                    "link" => $handle['link']."/".$fsas[$i]->id[0]->tagData,
                    "pubDate" => date(DATE_RFC2822, strtotime($fsas[$i]->date[0]->tagData)),
                    "desc" => preg_replace('/(<a href=.*>|<\/a>)/', '', $fsas[$i]->desc[0]->tagData) . 'Vulnerable version: ' . $fsas[$i]->vulnerable[0]->tagData . ', Unaffected version: ' . $fsas[$i]->unaffected[0]->tagData . ', CVEs: ' . $fsas[$i]->cve[0]->tagData,
                );
            }
            break;

        case "current":
            header('Content-Type: application/xml; charset=utf-8');
            print(file_get_contents("http://git.frugalware.org/gitweb/gitweb.cgi?p=frugalware-current.git;a=rss;opt=--no-merges"));
            die();
        case "stable":
            header('Content-Type: application/xml; charset=utf-8');
            print(file_get_contents("http://git.frugalware.org/gitweb/gitweb.cgi?p=frugalware-stable.git;a=rss;opt=--no-merges"));
            die();
        case "bugs":
            header('Content-Type: application/xml; charset=utf-8');
            //print(str_replace("index.php?do=details&amp;task_id=", "", file_get_contents("http://bugs.frugalware.org/feed.php?feed_type=rss2&project=1")));
            print( file_get_contents( "https://bugs.frugalware.org/report/1?asc=1&format=rss" ) );
            die();
        case "blogs":
            header('Content-Type: application/xml; charset=utf-8');
            print(file_get_contents("http://planet.frugalware.org/feed.php?type=atom"));
            die();
        default:
            include("header.php");

            print "<h2><img src=\"" . $fwng_root . "images/icons/rss.png\" />RSS</h2>";

            fwmiddlebox("Frugalware","<ul class=\"rss\">
                <li>× <a href=\"".$fwng_root."rss/news\">" . gettext('Frugalware news') . "</a><br>
                <em>" . gettext("News about Frugalware developement") . "</em></li>
                <li>× <a href=\"".$fwng_root."rss/releases\">" . gettext('Stable releases') . "</a><br>
                <em>" . gettext("Frugalware stable version release") . "</em></li>
                <li><hr/></li>
                <li>× <a href=\"".$fwng_root."rss/security\">" . gettext('Security announcements') . "</a><br>
                <em>" . gettext("Frugalware security announcement") . "</em></li>
            </ul>");

            fwmiddlebox(gettext("Community"),"<ul>
                <li>× <a href=\"http://planet.frugalware.org/feed.php?type=rss\">Planet</a><br>
                <em>" . gettext("Blogs from community") . "</em></li>
                <ul>
                    <li>× <a href=\"http://planet.frugalware.org/feed.php?type=atom&tribe_id=root-english\">" . gettext('English blogs') . "</a></li>
                    <li>× <a href=\"http://planet.frugalware.org/feed.php?type=atom&tribe_id=root-franyiais\">" . gettext('French blogs') . "</a></li>
                </ul>
            </ul>");

            fwmiddlebox(gettext("Packages"),"<ul class=\"rss\">
                <li>× <a href=\"".$fwng_root."rss/current\">" . gettext('Current branch commits') . "</a><br>
                <em>" . gettext("Packages update for current branch") . "</em></li>
                <li>× <a href=\"".$fwng_root."rss/stable\">" . gettext('Stable branch patches') . "</a><br>
                <em>" . gettext("Packages patches for stable branch") . "</em></li>
                <li>× <a href=\"".$fwng_root."rss/bugs\">" . gettext('BTS entries') . "</a><br>
                <em>" . gettext("Bug tracker feed") . "</em></li>
                <li><hr /></li>
                <li>× <a href=\"".$fwng_root."rss/packages\">" . gettext('Package updates') . "</a><br />
                <em>" . gettext('There is an optional suffix to filter the package parameters: [/&lt;version&gt;[&lt;arch&gt;[&lt;package&gt;]]]. Examples :') . "
                <ul>
                    <li>× Only 64 bits packages for stable branch with <a href=\"/rss/packages/stable/x86_64\">/stable/x86_64</a></li>
                    <li>× Only cups 32 bits release for current branch with <a href=\"/rss/packages/current/i686/cups\">/current/i686/cups</a></li>
                </ul>" . "</em></li>
            </ul>");

            include("footer.php");
            die();
    }

    header('Content-Type: application/xml; charset=utf-8');
    $buf = "";
    $buf .= "<?xml version=\"1.0\" encoding=\"utf-8\"?>
    <rss xmlns:atom=\"http://www.w3.org/2005/Atom\" version=\"2.0\"".$encoded.">
    <channel>
        <title>".$handle['title']."</title>
        <description>".$handle['desc']."</description>
        <link>".$handle['link']."</link>
        <atom:link href=\"".$handle['link']."rss/".$_GET['type']."\" rel=\"self\" type=\"application/rss+xml\" />\n";

    foreach( $handle['items'] as $i )
    {
        $buf .= "<item>\n<title>".$i['title']."</title>\n<link>".$i['link']."</link>\n";
        if(!empty($i['guid'])) {
            $buf .= "<guid>".$i['guid']."#top</guid>\n";
        }
        else {
            $buf .= "<guid>".$i['link']."#top</guid>\n";
        }
        if(isset($i['desc']))
        {
            $buf .= "<description>".htmlspecialchars($i['desc'])."</description>\n";
        }
        if(isset($i['encoded']))
        {
            $buf .= "<content:encoded><![CDATA[".$i['encoded']."]]></content:encoded>\n";
        }
        if(isset($i['author']))
        {
            $buf .= "<author>".$i['author']."</author>\n";
        }
        if(isset($i['pubDate']))
        {
            $buf .= "<pubDate>".$i['pubDate']."</pubDate>\n";
        }
        $buf .= "</item>\n";
    }
    $buf .= "</channel>\n</rss>";
    file_put_contents($path, $buf);
    print($buf);
}

?>
