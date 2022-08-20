<?php
defined('_JEXEC') or die();

use Joomla\CMS\MVC\View\HtmlView;

/**
 * View to edit a liste.
 *
 * @since  0.9
 */
class MitgliederViewListe extends HtmlView
{
	/** @var \Joomla\CMS\Form\Form $form */
	protected $form;
	/** @var bool|JObject $item */
	protected $item;
	/** @var string $sidebar */
	protected $sidebar;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 *
	 * @since   0.9
	 */
	public function display($tpl = null)
	{
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');

		$this->addToolbar();

		return parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	protected function addToolbar()
	{
		JToolBarHelper::title(JText::_('Mitglieder: Liste'), 'grid-2');
		JToolBarHelper::save('liste.save', 'JTOOLBAR_APPLY');
		JToolBarHelper::cancel('liste.cancel', 'JTOOLBAR_CANCEL');
		JToolBarHelper::preferences('com_mitglieder');

		if (version_compare(JVERSION, '4', '<')) {
			require_once JPATH_COMPONENT . '/helpers/mitglieder.php';
			MitgliederHelper::addSubmenu('liste');
			$this->sidebar = JHtmlSidebar::render();
		}
	}
}
