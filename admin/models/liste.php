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
   * Method to get a single record.
   *
   * @param   integer  $pk  The id of the primary key.
   *
   * @return  \JObject|boolean  Object on success, false on failure.
   *
   * @since   2.0
   */
  function getItem($pk = null)
  {
    $item = parent::getItem($pk);

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
  function getForm($data = array(), $loadData = true)
  {
    return false;
  }
}
