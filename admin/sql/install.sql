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
  	`typ` set('text','email','telefon','datum','jahre seit','liste','bild') NOT NULL default 'text',
  	`tooltip` varchar(255) default NULL,
  	`show` tinyint(1) NOT NULL default 1,
  	`ordering` tinyint(2) NOT NULL default '99'
);

create table IF NOT EXISTS #__mitglieder_listen (
	id int(11) not null primary Key auto_increment,
	liste int (11) not null,
	wert varchar(255) not null
);

CREATE TABLE IF NOT EXISTS `#__mitglieder_mitglieder` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `vorname` varchar(100) NOT NULL,
  `image_original` varchar(255) default NULL,
  `image_resize` varchar(255) default NULL,
  `image_thumb` varchar(255) default NULL,
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

CREATE TABLE IF NOT EXISTS `#__mitglieder_abteilungen_felder` (
  `abteilungen_id` int(11) NOT NULL,
  `felder_id` int(11) NOT NULL,
  `ordering` tinyint(2) NOT NULL default '99',
   PRIMARY KEY  (`abteilungen_id`,`felder_id`)
);
