<?php
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_COMPONENT . '/lib/mitglieder/printfelder.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR . '/lib/logger.php');

//
//	foreach($felder as $feld) {
//		$title = $feld->name;
//		$text = trim($feld->kurz_text);
//
//		if($feld->typ == "jahre seit") {
//			if(trim($feld->datum) == "0000-00-00")
//				continue;
//
//			$akt_jahr = date("Y");
//			$akt_monat = date("m");
//			$akt_tag = date("d");
//
//			$gebdat = explode("-", trim($feld->datum));
//			$geb_jahr = $gebdat[0];
//			$geb_monat = $gebdat[1];
//			$geb_tag = $gebdat[2];
//
//			$alter = $akt_jahr - $geb_jahr;
//			$v = $akt_monat - $geb_monat;
//
//			// Geb-Monat in der Zukunft
//			if ($v < 0) {
//				$alter = $alter - 1;
//
//			// aktuelles Monat ist Geb-Monat
//			} elseif ($v == 0) {
//				$d = $akt_tag - $geb_tag;
//				if ($d < 0)
//					$alter = $alter - 1;
//			}
//
//			if($alter == 0 && $v > 0) {
//				$text = $v . " Monate"; //Ungenau
//			} else {
//				$text = $alter . " Jahre";
//			}
//
//		}
//		if ($feld->typ == "email") {
//			$text = JHtml::_('email.cloak', $text);
//		}
//
//		if($text == null || $text == '')
//			continue;
$name = $this->mitglied->vorname . " " . $this->mitglied->name;
echo "<h1>$name</h1>";

//<title> Tag setzen
$document = JFactory::getDocument();
$document->setTitle($name);

?>

<table width="300px">
	<?php
	printFelder($this->mitglied->felder);
	?>
</table>
