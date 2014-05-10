<?php
jimport( 'joomla.application.component.model' );


class MitgliederModelMitglieder extends JModelLegacy
{

	function _buildMitgliederQuery()
	{
		$query = ' SELECT id,name, vorname '
			. 	' FROM #__mitglieder_mitglieder order by name asc, vorname asc';

		return $query;
	}


	function getData()
	{
		return $this->_getList( $this->_buildMitgliederQuery() );;
	}

}
?>
