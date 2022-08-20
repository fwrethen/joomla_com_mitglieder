<?php
defined('_JEXEC') or die();

/**
 * Abteilung admin model.
 *
 * @since  0.9
 */
class MitgliederModelAbteilung extends JModelAdmin
{
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
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$row = $this->getTable();

		if (count($pks))
		{
			foreach($pks as $pk) {
				/*
				 * Mitgliederzuordnungen löschen
				 */
				$query->delete()
					->from($db->qn('#__mitglieder_mitglieder_abteilungen'))
					->where($db->qn('abteilungen_id') . ' = ' . $db->q($pk));
				$db->setQuery($query);

				$db->execute();

				// Abteilung löschen
				$row->delete($pk);
			}
		}

		return true;
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
		// Get the form.
		$form = $this->loadForm('com_mitglieder.abteilung', 'abteilung', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   2.0
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_mitglieder.edit.abteilung.data', array());
		if (empty($data))
		{
			$data = $this->getItem();
		}
		$this->preprocessData('com_mitglieder.abteilung', $data);

		return $data;
	}
}
