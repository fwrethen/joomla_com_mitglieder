<?php
defined('_JEXEC') or die();

use Joomla\CMS\MVC\View\HtmlView;

class MitgliederViewMitglieder extends HtmlView
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
		JToolBarHelper::title(JText::_('Mitglieder: Mitglieder'), 'users');
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

		return parent::display($tpl);
	}
}
