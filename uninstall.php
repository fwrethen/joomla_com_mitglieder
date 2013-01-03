<?php
defined('_JEXEC') or die('Restricted access');
require( JPATH_ADMINISTRATOR .DS. 'components' .DS. 'com_mitglieder' .DS. 'lib'.DS. 'config'.DS. 'config.php' );
require( JPATH_ADMINISTRATOR .DS. 'components' .DS. 'com_mitglieder' .DS. 'lib'.DS. 'upload'.DS. 'image.php' );

$db = &JFactory::getDBO();

$config = Config::getConfig(array("delete_database","delete_pictures"));

/*
 * Löschen der Mitgliederbilder
 */
if($config['delete_pictures'] == "1") {
	$query = "SELECT image_orginal, image_resize, image_thumb 
				FROM #__mitglieder_mitglieder";
	$db->setQuery( $query );
	$images = $db->loadObjectList();
	Image::deleteImages($images);
}

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
}
?>