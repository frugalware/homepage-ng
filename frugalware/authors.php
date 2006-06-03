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
 * Frugalware Linux Homepage - Authors' page
 *
 * @author Krisztian VASAS <iron@frugalware.org>
 * @copyright Copyright (c) 2006. Krisztian VASAS
 */

// include some useful functions and the config
include("functions.inc.php");
include("config.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
putenv("LANG=".$llang);
setlocale(LC_ALL,$llang);
$domain = 'messages';
bindtextdomain($domain, "locale");
textdomain($domain);

// let's start page
include("header.php");

include("xml.inc.php");
$who = ($_GET['who'] != "") ? $_GET['who'] : "devel";

switch($who)
{
	case "devel":
		if (file_exists("xml/authors.xml"))
			$xmlfile = "xml/authors.xml";
		else
			$xmlfile = $docs_path."/xml/authors.xml";
		$xml = file_get_contents($xmlfile);
		$parser = new XMLParser($xml);
		$parser->Parse();
		$authors = "";
		for ( $i=0; $i<count($parser->document->author); $i++)
		{
			$email = str_replace("@", " at ", $parser->document->author[$i]->email[0]->tagData);
			$email = str_replace(".", " dot ", $email);
			$authors .= $parser->document->author[$i]->name[0]->tagData." (".$parser->document->author[$i]->nick[0]->tagData.") &lt;".$email."&gt;<br />\n<ul>\n";
			for ( $j=0; $j<count($parser->document->author[$i]->role); $j++ )
			{
				$authors.= "<li>".$parser->document->author[$i]->role[$j]->tagData."</li>\n";
			}
			$authors .= "</ul>\n";
		}
		$authors .= "<br />\n";
		$title = gettext("Developers");
		break;

	case "contrib";
		if(file_exists("xml/contributors.xml"))
			$xmlfile = "xml/contributors.xml";
		else
			$xmlfile = $docs_path."/xml/contributors.xml";
		$xml = file_get_contents($xmlfile);
		$parser = new XMLParser($xml);
		$parser->Parse();
		$authors = "";
		for ( $i=0; $i<count($parser->document->author); $i++)
		{
			$email = str_replace("@", " at ", $parser->document->author[$i]->email[0]->tagData);
			$email = str_replace(".", " dot ", $email);
			$authors .= "<p>\n".$parser->document->author[$i]->name[0]->tagData." (".$parser->document->author[$i]->nick[0]->tagData.") &lt;".$email."&gt;<br>\n<ul>\n";
			for ( $j=0; $j<count($parser->document->author[$i]->role); $j++ )
			{
				$authors.= "<li>".$parser->document->author[$i]->role[$j]->tagData."</li>\n";
			}
			$authors .= "</ul>\n</p>\n";
		}
		$title = gettext("Contributors");
		break;
}
fwmiddlebox($title, $authors);

include("footer.php");
?>
