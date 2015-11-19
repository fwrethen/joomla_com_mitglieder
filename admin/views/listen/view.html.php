<?php
defined('_JEXEC') or die();

class ListenViewListen extends JViewLegacy
{
	function display($tpl = null)
	{
		JToolBarHelper::title(JText::_('Mitglieder: Listen'), 'list');
		//JToolBarHelper::addNew();
		JToolBarHelper::editList();
		//JToolBarHelper::deleteList();
		JToolBarHelper::preferences('com_mitglieder');

		require_once JPATH_COMPONENT . '/helpers/mitglieder.php';
		MitgliederHelper::addSubmenu('listen');
		$this->sidebar = JHtmlSidebar::render();

		$items		= $this->get( 'Data');

		$this->items = $items;

		parent::display($tpl);
	}
}
?>
