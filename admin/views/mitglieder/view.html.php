<?php

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class MitgliederViewMitglieder extends JViewLegacy
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Mitglieder: Mitglieder' ), 'users' );
		//JToolBarHelper::publishList();
		//JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList();
		JToolBarHelper::editList();
		JToolBarHelper::addNew();
		JToolBarHelper::preferences('com_mitglieder');

		require_once JPATH_COMPONENT . '/helpers/mitglieder.php';
		MitgliederHelper::addSubmenu('mitglieder');
		$this->sidebar = JHtmlSidebar::render();

		$items		= $this->get( 'Data');

		$this->items = $items;

		parent::display($tpl);
	}
}
?>
