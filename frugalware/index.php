<?php

#homepage-ng: startpage

include("functions.inc.php");

$lang = getlang();
$llang = getllang($lang);
$flang = ( $lang == "en" ) ? "" : "_$lang";
$xmlfile = "xml/news".$flang.".xml";

putenv("LANG=".$llang);
setlocale(LC_ALL,$llang);
$domain = 'messages';
bindtextdomain($domain, "locale");
textdomain($domain);

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

include("xml.inc.php");

if (file_exists($xmlfile))
{
	$xml = file_get_contents($xmlfile);
	$parser = new XMLParser($xml);
	$parser->Parse();
	$news = $parser->document->post;
	for ( $i=0; $i<count($parser->document->post); $i++)
	{
		$posts[$i][title] = $news[$i]->title[0]->tagData;
		$posts[$i][date] = $news[$i]->date[0]->tagData;
		$posts[$i][author] = $news[$i]->author[0]->tagData;
		$posts[$i][content] = trim($news[$i]->content[0]->tagData);
	}
	for( $i=0; $i<count($posts); $i++ )
	{
		fwmiddlebox($posts[$i][title], "<div align=\"right\"><small>".$posts[$i][date]."<br />".gettext("posted by")." ".$posts[$i][author]."</small></div>\n<div align=\"justify\">\n".$posts[$i][content]."\n</div>");
	}
}
else
{
	fwmiddlebox("Webpage Reloaded", "<div align=\"justify\">This will be the new webpage of Frugalware Linux, with many new things. This site is totally table-free, uses only css. Please write me your comment to the frugalware-devel or the frugalware-users mailing list.<br />Thanks:<br />IroNiQ</div>");
}
?>
	</div>

</div>
<!-- main content end -->

<?php
include("footer.php");
?>
