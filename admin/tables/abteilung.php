<?php
defined('_JEXEC') or die('Restricted access');

class TableAbteilung extends JTable
{
	function __construct($db) {
		parent::__construct('#__mitglieder_abteilungen', 'id', $db);
	}
}
