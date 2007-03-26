top_srcdir=..

pot: intltool-extract
	intltool-update --pot --gettext-package=homepage

intltool-extract:
	cp /usr/bin/intltool-extract ./

clean:
	rm -f homepage.pot
