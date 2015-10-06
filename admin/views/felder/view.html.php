<?php

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class FelderViewFelder extends JViewLegacy
{
	function display($tpl = null)
	{
		JToolBarHelper::title(JText::_('Mitglieder: Felder'), 'grid-2');
		JToolBarHelper::save();
		JToolBarHelper::preferences('com_mitglieder');

		require_once JPATH_COMPONENT . '/helpers/mitglieder.php';
		MitgliederHelper::addSubmenu('felder');
		$this->sidebar = JHtmlSidebar::render();

		$this->felder = $this->get('Data');
		$this->typen = $this->get('Typen');

		parent::display($tpl);
	}
}
