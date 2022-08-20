<?php
defined('_JEXEC') or die();

use Joomla\CMS\MVC\View\HtmlView;

class MitgliederViewListen extends HtmlView
{
	protected $items;
	protected $sidebar;

	/**
	 * @param string $tpl
	 * @return mixed
	 * @since 0.9
	 */
	public function display($tpl = null)
	{
		JToolBarHelper::title(JText::_('Mitglieder: Listen'), 'list');
		JToolBarHelper::editList('liste.edit');
		JToolBarHelper::preferences('com_mitglieder');

		if (version_compare(JVERSION, '4', '<')) {
			require_once JPATH_COMPONENT . '/helpers/mitglieder.php';
			MitgliederHelper::addSubmenu('listen');
			$this->sidebar = JHtmlSidebar::render();
		}

		$this->items = $this->get('Items');

		return parent::display($tpl);
	}
}
