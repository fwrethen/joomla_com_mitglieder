<?php
defined('_JEXEC') or die();

use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class MitgliederModelAbteilung extends BaseDatabaseModel
{
	function getData($id, $layout = null) {
		$team = $this->getAbteilung($id);
		$team->mitglieder = $this->getMitglieder($id);

		return $team;
	}

	function getAbteilung( $id )
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
			->from($db->quoteName('#__mitglieder_abteilungen'))
			->where($db->quoteName('id') .' = '. (int) $id);
		$db->setQuery($query);
		$abteilung = $db->loadObject();

		return $abteilung;
	}

	function getMitglieder( $aid ) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('mitglied.id', 'mitglied.name',
			'mitglied.vorname')));
		$query->from($db->quoteName('#__mitglieder_mitglieder_abteilungen',
			'abteilung'));
		$query->from($db->quoteName('#__mitglieder_mitglieder', 'mitglied'));
		$query->where($db->quoteName('mitglied.id') .' = '
			. $db->quoteName('abteilung.mitglieder_id'));
		$query->where($db->quoteName('abteilungen_id') .' = '. (int) $aid);
		$query->order($db->quoteName('ordering') .','. $db->quoteName('name') .','
			. $db->quoteName('vorname') .' ASC');
		$db->setQuery($query);
		$mitglieder = $db->loadObjectList();

		return $mitglieder;
	}

	function getThumbData($aid, $spieler){
		$db = JFactory::getDbo();

		foreach($spieler as $id=>$einSpieler) {

			/* Query in SQL:
				SELECT `kurz_text` FROM `#__mitglieder_mitglieder_felder`
				WHERE `mitglieder_id` = $einSpieler->id
				AND `felder_id` = (
					SELECT `thumb` FROM `#__mitglieder_abteilungen`
					WHERE `id` = $aid
				);
			*/
			$subQuery = $db->getQuery(true);
			$query    = $db->getQuery(true);

			$subQuery->select($db->quoteName('thumb'))
				->from($db->quoteName('#__mitglieder_abteilungen'))
				->where($db->quoteName('id') . ' = ' . $db->quote((int) $aid));

			$query->select($db->quoteName('kurz_text'))
				->from($db->quoteName('#__mitglieder_mitglieder_felder'))
				->where($db->quoteName('mitglieder_id') . ' = '
					. $db->quote($einSpieler->id), 'AND')
				->where($db->quoteName('felder_id') . ' = (' . $subQuery->__toString()
					. ')');

			$db->setQuery($query);
			$spieler[$id]->thumb = $db->loadResult();

			/* Retrieve field field for thumb view
				Query as above but different subQuery:
				SELECT `field` FROM `#__mitglieder_abteilungen` WHERE `id` = $aid
			*/
			$subQuery = $db->getQuery(true);
			$query    = $db->getQuery(true);

			$subQuery->select($db->quoteName('field'))
				->from($db->quoteName('#__mitglieder_abteilungen'))
				->where($db->quoteName('id') . ' = ' . $db->quote((int) $aid));

			$query->select($db->quoteName('text'))
				->from($db->quoteName('#__mitglieder_mitglieder_felder'))
				->where($db->quoteName('mitglieder_id') . ' = '
					. $db->quote($einSpieler->id), 'AND')
				->where($db->quoteName('felder_id') . ' = (' . $subQuery->__toString()
					. ')');

			$db->setQuery($query);
			$spieler[$id]->text = $db->loadResult();

		}
		return $spieler;
	}
}
?>
