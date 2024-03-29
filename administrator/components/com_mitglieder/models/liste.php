<?php
defined('_JEXEC') or die();

use Joomla\Registry\Registry;

/**
 * Liste admin model.
 *
 * @since  0.9
 */
class MitgliederModelListe extends JModelAdmin
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
	  // There is only one list, and it has an ID of 1.
	  $pk = 1;

      $item = parent::getItem($pk);

      // If the item does not exist yet, set id and insert it to the db.
	  if ($item->id === null) {
		  $pk = (!empty($pk)) ? $pk : (int) $this->getState($this->getName() . '.id');
		  $item->felder_id = $pk;

		  $table = $this->getTable();
		  $table->getDbo()->insertObject($table->getTableName(), $item, 'id');
	  }

	  if (property_exists($item, 'values'))
	  {
		  // Convert the values field to an array.
		  $registry = new Registry($item->values);
		  $item->values = $registry->toArray();
	  }

	  return $item;
  }

  /**
   * Method overwrite to save the form data.
   *
   * @param   array  $data  The form data.
   *
   * @return  boolean  True on success, False on error.
   *
   * @since   2.0
   */
  public function save($data=null)
  {
    if (isset($data['values']) && is_array($data['values']))
    {
      /* Prepare form data as needed for database. */
      $values = array();
      $max_id = max(array_column($data['values'], 'id'));
      foreach ($data['values'] as $value) {
        /* Add id to new elements. */
        if ($value['id'] == 0)
        {
          $max_id += 1;
          $values[$max_id] = $value['title'];
        } else {
          $values[$value['id']] = $value['title'];
        }
      }

      /* Filter empty values from array. */
      $values = array_filter($values);
      /* Convert the values array to JSON. */
      $registry = new Registry($values);
      $data['values'] = (string) $registry;
    }

    if (parent::save($data))
    {
      return true;
    }

    return false;
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
  public function getForm($data = array(), $loadData = true)
  {
    // Get the form.
    $form = $this->loadForm('com_mitglieder.liste', 'liste', array('control' => 'jform', 'load_data' => $loadData));
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
    $data = JFactory::getApplication()->getUserState('com_mitglieder.edit.liste.data', array());
    if (empty($data))
    {
      $data = $this->getItem();
    }

    /* Prepare data structure for form. */
    if (property_exists($data, 'values'))
    {
      $values = array();
      foreach ($data->values as $key => $value) {
        $values['values' . $key] = array('id' => $key, 'title' => $value);
      }
      $data->values = $values;
    }

    $this->preprocessData('com_mitglieder.liste', $data);

    return $data;
  }
}
