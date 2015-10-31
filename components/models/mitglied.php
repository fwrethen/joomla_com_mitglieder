<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class MitgliederModelMitglied extends JModelLegacy
{
	var $_data = null;
	function __construct($options = array()) {
		parent::__construct($options);

	}

	function getMitglied( $id ) {

		if(!$this->_data) {
			$query = "select name,vorname " .
			"from #__mitglieder_mitglieder where  id = ".$id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
			$query = "select mitglieder_id, f1.name_frontend as name,a.felder_id, f1.typ, kurz_text, `text`, wert, datum " .
		"from (select mitglieder_id, felder_id, kurz_text,`text`, wert, datum " .
		"from #__mitglieder_mitglieder_felder as f LEFT JOIN #__mitglieder_listen as l ".
		"on l.id=f.listen_id ) as a, #__mitglieder_felder as f1 " .
		"where a.felder_id= f1.id AND f1.show = 1 AND mitglieder_id = $id order by f1.ordering, f1.id ASC";
			$this->_db->setQuery( $query );
			$this->_data->felder = $this->_db->loadObjectList();

		}
		return $this->_data;
	}

}
?>
