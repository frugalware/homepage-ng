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
 * extra functions to the homepage
 *
 * @author Krisztian VASAS <iron@frugalware.org>
 * @copyright Copyright (c) 2006. Krisztian VASAS
 */

/**
 * Creates a left/right side box
 *
 * @param string $boxhead
 * @param string $content
 */
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

/**
 * The main content: box of the news
 *
 * @param string $boxhead
 * @param string $content
 */
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

/**
 * Decides the language of the page from cookie, url or former settings
 */
function getlang($forcelanguage="")
{
	global $fwng_root;

	// If the lang comes from cookie, set it...
	if (isset($_COOKIE["fwcurrlang"]))
	{
		$lang=$_COOKIE["fwcurrlang"];
	}

	if (isset($lang) && $lang != "" )
	{
		// $lang is set and not empty
		if ((isset($_GET["lang"]) && $_GET["lang"] != "") or ($forcelanguage!=""))
		{
			// the lang variable is in the URL, we override the previous setting
			$nlang = $_GET["lang"];
			if($forcelanguage!="")
				$nlang=$forcelanguage;
			if ($nlang != $lang)
			{
				// if the previous setting is not the same as the new, we set the new into cookie
				$lang = $nlang;
				setcookie("fwcurrlang", $lang, time()+3*365*24*3600, $fwng_root);
			}
		}
	}
	else
	{
		// $lang is not set or empty
		if ((isset($_GET["lang"]) && $_GET["lang"] != "") or ($forcelanguage!=""))
		{
			// we lang comes from url, we put it into a cookie
			$lang=$_GET["lang"];
			if($forcelanguage!="")
				$lang=$forcelanguage;
			setcookie("fwcurrlang", $lang, time()+3*365*24*3600, $fwng_root);
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

/**
 * gives the complete locale for gettext()
 *
 * @param string $lang
 */
function getllang($lang)
{
	$langs = array(
		"en" => "en_US",
		"hu" => "hu_HU"
	);
	return $langs[$lang];
}

function getnlang($lang)
{
	$nlangs = array(
		"en_US" => "English",
		"hu_HU" => "Hungarian"
	);
	return $nlangs[$lang];
}

?>
