<?php

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class MitgliederViewMitglieder extends JViewLegacy
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Mitglieder Manager' ), 'generic.png' );
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
