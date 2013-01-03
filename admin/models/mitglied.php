<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

require_once( JPATH_ADMINISTRATOR .DS. 'components' .DS. 'com_mitglieder' .DS. 'lib'.DS. 'config'.DS. 'config.php' );
require_once( JPATH_ADMINISTRATOR .DS. 'components' .DS. 'com_mitglieder' .DS. 'lib'.DS. 'logger.php' );

/**
 * @author Florian Paetz
 */
class MitgliederModelMitglied extends JModel
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
		$row =& $this->getTable();
		$row->load($this->_id);

		return $row;
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
				 * Felder l�schen löschen
				 */
				$query = "DELETE FROM #__mitglieder_mitglieder_felder " .
						" WHERE mitglieder_id=" . $cid;
				$this->_db->setQuery($query);
				if ( !$this->_db->query() ) {
					JError::raiseError(105, $this->_db->getErrorMsg());
               		return false;
				}

				/*
				 * Mitgliederzuordnungen l�schen löschen
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


}
?>
