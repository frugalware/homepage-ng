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

if (defined("functions.inc"))
    return;
define("functions.inc", 1);

include("config.inc.php");

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
        print "
            <div id=\"sidebar\">
                <h2>" . $boxhead . "</h2>
                <div class=\"content\">
                    " . $content . "
                </div>
            </div>\n";
    // the opposite, no boxhead
    else
        print "<div class=\"sideboxpadding\">" . $content . "</div>\n";
}

/**
 * The main content: box of the news
 *
 * @param string $boxhead
 * @param string $content
 */

// Show the language icons on the top right corner
function fwlangbox($content)
{
    print " <div id=\"lang\">\n" . $content . "\t\t</div>\n";
}

// Function to show a nice name for screenshot
function NiceName($file)
{
    $name = preg_replace("/\.[^$]*/", "", $file);

    $name = str_replace("_", " by ", $name);

    return $name;
}


// Show a short Frugalware presentation in the index page
function showAbout ($content, $showScreenshot=true)
{
    global $fwng_root;

    print "
            <div class=\"about\">";

    if ($showScreenshot)
    {
        print "
                <div id=\"slideshow\" align=\"center\">";

        if ($screenshot_dir = opendir("images/users_screenshots/"))
        {

            print '
                    <ul>
                        <li>
                            <a id="imagebox" href="'.$fwng_root.'images/official_background.jpg"><img rel="fancybox" src="'. $fwng_root . 'images/data/official_background.jpg" title="Let\'s make things frugal!" /></a>
                        </li>';
            while (false !== ($file = readdir($screenshot_dir)))
            {
                if ($file != '.' && $file != '..' && $file != 'thumbnails' && $file != 'README') {
                    print '
                        <li>
                            <a id="imagebox" href="'.$fwng_root.'images/users_screenshots/'.$file.'"><img rel="fancybox" src="'. $fwng_root . 'images/users_screenshots/thumbnails/'.$file.'" title="'.NiceName($file).'" /></a>
                        </li>';
                }
            }
            print "
                    </ul>";
        }
        print "
                </div>";
    }
    print $content . "
            </div>";
}

// Show a simple box
function fwmiddlebox($boxhead="", $content)
{
    if ($boxhead != "")
        print "\t<div class=\"middleheader\">" . $boxhead . "</div>\n\t\t<div class=\"middlebox\">\n\t\t\t" . $content . "\n\t\t</div>";
    else
        print "<div class=\"middlebox\">" . $content . "</div>\n";
}

// Show a simple box without border
function fwemptybox($boxhead="", $content)
{
    if ($boxhead != "")
        print "\t<h2>" . $boxhead . "</h2>\n\t\t<div class=\"emptybox\">\n\t\t\t" . $content . "\n\t\t</div>";
    else
        print "<div class=\"emptybox\">" . $content . "</div>\n";
}


// Show a simple box without border
function fwauthorbox($content)
{
    print "<div class=\"authorbox\">" . $content . "</div>\n";
}

// Show a screen box without border
function fwscreenbox($boxhead="", $content)
{
    if ($boxhead != "")
        print "\t<h2>" . $boxhead . "</h2>\n\t\t<div class=\"screenbox\">\n\t\t\t" . $content . "\n\t\t</div>";
    else
        print "<div class=\"screenbox\">" . $content . "</div>\n";
}

// Show a roadmap box
function fwroadbox($title, $definition, $content, $id)
{
    print "\t<div class=\"middleheader\"";

    if ($id > 0)
        print " style=\"font-size: 10px;\"";

    print ">" . $title . "</div>\n\t\t
    <div id=\"roaddefinition\">" . $definition . "</div>
    <div id=\"road" . $id . "\" ";

    if ($id > 0)
        print "style=\"display: none;\"";

    print ">\n\t\t<div class=\"middlebox\">\n\t\t\t" . $content . "\n\t\t</div>\n\t</div>\n";
}

// Show a new box
function showNew ($post, $id, $hide=false)
{
    if (isset($post['title']) and !empty($post['title']))
    {
        $hideMode = ( $hide == false ) ? "" : "style=\"display: none;\"";

        print "<h3>" . $post['title'] . "</h3>
        <article>
            <h4>" . $post['date'] . " - " . gettext("Posted by") . " " . $post['author'] . "</h4>
            <div id=\"new" . $id . "\" " . $hideMode . ">
                <p>" . $post['content'] . "</p>
            </div>
        </article>";
    }
    else
    {
        print "<article>
            <h4>" . $post['date'] . " - " . gettext("Posted by") . " " . $post['author'] . "</h4>
            <p>" . $post['content'] . "</p>
        </article>";
    }
}

function showListNews ($post)
{
    global $fwng_root;

    print "<tr>
        <td><img src=\"" . $post['icon'] . "\" /></td><td><a href=\"" . $fwng_root . "news/" . $post['id'] . "\">" . $post['title'] . "</a></td><td>" . $post['date'] . "</td><td>" . $post['author'] . "</td>
    </tr>";
}


function showGetWidget ($mode, $version, $number, $date, $id, $mirror)
{
    $archs = array("32", "64");
    $devices = array("CD", "DVD");

    if ($mode == "stable")
        $title = gettext("Stable version");
    else if ($mode == "current")
        $title = gettext("Development version");

    $ftp = false;
    $http = false;
    for($i = 0; $i < count($mirror->type); $i++)
    {
        if ($mirror->type[$i]->tagData == "ftp")
            $ftp = true;
        if ($mirror->type[$i]->tagData == "http")
            $http = true;
    }

    $dlpath = $id.".".$mirror->link[0]->tagData."/".$mirror->path[0]->tagData;

    if ($ftp)
        $sha1sums = "<a href=\"ftp://ftp".$dlpath."/frugalware-".$mode."-iso/SHA1SUMS\">SHA1SUMS</a>";

    $text = "
                    <h3>" . $title . " - " . $version . "</h3>
                    <h4>" . gettext("Released on") . " " . $date . " - " . $sha1sums . "</h4>
                    <div id=\"dllists\">";

    // Architecture
    foreach ($archs as $arch)
    {
        if ($arch == "32")
            $dlarch = "-i686";
        else if ($arch == "64")
            $dlarch = "-x86_64";

        $text .= "
                        <div class=\"dllist\">
                            <h6>" . $arch . "bits</h6>
                            <ul>";

        // Device
        foreach ($devices as $device)
        {
            if ($device == "CD")
                $dldevice = "-basic";
            else if ($device == "DVD")
                $dldevice = "-full";

            $text .= "
                                    <li>" . $device . " ";

            // FTP
            if ($ftp)
                $text .= "<a href=\"ftp://ftp".$dlpath."/frugalware-".$mode."-iso/fvbe-".$number.$dldevice.$dlarch.".iso\">ftp</a>";

                // If we have both dl system, add a separator
                if ($http)
                    $text .= "/";

            // HTTP
            if ($http)
                $text .= "<a href=\"http://www".$dlpath."/frugalware-".$mode."-iso/fvbe-".$number.$dldevice.$dlarch.".iso\">http</a>";

            $text .= "
                                    </li>";
        }

        $text .= "
                            </ul>
                        </div>\n";
    }

    $text .= "
                    </div>";

    return $text;
}

/**
 * Decides the language of the page from cookie, url or former settings
 */
function getlang($forcelanguage="")
{
    global $fwng_root, $trans_path;

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

    // now update the .mo file from the .po one
    $po = $trans_path."po/homepage/$lang/homepage.po";
    if(file_exists($po))
        $poinfo = stat($po);
    $llang = getllang($lang);
    if(!file_exists("locale/$llang/LC_MESSAGES"))
        mkdir("locale/$llang/LC_MESSAGES", 0755, true);
    $mo = "locale/$llang/LC_MESSAGES/homepage.mo";
    if(file_exists($mo))
        $moinfo = stat($mo);
    if(isset($poinfo) and $poinfo["mtime"] > $moinfo["mtime"])
        system("msgfmt -o $mo $po &>/dev/null");

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
        "fr" => "fr_FR",
        "hu" => "hu_HU",
        "pl" => "pl_PL",
        "sk" => "sk_SK",
        "ru" => "ru_RU",
        "da" => "da_DK",
        "cs" => "cs_CZ",
        "tr" => "tr_TR",
        "es" => "es_ES",
        "it" => "it_IT",
        "de" => "de_DE"
    );
    return $langs[$lang];
}

function getnlang($lang)
{
    $nlangs = array(
        "en_US" => "English",
        "fr_FR" => "French",
        "hu_HU" => "Hungarian",
        "pl_PL" => "Polish",
        "sk_SK" => "Slovak",
        "ru_RU" => "Russian",
        "da_DK" => "Danish",
        "cs_CZ" => "Czech",
        "tr_TR" => "Turkish",
        "es_ES" => "Spanish",
        "it_IT" => "Italian"
    );
    return $nlangs[$lang];
}

function set_locale($lang, $domain)
{
    putenv("LANG=".$lang.".utf8");
    setlocale(LC_ALL,$lang.".utf8");
    bindtextdomain($domain, "locale");
    textdomain($domain);
}

function is_in_file( $str, $fname )
{
    $fl = file_get_contents( $fname );
    if ( stristr( $fl, $str ) === FALSE )
    {
        return false;
    }
    else
    {
        return true;
    }
}

?>
