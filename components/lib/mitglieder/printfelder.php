<?php
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_COMPONENT . '/lib/logger.php' );


function printFelder($felder) {
	Logger::log( 'Inf: Print fields: ');
	Logger::logArray($felder);

		foreach($felder as $id=>$feld) {
			?>
		<tr>
			<td class="key">
				<label for="alias">
					<?php if ($feld->name) echo JText::_( $feld->name ) . ':'; ?>
				</label>
			</td>
			<td>
			<?php

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
					echo $text;

					break;

				case "text":
					echo strip_tags($feld->text);
					break;
				case "text_html":
					echo $feld->text;
					break;
				case "email":
					echo $feld->kurz_text;
					break;
				case "telefon":
					echo $feld->kurz_text;
					break;
				case "liste":
					echo $feld->wert;
					break;
				case "bild":
					$params = JComponentHelper::getParams('com_mitglieder');
					$image_size = $params->get('mitglied_image_size', '300');
					echo '<img src="'. JURI::root() . $feld->kurz_text .'" alt="'. $feld->name .'"
						height="'. $image_size .'" max-width="'. $image_size .'" />';
					break;
			}
			?>
			</td>
		</tr>

			<?php
		}
/*		?>
		<!--tr>
			<th><?php echo $title;?></th>
			<td><?php echo $text;?></td>
		</tr-->
		<?php	*/

//	}



}

?>
