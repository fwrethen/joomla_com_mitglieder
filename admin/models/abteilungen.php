<?php
defined('_JEXEC') or die();

class MitgliederModelAbteilungen extends JModelLegacy
{

	function _buildAbteilungenQuery()
	{
		$query = ' SELECT id,name, description '
			. 	' FROM #__mitglieder_abteilungen ';

		return $query;
	}


	function getData()
	{
		return $this->_getList( $this->_buildAbteilungenQuery() );;
	}

}
?>
