<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_mitglieder
 *
 * @copyright   Copyright (C) 2018
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Liste table
 *
 * @since  2.0
 */
class TableListe extends JTable
{
  /**
   * Constructor
   *
   * @param   JDatabaseDriver  $db  Database connector object
   *
   * @since   2.0
   */
  public function __construct($db)
  {
    parent::__construct('#__mitglieder_listen', 'id', $db);
  }

  public function getKeyName($multiple = false): string
  {
	  return 'felder_id';
  }
}
