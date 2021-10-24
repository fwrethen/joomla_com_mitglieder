<?php
defined('_JEXEC') or die();

use Joomla\CMS\MVC\View\HtmlView;

class MitgliederViewMitglieder extends HtmlView
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Mitglieder: Mitglieder' ), 'users' );
		JToolBarHelper::addNew('mitglied.add');
		JToolBarHelper::editList('mitglied.edit');
		JToolBarHelper::deleteList('', 'mitglieder.delete');
		JToolBarHelper::preferences('com_mitglieder');

		if (version_compare(JVERSION, '4', '<')) {
			require_once JPATH_COMPONENT . '/helpers/mitglieder.php';
			MitgliederHelper::addSubmenu('mitglieder');
			$this->sidebar = JHtmlSidebar::render();
		}

		$this->items = $this->get('Items');

		parent::display($tpl);
	}
}
