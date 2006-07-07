LANGS=hu_HU fr_FR

mos:
	for i in $(LANGS); do \
		echo -n "$$i: "; \
		mkdir -p ../locale/`basename $$i .po`/LC_MESSAGES/; \
		msgfmt -c --statistics -o ../locale/`basename $$i .po`/LC_MESSAGES/homepage.mo $$i; \
	done
	# ugly hack till we don't know how to handle multiple apply hooks..
	cd ../.. && php frugalware/darcs-posthook.php

pot:
	intltool-update --pot --gettext-package=homepage

update-po: pot
	for lang in $(LANGS); do \
		if msgmerge $$lang.po homepage.pot -o $$lang.new.po; then \
			mv -f $$lang.new.po $$lang.po; \
		else \
			echo "msgmerge for $$cat failed!"; \
			rm -f $$lang.new.po; \
		fi; \
	done

clean:
	rm -f homepage.pot
