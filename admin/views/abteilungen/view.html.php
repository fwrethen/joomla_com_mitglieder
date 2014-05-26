<?php

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class AbteilungenViewAbteilungen extends JViewLegacy
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Abteilungen Manager' ), 'generic.png' );
		//JToolBarHelper::publishList();
		//JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList();
		JToolBarHelper::editList();
		JToolBarHelper::addNew();

		$items		= $this->get( 'Data');

		$this->items = $items;

		parent::display($tpl);
	}
}
?>
