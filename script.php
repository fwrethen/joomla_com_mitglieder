<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Installer\InstallerScript;
use Joomla\Registry\Registry;

class com_MitgliederInstallerScript extends InstallerScript
{
	/**
	 * The component version we are updating from
	 *
	 * @var    string
	 * @since  2.0
	 */
	protected $fromVersion = null;

	/**
	 * @since 2.0
	 */
	public function __construct()
	{
		$this->extension = 'com_mitglieder';
		$this->minimumJoomla = '3.9';
		$this->minimumPhp = '7.4';
	}

	/**
	 * Function to act prior to installation process begins
	 *
	 * @param   string      $action     Which action is happening (install|uninstall|discover_install|update)
	 * @param   JInstallerAdapter  $installer  The class calling this method
	 *
	 * @return  boolean  True on success
	 *
	 * @since   2.0
	 */
	public function preflight($action, $installer)
	{
		// Check for the minimum PHP version before continuing
		if (!empty($this->minimumPhp) && version_compare(PHP_VERSION, $this->minimumPhp, '<'))
		{
			\JLog::add(\JText::sprintf('JLIB_INSTALLER_MINIMUM_PHP', $this->minimumPhp), \JLog::WARNING, 'jerror');

			return false;
		}

		// Check for the minimum Joomla version before continuing
		if (!empty($this->minimumJoomla) && version_compare(JVERSION, $this->minimumJoomla, '<'))
		{
			\JLog::add(\JText::sprintf('JLIB_INSTALLER_MINIMUM_JOOMLA', $this->minimumJoomla), \JLog::WARNING, 'jerror');

			return false;
		}

		if ($action === 'update')
		{
			// Get the version we are updating from
			$manifest = $this->getItemArray('manifest_cache', '#__extensions', 'element', \JFactory::getDbo()->q($this->extension));

			// Check whether we have an old release installed and skip this check when this here is the initial install.
			if (isset($manifest['version']))
			{
				$this->fromVersion = $manifest['version'];

				return true;
			}

			return false;
		}

		return true;
	}

	public function install($parent)
	{
	}

	public function uninstall($parent)
	{
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
		if (Folder::delete($img_path))
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
			$db->setQuery($query);
			$db->execute();
			echo '<p>Datenbankeintr&auml;ge wurden gel&ouml;scht.</p>';
		}
		else echo '<p>Datenbankeintr&auml;ge wurden nicht gel&ouml;scht.</p>';
	}

	public function update($parent)
	{
		if (!empty($this->fromVersion) && version_compare($this->fromVersion, '2.0', 'lt'))
		{
			$this->migration20();
		}

		return true;
	}

	/**
	 * Called after any type of action
	 *
	 * @param   string      $action     Which action is happening (install|uninstall|discover_install|update)
	 * @param   JInstallerAdapter  $installer  The class calling this method
	 *
	 * @return  boolean  True on success
	 *
	 * @since   2.0
	 */
	public function postflight($action, $installer)
	{
		if ($action === 'update' && !empty($this->fromVersion))
		{
			/*
			 * (Re-)Generate Thumbnails
			 */
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select($db->qn('text'))
				->from($db->qn('#__mitglieder_mitglieder_felder'))
				->leftJoin($db->qn('#__mitglieder_felder') . " ON "
					. $db->qn('felder_id') . " = " . $db->qn('id'))
				->where($db->qn('typ') . " = " . $db->q('bild'));
			$db->setQuery($query);
			$images = $db->loadColumn();

			$params = JComponentHelper::getParams('com_mitglieder');
			$img_width  = $params->get('mitglied_thumb_width', '180');
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

		return true;
	}

	/**
	 * Migrate list data to version 2.0 database schema.
	 *
	 * @since 2.0
	 */
	private function migration20()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select($db->qn(array('id', 'liste', 'wert')))
			->from($db->qn('#__mitglieder_listen_v1'));
		$results = $db->setQuery($query)->loadObjectList();

		$data = [];
		foreach ($results as $row)
		{
			if ($row->wert)
				if (array_key_exists($row->liste, $data)) {
					$data[$row->liste][$row->id] = $row->wert;
				} else {
					$data[$row->liste] = [$row->id => $row->wert];
				}
		}

		foreach ($data as $id => $values)
		{
			if ($id <= 0)
			{
				continue;
			}

			$row     = new stdClass();
			$row->id = $id;
			// Convert the values to JSON.
			$registry    = new Registry($values);
			$row->values = (string) $registry;

			JFactory::getDbo()->insertObject('#__mitglieder_listen', $row);
		}
	}
}
