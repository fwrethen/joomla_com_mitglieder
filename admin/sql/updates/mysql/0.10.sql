ALTER TABLE `#__mitglieder_felder` CHANGE `typ` `typ`
	SET('text','email','telefon','datum','jahre seit','liste','bild')
	CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'text';
