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
			$this->felder[$feld->id]->id = $feld->id;
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
	function load($keys = NULL, $reset = true) {

		//Spielerdaten Laden
		if(parent::load($keys) === false)
			return false;

		//Datenbankverbindung
		$db = &$this->_db;

		//Nachdem parent::load() aufgerufen wurde, ist die ID auf jden fall im Objekt
		$key = $this->_tbl_key;
		$id = $this->$key;




		/*
		 * Zusätzliche Spielerfelder laden
		 */

		$query = "select mitglieder_id, f1.name_backend,a.felder_id, f1.typ, f1.tooltip, kurz_text, `text`, datum, listen_id " .
		"from #__mitglieder_mitglieder_felder as a, #__mitglieder_felder as f1 " .
		"where a.felder_id= f1.id AND mitglieder_id = $keys order by f1.ordering, f1.id ASC";

		/*gehört ins frontend
		 * $query = "select mitglieder_id, f1.name_backend,a.felder_id, f1.typ, kurz_text, `text`, wert " .
		"from (select mitglieder_id, felder_id, kurz_text,`text`, wert " .
		"from #__mitglieder_mitglieder_felder as f LEFT JOIN #__mitglieder_listen as l ".
		"on l.id=f.listen_id ) as a, #__mitglieder_felder as f1 " .
		"where a.felder_id= f1.id AND mitglieder_id = $keys order by f1.ordering, f1.id ASC";
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
				case 'text_html':
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
				case 'text_html':
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
