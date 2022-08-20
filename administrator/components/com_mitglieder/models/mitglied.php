<?php
defined('_JEXEC') or die();

/**
 * Mitglied admin model.
 *
 * @since  0.9
 */
class MitgliederModelMitglied extends JModelAdmin
{
  /**
   * Method to get a single record.
   *
   * @param   integer  $pk  The id of the primary key.
   *
   * @return  \JObject|boolean  Object on success, false on failure.
   *
   * @since   2.0
   */
  public function getItem($pk = null)
	{
		$pk = (!empty($pk)) ? $pk : (int) $this->getState($this->getName() . '.id');
		$table = $this->getTable();

		if ($pk > 0)
		{
			// Attempt to load the row.
			$table->load($pk);
		}

		return $table;
	}

	/**
	 * Method to delete one or more records.
	 *
	 * @param   array  &$pks  An array of record primary keys.
	 *
	 * @return  boolean  True if successful, false if an error occurs.
	 *
	 * @since   0.9
	 */
	public function delete(&$pks)
	{
		if (count($pks) > 0)
		{
			foreach($pks as $pk) {
				$row = $this->getTable();
				/*
				 * Felder löschen
				 */
				$query = "DELETE FROM #__mitglieder_mitglieder_felder " .
						" WHERE mitglieder_id=" . $pk;
				$this->_db->setQuery($query);
				$this->_db->execute();

				/*
				 * Mitgliederzuordnungen löschen
				 */
				$query = "DELETE FROM #__mitglieder_mitglieder_abteilungen " .
						" WHERE mitglieder_id=" . $pk;
				$this->_db->setQuery($query);
				$this->_db->execute();
				/*
				 * Spieler löschen
				 */

				if (!$row->delete($pk)) {
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
			->get('image_path', 'images') . '/';
		$img_path .= $params->get('image_path', 'stories/mitglieder');
		foreach($data['typen'] as $id=>$typ)
		{
			if (($typ == 'bild') && $data['felder'][$id])
			{
				$img_uri = JPATH_ROOT . '/' . $data['felder'][$id];
				ImageHelper::createThumb($img_uri, $img_width, $img_height, $img_path);
			}
		}

		return parent::save($data);
	}

	/**
	 * Method to save the Abteilungen of the Mitglied.
	 *
	 * @param   array $data The form data.
	 *
	 * @return  boolean  True on success, False on error.
	 *
	 * @since   2.0
	 * @throws Exception
	 */
	public function saveAbteilungen($data)
	{
		$id=(int) $data['id'];

		//Keine Daten Vorhanden.
		if(!is_array($data)) {
			throw new Exception("Es wurden keine Daten gespeichert");
		}

		//Alle Abteilungen löschen und neu speichern
		$query="DELETE FROM #__mitglieder_mitglieder_abteilungen where mitglieder_id = $id";
		$this->_db->setQuery($query);
		$this->_db->execute();

		$count=count($data['abteilung']);

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

			$this->_db->setQuery($query);
			$this->_db->execute();
		}

		return true;
	}

	/**
	* Method to retrieve the Abteilungen of the Mitglied.
	*
	* @return  array  An array with the Abteilungen and their respective ordering value.
	*
	* @since   2.0
	*/
	public function getAbteilungen()
	{
		$id = (int) $this->getState($this->getName() . '.id');

		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query->select($db->qn(array('abteilungen_id', 'ordering')));
		$query->from($db->qn('#__mitglieder_mitglieder_abteilungen'));
		$query->where($db->qn('mitglieder_id') . ' = ' . $db->q($id));
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
	public function getAllAbteilungen()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query->select($db->qn(array('id', 'name')));
		$query->from($db->qn('#__mitglieder_abteilungen'));
		$query->order('id ASC');

		$db->setQuery($query);
		$data = $db->loadObjectList();

		$def_obj = new stdClass();
		$def_obj->name = '-';

		$data = array_merge(array($def_obj), $data);

		return $data;
	}

	/**
	 * Method for getting the form from the model.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  \JForm|boolean  A \JForm object on success, false on failure
	 *
	 * @since   1.0
	 */
	public function getForm($data = array(), $loadData = true)
	{
		$params = JComponentHelper::getParams('com_mitglieder');
		$image_path = $params->get('image_path', 'stories/mitglieder');
		$formmitglied = '<?xml version="1.0" encoding="utf-8"?>
			<form><fieldset name="details">';
		//TODO: merge this with mitglied/view.html.php and|or move to controller
		$player	= $this->getItem();
		foreach($player->felder as $id=>$feld) {
			switch ($feld->typ) {
				case 'text':
					$formmitglied .= '<field name="' . $feld->id . '" type="textarea"
						label="' . $feld->name . '" description="' . $feld->tooltip . '" />';
					break;
				case 'text_html':
					$formmitglied .= '<field name="' . $feld->id . '" type="editor"
						label="' . $feld->name . '" description="' . $feld->tooltip . '" />';
					break;
				case 'email':
					$formmitglied .= '<field name="' . $feld->id . '" type="email"
						label="' . $feld->name . '" description="' . $feld->tooltip . '"
						validate="email" />';
					break;
				case 'telefon':
					$formmitglied .= '<field name="' . $feld->id . '" type="tel"
						label="' . $feld->name . '" description="' . $feld->tooltip . '"
						validate="tel" />';
					break;
				case 'jahre seit':
					$formmitglied .= '<field name="' . $feld->id . '" type="calendar"
						label="' . $feld->name . '" description="' . $feld->tooltip . '"
						format="%Y-%m-%d" />';
					break;
				case 'bild':
					$formmitglied .= '<field name="' . $feld->id . '" type="media"
						label="' . $feld->name . '" description="' . $feld->tooltip . '"
						directory="' . $image_path . '" preview="true" />';
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
