#!/bin/sh

for i in *.xml
do
	echo "validating $i..."
	xmllint -valid -noout $i || break
done
