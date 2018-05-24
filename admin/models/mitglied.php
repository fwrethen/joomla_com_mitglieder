<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

/**
 * @author Florian Paetz
 */
class MitgliederModelMitglied extends JModelAdmin
{
	function __construct()
	{
		parent::__construct();

		$input = JFactory::getApplication()->input;
		$this->setId($input->get('id'));
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

	/**
	 * Method overwrite to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success, False on error.
	 *
	 * @since   1.2
	 */
	public function save($data)
	{
		require_once JPATH_COMPONENT . '/helpers/image.php';

		$params = JComponentHelper::getParams('com_mitglieder');
		$img_width = $params->get('mitglied_thumb_width', '180');
		$img_height = $params->get('mitglied_thumb_height', '240');
		$img_path  = JPATH_ROOT . '/';
		$img_path .= JComponentHelper::getParams('com_media')
			->get('image_path', 'images')  . '/';
		$img_path .= $params->get('image_path', 'stories/mitglieder');
		foreach($data['typen'] as $id=>$typ)
		{
			if (($typ == 'bild') && $data['felder'][$id])
			{
				$img_uri = JPATH_ROOT . '/' . $data['felder'][$id];
				ImageHelper::createThumb($img_uri, $img_width, $img_height, $img_path);
			}
		}

		if (parent::save($data))
		{
			return true;
		}

		return false;
	}

	/**
	* Method to retrieve the Abteilungen of the Mitglied.
	*
	* @return  array  An array with the Abteilungen and their respective ordering value.
	*
	* @since   2.0
	*/
	function getAbteilungen()
	{
		$id = $this->_id;

		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query->select($db->quoteName(array('abteilungen_id', 'ordering')));
		$query->from($db->quoteName('#__mitglieder_mitglieder_abteilungen'));
		$query->where($db->quoteName('mitglieder_id') . ' = ' . $db->quote($id));
		$query->order('abteilungen_id ASC');

		$db->setQuery($query);
		$data = $db->loadObjectList();

		if($data == null) {
			$data = array();
		}

		return $data;
	}

	/**
	* Method to retrieve all available Abteilungen.
	*
	* @return  array  An array with all Abteilungen.
	*
	* @since   2.0
	*/
	function getAllAbteilungen()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query->select($db->quoteName(array('id', 'name')));
		$query->from($db->quoteName('#__mitglieder_abteilungen'));
		$query->order('id ASC');

		$db->setQuery($query);
		$data = $db->loadObjectList();

		$def_obj = new stdClass();
		$def_obj->name = '-';

		$data = array_merge(array($def_obj), $data);
		return $data;
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
			switch ($feld->typ) {
				case 'text':
					$formmitglied .= '<field name="'.$feld->id.'" type="textarea"
						label="'.$feld->name.'" description="'.$feld->tooltip.'" />';
					break;
				case 'text_html':
					$formmitglied .= '<field name="'.$feld->id.'" type="editor"
						label="'.$feld->name.'" description="'.$feld->tooltip.'" />';
					break;
				case 'email':
					$formmitglied .= '<field name="'.$feld->id.'" type="email"
						label="'.$feld->name.'" description="'.$feld->tooltip.'"
						validate="email" />';
					break;
				case 'telefon':
					$formmitglied .= '<field name="'.$feld->id.'" type="tel"
						label="'.$feld->name.'" description="'.$feld->tooltip.'"
						validate="tel" />';
					break;
				case 'jahre seit':
					$formmitglied .= '<field name="'.$feld->id.'" type="calendar"
						label="'.$feld->name.'" description="'.$feld->tooltip.'"
						format="%Y-%m-%d" />';
					break;
				case 'bild':
					$formmitglied .= '<field name="'.$feld->id.'" type="media"
						label="'.$feld->name.'" description="'.$feld->tooltip.'"
						directory="'.$image_path.'" preview="true" />';
					break;
			}
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
