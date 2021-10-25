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
			->from($db->qn('#__mitglieder_abteilungen'))
			->where($db->qn('id') .' = '. (int) $id);
		$db->setQuery($query);
		$abteilung = $db->loadObject();

		return $abteilung;
	}

	function getMitglieder( $aid ) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->qn(array('mitglied.id', 'mitglied.name', 'mitglied.vorname')));
		$query->from($db->qn('#__mitglieder_mitglieder_abteilungen', 'abteilung'));
		$query->from($db->qn('#__mitglieder_mitglieder', 'mitglied'));
		$query->where($db->qn('mitglied.id') .' = ' . $db->qn('abteilung.mitglieder_id'));
		$query->where($db->qn('abteilungen_id') .' = '. (int) $aid);
		$query->order($db->qn('ordering') .','. $db->qn('name') .','
			. $db->qn('vorname') .' ASC');
		$db->setQuery($query);
		$mitglieder = $db->loadObjectList();

		return $mitglieder;
	}

	function getThumbData($aid, $spieler){
		$db = JFactory::getDbo();

		foreach($spieler as $id=>$einSpieler) {

			/* Query in SQL:
				SELECT `text` FROM `#__mitglieder_mitglieder_felder`
				WHERE `mitglieder_id` = $einSpieler->id
				AND `felder_id` = (
					SELECT `thumb` FROM `#__mitglieder_abteilungen`
					WHERE `id` = $aid
				);
			*/
			$subQuery = $db->getQuery(true);
			$query    = $db->getQuery(true);

			$subQuery->select($db->qn('thumb'))
				->from($db->qn('#__mitglieder_abteilungen'))
				->where($db->qn('id') . ' = ' . $db->q((int) $aid));

			$query->select($db->qn('text'))
				->from($db->qn('#__mitglieder_mitglieder_felder'))
				->where($db->qn('mitglieder_id') . ' = ' . $db->q($einSpieler->id), 'AND')
				->where($db->qn('felder_id') . ' = (' . $subQuery->__toString() . ')');

			$db->setQuery($query);
			$spieler[$id]->thumb = $db->loadResult();

			/* Retrieve field field for thumb view
				Query as above but different subQuery:
				SELECT `field` FROM `#__mitglieder_abteilungen` WHERE `id` = $aid
			*/
			$subQuery = $db->getQuery(true);
			$query    = $db->getQuery(true);

			$subQuery->select($db->qn('field'))
				->from($db->qn('#__mitglieder_abteilungen'))
				->where($db->qn('id') . ' = ' . $db->q((int) $aid));

			$query->select($db->qn('text'))
				->from($db->qn('#__mitglieder_mitglieder_felder'))
				->where($db->qn('mitglieder_id') . ' = ' . $db->q($einSpieler->id), 'AND')
				->where($db->qn('felder_id') . ' = (' . $subQuery->__toString() . ')');

			$db->setQuery($query);
			$spieler[$id]->text = $db->loadResult();

		}
		return $spieler;
	}
}
?>
