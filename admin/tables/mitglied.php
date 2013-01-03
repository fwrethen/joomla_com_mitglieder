<?php

defined('_JEXEC') or die('Restricted access');

class TableMitglied extends JTable
{
	var $id						= 0;
	var $vorname				= '';
	var $name				= '';
	var $image_original			= '';
	var $image_resize			= '';
	var $image_thumb			= '';

	var $felder					= array();
	var $listen					= array();


	function TableMitglied(& $db) {
		parent::__construct('#__mitglieder_mitglieder', 'id', $db);

		/*
		 * Möglichen eingabefelder Laden
		 */
		$query = "SELECT id, name_backend, typ, tooltip " .
				" FROM #__mitglieder_felder " .
				" ORDER BY ordering, id ASC ";
		$db->setQuery( $query );
		$felder = $db->loadObjectList();


		$this->felder = array();
		foreach($felder as $feld) {
			$this->felder[$feld->id]->typ = $feld->typ;
			if ($feld->typ=='liste')
			{
				$query = " SELECT id, wert FROM #__mitglieder_listen WHERE liste = $feld->id";
				$db->setQuery($query);
				$liste=$db->loadObjectList('id');
				$this->listen[$feld->id]=$liste;
			}
			$this->felder[$feld->id]->name = $feld->name_backend;
			$this->felder[$feld->id]->wert = null;
			$this->felder[$feld->id]->tooltip = $feld->tooltip;
		}


	}

	/**
	 * Gibt die Konfigurationsdaten zurück die im Zusammenhang mit dem Spieler stehen.
	 *
	 * @access public
	 * @return array 'player_thumb_size', 'player_image_path', 'player_image_size'
	 */
	function getConfig(){
		return Config::getConfig(array('mitglied_thumb_size',
								'mitglied_image_path',
								'mitglied_image_size'));
	}


	function bind( $from, $ignore=array() ) {
		$felder = $this->felder;
		if(!parent::bind($from, $ignore))
			return false;
		$this->felder = $felder;

		if(array_key_exists("felder", $from) && is_array($from["felder"])) {
			foreach($from["felder"] as $id=>$wert) {
				if(!isset($wert) || $wert == "") {
					$this->felder[$id]->wert = null;
					$this->felder[$id]->typ = $from["typen"][$id];
				} else {
					$this->felder[$id]->wert = $wert;
					$this->felder[$id]->typ = $from["typen"][$id];
				}

			}
		}

		return true;
	}

	/**
	 * Läd zusätzlich die Mannschaften und die Aufstellungen
	 */
	function load($oid=null) {

		//Spielerdaten Laden
		if(parent::load($oid) === false)
			return false;

		//Datenbankverbindung
		$db = &$this->_db;

		//Nachdem parent::load() aufgerufen wurde, ist die ID auf jden fall im Objekt
		$key = $this->_tbl_key;
		$id = $this->$key;




		/*
		 * Zusätzliche Spielerfelder laden
		 */

		$query = "select mitglieder_id, f1.name_backend,a.felder_id, f1.typ, kurz_text, `text`, datum, listen_id " .
		"from #__mitglieder_mitglieder_felder as a, #__mitglieder_felder as f1 " .
		"where a.felder_id= f1.id AND mitglieder_id = $oid order by f1.ordering, f1.id ASC";

		/*geh�rt ins frontend
		 * $query = "select mitglieder_id, f1.name_backend,a.felder_id, f1.typ, kurz_text, `text`, wert " .
		"from (select mitglieder_id, felder_id, kurz_text,`text`, wert " .
		"from #__mitglieder_mitglieder_felder as f LEFT JOIN #__mitglieder_listen as l ".
		"on l.id=f.listen_id ) as a, #__mitglieder_felder as f1 " .
		"where a.felder_id= f1.id AND mitglieder_id = $oid order by f1.ordering, f1.id ASC";
		*/

		$db->setQuery( $query );
		$mitgliedFelder = $db->loadObjectList();

		//$this->felder = array();
		foreach($mitgliedFelder as $feld) {
			switch ($feld->typ)
			{
				/*
				 * Datum
				 */


				case "jahre seit":
				{
					$wert = $feld->datum;
				}
				break;

				case 'text':
				{
					$wert = $feld->text;
				}
				break;
				case 'liste':
				{
					$wert = $feld->listen_id;
				}
				break;
				default:
				{
					$wert = $feld->kurz_text;
				}
				break;
			}
			if($feld->typ == "jahre seit")
				$wert = $feld->datum;
			$this->felder[$feld->felder_id]->typ = $feld->typ;
			$this->felder[$feld->felder_id]->name = $feld->name_backend;
			$this->felder[$feld->felder_id]->wert = $wert;
			$this->felder[$feld->felder_id]->tooltip = $feld->tooltip;
		}


	}

	function store( $updateNulls=false ) {
		parent::store($updateNulls);

		//Datenbankverbindung
		$db = &$this->_db;

		$spielerID = $this->id;


		/*
		 * Profielfelder eintragen
		 */
		foreach($this->felder as $felderID=>$feld) {

			switch ($feld->typ)
			{
				/*
				 * Datum
				 */


				case "jahre seit":
				 {
					$spalte = "datum";

					//Datum in SQL (Englisches) Format umwandeln
					if($feld->wert) {
						$date = explode(".",$feld->wert);
						if(count($date) == 3)//Normales Deutsches Format tt.mm.jjjj
							$feld->wert = date("Y-m-d", mktime(0, 0, 0, $date[1], $date[0], $date[2]));
						else if( ($date = strtotime($feld->wert)) )//strtotime() wandelt verschiedene Formate in einen Timestamp um. Erst seit PHP5 wirklich gut.
							$feld->wert = date("Y-m-d", $date);
						else //Falsches Datum wird nicht gespeichert
							$feld->wert = null;
					}


				}
				break;

				case 'text':
				{
					$spalte = "text";
				}
				break;
				case 'liste':
				{
					$spalte = "listen_id";
				}
				break;
				default:
				{
					$spalte = "kurz_text";
				}
				break;
			}
			/*
			 * Leere Felder werden als null eingefügt
			 */
			if($feld->wert == "" || $feld->wert == null){
				$wert = "null";
				$query = "DELETE FROM #__mitglieder_mitglieder_felder " .
						" WHERE felder_id = $felderID " .
							" AND mitglieder_id = $spielerID ";
				$db->setQuery($query);
				$db->query();
			}
			else {
				$wert = "'" . $feld->wert . "'";

				$query = "INSERT INTO #__mitglieder_mitglieder_felder " .
						" SET felder_id=$felderID, mitglieder_id=$spielerID, " .
							" $spalte=$wert ".
				"ON DUPLICATE KEY UPDATE $spalte=$wert ";
				$db->setQuery($query);
				$db->query();

			}
		}

		//TODO: Abteilungszuordnung
//		//Speichern der Aufstellung
//		if($this->mannschaften != null && is_array($this->mannschaften)) {
//			foreach($this->mannschaften as $key =>$id) {
//				$id = intval($id);
//				$tmp = split("-", $key);
//				$saison = intval($tmp[0]);
//				$hinrunde = intval($tmp[1]);
//				$position = intval($this->aufstellungen[$key]);
//
//				//Löschen des vorher gesetzten Spielers
//
//
//				/*
//				 * Spieler aus den Aufstellungen der Saison herauslöschen.
//				 */
//				$query = "DELETE #__ttverein_aufstellungen " .
//						" FROM #__ttverein_aufstellungen " .
//							" INNER JOIN #__ttverein_mannschaften " .
//						" WHERE #__ttverein_aufstellungen.mannschafts_id=#__ttverein_mannschaften.id " .
//							" AND #__ttverein_mannschaften.saisonstart=$saison " .
//							" AND #__ttverein_mannschaften.hinrunde=$hinrunde" .
//							" AND #__ttverein_aufstellungen.spieler_id=$spielerID";
//				$this->_db->setQuery($query);
//				$this->_db->query();
//				/*if ( !$this->_db->query() ) {
//               		JError::raiseError(112, $this->_db->getErrorMsg());
//               		return false;
//            	}*/
//				if ($id > 0 && $position > 0)  {
//					// Vorhandenen Spieler auf der Position löschen
//					//Vorher "DELETE IGNORE" - Inkompatibel zu MySQL 4.0
//					$query = "DELETE FROM #__ttverein_aufstellungen " .
//							" WHERE mannschafts_id = $id " .
//							" AND position = $position ";
//					$this->_db->setQuery($query);
//					@$this->_db->query();
//					/*if ( !$this->_db->query() ) {
//               			JError::raiseError(111, $this->_db->getErrorMsg());
//               			return false;
//            		}*/
//
//					//Speichern der Aufstellung
//					$query = "INSERT INTO #__ttverein_aufstellungen " .
//							" SET mannschafts_id=$id, spieler_id=$spielerID" .
//							", position=$position ";
//					$this->_db->setQuery($query);
//
//					if ( !$this->_db->query() ) {
//               			JError::raiseError(113, $this->_db->getErrorMsg());
//               			return false;
//            		}
//
//				}
//
//			}
//		}
//
		return true;
	}

	function delete($oid=null) {
		$key = $this->_tbl_key;
		if ($oid) {
			$this->$key = intval( $oid );
		}

		//Datenbankverbindung
		$db = &$this->_db;

		/*
		 * Bilder löschen
		 */
//		 //TODO löschen konfigurierbar machen.
//		 //Nicht immer möchte mann, dass auch die Bilder glöscht werden sollen.
//		$query = 'SELECT image_orginal, image_resize, image_thumb ' .
//					' FROM #__ttverein_spieler ' .
//					' WHERE id = ' . $this->$key;
//		$db->setQuery($query);
//		$images = $db->loadObjectList();
//
//		if($images[0]->image_orginal)
//			@unlink(JPATH_ROOT . $images[0]->image_orginal);
//		if($images[0]->image_resize)
//			@unlink(JPATH_ROOT . $images[0]->image_resize);
//		if($images[0]->image_thumb)
//			@unlink(JPATH_ROOT . $images[0]->image_thumb);


		/*
		 * Spielerdaten löschen
		 */
		if(parent::delete($oid) === false)
			return false;

		/*
		 * Zusätliche Felder löschen
		 */
		$query = "DELETE FROM #__mitglieder_mitglieder_felder " .
				" WHERE mitglieder_id = ". $this->$key;
		$db->setQuery( $query );

		if($db->query() === false)
			return false;

		/*
		 * Abteilungen löschen
		 */
		$query = "DELETE FROM #__mitglieder_mitglieder_abteilungen" .
				" WHERE mitglieder_id=" . $this->$key;
		$db->setQuery($query);

		return $db->query();
	}
}
?>
