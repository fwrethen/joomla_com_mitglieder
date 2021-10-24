<?php
defined('_JEXEC') or die();

use Joomla\CMS\MVC\View\HtmlView;

class MitgliederViewListen extends HtmlView
{
	function display($tpl = null)
	{
		JToolBarHelper::title(JText::_('Mitglieder: Listen'), 'list');
		//JToolBarHelper::addNew();
		JToolBarHelper::editList('liste.edit');
		//JToolBarHelper::deleteList();
		JToolBarHelper::preferences('com_mitglieder');

		if (version_compare(JVERSION, '4', '<')) {
			require_once JPATH_COMPONENT . '/helpers/mitglieder.php';
			MitgliederHelper::addSubmenu('listen');
			$this->sidebar = JHtmlSidebar::render();
		}

		$this->items = $this->get('Items');

		parent::display($tpl);
	}
}
