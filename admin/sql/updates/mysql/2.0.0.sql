CREATE TABLE IF NOT EXISTS `#__mitglieder2_listen` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `values` mediumtext NOT NULL
);

ALTER TABLE `#__mitglieder_felder`
  CHANGE `typ` `typ` VARCHAR(100) NOT NULL DEFAULT 'text';
