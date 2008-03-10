"""
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License v2 as published by
 the Free Software Foundation

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 GNU General Public License for more details.

 Frugalware Linux Homepage - New Generation
 @author Miklos Vajna <vmiklos@frugalware.org>
 @copyright Copyright (C) 2006, 2007 Miklos Vajna

"""
from xml.dom import minidom
import sys, re, popen2, pwd, os

class fsa:
	def __init__(self, xmldoc):
		self.lines = []
		self.id = xmldoc.getElementsByTagName('id')[0].firstChild.toxml()
		self.date = xmldoc.getElementsByTagName('date')[0].firstChild.toxml()
		self.author = xmldoc.getElementsByTagName('author')[0].firstChild.toxml()
		self.package = xmldoc.getElementsByTagName('package')[0].firstChild.toxml()
		self.vulnerable = xmldoc.getElementsByTagName('vulnerable')[0].firstChild.toxml()
		self.unaffected = xmldoc.getElementsByTagName('unaffected')[0].firstChild.toxml()
		self.bts = xmldoc.getElementsByTagName('bts')[0].firstChild.toxml()
		self.cve = xmldoc.getElementsByTagName('cve')[0].firstChild.toxml()
		self.desc = re.sub(r'\n\t+', r'\n', xmldoc.getElementsByTagName('desc')[0].firstChild.toxml()).replace('&quot;', '"')
		self.subject = "[ FSA-%s ] %s" % (self.id, self.package)
		self.comment = "See http://ftp.frugalware.org/pub/README.GPG for info"

		# now generate the mail
		self.lines.append("Frugalware Security Advisory                           FSA-%s\n\n" % self.id)
		self.lines.append("Date: %s\n" % self.date)
		self.lines.append("Package: %s\n" % self.package)
		self.lines.append("Vulnerable versions: <= %s\n" % self.vulnerable)
		self.lines.append("Unaffected versions: >= %s\n" % self.unaffected)
		self.lines.append("Related bugreport: %s\n" % self.bts)
		self.lines.append("CVE: %s\n" % self.cve)
		self.lines.append("""
Description
===========

%s
""" % self.desc)
		self.lines.append("""
Updated Packages
================

Check if you have %s installed:

	# pacman-g2 -Q %s

If found, then you should upgrade to the latest version:

	# pacman-g2 -Sy %s

Availability
============

The latest revision of this advisory is available at
http://frugalware.org/security/%s

""" % (self.package, self.package, self.package, self.id))

	def output(self):
		pout, pin = popen2.popen2('gpg --comment "%s" --clearsign --homedir /home/%s/.gnupg -u 20F55619' % (self.comment, pwd.getpwuid(os.getuid())[0]))
		pin.write("".join(self.lines))
		pin.close()
		ret = "".join(pout.readlines())
		pout.close()
		return ret


if __name__ == "__main__":
	sock = open(".git/third_party/latest-security", "r")
	latest = sock.read().strip()
	sock.close()
	f = fsa(minidom.parse('frugalware/xml/security.xml'))
	if f.id != latest:
		import smtplib
		fro = f.author + " <noreply@frugalware.org>"
		to = "frugalware-security@frugalware.org"
		msg = "From: %s \r\nTo: %s\r\nSubject: %s\r\n\r\n" \
			% (fro, to, f.subject)
		msg += f.output()
		server = smtplib.SMTP('localhost')
		server.set_debuglevel(1)
		server.sendmail(fro, to, msg)
		server.quit()
		sock = open(".git/third_party/latest-security", "w")
		sock.write(f.id + "\n")
		sock.close()
