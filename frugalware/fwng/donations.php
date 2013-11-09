<?

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
 * Frugalware Linux Homepage - Donations page
 *
 * @author Krisztian VASAS <iron@frugalware.org>
 * @author Miklos Vajna <vmiklos@frugalware.org>
 *
 * @copyright Copyright (c) 2006. Krisztian VASAS
 * @copyright Copyright (c) 2005-2006. Miklos Vajna
 */

// include some useful functions
include("lib/functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

// include the config and let's start page
include("lib/config.inc.php");
include("header.php");

$fwdonatewelcome = gettext("Donations are a great way to show your appreciation
and support for Frugalware Linux. On this page we list the donations we have
received so far and those that would help us in our work on Frugalware Linux.;
If you have a piece of hardware or something whose Frugalware support could be
improved, a good way to achieve this is to donate it to a developer.<br /><br />
If you would like to donate something to the whole project (i.e. a mirror),
please send a mail to the <a href=\"http://frugalware.org/mailman/listinfo/frugalware-devel\">frugalware-devel</a>
list, or if you do not wish to subscribe, send a mail directly to vmiklos_at_frugalware_dot_org.
If you wish to donate something to an individual developer, see the <a href=\"/authors\">authors</a>
page and send the developer a mail. You can also use the PayPal donate link on the side of the page
if you wish to donate money.");

fwemptybox("<img src=\"" . $fwng_root . "images/icons/donation.png\" />" . gettext("Donations"), $fwdonatewelcome);

$fwadvert = '<a href="http://www.flosszine.org"><img src="images/data/flosszine_logo.png" border="0"/><br/>Hungarian online fanzine</a>';

fwmiddlebox( gettext( 'Advertisers' ), $fwadvert );

$cont1 = "Received:<ul>
<li>Socket939 Motherboard + AMD Athlon64 3000+ CPU Socket939 version + 512MB DDR400 RAM (x86_64 buildserver)</li>
<li>Socket939 Motherboard + AMD Athlon64 3000+ CPU Socket939 version + 1GB DDR400 RAM (main server)</li>
<li>Codegen case for the new x86_64 buildserver (Krisztian VASAS)</li>
<li>i586 Server: Pentium MMX 200 Mhz CPU, 64 Mb memory, 2.8Gb + 37Gb HDD (Botond Balazs, Miklos Vajna)</li>
<li>Main server hosting (Sandor Szentirmay)</li>
<li>Hungarian mirrors: inflame.hu, linuxforum.hu, FSN.hu</li>
<li>European mirrors: belnet.be</li>
<li>Asian mirror: Taipei City, Taiwan (National Taiwan University, cle.linux.org.tw)</li>
<li>i686 Server: Pentium III (Coppermine) 600 Mhz, 256 Mb memory (the developer team)</li>
<li>i686 build server: Pentium II (Deschutes) 300 Mhz, 384 Mb memory</li>
<li>i686 build server hosting</li>
<li>Advertising: linuxuser.hu, linuxlinks.com</li>
<li>2x40GB IDE HDD (Szalai, Ervin)</li>
<li>2x160GB IDE HDD for the i686 server (Miklos Vajna)</li>
<li>40GB IDE HDD (Kovacs, Janos)</li>
<li>Dell Optiplex P4 1.6GHz machine for main server - changed to i686 buildserver</li>
<li>Mylex DAC960 SCSI card with 2x18GB HDD (will be the base system of our x86_64 buildserver) (from Locsei, Gabor)</li>
<li>60GB Western Digital IDE HDD (from Michael Loomis)</li>
</ul>";
fwmiddlebox(gettext("The Frugalware Team"), $cont1);

$cont2 = "Received:<ul>
<li>Ati video card for fglrx package testing (David Kimpe)</li>
</ul>";
fwmiddlebox("Andras Voroskoi", $cont2);

$cont3 = "<div align=\"left\">Received:<ul>
<li>256MB extra memory to my notebook (Janos Kovacs)</li>
</ul></div>";
fwmiddlebox("Miklos Vajna", $cont3);

$cont4 = "<ul>
    <li>Arpad Bakos</li>
    <li>Balazs Dianiska</li>
    <li>Francois Biot</li>
    <li>Sebastien Mazzucco</li>
    <li>Distrowatch.com</li>
    <li>Marius Cirsta</li>
    <li>Jean-Pierre Le Leyzour</li>
    <li>Mario Bonasoro</li>
    </ul>";
fwmiddlebox("Monetary donations", $cont4);

include("footer.php");
?>
