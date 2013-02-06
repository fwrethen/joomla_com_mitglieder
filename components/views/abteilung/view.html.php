<?php
jimport( 'joomla.application.component.view');



class MitgliederViewAbteilung extends JView
{

	function display($tpl = null)
	{
 		$model	  = &$this->getModel();

		$params = &JComponentHelper::getParams( 'com_mitglieder' );
 		$id = JRequest::getInt('abteilungsid', '-1', 'GET');
		if ($id === -1){
			$id = $params->get( 'abteilungsid' );
		}
  		$this->assignRef( 'abteilung', $model->getData($id));
  		$this->assignRef( 'columns', $columns);


		parent::display($tpl);
	}
}