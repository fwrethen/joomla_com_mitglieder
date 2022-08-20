<?php
defined('_JEXEC') or die();

class MitgliederModelFelder extends JModelAdmin
{
	/**
	 * Method to get an array of data items.
	 *
	 * @return  array  An array of data items.
	 *
	 * @since   2.0
	 */
	public function getItems()
	{
		$this->getDbo()->setQuery($this->getListQuery(), 0, 0);

		return $this->getDbo()->loadObjectList();
	}

	/**
	 * Method to get a \JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return  \JDatabaseQuery  A \JDatabaseQuery object to retrieve the data set.
	 *
	 * @since   2.0
	 */
	public function getListQuery()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select($db->qn(['id', 'name_backend', 'name_frontend', 'typ', 'show', 'tooltip', 'ordering']));
		$query->from($db->qn('#__mitglieder_felder'));
		$query->order('ordering, id ASC');

		return $query;
	}

	/**
	 * Method for getting the form from the model.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  \JForm|boolean  A \JForm object on success, false on failure
	 *
	 * @since   2.0
	 */
	public function getForm($data = [], $loadData = true) {
		$form = $this->loadForm('com_mitglieder.feld', 'feld', ['control' => 'jform', 'load_data' => $loadData]);
		if (empty($form)) {
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
	 * @throws  Exception
	 */
	protected function loadFormData()
	{
		$data = $this->getItems();

		/* Prepare data structure for form. */
		if (is_array($data))
		{
			$values = [];
			foreach ($data as $item) {
				$values['values'][] = $item;
			}

			$data = $values;
		}

		$this->preprocessData('com_mitglieder.felder', $data);

		return $data;
	}

	/**
	 * Method to get an array of the supported field types. Key is the internal reference, value the display name.
	 *
	 * @return  array   An array of field types.
	 *
	 * @since   2.0
	 */
	public function getTypes()
	{
		return [
			'text' => 'Text',
			'text_html' => 'HTML',
			'email' => 'E-Mail',
			'telefon' => 'Telefon',
			'datum' => 'Datum',
			'jahre seit' => 'Jahre seit',
			'liste' => 'Liste',
			'bild' => 'Bild',
		];
	}

	/**
	 * @param array $data
	 *
	 * @return bool
	 *
	 * @since 0.9
	 */
	public function store($data = null)
	{
		$query = '';
		$ordering = 0;

		foreach ($data['values'] as $field) {
			$id = (int) $field['id'];
			$ordering++;
			// Special care needs to be taken with saving a checkbox from a form!! This is a common mistake.
			// You see, on saving a form with a checkbox that is unchecked, there is no variable for it in the POST
			// information and joomla does not take care of that yet!
			$show = isset($field['show']) ? 1 : 0;

			if ($id > 0) {
				$query .= sprintf(
				    "UPDATE #__mitglieder_felder SET name_backend='%s', name_frontend='%s', `show`=%s, tooltip='%s', typ='%s', ordering=%s WHERE id=%s;",
				    $field['name_backend'],
				    $field['name_frontend'],
				    $show,
				    $field['tooltip'],
				    $field['typ'],
				    $ordering,
				    $field['id']
				);
			} else {
				$query .= sprintf(
				    "INSERT INTO #__mitglieder_felder(name_backend, name_frontend,  `show`, tooltip, typ, ordering) VALUES( '%s', '%s', %s, '%s', '%s', %s);",
				    $field['name_backend'],
				    $field['name_frontend'],
				    $show,
				    $field['tooltip'],
				    $field['typ'],
				    $ordering
				);
			}
		}

		foreach ($data['deleted'] as $id => $val) {
			$query .= "DELETE FROM #__mitglieder_felder WHERE id=$id;";
		}

		if (empty($query)) {
			return false;
		}

		$this->_db->setQuery($query);
		$this->_db->execute();

		return true;
	}
}
