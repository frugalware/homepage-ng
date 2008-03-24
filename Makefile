hook:
	cd .git && python /home/ftp/pub/other/git-hooks/git-hooks.py post-receive
	python frugalware/darcs-posthook.py
	python frugalware/darcs-posthook-security.py
