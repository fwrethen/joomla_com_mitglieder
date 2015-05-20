<?php
defined('_JEXEC') or die('Restricted access');

class com_MitgliederInstallerScript
{
	function install($parent)
	{
	}

	function uninstall($parent)
	{
		if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
		require_once( JPATH_ADMINISTRATOR .DS. 'components' .DS. 'com_mitglieder' .DS. 'lib'.DS. 'config'.DS. 'config.php' );
		require_once( JPATH_ADMINISTRATOR .DS. 'components' .DS. 'com_mitglieder' .DS. 'lib'.DS. 'upload'.DS. 'image.php' );

		$db = JFactory::getDBO();
		$config = Config::getConfig(array("delete_database","delete_pictures"));

		/*
		 * Löschen der Mitgliederbilder
		 */
		if($config['delete_pictures'] == "1") {
			$query = "SELECT image_original, image_resize, image_thumb
				FROM #__mitglieder_mitglieder";
			$db->setQuery( $query );
			$images = $db->loadObjectList();
			Image::deleteImages($images);
			echo '<p>Mitgliederbilder wurden gel&ouml;scht.</p>';
		}
		else echo '<p>Mitgliederbilder wurden nicht gel&ouml;scht.</p>';

		/*
		 * Löschen der Datenbank-Tabellen
		 */
		if($config['delete_database'] == "1") {
			$query = "DROP TABLE IF EXISTS #__mitglieder_abteilungen, " .
				" #__mitglieder_felder, " .
				" #__mitglieder_listen, " .
				" #__mitglieder_mitglieder, " .
				" #__mitglieder_mitglieder_felder, " .
				" #__mitglieder_mitglieder_abteilungen," .
				" #__mitglieder_abteilungen_felder," .
				" #__mitglieder_config ";
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
