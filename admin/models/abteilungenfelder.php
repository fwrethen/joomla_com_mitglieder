<?php


defined('_JEXEC') or die();
jimport('joomla.application.component.model');


/**
 * @author Florian Paetz
 */
class AbteilungenModelAbteilungenFelder extends JModelLegacy
{
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	function setId($id)
	{
		$this->_id		= $id;
	}

	function getData($id=null)
	{
		if($id == null)
			$id = $this->_id;
		$query = ' SELECT felder_id,ordering FROM #__mitglieder_abteilungen_felder '.
				'  WHERE abteilungen_id = '.$id;
		$this->_db->setQuery( $query );
		$data = $this->_db->loadObjectList();

		if($data == null) {
			$data=array();

		}

		return $data;
	}


	function getFelder()
	{
	/*
		 * Alle Abteilungen laden
		 */
		$query = "SELECT id,name_frontend FROM #__mitglieder_felder";
		$this->_db->setQuery( $query );
		$def_obj= new stdClass();
		$def_obj->id='0';
		$def_obj->name_frontend="-";
		return array_merge(array($def_obj),$this->_db->loadObjectList());
	}


	function store($data=null)
	{
		//$row =& $this->getTable();

		if($data == null)
			$data = JRequest::get( 'post' );


		$id=(int)$data['id'];
		//Keine Daten Vorhanden.
		if(!is_array($data)) {
			JError::raiseWarning(191, "Es wurden keine Daten gespeichert");
			return false;
		}

		//Alle Abteilungen löschen und neu speichern
		$query="DELETE FROM #__mitglieder_abteilungen_felder where abteilungen_id = $id";
		$this->_db->setQuery($query);
		if(!$this->_db->query()) {
			JError::raiseError(802, $this->_db->getErrorMsg());
			return false;
		}


		$count=count($data['felder']);
		for($i=0; $i < $count; $i++){
			$feld = $data['felder'][$i];
			$ordering = $data['ordering'][$i];
			if ($feld=='')
				continue;
			if ($ordering=='')
			{
				$ordering='99';
			}
			$query = "INSERT INTO #__mitglieder_abteilungen_felder(" .
					 " `abteilungen_id`, `felder_id`, `ordering`) " .
					 "VALUES ($id,$feld,$ordering)";
			$this->_db->setQuery($query);
			if(!$this->_db->query()) {
				JError::raiseError(802, $this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}


}
?>
