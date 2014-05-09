<?php
jimport( 'joomla.application.component.view');


class MitgliederViewMitglied extends JView
{
	function display($tpl = null)
	{
		$id = JRequest::getInt('id', '-1', 'GET');

		$model	  = $this->getModel();
		if ($id === -1){
			$params = JComponentHelper::getParams( 'com_mitglieder' );
			$id = $params->get( 'mitgliederid' ); 
		}

  		$this->assignRef('mitglied'  , $model->getMitglied($id));
		
		parent::display($tpl);
	}
}
