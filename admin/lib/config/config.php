<?php
defined('_JEXEC') or die();
class Config {
	function getConfig($keys=array()) {
		$config = array();
		$query = "SELECT name,value " .
					"FROM #__mitglieder_config ";

		for($i=0; $i < count($keys); $i++) {
			if($i == 0)
				$where = "WHERE name='" . $keys[$i] . "' ";
			else
				$where .= "OR name='" . $keys[$i] . "' ";
		}
		$query .= $where;

		$db = &JFactory::getDBO();
		$db->setQuery( $query );
		$result = $db->loadObjectList();

		//Kein Eintrag gefunden
		if(!is_array($result))
			return $config;

		foreach($result as $row) {
			$config[$row->name] = $row->value;
		}

		return $config;
	}

	function setConfig($key, $value) {
		$db = &JFactory::getDBO();
		$db->setQuery( "UPDATE #__mitglieder_config " .
						" SET value='$value'" .
						" WHERE name='$key'");
		$db->query();

	}
}

?>