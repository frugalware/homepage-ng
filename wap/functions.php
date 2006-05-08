<?
include("lastRSS.php");

function first_words($str)
{
	$words = explode(' ', strip_tags($str));
	$words = array_slice($words, 0, 5);
	return(implode(' ', $words) . "...");
}

function display_feed($feed, $param)
{
	$rss = new lastRSS;

	if($feed=="cia")
	{
		if ($feed = $rss->get("http://cia.navi.cx/stats/project/Frugalware/.rss"))
		{
			$lines=array();
			foreach($feed['items'] as $item)
			{
				$lines[] = preg_replace("/.*, (.*) \+.*/", '$1', $item['pubDate']) . "<br />\n";
				// stip the html stuff
				$search = array ('@<script[^>]*?>.*?</script>@si', // strip out javascript
					'@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
      					'@([\r\n])[\s]+@', // Strip out white space
 					'@&(quot|#34);@i', // Replace HTML entities
					'@&(amp|#38);@i',
					'@&(lt|#60);@i',
					'@&(gt|#62);@i',
					'@&(nbsp|#160);@i',
					'@&(iexcl|#161);@i',
					'@&(cent|#162);@i',
					'@&(pound|#163);@i',
					'@&(copy|#169);@i',
					'@&#(\d+);@e'); // evaluate as php

				$replace = array ('',
					'',
					'\1',
					'"',
					'&',
					'<',
					'>',
					' ',
					chr(161),
					chr(162),
					chr(163),
					chr(169),
					'chr(\1)');
				$lines[] = htmlentities(preg_replace($search, $replace,
					html_entity_decode($item['description']))) . "<br />\n";
			}
			include("templates/feed.php");
		}
		else
		{
			$error = "Failed to fetch the feed.";
			include("templates/error.php");
		}
	}
	else if ($feed=="bts")
	{
		if ($feed = $rss->get("http://frugalware.org/rss.php?type=bugs"))
		{
			$lines=array();
			foreach($feed['items'] as $item)
			{
				$lines[] = htmlentities('#' . substr(strrchr($item['link'], "="), 1) .
					" - " . $item['title'] .
					" - " . $item['author']) . "<br />\n";
			}
			include("templates/feed.php");
		}
		else
		{
			$error = "Failed to fetch the feed.";
			include("templates/error.php");
		}
	}
	else if ($feed=="packages")
	{
		if ($feed = $rss->get("http://frugalware.org/rss.php?type=packages"))
		{
			$lines=array();
			foreach($feed['items'] as $item)
			{
				$lines[] = preg_replace("/.*, (.*) \+.*/", '$1', $item['pubDate']) . "<br />\n";
				$lines[] = $item['author'] . ": " . $item['title'] . "<br />\n";
			}
			include("templates/feed.php");
		}
		else
		{
			$error = "Failed to fetch the feed.";
			include("templates/error.php");
		}
	}
	else if ($feed=="blog")
	{
		if ($feed = $rss->get("http://blogs.frugalware.org/xmlsrv/rss2.php?blog=1"))
		{
			$lines=array();
			foreach($feed['items'] as $item)
			{
				$lines[] = preg_replace("/.*, (.*) \+.*/", '$1 ', $item['pubDate']) .
				preg_replace('|http://[^/]*/([^/]+)/.*|', '$1: ', $item['link']) .
				($item['title'] ? $item['title'] : first_words($item['description'])) . "<br />";
			}
			include("templates/feed.php");
		}
		else
		{
			$error = "Failed to fetch the feed.";
			include("templates/error.php");
		}
	}
	else
	{
		$error="No such feed.";
		include("templates/error.php");
	}
}
?>
