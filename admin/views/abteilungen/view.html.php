<?php

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class AbteilungenViewAbteilungen extends JView
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Abteilungen Manager' ), 'generic.png' );
		//JToolBarHelper::publishList();
		//JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		$items		= & $this->get( 'Data');

		$this->assignRef('items',		$items);


		parent::display($tpl);
	}
}
?>