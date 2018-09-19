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
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @since   0.9
	 */
	function __construct($config = array())
	{
		parent::__construct($config);
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
	function delete(&$pks)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$row =& $this->getTable();

		if (count( $pks ))
		{
			foreach($pks as $pk) {
				/*
				 * Mitgliederzuordnungen löschen
				 */
				$query->delete()
					->from($db->quoteName('#__mitglieder_mitglieder_abteilungen'))
					->where($db->quoteName('abteilungen_id') . ' = ' . $db->quote($pk));
				$db->setQuery($query);

				if (!$db->query()) {
					JError::raiseError(105, $this->_db->getErrorMsg());
					return false;
				}

				/*
				 * Abteilung löschen
				 */
				if (!$row->delete( $pk )) {
					JError::raiseError(106, $this->_db->getErrorMsg());
					return false;
				}

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
		$form = $this->loadForm('com_mitglieder.abteilung', 'abteilung', array('control' => '', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}

}
?>
