<?php
/**
* @package     Joomla.Administrator
* @subpackage  com_mitglieder
*
* @copyright   Copyright (C) 2018
* @license     GNU General Public License version 2 or later; see LICENSE.txt
*/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

//JLoader::register('MitgliederHelper', JPATH_COMPONENT . '/helpers/mitglieder.php');

/**
* Mitglieder master display controller.
*
* @package     Joomla.Administrator
* @subpackage  com_mitglieder
* @since       2.0
*/
class MitgliederController extends JControllerLegacy
{
	/**
	 * The default view for the display method.
	 *
	 * @var string
	 * @since 2.0
 	*/
	protected $default_view = 'mitglieder';

	/**
	* Method to display a view.
	*
	* @param   boolean  $cachable   If true, the view output will be cached
	* @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	*
	* @return  MitgliederController  This object to support chaining.
	*
	* @since   2.0
	*/
	public function display($cachable = false, $urlparams = array())
	{
		$view   = $this->input->get('view', 'mitglieder');
		$layout = $this->input->get('layout', 'default');
		$id     = $this->input->getInt('id');
		// Check for edit form.
		if ($view == 'mitglied' && $layout == 'edit' && !$this->checkEditId('com_mitglieder.edit.mitglied', $id))
		{
			// Somehow the person just went to the form - we don't allow that.
			$error = JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id);
			$this->setMessage($error, 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_mitglieder&view=mitglieder', false));
			return false;
		}
		elseif ($view == 'abteilung' && $layout == 'edit' && !$this->checkEditId('com_mitglieder.edit.abteilung', $id))
		{
			// Somehow the person just went to the form - we don't allow that.
			$error = JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id);
			$this->setMessage($error, 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_mitglieder&view=abteilungen', false));
			return false;
		}
		return parent::display();
	}
}
