<?
$fwshortabout="Frugalware is general purpose linux distribution, designed for intermediate users (who are not afraid of text mode).";
$fwabout= array (
	array ("What branches does Frugalware have?", 
		"We have a <i>current</i> and a <i>stable</i> branch. The <i>current</i> branch is updated daily, and we update our <i>stable</i> branch around every 6 months."), 
	array ("What is &quot;The Frugalware Philosophy&quot; about?",
		"Briefly: simplicity, multimedia, design. We try to make Frugalware as simple as possible while not forgetting to keep it comfortable. We try to ship fresh and stable software, as close to the original source as possible, because in our opinion most software is the best as is, and doesn't need patching."), 
	array ("What is the license of Frugalware?", 
		"That's two questions. Most software included in Frugalware have a GPL or BSD compatible license, for more information about a license of a specific package, refer to the LICENSE or COPYRIGHT file in the source tarball of the package. On the other hand, the part written by our team (FrugalBuild scripts, setup, homepage, etc) is released under GPL license. To make it even more complicated, some parts of the setup and init scripts are written by Patrick J. Volkerding. We GPL our additions, but Patrick J. Volkerding's code is still under the BSD license. For more information, refer the the COPYRIGHT file in the root directory of the FST (Frugalware Source Tree)."),
	array ("What package manager does Frugalware use?",
	"We don't have our own package manager, we use Judd Vinet's great work, the <a href=\"http://www.archlinux.org/pacman\">pacman</a> package manager. It's a tar.bz2 based package manager, similar to Slackware's .tgz. Our packages' extension is .fpm to differentiate them from regular tarballs. Unlike Slackware's scripts, pacman is written in C, so it's much faster."),
	array ("How does Frugalware manage updating obsolete packages?",
		"We don't have any standalone program for updating packages as pacman manages this task too. To update your package database, use <tt>pacman&nbsp;-Sy</tt>, an to update your packages according the just synchronized package database, you use <tt>pacman&nbsp;-Su</tt>. To install a package with the necessary dependencies directly from a mirror ftp server, you issue <tt>pacman&nbsp;-S&nbsp;foo</tt>. For more information, refer to the pacman man page."),
	array ("Is there any community support available for Frugalware?",
		"Currently we have three mailing lists, an irc channel and forums that can be used to communicate with us or other users and to get help. The irc channel is on the Freenode network (server: irc.freenode.net). For more information about our mailing lists, please refer to the <a href=\"mailman/listinfo\">list section</a> of our web site."),
	array("Is there any commercial support available for Frugalware?",
		"No, there isn't for now, and <i>currently</i> it isn't planned, either."),
	array("For whom is Frugalware recommended to use?",
		"Frugalware is designed for intermediate users. Installing Frugalware is not a magic, of course, but you should know what a partition, an MBR (Master Boot Record), etc. is."),
	array("How to become a developer?",
		"Get involved! :) If you installed Frugalware from CDs, get the full FST via repoman, which is available in pacman-tools. The sources are included in the DVD edition. Then start to play with the FrugalBuild scripts, for a typical example, refer to the <a href=\"packages.php?pkgname=cabextract\">cabextract</a> package. Try to improve them, or write a new one for a currently unsupported program. Then send your patches to the <a href=\"mailman/listinfo/frugalware-devel\">devel</a> mailing list. From this point everything will come naturally to you :)"),
	array("What do developers do?",
		"In short, what they want to, if they play a square game. They may maintain packages: building them if a newer version available and update the FrugalBuild scripts to work correctly against a newer version. They can contribute a new build script to a previously non-existant package. They can write articles about Frugalware, or anything else in connection with the Frugalware community. If you only want to help us, but you don't want to hack, you may help in translating Frugalware to your or other language. And, of course, we happily accept <a href=\"donations.php\">donations</a> :)"),
	array("Who develops Frugalware?",
		"A young group, but your age is not conditional to become a developer"),
	array("Is Frugalware specialized in a certain purpose?",
		"No, it's a general purpose distribution, for desktops and servers."),
	array("Do you plan to release a live cd?",
		"It is planned, of course, like many other features, but currently we don't have a live cd."),
	array("Does Frugalware support languages other than English?",
		"Yes, it supports all languages supported by the packages. If the init scripts or the setup is not available in your language, then it simply means it haven't yet translated."),
	array("What about Asian languages?",
		"Frugalware does not support Asian languages."),
	array("What architectures does Frugalware support?",
		"Currently we support x86 and x86_64 platforms, and inside x86, only i686 (Pentium Pro or higher instruction set) and inside x86_64 only k8 (amd64). If there are any claims, an i386 port will be created, but currently we don't have resources to build and maintain those packages. Outside x86, currently we don't have any non-x86 hardware, but happily accept such patches or any effort to create non-x86 optimized packages. We are also working on a PowerPC port")
	);
?>
