<?php
defined('_JEXEC') or die();

class MitgliederViewMitglied extends JViewLegacy
{
	function display($tpl = null)
	{
		$id = JFactory::getApplication()->input->get('id', '-1', 'INT');

		$model	  = $this->getModel();
		if ($id === -1){
			//TODO: show standard view or display error message
		}

  		$this->mitglied = $model->getMitglied($id);

		parent::display($tpl);
	}
}
