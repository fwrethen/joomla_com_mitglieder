<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
jimport('joomla.application.component.model');

require_once( JPATH_ADMINISTRATOR .DS. 'components' .DS. 'com_mitglieder' .DS. 'lib'.DS. 'logger.php' );

/**
 * @author Florian Paetz
 */
class MitgliederModelMitglied extends JModelAdmin
{
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	/**
	 * Beim Erzeugen des Objektes setzt Joomla automatisch die ID
	 *
	 * @access public
	 * @param int $id
	 */
	function setId($id) {
		$this->_id		= intval($id);
	}


	/**
	 * Läd die Spielerdaten, alle Mannschaften mit ihrer Altersklasse
	 * und Alle Mannschaften in der der Spieler aufgestellt ist.
	 *
	 * @access	public
	 * @return mixed Ein Objekt mit allen Spielerdaten.
	 */
	function getData()
	{
		$row = $this->getTable();
		$row->load($this->_id);

		return $row;
	}

	/**
	 * Speichert die Spielerdaten und die Aufstellung
	 *
	 * @access public
	 * @param array $data Is $data = null wird versucht über
	 * JRequest::get( 'post' ) an die Daten zu gelangen.
	 * @return	boolean	True bei Erfolg
	 */
	function store(&$data=null)
	{
		if($data == null)
			$data = JRequest::get( 'post' );


		//Keine Daten Vorhanden.
		if(!is_array($data))
		{
			Logger::log('No Data');
			return false;

		}
		Logger::logArray($data);

		//Speichern der Spielerdaten
		$row =& $this->getTable();

		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->store(true)) {
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}
		$data['id']=$row->id;

		return true;
	}

	/**
	 * Löscht alle Spieler Daten
	 *
	 * @access	public
	 * @return	boolean	True bei Erfolg
	 */
	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );


		if (count( $cids ) > 0)
		{
			foreach($cids as $cid) {
				$row =& $this->getTable();
				/*
				 * Felder löschen
				 */
				$query = "DELETE FROM #__mitglieder_mitglieder_felder " .
						" WHERE mitglieder_id=" . $cid;
				$this->_db->setQuery($query);
				if ( !$this->_db->query() ) {
					JError::raiseError(105, $this->_db->getErrorMsg());
               		return false;
				}

				/*
				 * Mitgliederzuordnungen löschen
				 */
				$query = "DELETE FROM #__mitglieder_mitglieder_abteilungen " .
						" WHERE mitglieder_id=" . $cid;
				$this->_db->setQuery($query);
				if ( !$this->_db->query() ) {
					JError::raiseError(105, $this->_db->getErrorMsg());
               		return false;
				}
				/*
				 * Spieler löschen
				 */

				if (!$row->delete( $cid )) {
					return false;
				}
			}
		}
		return true;
	}

	public function getForm($data = array(), $loadData = true)
	{
		$params = JComponentHelper::getParams('com_mitglieder');
		$image_path = $params->get('image_path', 'stories/mitglieder');
		$formmitglied = '<?xml version="1.0" encoding="utf-8"?>
			<form><fieldset name="details">';
		//TODO: merge this with mitglied/view.html.php and|or move to controller
		$player	= $this->getData();
		foreach($player->felder as $id=>$feld) {
			if ($feld->typ == 'bild')
				$formmitglied .= '<field name="'.$feld->id.'" type="media"
					directory="'.$image_path.'"
					label="'.$feld->name.'" preview="true" />';
		}
		$formmitglied .= '</fieldset></form>';
		// Get the form.
		$form = $this->loadForm('com_mitglieder.mitglied', $formmitglied, array('control' => 'felder', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}

}
?>
