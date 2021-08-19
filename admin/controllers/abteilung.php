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
class MitgliederControllerAbteilung extends JControllerForm
{
  /**
   * The URL view list variable.
   *
   * @var    string
   * @since  2.0
   */
   protected $view_list = 'abteilungen';

  /**
   * The prefix to use with controller messages.
   *
   * @var    string
   * @since  2.0
   */
   protected $text_prefix = 'COM_MITGLIEDER_ABTEILUNG';
}
