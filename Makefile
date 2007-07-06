hook:
	python frugalware/darcs-posthook.py
	python frugalware/darcs-posthook-security.py
	cd .git && python /home/ftp/pub/other/git-hooks/git-hooks.py
