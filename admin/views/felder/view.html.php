<?php

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class FelderViewFelder extends JView
{
	function display($tpl = null)
	{
		JToolBarHelper::save();

		$this->assignRef('felder', $this->get( 'Data'));
		$this->assignRef('typen', $this->get( 'Typen'));
		
		parent::display($tpl);
	}
}
