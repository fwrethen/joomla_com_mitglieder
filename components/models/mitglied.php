<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\Registry\Registry;

class MitgliederModelMitglied extends BaseDatabaseModel
{
	public $_data = null;

	public function getMitglied($id) {
		if(!$this->_data) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			$query->select($db->qn(['name', 'vorname']))
				->from($db->qn('#__mitglieder_mitglieder'))
				->where($db->qn('id') . ' = ' . (int) $id);
			$db->setQuery($query);
			$this->_data = $db->loadObjectList()[0];	// only first row needed

			$query    = $db->getQuery(true);
			$subQuery = $db->getQuery(true);

			$subQuery->select($db->qn(['felder_id', 'text', 'listen_id', 'datum']));
			$subQuery->from($db->qn('#__mitglieder_mitglieder_felder', 'f'));
			$subQuery->where($db->qn('mitglieder_id') . ' = ' . (int) $id);

			$query->select($db->qn(
			    ['f1.name_frontend', 'f1.typ', 'text', 'felder_id', 'listen_id', 'datum'],
			    ['name', 'typ', 'text', 'feld_id', 'wert', 'datum']
			));
			$query->from('(' . $subQuery->__toString() . ') AS a');
			$query->from($db->qn('#__mitglieder_felder', 'f1'));
			$query->where($db->qn('a.felder_id') . ' = '
				. $db->qn('f1.id'), 'AND');
			$query->where($db->qn('f1.show') . ' = 1');
			$query->order($db->qn('f1.ordering') . ',' . $db->qn('f1.id') . ' ASC');

			$db->setQuery($query);
			$this->_data->felder = $db->loadObjectList();

			/* If field is of type list resolve associated string value */
			foreach ($this->_data->felder as $feld)
			{
				if ($feld->typ == 'liste')
				{
					$query = $db->getQuery(true);
					$query->select($db->qn('values'))
						->from($db->qn('#__mitglieder_listen'))
						->where($db->qn('felder_id') . ' = ' . $db->q($feld->feld_id));
					$db->setQuery($query);
					$result = $db->loadObject();

					if ($result->values)
					{
						// Convert the values field to an array.
						$registry = new Registry($result->values);
						$result->values = $registry->toArray();
						$feld->wert = $result->values[$feld->wert];
					} else {
						$feld->wert = '';
					}
				}
			}
		}

		return $this->_data;
	}

}
?>
