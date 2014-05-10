<?php

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class FelderViewFelder extends JViewLegacy
{
	function display($tpl = null)
	{
		JToolBarHelper::save();

		$this->felder = $this->get('Data');
		$this->typen = $this->get('Typen');
		
		parent::display($tpl);
	}
}
