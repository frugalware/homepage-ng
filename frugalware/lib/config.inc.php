<?php
#config.inc

## SETTINGS ##

# SQL SETTINGS
$sqltype = "mysql";
$sqlhost = "localhost";
$sqluser = "homepage";
$sqlpass = "85Tdjf{Od";
$sqldb = "frugalware2";

# FWNG SETTINGS
$serverName = $_SERVER["SERVER_NAME"];
$check_www = explode(".", $serverName);

// frugalware.org
if ($check_www[0] != "www")
    // Check if https is available
    $http_mode = ($_SERVER['HTTPS'] == "on" ? 'https' : 'http');

// www.frugalware.org
else
    // This server name is special because it can cause a mixed content error
    // We can't check if https is available, so we use relative path
    $http_mode = "https";

$fwng_root = $http_mode . "://" . $serverName . "/";

$adodb_path = "/usr/share/php";
$trans_path="/home/ftp/pub/other/translations/";
$top_path = "/home/ftp/pub/frugalware/frugalware-current";
$cache_path = "/var/cache/homepage";
$docs_path = $top_path."/docs";
$top_path_stable = "/home/ftp/pub/frugalware/frugalware-stable";
$docs_path_stable = $top_path_stable."/docs";
$news_limit = 5;
$news_list_limit = 25;
$pkgcache = "/tmp/pkgcache.info";
$pkgcachetimeout = 180;
$rsscachetimeout = 900;
$upfile = "/proc/uptime";

# MODIFIABLE VARS
$title = "Frugalware";
$slogan = "Let's make things frugal!";
$copydate = "2003-2018";
$domain = 'homepage';
$defaultMirror = "ie"; // Ireland

## MAIN PAGE ##

# MENU
include("xml.inc.php");

// Find where the XML menu file is
if (file_exists('xml/menu.xml'))
    $xmlm = 'xml/menu.xml';
else
    $xmlm = $docs_path.'xml/menu.xml';

$xml = file_get_contents($xmlm);
$parser = new XMLParser($xml);
$parser->Parse();
$menu = $parser->document->menu;

// Generate the menu
$menucontent = "<ul id=\"menu\">\n";
for ( $i = 0; $i < count($menu); $i++) {

    // Check if the menu have submenus
    if (isset($menu[$i]->submenus[0]->tagData)) {

        $menucontent .= "\t\t\t<li><a>" . gettext($menu[$i]->_link[0]->tagData) . "</a>\n";

        $menucontent .= "\t\t\t\t<ul>\n";
        // Get all the submenus
        for ($j = 0; $j < count($menu[$i]->submenus[0]->_sublink); $j++) {

            // Check if this is an empty sublink
            if (!empty($menu[$i]->submenus[0]->_sublink[$j]->tagData)) {
                // It's a submenu
                $checkUrl = explode("://", $menu[$i]->submenus[0]->_sublink[$j]->tagAttrs['url']);
                $menuUrl = $fwng_root;
                if ($checkUrl[0] == "https" || $checkUrl[0] == "ftp" || $checkUrl[0] == "http")
                    $menuUrl = "";

                $menucontent .= "\t\t\t\t\t<li><a href=\"" . $menu[$i]->submenus[0]->_sublink[$j]->tagAttrs['url'] . "\">" . gettext($menu[$i]->submenus[0]->_sublink[$j]->tagData) . "</a></li>\n";
            }
            else
                // It's a <hr />
                $menucontent .= "\t\t\t\t\t<li><hr /></li>\n";
        }
        $menucontent .= "\t\t\t\t</ul>\n\t\t\t</li>\n";
    }
    else {
        $checkUrl = explode("://", $menu[$i]->submenus[0]->_sublink[$j]->tagAttrs['url']);
        $menuUrl = $fwng_root;
        if ($checkUrl[0] == "https" || $checkUrl[0] == "ftp" || $checkUrl[0] == "http")
            $menuUrl = "";

        $menucontent .= "\t\t\t<li><a href=\"" . $menu[$i]->_link[0]->tagAttrs['url'] . "\">" . gettext($menu[$i]->_link[0]->tagData) . "</a></li>\n";
    }
}
$menucontent .= "\t\t</ul>\n";

# LANG
if($_SERVER["PHP_SELF"]=="/index.php")
    $langpage = $fwng_root;
else
{
    $arr = explode("/", substr($_SERVER["PHP_SELF"], 1));
    $arr = explode(".", $arr[count($arr) - 1]);
    $langpage = $fwng_root . $arr[0] . "/";
}

$langcontent = "\t\t\t<a href=\"" . $langpage . "en\" title=\"English\">En</a>\n";
// $langcontent .= "\t\t\t<a href=\"" . $langpage . "hu\" title=\"Hungarian\">Hu</a>\n";
$langcontent .= "\t\t\t<a href=\"" . $langpage . "fr\" title=\"French\">Fr</a>\n";
// $langcontent .= "\t\t\t<a href=\"" . $langpage . "sk\" title=\"Slovak\">Sk</a>\n";
// $langcontent .= "\t\t\t<a href=\"" . $langpage . "ru\" title=\"Russian\">Ru</a>\n";
// $langcontent .= "\t\t\t<a href=\"" . $langpage . "da\" title=\"Danish\">Da</a>\n";
// $langcontent .= "\t\t\t<a href=\"" . $langpage . "cs\" title=\"Czesh\">Cs</a>\n";
$langcontent .= "\t\t\t<a href=\"" . $langpage . "es\" title=\"Spanish\">Es</a>\n";
$langcontent .= "\t\t\t<a href=\"" . $langpage . "it\" title=\"Italian\">It</a>\n";
// $langcontent .= "\t\t\t<a href=\"" . $langpage . "de\" title=\"German\">De</a>\n";

?>
