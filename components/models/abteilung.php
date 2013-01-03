<?php

defined('_JEXEC') or die();
jimport('joomla.application.component.model');


class MitgliederModelAbteilung extends JModel
{

	function __construct($options = array()) {
		parent::__construct($options);

	}

	function getAbteilungQuery( $id )
	{

		$query = "SELECT * FROM #__mitglieder_abteilungen WHERE id = ".$id;
		return $query;
	}


	function getData($id) {
		$db = &JFactory::getDBO();

		$team = $this->getAbteilung($id);

		$team->mitglieder = $this->getMitglieder($id);


		return $team;
	}

	function getAbteilung( $id )
	{
		$db = &JFactory::getDBO();
		$db->setQuery( $this->getAbteilungQuery($id) );
		$team = $db->loadObject();

		return $team;

	}




	function getMitglieder( $aid ) {
		$db = &JFactory::getDBO();

		$query = "SELECT mitglied.id,mitglied.name,mitglied.vorname,mitglied.image_thumb from #__mitglieder_mitglieder_abteilungen as abteilung,#__mitglieder_mitglieder as mitglied " .
				 " WHERE mitglied.id= abteilung.mitglieder_id AND abteilungen_id = ".$aid . " order by ordering , name asc, vorname ASC";
		$db->setQuery( $query );
		$spieler = $db->loadObjectList();

foreach($spieler as $id=>$einSpieler) {

			$query = "select a.mitglieder_id, a.name,a.felder_id, a.typ, a.kurz_text, a.`text`, a.wert, a.datum from (select mitglieder_id, f1.name_frontend as name,a.felder_id, f1.typ, kurz_text, `text`, wert, datum " .
		"from (select mitglieder_id, felder_id, kurz_text,`text`, wert, datum " .
		"from #__mitglieder_mitglieder_felder as f LEFT JOIN #__mitglieder_listen as l ".
		"on l.id=f.listen_id ) as a, #__mitglieder_felder as f1 " .
		"where a.felder_id = f1.id AND mitglieder_id = $einSpieler->id ) as a , #__mitglieder_abteilungen_felder as b WHERE a.felder_id=b.felder_id and b.abteilungen_id = $aid ORDER by b.ordering,a.name ASC";
			$db->setQuery( $query );
			$spieler[$id]->felder = $this->_db->loadObjectList();

//			$query = "SELECT sf.kurz_text, sf.datum, sf.text, f.typ, f.name_frontend AS name" .
//						" FROM #__ttverein_spieler_felder AS sf, #__ttverein_felder AS f " .
//						" WHERE sf.spieler_id = " . $einSpieler->id .
//							" AND sf.felder_id = f.id " .
//							" AND f.zeige_in_uebersicht = 1 " .
//						" ORDER BY f.reihenfolge, f.id ASC ";
//			$db->setQuery( $query );
//			$spieler[$index]->felder = $db->loadObjectList();
		}
		return $spieler;
	}

	function getConfig() {
		return Config::getConfig(array('team_image_size', 'clicktt_use'));
	}

}
?>
