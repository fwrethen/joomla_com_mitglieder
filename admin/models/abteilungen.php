<?php
jimport( 'joomla.application.component.model' );


class AbteilungenModelAbteilungen extends JModelLegacy
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
