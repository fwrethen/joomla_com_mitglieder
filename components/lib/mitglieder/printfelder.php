<?php
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_COMPONENT_ADMINISTRATOR . '/lib/logger.php' );


function printFelder($felder) {
	Logger::log( 'Inf: Print fields: ');
	Logger::logArray($felder);

	$data = array();

		foreach($felder as $id=>$feld) {
			$data[$id]['key'] = $feld->name;

			switch($feld->typ) {
				case "jahre seit":
					if(trim($feld->datum) == "0000-00-00")
						continue;

					$akt_jahr = date("Y");
					$akt_monat = date("m");
					$akt_tag = date("d");

					$gebdat = explode("-", trim($feld->datum));
					$geb_jahr = $gebdat[0];
					$geb_monat = $gebdat[1];
					$geb_tag = $gebdat[2];

					$alter = $akt_jahr - $geb_jahr;
					$v = $akt_monat - $geb_monat;

					// Geb-Monat in der Zukunft
					if ($v < 0) {
						$alter = $alter - 1;

					// aktuelles Monat ist Geb-Monat
					} elseif ($v == 0) {
						$d = $akt_tag - $geb_tag;
						if ($d < 0)
							$alter = $alter - 1;
					}

					if($alter == 0 && $v > 0) {
						$text = $v . " Monate"; //Ungenau
					} else {
						$text = $alter . " Jahre";
					}
					$data[$id]['type'] = 'text';
					$data[$id]['value'] = $feld->text;

					break;

				case "text":
					$data[$id]['type'] = 'text';
					// strip tags and replace newline with <br />
					$data[$id]['value'] = nl2br(strip_tags($feld->text));
					break;
				case "text_html":
					$data[$id]['type'] = 'text';
					$data[$id]['value'] = $feld->text;
					break;
				case "email":
					$data[$id]['type'] = 'text';
					$data[$id]['value'] = $feld->kurz_text;
					break;
				case "telefon":
					$data[$id]['type'] = 'text';
					$data[$id]['value'] = $feld->kurz_text;
					break;
				case "liste":
					$data[$id]['type'] = 'text';
					$data[$id]['value'] = $feld->wert;
					break;
				case "bild":
					$data[$id]['type'] = 'image';
					$data[$id]['value'] = $feld->kurz_text;
					break;
			}
		}

	return json_encode( $data );

}

?>
