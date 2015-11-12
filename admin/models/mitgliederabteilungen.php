<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.model');
require_once( JPATH_COMPONENT . '/lib/logger.php' );


/**
 * @author Florian Paetz
 */
class MitgliederModelMitgliederAbteilungen extends JModelLegacy
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
		$query = ' SELECT abteilungen_id,ordering FROM #__mitglieder_mitglieder_abteilungen '.
				'  WHERE mitglieder_id = '.$id;
		$this->_db->setQuery( $query );
		$data = $this->_db->loadObjectList();

		if($data == null) {
			$data=array();

		}

		return $data;
	}


	function getAbteilungen()
	{
	/*
		 * Alle Abteilungen laden
		 */
		$query = "SELECT id,name FROM #__mitglieder_abteilungen";
		$this->_db->setQuery( $query );
		$def_obj= new stdClass();
		$def_obj->name="-";
		return array_merge(array($def_obj),$this->_db->loadObjectList());
		//$ret_array=$this->_db->loadObjectList();
		//array_unshift($ret_array, $def_obj);
		//return $ret_array;
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

		Logger::log('Delete old entries');
		//Alle Abteilungen löschen und neu speichern
		$query="DELETE FROM #__mitglieder_mitglieder_abteilungen where mitglieder_id = $id";
		$this->_db->setQuery($query);
		if(!$this->_db->query()) {
			Logger::log( 'Err:Delete old entries'.$this->_db->getErrorMsg());
			JError::raiseError(802, $this->_db->getErrorMsg());
			return false;
		}

		Logger::log('Done:Delete old entries');

		$count=count($data['abteilung']);
		Logger::log( 'Have '.$count.'Abteilung');

		for($i=0; $i < $count; $i++){
			$abteilung = $data['abteilung'][$i];
			$ordering = $data['ordering'][$i];
			if ($abteilung=='')
				continue;
			if ($ordering=='')
			{
				$ordering='99';
			}
			$query = "INSERT INTO #__mitglieder_mitglieder_abteilungen(" .
					 "`mitglieder_id`, `abteilungen_id`, `ordering`) " .
					 "VALUES ($id,$abteilung,$ordering)";
			Logger::log('Insert new Entry: '.$query);
			$this->_db->setQuery($query);
			if(!$this->_db->query()) {
				Logger::log( 'Err:Insert new entries'.$this->_db->getErrorMsg());
				JError::raiseError(802, $this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}


}
?>
