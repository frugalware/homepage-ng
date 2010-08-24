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
 * Frugalware Linux Homepage - About (summary) page
 *
 * @author Krisztian VASAS <iron@frugalware.org>
 * @author Miklos Vajna <vmiklos@frugalware.org>
 *
 * @copyright Copyright (c) 2006. Krisztian VASAS
 * @copyright Copyright (c) 2005-2006. Miklos Vajna
 */

// include some useful functions
include("functions.inc.php");

$lang = getlang();
$llang = getllang($lang);

// set the locale settings for gettext
$domain = "homepage";
set_locale($llang, $domain);

// FIXME: use docs/about.txt as a source instead of this one

$fwshortabout = gettext("Frugalware is a general purpose linux distribution, designed for intermediate users (who are not afraid of text mode).");
$fwabout= array (
	array (gettext("What branches does Frugalware have?"), 
		gettext("We have a <i>current</i> and a <i>stable</i> branch. The <i>current</i> branch is updated daily, and we update our <i>stable</i> branch around every 6 months.")), 
	array (gettext("What is &quot;The Frugalware Philosophy&quot; about?"),
		gettext("Briefly: simplicity, multimedia, design. We try to make Frugalware as simple as possible while not forgetting to keep it comfortable for the user. We try to ship fresh and stable software, as close to the original source as possible, because in our opinion most software is the best as is, and doesn't need patching.")),
	array (gettext("What is the license of Frugalware?"), 
		gettext("That's two questions. Most software included in Frugalware have a GPL or BSD compatible license, for more information about a license of a specific package, refer to the LICENSE or COPYRIGHT file in the source tarball of the package. On the other hand, the part written by our team (FrugalBuild scripts, setup, homepage, etc) is released under GPL license. To make it even more complicated, some parts of the setup and init scripts are written by Patrick J. Volkerding. We GPL our additions, but Patrick J. Volkerding's code is still under the BSD license. For more information, refer to the COPYRIGHT file in the root directory of the FST (Frugalware Source Tree).")),
	array (gettext("What package manager does Frugalware use?"),
		gettext("We don't have our own package manager, we use Judd Vinet's great work, the <a href=\"http://www.archlinux.org/pacman\">pacman</a> package manager. It's a tar.bz2 based package manager, similar to Slackware's .tgz. Our packages' extension is .fpm to differentiate them from regular tarballs. Unlike Slackware's scripts, pacman is written in C, so it's much faster.")),
	array (gettext("How does Frugalware manage updating obsolete packages?"),
		gettext("We don't have any standalone program for updating packages as pacman manages this task too. To update your package database, use <tt>pacman&nbsp;-Sy</tt>, and to update your packages according the just synchronized package database, you use <tt>pacman&nbsp;-Su</tt>. To install a package with the necessary dependencies directly from a mirror ftp server, you issue <tt>pacman&nbsp;-S&nbsp;foo</tt>. For more information, refer to the pacman man page.")),
	array (gettext("Is there any community support available for Frugalware?"),
		gettext("Currently we have three mailing lists, an irc channel and forums that can be used to communicate with us or other users and to get help. The irc channel is on the Freenode network (server: irc.freenode.net). For more information about our mailing lists, please refer to the <a href=\"mailman/listinfo\">list section</a> of our web site.")),
	array (gettext("Is there any commercial support available for Frugalware?"),
		gettext("No, there isn't for now, and <i>currently</i> it isn't planned, either.")),
	array (gettext("For whom is Frugalware recommended to use?"),
		gettext("Frugalware is designed for intermediate users. Installing Frugalware is not a magic, of course, but you should know what a partition, an MBR (Master Boot Record), etc. is.")),
	array (gettext("How to become a developer?"),
		gettext("Get involved! :) If you installed Frugalware from CDs, get the full FST via repoman, which is available in pacman-tools. The sources are included in the DVD edition. Then start to play with the FrugalBuild scripts, for a typical example, refer to the <a href=\"/packages/44\">cabextract</a> package. Try to improve them, or write a new one for a currently unsupported program. Then send your patches to the <a href=\"mailman/listinfo/frugalware-devel\">devel</a> mailing list. From this point everything will come naturally to you :)")),
	array (gettext("What do developers do?"),
		gettext("In short, what they want to, if they play a square game. They may maintain packages: building them if a newer version is available and update the FrugalBuild scripts to work correctly against a newer version. They can contribute a new build script to a previously non-existent package. They can write articles about Frugalware, or anything else in connection with the Frugalware community. If you only want to help us, but you don't want to hack, you may help in translating Frugalware to your or other language. And, of course, we happily accept <a href=\"/donations\">donations</a>. :) More on this <a href=\"/docs/getting-involved#_further_options_for_those_who_have_developer_account_packagers_coders\">here</a>.")),
	array (gettext("Who develops Frugalware?"),
		gettext("A young group, but your age is not conditional to become a developer")),
	array (gettext("Is Frugalware specialized in a certain purpose?"),
		gettext("No, it's a general purpose distribution, for desktops and servers.")),
	array (gettext("Do you plan to release a live cd?"),
		gettext("Well, we have already a live cd, called FwLive. Currently it supports only i686, but an x86_64 version is also under development. You can find it in the standard release directories.")),
	array (gettext("Does Frugalware support languages other than English?"),
		gettext("Yes, it supports all languages supported by the packages. If the init scripts or the setup is not available in your language, then it simply means it haven't yet translated.")),
	array (gettext("What about Asian languages?"),
		gettext("Yes you just have to switch to UTF-8 encoding.")),
	array (gettext("What architectures does Frugalware support?"),
		gettext("Currently we support x86, x86_64 and ppc platforms, and inside x86, only i686 (Pentium Pro or higher instruction set), inside x86_64 only k8 (amd64) and inside ppc only PowerPC. If there are any claims, an i386 port will be created, but currently we don't have resources to build and maintain those packages. Outside x86, currently we don't have any non-x86 hardware, but happily accept such patches or any effort to create non-x86 optimized packages.")),
	array (gettext("How are compressed the Frugalware packages?"),
		gettext("FPM packages were originally .tar.gz packages, then a bit later we migrated to libarchive, which allowed bzip2 compression. Life was good, but then lzma was came, and I added support for libarchive, though others were not really interested in a migration, so we stick to .tar.bz2. A few months ago libarchive got support for the xz format (which is the successor of lzma), so we switched to it. pacman-g2 still
support .tar.gz and .tar.bz2 as well, and the package extension is .fpm all the time to make it clear that it's a Frugalware package"))
	);

// include the config and let's start page
include("config.inc.php");
include("header.php");

fwmiddlebox(gettext("Short"), $fwshortabout);
$cont = "";
for ( $i=0; $i<count($fwabout); $i++ )
{
	$cont .= "<p><b><img src=\"images/arrow.gif\" alt=\"\" border=\"0\" /> ".gettext("Question").":&nbsp;&nbsp;".$fwabout[$i][0]."</b></p>\n";
	$cont .= "<p align=\"justify\">".gettext("Answer").":&nbsp;&nbsp;".$fwabout[$i][1]."</p>\n";
}
fwmiddlebox(gettext("Long"), $cont);

include("footer.php");
?>
