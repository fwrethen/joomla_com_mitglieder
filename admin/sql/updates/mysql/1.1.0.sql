ALTER TABLE `#__mitglieder_abteilungen` ADD `field` int(11) default NULL;

DROP TABLE IF EXISTS `#__mitglieder_abteilungen_felder`;

ALTER TABLE `#__mitglieder_felder` CHANGE `typ` `typ`
SET('text','text_html','email','telefon','datum','jahre seit','liste','bild')
NOT NULL DEFAULT 'text';

UPDATE `#__mitglieder_felder` SET `typ` = 'text_html' WHERE `typ` = 'text';
