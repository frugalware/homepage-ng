<?
$fwshortabout="Frugalware Linux je distribuce zaměřená, designovaná pro pokročilé uživatele(kteří se nebojí práce v textovém režimu).";
$fwabout= array (
	array ("Které větve Frugalware používá ?", 
		"Máme <i>current(současná)</i> a <i>stable(stabilní)</i> větev. <i>Current(současná)</i> je denně aktualizována, a <i>stable(stabilní)</i> se aktualizuje přibližně každých 6 měsíců."), 
	array ("Jaká je&quot; Filozofie Frugalware &quot; ?",
		"Stručně: jednoduchost, multimedia, design. Snažíme se vytvořit Frugalware jednoduchou jak jen to je možné, při zachování daného komfortu. Pokoušíme se tvořit aktuální a stabilní software, aktuálnost se přibližuje k okamžiku vydání zdrojového balíčku."), 
	array ("Pod jakou licencí je uvolňován Frugalware ?", 
		"To jsou dvě otázky. Většina softwaru obsaženého v Frugalware mají GPL nebo BSD kompatibilní licenci, pro více informací o licencích některých specifických balíčků, nahlédněte do LICENSE nebo COPYRIGHT souboru obsaženého ve zdrojovém balíčku aplikace. Na druhé straně vše napsané našim vývojovým týmem (FrugalBuild skripty, setup, domácí stránka, atd) je uvolněno pod GPL licencí. Abychom to ještě zkomplikovali, tak některé části setupu a init skriptu napsal Patrick J. Volkerding pod licencí BSD. Pro více informací, nahlédněte do COPYRIGHT souboru v adresáři root v FST(Frugalware Source Tree)."),
	array ("Jaký balíčkovací manažer používá Frugalware ?",
	"Nemáme vlastní balíčkovací manažer, spoléháme se na Juddem Vinetem dobře odvedenou práci, a to<a href=\"http://www.archlinux.org/pacman\">pacman</a> balíčkovací manažer. Základem jsou tar.bz2 balíčky, jako Slackware.tgz. Našim rozšířením v oblasti balíčků je formát .fpm, který byl vytvořen k odlišení od .tar balíčků.  Narozdíl od Slackware(skripty), pacman je napsaný v Céčku, takže je mnohem rychlejší."),
	array ("Jak je zajištěno v Frugalware updatování zastaralých balíčků ?",
		"Nemáme žádný speciální nástroj pro aktualizaci balíčků, toto zajišťuje také pacman. K synchronizaci databáze balíčků použijte <tt>pacman&nbsp;-Sy</tt>, a k aktualizaci databáze použijte <tt>pacman&nbsp;-Su</tt>. K nainstalování balíčků s nezbytnými závislostmi přímo z mirroru (ftp server), využijte <tt>pacman&nbsp;-S&nbsp;foo</tt>. Pro více informací, využijte pacman man stránek."),
	array ("Existuje nějaká dostupná podpora pro distribuci Frugalware ?",
		"Současně máme 3 \"mailing lists\", irc kanál a fóra která mohou být využita pro komunikaci s námi či ostatními uživateli a k získání pomoci. Irc kanál se nachází na Freenode network (server: irc.freenode.net). Je dostupný také přímo z našeho webu (sekce komunita - irc). Pro více informací ohledně našich \"mailing lists\", přejděte do <a href=\"mailman/listinfo\">sekce seznam</a> na naší domácí stránce."),
	array("Je zde dostupná nějaká komerční podpora pro Frugalware ?",
		"Ne, nyní zde není, a<i>současně</i> není plánována."),
	array("Pro koho je Frugalware určen ?",
		"Frugalware je designován pro pokročilé uživatele. Instalace Frugalware není magie, samozřejmě, ale měli byste minimálně vědět něco o oddílech(partition), MBR (Master Boot Record), atd."),
	array("Jak se stát vývojářem Frugalware ?",
		"Snažte se :) Pokud jste instalovali Frugalware pomocí CD, získejte plné FST z hlavního repositáře, který je dostupný v pacman-tools(nástroje). Zdrojové kódy jsou obsaženy v DVD edici. Poté si začněte \"hrát\" s FrugalBuild skripty. Typický příklad najdete v <a href=\"packages.php?pkgname=cabextract\">cabextract</a> balíčku. Pokoušejte se je vylepšit, nebo vytvořte nový skript(balíček) pro nepodporované programy. Potom pošlete Vaše patche na adresu<a href=\"mailman/listinfo/frugalware-devel\"> devel</a> mailing list. Od tohoto okamžiku všechno už prijde \"samo sebou\" :)"),
	array("Co vlastně dělají vývojáři ?",
		"V krátkosti, to co oni sami chtějí. Oni třeba udržují balíčky: aktualizují je pokud vyjde nová verze aplikace a aktualizují FrugalBuild skripty aby pracovali správně s novými verzemi balíčků. Mohou přispět novým skriptem do předtím neexistujících balíčků. Mohou psát články o Frugalware, či o něčem jiném s propojením na Frugalware komunitu. Pokud nám chcete pomoct, a nechcete přímo programovat, nejvíce nám pomůžete překládáním Frugalware Linuxu do Vašeho mateřského jazyka. A samozřejmě rádi přijmeme jakékoliv <a href=\"donations.php\">dary</a> :)"),
	array("Kdo se stará o vývoj Frugalware?",
		"Skupina mladých vývojářů, ale Váš věk není omezením pro to aby jste se stal našim vývojářem"),
	array("Má Frugalware nějaké specifické zaměření  ?",
		"Ne, je to distribuce k všeobecnému užití, pro desktopy a servery."),
	array("Plánujete vydat live cd?",
		"Ano, je to v plánu, samozřejmě, podobně jako mnoho dalších chystaných \"featurek\"."),
	array("Podporuje Frugalware jiné jazyky než Angličtinu?",
		"Ano, podporuje všechny jazyky podporované jednotlivými balíčky. Pokud init skripty nebo setup není dostupný ve Vašem jazyce, potom to jednoduše znamená, že ještě nebyly přeloženy :)."),
	array("A jak je to s podporou Asijských jazyků ?",
		"Frugalware nepodporuje Asijské jazyky."),
	array("Které architektury podporuje Frugalware ?",
		"Nyní podporujeme x86 a x86_64 platformy, a z toho na platformě x86, pouze i686 (Pentium Pro nebo vyšší sestavy) a v rámci platformy x86_64 pouze k8 (amd64). Pokud se uživatelé nebudou dožadovat architektury i386, port bude vytvořen, ale nyní nemáme zdroje na vytvoření a udržování těchto balíčků. Kromě architektury x86, nyni nemáme žádný jiný hardware na testování, ale rádi přijmeme patche umožňující vytvořit non-x86 optimalizované balíčky. Také pracujeme na portu pro platformu PowerPC")
	);
?>
