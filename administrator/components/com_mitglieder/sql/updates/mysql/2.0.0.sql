RENAME TABLE `#__mitglieder_listen` TO `#__mitglieder_listen_v1`;

CREATE TABLE IF NOT EXISTS `#__mitglieder_listen` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `values` mediumtext NOT NULL
);

ALTER TABLE `#__mitglieder_felder`
  CHANGE `typ` `typ` VARCHAR(100) NOT NULL DEFAULT 'text';

UPDATE `#__mitglieder_mitglieder_felder`
SET `text` = `kurz_text`
WHERE `text` IS NULL AND `kurz_text` IS NOT NULL;

ALTER TABLE  `#__mitglieder_mitglieder_felder`
DROP COLUMN `kurz_text`;
