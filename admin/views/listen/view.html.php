<?php
defined('_JEXEC') or die();

class MitgliederViewListen extends JViewLegacy
{
	function display($tpl = null)
	{
		JToolBarHelper::title(JText::_('Mitglieder: Listen'), 'list');
		//JToolBarHelper::addNew();
		JToolBarHelper::editList('liste.edit');
		//JToolBarHelper::deleteList();
		JToolBarHelper::preferences('com_mitglieder');

		require_once JPATH_COMPONENT . '/helpers/mitglieder.php';
		MitgliederHelper::addSubmenu('listen');
		$this->sidebar = JHtmlSidebar::render();

		$this->items = $this->get('Items');

		parent::display($tpl);
	}
}
?>
