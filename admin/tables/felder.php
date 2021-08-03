<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_mitglieder
 *
 * @copyright   Copyright (C) 2019
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Felder table
 *
 * @since  2.0
 */
class TableFelder extends JTable
{
  /**
   * Constructor
   *
   * @param   JDatabaseDriver  $db  Database connector object
   *
   * @since   2.0
   */
  function __construct($db)
  {
    parent::__construct('#__mitglieder_felder', 'id', $db);
  }
}
