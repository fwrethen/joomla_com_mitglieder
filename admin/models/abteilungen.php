<?php
defined('_JEXEC') or die();

class MitgliederModelAbteilungen extends JModelList
{
  /**
   * Method to auto-populate the model state.
   *
   * @return  void
   *
   * @note    Calling getState in this method will result in recursion.
   * @since   2.0
   */
  protected function populateState()
  {
    // Set list limit to no limit.
    $this->setState('list.limit', 0);
    $this->setState('list.start', 0);
  }
  
  /**
   * Method to get a \JDatabaseQuery object for retrieving the data set from a database.
   *
   * @return  \JDatabaseQuery  A \JDatabaseQuery object to retrieve the data set.
   *
   * @since   2.0
   */
  function getListQuery()
  {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select($db->quoteName(array('id', 'name', 'description')));
    $query->from($db->quoteName('#__mitglieder_abteilungen'));
    $query->order('id ASC');

    return $query;
  }
}
