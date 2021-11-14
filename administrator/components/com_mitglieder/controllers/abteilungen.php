<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class MitgliederControllerAbteilungen extends JControllerAdmin
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Method to get a model object, loading it if required.
   *
   * @param   string  $name    The model name. Optional.
   * @param   string  $prefix  The class prefix. Optional.
   * @param   array   $config  Configuration array for model. Optional.
   *
   * @return  JModelLegacy  The model.
   *
   * @since   2.0
   */
  public function getModel($name = 'Abteilung', $prefix = 'MitgliederModel', $config = array('ignore_request' => true))
  {
    return parent::getModel($name, $prefix, $config);
  }
}
