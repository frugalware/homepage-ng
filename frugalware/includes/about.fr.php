<?
$fwshortabout="Frugalware est une distribution linux généraliste optimisé, conçu pour les utilisateurs intermédiaires (lire qui n'ont pas peur de la ligne de commande).";
$fwabout= array (
	array ("quelles sont les 'roulements de version' ou différentes branches de Frugalware ?",
"nous avons une branche <i>current</i>,une branche <i>testing</i> et une branche <i>stable</i> . la branche <i>current</i> est mise à jour quotidienement , nous mettons à jours les paquets de <i>testing</i> à peu près tout les deux mois, et nous essayons de mettre a jour notre branche <i>stable</i> tout les six mois."),
	array ("quelle est la philosophie de Frugalware?",
"en bref: simplicité, multimedia, design. nous éssayons de rendre Frugalware aussi simple que possible sans oublier de garder cette distribution confortable à utiliser. Nous éssayons de fournir des logiciels stables et récents, le plus proche possible des sources originales, car nous pensons qu'un logiciel de qualité n'a pas besoin d'être modifié."),
	array ("quelles est la license de Frugalware?",
"La plupart des logiciels présent dans Frugalware ont une license compatible GPL ou BSD, pour plus d'informations à propos d'une license ou d'un paquet spécifique, référez vous aux fichiers LICENSE et COPYRIGHT présents dans la partie source des paquets . Par contre toutes les parties écrite par notre équipe (FrugalBuild scripts, installation, page d'acceuil, etc) sont soumises à la license GPL. Pour compliquer le tout, quelques parties de l'installation et de l'init scripts sont de Patrick J. Volkerding, le code malgré nos contributions est donc encore sous la license BSD. Pour plus d'informations, référez vous au fichier  COPYRIGHT dans le dossier root du FST (Frugalware Source Tree)."),
	array ("quelle est le gestionnaire de paquets de Frugalware ?",
"Nous n'avons pas notre propre gestionnaire de paquet, nous utilisons le magnifique gestionnaire de paquet de Judd Vinet , le <a href=\"http://www.archlinux.org/pacman\">pacman</a> gestionnaire de paquet pacman. C'est un gestionnaire de paquet basé sur tar.gz, similaire au .tgz. de Slackware. Notre extension de paquet est .fpm pour pouvoir le différencier des tarballs. Contrairement au scripts Slackware, pacman est écrit en language C, il est donc beaucoup plus rapide."),
	array ("Comment Frugalware gère t-il la mise à jour des paquets anciens ?",
"Nous n'avons pas d'outil spécifique pour mettre a jour les paquets car pacman s'en charge. Pour mettre à jour votre  liste de paquet, utilisez <tt>pacman&nbsp;-Sy</tt>, pour mettre a jour votre paquet selon la liste de paquet a jour utilisez <tt>pacman&nbsp;-Su</tt>. Pour installer un paquet avec toutes les dépendances requises  directement depuis les mirroirs ftp de Frugalware, utilisez <tt>pacman&nbsp;-S&nbsp;foo</tt>. Pour plus d'information au sujet de l'utilisation de pacman voir man pacman."),
	array ("Y a t-il un support communautaire pour Frugalware ?",
"Actuellement nous avons trois mailling lists et un canal irc qui permet d'obtenir de l'aide de la part des développeurs et des utilisateurs. Le canal irc est sur le réseau Freenode (server: irc.freenode.net). Pour plus d'informations à propos de notre mailing list, référez vous <a href=\"mailman/listinfo\">list section</a> de notre site internet."),
	array("Y a t-il un support commercial pour Frugalware?",
"Non, il ny en a pas pour le moment, et <i>currently</i> ce n'est pas prévu."),
	array("Pour qui Frugalware est-il recommandé?",
"Frugalware est destiné aux utilisateurs intermédiaires. Installer Frugalware n'est pas compliqué, mais demande un minimum de connaissances: savoir ce qu'est une partition, et un MBR (Master Boot Record)"),
	array("Comment devenir un développeur?",
"Motivé? :) Si vous installez Frugalware à partir de cd-rom, prenez le FST, les sources sont incluses dans l'édition dvd. Ensuite commençez à vous faire la main avec les scripts FrugalBuild , pour un exemple concret, référez vous <a href=\"packages.php?pkgname=cabextract\">cabextract</a> paquet. Essayez d'améliorer, ou de construire de nouveaux paquets pour un programme non supporté. Ensuite envoyez le tout à <a href=\"mailman/listinfo/frugalware-devel\">devel</a> mailing list. A partir de là tout deviendra plus naturelle pour vous :)"),
	array("Que font les developeurs?",
"Et bien ceux qu'ils veulent ;). Ils maintiennent les paquets : les reconstruisent si une nouvelle version est disponible, en mettant à jour les scripts FrugalBuild. Ils peuvent également créer de nouveaux scripts frugalbuild afin de proposer de nouveaux paquets. Il écrivent également de nombreux articles traitants de Frugalware, ou bien en rapport avec sa communauté. Si vos connaissances en informatiques sont minimes mais que vous voulez participer, votre aide sera la bienvenu car il reste de nonbreuses choses a traduires. A signalez aussi que nous acceptons avec plaisir toutes donations :)"),
	array("Qui développe Frugalware?",
"Un jeune groupe, mais votre âge n'est pas discriminatif"),
	array("Est ce que Frugalware est une distribution spécialisé ?",
"Non c'est une distribution généraliste orientée utilisateur et serveurs."),
	array("Prévoyez vous un live cd?",
"C'est prévu, bien sur, comme bien d'autres projets , mais actuellement nous n'avons pas de live cd."),
	array("Est ce que Frugalware supporte d'autres langues que l'anglais?",
"Oui. Si le script init ou l'installation ne sont pas disponible dans votre language ( le français est supporté), cela veut dire que cette partie n'est pas encore traduite"),
	array("Et les langues asiatiques?",
"Frugalware ne supporte pas les langues asiatiques."),
	array("quelles architectures Frugalware supporte-t-il?",
"Actuellement nous supportons seulement les architectures x86, mais seulement les i686 (Pentium Pro, athlon xp et plus ). Si il y avait plus de demande un portage i386 serait creé, mais actuellement nous n'avons pas les ressources necessaires pour fabriquer et maintenir ces paquets.")
);
?>
