<?php

# functions.inc

// Creates a left/right side box
function fwsidebox($boxhead="", $content)
{
	// boxhead is given, displays a simple box with darker head
	if ($boxhead != "")
	{
		print "    <div class=\"boxpadding\">
      <div class=\"boxheader\">
        $boxhead
      </div>
      <div class=\"sidecontent\">
        $content
      </div>
    </div>\n";
	}
	// the opposite, no boxhead
	else
	{
		print "    <div class=\"boxpadding\">
      $content
    </div>\n";
	}
}

// The main content: box of the news
function fwmiddlebox($boxhead="", $content)
{
	if ($boxhead != "")
	{
		print "    <div class=\"boxpadding\">
      <div class=\"boxheader\">
        $boxhead
      </div>
      <div class=\"boxcontent\">
        $content
      </div>
    </div>\n";
	}
	else
	{
		print "    <div class=\"boxpadding\">
      $content
    </div>\n";
	}
}

// Decides the language of the page from cookie, url or former settings
function getlang()
{
	// If the lang comes from cookie, set it...
	if (isset($_COOKIE["fwcurrlang"]))
	{
		$lang=$_COOKIE["fwcurrlang"];
	}

	if (isset($lang) && $lang != "" )
	{
		// $lang is set and not empty
		if (isset($_GET["lang"]) && $_GET["lang"] != "")
		{
			// the lang variable is in the URL, we override the previous setting
			$nlang = $_GET["lang"];
			if ($nlang != $lang)
			{
				// if the previous setting is not the same as the new, we set the new into cookie
				$lang = $nlang;
				setcookie("fwcurrlang", $lang, time()+3*365*24*3600);
			}
		}
	}
	else
	{
		// $lang is not set or empty
		if (isset($_GET["lang"]) && $_GET["lang"] != "")
		{
			// we lang comes from url, we put it into a cookie
			$lang=$_GET["lang"];
			setcookie("fwcurrlang", $lang, time()+3*365*24*3600);
		}
		else
		{
			// we try to decide it
			$lang=preg_replace( "/^([a-z]*)-.*/", "$1",
			preg_replace("/^([a-z\-]*),.*/", "$1", $_SERVER['HTTP_ACCEPT_LANGUAGE']));
		}
	}
	if ( $lang == "" )
	{
		// if the $lang variable is still empty (could not decide), set it to English
		$lang="en";
	}

	return $lang;
}

function getllang($lang)
{
	// gives the complete locale for gettext()
	$langs = array(
		"en" => "en",
		"hu" => "hu_HU"
	);
	return $langs[$lang];
}

?>
