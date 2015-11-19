<?php
defined('_JEXEC') or die();

class ListenModelListen extends JModelLegacy
{

	function _buildListenQuery()
	{
		$query = ' SELECT id,name_backend '
			. 	' FROM #__mitglieder_felder where typ = \'liste\' ';

		return $query;
	}


	function getData()
	{
		return $this->_getList( $this->_buildListenQuery() );;
	}

}
?>
