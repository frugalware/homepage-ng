<?php

# functions.inc

function fwsidebox($boxhead="", $content)
{
	if ($boxhead != "")
	{
		print "    <div class=\"boxpadding\">
      <div class=\"boxheader\">
        $boxhead
      </div>
      <div class=\"sidecontent\">
        $content
      </div>
    </div>
    <div class=\"freespace\">&nbsp;</div>\n";
	}
	else
	{
		print "    <div class=\"boxpadding\">
      $content
    </div>\n";
	}
}

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
    </div>
    <div class=\"freespace\">&nbsp;</div>\n";
	}
	else
	{
		print "    <div class=\"boxpadding\">
      $content
    </div>\n";
	}
}

function getlang()
{
	if (isset($_COOKIE["fwcurrlang"]))
	{
		$lang=$_COOKIE["fwcurrlang"];
	}

	if (isset($lang) && $lang != "" )
	{
		if (isset($_GET["lang"]) && $_GET["lang"] != "")
		{
			$nlang = $_GET["lang"];
			if ($nlang != $lang)
			{
				$lang = $nlang;
				setcookie("fwcurrlang", $lang, time()+3*365*24*3600);
			}
		}
	}
	else
	{
		if (isset($_GET["lang"]) && $_GET["lang"] != "")
		{
			$lang=$_GET["lang"];
			setcookie("fwcurrlang", $lang, time()+3*365*24*3600);
		}
		else
		{
			$lang=preg_replace( "/^([a-z]*)-.*/", "$1",
			preg_replace("/^([a-z\-]*),.*/", "$1", $_SERVER['HTTP_ACCEPT_LANGUAGE']));
		}
	}
	if ( $lang == "" )
	{
		$lang="en";
	}

	$langs = array(
		"en" => "en",
		"hu" => "hu_HU"
	);
	return $langs[$lang];
}

?>