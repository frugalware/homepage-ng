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
 @copyright Copyright (C) 2006 Miklos Vajna

"""
from sgmllib import SGMLParser
import htmlentitydefs
import string
from xml.dom import minidom

class BaseHTMLProcessor(SGMLParser):
	def reset(self):
		self.enum = 0
		self.enumstrs = ("", "  * ", "	   + ")
		self.enumbrks = ("", "    ", "	     ")
		self.pieces = []
		self.refs = []
		SGMLParser.reset(self)
	
	def wrap(self, text, width):
		return reduce(lambda line, word, width=width: '%s%s%s' %
					  (line,
					   ' \n'[(len(line)-line.rfind('\n')-1
							 + len(word.split('\n',1)[0]
								  ) >= width)],
					   word),
					  text.split(' ')
					 )
	def start_br(self, attrs):
		if self.enum == 0:
			self.pieces.append("\n" + self.enumstrs[self.enum])
	
	def start_li(self, attrs):
		if self.enum > 0:
			self.pieces.append("\n" + self.enumstrs[self.enum])
	
	def start_a(self, attrs):
		for k, v in attrs:
			if k == "href":
				self.refs.append(v)
		self.pieces.append("[%d]" % len(self.refs))
	
	def start_ul(self, attrs):
		self.enum += 1
	
	def end_ul(self):
		self.enum -= 1
		if self.pieces[-1][-1] != "\n":
			self.pieces.append("\n")
	
	def handle_data(self, text):
		self.pieces.append(self.wrap(text.strip(), 80).replace("\n", "\n" + self.enumbrks[self.enum]))
	
	def output(self):
		"""Return processed HTML as a single string"""
		if len(self.refs) > 0:
			self.pieces.append("References\n\n")
			for i in self.refs:
				str = i
				try:
					str.index("http://")
				except ValueError:
					str = "http://frugalware.org/" + str
				self.pieces.append("%d. %s\n" % (self.refs.index(i)+1, str))
		return string.strip("".join(self.pieces))


if __name__ == "__main__":
	sock = open("_darcs/third_party/latest", "r")
	latest = sock.read().strip()
	sock.close()
	xmldoc = minidom.parse('frugalware/xml/news.xml')
	id = xmldoc.childNodes[1].childNodes[1].childNodes[1].firstChild.toxml()
	if id > latest:
		title = xmldoc.childNodes[1].childNodes[1].childNodes[3].firstChild.toxml()
		author = xmldoc.childNodes[1].childNodes[1].childNodes[7].firstChild.toxml()
		htmlSource = xmldoc.childNodes[1].childNodes[1].childNodes[9].firstChild.toxml()
		htmlSource = htmlSource.replace("<![CDATA[", "").replace("]]>", "").strip()
		parser = BaseHTMLProcessor()
		parser.feed(htmlSource)
		parser.close()
		import smtplib
		fro = author + " <noreply@frugalware.org>"
		to = "vmiklos@gmail.com"
		msg = "From: %s \r\nTo: %s\r\nSubject: %s\r\n\r\n" \
			% (fro, to, title)
		msg += parser.output()
		server = smtplib.SMTP('localhost')
		server.set_debuglevel(1)
		server.sendmail(fro, to, msg)
		server.quit()
		sock = open("_darcs/third_party/latest", "w")
		sock.write(id + "\n")
		sock.close()
