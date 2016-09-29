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
					// Future dates will also give positive diff but who cares...
					$age = date_diff(date_create($feld->datum), date_create('now'));
					if ($age->y < 1){
						if ($age->m < 1)
							$text = 'unbekannt';
						elseif ($age->m == 1)
							$text = $age->m .' Monat';
						else
							$text = $age->m .' Monate';
					}
					elseif ($age->y == 1)
						$text = $age->y .' Jahr';
					else
						$text = $age->y .' Jahre';

					$data[$id]['type'] = 'text';
					$data[$id]['value'] = $text;
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
