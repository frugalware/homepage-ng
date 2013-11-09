-- Host: genesis.frugalware.org
-- Generation Time: Apr 20, 2010 at 02:09 PM
--
-- Database: `frugalware2`
--

-- --------------------------------------------------------

--
-- Table structure for table `conflicts`
--

CREATE TABLE `conflicts` (
  `pkg_id` int(11) NOT NULL,
  `conflict_id` int(11) NOT NULL,
  KEY `pkg_id` (`pkg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ct_groups`
--

CREATE TABLE `ct_groups` (
  `pkg_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  KEY `pkg_id` (`pkg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `depends`
--

CREATE TABLE `depends` (
  `pkg_id` int(11) NOT NULL,
  `depend_id` int(11) NOT NULL,
  `version` varchar(32) DEFAULT NULL,
  KEY `pkg_id` (`pkg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `pkg_id` int(11) NOT NULL,
  `file` varchar(4096) DEFAULT NULL,
  KEY `file` (`file`(1000)),
  KEY `pkg_id` (`pkg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `abis`
--

CREATE TABLE `abis` (
  `pkg_id` int(11) NOT NULL,
  `abi` varchar(4096) DEFAULT NULL,
  KEY `abi` (`abi`(1000)),
  KEY `pkg_id` (`pkg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE `licenses` (
  `pkg_id` int(11) NOT NULL,
  `license` varchar(255) NOT NULL,
  KEY `pkg_id` (`pkg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pkgname` varchar(256) DEFAULT NULL,
  `pkgver` varchar(64) DEFAULT NULL,
  `desc` varchar(512) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `sha1sum` varchar(41) DEFAULT NULL,
  `arch` varchar(32) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `usize` int(11) DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `parent_id` int(11) DEFAULT NULL,
  `maintainer` varchar(255) DEFAULT NULL,
  `uploader_id` int(11) DEFAULT NULL,
  `fwver` varchar(32) DEFAULT NULL,
  `builddate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `fwver_pkgname_arch` (`fwver`,`pkgname`,`arch`),
  KEY `pkgname` (`pkgname`),
  KEY `arch` (`arch`),
  KEY `fwver` (`fwver`)
) ENGINE=MyISAM AUTO_INCREMENT=88532 DEFAULT CHARSET=utf8 AUTO_INCREMENT=88532 ;

-- --------------------------------------------------------

--
-- Table structure for table `provides`
--

CREATE TABLE `provides` (
  `pkg_id` int(11) NOT NULL,
  `provide_id` int(11) NOT NULL,
  KEY `pkg_id` (`pkg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `uploaders`
--

CREATE TABLE `uploaders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;
