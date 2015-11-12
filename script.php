<?php
defined('_JEXEC') or die('Restricted access');

class com_MitgliederInstallerScript
{
	function install($parent)
	{
	}

	function uninstall($parent)
	{
		jimport('joomla.filesystem.folder');

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
		 * Löschen der Mitgliederbilder
		 */
		$img_path	= JPATH_ROOT . '/'
			. JComponentHelper::getParams('com_media')->get('image_path', 'images')
			. '/' . $params->get('image_path', 'stories/mitglieder') . '/thumbs/';
		if (JFolder::delete($img_path))
		{
			echo '<p>Thumbnails wurden gel&ouml;scht.</p>';
		}
		else echo '<p>Thumbnails wurden nicht gel&ouml;scht.</p>';

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
		/*
		 * (Re-)Generate Thumbnails
		 */
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName('kurz_text'))
			->from($db->quoteName('#__mitglieder_mitglieder_felder'))
			->leftJoin($db->quoteName('#__mitglieder_felder')." ON "
			.$db->quoteName('felder_id')." = ".$db->quoteName('id'))
			->where($db->quoteName('typ')." = ".$db->quote('bild'));
		$db->setQuery($query);
		$images = $db->loadColumn();

		$params = JComponentHelper::getParams('com_mitglieder');
		$img_width  = $params->get('mitglied_thumb_width',  '180');
		$img_height = $params->get('mitglied_thumb_height', '240');
		$img_path   = $params->get('image_path', 'stories/mitglieder');
		$img_path	= JPATH_ROOT . '/'
			. JComponentHelper::getParams('com_media')->get('image_path', 'images')
			. '/' . $img_path;

		require_once JPATH_ADMINISTRATOR . '/components/com_mitglieder/helpers/image.php';
		foreach ($images as $image)
		{
			$image = JPATH_ROOT . '/' . $image;
			ImageHelper::createThumb($image, $img_width, $img_height, $img_path, true);
		}
	}

	function preflight($type, $parent)
	{
	}

	function postflight($type, $parent)
	{
	}
}
