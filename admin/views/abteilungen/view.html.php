<?php
defined('_JEXEC') or die();

class MitgliederViewAbteilungen extends JViewLegacy
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Mitglieder: Abteilungen' ), 'archive' );
		JToolBarHelper::addNew('abteilung.edit');
		JToolBarHelper::editList('abteilung.edit');
		JToolBarHelper::deleteList('', 'abteilungen.delete');
		JToolBarHelper::preferences('com_mitglieder');

		if (version_compare(JVERSION, '4', '<')) {
			require_once JPATH_COMPONENT . '/helpers/mitglieder.php';
			MitgliederHelper::addSubmenu('abteilungen');
			$this->sidebar = JHtmlSidebar::render();
		}

		$this->items = $this->get('Items');

		parent::display($tpl);
	}
}
