<?php
jimport( 'joomla.application.component.view');



class MitgliederViewAbteilung extends JViewLegacy
{

	function display($tpl = null)
	{
 		$model	  = $this->getModel();

 		$id = JFactory::getApplication()->input->get('abteilungsid', '-1', 'INT');
		if ($id === -1){
			//TODO: show standard view or display error message
		}
  		$this->abteilung = $model->getData($id);

		$this->thumb_size = JComponentHelper::getParams('com_mitglieder')->get(
			'mitglied_thumb_size', '150');
		$this->thumb_placeholder = JComponentHelper::getParams('com_mitglieder')
			->get('mitglied_thumb_placeholder');
		$this->thumb_rows = JComponentHelper::getParams('com_mitglieder')
			->get('thumbview_row_size', '4');

		parent::display($tpl);
	}
}
