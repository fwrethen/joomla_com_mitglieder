<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_mitglieder
 *
 * @copyright   Copyright (C) 2018
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Mitglied controller class.
 *
 * @since  2.0
 */
class MitgliederControllerMitglied extends JControllerForm
{
  /**
   * The URL view list variable.
   *
   * @var    string
   * @since  2.0
   */
   protected $view_list = 'mitglieder';

  /**
   * The prefix to use with controller messages.
   *
   * @var    string
   * @since  2.0
   */
   protected $text_prefix = 'COM_MITGLIEDER_MITGLIED';

  /**
   * Method to save a record.
   *
   * @param   string  $key     The name of the primary key of the URL variable.
   * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
   *
   * @return  boolean  True if successful, false otherwise.
   *
   * @since   2.0
   */
  public function save($key = null, $urlVar = null)
  {
      // Check for request forgeries.
      $this->checkToken();

      $model = $this->getModel();

      /* TODO: Use $this->input->post instead. But then array indices are not kept.
       *       Atm indices are used to map ids. So we to change the form data structure before. */
      $data = JRequest::get('post', 2);

      $url = 'index.php?option=' . $this->option . '&view=' . $this->view_list
              . $this->getRedirectToListAppend();
      $this->setRedirect(\JRoute::_($url, false));

      if ($model->save($data) && $model->saveAbteilungen($data))
      {
        $this->setMessage(\JText::_('JLIB_APPLICATION_SAVE_SUCCESS'));

        return true;
      } else {
        $error = \JText::_('JLIB_APPLICATION_ERROR_SAVE_FAILED');
        $this->setMessage($error, 'error');

        return false;
      }
  }
}
