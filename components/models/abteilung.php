<?php
defined('_JEXEC') or die();

class MitgliederModelAbteilung extends JModelLegacy
{

	function __construct($options = array()) {
		parent::__construct($options);

	}

	function getAbteilungQuery( $id )
	{

		$query = "SELECT * FROM #__mitglieder_abteilungen WHERE id = ".$id;
		return $query;
	}


	function getData($id) {
		$db = JFactory::getDBO();

		$team = $this->getAbteilung($id);

		$team->mitglieder = $this->getMitglieder($id);


		return $team;
	}

	function getAbteilung( $id )
	{
		$db = JFactory::getDBO();
		$db->setQuery( $this->getAbteilungQuery($id) );
		$team = $db->loadObject();

		return $team;

	}




	function getMitglieder( $aid ) {
		$db = JFactory::getDBO();

		$query = "SELECT mitglied.id,mitglied.name,mitglied.vorname from #__mitglieder_mitglieder_abteilungen as abteilung,#__mitglieder_mitglieder as mitglied " .
				 " WHERE mitglied.id= abteilung.mitglieder_id AND abteilungen_id = ".$aid . " order by ordering , name asc, vorname ASC";
		$db->setQuery( $query );
		$spieler = $db->loadObjectList();

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
				->where($db->quoteName('id') . ' = ' . $db->quote($aid));

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
				->where($db->quoteName('id') . ' = ' . $db->quote($aid));

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
