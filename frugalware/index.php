<?php

#homepage-ng: startpage

// include some useful functions
include("functions.inc.php");

$lang = getlang();
$llang = getllang($lang);
$flang = ( $lang == "en" ) ? "" : "_$lang";
$xmlfile = "xml/news".$flang.".xml";

// set the locale settings for gettext
putenv("LANG=".$llang);
setlocale(LC_ALL,$llang);
$domain = 'messages';
bindtextdomain($domain, "locale");
textdomain($domain);

// include the config and let's start page
include("config.inc.php");
include("header.php");

?>

<!-- main content start -->
<div id="columns">
	<div id="leftcolumn">
<?php
fwsidebox(gettext("Menu"), $menucontent);
fwsidebox(gettext("Languages"), $langcontent);
?>
	</div>

	<div id="rightcolumn">
<?php
fwsidebox(gettext("Information"), $validcontent);
?>
	</div>

	<div id="centercolumn">
<?php

// This includes the news.xml XML parser
include("xml.inc.php");

// Let's see whether the news file exist or not
if (file_exists($xmlfile))
{
	// Yes, exist. Let's start parsing it...
	$xml = file_get_contents($xmlfile);
	$parser = new XMLParser($xml);
	$parser->Parse();
	$news = $parser->document->post;
	// I hata writing a lot. And also the parser creates too long and unuseful object hierarchy
	// so create a better-readable one.
	// TODO: handle the editedby fields
	for ( $i=0; $i<count($news); $i++)
	{
		$posts[$i][title] = $news[$i]->title[0]->tagData;
		$posts[$i][date] = $news[$i]->date[0]->tagData;
		$posts[$i][author] = $news[$i]->author[0]->tagData;
		$posts[$i][content] = trim($news[$i]->content[0]->tagData);
	}
	// Let's write out the news in separate boxes.
	// TODO: clicking on the title the page shows the history of the news (editedby)
	for( $i=0; $i<count($posts); $i++ )
	{
		fwmiddlebox($posts[$i][title], "<div align=\"right\"><small>".$posts[$i][date]."<br />".gettext("posted by")." ".$posts[$i][author]."</small></div>\n<div align=\"justify\">\n".$posts[$i][content]."\n</div>");
	}
}
else
{
	// The xml file doesn't exist, write out a template text...
	fwmiddlebox("Webpage Reloaded", "<div align=\"justify\">This will be the new webpage of Frugalware Linux, with many new things. This site is totally table-free, uses only css. Please write me your comment to the frugalware-devel or the frugalware-users mailing list.<br />Thanks:<br />IroNiQ</div>");
}
?>
	</div>

</div>
<!-- main content end -->

<?php
include("footer.php");
?>
