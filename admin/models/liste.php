<?php
defined('_JEXEC') or die();

use Joomla\Registry\Registry;

/**
 * Liste admin model.
 *
 * @since  1.6
 */
class MitgliederModelListe extends JModelAdmin
{
  /**
   * Constructor.
   *
   * @param   array  $config  An optional associative array of configuration settings.
   *
   * @since   2.0
   */
  function __construct($config = array())
  {
    parent::__construct($config);

    $input = JFactory::getApplication()->input;
    if (isset($config['id']))
      $this->setId($config['id']);
    else
      $this->setId($input->get('id'));
  }

  function setId($id)
  {
    $this->_id		= $id;
  }

  /**
   * Unimplemented method for getting the form from the model.
   *
   * @param   array    $data      Data for the form.
   * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
   *
   * @return  \JForm|boolean  A \JForm object on success, false on failure
   *
   * @since   2.0
   */
  function getForm($data = array(), $loadData = true)
  {
    return false;
  }

  /**
   * Method to get a single record.
   *
   * @return  \JObject|boolean  Object on success, false on failure.
   *
   * @since   2.0
   */
  function getData()
  {
    $row = $this->getTable();
    $row->load($this->_id);

    if ($row->values)
    {
      // Convert the values field to an array.
      $registry = new Registry($row->values);
      $row->values = $registry->toArray();
    }
    return $row;
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
  function save($data=null)
  {
    /* Convert the values array to JSON. */
    if (isset($data['values']) && is_array($data['values']))
    {
      /* Filter empty values from array. */
      $values = array_filter($data['values']);
      $registry = new Registry($values);
      $data['values'] = (string) $registry;
    }

    if (parent::save($data))
    {
      return true;
    }

    return false;
  }
}
