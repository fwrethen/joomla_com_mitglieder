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
class MitgliederControllerListe extends JControllerForm
{
  /**
   * The URL view list variable.
   *
   * @var    string
   * @since  2.0
   */
   protected $view_list = 'listen';

  /**
   * The prefix to use with controller messages.
   *
   * @var    string
   * @since  2.0
   */
   protected $text_prefix = 'COM_MITGLIEDER_LISTE';

	/**
	 * @var string
	 * @since 2.0
	 */
	protected $redirectPath = 'index.php?option=com_mitglieder&view=liste&layout=edit';

	/**
	 * @param string $key
	 * @return bool
	 * @since 2.0
	 */
	public function cancel($key = null)
	{
		$result = parent::cancel($key);

		$msg = JText::_('Änderungen verworfen');
		$this->setRedirect($this->redirectPath, $msg);

		return $result;
	}

	/**
	 * @param string $key
	 * @param string $urlVar
	 * @return bool
	 * @since 2.0
	 */
	public function save($key = null, $urlVar = null)
	{
		$result = parent::save($key, $urlVar);

		$msg = $result ? JText::_('Liste gespeichert') : JText::_('Fehler beim Speichern');
		$this->setRedirect($this->redirectPath, $msg);

		return $result;
	}
}
