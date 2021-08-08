<?php
defined('_JEXEC') or die();

/**
 * @property \Joomla\CMS\Form\Form $form
 */

class MitgliederViewFelder extends JViewLegacy
{
	/**
	 * Display the view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 *
	 * @since   0.9
	 */
	function display($tpl = null)
	{
		$this->form = $this->get('Form');

		$this->addToolbar();

		parent::display($tpl);
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
		JToolBarHelper::title(JText::_('Mitglieder: Felder'), 'grid-2');
		JToolBarHelper::save('felder.save', 'JTOOLBAR_APPLY');
		JToolBarHelper::cancel('felder.cancel', 'JTOOLBAR_CANCEL');
		JToolBarHelper::preferences('com_mitglieder');

		if (version_compare(JVERSION, '4', '<')) {
			require_once JPATH_COMPONENT . '/helpers/mitglieder.php';
			MitgliederHelper::addSubmenu('felder');
			$this->sidebar = JHtmlSidebar::render();
		}
	}
}
