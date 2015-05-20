<?php

defined('_JEXEC') or die();
jimport('joomla.application.component.model');


/**
 * @author Florian Paetz
 */
class AbteilungenModelAbteilung extends JModelLegacy
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
		$query = ' SELECT * FROM #__mitglieder_abteilungen '.
				'  WHERE id = '.$id;
		$this->_db->setQuery( $query );
		$data = $this->_db->loadObject();

		if($data == null) {
			$data = new stdClass();
			$data->id 					= 0;


			$data->name				= null;
			$data->description		= null;

		}

		return $data;
	}

	function store($data=null)
	{
		$row =& $this->getTable();

		if($data == null)
			$data = JRequest::get( 'post' );

		//Keine Daten Vorhanden.
		if(!is_array($data)) {
			JError::raiseWarning(191, "Es wurden keine Daten gespeichert");
			return false;
		}

		/*
		 * String(0)'' Values werden herrausgefiltert, damit sie in nicht
		 * als String sondern mit null in die Datenbank gespeidchert werden.
		 */
		foreach($data as $key=>$value) {
			if(trim($value) == '')
				$data[$key] = null;
		}

		if (!$row->bind($data)) {
			JError::raiseError(101, $this->_db->getErrorMsg());
			return false;
		}

		if (!$row->check()) {
			JError::raiseError(102, $this->_db->getErrorMsg());
			return false;
		}

		if (!$row->store(true)) {
			JError::raiseError(103, $this->_db->getErrorMsg());
			return false;
		}

		return true;
	}

	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$row =& $this->getTable();

		if (count( $cids ))
		{
			foreach($cids as $cid) {
//				 /*
//				  * Bilder löschen
//				  */
//				 //TODO löschen konfigurierbar machen.
//				 //Nicht immer möchte mann, dass auch die Bilder glöscht werden sollen.
//				$query = 'SELECT image_orginal, image_resize, image_thumb ' .
//							' FROM #__ttverein_mannschaften ' .
//							' WHERE id = ' . $cid;
//				$images = $this->_getList($query);
//				@unlink(JPATH_ROOT . $images[0]->image_orginal);
//				@unlink(JPATH_ROOT . $images[0]->image_resize);
//				@unlink(JPATH_ROOT . $images[0]->image_thumb);

				/*
				 * Mitgliederzuordnungen löschen
				 */
				$query = "DELETE FROM #__mitglieder_mitglieder_abteilungen " .
						" WHERE abteilungen_id=" . $cid;
				$this->_db->setQuery($query);
				if ( !$this->_db->query() ) {
					JError::raiseError(105, $this->_db->getErrorMsg());
               		return false;
				}

				/*
				 * Abteilung löschen
				 */
				if (!$row->delete( $cid )) {
					JError::raiseError(106, $this->_db->getErrorMsg());
					return false;
				}

			}
		}
		return true;
	}



}
?>
