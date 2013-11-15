<!DOCTYPE html>

<?php
    include("lib/header.inc.php");
    $data = genHeader();

    $rsspath = $_SERVER["SERVER_NAME"] . $fwng_root;
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">

<head>

    <title><?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Frugalware Linux, a general purpose linux distribution, designed for intermediate users."/>
    <meta name="viewport" content="width=device-width; initial-scale=1.0;">
    <link rel="icon" href="<?php echo $fwng_root; ?>images/favicon.ico" />

    <!-- RSS -->
    <link rel="alternate" type="application/rss+xml" title="Frugalware news" href="<?php print $myurl; ?>rss/news" />
    <link rel="alternate" type="application/rss+xml" title="Frugalware packages" href="<?php print $myurl; ?>rss/packages" />

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $fwng_root; ?>static/css/common.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $fwng_root; ?>static/css/common_medium.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $fwng_root; ?>static/css/common_mobile.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $fwng_root; ?>static/css/craftyslide.css" />

    <link rel="stylesheet" href="<?php echo $fwng_root; ?>static/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

    <!-- JavaScript -->
    <script type="text/javascript" src="<?php echo $fwng_root; ?>static/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $fwng_root; ?>static/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo $fwng_root; ?>static/js/craftyslide.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("a#imagebox").fancybox();
            $("#slideshow").craftyslide({
                'pagination': false,
                'fadetime': 600,
                'delay': 6000});
        });
    </script>

    <script type="text/javascript">
        /* <![CDATA[ */
        (function() {
            var s = document.createElement('script'), t = document.getElementsByTagName('script')[0];
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'http://api.flattr.com/js/0.6/load.js?mode=auto';
            t.parentNode.insertBefore(s, t);
        })();
        /* ]]> */

        function toggle_div(bouton,id,mode) {
            var div=document.getElementById(id);
            if(div.style.display=="none") {
                div.style.display="block";
                if (mode == 1)
                    bouton.innerHTML="<img src=\"<?php echo $fwng_root; ?>images/icons/less.png\" class=\"moreandless\" />";
            } else {
                div.style.display="none";
                if (mode == 1)
                    bouton.innerHTML="<img src=\"<?php echo $fwng_root; ?>images/icons/more.png\" class=\"moreandless\" />";
            }
        }
        function toggle_complete(bouton,id) {
            var div=document.getElementById(id);
            if(div.style.display=="none") {
                div.style.display="block";
                bouton.innerHTML="";
            }
        }
    </script>

</head>

<body>

    <!-- HEADER -->
    <header>
        <a href="<?php echo $fwng_root; ?>">
            <img src="<?php echo $fwng_root; ?>images/frugalware.png" />
            <span class="title"><?php echo $title; ?></span>
            <span class="slogan"><?php echo $slogan; ?></span>
        </a>
    </header>

    <!-- MENU -->
    <nav>
        <?php echo $menucontent; ?>
    </nav>

    <!-- MAIN CONTENT -->
    <div id='wrapper'>
        <?php fwlangbox($langcontent); ?>

        <aside id="rightcolumn">
            <?php
                // Get Frugalware
                fwsidebox(gettext("Get Frugalware"), $data['download']);

                // Packages
                fwsidebox("<a href=\"${fwng_root}rss/releases\"><img src=\"images/icons/rss.png\" width=\"16\" alt=\"\" /></a> " . gettext("Recent updates"), $data['packages']);

                // IRC
                fwsidebox(gettext("IRC"), $data['irc']);

                // Social
                fwsidebox(gettext("Social"), $data['socialnetworks']);

                // Donations
                if ($data['paypal'] != '')
                    fwsidebox(gettext("Donations"), $data['paypal']);
            ?>
        </aside>

        <div id="centercolumn">
