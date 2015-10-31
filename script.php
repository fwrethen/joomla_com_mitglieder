<?php
defined('_JEXEC') or die('Restricted access');

class com_MitgliederInstallerScript
{
	function install($parent)
	{
	}

	function uninstall($parent)
	{
		jimport('joomla.filesystem.file');

		$db = JFactory::getDBO();
		$params = JComponentHelper::getParams('com_mitglieder');

		/*
		 * Löschen der Mitgliederbilder
		 */
		// TODO: Rewrite
		/*if ($params->get('delete_pictures', '0')) {
			$query = "SELECT image_original, image_resize, image_thumb
				FROM #__mitglieder_mitglieder";
			$db->setQuery( $query );
			$images = $db->loadObjectList();
			JFile::delete($images);
			echo '<p>Mitgliederbilder wurden gel&ouml;scht.</p>';
		}
		else*/ echo '<p>Mitgliederbilder wurden nicht gel&ouml;scht.</p>';

		/*
		 * Löschen der Datenbank-Tabellen
		 */
		if ($params->get('delete_database', '0')) {
			$query = "DROP TABLE IF EXISTS #__mitglieder_abteilungen, " .
				" #__mitglieder_felder, " .
				" #__mitglieder_listen, " .
				" #__mitglieder_mitglieder, " .
				" #__mitglieder_mitglieder_felder, " .
				" #__mitglieder_mitglieder_abteilungen";
			$db->setQuery( $query );
			$db->query();
			echo '<p>Datenbankeintr&auml;ge wurden gel&ouml;scht.</p>';
		}
		else echo '<p>Datenbankeintr&auml;ge wurden nicht gel&ouml;scht.</p>';
	}

	function update($parent)
	{
	}

	function preflight($type, $parent)
	{
	}

	function postflight($type, $parent)
	{
	}
}
