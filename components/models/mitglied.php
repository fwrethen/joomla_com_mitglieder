<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\Registry\Registry;

class MitgliederModelMitglied extends BaseDatabaseModel
{
	var $_data = null;

	function getMitglied( $id ) {
		if(!$this->_data) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			$query->select($db->quoteName(array('name', 'vorname')))
				->from($db->quoteName('#__mitglieder_mitglieder'))
				->where($db->quoteName('id') .' = '. (int) $id);
			$db->setQuery($query);
			$this->_data = $db->loadObjectList()[0];	// only first row needed

			$query    = $db->getQuery(true);
			$subQuery = $db->getQuery(true);

			$subQuery->select($db->quoteName(['felder_id', 'text', 'listen_id', 'datum']));
			$subQuery->from($db->quoteName('#__mitglieder_mitglieder_felder', 'f'));
			$subQuery->where($db->quoteName('mitglieder_id') .' = '. (int) $id);

			$query->select($db->quoteName(
				['f1.name_frontend', 'f1.typ', 'text', 'felder_id', 'listen_id', 'datum'],
				['name', 'typ', 'text', 'feld_id', 'wert', 'datum']
			));
			$query->from('('. $subQuery->__toString() .') AS a');
			$query->from($db->quoteName('#__mitglieder_felder', 'f1'));
			$query->where($db->quoteName('a.felder_id') .' = '
				. $db->quoteName('f1.id'), 'AND');
			$query->where($db->quoteName('f1.show') .' = 1');
			$query->order($db->quoteName('f1.ordering') .','. $db->quoteName('f1.id')
				.' ASC');

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
