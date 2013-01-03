<?php


defined('_JEXEC') or die('Restricted access');

class TableAbteilung extends JTable
{
	/** @var int Primary key */
	var $id					= 0;

	var $name				= null;

	var $description		= null;

	function TableAbteilung(& $db) {
		parent::__construct('#__mitglieder_abteilungen', 'id', $db);
	}
}
?>