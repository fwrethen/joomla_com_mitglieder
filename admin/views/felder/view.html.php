<?php
defined('_JEXEC') or die();

class MitgliederViewFelder extends JViewLegacy
{
	function display($tpl = null)
	{
		JToolBarHelper::title(JText::_('Mitglieder: Felder'), 'grid-2');
		JToolBarHelper::save('felder.save', 'JTOOLBAR_APPLY');
		JToolBarHelper::cancel('felder.cancel', 'JTOOLBAR_CANCEL');
		JToolBarHelper::preferences('com_mitglieder');

		require_once JPATH_COMPONENT . '/helpers/mitglieder.php';
		MitgliederHelper::addSubmenu('felder');
		$this->sidebar = JHtmlSidebar::render();

		$this->felder = $this->get('Items');
		$this->typen = $this->get('Typen');

		parent::display($tpl);
	}
}
