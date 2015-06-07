ALTER TABLE `#__mitglieder_felder` CHANGE `typ` `typ`
	SET('text','email','telefon','datum','jahre seit','liste','bild')
	CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'text';

INSERT INTO `#__mitglieder_felder`
	(`name_backend`, `name_frontend`, `typ`, `tooltip`, `show`, `ordering`)
	VALUES ('Profilbild', '', 'bild', '', '1', '0');

UPDATE `#__mitglieder_mitglieder`
	SET image_original = REPLACE (`image_resize`, '_resize', '');

INSERT INTO `#__mitglieder_mitglieder_felder`
	(`felder_id`, `mitglieder_id`, `kurz_text`)
	SELECT (
		SELECT `id` FROM `#__mitglieder_felder`
		WHERE `name_backend` = 'Profilbild' AND `typ` = 'bild'
	), `id`, `image_original` FROM `#__mitglieder_mitglieder`;

DROP TABLE IF EXISTS `#__mitglieder_config`;
