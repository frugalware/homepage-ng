hook:
	cd .git && python /home/ftp/pub/other/git-hooks/git-hooks.py
	python frugalware/darcs-posthook.py
	python frugalware/darcs-posthook-security.py
