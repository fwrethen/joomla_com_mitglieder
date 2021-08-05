CREATE TABLE IF NOT EXISTS `#__mitglieder_abteilungen` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `description` TEXT default NULL,
  `thumb` int(11) default NULL,
  `field` int(11) default NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS #__mitglieder_felder (
	id int(11) not null auto_increment PRIMARY KEY,
	`name_backend` varchar(100) NOT NULL,
	`name_frontend` varchar(100) NOT NULL,
  	`typ` VARCHAR(100) NOT NULL DEFAULT 'text',
  	`tooltip` varchar(255) default NULL,
  	`show` tinyint(1) NOT NULL default 1,
  	`ordering` tinyint(2) NOT NULL default '99'
);

CREATE TABLE IF NOT EXISTS `#__mitglieder_listen` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `values` mediumtext NOT NULL
);

CREATE TABLE IF NOT EXISTS `#__mitglieder_mitglieder` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `vorname` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__mitglieder_mitglieder_felder` (
  `felder_id` int(11) NOT NULL,
  `mitglieder_id` int(11) NOT NULL,
  `kurz_text` varchar(255) default NULL,
  `datum` date default NULL,
  `text` text,
  `listen_id` int(11) default NULL,
  PRIMARY KEY  (`felder_id`,`mitglieder_id`)
);

CREATE TABLE IF NOT EXISTS `#__mitglieder_mitglieder_abteilungen` (
  `abteilungen_id` int(11) NOT NULL,
  `mitglieder_id` int(11) NOT NULL,
  `ordering` tinyint(2) NOT NULL default '99',
   PRIMARY KEY  (`abteilungen_id`,`mitglieder_id`)
);
