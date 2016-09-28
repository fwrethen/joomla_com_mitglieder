<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class MitgliederModelMitglied extends JModelLegacy
{
	var $_data = null;
	function __construct($options = array()) {
		parent::__construct($options);

	}

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

			$subQuery->select($db->quoteName(array('felder_id', 'kurz_text', 'text',
				'wert', 'datum')));
			$subQuery->from($db->quoteName('#__mitglieder_mitglieder_felder', 'f'));
			$subQuery->join('LEFT', $db->quoteName('#__mitglieder_listen', 'l')
				.' ON ('. $db->quoteName('l.id') .' = '. $db->quoteName('f.listen_id')
				.')');
			$subQuery->where($db->quoteName('mitglieder_id') .' = '. (int) $id);

			$query->select($db->quoteName(array('f1.name_frontend', 'f1.typ',
				'kurz_text', 'text', 'wert', 'datum'),
				array('name', 'typ', 'kurz_text','text', 'wert', 'datum')));
			$query->from('('. $subQuery->__toString() .') AS a');
			$query->from($db->quoteName('#__mitglieder_felder', 'f1'));
			$query->where($db->quoteName('a.felder_id') .' = '
				. $db->quoteName('f1.id'), 'AND');
			$query->where($db->quoteName('f1.show') .' = 1');
			$query->order($db->quoteName('f1.ordering') .','. $db->quoteName('f1.id')
				.' ASC');

			$db->setQuery($query);
			$this->_data->felder = $db->loadObjectList();
		}
		return $this->_data;
	}

}
?>
