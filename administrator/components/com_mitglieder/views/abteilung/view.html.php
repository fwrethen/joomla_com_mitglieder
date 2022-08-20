<?php
defined('_JEXEC') or die();

use Joomla\CMS\MVC\View\HtmlView;

/**
 * View to edit an abteilung.
 *
 * @since  0.9
 */
class MitgliederViewAbteilung extends HtmlView
{
	protected $form;
	protected $item;

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
		$isNew = ($this->item->id == 0);
		$text = $isNew ? JText::_('Neu') : JText::_('Bearbeiten');

		JToolBarHelper::title(JText::_('Abteilung: ' . $text), 'archive');
		JToolBarHelper::save('abteilung.save');

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('abteilung.cancel');
		}
		else
		{
			JToolbarHelper::cancel('abteilung.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
