<?php

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class AbteilungenViewAbteilungen extends JViewLegacy
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Mitglieder: Abteilungen' ), 'archive' );
		//JToolBarHelper::publishList();
		//JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList();
		JToolBarHelper::editList();
		JToolBarHelper::addNew();
		JToolBarHelper::preferences('com_mitglieder');

		require_once JPATH_COMPONENT . '/helpers/mitglieder.php';
		MitgliederHelper::addSubmenu('abteilungen');
		$this->sidebar = JHtmlSidebar::render();

		$items		= $this->get( 'Data');

		$this->items = $items;

		parent::display($tpl);
	}
}
?>
